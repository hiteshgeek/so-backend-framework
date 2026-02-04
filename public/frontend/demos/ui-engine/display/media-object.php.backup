<?php
/**
 * SixOrbit UI Engine - Media Object Element Demo
 */

$pageTitle = 'Media Object - UI Engine';
$pageDescription = 'Layout for media with text content';

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
            <p class="so-page-subtitle">Layout pattern for media (image, icon) alongside text content, commonly used for comments and feeds.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Media Object -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Media Object</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-mb-4">
                    <div class="so-flex-shrink-0">
                        <div style="width:64px;height:64px;background:#6c757d;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <span class="material-icons so-text-white">person</span>
                        </div>
                    </div>
                    <div class="so-flex-grow-1 so-ms-3">
                        <h5 class="so-mt-0">John Doe</h5>
                        <p class="so-mb-0">This is some placeholder content for the media object. It demonstrates how text wraps around the media element.</p>
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

\$media = UiEngine::mediaObject()
    ->avatar('/avatars/john.jpg', 'John Doe')
    ->title('John Doe')
    ->body('This is some placeholder content for the media object.');

echo \$media->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const media = UiEngine.mediaObject()
    .avatar('/avatars/john.jpg', 'John Doe')
    .title('John Doe')
    .body('This is some placeholder content for the media object.');

document.getElementById('container').innerHTML = media.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatars/john.jpg" alt="John Doe" class="so-media-avatar">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">John Doe</h5>
        <p class="so-media-body">This is some placeholder content...</p>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icon -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icon Instead of Image</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-mb-4">
                    <div class="so-flex-shrink-0">
                        <div class="so-media-icon so-bg-primary" style="width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <span class="material-icons so-text-white">notifications</span>
                        </div>
                    </div>
                    <div class="so-flex-grow-1 so-ms-3">
                        <h5 class="so-mt-0">New Notification</h5>
                        <p class="so-mb-0">You have received a new message from the support team.</p>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-icon', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$media = UiEngine::mediaObject()
    ->icon('notifications', 'primary')
    ->title('New Notification')
    ->body('You have received a new message from the support team.');

echo \$media->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const media = UiEngine.mediaObject()
    .icon('notifications', 'primary')
    .title('New Notification')
    .body('You have received a new message from the support team.');

document.getElementById('container').innerHTML = media.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <div class="so-media-icon so-bg-primary">
            <span class="material-icons">notifications</span>
        </div>
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">New Notification</h5>
        <p class="so-media-body">You have received a new message...</p>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Media Position -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Media Position</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Position the media element on the left (start) or right (end) side of the content.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-flex-column so-gap-4 so-mb-4">
                    <!-- Media on the left (default) -->
                    <div>
                        <p class="so-text-muted so-mb-2 small">Media on Left (default):</p>
                        <div class="so-d-flex" style="max-width:500px;">
                            <div class="so-flex-shrink-0">
                                <div style="width:48px;height:48px;background:#0d6efd;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span class="material-icons so-text-white">person</span>
                                </div>
                            </div>
                            <div class="so-flex-grow-1 so-ms-3">
                                <h5 class="so-mt-0">Left Aligned</h5>
                                <p class="so-mb-0">Media element positioned on the left side of the content (default behavior).</p>
                            </div>
                        </div>
                    </div>
                    <!-- Media on the right -->
                    <div>
                        <p class="so-text-muted so-mb-2 small">Media on Right:</p>
                        <div class="so-d-flex" style="max-width:500px;">
                            <div class="so-flex-grow-1 so-me-3">
                                <h5 class="so-mt-0">Right Aligned</h5>
                                <p class="so-mb-0">Media element positioned on the right side of the content.</p>
                            </div>
                            <div class="so-flex-shrink-0">
                                <div style="width:48px;height:48px;background:#198754;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span class="material-icons so-text-white">person</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-position', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Media on the left (default)
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->position('start')  // or 'left'
    ->title('Left Aligned')
    ->body('Media is on the left side.');

