<?php
/**
 * SixOrbit UI Demo - Animations
 */
$pageTitle = 'Animations';
$pageDescription = 'Reusable CSS animations and transitions for interactive UI elements.';

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

<!-- Fade Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Fade Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Fade in/out animations with directional variants. Click boxes to replay.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in" onclick="replayAnimation(this, 'so-animate-fade-in')">
                            <span>Fade In</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up" onclick="replayAnimation(this, 'so-animate-fade-in-up')">
                            <span>Fade In Up</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-down" onclick="replayAnimation(this, 'so-animate-fade-in-down')">
                            <span>Fade In Down</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-left" onclick="replayAnimation(this, 'so-animate-fade-in-left')">
                            <span>Fade In Left</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-right" onclick="replayAnimation(this, 'so-animate-fade-in-right')">
                            <span>Fade In Right</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Fade animations --&gt;
&lt;div class="so-animate so-animate-fade-in"&gt;Fade In&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-up"&gt;Fade In Up&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-down"&gt;Fade In Down&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-left"&gt;Fade In Left&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-right"&gt;Fade In Right&lt;/div&gt;

&lt;!-- With duration modifiers --&gt;
&lt;div class="so-animate so-animate-fade-in so-animate-duration-500"&gt;Fast (500ms)&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in so-animate-delay-300"&gt;Delayed (300ms)&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Slide Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Slide Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Slide in/out animations from different directions.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-slide-in-up" onclick="replayAnimation(this, 'so-animate-slide-in-up')">
                            <span>Slide In Up</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-slide-in-down" onclick="replayAnimation(this, 'so-animate-slide-in-down')">
                            <span>Slide In Down</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-slide-in-left" onclick="replayAnimation(this, 'so-animate-slide-in-left')">
                            <span>Slide In Left</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-slide-in-right" onclick="replayAnimation(this, 'so-animate-slide-in-right')">
                            <span>Slide In Right</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-animate so-animate-slide-in-up"&gt;Slide In Up&lt;/div&gt;
&lt;div class="so-animate so-animate-slide-in-down"&gt;Slide In Down&lt;/div&gt;
&lt;div class="so-animate so-animate-slide-in-left"&gt;Slide In Left&lt;/div&gt;
&lt;div class="so-animate so-animate-slide-in-right"&gt;Slide In Right&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Scale & Zoom Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Scale & Zoom Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Scale and zoom animations for emphasis.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-scale-in" onclick="replayAnimation(this, 'so-animate-scale-in')">
                            <span>Scale In</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-scale-up" onclick="replayAnimation(this, 'so-animate-scale-up')">
                            <span>Scale Up</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-zoom-in" onclick="replayAnimation(this, 'so-animate-zoom-in')">
                            <span>Zoom In</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="animation-demo-box so-animate so-animate-scale-down" onclick="replayAnimation(this, 'so-animate-scale-down')">
                            <span>Scale Down</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-animate so-animate-scale-in"&gt;Scale In&lt;/div&gt;
&lt;div class="so-animate so-animate-scale-up"&gt;Scale Up&lt;/div&gt;
&lt;div class="so-animate so-animate-zoom-in"&gt;Zoom In&lt;/div&gt;
&lt;div class="so-animate so-animate-scale-down"&gt;Scale Down&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Bounce Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Bounce Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Bouncy animations for playful interactions.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-animate so-animate-bounce so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-bounce')">
                            <span>Bounce</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-animate so-animate-bounce-in so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-bounce-in')">
                            <span>Bounce In</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-animate so-animate-rubber-band so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-rubber-band')">
                            <span>Rubber Band</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-animate so-animate-bounce"&gt;Bounce&lt;/div&gt;
&lt;div class="so-animate so-animate-bounce-in"&gt;Bounce In&lt;/div&gt;
&lt;div class="so-animate so-animate-rubber-band"&gt;Rubber Band&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Shake & Wobble Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Shake & Wobble Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Shake animations for errors, alerts, or attention.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-shake so-animate-duration-500" onclick="replayAnimation(this, 'so-animate-shake')">
                            <span>Shake</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-shake-horizontal so-animate-duration-500" onclick="replayAnimation(this, 'so-animate-shake-horizontal')">
                            <span>Shake H</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-shake-vertical so-animate-duration-500" onclick="replayAnimation(this, 'so-animate-shake-vertical')">
                            <span>Shake V</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-wobble so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-wobble')">
                            <span>Wobble</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-jello so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-jello')">
                            <span>Jello</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-animate so-animate-shake"&gt;Shake&lt;/div&gt;
