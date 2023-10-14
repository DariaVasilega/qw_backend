<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\MicroserviceException;
use App\Http\Controllers\Controller;
use App\Services\Http\ClientResolver;
use App\Services\Http\PermissionManager;
use Symfony\Component\HttpFoundation\Response;

class Scores extends Controller
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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
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

        $page = request()?->get('page') ?? 1;

        /** @var \Illuminate\Http\Client\Response $scoresResponse */
        $scoresResponse = $this->clientResolver
            ->getClient('score')
            ->$method(
                '/scores',
                [
                    'page' => $page,
                    'includes' => 'test,question,answer',
                ],
                request()?->headers->all()
            );

        if (! $scoresResponse->ok()) {
            throw new MicroserviceException($scoresResponse->body(), $scoresResponse->status());
        }

        $scores = $scoresResponse->object()->data->scores;

        if (! count($scores)) {
            return \response(['data' => ['scores' => []]]);
        }

        $emails = array_map(static fn (\stdClass $score): string => $score->email, $scores);

        $users = $this->clientResolver
            ->getClient('user')
            ->$method(
                '/users',
                ['email[]' => implode('&email[]=', array_unique($emails))],
                request()?->headers->all()
            )
            ->object()
            ->data
            ->users;

        if (! count($users)) {
            return \response(['data' => ['scores' => []]]);
        }

        array_walk(
            $scores,
            fn (\stdClass $score) => $score->user = $this->pickUserByEmail($users, $score->email)
        );

        $data = $scoresResponse->object()->data;
        $data->scores = $scores;

        return \response(['data' => $data], $scoresResponse->status());
    }

    private function pickUserByEmail(array $users, string $email): \stdClass
    {
        return current(array_filter($users, static fn (\stdClass $user): bool => $user->email === $email));
    }
}
