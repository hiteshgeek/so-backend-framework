<?php
/**
 * SixOrbit UI Demo - Spinners
 */
$pageTitle = 'Spinners';
$pageDescription = 'Loading indicators and animations for async operations';

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

        <!-- ===================== BORDER SPINNER ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Border Spinner</h3>
                <p class="so-card-subtitle">The default spinner using a rotating border animation.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner"></div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner"&gt;&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== SPINNER SIZES ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spinner Sizes</h3>
                <p class="so-card-subtitle">Extra small to extra large spinner variants.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner so-spinner-xs"></div>
                <div class="so-spinner so-spinner-sm"></div>
                <div class="so-spinner so-spinner-md"></div>
                <div class="so-spinner so-spinner-lg"></div>
                <div class="so-spinner so-spinner-xl"></div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner so-spinner-xs"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-sm"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-md"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-lg"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-xl"&gt;&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== SPINNER COLORS ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spinner Colors</h3>
                <p class="so-card-subtitle">Color variants for different contexts.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner so-spinner-primary"></div>
                <div class="so-spinner so-spinner-secondary"></div>
                <div class="so-spinner so-spinner-success"></div>
                <div class="so-spinner so-spinner-danger"></div>
                <div class="so-spinner so-spinner-warning"></div>
                <div class="so-spinner so-spinner-info"></div>
                <div style="background: var(--so-grey-800); padding: 12px; border-radius: 8px;">
                    <div class="so-spinner so-spinner-light"></div>
                </div>
                <div class="so-spinner so-spinner-dark"></div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner so-spinner-primary"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-secondary"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-success"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-danger"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-warning"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-info"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-light"&gt;&lt;/div&gt;
&lt;div class="so-spinner so-spinner-dark"&gt;&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== GROWING SPINNER ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Growing Spinner</h3>
                <p class="so-card-subtitle">A pulsing dot animation that grows and fades.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner-grow"></div>
                <div class="so-spinner-grow so-spinner-sm"></div>
                <div class="so-spinner-grow so-spinner-lg"></div>
                <div class="so-spinner-grow so-spinner-primary"></div>
                <div class="so-spinner-grow so-spinner-success"></div>
                <div class="so-spinner-grow so-spinner-danger"></div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner-grow"&gt;&lt;/div&gt;
&lt;div class="so-spinner-grow so-spinner-sm"&gt;&lt;/div&gt;
&lt;div class="so-spinner-grow so-spinner-lg"&gt;&lt;/div&gt;
&lt;div class="so-spinner-grow so-spinner-primary"&gt;&lt;/div&gt;
&lt;div class="so-spinner-grow so-spinner-success"&gt;&lt;/div&gt;
&lt;div class="so-spinner-grow so-spinner-danger"&gt;&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== DOTS SPINNER ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Dots Spinner</h3>
                <p class="so-card-subtitle">Three bouncing dots animation.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner-dots">
                    <span></span><span></span><span></span>
                </div>
                <div class="so-spinner-dots so-spinner-dots-sm">
                    <span></span><span></span><span></span>
                </div>
                <div class="so-spinner-dots so-spinner-dots-lg">
                    <span></span><span></span><span></span>
                </div>
                <div class="so-spinner-dots so-spinner-dots-success">
                    <span></span><span></span><span></span>
                </div>
                <div class="so-spinner-dots so-spinner-dots-danger">
                    <span></span><span></span><span></span>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner-dots"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-dots so-spinner-dots-sm"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-dots so-spinner-dots-lg"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-dots so-spinner-dots-success"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== BARS SPINNER ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Bars Spinner</h3>
                <p class="so-card-subtitle">Animated loading bars like an equalizer.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner-bars">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="so-spinner-bars so-spinner-bars-sm">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="so-spinner-bars so-spinner-bars-lg">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="so-spinner-bars so-spinner-bars-primary">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="so-spinner-bars so-spinner-bars-success">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner-bars"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-bars so-spinner-bars-sm"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-bars so-spinner-bars-lg"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-bars so-spinner-bars-primary"&gt;
    &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== PULSE SPINNER ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Pulse Spinner</h3>
                <p class="so-card-subtitle">Expanding rings animation.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner-pulse"></div>
                <div class="so-spinner-pulse so-spinner-sm"></div>
                <div class="so-spinner-pulse so-spinner-lg"></div>
                <div class="so-spinner-pulse so-spinner-primary"></div>
                <div class="so-spinner-pulse so-spinner-success"></div>
                <div class="so-spinner-pulse so-spinner-danger"></div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner-pulse"&gt;&lt;/div&gt;
