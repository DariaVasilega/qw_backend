<?php

declare(strict_types=1);

namespace App\Services\Http;

class EntityTypeSeeker
{
    private array $entityTypes = [
        'login',
        'logout',
        'auth',
        'role\/[A-z0-9_-]+\/permissions',
        'role',
        'permission',
        'lection',
        'test',
        'question',
        'answer',
        'score',
        'user\/[0-9]+\/roles',
        'user',
        'position',
        'position-histor',
    ];

    public function seek(string $urlPath): string
    {
        $possibleEntityTypes = [];

        preg_match_all(
            '/^('.implode('|', $this->entityTypes).')/',
            ltrim($urlPath, '/'),
            $possibleEntityTypes,
            PREG_SET_ORDER
        );

        if (! isset($possibleEntityTypes[0][0])) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('No such client');
        }

        return $possibleEntityTypes[0][0];
    }
}
