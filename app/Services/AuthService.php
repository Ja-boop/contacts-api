<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getUser(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['email' => 'The provided credentials are incorrect.']);
        }

        return Auth::user();
    }

    public function createToken(User $user)
    {
        return $user->createToken('authToken')->plainTextToken;
    }

    public function logout()
    {
        Auth::guard('web')->logout();
    }
}
