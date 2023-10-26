<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Modules\Authenticator\Interfaces\Base as Authenticator;

class Token extends Controller
{ 
    public function __construct(
        protected Authenticator $auth,
    ) {
    }

    public function info(Request $request): JsonResponse
    {
        $response = $this->auth->tokenInfo($request->bearerToken());
        return response()->json($response->json(), $response->status(), $response->headers());
    }

    public function authenticate(Request $request): JsonResponse
    {
        $response = $this->auth->authenticateToken($request);
        return response()->json($response->json(), $response->status(), $response->headers());
    }

}
