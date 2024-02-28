<?php

namespace App\Exceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
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
    }

     public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return $this->handleAuthenticationException($exception, $request);
        } elseif (
            $exception instanceof TokenExpiredException ||
            $exception instanceof TokenInvalidException ||
            $exception instanceof JWTException
        ) {
            return $this->handleTokenException($exception);
        } elseif ($exception instanceof HttpException && $exception->getStatusCode() === 401) {
            return $this->handleHttpException($exception);
        }

        return parent::render($request, $exception);
    }

    protected function handleAuthenticationException(AuthenticationException $exception, $request)
    {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    protected function handleTokenException($exception)
    {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    protected function handleHttpException(HttpException $exception)
    {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
