<?php
/**
 * SixOrbit UI Demo - RTL Support
 */
$pageTitle = 'RTL Support';
$pageDescription = 'Right-to-left language support utilities for Arabic, Hebrew, Persian, and other RTL languages.';

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

<!-- RTL Container -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">RTL Container</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Apply RTL direction to a container and its children.</p>

            <div class="so-code-block so-mb-4">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- RTL container using dir attribute --&gt;
&lt;div dir="rtl"&gt;
    &lt;p&gt;Arabic or Hebrew text here...&lt;/p&gt;
&lt;/div&gt;

&lt;!-- RTL utilities --&gt;
&lt;div class="so-text-start"&gt;Start-aligned (left in LTR, right in RTL)&lt;/div&gt;
&lt;div class="so-text-end"&gt;End-aligned (right in LTR, left in RTL)&lt;/div&gt;
&lt;div class="so-ms-auto"&gt;Margin start auto&lt;/div&gt;
&lt;div class="so-me-3"&gt;Margin end 3&lt;/div&gt;</code></pre>
            </div>

        <div class="so-card so-card-bordered so-mb-4">
            <div class="so-card-header">
                <h6 class="so-card-title">Default (LTR)</h6>
            </div>
            <div class="so-card-body">
                <p>This text flows from left to right. This is the default text direction for English and other Western languages.</p>
                <ul class="so-list-group">
                    <li class="so-list-group-item">First item</li>
                    <li class="so-list-group-item">Second item</li>
                    <li class="so-list-group-item">Third item</li>
                </ul>
            </div>
        </div>

        <div class="so-card so-card-bordered" dir="rtl">
            <div class="so-card-header">
                <h6 class="so-card-title">RTL Direction</h6>
            </div>
            <div class="so-card-body">
                <p>هذا النص يتدفق من اليمين إلى اليسار. هذا هو اتجاه النص الافتراضي للغة العربية.</p>
                <ul class="so-list-group">
                    <li class="so-list-group-item">العنصر الأول</li>
                    <li class="so-list-group-item">العنصر الثاني</li>
                    <li class="so-list-group-item">العنصر الثالث</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Logical Text Alignment -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Logical Text Alignment</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Use logical properties that adapt to text direction.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-header">
                                <h6 class="so-card-title">LTR Context</h6>
                            </div>
                            <div class="so-card-body">
                                <p class="so-text-start so-p-3 so-bg-muted so-mb-2"><code>.so-text-start</code> - Aligned left</p>
                                <p class="so-text-end so-p-3 so-bg-muted"><code>.so-text-end</code> - Aligned right</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered" dir="rtl">
                            <div class="so-card-header">
                                <h6 class="so-card-title">RTL Context</h6>
                            </div>
                            <div class="so-card-body">
                                <p class="so-text-start so-p-3 so-bg-muted so-mb-2"><code>.so-text-start</code> - محاذاة لليمين</p>
                                <p class="so-text-end so-p-3 so-bg-muted"><code>.so-text-end</code> - محاذاة لليسار</p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Start-aligned text (left in LTR, right in RTL) --&gt;
&lt;p class="so-text-start"&gt;Start-aligned text&lt;/p&gt;

&lt;!-- End-aligned text (right in LTR, left in RTL) --&gt;
&lt;p class="so-text-end"&gt;End-aligned text&lt;/p&gt;

&lt;!-- RTL container --&gt;
&lt;div dir="rtl"&gt;
    &lt;p class="so-text-start"&gt;محاذاة لليمين&lt;/p&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Logical Margins & Padding -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Logical Margins & Padding</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Margin and padding utilities that flip in RTL.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">LTR Context</h6>
                        <div class="so-card so-card-bordered so-p-3">
                            <div class="so-ms-4 so-p-3 so-bg-primary-subtle so-mb-2">
                                <code>.so-ms-4</code> - Margin start (left)
                            </div>
                            <div class="so-me-4 so-p-3 so-bg-success-subtle so-mb-2">
                                <code>.so-me-4</code> - Margin end (right)
                            </div>
                            <div class="so-ps-4 so-p-3 so-bg-warning-subtle so-mb-2">
                                <code>.so-ps-4</code> - Padding start (left)
                            </div>
                            <div class="so-pe-4 so-p-3 so-bg-danger-subtle">
                                <code>.so-pe-4</code> - Padding end (right)
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">RTL Context</h6>
                        <div class="so-card so-card-bordered so-p-3" dir="rtl">
                            <div class="so-ms-4 so-p-3 so-bg-primary-subtle so-mb-2">
                                <code>.so-ms-4</code> - هامش البداية (يمين)
                            </div>
                            <div class="so-me-4 so-p-3 so-bg-success-subtle so-mb-2">
                                <code>.so-me-4</code> - هامش النهاية (يسار)
                            </div>
                            <div class="so-ps-4 so-p-3 so-bg-warning-subtle so-mb-2">
                                <code>.so-ps-4</code> - حشوة البداية (يمين)
                            </div>
                            <div class="so-pe-4 so-p-3 so-bg-danger-subtle">
                                <code>.so-pe-4</code> - حشوة النهاية (يسار)
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Margin start (left in LTR, right in RTL) --&gt;
&lt;div class="so-ms-4"&gt;Margin start&lt;/div&gt;

