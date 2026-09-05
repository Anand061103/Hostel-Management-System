<?php

use App\Helpers\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
   ->withExceptions(function (Exceptions $exceptions): void {

    // Validation Error - 422
    $exceptions->render(function (
        ValidationException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return ApiResponse::error(
                'Validation failed',
                $e->errors(),
                422
            );
        }
    });

    // Model Not Found - 404
    $exceptions->render(function (
        ModelNotFoundException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return ApiResponse::error(
                'Resource not found',
                null,
                404
            );
        }
    });

    // Route Not Found - 404
    $exceptions->render(function (
        NotFoundHttpException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return ApiResponse::error(
                'API endpoint not found',
                null,
                404
            );
        }
    });

    // Method Not Allowed - 405
    $exceptions->render(function (
        MethodNotAllowedHttpException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return ApiResponse::error(
                'HTTP method not allowed',
                null,
                405
            );
        }
    });

    // Authentication Error - 401
    $exceptions->render(function (
        AuthenticationException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return ApiResponse::error(
                'Unauthenticated',
                null,
                401
            );
        }
    });

    // Authorization Error - 403
    $exceptions->render(function (
        AuthorizationException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return ApiResponse::error(
                'You are not authorized to perform this action',
                null,
                403
            );
        }
    });
})->create();
