<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Modules\Authenticator\Interfaces\Base as Authenticator;

class Register extends Controller
{
    public function __construct(
        protected Authenticator $auth,
    ) {
    }

    public function register(Request $request): JsonResponse
    {
        $response = $this->auth->register($request);
        return response()->json($response->json(), $response->status(), $response->headers());
    }

    public function googleRegister(Request $request): JsonResponse
    {
        $response = $this->auth->googleRegister($request);
        return response()->json($response->json(), $response->status(), $response->headers());
    }
}
