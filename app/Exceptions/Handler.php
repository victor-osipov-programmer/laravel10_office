<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->renderable(function (ValidationException $e) {
            return response([
                'error' => [
                    'code' => 400,
                    'message' => 'Validation error',
                    'errors' => $e->errors(),
                ]
            ], 400);
        });
        $this->renderable(function (AuthenticationException $e) {
            return response([
                'error' => [
                    'code' => 401,
                    'message' => 'Токен отсутствует или недействителен',
                ]
            ], 401);
        });
        $this->renderable(function (NotFoundHttpException $e) {
            return response([
                'error' => [
                    'code' => 404,
                    'message' => 'Not Found',
                ]
            ], 404);
        });
    }
}
