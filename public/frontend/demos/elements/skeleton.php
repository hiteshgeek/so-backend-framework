<?php
/**
 * SixOrbit UI Demo - Skeleton
 */
$pageTitle = 'Skeleton';
$pageDescription = 'Loading placeholder animations that indicate content is being loaded.';

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

<!-- Basic Skeletons -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Skeletons</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Fundamental skeleton shapes for various content types.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">Text Lines</h6>
                        <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80%"></div>
                        <div class="so-skeleton so-skeleton-text" style="width: 60%"></div>
                    </div>
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">Shapes</h6>
                        <div class="so-d-flex so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 48px; height: 48px;"></div>
                            <div class="so-skeleton so-skeleton-rect" style="width: 100px; height: 48px;"></div>
                            <div class="so-skeleton so-skeleton-rounded" style="width: 80px; height: 32px;"></div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Text skeleton lines --&gt;
&lt;div class="so-skeleton so-skeleton-text"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-text" style="width: 80%"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-text" style="width: 60%"&gt;&lt;/div&gt;

&lt;!-- Shape variants --&gt;
&lt;div class="so-skeleton so-skeleton-circle" style="width: 48px; height: 48px;"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-rect" style="width: 100px; height: 48px;"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-rounded" style="width: 80px; height: 32px;"&gt;&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Card Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Card Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for card components.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-skeleton so-skeleton-rect" style="height: 180px;"></div>
                            <div class="so-card-body">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 70%;"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 50%;"></div>
                                <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width: 100px; height: 36px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-skeleton so-skeleton-rect" style="height: 180px;"></div>
                            <div class="so-card-body">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 70%;"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 50%;"></div>
                                <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width: 100px; height: 36px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-skeleton so-skeleton-rect" style="height: 180px;"></div>
                            <div class="so-card-body">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 70%;"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 50%;"></div>
                                <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width: 100px; height: 36px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-card so-card-bordered"&gt;
    &lt;div class="so-skeleton so-skeleton-rect" style="height: 180px;"&gt;&lt;/div&gt;
    &lt;div class="so-card-body"&gt;
        &lt;div class="so-skeleton so-skeleton-text so-mb-2" style="width: 70%;"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text so-mb-2"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 50%;"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-rounded so-mt-3" style="width: 100px; height: 36px;"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Profile Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Profile Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for user profiles and avatars.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 64px; height: 64px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 50%;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 30%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 48px; height: 48px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 40%; height: 14px;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 12px;"></div>
                            </div>
                            <div class="so-skeleton so-skeleton-rounded" style="width: 80px; height: 32px;"></div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-d-flex so-align-items-center so-gap-3"&gt;
    &lt;div class="so-skeleton so-skeleton-circle" style="width: 64px; height: 64px;"&gt;&lt;/div&gt;
    &lt;div class="so-flex-grow-1"&gt;
        &lt;div class="so-skeleton so-skeleton-text so-mb-2" style="width: 50%;"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 30%;"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- List Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">List Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for list items.</p>

                <div class="so-list-group">
                    <div class="so-list-group-item">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 30%;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-list-group-item">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 40%;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 12px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-list-group-item">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 35%;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 50%; height: 12px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-list-group-item"&gt;
    &lt;div class="so-d-flex so-align-items-center so-gap-3"&gt;
        &lt;div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"&gt;&lt;/div&gt;
        &lt;div class="so-flex-grow-1"&gt;
            &lt;div class="so-skeleton so-skeleton-text so-mb-1" style="width: 30%;"&gt;&lt;/div&gt;
            &lt;div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"&gt;&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Table Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Table Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for table rows.</p>

                <div class="so-table-responsive">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="so-skeleton so-skeleton-circle" style="width: 32px; height: 32px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 120px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 180px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 80px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-rounded" style="width: 60px; height: 24px;"></div></td>
                            </tr>
                            <tr>
                                <td><div class="so-skeleton so-skeleton-circle" style="width: 32px; height: 32px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 100px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 160px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 90px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-rounded" style="width: 60px; height: 24px;"></div></td>
                            </tr>
                            <tr>
                                <td><div class="so-skeleton so-skeleton-circle" style="width: 32px; height: 32px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 140px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 200px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-text" style="width: 70px;"></div></td>
                                <td><div class="so-skeleton so-skeleton-rounded" style="width: 60px; height: 24px;"></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;tr&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-circle" style="width: 32px; height: 32px;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-text" style="width: 120px;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-text" style="width: 180px;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-text" style="width: 80px;"&gt;&lt;/div&gt;&lt;/td&gt;
    &lt;td&gt;&lt;div class="so-skeleton so-skeleton-rounded" style="width: 60px; height: 24px;"&gt;&lt;/div&gt;&lt;/td&gt;
