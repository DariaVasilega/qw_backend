<?php

declare(strict_types=1);

namespace App\Services\Http\Client;

use Illuminate\Http\Client\Response;

/**
 * @method Response get(string $url, array|null|string $query = null, array $headers = [])
 * @method Response head(string $url, array|null|string $query = null, array $headers = [])
 * @method Response post(string $url, array $data = [], array $headers = [])
 * @method Response patch(string $url, array $data = [], array $headers = [])
 * @method Response put(string $url, array $data = [], array $headers = [])
 * @method Response delete(string $url, array $data = [], array $headers = [])
 */
abstract class AbstractMs
{
    protected const HOST = '';

    private const HEADERS_TO_REPLACE = [
        'content-type' => [
            'application/json',
        ],
    ];

    private const HEADERS_TO_REMOVE = [
        'accept',
        'content-length',
    ];

    private const METHODS = [
        'get',
        'head',
        'post',
        'patch',
        'put',
        'delete',
    ];

    private \Illuminate\Support\Facades\Http $client;

    public function __construct(
        \Illuminate\Support\Facades\Http $client
    ) {
        $this->client = $client;
    }

    public function __call(string $method, array $arguments): Response
    {
        if (! in_array($method, self::METHODS, true)) {
            return $this->client::$method($arguments);
        }

        $arguments[0] = "https://{$this->prepareUrl(static::HOST)}/{$this->prepareUrl($arguments[0])}";

        return ! empty($arguments[2])
            ? $this->client::withHeaders($this->prepareHeaders($arguments[2]))->$method(...$arguments)
            : $this->client::$method(...$arguments);
    }

    private function prepareUrl(string $url): string
    {
        return str_replace(['http://', 'https://'], '', rtrim(ltrim($url, '/'), '/'));
    }

    private function prepareHeaders(array $headers): array
    {
        foreach (self::HEADERS_TO_REMOVE as $headerToRemove) {
            unset($headers[$headerToRemove]);
        }

        return array_replace_recursive($headers, self::HEADERS_TO_REPLACE);
    }
}
