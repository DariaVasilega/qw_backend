<?php

declare(strict_types=1);

namespace App\Services\Http;

class MicroserviceUserManager
{
    private ClientResolver $clientResolver;

    public function __construct(
        ClientResolver $clientResolver
    ) {
        $this->clientResolver = $clientResolver;
    }

    public function getAuthMicroserviceUserIdByNativeUserId(int $userId): int
    {
        return $this->clientResolver
            ->getClient('auth')
            ->get(
                'users',
                [
                    'email' => $this
                        ->clientResolver
                        ->getClient('user')
                        ->get("user/$userId")
                        ->object()
                        ->data
                        ->user
                        ->email,
                ]
            )
            ->object()
            ->data
            ->users[0]
            ->id;
    }
}
