<?php
/**
 * SixOrbit UI Engine - Media Object Element Demo
 *
 * Comprehensive demonstration of the MediaObject element with:
 * - Basic usage examples
 * - UiEngine PHP and JavaScript API
 * - Complete API reference
 * - Validation patterns
 * - Error handling
 * - Configuration passing
 */

$pageTitle = 'Media Object - UI Engine';
$pageDescription = 'Flexible media object component for displaying content with images or icons';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Media Object</h1>
            <p class="so-page-subtitle">Flexible component for displaying content alongside images or icons, perfect for comments, notifications, and list items.</p>
        </div>
    </div>

    <div class="so-page-body">

        <!-- Quick Links -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Quick Navigation</h3>
            </div>
            <div class="so-card-body">
                <div class="so-d-flex so-flex-wrap so-gap-2">
                    <a href="#basic" class="so-btn so-btn-sm so-btn-outline-primary">Basic Usage</a>
                    <a href="#right-image" class="so-btn so-btn-sm so-btn-outline-primary">Right Image</a>
                    <a href="#icon-variants" class="so-btn so-btn-sm so-btn-outline-primary">Icon Variants</a>
                    <a href="#alignment" class="so-btn so-btn-sm so-btn-outline-primary">Alignment</a>
                    <a href="#sizes" class="so-btn so-btn-sm so-btn-outline-primary">Media Sizes</a>
                    <a href="#nested" class="so-btn so-btn-sm so-btn-outline-primary">Nested Objects</a>
                    <a href="#uiengine" class="so-btn so-btn-sm so-btn-outline-primary">UiEngine API</a>
                    <a href="#api-reference" class="so-btn so-btn-sm so-btn-outline-primary">API Reference</a>
                    <a href="#validation" class="so-btn so-btn-sm so-btn-outline-primary">Validation</a>
                    <a href="#error-handling" class="so-btn so-btn-sm so-btn-outline-primary">Error Handling</a>
                    <a href="#demo-link" class="so-btn so-btn-sm so-btn-success">Full CSS Demo</a>
                </div>
            </div>
        </div>

        <!-- Basic Media Object -->
        <div class="so-card so-mb-4" id="basic">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Media Object</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">The classic media object with an image on the left and content on the right.</p>

                <!-- Live Demo -->
                <div class="so-media-object so-mb-4">
                    <img src="https://via.placeholder.com/64" alt="User avatar" class="so-media-object-img">
                    <div class="so-media-object-body">
                        <h5 class="so-media-object-title">John Doe</h5>
                        <p class="so-media-object-content">This is a basic media object example. The image appears on the left side with content flowing alongside it.</p>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-media', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Create basic media object
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'User avatar')
    ->title('John Doe')
    ->content('This is a basic media object example. The image appears on the left side with content flowing alongside it.');

echo \$media;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { UiEngine } from './ui-engine/UiEngine.js';

// Create basic media object
const media = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'User avatar')
    .title('John Doe')
    .content('This is a basic media object example. The image appears on the left side with content flowing alongside it.');

document.getElementById('container').innerHTML = media.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object">
    <img src="https://via.placeholder.com/64" alt="User avatar" class="so-media-object-img">
    <div class="so-media-object-body">
        <h5 class="so-media-object-title">John Doe</h5>
        <p class="so-media-object-content">This is a basic media object example...</p>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Media Object with Right Image -->
        <div class="so-card so-mb-4" id="right-image">
            <div class="so-card-header">
                <h3 class="so-card-title">Media Object with Right Image</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Position the media on the right side instead of the left.</p>

                <!-- Live Demo -->
                <div class="so-media-object so-media-object-reverse so-mb-4">
                    <div class="so-media-object-body">
                        <h5 class="so-media-object-title">Jane Smith</h5>
                        <p class="so-media-object-content">The media can be positioned on the right side using the reverse layout option.</p>
                    </div>
                    <img src="https://via.placeholder.com/64" alt="User avatar" class="so-media-object-img">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-right', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'User avatar')
    ->title('Jane Smith')
    ->content('The media can be positioned on the right side using the reverse layout option.')
    ->mediaEnd();  // or ->reverse() or ->mediaPosition('end')

echo \$media;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const media = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'User avatar')
    .title('Jane Smith')
    .content('The media can be positioned on the right side using the reverse layout option.')
    .mediaEnd();  // or .reverse() or .mediaPosition('end')

document.getElementById('container').innerHTML = media.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object so-media-object-reverse">
    <div class="so-media-object-body">
        <h5 class="so-media-object-title">Jane Smith</h5>
        <p class="so-media-object-content">The media can be positioned...</p>
    </div>
    <img src="https://via.placeholder.com/64" alt="User avatar" class="so-media-object-img">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Icon Media Object -->
        <div class="so-card so-mb-4" id="icon-variants">
            <div class="so-card-header">
                <h3 class="so-card-title">Icon Media Object with Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use Material Icons instead of images, with contextual color variants.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-media-object so-mb-3">
                        <div class="so-media-object-icon so-media-object-icon-primary">
                            <span class="material-icons">person</span>
                        </div>
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Primary Icon</h5>
                            <p class="so-media-object-content">User profile updated successfully.</p>
                        </div>
                    </div>

                    <div class="so-media-object so-mb-3">
                        <div class="so-media-object-icon so-media-object-icon-success">
                            <span class="material-icons">check_circle</span>
                        </div>
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Success Icon</h5>
                            <p class="so-media-object-content">Your changes have been saved.</p>
                        </div>
                    </div>

                    <div class="so-media-object so-mb-3">
                        <div class="so-media-object-icon so-media-object-icon-warning">
                            <span class="material-icons">warning</span>
                        </div>
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Warning Icon</h5>
                            <p class="so-media-object-content">Please review your account settings.</p>
                        </div>
                    </div>

                    <div class="so-media-object so-mb-3">
                        <div class="so-media-object-icon so-media-object-icon-danger">
                            <span class="material-icons">error</span>
                        </div>
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Danger Icon</h5>
                            <p class="so-media-object-content">An error occurred while processing your request.</p>
                        </div>
                    </div>

                    <div class="so-media-object so-mb-3">
                        <div class="so-media-object-icon so-media-object-icon-info">
                            <span class="material-icons">info</span>
                        </div>
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Info Icon</h5>
                            <p class="so-media-object-content">New features are now available.</p>
                        </div>
                    </div>

                    <div class="so-media-object">
                        <div class="so-media-object-icon so-media-object-icon-secondary">
                            <span class="material-icons">mail</span>
                        </div>
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Secondary Icon</h5>
                            <p class="so-media-object-content">You have 3 unread messages.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Primary variant
