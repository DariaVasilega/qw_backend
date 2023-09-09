<?php

declare(strict_types=1);

namespace App\Services\Http;

class ClientResolver
{
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
        Client\AuthMs $authClient,
        Client\LearningMs $learningClient,
        Client\WorkersMs $workersClient,
    ) {
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

    public function identifyClient(string $string): ?string
    {
        $possibleClients = [];

        preg_match_all(
            '/^('.implode('|', array_keys($this->clients)).')/',
            ltrim($string, '/'),
            $possibleClients,
            PREG_SET_ORDER
        );

        return $possibleClients[0][0] ?? null;
    }
}
