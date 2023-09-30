<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Http\PermissionManager;

class Page
{
    private const PERMISSIONS = [
        'users' => 'user_read',
        'user' => 'user_read',
    ];

    private PermissionManager $permissionManager;

    public function __construct(
        PermissionManager $permissionManager
    ) {
        $this->permissionManager = $permissionManager;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function render($view): \Illuminate\Contracts\View\View|\Illuminate\Http\Response
    {
        $parameters = [
            'permissions' => $this->permissionManager->getPermissions(),
            'page' => request()?->get('page') ?? 1,
            'id' => request()?->get('id'),
            'disabled' => request()?->get('disabled') ? 'disabled="true"' : '',
        ];

        return request()?->hasHeader('hx-request')
            && session()->has('token')
            && (
                ! isset(self::PERMISSIONS[$view])
                    || $this->permissionManager->hasPermission(self::PERMISSIONS[$view])
            )
                ? view("admin_dashboard.pages.{$view}", $parameters)
                : response(view('errors.404'), 404);
    }
}
