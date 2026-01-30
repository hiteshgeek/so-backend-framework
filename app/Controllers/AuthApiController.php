<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\JsonResponse;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * API Authentication Controller
 *
 * Returns JSON responses for AJAX/API authentication requests
 */
class AuthApiController
{
    /**
     * API Register - Create new user account
     *
     * POST /api/auth/register
     */
    public function register(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        // Create new user (password is hashed automatically by User model)
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        // Log the user in
        auth()->login($user);

        return JsonResponse::success([
            'message' => 'Account created successfully!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'demo_token' => 'demo_token_' . time(), // For demo purposes
        ], 201);
    }

    /**
     * API Login - Authenticate user
     *
     * POST /api/auth/login
     */
    public function login(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $remember = $request->input('remember') === '1' || $request->input('remember') === 1;

        if (auth()->attempt($credentials, $remember)) {
            $user = auth()->user();

            return JsonResponse::success([
                'message' => 'Login successful!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'demo_token' => 'demo_token_' . time(), // For demo purposes
                'remember' => $remember,
            ]);
        }

        return JsonResponse::error('Invalid email or password', 401);
    }

    /**
     * API Logout - Clear authentication
     *
     * POST /api/auth/logout
     */
    public function logout(Request $request): Response
    {
        auth()->logout();

        return JsonResponse::success([
            'message' => 'Logged out successfully',
        ]);
    }
}
