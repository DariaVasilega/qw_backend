<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Http\MicroserviceUserManager;
use App\Services\Http\PermissionManager;

class Page
{
    private const PERMISSIONS = [
        'users' => 'user_read',
        'user' => 'user_read',
        'roles' => 'role_read',
        'role' => 'role_read',
        'history' => 'position_history_read',
        'lections' => 'lection_read',
        'lection' => 'lection_read',
        'permissions' => 'permission_read',
        'permission' => 'permission_read',
        'positions' => 'position_read',
        'position' => 'position_read',
        'questions' => 'question_read',
        'question' => 'question_read',
        'tests' => 'test_read',
        'test' => 'test_read',
    ];

    private PermissionManager $permissionManager;

    private MicroserviceUserManager $userManager;

    public function __construct(
        PermissionManager $permissionManager,
        MicroserviceUserManager $userManager,
    ) {
        $this->permissionManager = $permissionManager;
        $this->userManager = $userManager;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function render($view): \Illuminate\Contracts\View\View|\Illuminate\Http\Response
    {
        $parameters = [
            'userManager' => $this->userManager,
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
