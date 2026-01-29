<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Authentication Controller
 *
 * Handles user registration, login, and logout
 */
class AuthController
{
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect(url('/register'))
                ->withErrors($validator->errors())
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Create new user (password is hashed automatically by User model)
        $user = User::create([
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(url('/login'))
                ->withErrors($validator->errors())
                ->withInput($request->only(['email']));
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (auth()->attempt($credentials)) {
            return redirect(url('/dashboard'))
                ->with('success', 'Welcome back, ' . auth()->user()->name . '!');
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
        auth()->logout();

        return redirect(url('/login'))
            ->with('success', 'You have been logged out successfully.');
    }
}
