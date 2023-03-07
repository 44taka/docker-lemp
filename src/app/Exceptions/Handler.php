<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
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
            // TODO: リファクタする
            if ($request->is('api/*')) {
                $message = '';
                $details = [];

                // HttpExceptionの場合
                if ($e instanceof HttpException) {
                    switch ($e->getStatusCode()) {
                        case Response::HTTP_BAD_REQUEST:
                            $message = __('Bad Request');
                            break;
                        case Response::HTTP_NOT_FOUND:
                            $message = __('Not Found');
                            break;
                        case Response::HTTP_METHOD_NOT_ALLOWED:
                            $message = __('Method Not Allowed');
                            break;
                        case Response::HTTP_INTERNAL_SERVER_ERROR:
                            $message = __('Internal Server Error');
                            break;
                        case Response::HTTP_SERVICE_UNAVAILABLE:
                            $message = __('Service Unavailable');
                            break;
                    }
                    Log::error('API ERROR', ['detail' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace_str' => $e->getTraceAsString(),
                        'trace' => $e->getTrace()
                    ]]);
                    return response()->json(
                        [
                            'message' => $message,
                            'details' => $details,
                        ],
                        $e->getStatusCode()
                    );
                }

                // HttpException以外の場合
                $data = config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'details' => [
                        'code' => $e->getCode(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace_str' => $e->getTraceAsString(),
                        'trace' => $e->getTrace()
                    ]
                ] : [
                    'message' => __('Internal Server Error'),
                    'details' => [],
                ];

                Log::error('APPLICATION ERROR', ['detail' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace_str' => $e->getTraceAsString(),
                    // 'trace' => $e->getTrace()
                ]]);

                return response()->json(
                    $data,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        });
    }
}
