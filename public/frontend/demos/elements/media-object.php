<?php
/**
 * SixOrbit UI Demo - Media Object
 */
$pageTitle = 'Media Object';
$pageDescription = 'Flexible layout pattern for media alongside content, perfect for comments, notifications, and list items.';

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

<!-- Basic Media Object -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Media Object</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Standard media object with image and text content.</p>

                <div class="so-media">
                    <div class="so-media-left">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=667eea&color=fff&size=64" alt="John Doe" class="so-media-image">
                    </div>
                    <div class="so-media-body">
                        <h5 class="so-media-heading">John Doe</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media"&gt;
    &lt;div class="so-media-left"&gt;
        &lt;img src="avatar.jpg" alt="Name" class="so-media-image"&gt;
    &lt;/div&gt;
    &lt;div class="so-media-body"&gt;
        &lt;h5 class="so-media-heading"&gt;John Doe&lt;/h5&gt;
        &lt;p&gt;Content text here...&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Media Object with Right Image -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Media Object with Right Image</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Media positioned on the right side.</p>

                <div class="so-media">
                    <div class="so-media-body">
                        <h5 class="so-media-heading">Featured Article</h5>
                        <p>This is an example of a media object with the image on the right side. Perfect for alternating layouts or feature highlights.</p>
                        <a href="#" class="so-link">Read more</a>
                    </div>
                    <div class="so-media-right">
                        <img src="https://ui-avatars.com/api/?name=Featured&background=f093fb&color=fff&size=80" alt="Featured" class="so-media-image">
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media"&gt;
    &lt;div class="so-media-body"&gt;
        &lt;h5 class="so-media-heading"&gt;Title&lt;/h5&gt;
        &lt;p&gt;Content...&lt;/p&gt;
    &lt;/div&gt;
    &lt;div class="so-media-right"&gt;
        &lt;img src="image.jpg" class="so-media-image"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Vertical Alignment -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Vertical Alignment</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Control vertical alignment of media elements.</p>

                <div class="so-d-flex so-flex-column so-gap-4">
                    <div>
                        <h6 class="so-text-muted so-mb-2">Top Aligned (Default)</h6>
                        <div class="so-media">
                            <div class="so-media-left">
                                <img src="https://ui-avatars.com/api/?name=Top&background=667eea&color=fff&size=48" alt="Top" class="so-media-image">
                            </div>
                            <div class="so-media-body">
                                <h5 class="so-media-heading">Top Alignment</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="so-text-muted so-mb-2">Middle Aligned</h6>
                        <div class="so-media so-media-middle">
                            <div class="so-media-left">
                                <img src="https://ui-avatars.com/api/?name=Middle&background=4facfe&color=fff&size=48" alt="Middle" class="so-media-image">
                            </div>
                            <div class="so-media-body">
                                <h5 class="so-media-heading">Middle Alignment</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="so-text-muted so-mb-2">Bottom Aligned</h6>
                        <div class="so-media so-media-bottom">
                            <div class="so-media-left">
                                <img src="https://ui-avatars.com/api/?name=Bottom&background=f093fb&color=fff&size=48" alt="Bottom" class="so-media-image">
                            </div>
                            <div class="so-media-body">
                                <h5 class="so-media-heading">Bottom Alignment</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Top aligned (default) --&gt;
&lt;div class="so-media"&gt;...&lt;/div&gt;

&lt;!-- Middle aligned --&gt;
&lt;div class="so-media so-media-middle"&gt;...&lt;/div&gt;

