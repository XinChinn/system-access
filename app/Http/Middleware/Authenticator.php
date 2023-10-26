<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Src\Modules\Authenticator\Interfaces\Base as AuthenticatorInterface;

class Authenticator
{
    public function __construct(
        protected AuthenticatorInterface $auth,
    ) {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $this->auth->authenticateToken($request);
        if (! $response->ok() )
        {
            return response()->json($response->json(), $response->status(), $response->headers());
        }
            
        return $next($request);
    }
}
