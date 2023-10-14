<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\MicroserviceException;
use App\Http\Controllers\Controller;
use App\Services\Http\ClientResolver;
use App\Services\Http\PermissionManager;
use Symfony\Component\HttpFoundation\Response;

class MostPerspectiveUsersStatistic extends Controller
{
    private ClientResolver $clientResolver;

    private PermissionManager $permissionManager;

    public function __construct(
        ClientResolver $clientResolver,
        PermissionManager $permissionManager
    ) {
        $this->clientResolver = $clientResolver;
        $this->permissionManager = $permissionManager;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     * @throws \JsonException
     */
    public function get(): \Illuminate\Http\Response
    {
        $method = strtolower((string) request()?->method());

        if (! $this->permissionManager->isPermitted(request()?->path(), $method)) {
            $error = [
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'error' => [
                    'type' => 'UNAUTHENTICATED',
                    'description' => __('messages.error.403', [], request()?->getPreferredLanguage()),
                ],
            ];

            throw new MicroserviceException(json_encode($error, JSON_THROW_ON_ERROR), Response::HTTP_UNAUTHORIZED);
        }

        /** @var \Illuminate\Http\Client\Response $scoresResponse */
        $scoresResponse = $this->clientResolver
            ->getClient('score')
            ->$method(
                '/scores',
                [
                    'columns' => 'email,points',
                    'limit' => 999999999,
                ],
                request()?->headers->all()
            );

        if (! $scoresResponse->ok()) {
            throw new MicroserviceException($scoresResponse->body(), $scoresResponse->status());
        }

        $mostPerspectiveUsers = [];

        foreach ($scoresResponse->object()->data->scores as $score) {
            $mostPerspectiveUsers[$score->email] = isset($mostPerspectiveUsers[$score->email])
                ? ($mostPerspectiveUsers[$score->email] + (float) $score->points)
                : $score->points;
        }

        arsort($mostPerspectiveUsers);

        $top = array_slice($mostPerspectiveUsers, 0, 10);

        /** @var \Illuminate\Http\Client\Response $usersResponse */
        $usersResponse = $this->clientResolver
            ->getClient('user')
            ->$method(
                '/users',
                ['email[]' => implode('&email[]=', array_keys($top))],
                request()?->headers->all()
            );

        if (! $usersResponse->ok()) {
            throw new MicroserviceException($usersResponse->body(), $usersResponse->status());
        }

        $users = $usersResponse->object()->data->users;

        array_walk(
            $users,
            static fn (&$user) => $user->scores = $mostPerspectiveUsers[$user->email] ?? 0
        );

        usort($users, static fn ($currentUser, $nextUser) => $nextUser->scores <=> $currentUser->scores);

        return \response(['users' => $users], $usersResponse->status());
    }
}
