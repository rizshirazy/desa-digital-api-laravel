<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $data)
    {
        if (! Auth::guard('web')->attempt($data)) {
            return response([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'success' => true,
            'message' => 'Login Success',
            'token' => $token,
        ], 200);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response([
            'success' => true,
            'message' => 'Logout Success',
        ], 200);
    }

    public function me()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $user->load('roles.permissions');

            $permissions = $user->roles->flatMap->permissions->pluck('name');

            $role = $user->roles->first()->name;

            return response()->json([
                'message' => 'User Data',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                    'permissions' => $permissions,
                ],
            ]);
        }

        return response()->json([
            'message' => 'You are not logged in',
        ], 401);
    }
}