&lt;!-- Bottom aligned --&gt;
&lt;div class="so-media so-media-bottom"&gt;...&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Media Object with Icon -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Media Object with Icon</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Use icons instead of images.</p>

                <div class="so-d-flex so-flex-column so-gap-4">
                    <div class="so-media">
                        <div class="so-media-left">
                            <div class="so-media-icon so-media-icon-primary">
                                <span class="material-icons">notifications</span>
                            </div>
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">New Notification</h5>
                            <p class="so-text-muted">You have received a new message from the support team.</p>
                        </div>
                    </div>

                    <div class="so-media">
                        <div class="so-media-left">
                            <div class="so-media-icon so-media-icon-success">
                                <span class="material-icons">check_circle</span>
                            </div>
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">Task Completed</h5>
                            <p class="so-text-muted">Your scheduled backup has completed successfully.</p>
                        </div>
                    </div>

                    <div class="so-media">
                        <div class="so-media-left">
                            <div class="so-media-icon so-media-icon-warning">
                                <span class="material-icons">warning</span>
                            </div>
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">Storage Warning</h5>
                            <p class="so-text-muted">You're running low on storage space. Consider upgrading your plan.</p>
                        </div>
                    </div>

                    <div class="so-media">
                        <div class="so-media-left">
                            <div class="so-media-icon so-media-icon-danger">
                                <span class="material-icons">error</span>
                            </div>
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">Connection Error</h5>
                            <p class="so-text-muted">Failed to connect to the server. Please try again later.</p>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media"&gt;
    &lt;div class="so-media-left"&gt;
        &lt;div class="so-media-icon so-media-icon-primary"&gt;
            &lt;span class="material-icons"&gt;notifications&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-media-body"&gt;
        &lt;h5 class="so-media-heading"&gt;Title&lt;/h5&gt;
        &lt;p class="so-text-muted"&gt;Description&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Icon color variants: so-media-icon-success, so-media-icon-warning, so-media-icon-danger --&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Nested Media Objects -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Nested Media Objects</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Create threaded comments or nested replies.</p>

                <div class="so-media">
                    <div class="so-media-left">
                        <img src="https://ui-avatars.com/api/?name=Alice&background=667eea&color=fff&size=48" alt="Alice" class="so-media-image">
                    </div>
                    <div class="so-media-body">
                        <h5 class="so-media-heading">Alice Johnson <span class="so-text-muted so-text-sm so-ms-2">2 hours ago</span></h5>
                        <p>This is a great feature! I've been waiting for threaded comments for a while.</p>

                        <!-- Nested Reply -->
                        <div class="so-media so-media-nested">
                            <div class="so-media-left">
                                <img src="https://ui-avatars.com/api/?name=Bob&background=f093fb&color=fff&size=40" alt="Bob" class="so-media-image">
                            </div>
                            <div class="so-media-body">
                                <h6 class="so-media-heading">Bob Smith <span class="so-text-muted so-text-sm so-ms-2">1 hour ago</span></h6>
                                <p>I agree! The nested structure makes conversations much easier to follow.</p>

                                <!-- Deeper nested reply -->
                                <div class="so-media so-media-nested">
                                    <div class="so-media-left">
                                        <img src="https://ui-avatars.com/api/?name=Alice&background=667eea&color=fff&size=32" alt="Alice" class="so-media-image">
                                    </div>
                                    <div class="so-media-body">
                                        <h6 class="so-media-heading">Alice Johnson <span class="so-text-muted so-text-sm so-ms-2">30 minutes ago</span></h6>
                                        <p>Thanks Bob! Let me know if you have any other feedback.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Another Reply -->
                        <div class="so-media so-media-nested">
                            <div class="so-media-left">
                                <img src="https://ui-avatars.com/api/?name=Carol&background=4facfe&color=fff&size=40" alt="Carol" class="so-media-image">
                            </div>
                            <div class="so-media-body">
                                <h6 class="so-media-heading">Carol White <span class="so-text-muted so-text-sm so-ms-2">45 minutes ago</span></h6>
                                <p>Love it! Can we also get notifications for replies?</p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media"&gt;
    &lt;div class="so-media-left"&gt;...&lt;/div&gt;
    &lt;div class="so-media-body"&gt;
        &lt;h5 class="so-media-heading"&gt;Parent Comment&lt;/h5&gt;
        &lt;p&gt;Comment content...&lt;/p&gt;

        &lt;!-- Nested reply --&gt;
        &lt;div class="so-media so-media-nested"&gt;
            &lt;div class="so-media-left"&gt;...&lt;/div&gt;
            &lt;div class="so-media-body"&gt;
                &lt;h6 class="so-media-heading"&gt;Reply&lt;/h6&gt;
                &lt;p&gt;Reply content...&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Media Object List -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Media Object List</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Multiple media objects in a list.</p>

                <div class="so-media-list">
                    <div class="so-media so-media-list-item">
                        <div class="so-media-left">
                            <img src="https://ui-avatars.com/api/?name=New+Feature&background=667eea&color=fff&size=48" alt="Feature" class="so-media-image">
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">New Feature Released</h5>
                            <p class="so-text-muted so-mb-0">Check out our latest dashboard improvements.</p>
                        </div>
                        <div class="so-media-meta">
                            <span class="so-badge so-badge-primary">New</span>
                        </div>
                    </div>

                    <div class="so-media so-media-list-item">
                        <div class="so-media-left">
                            <img src="https://ui-avatars.com/api/?name=Bug+Fix&background=28a745&color=fff&size=48" alt="Bug Fix" class="so-media-image">
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">Bug Fixes</h5>
                            <p class="so-text-muted so-mb-0">Several performance issues have been resolved.</p>
                        </div>
                        <div class="so-media-meta">
                            <span class="so-text-muted so-text-sm">Yesterday</span>
                        </div>
                    </div>

                    <div class="so-media so-media-list-item">
                        <div class="so-media-left">
                            <img src="https://ui-avatars.com/api/?name=Update&background=ffc107&color=fff&size=48" alt="Update" class="so-media-image">
                        </div>
                        <div class="so-media-body">
                            <h5 class="so-media-heading">System Update</h5>
                            <p class="so-text-muted so-mb-0">Scheduled maintenance completed successfully.</p>
                        </div>
                        <div class="so-media-meta">
                            <span class="so-text-muted so-text-sm">2 days ago</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media-list"&gt;
    &lt;div class="so-media so-media-list-item"&gt;
        &lt;div class="so-media-left"&gt;...&lt;/div&gt;
        &lt;div class="so-media-body"&gt;
            &lt;h5 class="so-media-heading"&gt;Title&lt;/h5&gt;
            &lt;p class="so-text-muted so-mb-0"&gt;Description&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="so-media-meta"&gt;
            &lt;span class="so-badge so-badge-primary"&gt;New&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Media Object with Actions -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Media Object with Actions</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Include action buttons or links.</p>

                <div class="so-media">
                    <div class="so-media-left">
                        <img src="https://ui-avatars.com/api/?name=Product&background=667eea&color=fff&size=80" alt="Product" class="so-media-image so-media-image-rounded">
                    </div>
                    <div class="so-media-body">
                        <h5 class="so-media-heading">Premium Subscription</h5>
                        <p class="so-text-muted">Unlock all features including advanced analytics, priority support, and unlimited storage.</p>
                        <div class="so-d-flex so-gap-2">
                            <button class="so-btn so-btn-primary so-btn-sm">Upgrade Now</button>
                            <button class="so-btn so-btn-outline so-btn-sm">Learn More</button>
                        </div>
                    </div>
                    <div class="so-media-meta">
                        <span class="so-badge so-badge-warning">Save 20%</span>
                    </div>
                </div>

                <hr class="so-my-4">

                <div class="so-media">
                    <div class="so-media-left">
                        <img src="https://ui-avatars.com/api/?name=Sarah&background=f093fb&color=fff&size=64" alt="Sarah" class="so-media-image">
                    </div>
                    <div class="so-media-body">
                        <h5 class="so-media-heading">Sarah Connor</h5>
                        <p class="so-text-muted">Product Designer at Acme Inc.</p>
                        <div class="so-d-flex so-gap-2">
                            <button class="so-btn so-btn-sm so-btn-outline">
                                <span class="material-icons">person_add</span>
                                Follow
                            </button>
                            <button class="so-btn so-btn-sm so-btn-outline">
                                <span class="material-icons">mail</span>
                                Message
                            </button>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media"&gt;
    &lt;div class="so-media-left"&gt;
        &lt;img src="avatar.jpg" class="so-media-image"&gt;
    &lt;/div&gt;
    &lt;div class="so-media-body"&gt;
        &lt;h5 class="so-media-heading"&gt;Name&lt;/h5&gt;
        &lt;p class="so-text-muted"&gt;Description&lt;/p&gt;
        &lt;div class="so-d-flex so-gap-2"&gt;
            &lt;button class="so-btn so-btn-sm so-btn-outline"&gt;Follow&lt;/button&gt;
            &lt;button class="so-btn so-btn-sm so-btn-outline"&gt;Message&lt;/button&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Compact Media Object -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Compact Media Object</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Smaller variant for dense layouts.</p>

                <div class="so-d-flex so-flex-column so-gap-3">
                    <div class="so-media so-media-sm">
                        <div class="so-media-left">
                            <img src="https://ui-avatars.com/api/?name=User+1&background=667eea&color=fff&size=32" alt="User" class="so-media-image">
                        </div>
                        <div class="so-media-body">
                            <span class="so-media-heading">User 1</span>
                            <span class="so-text-muted so-text-sm">Online</span>
                        </div>
                    </div>

                    <div class="so-media so-media-sm">
                        <div class="so-media-left">
                            <img src="https://ui-avatars.com/api/?name=User+2&background=f093fb&color=fff&size=32" alt="User" class="so-media-image">
                        </div>
                        <div class="so-media-body">
                            <span class="so-media-heading">User 2</span>
                            <span class="so-text-muted so-text-sm">Away</span>
                        </div>
                    </div>

                    <div class="so-media so-media-sm">
                        <div class="so-media-left">
                            <img src="https://ui-avatars.com/api/?name=User+3&background=4facfe&color=fff&size=32" alt="User" class="so-media-image">
                        </div>
                        <div class="so-media-body">
                            <span class="so-media-heading">User 3</span>
                            <span class="so-text-muted so-text-sm">Offline</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-media so-media-sm"&gt;
    &lt;div class="so-media-left"&gt;
        &lt;img src="avatar.jpg" class="so-media-image"&gt;
    &lt;/div&gt;
    &lt;div class="so-media-body"&gt;
        &lt;span class="so-media-heading"&gt;User Name&lt;/span&gt;
        &lt;span class="so-text-muted so-text-sm"&gt;Status&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

    </div>
</main>

<script>
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

<?php require_once '../includes/footer.php'; ?>
