<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\MicroserviceException;
use App\Services\Http\ClientResolver;
use App\Services\Http\PermissionManager;
use App\Services\Http\SpecialCaseManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @throws MicroserviceException
     * @throws \JsonException
     */
    public function index(string $path = ''): \Illuminate\Http\Response|\Illuminate\Contracts\View\View
    {
        $method = strtolower((string) request()?->method());

        if (! $this->permissionManager->isPermitted($path, $method)) {
            $error = [
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'error' => [
                    'type' => 'UNAUTHENTICATED',
                    'description' => __('messages.error.403', [], request()?->getPreferredLanguage()),
                ],
            ];

            throw new MicroserviceException(json_encode($error, JSON_THROW_ON_ERROR), Response::HTTP_UNAUTHORIZED);
        }

        $this->specialCaseManager->resolveCases(request());

        try {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = $this->clientResolver
                ->getClientByUrlPath($path)
                ->$method(
                    $path,
                    request()?->toArray(),
                    request()?->headers->all()
                );
        } catch (NotFoundHttpException $exception) {
            return view('errors.404');
        }


        $this->specialCaseManager->resolveCases(request(), 'after', $response);

        return \response($response->json(), $response->status(), $response->headers());
    }
}
