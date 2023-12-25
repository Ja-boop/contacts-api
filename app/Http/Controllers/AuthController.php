<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = $this->authService->getUser($credentials);

        return $this->authService->createToken($user);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
