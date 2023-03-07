<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TraceLog
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info(
            'process start.',
            [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'request' => $request->all(),
            ]
        );
        $response = $next($request);
        Log::info(
            'process end.',
            [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'response' => json_decode($response->content(), true),
                'status_code' => $response->status()
            ]
        );
        return $response;
    }
}
