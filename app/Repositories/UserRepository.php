<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    public function getUserBy($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }
}
