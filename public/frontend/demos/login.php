<?php
/**
 * SixOrbit UI Demo - Login Page
 * Uses framework's standard form components and auth layout
 */
$pageTitle = 'Login';
$pageDescription = 'Login to SixOrbit ERP';

require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - SixOrbit UI</title>

    <!-- Prevent theme flash -->
    <script>
    (function() {
        try {
            var theme = localStorage.getItem('so-theme-preference') || 'sidebar-dark';
            var effectiveTheme = (theme === 'sidebar-dark' || theme === 'light') ? 'light' :
                                  (theme === 'system' && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' :
                                  (theme === 'dark') ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', effectiveTheme);
        } catch(e) {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    })();
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- SixOrbit UI CSS -->
    <link rel="stylesheet" href="<?= so_asset('css', 'sixorbit-full') ?>">
    <!-- Auth Page CSS -->
    <?php if ($authCss = so_page_asset('auth', 'css')): ?>
    <link rel="stylesheet" href="<?= $authCss ?>">
    <?php endif; ?>
</head>
<body class="so-auth-page">

<div class="so-auth-container">
    <!-- Left Panel - Branding -->
    <div class="so-auth-branding">
        <!-- Customer Logo -->
        <div class="so-customer-logo">
            <div class="so-customer-logo-placeholder" id="customerLogoPlaceholder">
                <span id="customerInitials"><?= DEMO_COMPANY_INITIALS ?></span>
            </div>
            <img id="customerLogoImg" src="" alt="Customer Logo" style="display: none;">
        </div>
        <div class="so-customer-name" id="customerName"><?= DEMO_COMPANY_NAME ?></div>

        <!-- Feature Carousel -->
        <div class="so-auth-features">
            <div class="so-auth-features-header">What's New</div>
            <div class="so-feature-carousel" id="featureCarousel">
                <div class="so-feature-slides" id="featureSlides">
                    <div class="so-feature-slide active" data-index="0">
                        <div class="so-feature-slide-content">
                            <div class="so-feature-icon">
                                <span class="material-icons">inventory_2</span>
                            </div>
                            <div class="so-feature-title">New Inventory Module</div>
                            <div class="so-feature-description">Track stock levels in real-time with advanced analytics and automated reorder points.</div>
                        </div>
                    </div>
                    <div class="so-feature-slide" data-index="1">
                        <div class="so-feature-slide-content">
                            <div class="so-feature-icon">
                                <span class="material-icons">assessment</span>
                            </div>
                            <div class="so-feature-title">Enhanced GST Reports</div>
                            <div class="so-feature-description">Simplified tax compliance with auto-generated GSTR-1, GSTR-3B, and reconciliation reports.</div>
                        </div>
                    </div>
                    <div class="so-feature-slide" data-index="2">
                        <div class="so-feature-slide-content">
                            <div class="so-feature-icon">
                                <span class="material-icons">phone_android</span>
                            </div>
                            <div class="so-feature-title">Mobile App Launched</div>
                            <div class="so-feature-description">Manage your business on the go with our new iOS and Android applications.</div>
                        </div>
                    </div>
                    <div class="so-feature-slide" data-index="3">
                        <div class="so-feature-slide-content">
                            <div class="so-feature-icon">
                                <span class="material-icons">security</span>
                            </div>
                            <div class="so-feature-title">Advanced Security</div>
                            <div class="so-feature-description">Two-factor authentication and role-based access control for enhanced protection.</div>
                        </div>
                    </div>
                </div>
                <div class="so-feature-dots" id="featureDots">
                    <button class="so-feature-dot active" data-index="0" aria-label="Go to slide 1"></button>
                    <button class="so-feature-dot" data-index="1" aria-label="Go to slide 2"></button>
                    <button class="so-feature-dot" data-index="2" aria-label="Go to slide 3"></button>
                    <button class="so-feature-dot" data-index="3" aria-label="Go to slide 4"></button>
                </div>
            </div>
        </div>

        <!-- SixOrbit Branding -->
        <div class="so-sixorbit-branding">
            <div class="so-sixorbit-branding-text">Powered by</div>
            <a href="https://sixorbit.com" target="_blank" rel="noopener" class="so-sixorbit-branding-link">
                <!-- SixOrbit Logo SVG -->
                <svg class="so-sixorbit-logo" width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Outer orbital ring -->
                    <ellipse cx="24" cy="24" rx="22" ry="10" stroke="currentColor" stroke-width="2" fill="none" transform="rotate(-20 24 24)" opacity="0.6"></ellipse>
                    <!-- Inner hexagon representing "6" -->
                    <path d="M24 6L38.7 15V33L24 42L9.3 33V15L24 6Z" stroke="currentColor" stroke-width="2.5" fill="none"></path>
                    <!-- Center dot -->
                    <circle cx="24" cy="24" r="4" fill="currentColor"></circle>
                    <!-- Orbital dots -->
                    <circle cx="42" cy="18" r="2.5" fill="currentColor"></circle>
                    <circle cx="6" cy="30" r="2.5" fill="currentColor"></circle>
                </svg>
                SixOrbit ERP
                <span class="material-icons">open_in_new</span>
            </a>
        </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="so-auth-card">
        <!-- Auth Header -->
        <div class="so-auth-header">
            <h1 class="so-auth-title">Welcome back!</h1>
            <p class="so-auth-subtitle">Sign in to continue to your account</p>
        </div>

        <!-- Auth Body -->
        <div class="so-auth-body">
            <!-- Login Type Toggle -->
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

            <!-- Login Form -->
            <form id="loginForm">
                <!-- Email/Mobile Input -->
                <div class="so-form-group" id="loginIdGroup">
                    <label class="so-form-label" for="loginId">Email Address</label>
                    <div class="so-input-wrapper so-auth-input-wrapper">
                        <span class="so-input-icon" id="loginIdIcon"><span class="material-icons">email</span></span>
                        <input type="email"
                               id="loginId"
                               class="so-form-control"
                               placeholder="Enter your email address"
                               autocomplete="email"
                               required>
                    </div>
                    <span class="so-form-error" id="loginIdError">
                        <span class="material-icons">error</span>
                        Please enter a valid email address
                    </span>
                </div>

                <!-- Password Input -->
                <div class="so-form-group" id="passwordGroup">
                    <label class="so-form-label" for="password">Password</label>
                    <div class="so-input-wrapper so-auth-input-wrapper">
                        <span class="so-input-icon"><span class="material-icons">lock</span></span>
                        <input type="password"
                               id="password"
                               class="so-form-control"
                               placeholder="Enter your password"
                               autocomplete="current-password"
                               required>
                        <button type="button" class="so-input-action so-password-toggle" id="togglePassword">
                            <span class="material-icons">visibility</span>
                        </button>
                    </div>
                    <span class="so-form-error" id="passwordError">
                        <span class="material-icons">error</span>
                        Password is required
                    </span>
                </div>

                <!-- Remember & Forgot -->
                <div class="so-auth-options">
                    <label class="so-checkbox so-checkbox-primary">
                        <input type="checkbox" id="rememberMe">
                        <span class="so-checkbox-box">
                            <span class="material-icons">check</span>
                        </span>
                        <span class="so-checkbox-label">Remember me</span>
                    </label>
                    <a href="forgot-password.php" class="so-auth-forgot-link">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="so-btn so-btn-primary so-btn-lg so-btn-block" id="loginBtn">
                    Sign In
                </button>
            </form>

            <!-- Footer -->
            <div class="so-auth-footer">
                <p class="so-auth-footer-text">
                    Don't have an account?
                    <a href="#" class="so-auth-footer-link">Contact Admin</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- SixOrbit UI JavaScript -->
<script src="<?= so_asset('js', 'sixorbit-full') ?>"></script>
<!-- Auth Page JavaScript -->
<?php if ($authJs = so_page_asset('auth', 'js')): ?>
<script src="<?= $authJs ?>"></script>
<?php endif; ?>

<script>
// Auth configuration
window.authConfig = {
    customerName: '<?= DEMO_COMPANY_NAME ?>',
    customerInitials: '<?= DEMO_COMPANY_INITIALS ?>',
    customerLogo: null,
    features: [], // Using hardcoded HTML slides
    carouselInterval: 5000
};

// Initialize auth
document.addEventListener('DOMContentLoaded', function() {
    const auth = new SOAuth({
        ...window.authConfig,
        onLogin: function(data) {
            // Simulate login
            setTimeout(function() {
                auth.completeLogin({
                    remember: document.getElementById('rememberMe').checked,
                    loginId: data.loginId,
                    loginType: data.loginType,
                    redirectUrl: 'index.php'
                });
            }, 1500);
        }
    });
});
</script>

</body>
</html>
