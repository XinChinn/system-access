<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Modules\Authenticator\Interfaces\Base as Authenticator;

class Authenticate extends Controller
{
    public function __construct(
        protected Authenticator $auth,
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        $response = $this->auth->login($request);

        return response()->json($response->json(), $response->status(), $response->headers());
    }

    public function googleLogin(Request $request): JsonResponse
    {
        $response = $this->auth->googleLogin($request);

        return response()->json($response->json(), $response->status(), $response->headers());
    }

    public function logout(Request $request): JsonResponse
    {
        $response = $this->auth->logout($request);

        return response()->json($response->json(), $response->status(), $response->headers());
    }
}
