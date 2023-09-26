<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Http\PermissionManager;

class Index extends Controller
{
    private PermissionManager $permissionManager;

    public function __construct(
        PermissionManager $permissionManager
    ) {
        $this->permissionManager = $permissionManager;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return session('token') && $this->permissionManager->hasPermission(Login::PERMISSION)
            ? view('admin_dashboard', ['permissions' => $this->permissionManager->getPermissions()])
            : view('login');
    }
}