&lt;/tr&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Article Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Article Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for article or blog post content.</p>

                <div class="so-card so-card-bordered">
                    <div class="so-skeleton so-skeleton-rect" style="height: 250px;"></div>
                    <div class="so-card-body">
                        <div class="so-d-flex so-align-items-center so-gap-2 so-mb-3">
                            <div class="so-skeleton so-skeleton-circle" style="width: 32px; height: 32px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 100px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 80px;"></div>
                        </div>
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80%; height: 24px;"></div>
                        <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 90%;"></div>
                        <div class="so-skeleton so-skeleton-text" style="width: 70%;"></div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-card so-card-bordered"&gt;
    &lt;div class="so-skeleton so-skeleton-rect" style="height: 250px;"&gt;&lt;/div&gt;
    &lt;div class="so-card-body"&gt;
        &lt;div class="so-d-flex so-align-items-center so-gap-2 so-mb-3"&gt;
            &lt;div class="so-skeleton so-skeleton-circle" style="width: 32px; height: 32px;"&gt;&lt;/div&gt;
            &lt;div class="so-skeleton so-skeleton-text" style="width: 100px;"&gt;&lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80%; height: 24px;"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text so-mb-2"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 70%;"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Dashboard Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Dashboard Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for dashboard widgets.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-3">
                        <div class="so-card so-card-bordered so-p-3">
                            <div class="so-d-flex so-justify-content-between so-align-items-start so-mb-3">
                                <div class="so-skeleton so-skeleton-text" style="width: 60%;"></div>
                                <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            </div>
                            <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 50%; height: 28px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"></div>
                        </div>
                    </div>
                    <div class="so-col-md-3">
                        <div class="so-card so-card-bordered so-p-3">
                            <div class="so-d-flex so-justify-content-between so-align-items-start so-mb-3">
                                <div class="so-skeleton so-skeleton-text" style="width: 60%;"></div>
                                <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            </div>
                            <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 50%; height: 28px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"></div>
                        </div>
                    </div>
                    <div class="so-col-md-3">
                        <div class="so-card so-card-bordered so-p-3">
                            <div class="so-d-flex so-justify-content-between so-align-items-start so-mb-3">
                                <div class="so-skeleton so-skeleton-text" style="width: 60%;"></div>
                                <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            </div>
                            <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 50%; height: 28px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"></div>
                        </div>
                    </div>
                    <div class="so-col-md-3">
                        <div class="so-card so-card-bordered so-p-3">
                            <div class="so-d-flex so-justify-content-between so-align-items-start so-mb-3">
                                <div class="so-skeleton so-skeleton-text" style="width: 60%;"></div>
                                <div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"></div>
                            </div>
                            <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 50%; height: 28px;"></div>
                            <div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"></div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-card so-card-bordered so-p-3"&gt;
    &lt;div class="so-d-flex so-justify-content-between so-align-items-start so-mb-3"&gt;
        &lt;div class="so-skeleton so-skeleton-text" style="width: 60%;"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton so-skeleton-circle" style="width: 40px; height: 40px;"&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-text so-mb-1" style="width: 50%; height: 28px;"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-text" style="width: 70%; height: 12px;"&gt;&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Form Skeleton -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Form Skeleton</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Loading placeholder for form fields.</p>

                <div class="so-row so-g-4" style="max-width: 500px;">
                    <div class="so-col-12">
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80px; height: 14px;"></div>
                        <div class="so-skeleton so-skeleton-rect so-skeleton-input"></div>
                    </div>
                    <div class="so-col-6">
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 100px; height: 14px;"></div>
                        <div class="so-skeleton so-skeleton-rect so-skeleton-input"></div>
                    </div>
                    <div class="so-col-6">
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 90px; height: 14px;"></div>
                        <div class="so-skeleton so-skeleton-rect so-skeleton-input"></div>
                    </div>
                    <div class="so-col-12">
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 70px; height: 14px;"></div>
                        <div class="so-skeleton so-skeleton-rect" style="height: 100px; border-radius: 8px;"></div>
                    </div>
                    <div class="so-col-12">
                        <div class="so-d-flex so-gap-2">
                            <div class="so-skeleton so-skeleton-rounded" style="width: 100px; height: 40px;"></div>
                            <div class="so-skeleton so-skeleton-rounded" style="width: 80px; height: 40px;"></div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Form field skeleton --&gt;
