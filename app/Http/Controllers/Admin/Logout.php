<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Http\ClientResolver;

class Logout
{
    private ClientResolver $clientResolver;

    public function __construct(
        ClientResolver $clientResolver,
    ) {
        $this->clientResolver = $clientResolver;
    }

    public function action(): \Illuminate\Http\RedirectResponse
    {
        $this->clientResolver->getClient('auth')->post('/logout', [], request()->headers->all());
        session()->flush();

        return response()->redirectTo('/admin');
    }
}
