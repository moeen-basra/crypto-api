<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Photon\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param \Throwable $e
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            $error = $this->formatError($e);

            return response()->json($error, $error['error']);
        }

        parent::render($request, $e);
    }

    private function formatError(Throwable $e): array
    {
        $error = [
            'error' => 400,
            'error_message' => $e->getMessage(),
            'time' => Carbon::now()->unix(),
        ];

        if ($e instanceof ValidationException) {
            $error['data'] = $e->errors();
        }

        return $error;
    }
}
