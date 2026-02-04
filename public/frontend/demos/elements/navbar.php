<?php
/**
 * SixOrbit UI Demo - Navbar
 */
$pageTitle = 'Navbar';
$pageDescription = 'Navigation bar component';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Navbar</h1>
            <p class="so-page-subtitle">Navigation bar component</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Section 1: Basic Navbar -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Navbar</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">A simple navbar with brand, navigation links, and responsive collapse behavior.</p>

                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <span class="material-icons so-text-primary">dashboard</span>
                                    SixOrbit
                                </a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" aria-label="Toggle navigation" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link so-active">Home</a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">Features</a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">Pricing</a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link so-disabled">Disabled</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <?= so_code_block('<nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg">
    <div class="so-component-navbar-container">
        <a href="#" class="so-component-navbar-brand">
            <span class="material-icons so-text-primary">dashboard</span>
            SixOrbit
        </a>
        <button class="so-component-navbar-toggler" type="button">
            <span class="so-component-navbar-toggler-icon"></span>
        </button>
        <div class="so-component-navbar-collapse">
            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                <li class="so-component-navbar-item">
                    <a href="#" class="so-component-navbar-link so-active">Home</a>
                </li>
                <li class="so-component-navbar-item">
                    <a href="#" class="so-component-navbar-link">Features</a>
                </li>
                <li class="so-component-navbar-item">
                    <a href="#" class="so-component-navbar-link">Pricing</a>
                </li>
                <li class="so-component-navbar-item">
                    <a href="#" class="so-component-navbar-link so-disabled">Disabled</a>
                </li>
            </ul>
        </div>
    </div>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Section 2: Color Themes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Color Themes</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Navbars come in various color themes including light, dark, and all semantic colors.</p>

                        <!-- Light Theme -->
                        <h6 class="so-mb-2 so-text-muted">Light Theme (Default)</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Light</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Dark Theme -->
                        <h6 class="so-mb-2 so-text-muted">Dark Theme</h6>
                        <nav class="so-component-navbar so-component-navbar-dark so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Dark</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Primary -->
                        <h6 class="so-mb-2 so-text-muted">Primary</h6>
                        <nav class="so-component-navbar so-component-navbar-primary so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Primary</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Secondary -->
                        <h6 class="so-mb-2 so-text-muted">Secondary</h6>
                        <nav class="so-component-navbar so-component-navbar-secondary so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Secondary</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Success -->
                        <h6 class="so-mb-2 so-text-muted">Success</h6>
                        <nav class="so-component-navbar so-component-navbar-success so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Success</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Danger -->
                        <h6 class="so-mb-2 so-text-muted">Danger</h6>
                        <nav class="so-component-navbar so-component-navbar-danger so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Danger</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Warning -->
                        <h6 class="so-mb-2 so-text-muted">Warning</h6>
                        <nav class="so-component-navbar so-component-navbar-warning so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Warning</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Info -->
                        <h6 class="so-mb-2 so-text-muted">Info</h6>
                        <nav class="so-component-navbar so-component-navbar-info so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Info</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <?= so_code_block('<!-- Light -->
<nav class="so-component-navbar so-component-navbar-light">...</nav>

<!-- Dark -->
<nav class="so-component-navbar so-component-navbar-dark">...</nav>

<!-- Primary -->
<nav class="so-component-navbar so-component-navbar-primary">...</nav>

<!-- Secondary -->
<nav class="so-component-navbar so-component-navbar-secondary">...</nav>

<!-- Success -->
<nav class="so-component-navbar so-component-navbar-success">...</nav>

<!-- Danger -->
<nav class="so-component-navbar so-component-navbar-danger">...</nav>

<!-- Warning -->
<nav class="so-component-navbar so-component-navbar-warning">...</nav>

