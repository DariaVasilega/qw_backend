<?php

declare(strict_types=1);

namespace App\Services\Http;

class ClientResolver
{
    private EntityTypeSeeker $entityTypeSeeker;

    private \App\Services\Http\Client\AuthMs $authClient;

    private \App\Services\Http\Client\LearningMs $learningClient;

    private \App\Services\Http\Client\WorkersMs $workersClient;

    /**
     * @var array|string[]
     */
    private array $clients = [
        'login' => 'authClient',
        'logout' => 'authClient',
        'auth' => 'authClient',
        'role' => 'authClient',
        'permission' => 'authClient',
        'lection' => 'learningClient',
        'test' => 'learningClient',
        'question' => 'learningClient',
        'answer' => 'learningClient',
        'score' => 'learningClient',
        'user' => 'workersClient',
        'position' => 'workersClient',
        'position-histor' => 'workersClient',
    ];

    public function __construct(
        EntityTypeSeeker $entityTypeSeeker,
        Client\AuthMs $authClient,
        Client\LearningMs $learningClient,
        Client\WorkersMs $workersClient,
    ) {
        $this->entityTypeSeeker = $entityTypeSeeker;
        $this->authClient = $authClient;
        $this->learningClient = $learningClient;
        $this->workersClient = $workersClient;
    }

    public function getClient(string $entityType): Client\AbstractMs
    {
        if (! isset($this->clients[$entityType])) {
            throw new \DomainException('No such client');
        }

        return $this->{$this->clients[$entityType]};
    }

    public function getClientByUrlPath(string $urlPath): Client\AbstractMs
    {
        return $this->getClient($this->entityTypeSeeker->seek($urlPath));
    }

    public function getClientEntityTypeByUrlPath(string $urlPath): string
    {
        return $this->entityTypeSeeker->seek($urlPath);
    }
}