&lt;div class="so-animate so-animate-shake-horizontal"&gt;Shake Horizontal&lt;/div&gt;
&lt;div class="so-animate so-animate-shake-vertical"&gt;Shake Vertical&lt;/div&gt;
&lt;div class="so-animate so-animate-wobble"&gt;Wobble&lt;/div&gt;
&lt;div class="so-animate so-animate-jello"&gt;Jello&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Special Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Special Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Unique animations for special effects.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-swing so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-swing')">
                            <span>Swing</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-tada so-animate-duration-700" onclick="replayAnimation(this, 'so-animate-tada')">
                            <span>Tada</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-flip-x so-animate-duration-500" onclick="replayAnimation(this, 'so-animate-flip-x')">
                            <span>Flip X</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-flip-y so-animate-duration-500" onclick="replayAnimation(this, 'so-animate-flip-y')">
                            <span>Flip Y</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-flash so-animate-duration-1000" onclick="replayAnimation(this, 'so-animate-flash')">
                            <span>Flash</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-animate so-animate-swing"&gt;Swing&lt;/div&gt;
&lt;div class="so-animate so-animate-tada"&gt;Tada&lt;/div&gt;
&lt;div class="so-animate so-animate-flip-x"&gt;Flip X&lt;/div&gt;
&lt;div class="so-animate so-animate-flip-y"&gt;Flip Y&lt;/div&gt;
&lt;div class="so-animate so-animate-flash"&gt;Flash&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Continuous Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Continuous Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Looping animations for loading states and attention grabbers.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-attention-pulse">
                            <span>Pulse</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-attention-bounce">
                            <span>Bounce</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-attention-heartbeat">
                            <span>Heartbeat</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-attention-float">
                            <span>Float</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-attention-glow">
                            <span>Glow</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-attention-blink">
                            <span>Blink</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Continuous/looping animations --&gt;
&lt;div class="so-attention-pulse"&gt;Pulse&lt;/div&gt;
&lt;div class="so-attention-bounce"&gt;Bounce&lt;/div&gt;
&lt;div class="so-attention-heartbeat"&gt;Heartbeat&lt;/div&gt;
&lt;div class="so-attention-float"&gt;Float&lt;/div&gt;
&lt;div class="so-attention-glow"&gt;Glow&lt;/div&gt;
&lt;div class="so-attention-blink"&gt;Blink&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Spin Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Spin & Loading Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Rotation and loading state animations.</p>

                <div class="so-row so-g-4 so-align-items-center">
                    <div class="so-col-6 so-col-md-3">
                        <div class="so-d-flex so-flex-column so-align-items-center so-gap-2">
                            <span class="material-icons so-loading-spin" style="font-size: 40px; color: var(--so-accent-primary);">sync</span>
                            <span class="so-text-muted so-text-sm">Spin</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="so-d-flex so-flex-column so-align-items-center so-gap-2">
                            <span class="material-icons so-animate so-animate-spin-reverse so-animate-infinite so-animate-linear" style="font-size: 40px; color: var(--so-accent-primary);">refresh</span>
                            <span class="so-text-muted so-text-sm">Spin Reverse</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="so-d-flex so-flex-column so-align-items-center so-gap-2">
                            <div class="so-loading-dots" style="color: var(--so-accent-primary);">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <span class="so-text-muted so-text-sm">Loading Dots</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-3">
                        <div class="so-d-flex so-flex-column so-align-items-center so-gap-2">
                            <div class="so-loading-pulse" style="width: 40px; height: 40px; background: var(--so-accent-primary); border-radius: 50%;"></div>
                            <span class="so-text-muted so-text-sm">Pulse</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Spinning icon --&gt;
&lt;span class="material-icons so-loading-spin"&gt;sync&lt;/span&gt;

&lt;!-- Reverse spin --&gt;
&lt;span class="material-icons so-animate so-animate-spin-reverse so-animate-infinite so-animate-linear"&gt;refresh&lt;/span&gt;

&lt;!-- Loading dots --&gt;
&lt;div class="so-loading-dots"&gt;
    &lt;span&gt;&lt;/span&gt;
    &lt;span&gt;&lt;/span&gt;
    &lt;span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Loading pulse --&gt;
&lt;div class="so-loading-pulse"&gt;&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Hover Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Hover Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Animations triggered on mouse hover.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-hover-animate-pulse">
                            <span>Pulse</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-hover-animate-bounce">
                            <span>Bounce</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-hover-animate-shake">
                            <span>Shake</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-hover-animate-tada">
                            <span>Tada</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-hover-animate-jello">
                            <span>Jello</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-hover-animate-wobble">
                            <span>Wobble</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Hover-triggered animations --&gt;
