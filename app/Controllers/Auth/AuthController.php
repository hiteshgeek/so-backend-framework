<?php

namespace App\Controllers\Auth;

use App\Services\Auth\AuthenticationService;
use App\Validation\UserValidationRules;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Authentication Controller
 *
 * Handles user registration, login, and logout for web interface.
 * Uses AuthenticationService for business logic.
 */
class AuthController
{
    private AuthenticationService $authService;

    public function __construct()
    {
        $this->authService = new AuthenticationService();
    }

    /**
     * Show registration form
     */
    public function showRegister(Request $request): Response
    {
        return Response::view('auth/register', [
            'title' => 'Register - ' . config('app.name'),
            'errors' => session('errors', []),
            'old' => session('_old_input', []),
        ]);
    }

    /**
     * Process registration
     */
    public function register(Request $request): Response
    {
        // Validate using centralized rules
        $validator = Validator::make($request->all(), UserValidationRules::registration());

        if ($validator->fails()) {
            return redirect(url('/register'))
                ->withErrors($validator->errors())
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Create user via service
        $user = $this->authService->register([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        // Log the user in
        auth()->login($user);

        return redirect(url('/dashboard'))
            ->with('success', 'Account created successfully! Welcome, ' . $user->name . '!');
    }

    /**
     * Show login form
     */
    public function showLogin(Request $request): Response
    {
        return Response::view('auth/login', [
            'title' => 'Login - ' . config('app.name'),
            'errors' => session('errors', []),
            'old' => session('_old_input', []),
        ]);
    }

    /**
     * Process login
     */
    public function login(Request $request): Response
    {
        // Validate using centralized rules
        $validator = Validator::make($request->all(), UserValidationRules::login());

        if ($validator->fails()) {
            return redirect(url('/login'))
                ->withErrors($validator->errors())
                ->withInput($request->only(['email']));
        }

        $remember = $request->input('remember') === '1';

        // Attempt login via service
        if ($this->authService->login(
            $request->input('email'),
            $request->input('password'),
            $remember
        )) {
            $user = $this->authService->getCurrentUser();
            return redirect(url('/dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return redirect(url('/login'))
            ->with('error', 'Invalid email or password.')
            ->withInput($request->only(['email']));
    }

    /**
     * Process logout
     */
    public function logout(Request $request): Response
    {
        $this->authService->logout();

        return redirect(url('/login'))
            ->with('success', 'You have been logged out successfully.');
    }
}
