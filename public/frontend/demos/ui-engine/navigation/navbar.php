<?php
/**
 * SixOrbit UI Engine - Navbar Element Demo
 */

$pageTitle = 'Navbar - UI Engine';
$pageDescription = 'Responsive navigation header with branding and navigation';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Navbar</h1>
            <p class="so-page-subtitle">Responsive navigation header with branding, navigation links, and action items.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Navbar -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Navbar</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Brand</a>
                        <button class="so-component-navbar-toggler" type="button" aria-expanded="false" aria-label="Toggle navigation" onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                            <span class="so-component-navbar-toggler-icon"></span>
                        </button>
                        <div class="so-component-navbar-collapse">
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link so-active" href="#">Home</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">Features</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">Pricing</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-navbar', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$navbar = UiEngine::navbar()
    ->brand('Brand', '/')
    ->item('Home', '/', ['active' => true])
    ->item('Features', '/features')
    ->item('Pricing', '/pricing');

echo \$navbar->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const navbar = UiEngine.navbar()
    .brand('Brand', '/')
    .item('Home', '/', {active: true})
    .item('Features', '/features')
    .item('Pricing', '/pricing');

document.getElementById('header').innerHTML = navbar.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg">
    <div class="so-component-navbar-container">
        <a class="so-component-navbar-brand" href="/">Brand</a>
        <button class="so-component-navbar-toggler" type="button">
            <span class="so-component-navbar-toggler-icon"></span>
        </button>
        <div class="so-component-navbar-collapse">
            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                <li class="so-component-navbar-item">
                    <a class="so-component-navbar-link so-active" href="/">Home</a>
                </li>
                <li class="so-component-navbar-item">
                    <a class="so-component-navbar-link" href="/features">Features</a>
                </li>
                <li class="so-component-navbar-item">
                    <a class="so-component-navbar-link" href="/pricing">Pricing</a>
                </li>
            </ul>
        </div>
    </div>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Logo -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Logo</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">
                            <span class="material-icons so-text-primary">hexagon</span>
                            SixOrbit
                        </a>
                        <div class="so-component-navbar-collapse">
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Products</a></li>
                                <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Solutions</a></li>
                                <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Resources</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-logo', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$navbar = UiEngine::navbar()
    ->brand('SixOrbit', '/')
    ->brandImage('/images/logo.png')  // Optional logo image
    ->item('Products', '/products')
    ->item('Solutions', '/solutions')
    ->item('Resources', '/resources');

echo \$navbar->render();

// Note: For icons in brand, use custom HTML in the brand area"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const navbar = UiEngine.navbar()
    .brand('SixOrbit', '/')
    .brandImage('/images/logo.png')
    .item('Products', '/products')
    .item('Solutions', '/solutions')
    .item('Resources', '/resources');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Schemes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Schemes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav class="so-component-navbar so-component-navbar-dark so-component-navbar-expand so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Dark Navbar</a>
                        <ul class="so-component-navbar-nav">
                            <li class="so-component-navbar-item"><a class="so-component-navbar-link so-active" href="#">Home</a></li>
                            <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Link</a></li>
                        </ul>
                    </div>
                </nav>
                <nav class="so-component-navbar so-component-navbar-primary so-component-navbar-expand so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Primary Navbar</a>
                        <ul class="so-component-navbar-nav">
                            <li class="so-component-navbar-item"><a class="so-component-navbar-link so-active" href="#">Home</a></li>
                            <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Link</a></li>
                        </ul>
                    </div>
                </nav>
                <nav class="so-component-navbar so-component-navbar-success so-component-navbar-expand so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Success Navbar</a>
                        <ul class="so-component-navbar-nav">
                            <li class="so-component-navbar-item"><a class="so-component-navbar-link so-active" href="#">Home</a></li>
                            <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Link</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Dark navbar
UiEngine::navbar()
    ->theme('dark')
    ->brand('Dark Navbar')
    ->item('Home', '/', ['active' => true])
    ->item('Link', '/link');

// Primary colored navbar
UiEngine::navbar()
    ->theme('primary')
    ->brand('Primary Navbar')
    ->item('Home', '/', ['active' => true]);