&lt;div class="so-hover-animate-pulse"&gt;Pulse on hover&lt;/div&gt;
&lt;div class="so-hover-animate-bounce"&gt;Bounce on hover&lt;/div&gt;
&lt;div class="so-hover-animate-shake"&gt;Shake on hover&lt;/div&gt;
&lt;div class="so-hover-animate-tada"&gt;Tada on hover&lt;/div&gt;
&lt;div class="so-hover-animate-jello"&gt;Jello on hover&lt;/div&gt;
&lt;div class="so-hover-animate-wobble"&gt;Wobble on hover&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Hover Effects -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Hover Effects</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Transition effects for hover states.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-hover-scale-up">
                            <span>Scale Up</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-hover-scale-down">
                            <span>Scale Down</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-hover-lift">
                            <span>Lift</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Hover transition effects --&gt;
&lt;div class="so-hover-scale-up"&gt;Scale up on hover&lt;/div&gt;
&lt;div class="so-hover-scale-down"&gt;Scale down on hover&lt;/div&gt;
&lt;div class="so-hover-lift"&gt;Lift on hover (with shadow)&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Animation Duration -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Animation Duration</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Control animation speed with duration modifiers.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-bounce-in so-animate-faster" onclick="replayAnimation(this, 'so-animate-bounce-in')">
                            <span>Faster</span>
                            <small class="so-text-muted">150ms</small>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-bounce-in so-animate-fast" onclick="replayAnimation(this, 'so-animate-bounce-in')">
                            <span>Fast</span>
                            <small class="so-text-muted">300ms</small>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-bounce-in so-animate-normal" onclick="replayAnimation(this, 'so-animate-bounce-in')">
                            <span>Normal</span>
                            <small class="so-text-muted">500ms</small>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-bounce-in so-animate-slow" onclick="replayAnimation(this, 'so-animate-bounce-in')">
                            <span>Slow</span>
                            <small class="so-text-muted">800ms</small>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-bounce-in so-animate-slower" onclick="replayAnimation(this, 'so-animate-bounce-in')">
                            <span>Slower</span>
                            <small class="so-text-muted">1200ms</small>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Duration modifiers --&gt;
&lt;div class="so-animate so-animate-bounce-in so-animate-faster"&gt;150ms&lt;/div&gt;
&lt;div class="so-animate so-animate-bounce-in so-animate-fast"&gt;300ms&lt;/div&gt;
&lt;div class="so-animate so-animate-bounce-in so-animate-normal"&gt;500ms&lt;/div&gt;
&lt;div class="so-animate so-animate-bounce-in so-animate-slow"&gt;800ms&lt;/div&gt;
&lt;div class="so-animate so-animate-bounce-in so-animate-slower"&gt;1200ms&lt;/div&gt;

&lt;!-- Custom duration --&gt;
&lt;div class="so-animate so-animate-bounce-in so-animate-duration-700"&gt;700ms&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Animation Delay -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Animation Delay</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Stagger animations with delay classes.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up so-animate-duration-500" onclick="replayAnimationGroup()">
                            <span>No Delay</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up so-animate-duration-500 so-animate-delay-100" onclick="replayAnimationGroup()">
                            <span>100ms</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up so-animate-duration-500 so-animate-delay-200" onclick="replayAnimationGroup()">
                            <span>200ms</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up so-animate-duration-500 so-animate-delay-300" onclick="replayAnimationGroup()">
                            <span>300ms</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up so-animate-duration-500 so-animate-delay-400" onclick="replayAnimationGroup()">
                            <span>400ms</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4 so-col-lg-2">
                        <div class="animation-demo-box so-animate so-animate-fade-in-up so-animate-duration-500 so-animate-delay-500" onclick="replayAnimationGroup()">
                            <span>500ms</span>
                        </div>
                    </div>
                </div>
                <button class="so-btn so-btn-primary so-mt-4" onclick="replayAnimationGroup()">
                    <span class="material-icons">replay</span> Replay Staggered
                </button>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Staggered animations with delay classes --&gt;
