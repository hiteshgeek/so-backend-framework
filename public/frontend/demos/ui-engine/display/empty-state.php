<?php
/**
 * SixOrbit UI Engine - Empty State Element Demo
 */

$pageTitle = 'Empty State - UI Engine';
$pageDescription = 'Placeholder for empty content areas';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Empty State</h1>
            <p class="so-page-subtitle">Placeholder UI for when there's no content to display, guiding users on what to do next.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Empty State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Empty State</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-text-center so-py-5 so-mb-4">
                    <span class="material-icons so-text-muted" style="font-size:64px;">inbox</span>
                    <h5 class="so-mt-3">No items yet</h5>
                    <p class="so-text-muted">Get started by creating your first item.</p>
                    <button class="so-btn so-btn-primary">
                        <span class="material-icons" style="font-size:18px;">add</span> Create Item
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-empty', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$emptyState = UiEngine::emptyState()
    ->icon('inbox')
    ->title('No items yet')
    ->description('Get started by creating your first item.')
    ->action(UiEngine::button('Create Item')->variant('primary')->icon('add'));

echo \$emptyState->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const emptyState = UiEngine.emptyState()
    .icon('inbox')
    .title('No items yet')
    .description('Get started by creating your first item.')
    .action(UiEngine.button('Create Item').variant('primary').icon('add'));

