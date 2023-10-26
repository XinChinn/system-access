<?php

namespace Src\Modules\Authenticator\Interfaces;

use Illuminate\Http\Request;

interface Base
{
    public function login(Request $request);

    public function googleLogin(Request $request);

    public function register(Request $request);

    public function googleRegister(Request $request);

    public function logout(Request $request);

    public function show(Request $request);

    public function update(Request $request);

    public function authenticateToken($request);

    public function tokenInfo($token);
}
