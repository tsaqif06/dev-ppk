<?php

namespace App\Exceptions;

use Throwable;
use Psr\Log\LogLevel;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {

                if ($e instanceof NotFoundHttpException) {
                    return ApiResponse::errorResponse('Record Not Found', 404, null);
                }
                if ($e instanceof UnauthorizedHttpException) {
                    return ApiResponse::errorResponse('Unauthorized', 401, null);
                }
                if ($e instanceof BadRequestHttpException) {
                    return ApiResponse::errorResponse('Bad Request', 400, $e->getTrace());
                }
                if ($e instanceof MethodNotAllowedHttpException) {
                    return ApiResponse::errorResponse('Method Not Allowed', 405, $e->getTrace());
                }
                if ($e instanceof HttpException) {
                    return ApiResponse::errorResponse('Internal Server Error', 500, $e->getTrace());
                }
                if ($e instanceof UnauthorizedHttpException) {
                    return ApiResponse::errorResponse('Unauthorized', 401, null);
                }
                if ($e instanceof AuthenticationException) {
                    return ApiResponse::errorResponse('Unauthenticated', 401, null);
                }
                return ApiResponse::errorResponse($e->getMessage(), 500, $e->getTrace());
            }
        });
    }
}