&lt;!-- Margin end (right in LTR, left in RTL) --&gt;
&lt;div class="so-me-4"&gt;Margin end&lt;/div&gt;

&lt;!-- Padding start (left in LTR, right in RTL) --&gt;
&lt;div class="so-ps-4"&gt;Padding start&lt;/div&gt;

&lt;!-- Padding end (right in LTR, left in RTL) --&gt;
&lt;div class="so-pe-4"&gt;Padding end&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Logical Floats -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Logical Floats</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Float utilities that adapt to text direction.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-header">
                                <h6 class="so-card-title">LTR Context</h6>
                            </div>
                            <div class="so-card-body" style="overflow: hidden;">
                                <img src="https://ui-avatars.com/api/?name=Float&background=667eea&color=fff&size=80" class="so-float-start so-me-3 so-mb-2" alt="Float Start">
                                <p>This image uses <code>.so-float-start</code> which floats it to the left in LTR mode. The text wraps around the image naturally.</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered" dir="rtl">
                            <div class="so-card-header">
                                <h6 class="so-card-title">RTL Context</h6>
                            </div>
                            <div class="so-card-body" style="overflow: hidden;">
                                <img src="https://ui-avatars.com/api/?name=Float&background=667eea&color=fff&size=80" class="so-float-start so-ms-3 so-mb-2" alt="Float Start">
                                <p>هذه الصورة تستخدم <code>.so-float-start</code> والتي تطفو إلى اليمين في وضع RTL. يلتف النص حول الصورة بشكل طبيعي.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Float start (left in LTR, right in RTL) --&gt;
&lt;img class="so-float-start so-me-3" src="image.jpg"&gt;
&lt;p&gt;Text wraps around the image...&lt;/p&gt;

&lt;!-- Float end (right in LTR, left in RTL) --&gt;
&lt;img class="so-float-end so-ms-3" src="image.jpg"&gt;
&lt;p&gt;Text wraps around the image...&lt;/p&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Logical Borders -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Logical Borders</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Border utilities that flip in RTL.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">LTR Context</h6>
                        <div class="so-border-start so-p-3 so-mb-2" style="border-width: 3px !important;">
                            <code>.so-border-start</code> - Border on left
                        </div>
                        <div class="so-border-end so-p-3" style="border-width: 3px !important;">
                            <code>.so-border-end</code> - Border on right
                        </div>
                    </div>
                    <div class="so-col-md-6" dir="rtl">
                        <h6 class="so-text-muted so-mb-3">RTL Context</h6>
                        <div class="so-border-start so-p-3 so-mb-2" style="border-width: 3px !important;">
                            <code>.so-border-start</code> - حدود على اليمين
                        </div>
                        <div class="so-border-end so-p-3" style="border-width: 3px !important;">
                            <code>.so-border-end</code> - حدود على اليسار
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Border on start side (left in LTR, right in RTL) --&gt;
&lt;div class="so-border-start"&gt;Border start&lt;/div&gt;

