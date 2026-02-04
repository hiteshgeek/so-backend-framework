<?php
/**
 * SixOrbit UI Demo - Popover
 */
$pageTitle = 'Popover';
$pageDescription = 'Floating content boxes that display additional information on hover or click.';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

<!-- Basic Popover -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Popover</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Click the button to toggle the popover.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap">
                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-primary" data-popover-toggle="popover1">Click me</button>
                        <div class="so-popover" id="popover1">
                            <div class="so-popover-body">
                                This is a basic popover with just content.
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-popover-wrapper"&gt;
    &lt;button class="so-btn so-btn-primary" data-popover-toggle="myPopover"&gt;Click me&lt;/button&gt;
    &lt;div class="so-popover" id="myPopover"&gt;
        &lt;div class="so-popover-body"&gt;
            Popover content here.
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Popover with Header -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Popover with Header</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Popovers can include a title header.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap">
                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="popover2">With Header</button>
                        <div class="so-popover" id="popover2">
                            <div class="so-popover-header">
                                <h6 class="so-popover-title">Popover Title</h6>
                            </div>
                            <div class="so-popover-body">
                                And here's some amazing content. It's very engaging. Right?
                            </div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="popover3">Dismissible</button>
                        <div class="so-popover" id="popover3">
                            <div class="so-popover-header">
                                <h6 class="so-popover-title">Dismissible Popover</h6>
                                <button class="so-popover-close" data-popover-close>&times;</button>
                            </div>
                            <div class="so-popover-body">
                                Click the X button to close this popover.
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-popover-wrapper"&gt;
    &lt;button class="so-btn so-btn-outline" data-popover-toggle="myPopover"&gt;With Header&lt;/button&gt;
    &lt;div class="so-popover" id="myPopover"&gt;
        &lt;div class="so-popover-header"&gt;
            &lt;h6 class="so-popover-title"&gt;Popover Title&lt;/h6&gt;
            &lt;button class="so-popover-close" data-popover-close&gt;&amp;times;&lt;/button&gt;
        &lt;/div&gt;
        &lt;div class="so-popover-body"&gt;Content here...&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Popover Positions -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Popover Positions</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Popovers can appear in different positions.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap so-justify-content-center so-py-5">
                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="popoverTop">Top</button>
                        <div class="so-popover so-popover-top" id="popoverTop">
                            <div class="so-popover-body">Popover on top</div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="popoverRight">Right</button>
                        <div class="so-popover so-popover-right" id="popoverRight">
                            <div class="so-popover-body">Popover on right</div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="popoverBottom">Bottom</button>
                        <div class="so-popover so-popover-bottom" id="popoverBottom">
                            <div class="so-popover-body">Popover on bottom</div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="popoverLeft">Left</button>
                        <div class="so-popover so-popover-left" id="popoverLeft">
                            <div class="so-popover-body">Popover on left</div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Top position --&gt;
&lt;div class="so-popover so-popover-top"&gt;...&lt;/div&gt;

&lt;!-- Right position --&gt;
&lt;div class="so-popover so-popover-right"&gt;...&lt;/div&gt;

&lt;!-- Bottom position (default) --&gt;
&lt;div class="so-popover so-popover-bottom"&gt;...&lt;/div&gt;

