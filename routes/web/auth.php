<?php

/**
 * Authentication Routes
 *
 * Login, Register, Password Reset, Logout
 */

use Core\Routing\Router;
use App\Controllers\AuthController;
use App\Controllers\PasswordController;
use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\ThrottleMiddleware;

Router::group(['middleware' => [CsrfMiddleware::class]], function () {

    // Guest routes (redirect to dashboard if authenticated)
    Router::group(['middleware' => [GuestMiddleware::class]], function () {
        Router::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Router::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Router::get('/password/forgot', [PasswordController::class, 'showForgotForm'])->name('password.forgot');
        Router::get('/password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');

        // Rate-limited auth POST routes (5 attempts per minute)
        Router::group(['middleware' => [ThrottleMiddleware::class . ':5,1']], function () {
            Router::post('/register', [AuthController::class, 'register'])->name('register.submit');
            Router::post('/login', [AuthController::class, 'login'])->name('login.submit');
            Router::post('/password/forgot', [PasswordController::class, 'sendResetLink'])->name('password.email');
            Router::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');
        });
    });

    // Logout (requires authentication)
    Router::group(['middleware' => [AuthMiddleware::class]], function () {
        Router::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
