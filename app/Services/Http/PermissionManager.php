<?php

declare(strict_types=1);

namespace App\Services\Http;

class PermissionManager
{
    private const EXCLUDED_ROUTES = [
        'auth',
        'login',
        'logout',
    ];

    private const HTTP_ACTION_TO_METHOD_MAPPING = [
        'post' => 'create',
        'get' => 'read',
        'put' => 'update',
        'delete' => 'delete',
    ];

    private \Illuminate\Support\Facades\Session $session;

    private ClientResolver $clientResolver;

    private \Illuminate\Http\Request $request;

    public function __construct(
        \Illuminate\Support\Facades\Session $session,
        ClientResolver $clientResolver,
        \Illuminate\Http\Request $request
    ) {
        $this->session = $session;
        $this->clientResolver = $clientResolver;
        $this->request = $request;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function isPermitted(string $route, string $httpMethod): bool
    {
        $entityType = $this->clientResolver->getClientEntityTypeByUrlPath($route);

        if (in_array($entityType, self::EXCLUDED_ROUTES, true)) {
            return true;
        }

        $crudAction = $this->getCrudActionFromHttpMethod($httpMethod);

        return $this->hasPermission("{$entityType}_{$crudAction}");
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = $this->getPermissions();

        return in_array($permission, $permissions, true);
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function getPermissions(): array
    {
        $this->askPermissions();

        return $this->session::get('permissions', []);
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    private function askPermissions(): void
    {
        if ($this->session::get('permissions') !== null) {
            return;
        }

        $response = $this->clientResolver
            ->getClientByUrlPath('/auth')
            ->get(
                '/auth',
                null,
                $this->request->headers->all()
            );

        if ($response->status() !== \Symfony\Component\HttpFoundation\Response::HTTP_OK) {
            throw new \App\Exceptions\MicroserviceException(
                $response->body(),
                $response->status()
            );
        }

        $this->session::put('permissions', $response->object()->data->permissions);
    }

    private function getCrudActionFromHttpMethod(string $httpMethod): string
    {
        return self::HTTP_ACTION_TO_METHOD_MAPPING[$httpMethod] ?? 'read';
    }
}
