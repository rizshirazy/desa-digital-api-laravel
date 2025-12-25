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
        $messageForModel = function (ModelNotFoundException $e): string {
            $messages = [
                'User' => 'User tidak ditemukan',
                'HeadOfFamily' => 'Kepala Keluarga tidak ditemukan',
            ];

            return $messages[class_basename($e->getModel())] ?? 'Data tidak ditemukan';
        };

        $exceptions->render(function (ModelNotFoundException $e, $request) use ($messageForModel) {
            if (! $request->expectsJson()) {
                return null;
            }

            return ResponseHelper::JsonResponse(false, $messageForModel($e), null, 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) use ($messageForModel) {
            if (! $request->expectsJson()) {
                return null;
            }

            // When implicit route model binding fails (including soft-deleted models),
            // Laravel may wrap the ModelNotFoundException inside a NotFoundHttpException.
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return ResponseHelper::JsonResponse(false, $messageForModel($e->getPrevious()), null, 404);
            }

            return ResponseHelper::JsonResponse(false, 'Endpoint tidak ditemukan', null, 404);
        });
    })->create();
