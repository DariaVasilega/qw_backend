<?php

declare(strict_types=1);

namespace App\Services\Http\SpecialCases;

class AddPositionToUser extends AbstractCase
{
    protected const ENTITY_TYPES = [
        'user',
    ];

    protected const HTTP_METHODS = [
        'post',
        'put',
    ];

    protected function getRequestBodyConditions(): array
    {
        return [
            'changed' => static fn ($changed) => $changed === null || is_string($changed),
            'position',
            'salary',
        ];
    }

    public function resolve(\Illuminate\Http\Request $request): void
    {
        $workersClient = $this->clientResolver->getClient('position');
        $response = $workersClient->get('/users', ['email' => $request->get('email')], $request->headers->all());

        $userId = $response->object()->data->users[0]->id;

        $response = $workersClient->post(
            '/position-history',
            [
                'user_id' => $userId,
                'salary' => (float) $request->get('salary'),
                'position_code' => $request->get('position'),
                'from_date' => date('Y-m-d'),
            ],
            $request->headers->all()
        );

        $workersClient->put(
            "/user/$userId",
            ['current_position_id' => $response->object()->data->history->id],
            $request->headers->all()
        );
    }
}