&lt;!-- Border on end side (right in LTR, left in RTL) --&gt;
&lt;div class="so-border-end"&gt;Border end&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Icon Flipping -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Icon Flipping</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Automatically flip directional icons in RTL mode.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">LTR Context</h6>
                        <div class="so-d-flex so-gap-3 so-align-items-center">
                            <span class="material-icons so-rtl-flip">arrow_forward</span>
                            <span class="material-icons so-rtl-flip">chevron_right</span>
                            <span class="material-icons so-rtl-flip">arrow_back</span>
                            <span class="material-icons so-rtl-flip">reply</span>
                            <span class="material-icons so-rtl-flip">redo</span>
                        </div>
                    </div>
                    <div class="so-col-md-6" dir="rtl">
                        <h6 class="so-text-muted so-mb-3">RTL Context (Flipped)</h6>
                        <div class="so-d-flex so-gap-3 so-align-items-center">
                            <span class="material-icons so-rtl-flip">arrow_forward</span>
                            <span class="material-icons so-rtl-flip">chevron_right</span>
                            <span class="material-icons so-rtl-flip">arrow_back</span>
                            <span class="material-icons so-rtl-flip">reply</span>
                            <span class="material-icons so-rtl-flip">redo</span>
                        </div>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Directional icons that flip in RTL --&gt;
&lt;span class="material-icons so-rtl-flip"&gt;arrow_forward&lt;/span&gt;
&lt;span class="material-icons so-rtl-flip"&gt;chevron_right&lt;/span&gt;
&lt;span class="material-icons so-rtl-flip"&gt;arrow_back&lt;/span&gt;
&lt;span class="material-icons so-rtl-flip"&gt;reply&lt;/span&gt;
&lt;span class="material-icons so-rtl-flip"&gt;redo&lt;/span&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Form Elements in RTL -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Form Elements in RTL</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Form controls automatically adapt to RTL.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <h6 class="so-text-muted so-mb-3">LTR Form</h6>
                        <form>
                            <div class="so-form-group">
                                <label class="so-form-label">Email Address</label>
                                <input type="email" class="so-form-control" placeholder="Enter your email">
                            </div>
                            <div class="so-form-group">
                                <label class="so-form-label">Password</label>
                                <input type="password" class="so-form-control" placeholder="Enter password">
                            </div>
                            <div class="so-form-group">
                                <label class="so-checkbox">
                                    <input type="checkbox" class="so-checkbox-input">
                                    <span class="so-checkbox-box"></span>
                                    <span class="so-checkbox-label">Remember me</span>
                                </label>
                            </div>
                            <button type="button" class="so-btn so-btn-primary">Sign In</button>
                        </form>
                    </div>
                    <div class="so-col-md-6" dir="rtl">
                        <h6 class="so-text-muted so-mb-3">RTL Form</h6>
                        <form>
                            <div class="so-form-group">
                                <label class="so-form-label">البريد الإلكتروني</label>
                                <input type="email" class="so-form-control" placeholder="أدخل بريدك الإلكتروني">
                            </div>
                            <div class="so-form-group">
                                <label class="so-form-label">كلمة المرور</label>
                                <input type="password" class="so-form-control" placeholder="أدخل كلمة المرور">
                            </div>
                            <div class="so-form-group">
                                <label class="so-checkbox">
                                    <input type="checkbox" class="so-checkbox-input">
                                    <span class="so-checkbox-box"></span>
                                    <span class="so-checkbox-label">تذكرني</span>
                                </label>
                            </div>
                            <button type="button" class="so-btn so-btn-primary">تسجيل الدخول</button>
                        </form>
                    </div>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- RTL Form - just add dir="rtl" to container --&gt;
&lt;form dir="rtl"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;البريد الإلكتروني&lt;/label&gt;
        &lt;input type="email" class="so-form-control" placeholder="أدخل بريدك"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox" class="so-checkbox-input"&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;تذكرني&lt;/span&gt;
        &lt;/label&gt;
    &lt;/div&gt;
    &lt;button type="button" class="so-btn so-btn-primary"&gt;تسجيل الدخول&lt;/button&gt;
&lt;/form&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Navigation in RTL -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Navigation in RTL</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Navigation components adapt to RTL direction.</p>

                <h6 class="so-text-muted so-mb-3">LTR Navigation</h6>
                <nav class="so-breadcrumb so-mb-4">
                    <a href="#" class="so-breadcrumb-item">Home</a>
                    <span class="so-breadcrumb-separator">/</span>
                    <a href="#" class="so-breadcrumb-item">Products</a>
                    <span class="so-breadcrumb-separator">/</span>
                    <span class="so-breadcrumb-item so-active">Details</span>
                </nav>

                <h6 class="so-text-muted so-mb-3">RTL Navigation</h6>
                <nav class="so-breadcrumb" dir="rtl">
                    <a href="#" class="so-breadcrumb-item">الرئيسية</a>
                    <span class="so-breadcrumb-separator">/</span>
                    <a href="#" class="so-breadcrumb-item">المنتجات</a>
                    <span class="so-breadcrumb-separator">/</span>
                    <span class="so-breadcrumb-item so-active">التفاصيل</span>
                </nav>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- RTL Breadcrumb --&gt;