&lt;div class="so-animate so-animate-fade-in-up"&gt;No delay&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-up so-animate-delay-100"&gt;100ms delay&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-up so-animate-delay-200"&gt;200ms delay&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-up so-animate-delay-300"&gt;300ms delay&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-up so-animate-delay-400"&gt;400ms delay&lt;/div&gt;
&lt;div class="so-animate so-animate-fade-in-up so-animate-delay-500"&gt;500ms delay&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Scroll Animations -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Scroll-Triggered Animations</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Animations that trigger when elements enter the viewport. Scroll down to see them animate.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-scroll-fade-in" data-scroll-animate>
                            <span>Fade In</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-scroll-fade-in-up" data-scroll-animate>
                            <span>Fade In Up</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-scroll-fade-in-down" data-scroll-animate>
                            <span>Fade In Down</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-scroll-fade-in-left" data-scroll-animate>
                            <span>Fade In Left</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-scroll-fade-in-right" data-scroll-animate>
                            <span>Fade In Right</span>
                        </div>
                    </div>
                    <div class="so-col-6 so-col-md-4">
                        <div class="animation-demo-box so-scroll-scale-in" data-scroll-animate>
                            <span>Scale In</span>
                        </div>
                    </div>
                </div>
                <button class="so-btn so-btn-outline-primary so-mt-4" onclick="resetScrollAnimations()">
                    <span class="material-icons">refresh</span> Reset Scroll Animations
                </button>
            <div class="so-tabs so-tabs-code so-mt-3">
                <button class="so-tab so-tab-active" onclick="switchCodeTab(this, 'html-scroll')">HTML</button>
                <button class="so-tab" onclick="switchCodeTab(this, 'js-scroll')">JavaScript</button>
            </div>
            <div class="so-code-block" id="html-scroll">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Scroll-triggered animations --&gt;
&lt;div class="so-scroll-fade-in" data-scroll-animate&gt;Fade In&lt;/div&gt;
&lt;div class="so-scroll-fade-in-up" data-scroll-animate&gt;Fade In Up&lt;/div&gt;
&lt;div class="so-scroll-fade-in-down" data-scroll-animate&gt;Fade In Down&lt;/div&gt;
&lt;div class="so-scroll-fade-in-left" data-scroll-animate&gt;Fade In Left&lt;/div&gt;
&lt;div class="so-scroll-fade-in-right" data-scroll-animate&gt;Fade In Right&lt;/div&gt;
&lt;div class="so-scroll-scale-in" data-scroll-animate&gt;Scale In&lt;/div&gt;</code></pre>
            </div>
            <div class="so-code-block" id="js-scroll" style="display: none;">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-javascript">// Scroll animation observer
