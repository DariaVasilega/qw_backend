<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function register(): void
    {
        $this->renderable(function (MicroserviceException $exception) {
            return response()->json(
                json_decode($exception->getMessage(), true, 512, JSON_THROW_ON_ERROR),
                $exception->getCode()
            );
        });

        $this->reportable(function (\Throwable $e) {
            //
        });
    }
}
