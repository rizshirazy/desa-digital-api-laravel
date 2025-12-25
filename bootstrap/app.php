<?php

use App\Helpers\ResponseHelper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $model = class_basename($e->getModel());

            $messages = [
                'User' => 'User tidak ditemukan',
                'HeadOfFamily' => 'Kepala Keluarga tidak ditemukan',
            ];

            $message = $messages[$model] ?? 'Data tidak ditemukan';

            return ResponseHelper::JsonResponse(false, $message, null, 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            return ResponseHelper::JsonResponse(false, 'Endpoint tidak ditemukan', null, 404);
        });
    })->create();
