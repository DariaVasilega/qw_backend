<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Http\ClientResolver;
use App\Services\Http\PermissionManager;
use App\Services\Http\SpecialCaseManager;
use Illuminate\Http\Client\HttpClientException;
use Symfony\Component\HttpFoundation\Response;

class Proxy extends Controller
{
    private ClientResolver $clientResolver;

    private PermissionManager $permissionManager;

    private SpecialCaseManager $specialCaseManager;

    public function __construct(
        ClientResolver $clientResolver,
        PermissionManager $permissionManager,
        SpecialCaseManager $specialCaseManager
    ) {
        $this->clientResolver = $clientResolver;
        $this->permissionManager = $permissionManager;
        $this->specialCaseManager = $specialCaseManager;
    }

    /**
     * @throws \Illuminate\Http\Client\HttpClientException
     */
    public function index(string $path): \Illuminate\Http\Response
    {
        $method = strtolower((string) request()?->method());

        try {
            if (! $this->permissionManager->isPermitted($path, $method)) {
                throw new HttpClientException('', Response::HTTP_UNAUTHORIZED);
            }
        } catch (HttpClientException $exception) {
            if ($exception->getCode() === Response::HTTP_UNAUTHORIZED) {
                return \response('nada avtorizovatsa'); // TODO
            }

            throw $exception;
        }

        $this->specialCaseManager->resolveCases(request());

        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->clientResolver
            ->getClientByUrlPath($path)
            ->$method(
                $path,
                request()?->toArray(),
                request()?->headers->all()
            );

        $this->specialCaseManager->resolveCases(request(), 'after', $response);

        return \response($response->json(), $response->status(), $response->headers());
    }
}