&lt;!-- Left position --&gt;
&lt;div class="so-popover so-popover-left"&gt;...&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Hover Trigger -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Hover Trigger</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Popovers that appear on hover instead of click.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap">
                    <div class="so-popover-wrapper so-popover-hover">
                        <button class="so-btn so-btn-success">Hover me</button>
                        <div class="so-popover so-popover-top">
                            <div class="so-popover-body">
                                This popover appears when you hover!
                            </div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper so-popover-hover">
                        <span class="so-badge so-badge-info">
                            <span class="material-icons so-text-sm">help</span>
                            Help
                        </span>
                        <div class="so-popover so-popover-top">
                            <div class="so-popover-body">
                                Hover over items for quick help information.
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-popover-wrapper so-popover-hover"&gt;
    &lt;button class="so-btn so-btn-success"&gt;Hover me&lt;/button&gt;
    &lt;div class="so-popover so-popover-top"&gt;
        &lt;div class="so-popover-body"&gt;Content here...&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Rich Content Popover -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Rich Content Popover</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Popovers can contain rich HTML content.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap">
                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-primary" data-popover-toggle="richPopover">
                            <span class="material-icons">person</span>
                            User Profile
                        </button>
                        <div class="so-popover so-popover-lg" id="richPopover">
                            <div class="so-popover-body">
                                <div class="so-d-flex so-gap-3 so-align-items-center so-mb-3">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Connor&background=667eea&color=fff&size=64" alt="Sarah" style="width: 64px; height: 64px; border-radius: 50%;">
                                    <div>
                                        <h6 class="so-mb-0">Sarah Connor</h6>
                                        <span class="so-text-muted so-text-sm">Product Designer</span>
                                    </div>
                                </div>
                                <p class="so-text-sm so-text-muted so-mb-3">Designing beautiful and functional user interfaces since 2015.</p>
                                <div class="so-d-flex so-gap-2">
                                    <button class="so-btn so-btn-sm so-btn-primary">Follow</button>
                                    <button class="so-btn so-btn-sm so-btn-outline">Message</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-warning" data-popover-toggle="listPopover">
                            <span class="material-icons">notifications</span>
                            Notifications
                        </button>
                        <div class="so-popover so-popover-lg" id="listPopover">
                            <div class="so-popover-header">
                                <h6 class="so-popover-title">Recent Notifications</h6>
                            </div>
                            <div class="so-popover-body so-p-0">
                                <div class="so-list-group so-list-group-flush">
                                    <a href="#" class="so-list-group-item so-list-group-item-action">
                                        <div class="so-d-flex so-gap-2">
                                            <span class="material-icons so-text-primary">mail</span>
                                            <div>
                                                <div>New message received</div>
                                                <small class="so-text-muted">2 minutes ago</small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="so-list-group-item so-list-group-item-action">
                                        <div class="so-d-flex so-gap-2">
                                            <span class="material-icons so-text-success">check_circle</span>
                                            <div>
                                                <div>Task completed</div>
                                                <small class="so-text-muted">1 hour ago</small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="so-list-group-item so-list-group-item-action">
                                        <div class="so-d-flex so-gap-2">
                                            <span class="material-icons so-text-warning">warning</span>
                                            <div>
                                                <div>System update required</div>
                                                <small class="so-text-muted">Yesterday</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- User Profile Popover --&gt;
&lt;div class="so-popover-wrapper"&gt;
    &lt;button class="so-btn so-btn-primary" data-popover-toggle="richPopover"&gt;
        &lt;span class="material-icons"&gt;person&lt;/span&gt;
        User Profile
    &lt;/button&gt;
    &lt;div class="so-popover so-popover-lg" id="richPopover"&gt;
        &lt;div class="so-popover-body"&gt;
            &lt;div class="so-d-flex so-gap-3 so-align-items-center so-mb-3"&gt;
                &lt;img src="avatar.jpg" alt="User" style="width: 64px; border-radius: 50%;"&gt;
                &lt;div&gt;
                    &lt;h6 class="so-mb-0"&gt;Sarah Connor&lt;/h6&gt;
                    &lt;span class="so-text-muted"&gt;Product Designer&lt;/span&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;p class="so-text-sm so-text-muted so-mb-3"&gt;User bio here...&lt;/p&gt;
            &lt;div class="so-d-flex so-gap-2"&gt;
                &lt;button class="so-btn so-btn-sm so-btn-primary"&gt;Follow&lt;/button&gt;
                &lt;button class="so-btn so-btn-sm so-btn-outline"&gt;Message&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Notifications Popover --&gt;