\$media = UiEngine::mediaObject()
    ->icon('person', 'primary')
    ->title('Primary Icon')
    ->content('User profile updated successfully.');

// Success variant
\$media = UiEngine::mediaObject()
    ->icon('check_circle', 'success')
    ->title('Success Icon')
    ->content('Your changes have been saved.');

// Warning variant
\$media = UiEngine::mediaObject()
    ->icon('warning', 'warning')
    ->title('Warning Icon')
    ->content('Please review your account settings.');

// Danger variant
\$media = UiEngine::mediaObject()
    ->icon('error', 'danger')
    ->title('Danger Icon')
    ->content('An error occurred while processing your request.');

// Info variant
\$media = UiEngine::mediaObject()
    ->icon('info', 'info')
    ->title('Info Icon')
    ->content('New features are now available.');

// Secondary variant
\$media = UiEngine::mediaObject()
    ->icon('mail', 'secondary')
    ->title('Secondary Icon')
    ->content('You have 3 unread messages.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Primary variant
const media1 = UiEngine.mediaObject()
    .icon('person', 'primary')
    .title('Primary Icon')
    .content('User profile updated successfully.');

// Success variant
const media2 = UiEngine.mediaObject()
    .icon('check_circle', 'success')
    .title('Success Icon')
    .content('Your changes have been saved.');

// Warning variant
const media3 = UiEngine.mediaObject()
    .icon('warning', 'warning')
    .title('Warning Icon')
    .content('Please review your account settings.');

// Danger variant
const media4 = UiEngine.mediaObject()
    .icon('error', 'danger')
    .title('Danger Icon')
    .content('An error occurred while processing your request.');

// Info variant
const media5 = UiEngine.mediaObject()
    .icon('info', 'info')
    .title('Info Icon')
    .content('New features are now available.');

// Secondary variant
const media6 = UiEngine.mediaObject()
    .icon('mail', 'secondary')
    .title('Secondary Icon')
    .content('You have 3 unread messages.');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object">
    <div class="so-media-object-icon so-media-object-icon-primary">
        <span class="material-icons">person</span>
    </div>
    <div class="so-media-object-body">
        <h5 class="so-media-object-title">Primary Icon</h5>
        <p class="so-media-object-content">User profile updated successfully.</p>
    </div>
</div>

<div class="so-media-object">
    <div class="so-media-object-icon so-media-object-icon-success">
        <span class="material-icons">check_circle</span>
    </div>
    <div class="so-media-object-body">
        <h5 class="so-media-object-title">Success Icon</h5>
        <p class="so-media-object-content">Your changes have been saved.</p>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Alignment -->
        <div class="so-card so-mb-4" id="alignment">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Alignment</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control vertical alignment of the media relative to the content.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Top Aligned (Default)</label>
                    <div class="so-media-object so-media-object-align-top so-mb-4">
                        <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Top Alignment</h5>
                            <p class="so-media-object-content">The media is aligned to the top of the content. This is the default alignment. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>

                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Middle Aligned</label>
                    <div class="so-media-object so-media-object-align-middle so-mb-4">
                        <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Middle Alignment</h5>
                            <p class="so-media-object-content">The media is vertically centered with the content. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>

                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Bottom Aligned</label>
                    <div class="so-media-object so-media-object-align-bottom">
                        <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Bottom Alignment</h5>
                            <p class="so-media-object-content">The media is aligned to the bottom of the content. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-alignment', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Top aligned (default)
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'Avatar')
    ->title('Top Alignment')
    ->content('The media is aligned to the top...')
    ->alignTop();  // or ->align('top')

// Middle aligned
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'Avatar')
    ->title('Middle Alignment')
    ->content('The media is vertically centered...')
    ->alignMiddle();  // or ->align('middle') or ->alignCenter()

// Bottom aligned
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'Avatar')
    ->title('Bottom Alignment')
    ->content('The media is aligned to the bottom...')
    ->alignBottom();  // or ->align('bottom')

echo \$media;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Top aligned (default)
const media1 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'Avatar')
    .title('Top Alignment')
    .content('The media is aligned to the top...')
    .alignTop();  // or .align('top')

// Middle aligned
const media2 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'Avatar')
    .title('Middle Alignment')
    .content('The media is vertically centered...')
    .alignMiddle();  // or .align('middle') or .alignCenter()

// Bottom aligned
const media3 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'Avatar')
    .title('Bottom Alignment')
    .content('The media is aligned to the bottom...')
    .alignBottom();  // or .align('bottom')

document.getElementById('container').innerHTML = media1.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Top aligned -->
<div class="so-media-object so-media-object-align-top">
    <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
    <div class="so-media-object-body">...</div>
</div>

<!-- Middle aligned -->
<div class="so-media-object so-media-object-align-middle">
    <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
    <div class="so-media-object-body">...</div>
</div>

<!-- Bottom aligned -->
<div class="so-media-object so-media-object-align-bottom">
    <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
    <div class="so-media-object-body">...</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Different Media Sizes -->
        <div class="so-card so-mb-4" id="sizes">
            <div class="so-card-header">
                <h3 class="so-card-title">Different Media Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control the size of the media element.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Small (48px)</label>
                    <div class="so-media-object so-mb-3">
                        <img src="https://via.placeholder.com/48" alt="Avatar" class="so-media-object-img so-media-object-img-sm">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Small Media</h5>
                            <p class="so-media-object-content">Compact media size for list items.</p>
                        </div>
                    </div>

                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Medium (64px - Default)</label>
                    <div class="so-media-object so-mb-3">
                        <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Medium Media</h5>
                            <p class="so-media-object-content">Default media size for most use cases.</p>
                        </div>
                    </div>

                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Large (96px)</label>
                    <div class="so-media-object so-mb-3">
                        <img src="https://via.placeholder.com/96" alt="Avatar" class="so-media-object-img so-media-object-img-lg">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Large Media</h5>
                            <p class="so-media-object-content">Larger media size for prominent displays.</p>
                        </div>
                    </div>

                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Extra Large (128px)</label>
                    <div class="so-media-object">
                        <img src="https://via.placeholder.com/128" alt="Avatar" class="so-media-object-img so-media-object-img-xl">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Extra Large Media</h5>
                            <p class="so-media-object-content">Extra large media size for featured content.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small size
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/48', 'Avatar')
    ->mediaSize('sm')
    ->title('Small Media')
    ->content('Compact media size for list items.');

