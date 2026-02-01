<?php

namespace App\Controllers\Auth;

use App\Services\Auth\AuthenticationService;
use App\Validation\UserValidationRules;
use Core\Http\JsonResponse;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * API Authentication Controller
 *
 * Returns JSON responses for AJAX/API authentication requests.
 * Uses AuthenticationService for business logic.
 */
class AuthApiController
{
    /**
     * Constructor with dependency injection
     *
     * @param AuthenticationService $authService
     */
    public function __construct(
        private AuthenticationService $authService
    ) {}

    /**
     * API Register - Create new user account
     *
     * POST /api/auth/register
     */
    public function register(Request $request): Response
    {
        // Validate using centralized rules
        $validator = Validator::make($request->all(), UserValidationRules::registration());

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        // Create user via service
        $user = $this->authService->register([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        // Log the user in
        auth()->login($user);

        return JsonResponse::success([
            'message' => 'Account created successfully!',
            'user' => $this->authService->userToArray($user),
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
        // Validate using centralized rules
        $validator = Validator::make($request->all(), UserValidationRules::login());

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        $remember = $request->input('remember') === '1' || $request->input('remember') === 1;

        // Attempt login via service
        if ($this->authService->login(
            $request->input('email'),
            $request->input('password'),
            $remember
        )) {
            $user = $this->authService->getCurrentUser();

            return JsonResponse::success([
                'message' => 'Login successful!',
                'user' => $this->authService->userToArray($user),
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
        $this->authService->logout();

        return JsonResponse::success([
            'message' => 'Logged out successfully',
        ]);
    }
}
