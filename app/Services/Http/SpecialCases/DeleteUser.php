<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

class DeleteUser extends AbstractCase
{
    protected const ENTITY_TYPES = [
        'user',
    ];

    protected const HTTP_METHODS = [
        'delete',
    ];

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function resolve(\Illuminate\Http\Request $request): void
    {
        $workerId = $this->getUserIdFromRequestPath($request->path());

        if (! $workerId) {
            return;
        }

        $workersClient = $this->clientResolver->getClient('user');
        $response = $workersClient->get("/user/$workerId", null, $request->headers->all());

        $this->handleCaseErrors($response);

        $email = $response->object()->data->user->email;

        $authClient = $this->clientResolver->getClient('auth');
        $authUsersData = $authClient->get("/users?email=$email", null, $request->headers->all())
            ?->object()
            ?->data
            ?->users;

        if (!empty($authUsersData[0])) {
            $authUserId = $authUsersData[0]?->id;
            $authClient->delete("/user/$authUserId", [], $request->headers->all());
        }

        $learningClient = $this->clientResolver->getClient('score');
        $learningClient->post('/score/delete-by-user-email', ['email' => $email], $request->headers->all());
    }

    private function getUserIdFromRequestPath(string $requestPath): int|bool
    {
        return preg_match('/user\/(.*?)(\/|$)/', $requestPath, $match) === 1 ? (int) $match[1] : false;
    }
}