<!-- Info -->
<nav class="so-component-navbar so-component-navbar-info">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Section 3: Brand Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Brand Variants</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">The brand area supports text, images, icons, or combinations.</p>

                        <!-- Text Only -->
                        <h6 class="so-mb-2 so-text-muted">Text Only</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">SixOrbit ERP</a>
                            </div>
                        </nav>

                        <!-- Icon + Text -->
                        <h6 class="so-mb-2 so-text-muted">Icon + Text</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <span class="material-icons so-text-primary">rocket_launch</span>
                                    SixOrbit
                                </a>
                            </div>
                        </nav>

                        <!-- Image Logo -->
                        <h6 class="so-mb-2 so-text-muted">Image Logo (Inline SVG)</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" rx="6" fill="#1a73e8"/>
                                        <text x="50%" y="50%" dominant-baseline="central" text-anchor="middle" fill="white" font-size="12" font-weight="bold">SO</text>
                                    </svg>
                                    SixOrbit
                                </a>
                            </div>
                        </nav>

                        <?= so_code_block('<!-- Text Only -->
<a href="#" class="so-component-navbar-brand">SixOrbit ERP</a>

<!-- Icon + Text -->
<a href="#" class="so-component-navbar-brand">
    <span class="material-icons so-text-primary">rocket_launch</span>
    SixOrbit
</a>

<!-- Image Logo -->
<a href="#" class="so-component-navbar-brand">
    <img src="logo.png" alt="Logo">
    SixOrbit
</a>', 'html') ?>
                    </div>
                </div>

                <!-- Section 4: With Dropdowns -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Navbar with Dropdowns</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Integrate dropdown menus into the navbar navigation. Click on dropdown items to toggle.</p>

                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <span class="material-icons so-text-primary">dashboard</span>
                                    SixOrbit
                                </a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link so-active">Dashboard</a>
                                        </li>
                                        <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                                            <a href="#" class="so-component-navbar-link so-dropdown-toggle">
                                                Products
                                                <span class="material-icons so-dropdown-arrow">expand_more</span>
                                            </a>
                                            <div class="so-dropdown-menu">
                                                <a href="#" class="so-dropdown-item">
                                                    <span class="material-icons">inventory_2</span>
                                                    All Products
                                                </a>
                                                <a href="#" class="so-dropdown-item">
                                                    <span class="material-icons">add_box</span>
                                                    Add New
                                                </a>
                                                <a href="#" class="so-dropdown-item">
                                                    <span class="material-icons">category</span>
                                                    Categories
                                                </a>
                                                <div class="so-dropdown-divider"></div>
                                                <a href="#" class="so-dropdown-item">
                                                    <span class="material-icons">archive</span>
                                                    Archived
                                                </a>
                                            </div>
                                        </li>
                                        <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                                            <a href="#" class="so-component-navbar-link so-dropdown-toggle">
                                                Reports
                                                <span class="material-icons so-dropdown-arrow">expand_more</span>
                                            </a>
                                            <div class="so-dropdown-menu">
                                                <a href="#" class="so-dropdown-item">Sales Report</a>
                                                <a href="#" class="so-dropdown-item">Inventory Report</a>
                                                <a href="#" class="so-dropdown-item">Analytics</a>
                                            </div>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">Settings</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <?= so_code_block('<li class="so-component-navbar-item so-dropdown" data-so-dropdown>
    <a href="#" class="so-component-navbar-link so-dropdown-toggle">
        Products
    </a>
    <div class="so-dropdown-menu">
        <a href="#" class="so-dropdown-item">
            <span class="material-icons">inventory_2</span>
            All Products
        </a>
        <a href="#" class="so-dropdown-item">
            <span class="material-icons">add_box</span>
            Add New
        </a>
        <div class="so-dropdown-divider"></div>
        <a href="#" class="so-dropdown-item">
            <span class="material-icons">archive</span>
            Archived
        </a>
    </div>
</li>', 'html') ?>
                    </div>
                </div>

                <!-- Section 5: Search & Forms -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Search & Forms</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Integrate search inputs, forms, and action buttons in the navbar.</p>

                        <!-- Search + Buttons -->
                        <h6 class="so-mb-2 so-text-muted">With Search & Buttons</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <span class="material-icons so-text-primary">dashboard</span>
                                    SixOrbit
                                </a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link so-active">Home</a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">Features</a>
                                        </li>
                                    </ul>
                                    <form class="so-component-navbar-form so-component-navbar-nav-end">
                                        <div class="so-component-navbar-search">
                                            <span class="material-icons search-icon">search</span>
                                            <input type="search" class="so-form-control" placeholder="Search...">
                                        </div>
                                        <button type="submit" class="so-btn so-btn-primary">Search</button>
                                    </form>
                                </div>
                            </div>
                        </nav>

                        <!-- Login/Signup Buttons -->
                        <h6 class="so-mb-2 so-text-muted">With Auth Buttons</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">SixOrbit</a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">Features</a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">Pricing</a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">About</a>
                                        </li>
                                    </ul>
                                    <div class="so-component-navbar-nav so-component-navbar-nav-end so-gap-2">
                                        <a href="#" class="so-btn so-btn-outline-primary">Login</a>
                                        <a href="#" class="so-btn so-btn-primary">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </nav>

                        <?= so_code_block('<!-- Search Form -->
<form class="so-component-navbar-form so-component-navbar-nav-end">
    <div class="so-component-navbar-search">
        <span class="material-icons search-icon">search</span>
        <input type="search" class="so-form-control" placeholder="Search...">
    </div>
    <button type="submit" class="so-btn so-btn-primary">Search</button>
</form>

<!-- Auth Buttons -->
<div class="so-component-navbar-nav so-component-navbar-nav-end so-gap-2">
    <a href="#" class="so-btn so-btn-outline-primary">Login</a>
    <a href="#" class="so-btn so-btn-primary">Sign Up</a>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Section 6: Badges & Icons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Badges & Icons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add badges for notifications and icons for visual clarity.</p>

                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <span class="material-icons so-text-primary">dashboard</span>
                                    SixOrbit
                                </a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link so-active">
                                                <span class="material-icons">home</span>
                                                Home
                                            </a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">mail</span>
                                                Messages
                                                <span class="so-badge so-badge-danger">5</span>
                                            </a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">notifications</span>
                                                Alerts
                                                <span class="so-badge so-badge-warning">New</span>
                                            </a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">shopping_cart</span>
                                                Cart
                                                <span class="so-badge so-badge-primary">3</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-end">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">account_circle</span>
                                                Profile
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <?= so_code_block('<a href="#" class="so-component-navbar-link">
    <span class="material-icons">mail</span>
    Messages
    <span class="so-badge so-badge-danger">5</span>
</a>

<a href="#" class="so-component-navbar-link">
    <span class="material-icons">notifications</span>
    Alerts
    <span class="so-badge so-badge-warning">New</span>
</a>', 'html') ?>
                    </div>
                </div>

                <!-- Section 7: Visual Modifiers -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Visual Modifiers</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add shadows, borders, or make the navbar transparent.</p>

                        <!-- With Shadow -->
                        <h6 class="so-mb-2 so-text-muted">With Shadow</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-component-navbar-shadow so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Shadow Navbar</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- With Border -->
                        <h6 class="so-mb-2 so-text-muted">With Border</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-component-navbar-bordered so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Bordered Navbar</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Transparent (on dark background) -->
                        <h6 class="so-mb-2 so-text-muted">Transparent (for hero sections)</h6>
                        <div class="so-p-4 so-rounded-lg" style="background: linear-gradient(135deg, #1a73e8, #174ea6);">
                            <nav class="so-component-navbar so-component-navbar-dark so-component-navbar-expand so-component-navbar-transparent">
                                <div class="so-component-navbar-container">
                                    <a href="#" class="so-component-navbar-brand">Transparent</a>
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>

                        <?= so_code_block('<!-- With Shadow -->
<nav class="so-component-navbar so-component-navbar-light so-component-navbar-shadow">...</nav>

<!-- With Border -->
<nav class="so-component-navbar so-component-navbar-light so-component-navbar-bordered">...</nav>

<!-- Transparent -->
<nav class="so-component-navbar so-component-navbar-dark so-component-navbar-transparent">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Section 8: Responsive Breakpoints -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Responsive Breakpoints</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Control at which breakpoint the navbar expands from collapsed mobile view to full desktop view.</p>

                        <div class="so-alert so-alert-info so-mb-4">
                            <span class="material-icons">info</span>
                            <div>
                                <strong>Tip:</strong> Resize your browser window to see the collapse behavior at different breakpoints.
                            </div>
                        </div>

                        <!-- Expand SM -->
                        <h6 class="so-mb-2 so-text-muted">Expand at SM (576px)</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-sm so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Expand SM</a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <!-- Expand MD -->
                        <h6 class="so-mb-2 so-text-muted">Expand at MD (768px)</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-md so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Expand MD</a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <!-- Expand LG -->
                        <h6 class="so-mb-2 so-text-muted">Expand at LG (1024px) - Default</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Expand LG</a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <!-- Always Expanded -->
                        <h6 class="so-mb-2 so-text-muted">Always Expanded (Never Collapse)</h6>
                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Always Expand</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Contact</a></li>
                                </ul>
                            </div>
                        </nav>

                        <?= so_code_block('<!-- Expand at SM (576px) -->
<nav class="so-component-navbar so-component-navbar-expand-sm">...</nav>

<!-- Expand at MD (768px) -->
<nav class="so-component-navbar so-component-navbar-expand-md">...</nav>

<!-- Expand at LG (1024px) - Recommended -->
<nav class="so-component-navbar so-component-navbar-expand-lg">...</nav>

<!-- Expand at XL (1200px) -->
<nav class="so-component-navbar so-component-navbar-expand-xl">...</nav>

<!-- Always Expanded -->
<nav class="so-component-navbar so-component-navbar-expand">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Section 9: Container Options -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Container Options</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Choose between full-width (fluid) or contained (centered with max-width) navbar layouts.</p>

                        <!-- Fluid (Default) -->
                        <h6 class="so-mb-2 so-text-muted">Fluid (Full Width) - Default</h6>
                        <nav class="so-component-navbar so-component-navbar-primary so-component-navbar-expand so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Fluid Navbar</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Contained -->
                        <h6 class="so-mb-2 so-text-muted">Contained (Centered Max-Width)</h6>
                        <nav class="so-component-navbar so-component-navbar-primary so-component-navbar-expand so-component-navbar-contained so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">Contained Navbar</a>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link so-active">Home</a></li>
                                    <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                </ul>
                            </div>
                        </nav>

                        <?= so_code_block('<!-- Fluid (Full Width) -->
<nav class="so-component-navbar">
    <div class="so-component-navbar-container">...</div>
</nav>

<!-- Contained (Centered Max-Width) -->
<nav class="so-component-navbar so-component-navbar-contained">
    <div class="so-component-navbar-container">...</div>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Section 10: Positioning -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Positioning</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Position the navbar as fixed or sticky. Below are visual demos showing how fixed positioning works.</p>

                        <div class="so-alert so-alert-warning so-mb-4">
                            <span class="material-icons">warning</span>
                            <div>
                                <strong>Note:</strong> In production, fixed-top navbars require adding padding to the body to prevent content from being hidden behind the navbar.
                            </div>
                        </div>

                        <!-- Fixed Top Demo -->
                        <h6 class="so-mb-2 so-text-muted">Fixed Top (Preview)</h6>
                        <div class="so-border so-rounded-lg so-overflow-hidden so-mb-4" style="height: 180px; position: relative; background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);">
                            <nav class="so-component-navbar so-component-navbar-primary so-component-navbar-expand" style="position: absolute; top: 0; left: 0; right: 0; z-index: 10;">
                                <div class="so-component-navbar-container">
                                    <a href="#" class="so-component-navbar-brand">Fixed Top</a>
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Home</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">About</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <div class="so-p-4 so-text-center" style="padding-top: 80px;">
                                <p class="so-text-muted so-mb-2">Content area</p>
                                <p class="so-text-muted so-text-sm">Navbar stays fixed at the top of its container</p>
                            </div>
                        </div>

                        <!-- Fixed Bottom Demo -->
                        <h6 class="so-mb-2 so-text-muted">Fixed Bottom (Preview)</h6>
                        <div class="so-border so-rounded-lg so-overflow-hidden so-mb-4" style="height: 180px; position: relative; background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);">
                            <div class="so-p-4 so-text-center">
                                <p class="so-text-muted so-mb-2">Content area</p>
                                <p class="so-text-muted so-text-sm">Navbar stays fixed at the bottom of its container</p>
                            </div>
                            <nav class="so-component-navbar so-component-navbar-dark so-component-navbar-expand" style="position: absolute; bottom: 0; left: 0; right: 0; z-index: 10;">
                                <div class="so-component-navbar-container">
                                    <a href="#" class="so-component-navbar-brand">Fixed Bottom</a>
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-end">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Contact</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Help</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>

                        <!-- Sticky Top Demo -->
                        <h6 class="so-mb-2 so-text-muted">Sticky Top (Preview - scroll inside)</h6>
                        <div class="so-border so-rounded-lg so-overflow-hidden so-mb-4" style="height: 200px; overflow-y: auto; background: #f8f9fa;">
                            <nav class="so-component-navbar so-component-navbar-success so-component-navbar-expand" style="position: sticky; top: 0; z-index: 10;">
                                <div class="so-component-navbar-container">
                                    <a href="#" class="so-component-navbar-brand">Sticky Top</a>
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Link</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <div class="so-p-4">
                                <p class="so-text-muted so-mb-3">Scroll down to see sticky behavior...</p>
                                <p class="so-text-muted so-mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <p class="so-text-muted so-mb-3">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <p class="so-text-muted so-mb-3">Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                <p class="so-text-muted so-mb-3">Duis aute irure dolor in reprehenderit in voluptate velit.</p>
                                <p class="so-text-muted">The navbar sticks to the top when you scroll past it!</p>
                            </div>
                        </div>

                        <?= so_code_block('<!-- Fixed to Top -->
<nav class="so-component-navbar so-component-navbar-fixed-top">...</nav>

<!-- Fixed to Bottom -->
<nav class="so-component-navbar so-component-navbar-fixed-bottom">...</nav>

<!-- Sticky Top (sticks on scroll) -->
<nav class="so-component-navbar so-component-navbar-sticky-top">...</nav>', 'html') ?>

                        <h6 class="so-mt-4 so-mb-2 so-text-muted">Positioning Classes</h6>
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so-component-navbar-fixed-top</code></td>
                                    <td>Fixed to the top of the viewport, stays in place during scroll</td>
                                </tr>
                                <tr>
                                    <td><code>so-component-navbar-fixed-bottom</code></td>
                                    <td>Fixed to the bottom of the viewport</td>
                                </tr>
                                <tr>
                                    <td><code>so-component-navbar-sticky-top</code></td>
                                    <td>Sticks to top when scrolling past it (position: sticky)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 11: Complete Example -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Complete Example</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">A fully-featured navbar combining multiple features.</p>

                        <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-component-navbar-shadow so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">
                                    <span class="material-icons so-text-primary">rocket_launch</span>
                                    SixOrbit ERP
                                </a>
                                <button class="so-component-navbar-toggler" type="button" aria-expanded="false" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                    <span class="so-component-navbar-toggler-icon"></span>
                                </button>
                                <div class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link so-active">
                                                <span class="material-icons">dashboard</span>
                                                Dashboard
                                            </a>
                                        </li>
                                        <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                                            <a href="#" class="so-component-navbar-link so-dropdown-toggle">
                                                <span class="material-icons">inventory_2</span>
                                                Products
                                                <span class="material-icons so-dropdown-arrow">expand_more</span>
                                            </a>
                                            <div class="so-dropdown-menu">
                                                <a href="#" class="so-dropdown-item">All Products</a>
                                                <a href="#" class="so-dropdown-item">Add New</a>
                                                <a href="#" class="so-dropdown-item">Categories</a>
                                                <div class="so-dropdown-divider"></div>
                                                <a href="#" class="so-dropdown-item">Import/Export</a>
                                            </div>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">people</span>
                                                Customers
                                            </a>
                                        </li>
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">analytics</span>
                                                Reports
                                            </a>
                                        </li>
                                    </ul>

                                    <span class="so-component-navbar-divider"></span>

                                    <form class="so-component-navbar-form">
                                        <div class="so-component-navbar-search">
                                            <span class="material-icons search-icon">search</span>
                                            <input type="search" class="so-form-control so-form-control-sm" placeholder="Search...">
                                        </div>
                                    </form>

                                    <ul class="so-component-navbar-nav so-component-navbar-nav-end">
                                        <li class="so-component-navbar-item">
                                            <a href="#" class="so-component-navbar-link">
                                                <span class="material-icons">notifications</span>
                                                <span class="so-badge so-badge-danger">3</span>
                                            </a>
                                        </li>
                                        <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                                            <a href="#" class="so-component-navbar-link so-dropdown-toggle">
                                                <span class="material-icons">account_circle</span>
                                                John Doe
                                                <span class="material-icons so-dropdown-arrow">expand_more</span>
                                            </a>
                                            <div class="so-dropdown-menu so-dropdown-menu-end">
                                                <a href="#" class="so-dropdown-item">
                                                    <span class="material-icons">person</span>
                                                    Profile
                                                </a>
                                                <a href="#" class="so-dropdown-item">
                                                    <span class="material-icons">settings</span>
                                                    Settings
                                                </a>
                                                <div class="so-dropdown-divider"></div>
                                                <a href="#" class="so-dropdown-item so-text-danger">
                                                    <span class="material-icons">logout</span>
                                                    Logout
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <?= so_code_block('<nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-component-navbar-shadow">
    <div class="so-component-navbar-container">
        <a href="#" class="so-component-navbar-brand">
            <span class="material-icons so-text-primary">rocket_launch</span>
            SixOrbit ERP
        </a>
        <button class="so-component-navbar-toggler" type="button">
            <span class="so-component-navbar-toggler-icon"></span>
        </button>
        <div class="so-component-navbar-collapse">
            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                <li class="so-component-navbar-item">
                    <a href="#" class="so-component-navbar-link so-active">
                        <span class="material-icons">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                    <a href="#" class="so-component-navbar-link so-dropdown-toggle">
                        <span class="material-icons">inventory_2</span>
                        Products
                    </a>
                    <div class="so-dropdown-menu">
                        <a href="#" class="so-dropdown-item">All Products</a>
                        <a href="#" class="so-dropdown-item">Add New</a>
                    </div>
                </li>
            </ul>

            <span class="so-component-navbar-divider"></span>

            <form class="so-component-navbar-form">
                <div class="so-component-navbar-search">
                    <span class="material-icons search-icon">search</span>
                    <input type="search" class="so-form-control" placeholder="Search...">
                </div>
            </form>

            <ul class="so-component-navbar-nav so-component-navbar-nav-end">
                <li class="so-component-navbar-item">
                    <a href="#" class="so-component-navbar-link">
                        <span class="material-icons">notifications</span>
                        <span class="so-badge so-badge-danger">3</span>
                    </a>
                </li>
                <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                    <a href="#" class="so-component-navbar-link so-dropdown-toggle">
                        <span class="material-icons">account_circle</span>
                        John Doe
                    </a>
                    <div class="so-dropdown-menu dropdown-menu-end">
                        <a href="#" class="so-dropdown-item">Profile</a>
                        <a href="#" class="so-dropdown-item">Settings</a>
                        <div class="so-dropdown-divider"></div>
                        <a href="#" class="so-dropdown-item so-text-danger">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Section 12: Mobile Offcanvas Menu -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Mobile Offcanvas Menu</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Slide-out menus from left or right side for mobile navigation. Click the buttons to see offcanvas menus in action.</p>

                        <div class="so-d-flex so-gap-3 so-mb-4">
                            <!-- Left Side Button -->
                            <button class="so-btn so-btn-primary" onclick="document.getElementById('demo-offcanvas-left').classList.add('so-show'); document.getElementById('demo-offcanvas-backdrop').classList.add('so-show');">
                                <span class="material-icons so-mr-2">menu</span>
                                Open Left Menu
                            </button>

                            <!-- Right Side Button -->
                            <button class="so-btn so-btn-secondary" onclick="document.getElementById('demo-offcanvas-right').classList.add('so-show'); document.getElementById('demo-offcanvas-backdrop').classList.add('so-show');">
                                <span class="material-icons so-mr-2">menu_open</span>
                                Open Right Menu
                            </button>
                        </div>

                        <!-- Offcanvas Left -->
                        <div id="demo-offcanvas-left" class="so-component-navbar-offcanvas">
                            <div class="so-component-navbar-offcanvas-header">
                                <h5 class="so-component-navbar-offcanvas-title">
                                    <span class="material-icons so-text-primary so-mr-2">dashboard</span>
                                    SixOrbit
                                </h5>
                                <button class="so-component-navbar-offcanvas-close" onclick="document.getElementById('demo-offcanvas-left').classList.remove('so-show'); document.getElementById('demo-offcanvas-backdrop').classList.remove('so-show');">
                                    <span class="material-icons">close</span>
                                </button>
                            </div>
                            <div class="so-component-navbar-offcanvas-body">
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link so-active">
                                            <span class="material-icons">home</span>
                                            Home
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">inventory_2</span>
                                            Products
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">people</span>
                                            Customers
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">analytics</span>
                                            Reports
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">settings</span>
                                            Settings
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Offcanvas Right -->
                        <div id="demo-offcanvas-right" class="so-component-navbar-offcanvas so-component-navbar-offcanvas-end">
                            <div class="so-component-navbar-offcanvas-header">
                                <h5 class="so-component-navbar-offcanvas-title">
                                    <span class="material-icons so-text-primary so-mr-2">account_circle</span>
                                    Account
                                </h5>
                                <button class="so-component-navbar-offcanvas-close" onclick="document.getElementById('demo-offcanvas-right').classList.remove('so-show'); document.getElementById('demo-offcanvas-backdrop').classList.remove('so-show');">
                                    <span class="material-icons">close</span>
                                </button>
                            </div>
                            <div class="so-component-navbar-offcanvas-body">
                                <div class="so-text-center so-mb-4">
                                    <div class="so-avatar so-avatar-xl so-mb-2" style="width: 80px; height: 80px; background: #e3f2fd; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <span class="material-icons so-text-primary" style="font-size: 40px;">person</span>
                                    </div>
                                    <h6 class="so-mb-1">John Doe</h6>
                                    <p class="so-text-muted so-text-sm">john@sixorbit.com</p>
                                </div>
                                <ul class="so-component-navbar-nav">
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">person</span>
                                            My Profile
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">notifications</span>
                                            Notifications
                                            <span class="so-badge so-badge-danger so-ml-auto">5</span>
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link">
                                            <span class="material-icons">settings</span>
                                            Settings
                                        </a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a href="#" class="so-component-navbar-link so-text-danger">
                                            <span class="material-icons">logout</span>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Shared Backdrop -->
                        <div id="demo-offcanvas-backdrop" class="so-component-navbar-offcanvas-backdrop" onclick="document.getElementById('demo-offcanvas-left').classList.remove('so-show'); document.getElementById('demo-offcanvas-right').classList.remove('so-show'); this.classList.remove('so-show');"></div>

                        <?= so_code_block('<!-- Left Side Offcanvas (Default) -->
<div class="so-component-navbar-offcanvas">
    <div class="so-component-navbar-offcanvas-header">
        <h5 class="so-component-navbar-offcanvas-title">Menu</h5>
        <button class="so-component-navbar-offcanvas-close">
            <span class="material-icons">close</span>
        </button>
    </div>
    <div class="so-component-navbar-offcanvas-body">
        <ul class="so-component-navbar-nav">
            <li class="so-component-navbar-item">
                <a href="#" class="so-component-navbar-link">Link</a>
            </li>
        </ul>
    </div>
</div>

<!-- Right Side Offcanvas -->
<div class="so-component-navbar-offcanvas so-component-navbar-offcanvas-end">
    ...
</div>

<!-- Backdrop -->
<div class="so-component-navbar-offcanvas-backdrop"></div>', 'html') ?>

                        <h6 class="so-mt-4 so-mb-2 so-text-muted">Offcanvas Position Classes</h6>
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so-component-navbar-offcanvas</code></td>
                                    <td>Base offcanvas (left side by default)</td>
                                </tr>
                                <tr>
                                    <td><code>so-component-navbar-offcanvas-start</code></td>
                                    <td>Explicit left-side positioning</td>
                                </tr>
                                <tr>
                                    <td><code>so-component-navbar-offcanvas-end</code></td>
                                    <td>Right-side positioning</td>
                                </tr>
                                <tr>
                                    <td><code>so-component-navbar-offcanvas-full</code></td>
                                    <td>Full-width offcanvas</td>
                                </tr>
                                <tr>
                                    <td><code>show</code></td>
                                    <td>Add to show the offcanvas</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 13: Animated Hamburger Menu -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Animated Hamburger Menu</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Beautiful hamburger icon animations with smooth transitions. Inspired by <a href="https://codepen.io/RRoberts/pen/ZBYaJr" target="_blank" rel="noopener">CodePen by RRoberts</a>. Click each icon to see the animation.</p>

                        <div class="so-d-flex so-flex-wrap so-gap-6 so-mb-6">
                            <!-- Squeeze -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Squeeze</p>
                            </div>

                            <!-- Spin -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--spin" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Spin</p>
                            </div>

                            <!-- Elastic -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--elastic" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Elastic</p>
                            </div>

                            <!-- Arrow -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--arrow" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Arrow</p>
                            </div>

                            <!-- Collapse -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--collapse" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Collapse</p>
                            </div>
                        </div>

                        <!-- Size Variants -->
                        <h6 class="so-mb-3 so-text-muted">Size Variants</h6>
                        <div class="so-d-flex so-flex-wrap so-align-items-center so-gap-6 so-mb-6">
                            <!-- Small -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--squeeze so-hamburger--sm" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Small</p>
                            </div>

                            <!-- Default -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Default</p>
                            </div>

                            <!-- Large -->
                            <div class="so-text-center">
                                <button class="so-hamburger so-hamburger--squeeze so-hamburger--lg" type="button" onclick="this.classList.toggle('is-active')">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <p class="so-text-sm so-text-muted so-mt-2">Large</p>
                            </div>
                        </div>

                        <!-- On Different Backgrounds -->
                        <h6 class="so-mb-3 so-text-muted">On Different Backgrounds</h6>
                        <div class="so-d-flex so-flex-wrap so-gap-4 so-mb-6">
                            <div class="so-p-3 so-rounded-lg" style="background: #f5f5f5;">
                                <button class="so-hamburger so-hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active')" style="color: #333;">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="so-p-3 so-rounded-lg" style="background: #1a73e8;">
                                <button class="so-hamburger so-hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active')" style="color: white;">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="so-p-3 so-rounded-lg" style="background: #34a853;">
                                <button class="so-hamburger so-hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active')" style="color: white;">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="so-p-3 so-rounded-lg" style="background: #333;">
                                <button class="so-hamburger so-hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active')" style="color: white;">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Integration Example -->
                        <h6 class="so-mb-3 so-text-muted">Navbar Integration</h6>
                        <nav class="so-component-navbar so-component-navbar-primary so-mb-4">
                            <div class="so-component-navbar-container">
                                <a href="#" class="so-component-navbar-brand">SixOrbit</a>
                                <button class="so-hamburger so-hamburger--squeeze" type="button" style="color: white;" onclick="this.classList.toggle('is-active'); document.getElementById('demo-hamburger-collapse').classList.toggle('so-show');">
                                    <span class="so-hamburger-box">
                                        <span class="so-hamburger-inner"></span>
                                    </span>
                                </button>
                                <div id="demo-hamburger-collapse" class="so-component-navbar-collapse">
                                    <ul class="so-component-navbar-nav">
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Home</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">About</a></li>
                                        <li class="so-component-navbar-item"><a href="#" class="so-component-navbar-link">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <?= so_code_block('<!-- Squeeze Animation -->
<button class="so-hamburger so-hamburger--squeeze" type="button">
    <span class="so-hamburger-box">
        <span class="so-hamburger-inner"></span>
    </span>
</button>

<!-- Spin Animation -->
<button class="so-hamburger so-hamburger--spin">...</button>

<!-- Elastic Animation -->
<button class="so-hamburger so-hamburger--elastic">...</button>

<!-- Arrow Animation -->
<button class="so-hamburger so-hamburger--arrow">...</button>

<!-- Collapse Animation -->
<button class="so-hamburger so-hamburger--collapse">...</button>

<!-- Size Variants -->
<button class="so-hamburger so-hamburger--squeeze so-hamburger--sm">...</button>
<button class="so-hamburger so-hamburger--squeeze so-hamburger--lg">...</button>

<!-- Toggle active state with JavaScript -->
<script>
hamburger.addEventListener(\'click\', function() {
    this.classList.toggle(\'is-active\');
});
</script>', 'html') ?>

                        <h6 class="so-mt-4 so-mb-2 so-text-muted">Hamburger Classes</h6>
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so-hamburger</code></td>
                                    <td>Base hamburger button</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--squeeze</code></td>
                                    <td>Squeeze to X animation</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--spin</code></td>
                                    <td>Spin to X animation</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--elastic</code></td>
                                    <td>Elastic bounce animation</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--arrow</code></td>
                                    <td>Transform to arrow animation</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--collapse</code></td>
                                    <td>Collapse animation</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--sm</code></td>
                                    <td>Small size variant</td>
                                </tr>
                                <tr>
                                    <td><code>so-hamburger--lg</code></td>
                                    <td>Large size variant</td>
                                </tr>
                                <tr>
                                    <td><code>is-active</code></td>
                                    <td>Active state (shows X)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 14: CSS Classes Reference -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">CSS Classes Reference</h3>
                    </div>
                    <div class="so-card-body">
                        <h6 class="so-mb-3">Structure Classes</h6>
                        <table class="so-table so-mb-4">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><code>so-component-navbar</code></td><td>Base navbar wrapper</td></tr>
                                <tr><td><code>so-component-navbar-container</code></td><td>Inner container for content</td></tr>
                                <tr><td><code>so-component-navbar-brand</code></td><td>Brand/logo area</td></tr>
                                <tr><td><code>so-component-navbar-nav</code></td><td>Navigation items wrapper</td></tr>
                                <tr><td><code>so-component-navbar-item</code></td><td>Individual nav item</td></tr>
                                <tr><td><code>so-component-navbar-link</code></td><td>Nav link</td></tr>
                                <tr><td><code>so-component-navbar-text</code></td><td>Plain text content</td></tr>
                                <tr><td><code>so-component-navbar-divider</code></td><td>Vertical divider</td></tr>
                                <tr><td><code>so-component-navbar-toggler</code></td><td>Mobile hamburger toggle</td></tr>
                                <tr><td><code>so-component-navbar-collapse</code></td><td>Collapsible content area</td></tr>
                                <tr><td><code>so-component-navbar-form</code></td><td>Form wrapper</td></tr>
                                <tr><td><code>so-component-navbar-search</code></td><td>Search input with icon</td></tr>
                            </tbody>
                        </table>

                        <h6 class="so-mb-3">Color Classes</h6>
                        <table class="so-table so-mb-4">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><code>so-component-navbar-light</code></td><td>Light background, dark text</td></tr>
                                <tr><td><code>so-component-navbar-dark</code></td><td>Dark background, light text</td></tr>
                                <tr><td><code>so-component-navbar-primary</code></td><td>Primary color background</td></tr>
                                <tr><td><code>so-component-navbar-secondary</code></td><td>Secondary color background</td></tr>
                                <tr><td><code>so-component-navbar-success</code></td><td>Success color background</td></tr>
                                <tr><td><code>so-component-navbar-danger</code></td><td>Danger color background</td></tr>
                                <tr><td><code>so-component-navbar-warning</code></td><td>Warning color background</td></tr>
                                <tr><td><code>so-component-navbar-info</code></td><td>Info color background</td></tr>
                            </tbody>
                        </table>

                        <h6 class="so-mb-3">Modifier Classes</h6>
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><code>so-component-navbar-expand-{sm|md|lg|xl}</code></td><td>Expand at breakpoint</td></tr>
                                <tr><td><code>so-component-navbar-expand</code></td><td>Always expanded</td></tr>
                                <tr><td><code>so-component-navbar-fixed-top</code></td><td>Fixed to top</td></tr>
                                <tr><td><code>so-component-navbar-fixed-bottom</code></td><td>Fixed to bottom</td></tr>
                                <tr><td><code>so-component-navbar-sticky-top</code></td><td>Sticky positioning</td></tr>
                                <tr><td><code>so-component-navbar-contained</code></td><td>Centered with max-width</td></tr>
                                <tr><td><code>so-component-navbar-shadow</code></td><td>Add drop shadow</td></tr>
                                <tr><td><code>so-component-navbar-bordered</code></td><td>Add bottom border</td></tr>
                                <tr><td><code>so-component-navbar-transparent</code></td><td>Transparent background</td></tr>
                                <tr><td><code>so-component-navbar-nav-start</code></td><td>Align nav to start</td></tr>
                                <tr><td><code>so-component-navbar-nav-end</code></td><td>Align nav to end</td></tr>
                                <tr><td><code>so-component-navbar-nav-center</code></td><td>Center nav items</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
