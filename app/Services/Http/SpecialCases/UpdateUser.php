<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

class UpdateUser extends AbstractCase
{
    protected const ENTITY_TYPES = [
        'user',
    ];

    protected const HTTP_METHODS = [
        'put',
    ];

    protected function getRequestBodyConditions(): array
    {
        return [
            'email',
            'password',
        ];
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function resolve(\Illuminate\Http\Request $request): void
    {
        $dataToUpdate = [];

        $request->post('email') ? $dataToUpdate['email'] = $request->post('email') : false;
        $request->post('password') ? $dataToUpdate['password'] = $request->post('password') : false;

        $userId = (int) strpbrk($request->path(), '123456789');
        $workersClient = $this->clientResolver->getClient('user');
        $response = $workersClient->get("/user/$userId", null, $request->headers->all());

        $this->handleCaseErrors($response);

        $oldEmail = $response->object()->data->user->email;

        $authClient = $this->clientResolver->getClient('auth');
        $response = $authClient->get('/users', ['email' => $oldEmail], $request->headers->all());

        $response = $authClient->put(
            "/user/{$response->object()->data?->users[0]?->id}",
            $dataToUpdate,
            $request->headers->all()
        );

        $this->handleCaseErrors($response);

        if (empty($dataToUpdate['email'])) {
            return;
        }

        $this
            ->clientResolver
            ->getClient('score')
            ->post(
                '/score/change-user-email',
                [
                    'old_email' => $oldEmail,
                    'new_email' => $dataToUpdate['email'],
                ],
                $request->headers->all()
            );
    }
}