&lt;div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80px; height: 14px;"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-rect so-skeleton-input"&gt;&lt;/div&gt;

&lt;!-- Textarea skeleton --&gt;
&lt;div class="so-skeleton so-skeleton-rect" style="height: 100px; border-radius: 8px;"&gt;&lt;/div&gt;

&lt;!-- Button skeleton --&gt;
&lt;div class="so-skeleton so-skeleton-rounded" style="width: 100px; height: 40px;"&gt;&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Animation Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Animation Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Different animation styles for skeleton loaders.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <h6 class="so-text-muted so-mb-3">Wave (Default)</h6>
                        <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80%"></div>
                        <div class="so-skeleton so-skeleton-text" style="width: 60%"></div>
                    </div>
                    <div class="so-col-md-4">
                        <h6 class="so-text-muted so-mb-3">Pulse</h6>
                        <div class="so-skeleton so-skeleton-pulse so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-pulse so-skeleton-text so-mb-2" style="width: 80%"></div>
                        <div class="so-skeleton so-skeleton-pulse so-skeleton-text" style="width: 60%"></div>
                    </div>
                    <div class="so-col-md-4">
                        <h6 class="so-text-muted so-mb-3">No Animation</h6>
                        <div class="so-skeleton so-skeleton-static so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-static so-skeleton-text so-mb-2" style="width: 80%"></div>
                        <div class="so-skeleton so-skeleton-static so-skeleton-text" style="width: 60%"></div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Wave animation (default) --&gt;
&lt;div class="so-skeleton so-skeleton-text"&gt;&lt;/div&gt;

&lt;!-- Pulse animation --&gt;
&lt;div class="so-skeleton so-skeleton-pulse so-skeleton-text"&gt;&lt;/div&gt;

&lt;!-- No animation (static) --&gt;
&lt;div class="so-skeleton so-skeleton-static so-skeleton-text"&gt;&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Skeleton Presets -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Skeleton Presets</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Ready-to-use skeleton components that can be dropped in directly.</p>

        <h6 class="so-text-muted so-mb-3">Card Preset</h6>
        <div class="so-row so-g-4 so-mb-5">
            <div class="so-col-md-4">
                <div class="so-skeleton-card">
                    <div class="so-skeleton-card-img"></div>
                    <div class="so-skeleton-card-body">
                        <div class="so-skeleton-card-title"></div>
                        <div class="so-skeleton-card-text"></div>
                        <div class="so-skeleton-card-text"></div>
                        <div class="so-skeleton-card-text"></div>
                        <div class="so-skeleton-card-btn"></div>
                    </div>
                </div>
            </div>
            <div class="so-col-md-4">
                <div class="so-skeleton-card so-skeleton-card-text-only">
                    <div class="so-skeleton-card-body">
                        <div class="so-skeleton-card-title"></div>
                        <div class="so-skeleton-card-text"></div>
                        <div class="so-skeleton-card-text"></div>
                        <div class="so-skeleton-card-text"></div>
                    </div>
                </div>
            </div>
            <div class="so-col-md-4">
                <div class="so-skeleton-stats">
                    <div class="so-skeleton-stats-header">
                        <div class="so-skeleton-stats-label"></div>
                        <div class="so-skeleton-stats-icon"></div>
                    </div>
                    <div class="so-skeleton-stats-value"></div>
                    <div class="so-skeleton-stats-change"></div>
                </div>
            </div>
        </div>

        <h6 class="so-text-muted so-mb-3">List Item Preset</h6>
        <div class="so-card so-card-bordered so-mb-5">
            <div class="so-skeleton-list-item">
                <div class="so-skeleton-list-avatar"></div>
                <div class="so-skeleton-list-content">
                    <div class="so-skeleton-list-title"></div>
                    <div class="so-skeleton-list-subtitle"></div>
                </div>
                <div class="so-skeleton-list-action"></div>
            </div>
            <div class="so-skeleton-list-item">
                <div class="so-skeleton-list-avatar"></div>
                <div class="so-skeleton-list-content">
                    <div class="so-skeleton-list-title"></div>
                    <div class="so-skeleton-list-subtitle"></div>
                </div>
                <div class="so-skeleton-list-action"></div>
            </div>
            <div class="so-skeleton-list-item">
                <div class="so-skeleton-list-avatar"></div>
                <div class="so-skeleton-list-content">
                    <div class="so-skeleton-list-title"></div>
                    <div class="so-skeleton-list-subtitle"></div>
                </div>
                <div class="so-skeleton-list-action"></div>
            </div>
        </div>

        <h6 class="so-text-muted so-mb-3">Avatar Sizes</h6>
        <div class="so-d-flex so-align-items-end so-gap-3 so-mb-4">
            <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xs"></div>
            <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-sm"></div>
            <div class="so-skeleton so-skeleton-avatar"></div>
            <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-lg"></div>
            <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xl"></div>
            <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-2xl"></div>
        </div>

        <div class="so-code-block">
            <div class="so-code-header">
                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
            </div>
            <pre class="so-code-content"><code class="language-html">&lt;!-- Card Preset --&gt;