&lt;div class="so-spinner-pulse so-spinner-sm"&gt;&lt;/div&gt;
&lt;div class="so-spinner-pulse so-spinner-lg"&gt;&lt;/div&gt;
&lt;div class="so-spinner-pulse so-spinner-primary"&gt;&lt;/div&gt;
&lt;div class="so-spinner-pulse so-spinner-success"&gt;&lt;/div&gt;
&lt;div class="so-spinner-pulse so-spinner-danger"&gt;&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== SPINNER WITH TEXT ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spinner with Text</h3>
                <p class="so-card-subtitle">Inline spinner combined with loading text.</p>
            </div>
            <div class="so-card-body">
                <div class="so-spinner-inline">
                    <div class="so-spinner so-spinner-sm"></div>
                    <span>Loading...</span>
                </div>
                <div class="so-spinner-inline">
                    <div class="so-spinner-dots so-spinner-dots-sm">
                        <span></span><span></span><span></span>
                    </div>
                    <span>Please wait</span>
                </div>
                <div class="so-spinner-inline">
                    <div class="so-spinner so-spinner-sm so-spinner-success"></div>
                    <span>Saving changes...</span>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-spinner-inline"&gt;
    &lt;div class="so-spinner so-spinner-sm"&gt;&lt;/div&gt;
    &lt;span&gt;Loading...&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-spinner-inline"&gt;
    &lt;div class="so-spinner-dots so-spinner-dots-sm"&gt;
        &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
    &lt;/div&gt;
    &lt;span&gt;Please wait&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== BUTTON LOADING STATES ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Loading States</h3>
                <p class="so-card-subtitle">Spinners inside buttons for async actions.</p>
            </div>
            <div class="so-card-body">
                <button class="so-btn so-btn-primary" disabled>
                    <div class="so-spinner so-spinner-xs so-spinner-light"></div>
                    Loading...
                </button>
                <button class="so-btn so-btn-success" disabled>
                    <div class="so-spinner so-spinner-xs so-spinner-light"></div>
                    Saving
                </button>
                <button class="so-btn so-btn-secondary" disabled>
                    <div class="so-spinner-dots so-spinner-dots-sm so-spinner-dots-dark">
                        <span></span><span></span><span></span>
                    </div>
                </button>
                <button class="so-btn so-btn-outline-primary" disabled>
                    <div class="so-spinner so-spinner-xs so-spinner-primary"></div>
                    Processing
                </button>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;button class="so-btn so-btn-primary" disabled&gt;
    &lt;div class="so-spinner so-spinner-xs so-spinner-light"&gt;&lt;/div&gt;
    Loading...
&lt;/button&gt;

&lt;button class="so-btn so-btn-success" disabled&gt;
    &lt;div class="so-spinner so-spinner-xs so-spinner-light"&gt;&lt;/div&gt;
    Saving
&lt;/button&gt;

&lt;button class="so-btn so-btn-secondary" disabled&gt;
    &lt;div class="so-spinner-dots so-spinner-dots-sm so-spinner-dots-dark"&gt;
        &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
    &lt;/div&gt;
&lt;/button&gt;

&lt;button class="so-btn so-btn-outline-primary" disabled&gt;
    &lt;div class="so-spinner so-spinner-xs so-spinner-primary"&gt;&lt;/div&gt;
    Processing
&lt;/button&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== LOADING OVERLAY ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Loading Overlay</h3>
                <p class="so-card-subtitle">Full-screen or contained loading overlay.</p>
            </div>
            <div class="so-card-body">
                <div style="position: relative; height: 200px; border: 1px solid var(--so-border-color); border-radius: 8px; overflow: hidden;">
                    <div class="so-spinner-overlay so-spinner-overlay-contained">
                        <div class="so-spinner-overlay-content">
                            <div class="so-spinner so-spinner-lg"></div>
                            <div class="so-spinner-overlay-text">Loading content...</div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 16px;">
                    <button class="so-btn so-btn-primary" onclick="showFullOverlay()">
                        <span class="material-icons">fullscreen</span>
                        Show Full-screen Overlay (2s)
                    </button>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Contained overlay (for cards, sections) --&gt;
&lt;div style="position: relative;"&gt;
    &lt;div class="so-spinner-overlay so-spinner-overlay-contained"&gt;
        &lt;div class="so-spinner-overlay-content"&gt;
            &lt;div class="so-spinner so-spinner-lg"&gt;&lt;/div&gt;
            &lt;div class="so-spinner-overlay-text"&gt;Loading content...&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Full-screen overlay --&gt;
&lt;div class="so-spinner-overlay"&gt;
    &lt;div class="so-spinner-overlay-content"&gt;
        &lt;div class="so-spinner so-spinner-xl"&gt;&lt;/div&gt;
        &lt;div class="so-spinner-overlay-text"&gt;Loading...&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

    </div>
</main>

<div class="so-spinner-overlay" id="fullOverlay" style="display: none;">
    <div class="so-spinner-overlay-content">
        <div class="so-spinner so-spinner-xl"></div>
        <div class="so-spinner-overlay-text">Loading application...</div>
    </div>
</div>

<script>
function showFullOverlay() {
    const overlay = document.getElementById('fullOverlay');
    overlay.style.display = 'flex';
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 2000);
}
</script>

<?php require_once '../includes/footer.php'; ?>
