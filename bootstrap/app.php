<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Middleware\ForceJsonRequestHeader;
use App\Http\Middleware\CrosMiddleware;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->validateCsrfTokens(
            except: ['stripe/*']
        );
        // Force json for all incoming requests
        $middleware->append(ForceJsonRequestHeader::class);
        $middleware->appendToGroup('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful ::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->append(CrosMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom Rendering
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return $request->expectsJson()
            ? response()->json([
                'success' => false,
                'message' => __('Unauthorized'),
            ], Response::HTTP_UNAUTHORIZED)
            : redirect()->guest(route('login'));
        });
        // Custom Rendering User does not have the right permissions
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            return $request->expectsJson()
            ? response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_FORBIDDEN)
            : abort(Response::HTTP_FORBIDDEN);
        });
    })
    ->create();
