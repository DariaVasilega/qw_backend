<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Http\ClientResolver;
use App\Services\Http\PermissionManager;

class Login extends Controller
{
    public const PERMISSION = 'admin_dashboard';

    private ClientResolver $clientResolver;

    private PermissionManager $permissionManager;

    public function __construct(
        ClientResolver $clientResolver,
        PermissionManager $permissionManager
    ) {
        $this->clientResolver = $clientResolver;
        $this->permissionManager = $permissionManager;
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    public function action(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $response = $this
            ->clientResolver
            ->getClient('auth')
            ->post(
                'login',
                request()?->all(['email', 'password']),
                request()?->headers->all()
            );

        return $response->ok()
            ? $this->handleSuccessLogin($response)
            : view('login', ['error' => $response->object()->error->description]);
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    private function handleSuccessLogin(
        \Illuminate\Http\Client\Response $response
    ): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse {
        session()->flush();
        session(['token' => $response->object()->data->token]);

        return $this->permissionManager->hasPermission(static::PERMISSION)
            ? response()->redirectTo('/admin#statistics')
            : view('login', ['error' => __('messages.error.403', [], request()?->getPreferredLanguage())]);
    }
}
