<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

class AddRolesToUser extends AbstractCase
{
    protected const ENTITY_TYPES = [
        'user',
    ];

    protected const HTTP_METHODS = [
        'post',
        'put',
    ];

    protected function getRequestBodyConditions(): array
    {
        return [
            'codes' => static fn ($codes) => ! empty($codes),
        ];
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function resolve(\Illuminate\Http\Request $request): void
    {
        $authClient = $this->clientResolver->getClient('auth');
        $response = $authClient->get('/users', ['email' => $request->get('email')], $request->headers->all());
        $response = $authClient->post(
            "user/{$response?->object()?->data?->users[0]?->id}/roles",
            [
                'codes' => $request->get('codes'),
            ],
            $request->headers->all()
        );

        $this->handleCaseErrors($response);
    }
}
