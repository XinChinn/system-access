<?php

namespace Src\Modules\Authenticator\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Src\Modules\Authenticator\Interfaces\Base as BaseInterface;

class Base implements BaseInterface
{
    public function login(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->post('http://127.0.0.1:8001/api/tenant/login', $request->all());
        
        return $response;
    }

    public function googleLogin(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->post('http://127.0.0.1:8001/api/tenant/google-login', $request->all());

        return $response;
    }

    public function register(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->post('http://127.0.0.1:8001/api/tenant/register', $request->all());

        return $response;
    }

    public function googleRegister(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->post('http://127.0.0.1:8001/api/tenant/google-register', $request->all());

        return $response;
    }

    public function logout(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->get('http://127.0.0.1:8001/api/tenant/logout', $request->all());

        return $response;
    }

    public function show(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->withToken($request->bearerToken())->get('http://127.0.0.1:8001/api/tenant/profile/show', $request->all());

        return $response;
    }

    public function update(Request $request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->withToken($request->bearerToken())->get('http://127.0.0.1:8001/api/tenant/profile/update', $request->all());

        return $response;
    }

    public function tokenInfo($token): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->withToken($token)->get('http://127.0.0.1:8001/api/tenant/token-info');

        return $response;
    }

    public function authenticateToken($request): Response
    {
        $response = Http::withHeaders([
            'api-key' => config('authenticator.api-key'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->withToken($request->bearerToken())->get('http://127.0.0.1:8001/api/tenant/token-authenticate', $request->all());

        return $response;
    }
}
