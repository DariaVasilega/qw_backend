<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

class AddPermissionsToRole extends AbstractCase
{
    protected const ENTITY_TYPES = [
        'role',
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
        $response = $authClient->post(
            "role/{$request->get('code')}/permissions",
            [
                'codes' => $request->get('codes'),
            ],
            $request->headers->all()
        );

        $this->handleCaseErrors($response);
    }
}
