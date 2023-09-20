<?php

declare(strict_types=1);

namespace App\Services\Http;

class EntityTypeSeeker
{
    private array $entityTypes = [
        'login',
        'logout',
        'auth',
        'role',
        'permission',
        'lection',
        'test',
        'question',
        'answer',
        'score',
        'user',
        'position',
        'position-histor',
    ];

    public function seek(string $urlPath): ?string
    {
        $possibleEntityTypes = [];

        preg_match_all(
            '/^('.implode('|', $this->entityTypes).')/',
            ltrim($urlPath, '/'),
            $possibleEntityTypes,
            PREG_SET_ORDER
        );

        return $possibleEntityTypes[0][0] ?? null;
    }
}
