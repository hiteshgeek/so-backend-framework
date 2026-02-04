<?php
/**
 * SixOrbit UI Framework - Demo Index
 * Links to all available demo pages
 */
require_once 'includes/config.php';
$pageTitle = 'SixOrbit UI Framework - Demo Gallery';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>

    <!-- Anti-flash scripts -->
    <script>
    (function() {
        var theme = localStorage.getItem('so-theme-preference') || 'sidebar-dark';
        var effectiveTheme = theme === 'sidebar-dark' ? 'light' : (theme === 'system' ?
            (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : theme);
        document.documentElement.setAttribute('data-theme', effectiveTheme);
    })();
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- SixOrbit UI CSS -->
    <link rel="stylesheet" href="<?= so_asset('css', 'sixorbit-full') ?>">

    <style>
        .demo-gallery {
            min-height: 100vh;
            background: var(--so-page-bg);
            padding: 40px 20px;
        }

        .demo-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .demo-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .demo-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .demo-logo svg {
            width: 48px;
            height: 48px;
            color: var(--so-accent-primary);
        }

        .demo-logo-text {
            font-size: 28px;
            font-weight: 700;
            color: var(--so-text-heading);
        }

        .demo-logo-text span {
            color: var(--so-accent-primary);
        }

        .demo-subtitle {
            font-size: 16px;
            color: var(--so-text-secondary);
            margin-bottom: 24px;
        }

        .demo-version {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: var(--so-accent-primary);
            color: white;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .demo-section {
            margin-bottom: 40px;
        }

        .demo-section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--so-text-heading);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .demo-section-title .material-icons {
            color: var(--so-accent-primary);
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .demo-card {
            background: var(--so-card-bg);
            border: 1px solid var(--so-card-border);
            border-radius: 12px;
            padding: 24px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .demo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--so-accent-primary);
        }

        .demo-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .demo-card-icon.blue { background: rgba(26, 115, 232, 0.1); color: #1a73e8; }
        .demo-card-icon.green { background: rgba(52, 168, 83, 0.1); color: #34a853; }
        .demo-card-icon.purple { background: rgba(115, 103, 240, 0.1); color: #7367f0; }
        .demo-card-icon.orange { background: rgba(249, 171, 0, 0.1); color: #f9ab00; }
        .demo-card-icon.red { background: rgba(234, 67, 53, 0.1); color: #ea4335; }
        .demo-card-icon.teal { background: rgba(0, 150, 136, 0.1); color: #009688; }

        .demo-card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--so-text-heading);
        }

        .demo-card-desc {
            font-size: 13px;
            color: var(--so-text-secondary);
            line-height: 1.5;
        }

        .demo-card-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            background: rgba(52, 168, 83, 0.1);
            color: #34a853;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            width: fit-content;
        }

        .demo-footer {
            text-align: center;
            margin-top: 48px;
            padding-top: 24px;
            border-top: 1px solid var(--so-border-color);
        }

        .demo-footer-links {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 16px;
        }

        .demo-footer-link {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--so-text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .demo-footer-link:hover {
            color: var(--so-accent-primary);
        }

        .demo-footer-link .material-icons {
            font-size: 18px;
        }

        .demo-copyright {
            font-size: 13px;
            color: var(--so-text-muted);
        }

        /* Theme Toggle */
        .demo-theme-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--so-card-bg);
            border: 1px solid var(--so-border-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--so-text-primary);
        }

        .demo-theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="demo-gallery">
        <div class="demo-container">
            <!-- Header -->
            <div class="demo-header">
                <div class="demo-logo">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="24" cy="24" rx="22" ry="10" stroke="currentColor" stroke-width="2" fill="none" transform="rotate(-20 24 24)" opacity="0.6"/>
                        <path d="M24 6L38.7 15V33L24 42L9.3 33V15L24 6Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                        <circle cx="24" cy="24" r="4" fill="currentColor"/>
                        <circle cx="42" cy="18" r="2.5" fill="currentColor"/>
                        <circle cx="6" cy="30" r="2.5" fill="currentColor"/>
                    </svg>
                    <span class="demo-logo-text">Six<span>Orbit</span> UI</span>
                </div>
                <p class="demo-subtitle">A modern, modular UI framework for enterprise applications</p>
                <div class="demo-version">
                    <span class="material-icons" style="font-size: 16px;">verified</span>
                    Version <?= SO_VERSION ?>
                </div>
            </div>

            <!-- Main Application Pages -->
            <div class="demo-section">
                <h2 class="demo-section-title">
                    <span class="material-icons">dashboard</span>
                    Application Pages
                </h2>
                <div class="demo-grid">
                    <a href="index.php" class="demo-card">
                        <div class="demo-card-icon blue">
                            <span class="material-icons">dashboard</span>
                        </div>
                        <div class="demo-card-title">Dashboard</div>
                        <div class="demo-card-desc">Main dashboard with stats, charts, transactions, and quick actions</div>
                    </a>

                    <a href="form-elements.php" class="demo-card">
                        <div class="demo-card-icon purple">
                            <span class="material-icons">input</span>
                        </div>
                        <div class="demo-card-title">Form Elements</div>
                        <div class="demo-card-desc">Complete form components showcase - inputs, buttons, dropdowns, toggles</div>
                    </a>

                    <a href="video-tutorial.php" class="demo-card">
                        <div class="demo-card-icon green">
                            <span class="material-icons">play_circle</span>
                        </div>
                        <div class="demo-card-title">Video Tutorials</div>
                        <div class="demo-card-desc">LMS-style video course listing with categories and progress tracking</div>
                        <span class="demo-card-badge">
                            <span class="material-icons" style="font-size: 12px;">star</span>
                            New
                        </span>
                    </a>
                </div>
            </div>

            <!-- Finance Reports -->
            <div class="demo-section">
                <h2 class="demo-section-title">
                    <span class="material-icons">account_balance</span>
                    Finance Reports
                </h2>
                <div class="demo-grid">
                    <a href="profit-loss.php" class="demo-card">
                        <div class="demo-card-icon green">
                            <span class="material-icons">trending_up</span>
                        </div>
                        <div class="demo-card-title">Profit & Loss</div>
                        <div class="demo-card-desc">Income and expense analysis with detailed breakdown</div>
                    </a>

                    <a href="balance-sheet.php" class="demo-card">
                        <div class="demo-card-icon blue">
                            <span class="material-icons">account_balance_wallet</span>
                        </div>
                        <div class="demo-card-title">Balance Sheet</div>
                        <div class="demo-card-desc">Assets, liabilities, and equity statement</div>
                    </a>

                    <a href="cash-flow.php" class="demo-card">
                        <div class="demo-card-icon teal">
                            <span class="material-icons">payments</span>
                        </div>
                        <div class="demo-card-title">Cash Flow</div>
                        <div class="demo-card-desc">Cash flow summary with operating, investing, and financing activities</div>
                    </a>

                    <a href="trial-balance.php" class="demo-card">
                        <div class="demo-card-icon orange">
                            <span class="material-icons">receipt_long</span>
                        </div>
                        <div class="demo-card-title">Trial Balance</div>
                        <div class="demo-card-desc">Debit and credit balance verification report</div>
                    </a>
                </div>
            </div>

            <!-- Authentication Pages -->
            <div class="demo-section">
                <h2 class="demo-section-title">
                    <span class="material-icons">lock</span>
                    Authentication
                </h2>
                <div class="demo-grid">
                    <a href="login.php" class="demo-card">
                        <div class="demo-card-icon purple">
                            <span class="material-icons">login</span>
                        </div>
                        <div class="demo-card-title">Login</div>
                        <div class="demo-card-desc">Login page with email/mobile toggle and feature carousel</div>
                    </a>

                    <a href="forgot-password.php" class="demo-card">
                        <div class="demo-card-icon red">
                            <span class="material-icons">vpn_key</span>
                        </div>
                        <div class="demo-card-title">Forgot Password</div>
                        <div class="demo-card-desc">Multi-step password reset with OTP verification</div>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="demo-footer">
                <div class="demo-footer-links">
                    <a href="https://github.com/sixorbit/sixorbit-ui" class="demo-footer-link" target="_blank">
                        <span class="material-icons">code</span>
                        View Source
                    </a>
                    <a href="#" class="demo-footer-link">
                        <span class="material-icons">description</span>
                        Documentation
                    </a>
                    <a href="https://sixorbit.com" class="demo-footer-link" target="_blank">
                        <span class="material-icons">public</span>
                        SixOrbit.com
                    </a>
                </div>
                <p class="demo-copyright">
                    &copy; <?= date('Y') ?> SixOrbit. Built with care for enterprise applications.
                </p>
            </div>
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <button class="demo-theme-toggle" id="themeToggle" title="Toggle Theme">
        <span class="material-icons" id="themeIcon">dark_mode</span>
    </button>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        function updateThemeIcon() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            themeIcon.textContent = currentTheme === 'dark' ? 'light_mode' : 'dark_mode';
        }

        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('so-theme-preference', newTheme);
            updateThemeIcon();
        });

        updateThemeIcon();
    </script>
</body>
</html>
