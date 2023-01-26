<?php

namespace App\Exceptions;

use App\Helpers\FlashMessage\FlashMessageParameters;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return $this->handleApiException($e);
            }
        });
    }

    private function handleApiException(Throwable $e): JsonResponse
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return FlashMessageParameters::error(['message' => $e->getMessage()], ResponseAlias::HTTP_FORBIDDEN)->toJson();
        }
        if ($e instanceof UnauthorizedException || $e instanceof AuthenticationException) {
            return FlashMessageParameters::error(['message' => $e->getMessage()], ResponseAlias::HTTP_UNAUTHORIZED)->toJson();
        }
        if ($e instanceof ValidationException) {
            return FlashMessageParameters::error(['message' => $e->getMessage(), 'errors' => $e->errors()], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)->toJson();
        }
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return FlashMessageParameters::error(['message' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND)->toJson();
        }
        return FlashMessageParameters::error(['message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR)->toJson();
    }
}
