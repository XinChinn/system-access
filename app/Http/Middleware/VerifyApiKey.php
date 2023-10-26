<?php

namespace App\Http\Middleware;

use App\Models\Services\Key;
use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->expectsJson()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Forbidden Access',
                    'prompt' => 'error',
                ], 401
            );
        }

        if (empty($request->header('api-key'))) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'API key is required.',
                    'prompt' => 'error',
                ], 401
            );
        }
        
        if (Key::whereKeyKey($request->header('api-key') ?? false)->doesntExist()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'API key is not registered.',
                    'prompt' => 'error',
                ],
                401
            );
        }

        if (Key::whereKeyKey($request->header('api-key') ?? false)->has('websites')->exists()
        && Key::whereKeyKey($request->header('api-key') ?? false)->whereWebsite($request->root())->doesntExist()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Request form '.$request->root().' is not allowed',
                    'prompt' => 'error',
                ],
                401
            );
        }

        if (Key::whereKeyKey($request->header('api-key') ?? false)->has('ip_addresses')->exists()
        && Key::whereKeyKey($request->header('api-key') ?? false)->whereIpAddress($request->ip())->doesntExist()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Request form IP Address: '.$request->ip().' is not allowed',
                    'prompt' => 'error',
                ],
                401
            );
        }

        return $next($request);
    }
}