&lt;div class="so-popover-wrapper"&gt;
    &lt;button class="so-btn so-btn-warning" data-popover-toggle="listPopover"&gt;Notifications&lt;/button&gt;
    &lt;div class="so-popover so-popover-lg" id="listPopover"&gt;
        &lt;div class="so-popover-header"&gt;
            &lt;h6 class="so-popover-title"&gt;Recent Notifications&lt;/h6&gt;
        &lt;/div&gt;
        &lt;div class="so-popover-body so-p-0"&gt;
            &lt;div class="so-list-group so-list-group-flush"&gt;
                &lt;a href="#" class="so-list-group-item so-list-group-item-action"&gt;...&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Image Popover -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Image Popover</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Popover containing image content.</p>

                <div class="so-popover-wrapper so-popover-hover">
                    <a href="#" class="so-link">
                        <span class="material-icons">image</span>
                        Preview Image
                    </a>
                    <div class="so-popover so-popover-top so-popover-image">
                        <img src="https://picsum.photos/300/200" alt="Preview" style="border-radius: 8px;">
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-popover-wrapper so-popover-hover"&gt;
    &lt;a href="#" class="so-link"&gt;Preview Image&lt;/a&gt;
    &lt;div class="so-popover so-popover-top so-popover-image"&gt;
        &lt;img src="image.jpg" alt="Preview"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Form Popover -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Form Popover</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Popovers can contain form elements.</p>

                <div class="so-popover-wrapper">
                    <button class="so-btn so-btn-info" data-popover-toggle="formPopover">
                        <span class="material-icons">edit</span>
                        Quick Edit
                    </button>
                    <div class="so-popover so-popover-lg" id="formPopover">
                        <div class="so-popover-header">
                            <h6 class="so-popover-title">Edit Settings</h6>
                            <button class="so-popover-close" data-popover-close>&times;</button>
                        </div>
                        <div class="so-popover-body">
                            <form>
                                <div class="so-form-group">
                                    <label class="so-form-label">Name</label>
                                    <input type="text" class="so-form-control so-form-control-sm" placeholder="Enter name">
                                </div>
                                <div class="so-form-group">
                                    <label class="so-form-label">Status</label>
                                    <select class="so-form-control so-form-control-sm">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                        <option>Pending</option>
                                    </select>
                                </div>
                                <div class="so-d-flex so-gap-2 so-justify-content-end">
                                    <button type="button" class="so-btn so-btn-sm so-btn-outline" data-popover-close>Cancel</button>
                                    <button type="submit" class="so-btn so-btn-sm so-btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-popover-wrapper"&gt;
    &lt;button class="so-btn so-btn-info" data-popover-toggle="formPopover"&gt;
        &lt;span class="material-icons"&gt;edit&lt;/span&gt;
        Quick Edit
    &lt;/button&gt;
    &lt;div class="so-popover so-popover-lg" id="formPopover"&gt;
        &lt;div class="so-popover-header"&gt;
            &lt;h6 class="so-popover-title"&gt;Edit Settings&lt;/h6&gt;
            &lt;button class="so-popover-close" data-popover-close&gt;&amp;times;&lt;/button&gt;
        &lt;/div&gt;
        &lt;div class="so-popover-body"&gt;
            &lt;form&gt;
                &lt;div class="so-form-group"&gt;
                    &lt;label class="so-form-label"&gt;Name&lt;/label&gt;
                    &lt;input type="text" class="so-form-control so-form-control-sm"&gt;
                &lt;/div&gt;
                &lt;div class="so-form-group"&gt;
                    &lt;label class="so-form-label"&gt;Status&lt;/label&gt;
                    &lt;select class="so-form-control so-form-control-sm"&gt;
                        &lt;option&gt;Active&lt;/option&gt;
                        &lt;option&gt;Inactive&lt;/option&gt;
                    &lt;/select&gt;
                &lt;/div&gt;
                &lt;div class="so-d-flex so-gap-2 so-justify-content-end"&gt;
                    &lt;button type="button" class="so-btn so-btn-sm so-btn-outline" data-popover-close&gt;Cancel&lt;/button&gt;
                    &lt;button type="submit" class="so-btn so-btn-sm so-btn-primary"&gt;Save&lt;/button&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Confirmation Popover -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Confirmation Popover</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Use popovers for confirmation dialogs.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap">
                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-danger" data-popover-toggle="confirmPopover">
                            <span class="material-icons">delete</span>
                            Delete Item
                        </button>
                        <div class="so-popover" id="confirmPopover">
                            <div class="so-popover-body so-text-center">
                                <span class="material-icons so-text-danger" style="font-size: 48px;">warning</span>
                                <p class="so-mt-2 so-mb-3">Are you sure you want to delete this item?</p>
                                <div class="so-d-flex so-gap-2 so-justify-content-center">
                                    <button class="so-btn so-btn-sm so-btn-outline" data-popover-close>Cancel</button>
                                    <button class="so-btn so-btn-sm so-btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-popover-wrapper"&gt;
    &lt;button class="so-btn so-btn-danger" data-popover-toggle="confirmPopover"&gt;
        &lt;span class="material-icons"&gt;delete&lt;/span&gt;
        Delete Item
    &lt;/button&gt;
    &lt;div class="so-popover" id="confirmPopover"&gt;
        &lt;div class="so-popover-body so-text-center"&gt;
            &lt;span class="material-icons so-text-danger" style="font-size: 48px;"&gt;warning&lt;/span&gt;
            &lt;p class="so-mt-2 so-mb-3"&gt;Are you sure you want to delete this item?&lt;/p&gt;
            &lt;div class="so-d-flex so-gap-2 so-justify-content-center"&gt;
                &lt;button class="so-btn so-btn-sm so-btn-outline" data-popover-close&gt;Cancel&lt;/button&gt;
                &lt;button class="so-btn so-btn-sm so-btn-danger"&gt;Delete&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Size Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Size Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Different popover sizes for various content needs.</p>

                <div class="so-d-flex so-gap-3 so-flex-wrap">
                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="smallPopover">Small</button>
                        <div class="so-popover so-popover-sm" id="smallPopover">
                            <div class="so-popover-body">
                                Small popover content.
                            </div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="defaultPopover">Default</button>
                        <div class="so-popover" id="defaultPopover">
                            <div class="so-popover-body">
                                Default sized popover with medium content area.
                            </div>
                        </div>
                    </div>

                    <div class="so-popover-wrapper">
                        <button class="so-btn so-btn-outline" data-popover-toggle="largePopover">Large</button>
                        <div class="so-popover so-popover-lg" id="largePopover">
                            <div class="so-popover-body">
                                Large popover with more space for extended content and additional information.
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Small popover --&gt;
&lt;div class="so-popover so-popover-sm"&gt;...&lt;/div&gt;