&lt;div class="so-skeleton-card"&gt;
    &lt;div class="so-skeleton-card-img"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton-card-body"&gt;
        &lt;div class="so-skeleton-card-title"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton-card-text"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton-card-text"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton-card-btn"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- List Item Preset --&gt;
&lt;div class="so-skeleton-list-item"&gt;
    &lt;div class="so-skeleton-list-avatar"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton-list-content"&gt;
        &lt;div class="so-skeleton-list-title"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton-list-subtitle"&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-skeleton-list-action"&gt;&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Stats Card Preset --&gt;
&lt;div class="so-skeleton-stats"&gt;
    &lt;div class="so-skeleton-stats-header"&gt;
        &lt;div class="so-skeleton-stats-label"&gt;&lt;/div&gt;
        &lt;div class="so-skeleton-stats-icon"&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-skeleton-stats-value"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton-stats-change"&gt;&lt;/div&gt;
&lt;/div&gt;

&lt;!-- Avatar Sizes --&gt;
&lt;div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xs"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-sm"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-avatar"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-lg"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xl"&gt;&lt;/div&gt;
&lt;div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-2xl"&gt;&lt;/div&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Real World Example -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Real World Comparison</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Side-by-side comparison of skeleton loading and loaded content.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">Loading State</h6>
                        <div class="so-card so-card-bordered">
                            <div class="so-card-body">
                                <div class="so-d-flex so-align-items-center so-gap-3 so-mb-3">
                                    <div class="so-skeleton so-skeleton-circle" style="width: 48px; height: 48px;"></div>
                                    <div class="so-flex-grow-1">
                                        <div class="so-skeleton so-skeleton-text so-mb-1" style="width: 40%;"></div>
                                        <div class="so-skeleton so-skeleton-text" style="width: 60%; height: 12px;"></div>
                                    </div>
                                </div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width: 70%;"></div>
                                <div class="so-d-flex so-gap-2 so-mt-3">
                                    <div class="so-skeleton so-skeleton-rounded" style="width: 80px; height: 32px;"></div>
                                    <div class="so-skeleton so-skeleton-rounded" style="width: 80px; height: 32px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">Loaded State</h6>
                        <div class="so-card so-card-bordered">
                            <div class="so-card-body">
                                <div class="so-d-flex so-align-items-center so-gap-3 so-mb-3">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Connor&background=667eea&color=fff&size=48" alt="Sarah Connor" style="width: 48px; height: 48px; border-radius: 50%;">
                                    <div>
                                        <h6 class="so-mb-0">Sarah Connor</h6>
                                        <span class="so-text-muted so-text-sm">Product Designer</span>
                                    </div>
                                </div>
                                <p>Just finished the new dashboard design! Really happy with how it turned out. Can't wait to share it with the team tomorrow.</p>
                                <div class="so-d-flex so-gap-2 so-mt-3">
                                    <button class="so-btn so-btn-sm so-btn-outline">
                                        <span class="material-icons">thumb_up</span> Like
                                    </button>
                                    <button class="so-btn so-btn-sm so-btn-outline">
                                        <span class="material-icons">chat_bubble</span> Reply
                                    </button>
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
                <pre class="so-code-content"><code class="language-html">&lt;!-- Post card skeleton --&gt;
&lt;div class="so-card-body"&gt;
    &lt;div class="so-d-flex so-align-items-center so-gap-3 so-mb-3"&gt;
        &lt;div class="so-skeleton so-skeleton-circle" style="width: 48px; height: 48px;"&gt;&lt;/div&gt;
        &lt;div class="so-flex-grow-1"&gt;
            &lt;div class="so-skeleton so-skeleton-text so-mb-1" style="width: 40%;"&gt;&lt;/div&gt;
            &lt;div class="so-skeleton so-skeleton-text" style="width: 60%; height: 12px;"&gt;&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-text so-mb-2"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-text so-mb-2"&gt;&lt;/div&gt;
    &lt;div class="so-skeleton so-skeleton-text" style="width: 70%;"&gt;&lt;/div&gt;
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