// Success colored navbar
UiEngine::navbar()
    ->theme('success')
    ->brand('Success Navbar')
    ->item('Home', '/', ['active' => true]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Dark navbar
UiEngine.navbar()
    .theme('dark')
    .brand('Dark Navbar')
    .item('Home', '/', {active: true})
    .item('Link', '/link');

// Primary colored navbar
UiEngine.navbar()
    .theme('primary')
    .brand('Primary Navbar')
    .item('Home', '/', {active: true});

// Success colored navbar
UiEngine.navbar()
    .theme('success')
    .brand('Success Navbar')
    .item('Home', '/', {active: true});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Dropdown -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Dropdown</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Brand</a>
                        <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                            <li class="so-component-navbar-item">
                                <a class="so-component-navbar-link so-active" href="#">Home</a>
                            </li>
                            <li class="so-component-navbar-item so-dropdown" data-so-dropdown>
                                <a class="so-component-navbar-link so-dropdown-toggle" href="#">
                                    Products <span class="material-icons so-dropdown-arrow">expand_more</span>
                                </a>
                                <div class="so-dropdown-menu">
                                    <a class="so-dropdown-item" href="#">Product A</a>
                                    <a class="so-dropdown-item" href="#">Product B</a>
                                    <div class="so-dropdown-divider"></div>
                                    <a class="so-dropdown-item" href="#">All Products</a>
                                </div>
                            </li>
                            <li class="so-component-navbar-item">
                                <a class="so-component-navbar-link" href="#">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-dropdown', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$navbar = UiEngine::navbar()
    ->brand('Brand', '/')
    ->item('Home', '/', ['active' => true])
    ->dropdown('Products', [
        ['label' => 'Product A', 'url' => '/products/a'],
        ['label' => 'Product B', 'url' => '/products/b'],
        ['divider' => true],
        ['label' => 'All Products', 'url' => '/products'],
    ])
    ->item('Contact', '/contact');

echo \$navbar->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const navbar = UiEngine.navbar()
    .brand('Brand', '/')
    .item('Home', '/', {active: true})
    .dropdown('Products', [
        {label: 'Product A', url: '/products/a'},
        {label: 'Product B', url: '/products/b'},
        {divider: true},
        {label: 'All Products', url: '/products'},
    ])
    .item('Contact', '/contact');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Search -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Search Form</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Brand</a>
                        <div class="so-component-navbar-collapse">
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Home</a></li>
                            </ul>
                            <form class="so-component-navbar-form so-component-navbar-nav-end" role="search">
                                <div class="so-component-navbar-search">
                                    <span class="material-icons search-icon">search</span>
                                    <input type="search" class="so-form-control" placeholder="Search...">
                                </div>
                                <button type="submit" class="so-btn so-btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-search', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Search form is added via manual HTML in the navbar collapse area
// The Navbar UiEngine class focuses on navigation items

\$navbar = UiEngine::navbar()
    ->brand('Brand', '/')
    ->item('Home', '/');

echo \$navbar->render();

// Add search form manually in the navbar-collapse section:
// <form class=\"so-component-navbar-form\" role=\"search\">
//     <input type=\"search\" class=\"so-form-control\" placeholder=\"Search...\">
//     <button type=\"submit\" class=\"so-btn so-btn-primary\">Search</button>
// </form>"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const navbar = UiEngine.navbar()
    .brand('Brand', '/')
    .item('Home', '/');

// Search form is typically added as custom HTML content
// within the navbar-collapse container"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Action Buttons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Action Buttons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav class="so-component-navbar so-component-navbar-light so-component-navbar-expand-lg so-mb-3">
                    <div class="so-component-navbar-container">
                        <a class="so-component-navbar-brand" href="#">Brand</a>
                        <div class="so-component-navbar-collapse">
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Features</a></li>
                                <li class="so-component-navbar-item"><a class="so-component-navbar-link" href="#">Pricing</a></li>
                            </ul>
                            <div class="so-component-navbar-actions">
                                <a href="/login" class="so-btn so-btn-outline-primary so-btn-sm">Login</a>
                                <a href="/register" class="so-btn so-btn-primary so-btn-sm">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-actions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$navbar = UiEngine::navbar()
    ->brand('Brand', '/')
    ->item('Features', '/features')
    ->item('Pricing', '/pricing')
    ->action('Login', '/login', ['variant' => 'outline-primary'])
    ->action('Sign Up', '/register', ['variant' => 'primary']);

echo \$navbar->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const navbar = UiEngine.navbar()
    .brand('Brand', '/')
    .item('Features', '/features')
    .item('Pricing', '/pricing')
    .action('Login', '/login', {variant: 'outline-primary'})
    .action('Sign Up', '/register', {variant: 'primary'});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Fixed Position -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Fixed & Sticky Positions</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Fixed and sticky positions keep the navbar visible while scrolling. Below are examples shown in contained areas to demonstrate the classes (in production, these would be fixed/sticky to the viewport).</p>

                <!-- Fixed Top Demo -->
                <h6 class="so-fw-semibold so-mb-2">Fixed Top</h6>
                <div class="so-border so-rounded so-mb-4" style="position: relative; height: 120px; overflow: hidden; background: #f8f9fa;">
                    <nav class="so-component-navbar so-component-navbar-expand-lg so-component-navbar-light" style="position: absolute; top: 0; left: 0; right: 0;">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Fixed Top</a>
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link so-active" href="#">Home</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">Features</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div style="padding: 70px 16px 16px; color: #6c757d;">
                        <small>Content area - navbar stays at top</small>
                    </div>
                </div>

                <!-- Fixed Bottom Demo -->
                <h6 class="so-fw-semibold so-mb-2">Fixed Bottom</h6>
                <div class="so-border so-rounded so-mb-4" style="position: relative; height: 120px; overflow: hidden; background: #f8f9fa;">
                    <div style="padding: 16px; color: #6c757d;">
                        <small>Content area - navbar stays at bottom</small>
                    </div>
                    <nav class="so-component-navbar so-component-navbar-expand-lg so-component-navbar-dark" style="position: absolute; bottom: 0; left: 0; right: 0;">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Fixed Bottom</a>
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link so-active" href="#">Home</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">Features</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <!-- Sticky Top Demo -->
                <h6 class="so-fw-semibold so-mb-2">Sticky Top</h6>
                <div class="so-border so-rounded so-mb-4" style="position: relative; height: 150px; overflow-y: auto; background: #f8f9fa;">
                    <nav class="so-component-navbar so-component-navbar-expand-lg so-component-navbar-primary" style="position: sticky; top: 0; z-index: 10;">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Sticky Top</a>
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link so-active" href="#">Home</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">Features</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div style="padding: 16px; color: #6c757d;">
                        <p><small>Scroll this area to see the sticky behavior. The navbar will stick to the top when you scroll past it.</small></p>
                        <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</small></p>
                        <p><small>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></p>
                        <p><small>Ut enim ad minim veniam, quis nostrud exercitation.</small></p>
                        <p><small>Duis aute irure dolor in reprehenderit in voluptate.</small></p>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-fixed', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Fixed to top
UiEngine::navbar()
    ->fixed('top')  // or ->fixedTop()
    ->brand('Brand')
    ->item('Home', '/');

// Fixed to bottom
UiEngine::navbar()
    ->fixed('bottom')  // or ->fixedBottom()
    ->brand('Brand')
    ->item('Home', '/');

// Sticky top (scrolls with page then sticks)
UiEngine::navbar()
    ->sticky()  // Enables sticky-top behavior
    ->brand('Brand')
    ->item('Home', '/');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Fixed to top
UiEngine.navbar()
    .fixed('top')
    .brand('Brand')
    .item('Home', '/');

// Fixed to bottom
UiEngine.navbar()
    .fixed('bottom')
    .brand('Brand')
    .item('Home', '/');

// Sticky top
UiEngine.navbar()
    .sticky()  // Enables sticky-top behavior
    .brand('Brand')
    .item('Home', '/');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Fixed top -->
<nav class="so-component-navbar so-component-navbar-light so-component-navbar-fixed-top">
    ...
</nav>

<!-- Fixed bottom -->
<nav class="so-component-navbar so-component-navbar-light so-component-navbar-fixed-bottom">
    ...
</nav>

<!-- Sticky top -->
<nav class="so-component-navbar so-component-navbar-light so-component-navbar-sticky-top">
    ...
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Responsive Breakpoints -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Responsive Breakpoints</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control when the navbar expands from mobile hamburger menu to full horizontal navigation. Resize your browser to see the behavior.</p>

                <!-- Always Expanded -->
                <h6 class="so-fw-semibold so-mb-2">Always Expanded <code class="so-ms-2">expand()</code></h6>
                <div class="so-border so-rounded so-p-0 so-mb-4">
                    <nav class="so-component-navbar so-component-navbar-expand so-component-navbar-light">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Brand</a>
                            <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link so-active" href="#">Home</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">About</a>
                                </li>
                                <li class="so-component-navbar-item">
                                    <a class="so-component-navbar-link" href="#">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <!-- Expand at SM -->
                <h6 class="so-fw-semibold so-mb-2">Expand at SM (≥576px) <code class="so-ms-2">expand('sm')</code></h6>
                <div class="so-border so-rounded so-p-0 so-mb-4">
                    <nav class="so-component-navbar so-component-navbar-expand-sm so-component-navbar-info">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Brand</a>
                            <button class="so-component-navbar-toggler" type="button" onclick="this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                <span class="so-component-navbar-toggler-icon"></span>
                            </button>
                            <div class="so-component-navbar-collapse">
                                <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link so-active" href="#">Home</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">About</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Expand at MD -->
                <h6 class="so-fw-semibold so-mb-2">Expand at MD (≥768px) <code class="so-ms-2">expand('md')</code></h6>
                <div class="so-border so-rounded so-p-0 so-mb-4">
                    <nav class="so-component-navbar so-component-navbar-expand-md so-component-navbar-success">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Brand</a>
                            <button class="so-component-navbar-toggler" type="button" onclick="this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                <span class="so-component-navbar-toggler-icon"></span>
                            </button>
                            <div class="so-component-navbar-collapse">
                                <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link so-active" href="#">Home</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">About</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Expand at LG (Default) -->
                <h6 class="so-fw-semibold so-mb-2">Expand at LG (≥992px) - Default <code class="so-ms-2">expand('lg')</code></h6>
                <div class="so-border so-rounded so-p-0 so-mb-4">
                    <nav class="so-component-navbar so-component-navbar-expand-lg so-component-navbar-warning">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Brand</a>
                            <button class="so-component-navbar-toggler" type="button" onclick="this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                <span class="so-component-navbar-toggler-icon"></span>
                            </button>
                            <div class="so-component-navbar-collapse">
                                <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link so-active" href="#">Home</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">About</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Expand at XL -->
                <h6 class="so-fw-semibold so-mb-2">Expand at XL (≥1200px) <code class="so-ms-2">expand('xl')</code></h6>
                <div class="so-border so-rounded so-p-0 so-mb-4">
                    <nav class="so-component-navbar so-component-navbar-expand-xl so-component-navbar-danger">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Brand</a>
                            <button class="so-component-navbar-toggler" type="button" onclick="this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                <span class="so-component-navbar-toggler-icon"></span>
                            </button>
                            <div class="so-component-navbar-collapse">
                                <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link so-active" href="#">Home</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">About</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Never Expand -->
                <h6 class="so-fw-semibold so-mb-2">Never Expand (Always Collapsed) <code class="so-ms-2">expand(false)</code></h6>
                <div class="so-border so-rounded so-p-0 so-mb-4">
                    <nav class="so-component-navbar so-component-navbar-dark">
                        <div class="so-component-navbar-container">
                            <a class="so-component-navbar-brand" href="#">Brand</a>
                            <button class="so-component-navbar-toggler" type="button" onclick="this.closest('.so-component-navbar').querySelector('.so-component-navbar-collapse').classList.toggle('so-show')">
                                <span class="so-component-navbar-toggler-icon"></span>
                            </button>
                            <div class="so-component-navbar-collapse">
                                <ul class="so-component-navbar-nav so-component-navbar-nav-start">
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link so-active" href="#">Home</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">About</a>
                                    </li>
                                    <li class="so-component-navbar-item">
                                        <a class="so-component-navbar-link" href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('navbar-responsive', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Always expanded
UiEngine::navbar()->expand();

// Expand at small breakpoint (>=576px)
UiEngine::navbar()->expand('sm');

// Expand at medium breakpoint (>=768px)
UiEngine::navbar()->expand('md');

// Expand at large breakpoint (>=992px) - default
UiEngine::navbar()->expand('lg');

// Expand at extra large breakpoint (>=1200px)
UiEngine::navbar()->expand('xl');

// Never expand (always collapsed)
UiEngine::navbar()->expand(false);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Always expanded
UiEngine.navbar().expand();

// Expand at small breakpoint (>=576px)
UiEngine.navbar().expand('sm');

// Expand at medium breakpoint (>=768px)
UiEngine.navbar().expand('md');

// Expand at large breakpoint (>=992px) - default
UiEngine.navbar().expand('lg');

// Expand at extra large breakpoint (>=1200px)
UiEngine.navbar().expand('xl');

// Never expand (always collapsed)
UiEngine.navbar().expand(false);"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Method</th>
                                <th>Parameters</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>brand()</code></td>
                                <td><code>string $text, string $url, array $options</code></td>
                                <td>Set brand/logo with optional icon or image</td>
                            </tr>
                            <tr>
                                <td><code>item()</code></td>
                                <td><code>string $label, string $url, array $options</code></td>
                                <td>Add navigation item</td>
                            </tr>
                            <tr>
                                <td><code>dropdown()</code></td>
                                <td><code>string $label, array $items</code></td>
                                <td>Add dropdown menu</td>
                            </tr>
                            <tr>
                                <td><code>rightItems()</code></td>
                                <td><code>array $items</code></td>
                                <td>Set right-aligned items</td>
                            </tr>
                            <tr>
                                <td><code>action()</code></td>
                                <td><code>string $label, string $url, array $options</code></td>
                                <td>Add action button</td>
                            </tr>
                            <tr>
                                <td><code>theme()</code></td>
                                <td><code>string $theme</code></td>
                                <td>Color theme: light, dark, primary, secondary, success, danger, warning, info</td>
                            </tr>
                            <tr>
                                <td><code>expand()</code></td>
                                <td><code>string|bool $breakpoint</code></td>
                                <td>Responsive expand: sm, md, lg, xl, true (always), false (never)</td>
                            </tr>
                            <tr>
                                <td><code>fixed()</code></td>
                                <td><code>string $position</code></td>
                                <td>Fixed position: top, bottom</td>
                            </tr>
                            <tr>
                                <td><code>sticky()</code></td>
                                <td><code>bool $sticky = true</code></td>
                                <td>Enable sticky-top positioning</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">CSS Classes</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>.so-component-navbar</code></td><td>Base navbar container</td></tr>
                            <tr><td><code>.so-component-navbar-light</code></td><td>Light theme (dark text)</td></tr>
                            <tr><td><code>.so-component-navbar-dark</code></td><td>Dark theme (light text)</td></tr>
                            <tr><td><code>.so-component-navbar-primary</code></td><td>Primary color theme</td></tr>
                            <tr><td><code>.so-component-navbar-expand-{sm|md|lg|xl}</code></td><td>Responsive expand breakpoint</td></tr>
                            <tr><td><code>.so-component-navbar-fixed-top</code></td><td>Fixed to top of viewport</td></tr>
                            <tr><td><code>.so-component-navbar-fixed-bottom</code></td><td>Fixed to bottom of viewport</td></tr>
                            <tr><td><code>.so-component-navbar-sticky-top</code></td><td>Sticky positioning at top</td></tr>
                            <tr><td><code>.so-component-navbar-brand</code></td><td>Brand/logo link</td></tr>
                            <tr><td><code>.so-component-navbar-nav</code></td><td>Navigation list</td></tr>
                            <tr><td><code>.so-component-navbar-item</code></td><td>Navigation item</td></tr>
                            <tr><td><code>.so-component-navbar-link</code></td><td>Navigation link</td></tr>
                            <tr><td><code>.so-component-navbar-collapse</code></td><td>Collapsible content wrapper</td></tr>
                            <tr><td><code>.so-component-navbar-toggler</code></td><td>Mobile toggle button</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