// Medium size (default)
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'Avatar')
    ->mediaSize('md')  // Optional, this is the default
    ->title('Medium Media')
    ->content('Default media size for most use cases.');

// Large size
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/96', 'Avatar')
    ->mediaSize('lg')
    ->title('Large Media')
    ->content('Larger media size for prominent displays.');

// Extra large size
\$media = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/128', 'Avatar')
    ->mediaSize('xl')
    ->title('Extra Large Media')
    ->content('Extra large media size for featured content.');

echo \$media;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small size
const media1 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/48', 'Avatar')
    .mediaSize('sm')
    .title('Small Media')
    .content('Compact media size for list items.');

// Medium size (default)
const media2 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'Avatar')
    .mediaSize('md')
    .title('Medium Media')
    .content('Default media size for most use cases.');

// Large size
const media3 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/96', 'Avatar')
    .mediaSize('lg')
    .title('Large Media')
    .content('Larger media size for prominent displays.');

// Extra large size
const media4 = UiEngine.mediaObject()
    .image('https://via.placeholder.com/128', 'Avatar')
    .mediaSize('xl')
    .title('Extra Large Media')
    .content('Extra large media size for featured content.');

document.getElementById('container').innerHTML = media1.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small -->
<div class="so-media-object">
    <img src="https://via.placeholder.com/48" alt="Avatar" class="so-media-object-img so-media-object-img-sm">
    <div class="so-media-object-body">...</div>
</div>

<!-- Medium (default) -->
<div class="so-media-object">
    <img src="https://via.placeholder.com/64" alt="Avatar" class="so-media-object-img">
    <div class="so-media-object-body">...</div>
</div>

<!-- Large -->
<div class="so-media-object">
    <img src="https://via.placeholder.com/96" alt="Avatar" class="so-media-object-img so-media-object-img-lg">
    <div class="so-media-object-body">...</div>
</div>

<!-- Extra Large -->
<div class="so-media-object">
    <img src="https://via.placeholder.com/128" alt="Avatar" class="so-media-object-img so-media-object-img-xl">
    <div class="so-media-object-body">...</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Nested Media Objects -->
        <div class="so-card so-mb-4" id="nested">
            <div class="so-card-header">
                <h3 class="so-card-title">Nested Media Objects</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Media objects can be nested for threaded comments or replies.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-media-object">
                        <img src="https://via.placeholder.com/64" alt="User 1" class="so-media-object-img">
                        <div class="so-media-object-body">
                            <h5 class="so-media-object-title">Parent Comment</h5>
                            <p class="so-media-object-content">This is a top-level comment in a threaded discussion.</p>

                            <!-- Nested media object -->
                            <div class="so-media-object so-mt-3">
                                <img src="https://via.placeholder.com/48" alt="User 2" class="so-media-object-img so-media-object-img-sm">
                                <div class="so-media-object-body">
                                    <h5 class="so-media-object-title">Reply to Parent</h5>
                                    <p class="so-media-object-content">This is a nested reply to the parent comment.</p>

                                    <!-- Deeply nested media object -->
                                    <div class="so-media-object so-mt-3">
                                        <img src="https://via.placeholder.com/48" alt="User 3" class="so-media-object-img so-media-object-img-sm">
                                        <div class="so-media-object-body">
                                            <h5 class="so-media-object-title">Nested Reply</h5>
                                            <p class="so-media-object-content">This is a deeply nested reply in the thread.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-nested', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create nested media objects for threaded comments
\$nestedReply = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/48', 'User 3')
    ->mediaSize('sm')
    ->title('Nested Reply')
    ->content('This is a deeply nested reply in the thread.')
    ->addClass('so-mt-3');

\$reply = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/48', 'User 2')
    ->mediaSize('sm')
    ->title('Reply to Parent')
    ->content('This is a nested reply to the parent comment.')
    ->body(\$nestedReply)  // Add nested content
    ->addClass('so-mt-3');

\$parent = UiEngine::mediaObject()
    ->image('https://via.placeholder.com/64', 'User 1')
    ->title('Parent Comment')
    ->content('This is a top-level comment in a threaded discussion.')
    ->body(\$reply);  // Add reply as nested content

echo \$parent;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Create nested media objects for threaded comments
const nestedReply = UiEngine.mediaObject()
    .image('https://via.placeholder.com/48', 'User 3')
    .mediaSize('sm')
    .title('Nested Reply')
    .content('This is a deeply nested reply in the thread.')
    .addClass('so-mt-3');

const reply = UiEngine.mediaObject()
    .image('https://via.placeholder.com/48', 'User 2')
    .mediaSize('sm')
    .title('Reply to Parent')
    .content('This is a nested reply to the parent comment.')
    .body(nestedReply.render())  // Add nested content
    .addClass('so-mt-3');

const parent = UiEngine.mediaObject()
    .image('https://via.placeholder.com/64', 'User 1')
    .title('Parent Comment')
    .content('This is a top-level comment in a threaded discussion.')
    .body(reply.render());  // Add reply as nested content