document.addEventListener('DOMContentLoaded', function() {
    const scrollElements = document.querySelectorAll('[data-scroll-animate]');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('so-is-visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    scrollElements.forEach(el => observer.observe(el));
});</code></pre>
            </div>
    </div>
</div>

<!-- Usage with Components -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Usage with Components</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Apply animations to buttons, cards, and other components.</p>

                <h6 class="so-mb-3">Animated Buttons</h6>
                <div class="so-d-flex so-flex-wrap so-gap-3 so-mb-5">
                    <button class="so-btn so-btn-primary so-hover-animate-pulse">Pulse</button>
                    <button class="so-btn so-btn-success so-hover-animate-bounce">Bounce</button>
                    <button class="so-btn so-btn-warning so-hover-animate-shake">Shake</button>
                    <button class="so-btn so-btn-danger so-hover-animate-tada">Tada</button>
                    <button class="so-btn so-btn-info so-hover-scale-up">Scale Up</button>
                    <button class="so-btn so-btn-secondary so-hover-lift">Lift</button>
                </div>

                <h6 class="so-mb-3">Animated Cards</h6>
                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <div class="so-card so-hover-lift" style="cursor: pointer;">
                            <div class="so-card-body so-text-center">
                                <span class="material-icons so-text-primary" style="font-size: 48px;">rocket_launch</span>
                                <h5 class="so-mt-3 so-mb-2">Hover Lift</h5>
                                <p class="so-text-muted so-mb-0">Card lifts on hover</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-hover-scale-up" style="cursor: pointer;">
                            <div class="so-card-body so-text-center">
                                <span class="material-icons so-text-success" style="font-size: 48px;">expand</span>
                                <h5 class="so-mt-3 so-mb-2">Hover Scale</h5>
                                <p class="so-text-muted so-mb-0">Card scales on hover</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-hover-animate-pulse" style="cursor: pointer;">
                            <div class="so-card-body so-text-center">
                                <span class="material-icons so-text-warning" style="font-size: 48px;">favorite</span>
                                <h5 class="so-mt-3 so-mb-2">Hover Pulse</h5>
                                <p class="so-text-muted so-mb-0">Card pulses on hover</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="so-mb-3 so-mt-5">Notification Badges</h6>
                <div class="so-d-flex so-gap-4 so-align-items-center">
                    <span class="so-badge so-badge-danger so-attention-pulse">New</span>
                    <span class="so-badge so-badge-warning so-attention-bounce">Alert</span>
                    <span class="so-badge so-badge-success so-attention-heartbeat">Live</span>
                    <span class="so-badge so-badge-info so-attention-glow">Update</span>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Animated buttons --&gt;
&lt;button class="so-btn so-btn-primary so-hover-animate-pulse"&gt;Pulse&lt;/button&gt;
&lt;button class="so-btn so-btn-success so-hover-animate-bounce"&gt;Bounce&lt;/button&gt;
&lt;button class="so-btn so-btn-warning so-hover-animate-shake"&gt;Shake&lt;/button&gt;
&lt;button class="so-btn so-btn-danger so-hover-animate-tada"&gt;Tada&lt;/button&gt;
&lt;button class="so-btn so-btn-info so-hover-scale-up"&gt;Scale Up&lt;/button&gt;
&lt;button class="so-btn so-btn-secondary so-hover-lift"&gt;Lift&lt;/button&gt;

&lt;!-- Animated cards --&gt;
&lt;div class="so-card so-hover-lift"&gt;...&lt;/div&gt;
&lt;div class="so-card so-hover-scale-up"&gt;...&lt;/div&gt;
&lt;div class="so-card so-hover-animate-pulse"&gt;...&lt;/div&gt;

&lt;!-- Notification badges with continuous animations --&gt;
&lt;span class="so-badge so-badge-danger so-attention-pulse"&gt;New&lt;/span&gt;
&lt;span class="so-badge so-badge-warning so-attention-bounce"&gt;Alert&lt;/span&gt;
&lt;span class="so-badge so-badge-success so-attention-heartbeat"&gt;Live&lt;/span&gt;
&lt;span class="so-badge so-badge-info so-attention-glow"&gt;Update&lt;/span&gt;</code></pre>
            </div>
    </div>
</div>

    </div>
</main>

<style>
.animation-demo-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px 10px;
    background: var(--so-card-bg);
    border: 1px solid var(--so-border-color);
    border-radius: var(--so-radius-lg);
    text-align: center;
    cursor: pointer;
    min-height: 80px;
    transition: border-color 0.2s;
}
.animation-demo-box:hover {
    border-color: var(--so-accent-primary);
}
.animation-demo-box span {
    font-size: 12px;
    font-weight: 500;
}
.animation-demo-box small {
    font-size: 10px;
    display: block;
    margin-top: 4px;
}
</style>

<script>
// Replay animation on click
function replayAnimation(element, animationClass) {
    element.classList.remove(animationClass);
    void element.offsetWidth; // Trigger reflow
    element.classList.add(animationClass);
}

// Replay staggered animation group
function replayAnimationGroup() {
    const boxes = document.querySelectorAll('.so-animate-fade-in-up');
    boxes.forEach(box => {
        box.classList.remove('so-animate-fade-in-up');
    });
    void document.body.offsetWidth; // Trigger reflow
    boxes.forEach(box => {
        box.classList.add('so-animate-fade-in-up');
    });
}

// Scroll animation observer
document.addEventListener('DOMContentLoaded', function() {
    const scrollElements = document.querySelectorAll('[data-scroll-animate]');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('so-is-visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    scrollElements.forEach(el => observer.observe(el));
});

// Reset scroll animations
function resetScrollAnimations() {
    const scrollElements = document.querySelectorAll('[data-scroll-animate]');
    scrollElements.forEach(el => {
        el.classList.remove('so-is-visible');
    });
    // Re-trigger after a short delay
    setTimeout(() => {
        scrollElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.classList.add('so-is-visible');
            }
        });
    }, 100);
}

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

function switchCodeTab(button, targetId) {
    const tabsContainer = button.parentElement;
    const codeContainer = tabsContainer.parentElement;

    // Remove active class from all tabs
    tabsContainer.querySelectorAll('.so-tab').forEach(tab => tab.classList.remove('so-tab-active'));
    button.classList.add('so-tab-active');

    // Hide all code blocks and show target
    codeContainer.querySelectorAll('.so-code-block').forEach(block => block.style.display = 'none');
    document.getElementById(targetId).style.display = 'block';
}
</script>

<?php require_once '../includes/footer.php'; ?>
