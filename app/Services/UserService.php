<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function login($data)
    {

        try {

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                return ['success' => false, 'message' => 'Invalid credentials'];
            }

            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

            return ['success' => true, 'message' => 'Login was successful', 'token' => $token];

        } catch (Exception $ex) {
            return ['success' => false, 'message' => 'Internal server error'];
        }

    }

    public function register($data)
    {
        try {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return ['success' => true, 'message' => 'User account created successfully', 'users' => $user];

        } catch (Exception $ex) {
            return ['success' => false, 'message' => 'Internal server error'];
        }
    }

}
