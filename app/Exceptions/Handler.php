<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (DangerousUrlException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'URL is dangerous, please try another one'], 422);
            }
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Not Found'], 404);
            }
        });
    }
}