document.getElementById('container').innerHTML = parent.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object">
    <img src="https://via.placeholder.com/64" alt="User 1" class="so-media-object-img">
    <div class="so-media-object-body">
        <h5 class="so-media-object-title">Parent Comment</h5>
        <p class="so-media-object-content">This is a top-level comment...</p>

        <div class="so-media-object so-mt-3">
            <img src="https://via.placeholder.com/48" alt="User 2" class="so-media-object-img so-media-object-img-sm">
            <div class="so-media-object-body">
                <h5 class="so-media-object-title">Reply to Parent</h5>
                <p class="so-media-object-content">This is a nested reply...</p>

                <div class="so-media-object so-mt-3">
                    <img src="https://via.placeholder.com/48" alt="User 3" class="so-media-object-img so-media-object-img-sm">
                    <div class="so-media-object-body">
                        <h5 class="so-media-object-title">Nested Reply</h5>
                        <p class="so-media-object-content">This is a deeply nested reply...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- UiEngine Usage -->
        <div class="so-card so-mb-4" id="uiengine">
            <div class="so-card-header">
                <h3 class="so-card-title">UiEngine Usage</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    The UiEngine provides identical PHP and JavaScript APIs for server-side and client-side rendering.
                </p>

                <?php
                $phpContent = so_code_block('<?php
use Core\UiEngine\UiEngine;

// Basic media object with image
$media = UiEngine::mediaObject()
    ->image(\'https://via.placeholder.com/64\', \'User avatar\')
    ->title(\'John Doe\')
    ->content(\'This is the main content of the media object.\');

echo $media;

// Media object with icon
$notification = UiEngine::mediaObject()
    ->icon(\'check_circle\', \'success\')
    ->title(\'Success!\')
    ->content(\'Your changes have been saved successfully.\');

echo $notification;

// Advanced configuration
$comment = UiEngine::mediaObject()
    ->image(\'/images/avatar.jpg\', \'User avatar\')
    ->mediaSize(\'lg\')
    ->title(\'Jane Smith\')
    ->content(\'This is a comment with advanced configuration.\')
    ->alignMiddle()
    ->mediaStart();

echo $comment;

// Right-aligned media
$mediaRight = UiEngine::mediaObject()
    ->image(\'https://via.placeholder.com/64\', \'Avatar\')
    ->title(\'Right Aligned\')
    ->content(\'Media appears on the right side.\')
    ->mediaEnd();  // or ->reverse()

echo $mediaRight;

// Getters
$title = $media->getTitle();
$content = $media->getContent();
$mediaType = $media->getMediaType();  // \'image\' or \'icon\'
$mediaData = $media->getMedia();      // Returns media configuration', 'php');

                $jsContent = so_code_block('import { UiEngine } from \'./ui-engine/UiEngine.js\';

// Basic media object with image
const media = UiEngine.mediaObject()
    .image(\'https://via.placeholder.com/64\', \'User avatar\')
    .title(\'John Doe\')
    .content(\'This is the main content of the media object.\');

document.getElementById(\'container\').innerHTML = media.render();

// Media object with icon
const notification = UiEngine.mediaObject()
    .icon(\'check_circle\', \'success\')
    .title(\'Success!\')
    .content(\'Your changes have been saved successfully.\');

document.getElementById(\'notifications\').innerHTML = notification.render();

// Advanced configuration
const comment = UiEngine.mediaObject()
    .image(\'/images/avatar.jpg\', \'User avatar\')
    .mediaSize(\'lg\')
    .title(\'Jane Smith\')
    .content(\'This is a comment with advanced configuration.\')
    .alignMiddle()
    .mediaStart();

document.getElementById(\'comments\').innerHTML = comment.render();

// Right-aligned media
const mediaRight = UiEngine.mediaObject()
    .image(\'https://via.placeholder.com/64\', \'Avatar\')
    .title(\'Right Aligned\')
    .content(\'Media appears on the right side.\')
    .mediaEnd();  // or .reverse()

// Event handling (JavaScript only)
media.onMediaChange((e) => {
    console.log(\'Media changed:\', e.detail);
});

media.onTitleChange((e) => {
    console.log(\'Title changed:\', e.detail.title);
});

media.onContentChange((e) => {
    console.log(\'Content changed:\', e.detail.content);
});

// Getters
const title = media.getTitle();
const content = media.getContent();
const mediaType = media.getMediaType();  // \'image\' or \'icon\'
const mediaData = media.getMedia();      // Returns media configuration', 'javascript');

                $configContent = so_code_block('// Configuration array format (works in both PHP and JS)
const config = {
    type: \'media-object\',
    media: {
        type: \'image\',  // or \'icon\'
        src: \'https://via.placeholder.com/64\',
        alt: \'User avatar\',
        size: \'md\'  // sm, md, lg, xl
    },
    // OR for icon:
    media: {
        type: \'icon\',
        icon: \'check_circle\',
        variant: \'success\'  // primary, success, warning, danger, info, secondary
    },
    title: \'John Doe\',
    content: \'This is the main content.\',
    position: \'start\',  // \'start\' or \'end\'
    align: \'middle\',     // \'top\', \'middle\', \'bottom\'
    reverse: false
};

// PHP: Create from config
$media = UiEngine::fromConfig($config);

// JavaScript: Create from config
const media = UiEngine.fromConfig(config);

// Export to config
const exportedConfig = media.toConfig();  // JS
$exportedConfig = $media->toArray();      // PHP', 'javascript');

                echo so_tabs('uiengine-tabs', [
                    [
                        'id' => 'php-usage',
                        'label' => 'PHP (Server-side)',
                        'active' => true,
                        'content' => $phpContent
                    ],
                    [
                        'id' => 'js-usage',
                        'label' => 'JavaScript (Client-side)',
                        'content' => $jsContent
                    ],
                    [
                        'id' => 'config-usage',
                        'label' => 'Configuration',
                        'content' => $configContent
                    ]
                ]);
                ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4" id="api-reference">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete API reference for all MediaObject methods. All methods support chaining and are available in both PHP and JavaScript.</p>

                <!-- Tab Navigation -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-content-methods" aria-selected="true" aria-controls="api-content-methods">Content Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-media-methods" aria-selected="false" aria-controls="api-media-methods">Media Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-position-methods" aria-selected="false" aria-controls="api-position-methods">Position & Alignment</button>
                    <button class="so-tab" role="tab" data-so-target="#api-event-methods" aria-selected="false" aria-controls="api-event-methods">Event Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-inherited-methods" aria-selected="false" aria-controls="api-inherited-methods">Inherited Methods</button>
                </div>

                <div class="so-tab-content">
                <!-- Content Methods -->
                <div class="so-tab-pane so-fade so-show so-active" id="api-content-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>title(string $title)</code></td>
                                    <td>Set the media object title. Renders as <code>&lt;h5&gt;</code> with class <code>.so-media-object-title</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>content(string $content)</code></td>
                                    <td>Set the main content text. Renders as <code>&lt;p&gt;</code> with class <code>.so-media-object-content</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>body(string $html)</code></td>
                                    <td>Set custom body HTML. Appends to the body container after title and content. Useful for nested media objects.</td>
                                </tr>
                                <tr>
                                    <td><code>getTitle()</code></td>
                                    <td>Get the current title text.</td>
                                </tr>
                                <tr>
                                    <td><code>getContent()</code></td>
                                    <td>Get the current content text.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
$media = UiEngine::mediaObject()
    ->image(\'avatar.jpg\', \'Avatar\')
    ->title(\'John Doe\')
    ->content(\'This is the main content.\')
    ->body(\'<small class="so-text-muted">2 hours ago</small>\');

$title = $media->getTitle();      // \'John Doe\'
$content = $media->getContent();  // \'This is the main content.\'

// JavaScript
const media = UiEngine.mediaObject()
    .image(\'avatar.jpg\', \'Avatar\')
    .title(\'John Doe\')
    .content(\'This is the main content.\')
    .body(\'<small class="so-text-muted">2 hours ago</small>\');

const title = media.getTitle();      // \'John Doe\'
const content = media.getContent();  // \'This is the main content.\'', 'php') ?>
                </div>

                <!-- Media Methods -->
                <div class="so-tab-pane so-fade" id="api-media-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>image(string $src, string $alt)</code></td>
                                    <td>Set media as an image. Requires source URL and alt text for accessibility.</td>
                                </tr>
                                <tr>
                                    <td><code>icon(string $icon, string $variant = \'primary\')</code></td>
                                    <td>Set media as a Material Icon with optional variant: <code>primary</code>, <code>success</code>, <code>warning</code>, <code>danger</code>, <code>info</code>, <code>secondary</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>mediaSize(string $size)</code></td>
                                    <td>Set media size: <code>sm</code> (48px), <code>md</code> (64px, default), <code>lg</code> (96px), <code>xl</code> (128px).</td>
                                </tr>
                                <tr>
                                    <td><code>iconVariant(string $variant)</code></td>
                                    <td>Set or change icon variant after creation: <code>primary</code>, <code>success</code>, <code>warning</code>, <code>danger</code>, <code>info</code>, <code>secondary</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>setMedia(array $config)</code></td>
                                    <td>Set media configuration directly. Config must include <code>type</code> (image/icon) and relevant properties.</td>
                                </tr>
                                <tr>
                                    <td><code>getMedia()</code></td>
                                    <td>Get current media configuration array.</td>
                                </tr>
                                <tr>
                                    <td><code>getMediaType()</code></td>
                                    <td>Get media type: <code>'image'</code> or <code>'icon'</code>.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
// Image media
$media = UiEngine::mediaObject()
    ->image(\'https://via.placeholder.com/64\', \'User avatar\')
    ->mediaSize(\'lg\')
    ->title(\'With Image\');

// Icon media
$media = UiEngine::mediaObject()
    ->icon(\'check_circle\', \'success\')
    ->mediaSize(\'md\')
    ->title(\'Success Notification\');

// Change icon variant
$media->iconVariant(\'warning\');

// Get media info
$type = $media->getMediaType();  // \'icon\'
$config = $media->getMedia();    // [\'type\' => \'icon\', \'icon\' => \'check_circle\', ...]

// JavaScript
const media = UiEngine.mediaObject()
    .image(\'https://via.placeholder.com/64\', \'User avatar\')
    .mediaSize(\'lg\')
    .title(\'With Image\');

const iconMedia = UiEngine.mediaObject()
    .icon(\'check_circle\', \'success\')
    .mediaSize(\'md\')
    .title(\'Success Notification\');

// Change icon variant
iconMedia.iconVariant(\'warning\');

// Get media info
const type = iconMedia.getMediaType();  // \'icon\'
const config = iconMedia.getMedia();    // {type: \'icon\', icon: \'check_circle\', ...}', 'php') ?>
                </div>

                <!-- Position & Alignment Methods -->
                <div class="so-tab-pane so-fade" id="api-position-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>mediaPosition(string $position)</code></td>
                                    <td>Set media position: <code>'start'</code> (left) or <code>'end'</code> (right).</td>
                                </tr>
                                <tr>
                                    <td><code>mediaStart()</code></td>
                                    <td>Position media on the start/left side (default).</td>
                                </tr>
                                <tr>
                                    <td><code>mediaEnd()</code></td>
                                    <td>Position media on the end/right side.</td>
                                </tr>
                                <tr>
                                    <td><code>reverse(bool $reverse = true)</code></td>
                                    <td>Reverse layout (media on right). Adds <code>.so-media-object-reverse</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>align(string $alignment)</code></td>
                                    <td>Set vertical alignment: <code>'top'</code>, <code>'middle'</code>, or <code>'bottom'</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>alignTop()</code></td>
                                    <td>Align media to top (default). Adds <code>.so-media-object-align-top</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>alignMiddle()</code></td>
                                    <td>Vertically center media. Adds <code>.so-media-object-align-middle</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>alignCenter()</code></td>
                                    <td>Alias for <code>alignMiddle()</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>alignBottom()</code></td>
                                    <td>Align media to bottom. Adds <code>.so-media-object-align-bottom</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>togglePosition()</code></td>
                                    <td><strong>JavaScript only:</strong> Toggle media position between start and end. Fires <code>so:media:positionToggled</code> event.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
// Media on left (default)
$media = UiEngine::mediaObject()
    ->image(\'avatar.jpg\', \'Avatar\')
    ->mediaStart()  // or ->mediaPosition(\'start\')
    ->alignTop()
    ->title(\'Left Aligned\');

// Media on right
$media = UiEngine::mediaObject()
    ->image(\'avatar.jpg\', \'Avatar\')
    ->mediaEnd()  // or ->mediaPosition(\'end\') or ->reverse()
    ->alignMiddle()
    ->title(\'Right Aligned\');

// Bottom aligned
$media = UiEngine::mediaObject()
    ->image(\'avatar.jpg\', \'Avatar\')
    ->alignBottom()  // or ->align(\'bottom\')
    ->title(\'Bottom Aligned\');

// JavaScript
const media = UiEngine.mediaObject()
    .image(\'avatar.jpg\', \'Avatar\')
    .mediaStart()
    .alignMiddle()
    .title(\'Centered Media\');

// Toggle position (JS only)
media.togglePosition();  // Switches from start to end or vice versa', 'php') ?>
                </div>

                <!-- Event Methods -->
                <div class="so-tab-pane so-fade" id="api-event-methods" role="tabpanel">
                    <p class="so-text-muted so-mb-3"><strong>JavaScript Only:</strong> Event handling methods for client-side interactivity.</p>

                    <div class="so-table-responsive so-mb-4">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>onMediaChange(callback)</code></td>
                                    <td>Listen for media changes. Receives event with <code>detail: {media, type}</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>onTitleChange(callback)</code></td>
                                    <td>Listen for title changes. Receives event with <code>detail: {title}</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>onContentChange(callback)</code></td>
                                    <td>Listen for content changes. Receives event with <code>detail: {content}</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>onPositionChange(callback)</code></td>
                                    <td>Listen for position changes. Receives event with <code>detail: {position}</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>onClick(callback)</code></td>
                                    <td>Listen for clicks on the media object.</td>
                                </tr>
                                <tr>
                                    <td><code>on(eventName, callback)</code></td>
                                    <td>Generic event listener (inherited from Element).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="so-mb-3">Custom Events (so: prefixed)</h5>
                    <div class="so-table-responsive so-mb-4">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Event</th>
                                    <th style="width: 65%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so:media:mediaChanged</code></td>
                                    <td>Fired when media (image/icon) is changed. <code>detail: {media, type}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:titleChanged</code></td>
                                    <td>Fired when title is changed. <code>detail: {title}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:contentChanged</code></td>
                                    <td>Fired when content is changed. <code>detail: {content}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:positionChanged</code></td>
                                    <td>Fired when media position changes. <code>detail: {position}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:sizeChanged</code></td>
                                    <td>Fired when media size changes. <code>detail: {size}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:variantChanged</code></td>
                                    <td>Fired when icon variant changes. <code>detail: {variant}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:alignChanged</code></td>
                                    <td>Fired when vertical alignment changes. <code>detail: {align}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:media:positionToggled</code></td>
                                    <td>Fired when position is toggled. <code>detail: {position}</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// JavaScript event handling
const media = UiEngine.mediaObject()
    .image(\'avatar.jpg\', \'User\')
    .title(\'John Doe\')
    .content(\'Initial content\');

// Listen for media changes
media.onMediaChange((e) => {
    console.log(\'Media changed:\', e.detail.media);
    console.log(\'Media type:\', e.detail.type);
});

// Listen for title changes
media.onTitleChange((e) => {
    console.log(\'New title:\', e.detail.title);
});

// Listen for content changes
media.onContentChange((e) => {
    console.log(\'New content:\', e.detail.content);
});

// Listen for position changes
media.onPositionChange((e) => {
    console.log(\'Position changed to:\', e.detail.position);
});

// Listen for clicks
media.onClick((e) => {
    console.log(\'Media object clicked\');
});

// Listen for custom events
media.on(\'so:media:variantChanged\', (e) => {
    console.log(\'Variant changed to:\', e.detail.variant);
});

// Update media to trigger events
media.title(\'Jane Smith\');         // Fires so:media:titleChanged
media.icon(\'mail\', \'primary\');   // Fires so:media:mediaChanged
media.mediaEnd();                    // Fires so:media:positionChanged
media.togglePosition();              // Fires so:media:positionToggled

// Render and attach events
document.getElementById(\'container\').innerHTML = media.render();', 'javascript') ?>
                </div>

                <!-- Inherited Methods -->
                <div class="so-tab-pane so-fade" id="api-inherited-methods" role="tabpanel">
                    <p class="so-text-muted so-mb-3">MediaObject inherits these methods from the base Element class:</p>

                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>id(string $id)</code></td>
                                    <td>Set element ID attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>addClass(string $class)</code></td>
                                    <td>Add CSS class(es). Space-separated for multiple.</td>
                                </tr>
                                <tr>
                                    <td><code>removeClass(string $class)</code></td>
                                    <td>Remove CSS class(es).</td>
                                </tr>
                                <tr>
                                    <td><code>attr(string $name, mixed $value)</code></td>
                                    <td>Set HTML attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>data(string $key, mixed $value)</code></td>
                                    <td>Set data attribute (auto-prefixes with <code>data-so-</code>).</td>
                                </tr>
                                <tr>
                                    <td><code>style(string $property, string $value)</code></td>
                                    <td>Set inline CSS style property.</td>
                                </tr>
                                <tr>
                                    <td><code>render()</code></td>
                                    <td><strong>JavaScript:</strong> Return rendered HTML string.</td>
                                </tr>
                                <tr>
                                    <td><code>__toString()</code></td>
                                    <td><strong>PHP:</strong> Automatically called when echoing.</td>
                                </tr>
                                <tr>
                                    <td><code>toArray() / toConfig()</code></td>
                                    <td>Export element configuration.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP - Using inherited methods
$media = UiEngine::mediaObject()
    ->image(\'avatar.jpg\', \'Avatar\')
    ->title(\'John Doe\')
    ->content(\'User comment\')
    ->id(\'comment-123\')
    ->addClass(\'featured highlight\')
    ->attr(\'role\', \'article\')
    ->attr(\'aria-label\', \'User comment\')
    ->data(\'user-id\', \'12345\')
    ->data(\'timestamp\', time())
    ->style(\'margin-bottom\', \'2rem\');

echo $media;  // Calls __toString()

// Export configuration
$config = $media->toArray();

// JavaScript - Using inherited methods
const media = UiEngine.mediaObject()
    .image(\'avatar.jpg\', \'Avatar\')
    .title(\'John Doe\')
    .content(\'User comment\')
    .id(\'comment-123\')
    .addClass(\'featured highlight\')
    .attr(\'role\', \'article\')
    .attr(\'aria-label\', \'User comment\')
    .data(\'user-id\', \'12345\')
    .data(\'timestamp\', Date.now())
    .style(\'margin-bottom\', \'2rem\');

const html = media.render();
document.getElementById(\'container\').innerHTML = html;

// Export configuration
const config = media.toConfig();', 'php') ?>
                </div>
                </div>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4" id="validation">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    MediaObject is a display-only component that doesn't require validation. However, if you're dynamically
                    generating media objects from user input or database data, you should validate that data before creating the component.
                </p>

                <div class="so-alert so-alert-info so-mb-4">
                    <div class="so-alert-icon">
                        <span class="material-icons">info</span>
                    </div>
                    <div class="so-alert-content">
                        <strong>Note:</strong> Media objects are for display purposes. They don't collect user input and therefore
                        don't need built-in validation. Always sanitize and validate data from external sources before rendering.
                    </div>
                </div>

                <h5 class="so-mb-3">Validating Media Object Data</h5>
                <?= so_code_block('<?php
use Core\Validation\Validator;
use Core\UiEngine\UiEngine;

// Validate media object data before rendering
function createValidatedMediaObject(array $data): ?string
{
    $validator = new Validator($data, [
        \'title\' => \'required|string|max:200\',
        \'content\' => \'required|string|max:1000\',
        \'media_type\' => \'required|in:image,icon\',
        \'media_src\' => \'required_if:media_type,image|url\',
        \'media_icon\' => \'required_if:media_type,icon|string\',
        \'media_variant\' => \'nullable|in:primary,secondary,success,danger,warning,info\',
        \'media_size\' => \'nullable|in:sm,md,lg,xl\',
        \'position\' => \'nullable|in:start,end\',
        \'align\' => \'nullable|in:top,middle,bottom\',
    ]);

    if ($validator->fails()) {
        // Handle validation errors
        return null;
    }

    $media = UiEngine::mediaObject()
        ->title($data[\'title\'])
        ->content($data[\'content\']);

    // Set media based on type
    if ($data[\'media_type\'] === \'image\') {
        $media->image($data[\'media_src\'], $data[\'title\']);
    } else {
        $variant = $data[\'media_variant\'] ?? \'primary\';
        $media->icon($data[\'media_icon\'], $variant);
    }

    // Optional configurations
    if (!empty($data[\'media_size\'])) {
        $media->mediaSize($data[\'media_size\']);
    }

    if (!empty($data[\'position\']) && $data[\'position\'] === \'end\') {
        $media->mediaEnd();
    }

    if (!empty($data[\'align\'])) {
        $media->align($data[\'align\']);
    }

    return (string) $media;
}

// Usage
$userData = [
    \'title\' => \'John Doe\',
    \'content\' => \'This is a user comment.\',
    \'media_type\' => \'image\',
    \'media_src\' => \'https://example.com/avatar.jpg\',
    \'media_size\' => \'md\',
    \'align\' => \'middle\'
];

$html = createValidatedMediaObject($userData);', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Content Sanitization</h5>
                <?= so_code_block('<?php
// Always sanitize user-generated content
function renderUserComment(array $comment): string
{
    // Sanitize HTML in content
    $safeTitle = htmlspecialchars($comment[\'title\'], ENT_QUOTES, \'UTF-8\');
    $safeContent = htmlspecialchars($comment[\'content\'], ENT_QUOTES, \'UTF-8\');

    // Validate image URL
    $avatarUrl = filter_var($comment[\'avatar_url\'], FILTER_VALIDATE_URL)
        ? $comment[\'avatar_url\']
        : \'/images/default-avatar.png\';

    return (string) UiEngine::mediaObject()
        ->image($avatarUrl, $safeTitle)
        ->title($safeTitle)
        ->content($safeContent)
        ->mediaSize(\'lg\')
        ->alignMiddle();
}', 'php') ?>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4" id="error-handling">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Common error scenarios and how to handle them when working with MediaObject.
                </p>

                <h5 class="so-mb-3">Common Scenarios</h5>
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Scenario</th>
                                <th style="width: 35%;">Issue</th>
                                <th style="width: 40%;">Solution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Missing media</td>
                                <td>No image or icon specified</td>
                                <td>Provide default media or show placeholder</td>
                            </tr>
                            <tr>
                                <td>Broken image URL</td>
                                <td>Image fails to load</td>
                                <td>Use fallback image with error handling</td>
                            </tr>
                            <tr>
                                <td>Invalid icon name</td>
                                <td>Material icon doesn't exist</td>
                                <td>Use default icon or validate icon names</td>
                            </tr>
                            <tr>
                                <td>Missing content</td>
                                <td>Title or content is empty</td>
                                <td>Provide fallback text or skip rendering</td>
                            </tr>
                            <tr>
                                <td>Invalid variant</td>
                                <td>Typo in variant name</td>
                                <td>Use constants or validation</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Error Handling Examples</h5>
                <?= so_code_block('<?php
// PHP - Handle missing or invalid data
function renderMediaObject(array $data): string
{
    // Validate required fields
    if (empty($data[\'title\']) || empty($data[\'content\'])) {
        return \'\'; // Or return error message
    }

    $media = UiEngine::mediaObject()
        ->title($data[\'title\'])
        ->content($data[\'content\']);

    // Handle media with fallback
    if (!empty($data[\'avatar_url\'])) {
        // Check if URL is valid
        if (filter_var($data[\'avatar_url\'], FILTER_VALIDATE_URL)) {
            $media->image($data[\'avatar_url\'], $data[\'title\']);
        } else {
            // Use default avatar
            $media->image(\'/images/default-avatar.png\', \'Default avatar\');
        }
    } else if (!empty($data[\'icon\'])) {
        // Validate icon variant
        $validVariants = [\'primary\', \'success\', \'warning\', \'danger\', \'info\', \'secondary\'];
        $variant = in_array($data[\'variant\'] ?? \'\', $validVariants)
            ? $data[\'variant\']
            : \'primary\';

        $media->icon($data[\'icon\'], $variant);
    } else {
        // No media provided, use default icon
        $media->icon(\'person\', \'secondary\');
    }

    // Validate media size
    $validSizes = [\'sm\', \'md\', \'lg\', \'xl\'];
    if (!empty($data[\'size\']) && in_array($data[\'size\'], $validSizes)) {
        $media->mediaSize($data[\'size\']);
    }

    return (string) $media;
}

// Usage with error handling
$commentData = [
    \'title\' => \'John Doe\',
    \'content\' => \'Great article!\',
    \'avatar_url\' => \'invalid-url\',  // Will use fallback
    \'size\' => \'invalid-size\'        // Will be ignored
];

$html = renderMediaObject($commentData);', 'php') ?>

                <hr class="so-my-4">

                <?= so_code_block('// JavaScript - Error handling with fallbacks
function renderMediaObject(data) {
    // Validate required fields
    if (!data.title || !data.content) {
        console.error(\'Missing required fields\');
        return \'\';
    }

    const media = UiEngine.mediaObject()
        .title(data.title)
        .content(data.content);

    // Handle media with fallback
    if (data.avatarUrl) {
        try {
            new URL(data.avatarUrl);  // Validate URL
            media.image(data.avatarUrl, data.title);
        } catch (e) {
            console.warn(\'Invalid image URL, using default\');
            media.image(\'/images/default-avatar.png\', \'Default avatar\');
        }
    } else if (data.icon) {
        // Validate variant
        const validVariants = [\'primary\', \'success\', \'warning\', \'danger\', \'info\', \'secondary\'];
        const variant = validVariants.includes(data.variant) ? data.variant : \'primary\';
        media.icon(data.icon, variant);
    } else {
        // No media provided, use default
        media.icon(\'person\', \'secondary\');
    }

    // Validate size
    const validSizes = [\'sm\', \'md\', \'lg\', \'xl\'];
    if (data.size && validSizes.includes(data.size)) {
        media.mediaSize(data.size);
    }

    return media.render();
}

// Usage with error handling
const commentData = {
    title: \'John Doe\',
    content: \'Great article!\',
    avatarUrl: \'invalid-url\',  // Will use fallback
    size: \'invalid-size\'        // Will be ignored
};

const html = renderMediaObject(commentData);
document.getElementById(\'comments\').innerHTML = html;

// Handle image load errors
document.addEventListener(\'error\', (e) => {
    if (e.target.tagName === \'IMG\' && e.target.classList.contains(\'so-media-object-img\')) {
        console.warn(\'Image failed to load:\', e.target.src);
        e.target.src = \'/images/default-avatar.png\';
    }
}, true);', 'javascript') ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Pass MediaObject configuration from PHP to JavaScript for client-side hydration and interactivity.
                </p>

                <h5 class="so-mb-3">Method 1: Data Attributes</h5>
                <?= so_code_block('<?php
// PHP - Export config to data attribute
$media = UiEngine::mediaObject()
    ->icon(\'check_circle\', \'success\')
    ->title(\'Success!\')
    ->content(\'Your changes have been saved.\')
    ->mediaSize(\'lg\')
    ->alignMiddle();

$config = $media->toArray();
?>

<div id="notification-container" data-media-config=\'<?= json_encode($config) ?>\'></div>

<script type="module">
import { UiEngine } from \'./ui-engine/UiEngine.js\';

// JavaScript - Hydrate from config
const container = document.getElementById(\'notification-container\');
const config = JSON.parse(container.dataset.mediaConfig);

const media = UiEngine.fromConfig(config);
container.innerHTML = media.render();

// Add interactivity
media.onClick(() => {
    console.log(\'Notification clicked\');
});
</script>', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Method 2: Inline Script</h5>
                <?= so_code_block('<?php
$comment = UiEngine::mediaObject()
    ->image(\'/images/user-avatar.jpg\', \'User avatar\')
    ->title(\'Jane Smith\')
    ->content(\'This is an excellent article, thanks for sharing!\')
    ->mediaSize(\'md\')
    ->alignTop();

$config = $comment->toArray();
?>

<div id="comment"></div>

<script type="module">
import { UiEngine } from \'./ui-engine/UiEngine.js\';

const config = <?= json_encode($config) ?>;
const media = UiEngine.fromConfig(config);

document.getElementById(\'comment\').innerHTML = media.render();

// Add event handlers
media.onClick(() => {
    console.log(\'Comment clicked\');
});
</script>', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Method 3: API Endpoint</h5>
                <?= so_code_block('// PHP - API endpoint returning config
Route::get(\'/api/notifications\', function() {
    $notifications = [
        UiEngine::mediaObject()
            ->icon(\'check_circle\', \'success\')
            ->title(\'Success\')
            ->content(\'Your profile has been updated.\')
            ->toArray(),
        UiEngine::mediaObject()
            ->icon(\'warning\', \'warning\')
            ->title(\'Warning\')
            ->content(\'Your subscription expires soon.\')
            ->toArray(),
        UiEngine::mediaObject()
            ->icon(\'mail\', \'info\')
            ->title(\'New Message\')
            ->content(\'You have 3 unread messages.\')
            ->toArray()
    ];

    return response()->json([
        \'notifications\' => $notifications
    ]);
});', 'php') ?>

                <?= so_code_block('// JavaScript - Fetch and render
import { UiEngine } from \'./ui-engine/UiEngine.js\';

async function loadNotifications() {
    const response = await fetch(\'/api/notifications\');
    const data = await response.json();

    const container = document.getElementById(\'notifications\');
    container.innerHTML = \'\';

    data.notifications.forEach(config => {
        const media = UiEngine.fromConfig(config);

        // Add click handler
        media.onClick(() => {
            console.log(\'Notification clicked:\', config.title);
        });

        // Append to container
        container.innerHTML += media.render();
    });
}

loadNotifications();', 'javascript') ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete reference of CSS classes used by MediaObject.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Class</th>
                                <th style="width: 60%;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-media-object</code></td>
                                <td>Base media object container</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-img</code></td>
                                <td>Image element within media object</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon</code></td>
                                <td>Icon container within media object</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-body</code></td>
                                <td>Content container (title + content)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-title</code></td>
                                <td>Title heading (h5 by default)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-content</code></td>
                                <td>Main content paragraph</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-reverse</code></td>
                                <td>Reverse layout (media on right)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-img-sm</code></td>
                                <td>Small image size (48px)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-img-md</code></td>
                                <td>Medium image size (64px, default)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-img-lg</code></td>
                                <td>Large image size (96px)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-img-xl</code></td>
                                <td>Extra large image size (128px)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon-primary</code></td>
                                <td>Primary color variant for icon</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon-secondary</code></td>
                                <td>Secondary color variant for icon</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon-success</code></td>
                                <td>Success color variant for icon</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon-danger</code></td>
                                <td>Danger color variant for icon</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon-warning</code></td>
                                <td>Warning color variant for icon</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-icon-info</code></td>
                                <td>Info color variant for icon</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-align-top</code></td>
                                <td>Align media to top (default)</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-align-middle</code></td>
                                <td>Vertically center media</td>
                            </tr>
                            <tr>
                                <td><code>.so-media-object-align-bottom</code></td>
                                <td>Align media to bottom</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Demo Link -->
        <div class="so-card so-mb-4" id="demo-link">
            <div class="so-card-header">
                <h3 class="so-card-title">Additional Examples</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    For more CSS-based examples without UiEngine, visit the full demo page:
                </p>
                <a href="/demo/elements/media-object" class="so-btn so-btn-primary">
                    <span class="material-icons so-me-2">open_in_new</span>
                    View Full CSS Demo
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