&lt;nav class="so-breadcrumb" dir="rtl"&gt;
    &lt;a href="#" class="so-breadcrumb-item"&gt;الرئيسية&lt;/a&gt;
    &lt;span class="so-breadcrumb-separator"&gt;/&lt;/span&gt;
    &lt;a href="#" class="so-breadcrumb-item"&gt;المنتجات&lt;/a&gt;
    &lt;span class="so-breadcrumb-separator"&gt;/&lt;/span&gt;
    &lt;span class="so-breadcrumb-item so-active"&gt;التفاصيل&lt;/span&gt;
&lt;/nav&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Bidirectional Text -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Bidirectional Text</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Handle mixed LTR and RTL content.</p>

                <div class="so-card so-card-bordered so-p-3 so-mb-3" dir="rtl">
                    <p>هذا نص عربي يحتوي على <span class="so-bidi-isolate" dir="ltr">English text</span> في المنتصف.</p>
                </div>

                <div class="so-card so-card-bordered so-p-3">
                    <p>This English text contains <span class="so-bidi-isolate" dir="rtl">نص عربي</span> in the middle.</p>
                </div>
            <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;!-- Arabic text with embedded English --&gt;
&lt;div dir="rtl"&gt;
    &lt;p&gt;هذا نص عربي &lt;span class="so-bidi-isolate" dir="ltr"&gt;English text&lt;/span&gt; المزيد&lt;/p&gt;
&lt;/div&gt;

&lt;!-- English text with embedded Arabic --&gt;
&lt;div&gt;
    &lt;p&gt;English text &lt;span class="so-bidi-isolate" dir="rtl"&gt;نص عربي&lt;/span&gt; more text&lt;/p&gt;
&lt;/div&gt;</code></pre>
            </div>
    </div>
</div>

<!-- Available Classes -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Available Classes</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Quick reference for RTL utility classes.</p>

        <div class="so-table-responsive">
            <table class="so-table">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Description</th>
                        <th>LTR Effect</th>
                        <th>RTL Effect</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>.so-text-start</code></td>
                        <td>Logical text alignment start</td>
                        <td>text-align: left</td>
                        <td>text-align: right</td>
                    </tr>
                    <tr>
                        <td><code>.so-text-end</code></td>
                        <td>Logical text alignment end</td>
                        <td>text-align: right</td>
                        <td>text-align: left</td>
                    </tr>
                    <tr>
                        <td><code>.so-float-start</code></td>
                        <td>Logical float start</td>
                        <td>float: left</td>
                        <td>float: right</td>
                    </tr>
                    <tr>
                        <td><code>.so-float-end</code></td>
                        <td>Logical float end</td>
                        <td>float: right</td>
                        <td>float: left</td>
                    </tr>
                    <tr>
                        <td><code>.so-ms-*</code></td>
                        <td>Margin start</td>
                        <td>margin-left</td>
                        <td>margin-right</td>
                    </tr>
                    <tr>
                        <td><code>.so-me-*</code></td>
                        <td>Margin end</td>
                        <td>margin-right</td>
                        <td>margin-left</td>
                    </tr>
                    <tr>
                        <td><code>.so-ps-*</code></td>
                        <td>Padding start</td>
                        <td>padding-left</td>
                        <td>padding-right</td>
                    </tr>
                    <tr>
                        <td><code>.so-pe-*</code></td>
                        <td>Padding end</td>
                        <td>padding-right</td>
                        <td>padding-left</td>
                    </tr>
                    <tr>
                        <td><code>.so-border-start</code></td>
                        <td>Border on start side</td>
                        <td>border-left</td>
                        <td>border-right</td>
                    </tr>
                    <tr>
                        <td><code>.so-border-end</code></td>
                        <td>Border on end side</td>
                        <td>border-right</td>
                        <td>border-left</td>
                    </tr>
                    <tr>
                        <td><code>.so-rtl-flip</code></td>
                        <td>Horizontal flip in RTL</td>
                        <td>No transform</td>
                        <td>scaleX(-1)</td>
                    </tr>
                </tbody>
            </table>
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