document.getElementById('container').innerHTML = emptyState.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-text-center so-py-5">
    <span class="material-icons so-text-muted" style="font-size:64px;">inbox</span>
    <h5 class="so-mt-3">No items yet</h5>
    <p class="so-text-muted">Get started by creating your first item.</p>
    <button class="so-btn so-btn-primary">
        <span class="material-icons">add</span> Create Item
    </button>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Image -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Custom Image</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-text-center so-py-5 so-mb-4">
                    <svg width="200" height="150" viewBox="0 0 200 150" class="so-mb-3">
                        <rect x="40" y="30" width="120" height="90" rx="8" fill="#e9ecef" stroke="#dee2e6" stroke-width="2"/>
                        <rect x="55" y="45" width="90" height="12" rx="2" fill="#adb5bd"/>
                        <rect x="55" y="65" width="70" height="8" rx="2" fill="#ced4da"/>
                        <rect x="55" y="80" width="80" height="8" rx="2" fill="#ced4da"/>
                        <rect x="55" y="95" width="50" height="8" rx="2" fill="#ced4da"/>
                        <circle cx="100" cy="70" r="35" fill="#f8f9fa" stroke="#dee2e6" stroke-width="2" stroke-dasharray="5,5"/>
                        <text x="100" y="75" text-anchor="middle" fill="#6c757d" font-size="12">No Image</text>
                    </svg>
                    <h5 class="so-mt-3">Your inbox is empty</h5>
                    <p class="so-text-muted">When you receive messages, they will appear here.</p>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('empty-image', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$emptyState = UiEngine::emptyState()
    ->image('/images/illustrations/empty-inbox.svg')
    ->imageSize(200)
    ->title('Your inbox is empty')
    ->description('When you receive messages, they will appear here.');

echo \$emptyState->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const emptyState = UiEngine.emptyState()
    .image('/images/illustrations/empty-inbox.svg')
    .imageSize(200)
    .title('Your inbox is empty')
    .description('When you receive messages, they will appear here.');

document.getElementById('container').innerHTML = emptyState.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-empty-state so-text-center so-py-5">
    <img src="/images/illustrations/empty-inbox.svg"
         alt="Empty inbox"
         class="so-empty-state-image"
         style="width:200px;height:auto;">
    <h5 class="so-mt-3">Your inbox is empty</h5>
    <p class="so-text-muted">When you receive messages, they will appear here.</p>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Common Scenarios -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Common Scenarios</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demos -->
                <div class="so-row so-g-4 so-mb-4">
                    <!-- No Search Results -->
                    <div class="so-col-md-6">
                        <div class="so-border so-rounded so-p-4">
                            <div class="so-text-center so-py-4">
                                <span class="material-icons so-text-muted" style="font-size:48px;">search_off</span>
                                <h6 class="so-mt-3">No results found</h6>
                                <p class="so-text-muted small">Try adjusting your search or filters.</p>
                                <button class="so-btn so-btn-sm so-btn-secondary">Clear filters</button>
                            </div>
                        </div>
                    </div>
                    <!-- No Notifications -->
                    <div class="so-col-md-6">
                        <div class="so-border so-rounded so-p-4">
                            <div class="so-text-center so-py-4">
                                <span class="material-icons so-text-success" style="font-size:48px;">notifications_none</span>
                                <h6 class="so-mt-3">All caught up!</h6>
                                <p class="so-text-muted small">You have no new notifications.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Empty Cart -->
                    <div class="so-col-md-6">
                        <div class="so-border so-rounded so-p-4">
                            <div class="so-text-center so-py-4">
                                <span class="material-icons so-text-muted" style="font-size:48px;">shopping_cart</span>
                                <h6 class="so-mt-3">Your cart is empty</h6>
                                <p class="so-text-muted small">Add some items to get started.</p>
                                <button class="so-btn so-btn-sm so-btn-primary">Browse Products</button>
                            </div>
                        </div>
                    </div>
                    <!-- Error State -->
                    <div class="so-col-md-6">
                        <div class="so-border so-rounded so-p-4">
                            <div class="so-text-center so-py-4">
                                <span class="material-icons so-text-danger" style="font-size:48px;">error_outline</span>
                                <h6 class="so-mt-3">Something went wrong</h6>
                                <p class="so-text-muted small">We encountered an error loading your data.</p>
                                <button class="so-btn so-btn-sm so-btn-primary">Retry</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('empty-scenarios', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// No search results
UiEngine::emptyState()
    ->icon('search_off')
    ->title('No results found')
    ->description('Try adjusting your search or filters.')
    ->action(UiEngine::button('Clear filters')->variant('secondary'));

// No notifications
UiEngine::emptyState()
    ->icon('notifications_none')
    ->title('All caught up!')
    ->description('You have no new notifications.');

// Empty cart
UiEngine::emptyState()
    ->icon('shopping_cart')
    ->title('Your cart is empty')
    ->description('Add some items to get started.')
    ->action(UiEngine::button('Browse Products')->variant('primary'));

// Error state
UiEngine::emptyState()
    ->icon('error_outline')
    ->iconColor('danger')
    ->title('Something went wrong')
    ->description('We encountered an error loading your data.')
    ->action(UiEngine::button('Retry')->variant('primary'));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// No search results
UiEngine.emptyState()
    .icon('search_off')
    .title('No results found')
    .description('Try adjusting your search or filters.')
    .action(UiEngine.button('Clear filters').variant('secondary'));

// No notifications
UiEngine.emptyState()
    .icon('notifications_none')
    .title('All caught up!')
    .description('You have no new notifications.');

// Empty cart
UiEngine.emptyState()
    .icon('shopping_cart')
    .title('Your cart is empty')
    .description('Add some items to get started.')
    .action(UiEngine.button('Browse Products').variant('primary'));

// Error state
UiEngine.emptyState()
    .icon('error_outline')
    .iconColor('danger')
    .title('Something went wrong')
    .description('We encountered an error loading your data.')
    .action(UiEngine.button('Retry').variant('primary'));"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- No search results -->
<div class="so-empty-state so-text-center so-py-5">
    <span class="material-icons so-text-muted" style="font-size:64px;">search_off</span>
    <h5 class="so-mt-3">No results found</h5>
    <p class="so-text-muted">Try adjusting your search or filters.</p>
    <button class="so-btn so-btn-secondary">Clear filters</button>
</div>

<!-- Error state with colored icon -->
<div class="so-empty-state so-text-center so-py-5">
    <span class="material-icons so-text-danger" style="font-size:64px;">error_outline</span>
    <h5 class="so-mt-3">Something went wrong</h5>
    <p class="so-text-muted">We encountered an error loading your data.</p>
    <button class="so-btn so-btn-primary">Retry</button>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Multiple Actions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Multiple Actions</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-text-center so-py-5 so-mb-4">
                    <span class="material-icons so-text-muted" style="font-size:64px;">folder_open</span>
                    <h5 class="so-mt-3">No files uploaded</h5>
                    <p class="so-text-muted">Upload files or create a new folder to organize your content.</p>
                    <div class="so-d-flex so-gap-2 so-justify-content-center">
                        <button class="so-btn so-btn-primary">
                            <span class="material-icons" style="font-size:18px;">upload</span> Upload Files
                        </button>
                        <button class="so-btn so-btn-outline-secondary">
                            <span class="material-icons" style="font-size:18px;">create_new_folder</span> New Folder
                        </button>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('empty-actions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$emptyState = UiEngine::emptyState()
    ->icon('folder_open')
    ->title('No files uploaded')
    ->description('Upload files or create a new folder to organize your content.')
    ->actions([
        UiEngine::button('Upload Files')->variant('primary')->icon('upload'),
        UiEngine::button('New Folder')->variant('secondary')->outline()->icon('create_new_folder'),
    ]);

echo \$emptyState->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const emptyState = UiEngine.emptyState()
    .icon('folder_open')
    .title('No files uploaded')
    .description('Upload files or create a new folder to organize your content.')
    .actions([
        UiEngine.button('Upload Files').variant('primary').icon('upload'),
        UiEngine.button('New Folder').variant('secondary').outline().icon('create_new_folder'),
    ]);

document.getElementById('container').innerHTML = emptyState.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-text-center so-py-5">
    <span class="material-icons so-text-muted" style="font-size:64px;">folder_open</span>
    <h5 class="so-mt-3">No files uploaded</h5>
    <p class="so-text-muted">Upload files or create a new folder to organize your content.</p>
    <div class="so-d-flex so-gap-2 so-justify-content-center">
        <button class="so-btn so-btn-primary">
            <span class="material-icons">upload</span> Upload Files
        </button>
        <button class="so-btn so-btn-outline-secondary">
            <span class="material-icons">create_new_folder</span> New Folder
        </button>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Compact Style -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Compact Style</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-border so-rounded so-p-3 so-mb-4" style="max-width:400px;">
                    <div class="so-text-center so-py-3">
                        <span class="material-icons so-text-muted" style="font-size:32px;">comment</span>
                        <h6 class="so-mt-2 so-mb-1">No comments</h6>
                        <p class="so-text-muted small so-mb-0">Be the first to comment.</p>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('empty-compact', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Compact empty state for smaller areas
\$emptyState = UiEngine::emptyState()
    ->compact()
    ->icon('comment')
    ->title('No comments')
    ->description('Be the first to comment.');

echo \$emptyState->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Compact empty state for smaller areas
const emptyState = UiEngine.emptyState()
    .compact()
    .icon('comment')
    .title('No comments')
    .description('Be the first to comment.');

document.getElementById('container').innerHTML = emptyState.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-empty-state so-empty-state-compact so-text-center so-py-3">
    <span class="material-icons so-text-muted" style="font-size:32px;">comment</span>
    <h6 class="so-mt-2 so-mb-1">No comments</h6>
    <p class="so-text-muted small so-mb-0">Be the first to comment.</p>
</div>'
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
                                <td><code>icon()</code></td>
                                <td><code>string $icon</code></td>
                                <td>Set the icon</td>
                            </tr>
                            <tr>
                                <td><code>iconColor()</code></td>
                                <td><code>string $color</code></td>
                                <td>Set icon color variant</td>
                            </tr>
                            <tr>
                                <td><code>image()</code></td>
                                <td><code>string $src</code></td>
                                <td>Use image instead of icon</td>
                            </tr>
                            <tr>
                                <td><code>title()</code></td>
                                <td><code>string $title</code></td>
                                <td>Set the title</td>
                            </tr>
                            <tr>
                                <td><code>description()</code></td>
                                <td><code>string $text</code></td>
                                <td>Set the description</td>
                            </tr>
                            <tr>
                                <td><code>action()</code></td>
                                <td><code>Element $button</code></td>
                                <td>Add single action button</td>
                            </tr>
                            <tr>
                                <td><code>actions()</code></td>
                                <td><code>array $buttons</code></td>
                                <td>Add multiple action buttons</td>
                            </tr>
                            <tr>
                                <td><code>compact()</code></td>
                                <td>-</td>
                                <td>Use compact style</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
