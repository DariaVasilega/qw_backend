<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\MicroserviceException;
use App\Http\Controllers\Controller;
use App\Services\Http\ClientResolver;
use App\Services\Http\PermissionManager;
use Symfony\Component\HttpFoundation\Response;

class LastLectionStatistic extends Controller
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
        $path = request()?->path();
        $method = strtolower((string) request()?->method());

        if (! $this->permissionManager->isPermitted($path, $method)) {
            $error = [
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'error' => [
                    'type' => 'UNAUTHENTICATED',
                    'description' => __('messages.error.403', [], request()?->getPreferredLanguage()),
                ],
            ];

            throw new MicroserviceException(json_encode($error, JSON_THROW_ON_ERROR), Response::HTTP_UNAUTHORIZED);
        }

        /** @var \Illuminate\Http\Client\Response $lastLectionResponse */
        $lastLectionResponse = $this->clientResolver
            ->getClientByUrlPath($path)
            ->$method(
                $path,
                request()?->toArray(),
                request()?->headers->all()
            );

        if (! $lastLectionResponse->ok()) {
            throw new MicroserviceException($lastLectionResponse->body(), $lastLectionResponse->status());
        }

        $whereCondition = '?limit=1000';

        $completedUsers = $lastLectionResponse->object()->data->users;

        foreach ($completedUsers as $user) {
            $whereCondition .= "&email[]!=$user->email";
        }

        $userListResponse = $this->clientResolver
            ->getClient('user')
            ->get(
                "/users{$whereCondition}",
                null,
                request()?->headers->all()
            );

        $uncompletedUsers = $userListResponse->object()->data->users;

        $totalUsersCount = count($completedUsers) + count($uncompletedUsers);

        return \response(
            [
                'label' => $lastLectionResponse->object()->data->label,
                'test' => $lastLectionResponse->object()->data->test,
                'users' => $uncompletedUsers,
                'percentage' => count($completedUsers)
                    ? (int) round((count($uncompletedUsers) * 100) / $totalUsersCount)
                    : 0,
            ],
            $lastLectionResponse->status(),
            $lastLectionResponse->headers()
        );
    }
}
