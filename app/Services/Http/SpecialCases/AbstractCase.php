<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

use App\Services\Http\ClientResolver;

abstract class AbstractCase
{
    protected const ENTITY_TYPES = [];

    protected const HTTP_METHODS = [];

    protected ClientResolver $clientResolver;

    public function __construct(ClientResolver $clientResolver)
    {
        $this->clientResolver = $clientResolver;
    }

    abstract public function resolve(\Illuminate\Http\Request $request): void;

    public function getConditions(): array
    {
        return [
            'entity_types' => static::ENTITY_TYPES,
            'http_methods' => static::HTTP_METHODS,
            'request_body' => $this->getRequestBodyConditions(),
        ];
    }

    protected function getRequestBodyConditions(): array
    {
        return [];
    }

    /**
     * @throws \App\Exceptions\MicroserviceException
     */
    protected function handleCaseErrors(\Illuminate\Http\Client\Response $response): void
    {
        if ($response->status() !== \Symfony\Component\HttpFoundation\Response::HTTP_OK) {
            throw new \App\Exceptions\MicroserviceException(
                $response->body(),
                $response->status()
            );
        }
    }
}
