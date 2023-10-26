<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Modules\Authenticator\Interfaces\Base as Authenticator;

class Profile extends Controller
{
    public function __construct(
        protected Authenticator $auth,
    ) {
    }

    public function show(Request $request): JsonResponse
    {
        $response = $this->auth->show($request);
        return response()->json($response->json(), $response->status(), $response->headers());
    }

    public function update(Request $request): JsonResponse
    {
        $response = $this->auth->update($request);
        return response()->json($response->json(), $response->status(), $response->headers());
    }
}
