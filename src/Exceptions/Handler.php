<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        Log::channel('errors')->error($exception->getMessage() . " " . $exception->getFile() . "(" . $exception->getLine() . ")" . PHP_EOL . $exception->getTraceAsString());
        if (env('APP_DEBUG') || !View::exists('error')) {
            return parent::render($request, $exception);
        } else {
            $code = $exception->getStatusCode() ?? 500;
            switch ($code) {
                case 404:
                    $message = "La page n'existe pas";
                    break;
                case 405:
                    $message = "Méthode non autorisée";
                    break;
                default:
                    $message = "Erreur interne";
                    break;
            }
            return response(view("error", ['code' => $code, 'message' => $message]), $code);
        }
    }
}
