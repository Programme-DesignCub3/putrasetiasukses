<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use NielsNumbers\LaravelLocalizer\Middleware\RedirectLocale;
use NielsNumbers\LaravelLocalizer\Middleware\SetLocale;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$resolveSite = function (): array {
    try {
        return safe_db_config('website.site', []);
    } catch (Throwable) {
        return [];
    }
};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(remove: [
            SubstituteBindings::class,
        ]);

        $middleware->web(append: [
            SetLocale::class,
            RedirectLocale::class,
            SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) use ($resolveSite): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) use ($resolveSite) {
            if ($request->expectsJson() || $request->is('admin/*')) {
                return;
            }

            $site = $resolveSite();

            return response()->view('errors.404', [
                'site' => $site,
                'activeSection' => null,
                'bodyClass' => 'bg-white',
            ], 404);
        });

        $exceptions->render(function (HttpException $e, Request $request) use ($resolveSite) {
            $statusCode = $e->getStatusCode();

            if ($request->expectsJson() || $request->is('admin/*')) {
                return;
            }

            if (! in_array($statusCode, [403, 500], true)) {
                return;
            }

            $site = $resolveSite();

            return response()->view("errors.{$statusCode}", [
                'site' => $site,
                'activeSection' => null,
                'bodyClass' => 'bg-white',
            ], $statusCode);
        });
    })->create();
