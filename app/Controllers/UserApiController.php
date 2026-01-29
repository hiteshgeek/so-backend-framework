<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Validation\Validator;

/**
 * User API Controller
 *
 * Handles AJAX requests for user CRUD operations
 */
class UserApiController
{
    /**
     * Get all users
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::all();

        return new JsonResponse([
            'success' => true,
            'users' => array_map(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ], $users)
        ]);
    }

    /**
     * Create a new user
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return new JsonResponse([
            'success' => true,
            'message' => 'User created successfully!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ]
        ], 201);
    }

    /**
     * Get a single user
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    /**
     * Update a user
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email',
        ];

        // Add password validation only if password is provided
        if ($request->input('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password if provided
        if ($request->input('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        return new JsonResponse([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    /**
     * Delete a user
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return new JsonResponse([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 403);
        }

        $userName = $user->name;
        $user->delete();

        return new JsonResponse([
            'success' => true,
            'message' => 'User "' . $userName . '" deleted successfully.'
        ]);
    }
}
