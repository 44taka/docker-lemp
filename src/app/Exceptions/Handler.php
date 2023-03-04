<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Throwable;

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
     *
     * @return void
     */
    public function register()
    {
        // APIのエラーハンドリング
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $message = '';

                // HttpExceptionの場合
                if ($e instanceof HttpException) {
                    switch ($e->getStatusCode()) {
                        case Response::HTTP_BAD_REQUEST:
                            $message = __('Bad Request');
                            break;
                        case Response::HTTP_NOT_FOUND:
                            $message = __('Not Found');
                            break;
                    }
                    return response()->json(
                        ['message' => $message],
                        $e->getStatusCode()
                    );
                }

                // HttpException以外の場合
                $message = config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace_str' => $e->getTraceAsString(),
                    'trace' => $e->getTrace()
                ] : __('Server Error');

                return response()->json([
                    'message' => $message
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
