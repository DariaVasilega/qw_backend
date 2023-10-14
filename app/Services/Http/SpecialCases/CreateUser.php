<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

class CreateUser extends AbstractCase
{
    protected const ENTITY_TYPES = [
        'user',
    ];

    protected const HTTP_METHODS = [
        'post',
    ];

    protected function getRequestBodyConditions(): array
    {
        return [
            'email' => static fn ($email) => $email === null || is_string($email),
            'password' => static fn ($password) => $password === null || is_string($password),
        ];
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function resolve(\Illuminate\Http\Request $request): void
    {
        $authClient = $this->clientResolver->getClient('auth');
        $response = $authClient->post(
            '/user',
            [
                'email' => $request->post('email'),
                'password' => $request->post('password'),
            ],
            $request->headers->all()
        );

        try {
            $this->handleCaseErrors($response);
        } catch (\App\Exceptions\MicroserviceException $exception) {
            $workersClient = $this->clientResolver->getClient('user');
            $response = $workersClient->get(
                '/users',
                ['email' => $request->post('email')],
                $request->headers->all()
            );
            $workersClient->delete("/user/{$response->object()->data?->users[0]?->id}");

            throw $exception;
        }
    }
}
