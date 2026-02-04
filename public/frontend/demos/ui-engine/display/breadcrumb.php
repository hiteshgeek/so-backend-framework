<?php
/**
 * SixOrbit UI Engine - Breadcrumb Element Demo
 */

$pageTitle = 'Breadcrumb - UI Engine';
$pageDescription = 'Navigation trail showing page hierarchy';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Breadcrumb</h1>
            <p class="so-page-subtitle">Navigation trail showing the current page's location within the site hierarchy.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Breadcrumb -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Breadcrumb</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav aria-label="breadcrumb" class="so-mb-4">
                    <ol class="so-breadcrumb">
                        <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                        <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                        <li class="so-breadcrumb-item so-active" aria-current="page">Category</li>
                    </ol>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-breadcrumb', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$breadcrumb = UiEngine::breadcrumb()
    ->item('Home', '/')
    ->item('Products', '/products')
    ->item('Category'); // Last item is active (no link)

echo \$breadcrumb->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const breadcrumb = UiEngine.breadcrumb()
    .item('Home', '/')
    .item('Products', '/products')
    .item('Category'); // Last item is active (no link)

document.getElementById('container').innerHTML = breadcrumb.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav aria-label="breadcrumb">
    <ol class="so-breadcrumb">
        <li class="so-breadcrumb-item"><a href="/">Home</a></li>
        <li class="so-breadcrumb-item"><a href="/products">Products</a></li>
        <li class="so-breadcrumb-item so-active" aria-current="page">Category</li>
    </ol>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <nav aria-label="breadcrumb" class="so-mb-4">
                    <ol class="so-breadcrumb">
                        <li class="so-breadcrumb-item">
                            <a href="#"><span class="material-icons" style="font-size:18px;vertical-align:middle;">home</span> Home</a>
                        </li>
                        <li class="so-breadcrumb-item">
                            <a href="#"><span class="material-icons" style="font-size:18px;vertical-align:middle;">settings</span> Settings</a>
                        </li>
                        <li class="so-breadcrumb-item so-active">
                            <span class="material-icons" style="font-size:18px;vertical-align:middle;">person</span> Profile
                        </li>
                    </ol>
                </nav>

                <!-- Code Tabs -->
                <?= so_code_tabs('breadcrumb-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$breadcrumb = UiEngine::breadcrumb()
    ->item('Home', '/', 'home')
    ->item('Settings', '/settings', 'settings')
    ->item('Profile', null, 'person');

echo \$breadcrumb->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const breadcrumb = UiEngine.breadcrumb()
    .item('Home', '/', 'home')
    .item('Settings', '/settings', 'settings')
    .item('Profile', null, 'person');

document.getElementById('container').innerHTML = breadcrumb.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav aria-label="breadcrumb">
    <ol class="so-breadcrumb">
        <li class="so-breadcrumb-item">
            <a href="/"><span class="material-icons">home</span> Home</a>
        </li>
        <li class="so-breadcrumb-item">
            <a href="/settings"><span class="material-icons">settings</span> Settings</a>
        </li>
        <li class="so-breadcrumb-item so-active" aria-current="page">
            <span class="material-icons">person</span> Profile
        </li>
    </ol>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Custom Separator -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Separators</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Customize the separator between breadcrumb items using CSS variables.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <p class="so-text-muted so-mb-2">Arrow separator (>):</p>
                    <nav aria-label="breadcrumb" class="so-mb-3" style="--so-breadcrumb-divider: '>';">
                        <ol class="so-breadcrumb">
                            <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                            <li class="so-breadcrumb-item so-active">Item</li>
                        </ol>
                    </nav>

                    <p class="so-text-muted so-mb-2">Pipe separator (|):</p>
                    <nav aria-label="breadcrumb" style="--so-breadcrumb-divider: '|';">
                        <ol class="so-breadcrumb">
                            <li class="so-breadcrumb-item"><a href="#">Page 1</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Page 2</a></li>
                            <li class="so-breadcrumb-item so-active">Page 3</li>
                        </ol>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('breadcrumb-separator', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Arrow separator
\$breadcrumb = UiEngine::breadcrumb()
    ->separator('>')
    ->item('Home', '/')
    ->item('Products', '/products')
    ->item('Item');

// Icon separator
\$breadcrumb = UiEngine::breadcrumb()
    ->separator('chevron_right', 'icon')
    ->item('Home', '/')
    ->item('Category')
    ->item('Product');

// Custom character
\$breadcrumb = UiEngine::breadcrumb()
    ->separator('|')
    ->item('Page 1', '/page1')
    ->item('Page 2', '/page2')
    ->item('Page 3');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Arrow separator
const breadcrumb = UiEngine.breadcrumb()
    .separator('>')
    .item('Home', '/')
    .item('Products', '/products')
    .item('Item');

// Icon separator
const iconBreadcrumb = UiEngine.breadcrumb()
    .separator('chevron_right', 'icon')
    .item('Home', '/')
    .item('Category')
    .item('Product');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Arrow separator using CSS variable -->
<nav aria-label="breadcrumb" style="--so-breadcrumb-divider: \'>\';">
    <ol class="so-breadcrumb">
        <li class="so-breadcrumb-item"><a href="/">Home</a></li>
        <li class="so-breadcrumb-item"><a href="/products">Products</a></li>
        <li class="so-breadcrumb-item so-active">Item</li>
    </ol>
</nav>

<!-- Pipe separator -->
<nav aria-label="breadcrumb" style="--so-breadcrumb-divider: \'|\';">
    <ol class="so-breadcrumb">...</ol>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- From Array -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">From Array</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Build breadcrumbs from an array of items for dynamic navigation.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="so-breadcrumb">
                            <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Users</a></li>
                            <li class="so-breadcrumb-item"><a href="#">John Doe</a></li>
                            <li class="so-breadcrumb-item so-active" aria-current="page">Edit Profile</li>
                        </ol>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('breadcrumb-array', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$items = [
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'Users', 'url' => '/users'],
    ['label' => 'John Doe', 'url' => '/users/123'],
    ['label' => 'Edit Profile'], // No URL = active/current
];

\$breadcrumb = UiEngine::breadcrumb()
    ->items(\$items);

echo \$breadcrumb->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const items = [
    {label: 'Home', url: '/'},
    {label: 'Users', url: '/users'},
    {label: 'John Doe', url: '/users/123'},
    {label: 'Edit Profile'}, // No URL = active/current
];

const breadcrumb = UiEngine.breadcrumb()
    .items(items);

document.getElementById('container').innerHTML = breadcrumb.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav aria-label="breadcrumb">
    <ol class="so-breadcrumb">
        <li class="so-breadcrumb-item"><a href="/">Home</a></li>
        <li class="so-breadcrumb-item"><a href="/users">Users</a></li>
        <li class="so-breadcrumb-item"><a href="/users/123">John Doe</a></li>
        <li class="so-breadcrumb-item so-active" aria-current="page">Edit Profile</li>
    </ol>
</nav>'
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
                                <td><code>item()</code></td>
                                <td><code>string $label, string $url, string $icon</code></td>
                                <td>Add a breadcrumb item</td>
                            </tr>
                            <tr>
                                <td><code>items()</code></td>
                                <td><code>array $items</code></td>
                                <td>Add multiple items from array</td>
                            </tr>
                            <tr>
                                <td><code>separator()</code></td>
                                <td><code>string $separator, string $type</code></td>
                                <td>Set separator (text or icon)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
