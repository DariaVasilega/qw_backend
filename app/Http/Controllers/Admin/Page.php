<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Http\PermissionManager;

class Page
{
    private const PERMISSIONS = [
        // TODO permissions
    ];

    private PermissionManager $permissionManager;

    public function __construct(
        PermissionManager $permissionManager
    ) {
        $this->permissionManager = $permissionManager;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function render($view): \Illuminate\Contracts\View\View|\Illuminate\Http\Response
    {
        return request()?->hasHeader('hx-request')
            && session()->has('token')
            && (
                ! isset(self::PERMISSIONS[$view])
                    || $this->permissionManager->hasPermission(self::PERMISSIONS[$view])
            )
                ? view("admin_dashboard.pages.{$view}", ['permissions' => $this->permissionManager->getPermissions()])
                : response(view('errors.404'), 404);
    }
}