&lt;!-- Default popover --&gt;
&lt;div class="so-popover"&gt;...&lt;/div&gt;

&lt;!-- Large popover --&gt;
&lt;div class="so-popover so-popover-lg"&gt;...&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Popover vs Tooltip -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Popover vs Tooltip</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Comparison between popovers and tooltips.</p>

        <div class="so-table-responsive">
            <table class="so-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Popover</th>
                        <th>Tooltip</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Trigger</td>
                        <td>Click (default) or Hover</td>
                        <td>Hover (default)</td>
                    </tr>
                    <tr>
                        <td>Content</td>
                        <td>Rich HTML, forms, images</td>
                        <td>Simple text only</td>
                    </tr>
                    <tr>
                        <td>Size</td>
                        <td>Larger, configurable</td>
                        <td>Small, compact</td>
                    </tr>
                    <tr>
                        <td>Dismissal</td>
                        <td>Click outside or close button</td>
                        <td>Mouse leave</td>
                    </tr>
                    <tr>
                        <td>Use Case</td>
                        <td>Detailed info, actions, forms</td>
                        <td>Quick hints, labels</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Popover Styles */
.so-popover-wrapper {
    position: relative;
    display: inline-block;
}

.so-popover {
    position: absolute;
    z-index: 1070;
    display: none;
    min-width: 200px;
    max-width: 300px;
    background: var(--so-card-bg);
    border: 1px solid var(--so-border-color);
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
}

.so-popover.show {
    display: block;
    opacity: 1;
}

.so-popover-sm { max-width: 180px; }
.so-popover-lg { max-width: 400px; }

/* Positions */
.so-popover-top {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-8px);
    margin-bottom: 8px;
}

.so-popover-bottom {
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(8px);
    margin-top: 8px;
}

.so-popover-left {
    right: 100%;
    top: 50%;
    transform: translateY(-50%) translateX(-8px);
    margin-right: 8px;
}

.so-popover-right {
    left: 100%;
    top: 50%;
    transform: translateY(-50%) translateX(8px);
    margin-left: 8px;
}

/* Default position (bottom) */
.so-popover:not(.so-popover-top):not(.so-popover-left):not(.so-popover-right) {
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(8px);
    margin-top: 8px;
}

/* Header */
.so-popover-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-bottom: 1px solid var(--so-border-color);
    background: var(--so-card-hover-bg);
    border-radius: 8px 8px 0 0;
}

.so-popover-title {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.so-popover-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: var(--so-text-muted);
    line-height: 1;
    padding: 0;
}

.so-popover-close:hover {
    color: var(--so-text-color);
}

/* Body */
.so-popover-body {
    padding: 12px 16px;
}

/* Image popover */
.so-popover-image {
    padding: 8px;
}

.so-popover-image img {
    max-width: 100%;
    height: auto;
}

/* Hover trigger */
.so-popover-hover .so-popover {
    pointer-events: none;
}

.so-popover-hover:hover .so-popover {
    display: block;
    opacity: 1;
    pointer-events: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle popovers on click
    document.querySelectorAll('[data-popover-toggle]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const popoverId = this.getAttribute('data-popover-toggle');
            const popover = document.getElementById(popoverId);

            // Close all other popovers
            document.querySelectorAll('.so-popover.show').forEach(p => {
                if (p.id !== popoverId) p.classList.remove('show');
            });

            // Toggle current popover
            popover.classList.toggle('show');
        });
    });

    // Close popover buttons
    document.querySelectorAll('[data-popover-close]').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            this.closest('.so-popover').classList.remove('show');
        });
    });

    // Close popovers when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.so-popover-wrapper')) {
            document.querySelectorAll('.so-popover.show').forEach(p => {
                p.classList.remove('show');
            });
        }
    });
});

function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const code = codeBlock.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
