<?php

/**
 * SixOrbit UI Demo - Forgot Password
 */
require_once 'includes/config.php';
$pageTitle = 'Reset Password - ' . DEMO_COMPANY_NAME;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>

    <!-- Prevent theme flash on page load -->
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('so-theme-preference') || 'light';
                var effectiveTheme = theme;
                if (theme === 'sidebar-dark') effectiveTheme = 'light';
                else if (theme === 'system') {
                    effectiveTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                document.documentElement.setAttribute('data-theme', effectiveTheme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- SixOrbit UI CSS -->
    <link rel="stylesheet" href="<?= so_asset('css', 'sixorbit-full') ?>">
    <!-- Auth Page CSS -->
    <?php if ($authCss = so_page_asset('auth', 'css')): ?>
        <link rel="stylesheet" href="<?= $authCss ?>">
    <?php endif; ?>
</head>

<body>
    <div class="so-auth-page">
        <div class="so-auth-container centered">
            <!-- Single Card for Forgot Password Flow -->
            <div class="so-auth-card">
                <div class="so-auth-body">
                    <!-- Step 1: Enter Email/Mobile -->
                    <div class="so-auth-step active" data-step="1">
                        <div class="so-auth-header">
                            <h1 class="so-auth-title">Reset Password</h1>
                            <p class="so-auth-subtitle">Enter your email or mobile to receive a verification code</p>
                        </div>

                        <form id="sendOtpForm" novalidate>
                            <!-- Recovery Type Toggle -->
                            <div class="so-auth-type-toggle">
                                <button type="button" class="so-auth-type-btn active" data-type="email">
                                    <span class="material-icons">email</span>
                                    Email
                                </button>
                                <button type="button" class="so-auth-type-btn" data-type="mobile">
                                    <span class="material-icons">phone</span>
                                    Mobile
                                </button>
                            </div>

                            <!-- Email/Mobile Input -->
                            <div class="so-form-group" id="recoveryIdGroup">
                                <label class="so-form-label" for="recoveryId">Email Address</label>
                                <div class="so-input-wrapper so-auth-input-wrapper">
                                    <span class="so-input-icon" id="recoveryIdIcon">
                                        <span class="material-icons">email</span>
                                    </span>
                                    <input type="email"
                                        id="recoveryId"
                                        class="so-form-control"
                                        placeholder="Enter your email address"
                                        autocomplete="email"
                                        required>
                                </div>
                                <span class="so-form-error" id="recoveryIdError">
                                    <span class="material-icons">error</span>
                                    Please enter a valid email address
                                </span>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="so-btn so-btn-primary so-btn-lg so-btn-block" id="sendOtpBtn">
                                <span class="material-icons">send</span>
                                Send Verification Code
                            </button>
                        </form>

                        <div class="so-text-center">
                            <a href="login.php" class="so-auth-back">
                                <span class="material-icons">arrow_back</span>
                                Back to Login
                            </a>
                        </div>
                    </div>

                    <!-- Step 2: OTP Verification -->
                    <div class="so-auth-step" data-step="2">
                        <div class="so-auth-header">
                            <h1 class="so-auth-title">Verify Your Identity</h1>
                            <p class="so-auth-subtitle" id="otpSentText">We sent a verification code to your email</p>
                        </div>

                        <form id="verifyOtpForm" novalidate>
                            <!-- OTP Input -->
                            <div class="so-otp-container">
                                <div class="so-otp-inputs">
                                    <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
                                    <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                    <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                    <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                    <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                    <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                </div>

                                <div class="so-auth-resend">
                                    <span>Didn't receive the code?</span>
                                    <button type="button" class="so-auth-resend-btn" id="resendOtpBtn" disabled>
                                        Resend in 30s
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="so-btn so-btn-primary so-btn-lg so-btn-block" id="verifyOtpBtn">
                                <span class="material-icons">verified</span>
                                Verify Code
                            </button>
                        </form>

                        <div class="so-text-center">
                            <a href="#" class="so-auth-back" data-go-step="1">
                                <span class="material-icons">arrow_back</span>
                                Change Email/Mobile
                            </a>
                        </div>
                    </div>

                    <!-- Step 3: Create New Password -->
                    <div class="so-auth-step" data-step="3">
                        <div class="so-auth-header">
                            <h1 class="so-auth-title">Create New Password</h1>
                            <p class="so-auth-subtitle">Enter your new password below</p>
                        </div>

                        <form id="resetPasswordForm" novalidate>
                            <!-- New Password Input -->
                            <div class="so-form-group" id="newPasswordGroup">
                                <label class="so-form-label" for="newPassword">New Password</label>
                                <div class="so-input-wrapper so-auth-input-wrapper">
                                    <span class="so-input-icon">
                                        <span class="material-icons">lock</span>
                                    </span>
                                    <input type="password"
                                        id="newPassword"
                                        class="so-form-control"
                                        placeholder="Enter your new password"
                                        autocomplete="new-password"
                                        required>
                                    <button type="button" class="so-input-action so-password-toggle" aria-label="Toggle password visibility">
                                        <span class="material-icons">visibility</span>
                                    </button>
                                </div>
                                <span class="so-form-error" id="newPasswordError">
                                    <span class="material-icons">error</span>
                                    Password is required
                                </span>
                            </div>

                            <!-- Password Requirements -->
                            <ul class="so-password-requirements">
                                <li data-requirement="length">
                                    <span class="material-icons">radio_button_unchecked</span>
                                    At least 8 characters
                                </li>
                                <li data-requirement="uppercase">
                                    <span class="material-icons">radio_button_unchecked</span>
                                    One uppercase letter
                                </li>
                                <li data-requirement="number">
                                    <span class="material-icons">radio_button_unchecked</span>
                                    One number
                                </li>
                            </ul>

                            <!-- Confirm Password Input -->
                            <div class="so-form-group" id="confirmPasswordGroup">
                                <label class="so-form-label" for="confirmPassword">Confirm Password</label>
                                <div class="so-input-wrapper so-auth-input-wrapper">
                                    <span class="so-input-icon">
                                        <span class="material-icons">lock_outline</span>
                                    </span>
                                    <input type="password"
                                        id="confirmPassword"
                                        class="so-form-control"
                                        placeholder="Confirm your new password"
                                        autocomplete="new-password"
                                        required>
                                    <button type="button" class="so-input-action so-password-toggle" aria-label="Toggle password visibility">
                                        <span class="material-icons">visibility</span>
                                    </button>
                                </div>
                                <span class="so-form-error" id="confirmPasswordError">
                                    <span class="material-icons">error</span>
                                    Please confirm your password
                                </span>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="so-btn so-btn-primary so-btn-lg so-btn-block" id="resetPasswordBtn">
                                <span class="material-icons">vpn_key</span>
                                Reset Password
                            </button>
                        </form>
                    </div>

                    <!-- Step 4: Success -->
                    <div class="so-auth-step" data-step="4">
                        <div class="so-auth-success">
                            <div class="so-auth-success-icon">
                                <span class="material-icons">check_circle</span>
                            </div>
                            <h2 class="so-auth-success-title">Password Reset Successfully!</h2>
                            <p class="so-auth-success-message">
                                Your password has been changed successfully.<br>
                                You can now sign in with your new password.
                            </p>

                            <a href="login.php" class="so-btn so-btn-primary so-btn-lg so-btn-block">
                                <span class="material-icons">login</span>
                                Back to Login
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SixOrbit Branding Footer -->
                <div class="so-auth-footer so-mt-5" style="border-top: none;">
                    <a href="https://sixorbit.com" target="_blank" rel="noopener" class="so-d-inline-flex so-align-items-center so-gap-1 so-text-decoration-none so-fs-xs" style="color: var(--so-text-muted);">
                        <svg width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="24" cy="24" rx="22" ry="10" stroke="currentColor" stroke-width="2" fill="none" transform="rotate(-20 24 24)" opacity="0.6" />
                            <path d="M24 6L38.7 15V33L24 42L9.3 33V15L24 6Z" stroke="currentColor" stroke-width="2.5" fill="none" />
                            <circle cx="24" cy="24" r="4" fill="currentColor" />
                            <circle cx="42" cy="18" r="2.5" fill="currentColor" />
                            <circle cx="6" cy="30" r="2.5" fill="currentColor" />
                        </svg>
                        Powered by <span style="color: var(--so-accent-primary); font-weight: 500;">SixOrbit ERP</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SixOrbit UI JS -->
    <script src="<?= so_asset('js', 'sixorbit-full') ?>"></script>
    <!-- Auth Page JavaScript -->
    <?php if ($authJs = so_page_asset('auth', 'js')): ?>
        <script src="<?= $authJs ?>"></script>
    <?php endif; ?>
    <script>
        // Initialize forgot password flow
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof SOForgotPassword !== 'undefined') {
                new SOForgotPassword(document.querySelector('.so-auth-card'));
            } else {
                // Fallback simple step navigation
                initSimpleForgotPassword();
            }
        });

        function initSimpleForgotPassword() {
            const steps = document.querySelectorAll('.so-auth-step');
            const dots = document.querySelectorAll('.so-auth-step-dot');
            let currentStep = 1;

            function goToStep(step) {
                steps.forEach(s => s.classList.remove('active'));
                dots.forEach((d, i) => {
                    d.classList.remove('active', 'completed');
                    if (i + 1 < step) {
                        d.classList.add('completed');
                    } else if (i + 1 === step) {
                        d.classList.add('active');
                    }
                });
                const targetStep = document.querySelector(`.so-auth-step[data-step="${step}"]`);
                if (targetStep) targetStep.classList.add('active');
                currentStep = step;
            }

            // Step 1: Send OTP
            document.getElementById('sendOtpForm')?.addEventListener('submit', function(e) {
                e.preventDefault();
                const input = document.getElementById('recoveryId');
                if (input.value.trim()) {
                    goToStep(2);
                }
            });

            // Step 2: Verify OTP
            document.getElementById('verifyOtpForm')?.addEventListener('submit', function(e) {
                e.preventDefault();
                const inputs = document.querySelectorAll('.so-otp-input');
                const otp = Array.from(inputs).map(i => i.value).join('');
                if (otp.length === 6) {
                    goToStep(3);
                }
            });

            // Step 3: Reset Password
            document.getElementById('resetPasswordForm')?.addEventListener('submit', function(e) {
                e.preventDefault();
                const newPass = document.getElementById('newPassword').value;
                const confirmPass = document.getElementById('confirmPassword').value;
                if (newPass && newPass === confirmPass) {
                    goToStep(4);
                }
            });

            // Back links
            document.querySelectorAll('[data-go-step]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToStep(parseInt(this.dataset.goStep));
                });
            });

            // Type toggle
            document.querySelectorAll('.so-auth-type-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.so-auth-type-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const type = this.dataset.type;
                    const input = document.getElementById('recoveryId');
                    const iconWrapper = document.getElementById('recoveryIdIcon');
                    const iconEl = iconWrapper?.querySelector('.material-icons');
                    const label = document.querySelector('label[for="recoveryId"]');
                    if (type === 'mobile') {
                        input.type = 'tel';
                        input.placeholder = 'Enter your mobile number';
                        if (iconEl) iconEl.textContent = 'phone';
                        label.textContent = 'Mobile Number';
                    } else {
                        input.type = 'email';
                        input.placeholder = 'Enter your email address';
                        if (iconEl) iconEl.textContent = 'email';
                        label.textContent = 'Email Address';
                    }
                });
            });

            // OTP auto-advance
            document.querySelectorAll('.so-otp-input').forEach((input, index, inputs) => {
                input.addEventListener('input', function() {
                    if (this.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            // Password toggle
            document.querySelectorAll('.so-password-toggle').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('.material-icons');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.textContent = 'visibility_off';
                    } else {
                        input.type = 'password';
                        icon.textContent = 'visibility';
                    }
                });
            });

            // Password requirements check
            const newPassword = document.getElementById('newPassword');
            if (newPassword) {
                newPassword.addEventListener('input', function() {
                    const val = this.value;
                    const reqs = {
                        length: val.length >= 8,
                        uppercase: /[A-Z]/.test(val),
                        number: /[0-9]/.test(val)
                    };
                    Object.entries(reqs).forEach(([key, met]) => {
                        const li = document.querySelector(`[data-requirement="${key}"]`);
                        if (li) {
                            li.classList.toggle('valid', met);
                            li.querySelector('.material-icons').textContent = met ? 'check_circle' : 'radio_button_unchecked';
                        }
                    });
                });
            }
        }
    </script>
</body>

</html>