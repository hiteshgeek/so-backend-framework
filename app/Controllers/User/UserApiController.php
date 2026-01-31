<?php

namespace App\Controllers\User;

use App\Services\User\UserService;
use App\Validation\UserValidationRules;
use Core\Http\Request;
use Core\Http\JsonResponse;
use Core\Validation\Validator;

/**
 * User API Controller
 *
 * Handles AJAX requests for user CRUD operations.
 * Uses UserService for business logic and authorization.
 */
class UserApiController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Get all users
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return JsonResponse::success([
            'users' => array_map(fn($user) => $this->userService->toArray($user), $users),
            'count' => count($users),
        ]);
    }

    /**
     * Create a new user
     */
    public function store(Request $request): JsonResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), UserValidationRules::registration());

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        // Create user
        $user = $this->userService->createUser([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return JsonResponse::success([
            'message' => 'User created successfully!',
            'user' => $this->userService->toArray($user),
        ], 201);
    }

    /**
     * Get a single user
     *
     * ✅ IDOR FIX: Users can only view their own data (or admins can view all)
     */
    public function show(Request $request, int $id): JsonResponse
    {
        // Authorization check - prevent IDOR vulnerability
        if (!$this->userService->canAccessUser($id, auth()->id(), true)) {
            return JsonResponse::error('Forbidden - you can only view your own user data', 403);
        }

        // Find user
        try {
            $user = $this->userService->findOrFail($id);
        } catch (\RuntimeException $e) {
            return JsonResponse::error($e->getMessage(), $e->getCode());
        }

        return JsonResponse::success([
            'user' => $this->userService->toArray($user),
        ]);
    }

    /**
     * Update a user
     *
     * ✅ IDOR FIX: Users can only update their own data (or admins can update all)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Authorization check - prevent IDOR vulnerability
        if (!$this->userService->canModifyUser($id, auth()->id())) {
            return JsonResponse::error('Forbidden - you can only update your own user data', 403);
        }

        // Find user
        try {
            $user = $this->userService->findOrFail($id);
        } catch (\RuntimeException $e) {
            return JsonResponse::error($e->getMessage(), $e->getCode());
        }

        // Validation rules - password optional
        $rules = UserValidationRules::update(false);

        // Add password validation if password is provided
        if ($request->input('password')) {
            $rules = array_merge($rules, UserValidationRules::passwordUpdate());
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        // Update user
        $updatedUser = $this->userService->updateUser($id, [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return JsonResponse::success([
            'message' => 'User updated successfully!',
            'user' => $this->userService->toArray($updatedUser),
        ]);
    }

    /**
     * Delete a user
     *
     * ✅ IDOR FIX: Proper authorization check via service
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        // Authorization check - prevent IDOR and self-deletion
        if (!$this->userService->canDeleteUser($id, auth()->id())) {
            return JsonResponse::error('Forbidden - you cannot delete this user', 403);
        }

        // Find user
        try {
            $user = $this->userService->findOrFail($id);
        } catch (\RuntimeException $e) {
            return JsonResponse::error($e->getMessage(), $e->getCode());
        }

        $userName = $user->name;

        // Delete user
        $this->userService->deleteUser($id);

        return JsonResponse::success([
            'message' => 'User "' . $userName . '" deleted successfully.',
        ]);
    }
}
