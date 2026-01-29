<?php

namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Models\User;

/**
 * User API Controller
 */
class UserController
{
    public function index(Request $request): JsonResponse
    {
        try {
            $users = User::all();
            return JsonResponse::success([
                'users' => array_map(fn($user) => $user->toArray(), $users),
                'count' => count($users),
            ]);
        } catch (\Exception $e) {
            return JsonResponse::error('Failed to fetch users', 500);
        }
    }

    public function show(Request $request, int $id): JsonResponse
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return JsonResponse::error('User not found', 404);
            }
            return JsonResponse::success($user->toArray());
        } catch (\Exception $e) {
            return JsonResponse::error('Failed to fetch user', 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                return JsonResponse::error('Name, email, and password are required', 422);
            }

            if (User::findByEmail($data['email'])) {
                return JsonResponse::error('Email already exists', 422);
            }

            $user = User::create($data);
            return JsonResponse::created($user->toArray(), 'User created successfully');
        } catch (\Exception $e) {
            return JsonResponse::error('Failed to create user: ' . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return JsonResponse::error('User not found', 404);
            }

            $data = $request->all();
            $user->fill($data);
            $user->save();

            return JsonResponse::success($user->toArray(), 'User updated successfully');
        } catch (\Exception $e) {
            return JsonResponse::error('Failed to update user', 500);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return JsonResponse::error('User not found', 404);
            }

            $user->delete();
            return JsonResponse::success(null, 'User deleted successfully');
        } catch (\Exception $e) {
            return JsonResponse::error('Failed to delete user', 500);
        }
    }
}
