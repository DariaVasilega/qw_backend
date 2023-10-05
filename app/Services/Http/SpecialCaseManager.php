<?php

declare(strict_types=1);

namespace App\Services\Http;

use App\Services\Http\SpecialCases\AddPermissionsToRole;
use App\Services\Http\SpecialCases\AddPositionToUser;
use App\Services\Http\SpecialCases\AddRolesToUser;
use App\Services\Http\SpecialCases\CreateUser;
use App\Services\Http\SpecialCases\DeleteUser;
use App\Services\Http\SpecialCases\UpdateUser;

class SpecialCaseManager
{
    /**
     * @var \App\Services\Http\SpecialCases\AbstractCase[]
     */
    protected array $before = [
        'deleteUser',
        'updateUser',
    ];

    /**
     * @var \App\Services\Http\SpecialCases\AbstractCase[]
     */
    protected array $after = [
        'createUser',
        'addRolesToUser',
        'addPermissionsToRole',
        'addPositionToUser',
    ];

    private EntityTypeSeeker $entityTypeSeeker;

    private CreateUser $createUser;

    private DeleteUser $deleteUser;

    private UpdateUser $updateUser;

    private AddRolesToUser $addRolesToUser;

    private AddPermissionsToRole $addPermissionsToRole;

    private AddPositionToUser $addPositionToUser;

    public function __construct(
        EntityTypeSeeker $entityTypeSeeker,
        CreateUser $createUser,
        DeleteUser $deleteUser,
        UpdateUser $updateUser,
        AddRolesToUser $addRolesToUser,
        AddPermissionsToRole $addPermissionsToRole,
        AddPositionToUser $addPositionToUser,
    ) {
        $this->entityTypeSeeker = $entityTypeSeeker;
        $this->createUser = $createUser;
        $this->deleteUser = $deleteUser;
        $this->updateUser = $updateUser;
        $this->addRolesToUser = $addRolesToUser;
        $this->addPermissionsToRole = $addPermissionsToRole;
        $this->addPositionToUser = $addPositionToUser;
    }

    public function resolveCases(
        \Illuminate\Http\Request $request,
        $when = 'before',
        \Illuminate\Http\Client\Response $response = null
    ): void {
        if ($response !== null && $response->status() !== \Symfony\Component\HttpFoundation\Response::HTTP_OK) {
            return;
        }

        array_walk(
            $this->{$when},
            fn ($case) => $this->shouldResolve($this->{$case}, $request) && $this->{$case}->resolve($request)
        );
    }

    protected function shouldResolve(
        SpecialCases\AbstractCase $case,
        \Illuminate\Http\Request $request
    ): bool {
        $conditions = $case->getConditions();

        $isHttpMethodSuitable = in_array(
            strtolower($request->method()),
            array_map('strtolower', $conditions['http_methods']),
            true
        );

        $isEntityTypeSuitable = $isHttpMethodSuitable && in_array(
            $this->entityTypeSeeker->seek($request->path()),
            $conditions['entity_types'],
            true
        );

        return $isEntityTypeSuitable
            && $this->isRequestBodySuitable($conditions['request_body'], $request->all());
    }

    private function isRequestBodySuitable(array $conditions, array $requestBody): bool
    {
        $isSuitable = empty($conditions);

        foreach ($conditions as $fieldName => $condition) {
            $firstCondition = is_numeric($fieldName) && ! empty($requestBody[$condition]);
            $secondCondition = is_string($fieldName)
                && (is_string($condition) || is_callable($condition))
                && ! empty($requestBody[$fieldName])
                && $condition($requestBody[$fieldName]);

            if (! $firstCondition && ! $secondCondition) {
                return false;
            }

            $isSuitable = true;
        }

        return $isSuitable;
    }
}