// Media on the right
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->position('end')  // or 'right'
    ->title('Right Aligned')
    ->body('Media is on the right side.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Media on the left (default)
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .position('start')
    .title('Left Aligned')
    .body('Media is on the left side.');

// Media on the right
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .position('end')
    .title('Right Aligned')
    .body('Media is on the right side.');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Media on left (default) -->
<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar">
    </div>
    <div class="so-flex-grow-1 so-ms-3">...</div>
</div>

<!-- Media on right -->
<div class="so-media-object so-d-flex">
    <div class="so-flex-grow-1 so-me-3">...</div>
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar">
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Alignment -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Alignment</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-flex-column so-gap-4 so-mb-4">
                    <!-- Top aligned -->
                    <div class="so-d-flex so-align-items-start">
                        <div class="so-flex-shrink-0">
                            <div style="width:48px;height:48px;background:#6c757d;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h5 class="so-mt-0">Top Aligned</h5>
                            <p class="so-mb-0">This is a longer paragraph of text to demonstrate vertical alignment. The media element stays at the top while the text wraps below. This alignment is useful when you want the avatar to stay at the beginning of the content.</p>
                        </div>
                    </div>
                    <!-- Center aligned -->
                    <div class="so-d-flex so-align-items-center">
                        <div class="so-flex-shrink-0">
                            <div style="width:48px;height:48px;background:#0d6efd;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h5 class="so-mt-0">Center Aligned</h5>
                            <p class="so-mb-0">This is a longer paragraph of text to demonstrate vertical alignment. The media element stays centered vertically with the content. This works well for medium-length content.</p>
                        </div>
                    </div>
                    <!-- Bottom aligned -->
                    <div class="so-d-flex so-align-items-end">
                        <div class="so-flex-shrink-0">
                            <div style="width:48px;height:48px;background:#198754;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h5 class="so-mt-0">Bottom Aligned</h5>
                            <p class="so-mb-0">This is a longer paragraph of text to demonstrate vertical alignment. The media element stays at the bottom while content expands above it. Use this when you want the avatar aligned with the last line.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-align', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Top aligned (default)
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->align('top')
    ->title('Top Aligned')
    ->body('Long content here...');

// Center aligned
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->align('center')
    ->title('Center Aligned')
    ->body('Long content here...');

// Bottom aligned
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->align('bottom')
    ->title('Bottom Aligned')
    ->body('Long content here...');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Top aligned (default)
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .align('top')
    .title('Top Aligned')
    .body('Long content here...');

// Center aligned
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .align('center')
    .title('Center Aligned')
    .body('Long content here...');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Top aligned (default) -->
<div class="so-media-object so-d-flex so-align-items-start">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Top Aligned</h5>
        <p class="so-media-body">Long content here...</p>
    </div>
</div>

<!-- Center aligned -->
<div class="so-media-object so-d-flex so-align-items-center">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Center Aligned</h5>
        <p class="so-media-body">Long content here...</p>
    </div>
</div>

<!-- Bottom aligned -->
<div class="so-media-object so-d-flex so-align-items-end">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Bottom Aligned</h5>
        <p class="so-media-body">Long content here...</p>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Nested Media Objects -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Nested Media Objects (Comments)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <!-- Parent comment -->
                    <div class="so-d-flex so-mb-3">
                        <div class="so-flex-shrink-0">
                            <div style="width:48px;height:48px;background:#0d6efd;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h5 class="so-mt-0 so-mb-1">John Doe</h5>
                            <small class="so-text-muted">2 hours ago</small>
                            <p class="so-mt-2 so-mb-3">This is a parent comment. It demonstrates how nested media objects can be used to create threaded comment systems.</p>

                            <!-- First reply -->
                            <div class="so-d-flex so-mb-3">
                                <div class="so-flex-shrink-0">
                                    <div style="width:40px;height:40px;background:#198754;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                        <span class="material-icons so-text-white" style="font-size:18px;">person</span>
                                    </div>
                                </div>
                                <div class="so-flex-grow-1 so-ms-3">
                                    <h6 class="so-mt-0 so-mb-1">Jane Smith</h6>
                                    <small class="so-text-muted">1 hour ago</small>
                                    <p class="so-mt-2 so-mb-0">This is a reply to the comment. Nested media objects make this easy!</p>
                                </div>
                            </div>

                            <!-- Second reply -->
                            <div class="so-d-flex">
                                <div class="so-flex-shrink-0">
                                    <div style="width:40px;height:40px;background:#dc3545;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                        <span class="material-icons so-text-white" style="font-size:18px;">person</span>
                                    </div>
                                </div>
                                <div class="so-flex-grow-1 so-ms-3">
                                    <h6 class="so-mt-0 so-mb-1">Bob Wilson</h6>
                                    <small class="so-text-muted">30 minutes ago</small>
                                    <p class="so-mt-2 so-mb-0">Another reply here. You can nest as deeply as needed.</p>
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
                        'code' => "\$comment = UiEngine::mediaObject()
    ->avatar('/avatars/john.jpg')
    ->title('John Doe')
    ->subtitle('2 hours ago')
    ->body('This is a parent comment.')
    ->child(UiEngine::mediaObject()
        ->avatar('/avatars/jane.jpg')
        ->title('Jane Smith')
        ->subtitle('1 hour ago')
        ->body('This is a reply to the comment.')
    )
    ->child(UiEngine::mediaObject()
        ->avatar('/avatars/bob.jpg')
        ->title('Bob Wilson')
        ->subtitle('30 minutes ago')
        ->body('Another reply here.')
    );

echo \$comment->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const comment = UiEngine.mediaObject()
    .avatar('/avatars/john.jpg')
    .title('John Doe')
    .subtitle('2 hours ago')
    .body('This is a parent comment.')
    .child(UiEngine.mediaObject()
        .avatar('/avatars/jane.jpg')
        .title('Jane Smith')
        .subtitle('1 hour ago')
        .body('This is a reply to the comment.')
    )
    .child(UiEngine.mediaObject()
        .avatar('/avatars/bob.jpg')
        .title('Bob Wilson')
        .subtitle('30 minutes ago')
        .body('Another reply here.')
    );

document.getElementById('container').innerHTML = comment.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatars/john.jpg" alt="John Doe" class="so-media-avatar">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">John Doe</h5>
        <small class="so-media-subtitle so-text-muted">2 hours ago</small>
        <p class="so-media-body">This is a parent comment.</p>

        <!-- Nested child 1 -->
        <div class="so-media-object so-d-flex so-mt-3">
            <div class="so-flex-shrink-0">
                <img src="/avatars/jane.jpg" alt="Jane Smith" class="so-media-avatar so-media-avatar-sm">
            </div>
            <div class="so-flex-grow-1 so-ms-3">
                <h6 class="so-media-title">Jane Smith</h6>
                <small class="so-media-subtitle so-text-muted">1 hour ago</small>
                <p class="so-media-body">This is a reply to the comment.</p>
            </div>
        </div>

        <!-- Nested child 2 -->
        <div class="so-media-object so-d-flex so-mt-3">
            <div class="so-flex-shrink-0">
                <img src="/avatars/bob.jpg" alt="Bob Wilson" class="so-media-avatar so-media-avatar-sm">
            </div>
            <div class="so-flex-grow-1 so-ms-3">
                <h6 class="so-media-title">Bob Wilson</h6>
                <small class="so-media-subtitle so-text-muted">30 minutes ago</small>
                <p class="so-media-body">Another reply here.</p>
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Media Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Media Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-flex-column so-gap-4 so-mb-4">
                    <!-- Small (32px) -->
                    <div class="so-d-flex so-align-items-center">
                        <div class="so-flex-shrink-0">
                            <div style="width:32px;height:32px;background:#6c757d;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white" style="font-size:16px;">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h6 class="so-mt-0 so-mb-0">Small Size (32px)</h6>
                            <p class="so-mb-0 so-text-muted small">Compact media object for tight spaces</p>
                        </div>
                    </div>
                    <!-- Medium (48px) - default -->
                    <div class="so-d-flex so-align-items-center">
                        <div class="so-flex-shrink-0">
                            <div style="width:48px;height:48px;background:#0d6efd;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h5 class="so-mt-0 so-mb-0">Medium Size (48px) - Default</h5>
                            <p class="so-mb-0 so-text-muted">Standard size for most use cases</p>
                        </div>
                    </div>
                    <!-- Large (64px) -->
                    <div class="so-d-flex so-align-items-center">
                        <div class="so-flex-shrink-0">
                            <div style="width:64px;height:64px;background:#198754;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white" style="font-size:32px;">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h4 class="so-mt-0 so-mb-0">Large Size (64px)</h4>
                            <p class="so-mb-0 so-text-muted">Prominent display for featured content</p>
                        </div>
                    </div>
                    <!-- Custom (100px) -->
                    <div class="so-d-flex so-align-items-center">
                        <div class="so-flex-shrink-0">
                            <div style="width:100px;height:100px;background:#6f42c1;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span class="material-icons so-text-white" style="font-size:48px;">person</span>
                            </div>
                        </div>
                        <div class="so-flex-grow-1 so-ms-3">
                            <h3 class="so-mt-0 so-mb-0">Custom Size (100px)</h3>
                            <p class="so-mb-0 so-text-muted">Any pixel value for complete control</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('media-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small media (32px)
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->mediaSize('sm')
    ->title('Small');

// Medium media (48px) - default
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->title('Medium');

// Large media (64px)
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->mediaSize('lg')
    ->title('Large');

// Custom size
UiEngine::mediaObject()
    ->avatar('/avatar.jpg')
    ->mediaSize(100) // 100px
    ->title('Custom Size');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small media (32px)
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .mediaSize('sm')
    .title('Small');

// Large media (64px)
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .mediaSize('lg')
    .title('Large');

// Custom size
UiEngine.mediaObject()
    .avatar('/avatar.jpg')
    .mediaSize(100)
    .title('Custom Size');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small (32px) -->
<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar so-media-avatar-sm" style="width:32px;height:32px;">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Small</h5>
    </div>
</div>

<!-- Medium (48px) - default -->
<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar" style="width:48px;height:48px;">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Medium</h5>
    </div>
</div>

<!-- Large (64px) -->
<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar so-media-avatar-lg" style="width:64px;height:64px;">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Large</h5>
    </div>
</div>

<!-- Custom (100px) -->
<div class="so-media-object so-d-flex">
    <div class="so-flex-shrink-0">
        <img src="/avatar.jpg" class="so-media-avatar" style="width:100px;height:100px;">
    </div>
    <div class="so-flex-grow-1 so-ms-3">
        <h5 class="so-media-title">Custom Size</h5>
    </div>
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
                                <td><code>avatar()</code></td>
                                <td><code>string $src, string $alt</code></td>
                                <td>Set avatar image</td>
                            </tr>
                            <tr>
                                <td><code>icon()</code></td>
                                <td><code>string $icon, string $color</code></td>
                                <td>Use icon instead of image</td>
                            </tr>
                            <tr>
                                <td><code>title()</code></td>
                                <td><code>string $title</code></td>
                                <td>Set title text</td>
                            </tr>
                            <tr>
                                <td><code>subtitle()</code></td>
                                <td><code>string $subtitle</code></td>
                                <td>Set subtitle text</td>
                            </tr>
                            <tr>
                                <td><code>body()</code></td>
                                <td><code>string $content</code></td>
                                <td>Set body content</td>
                            </tr>
                            <tr>
                                <td><code>position()</code></td>
                                <td><code>string $position</code></td>
                                <td>Media position: start, end</td>
                            </tr>
                            <tr>
                                <td><code>align()</code></td>
                                <td><code>string $align</code></td>
                                <td>Vertical align: top, center, bottom</td>
                            </tr>
                            <tr>
                                <td><code>mediaSize()</code></td>
                                <td><code>string|int $size</code></td>
                                <td>Media size: sm, lg, or pixels</td>
                            </tr>
                            <tr>
                                <td><code>child()</code></td>
                                <td><code>MediaObject $child</code></td>
                                <td>Add nested media object</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
