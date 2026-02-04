<?php
/**
 * SixOrbit UI Demo - Timeline
 */
$pageTitle = 'Timeline';
$pageDescription = 'Display chronological events and activities with visual timeline components.';

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

<!-- Basic Timeline -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Timeline</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Simple vertical timeline with left-aligned content.</p>

        <div class="so-timeline">
            <div class="so-timeline-item">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">Today</div>
                    <div class="so-timeline-title">Project Completed</div>
                    <div class="so-timeline-body">
                        <p>The final deliverables were submitted and approved by the client.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">Yesterday</div>
                    <div class="so-timeline-title">Code Review</div>
                    <div class="so-timeline-body">
                        <p>Final code review completed with all changes approved.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">3 days ago</div>
                    <div class="so-timeline-title">Testing Phase</div>
                    <div class="so-timeline-body">
                        <p>QA testing completed successfully with no critical bugs found.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">1 week ago</div>
                    <div class="so-timeline-title">Project Started</div>
                    <div class="so-timeline-body">
                        <p>Initial project kickoff meeting and requirements gathering.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline"&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-marker"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;div class="so-timeline-time"&gt;Today&lt;/div&gt;
            &lt;div class="so-timeline-title"&gt;Project Completed&lt;/div&gt;
            &lt;div class="so-timeline-body"&gt;
                &lt;p&gt;The final deliverables were submitted.&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;!-- Last item omits connector --&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-marker"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;...&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Timeline with Icons -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Timeline with Icons</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Timeline with custom icons for each event.</p>

        <div class="so-timeline so-timeline-icons">
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-success">
                    <span class="material-icons">check_circle</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">2:30 PM</div>
                    <div class="so-timeline-title">Order Delivered</div>
                    <div class="so-timeline-body">
                        <p>Package was delivered to the recipient.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-primary">
                    <span class="material-icons">local_shipping</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">10:15 AM</div>
                    <div class="so-timeline-title">Out for Delivery</div>
                    <div class="so-timeline-body">
                        <p>Package is with the courier and on its way.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-info">
                    <span class="material-icons">warehouse</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">Yesterday, 8:00 PM</div>
                    <div class="so-timeline-title">Arrived at Local Facility</div>
                    <div class="so-timeline-body">
                        <p>Package arrived at the distribution center.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-warning">
                    <span class="material-icons">inventory_2</span>
                </div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">2 days ago</div>
                    <div class="so-timeline-title">Order Shipped</div>
                    <div class="so-timeline-body">
                        <p>Seller has shipped your order.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline"&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-marker so-timeline-marker-success"&gt;
            &lt;span class="material-icons"&gt;check_circle&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;div class="so-timeline-time"&gt;2:30 PM&lt;/div&gt;
            &lt;div class="so-timeline-title"&gt;Order Delivered&lt;/div&gt;
            &lt;div class="so-timeline-body"&gt;...&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Color variants: so-timeline-marker-primary, -success, -danger, -warning, -info --&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Centered Timeline -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Centered Timeline</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Timeline with centered line and alternating content.</p>

        <div class="so-timeline so-timeline-centered">
            <div class="so-timeline-item so-timeline-left">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">2024</div>
                    <div class="so-timeline-title">Series B Funding</div>
                    <div class="so-timeline-body">
                        <p>Raised $50M in Series B funding to expand operations.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item so-timeline-right">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">2023</div>
                    <div class="so-timeline-title">Product Launch</div>
                    <div class="so-timeline-body">
                        <p>Successfully launched our flagship product to the market.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item so-timeline-left">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">2022</div>
                    <div class="so-timeline-title">Series A Funding</div>
                    <div class="so-timeline-body">
                        <p>Secured $10M in Series A to build our core team.</p>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item so-timeline-right">
                <div class="so-timeline-marker"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-time">2021</div>
                    <div class="so-timeline-title">Company Founded</div>
                    <div class="so-timeline-body">
                        <p>Started with a vision to transform the industry.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline so-timeline-centered"&gt;
    &lt;!-- Left-aligned item --&gt;
    &lt;div class="so-timeline-item so-timeline-left"&gt;
        &lt;div class="so-timeline-marker"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;div class="so-timeline-time"&gt;2024&lt;/div&gt;
            &lt;div class="so-timeline-title"&gt;Event Title&lt;/div&gt;
            &lt;div class="so-timeline-body"&gt;...&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;!-- Right-aligned item --&gt;
    &lt;div class="so-timeline-item so-timeline-right"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Compact Timeline -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Compact Timeline</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Dense timeline with minimal spacing.</p>

        <div class="so-timeline so-timeline-compact">
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-sm"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <span class="so-text-muted so-text-sm">10:45 AM</span>
                    <span class="so-ms-2">File uploaded successfully</span>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-sm"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <span class="so-text-muted so-text-sm">10:42 AM</span>
                    <span class="so-ms-2">Processing started</span>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-sm"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <span class="so-text-muted so-text-sm">10:40 AM</span>
                    <span class="so-ms-2">Validation complete</span>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-sm"></div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <span class="so-text-muted so-text-sm">10:38 AM</span>
                    <span class="so-ms-2">File received</span>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-sm"></div>
                <div class="so-timeline-content">
                    <span class="so-text-muted so-text-sm">10:35 AM</span>
                    <span class="so-ms-2">Upload initiated</span>
                </div>
            </div>
        </div>
        <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline so-timeline-compact"&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-marker so-timeline-marker-sm"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;span class="so-text-muted so-text-sm"&gt;10:45 AM&lt;/span&gt;
            &lt;span class="so-ms-2"&gt;Event description&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;!-- More items... --&gt;
&lt;/div&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Activity Feed -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Activity Feed</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Social media style activity feed.</p>

        <div class="so-timeline so-timeline-feed">
            <div class="so-timeline-item">
                <div class="so-timeline-avatar">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=667eea&color=fff" alt="John Doe">
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-header">
                        <strong>John Doe</strong>
                        <span class="so-text-muted">commented on your post</span>
                    </div>
                    <div class="so-timeline-body">
                        <p class="so-text-muted">"Great work on this project! The design looks amazing."</p>
                    </div>
                    <div class="so-timeline-time">2 hours ago</div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-avatar">
                    <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=f093fb&color=fff" alt="Jane Smith">
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-header">
                        <strong>Jane Smith</strong>
                        <span class="so-text-muted">liked your photo</span>
                    </div>
                    <div class="so-timeline-time">4 hours ago</div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-avatar">
                    <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=4facfe&color=fff" alt="Mike Johnson">
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-header">
                        <strong>Mike Johnson</strong>
                        <span class="so-text-muted">started following you</span>
                    </div>
                    <div class="so-timeline-time">Yesterday</div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-avatar">
                    <span class="material-icons">notifications</span>
                </div>
                <div class="so-timeline-content">
                    <div class="so-timeline-header">
                        <strong>System</strong>
                        <span class="so-text-muted">Your account was verified</span>
                    </div>
                    <div class="so-timeline-time">2 days ago</div>
                </div>
            </div>
        </div>
        <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline so-timeline-feed"&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-avatar"&gt;
            &lt;img src="avatar.jpg" alt="User"&gt;
        &lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;div class="so-timeline-header"&gt;
                &lt;strong&gt;John Doe&lt;/strong&gt;
                &lt;span class="so-text-muted"&gt;commented on your post&lt;/span&gt;
            &lt;/div&gt;
            &lt;div class="so-timeline-body"&gt;...&lt;/div&gt;
            &lt;div class="so-timeline-time"&gt;2 hours ago&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;!-- System notification with icon --&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-avatar"&gt;
            &lt;span class="material-icons"&gt;notifications&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;...&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Horizontal Timeline -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Horizontal Timeline</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Horizontal layout for process or roadmap display.</p>

        <div class="so-timeline so-timeline-horizontal">
            <div class="so-timeline-item so-timeline-item-completed">
                <div class="so-timeline-marker">
                    <span class="material-icons">check</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-title">Q1 2024</div>
                    <div class="so-timeline-body">Research</div>
                </div>
            </div>
            <div class="so-timeline-item so-timeline-item-completed">
                <div class="so-timeline-marker">
                    <span class="material-icons">check</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-title">Q2 2024</div>
                    <div class="so-timeline-body">Design</div>
                </div>
            </div>
            <div class="so-timeline-item so-timeline-item-active">
                <div class="so-timeline-marker">3</div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-title">Q3 2024</div>
                    <div class="so-timeline-body">Development</div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker">4</div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-timeline-title">Q4 2024</div>
                    <div class="so-timeline-body">Launch</div>
                </div>
            </div>
        </div>
        <div class="so-code-block">
                <div class="so-code-header">
                    <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                    <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                </div>
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline so-timeline-horizontal"&gt;
    &lt;div class="so-timeline-item so-timeline-item-completed"&gt;
        &lt;div class="so-timeline-marker"&gt;
            &lt;span class="material-icons"&gt;check&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;div class="so-timeline-title"&gt;Q1 2024&lt;/div&gt;
            &lt;div class="so-timeline-body"&gt;Research&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-timeline-item so-timeline-item-active"&gt;...&lt;/div&gt;
    &lt;div class="so-timeline-item"&gt;...&lt;/div&gt;
&lt;/div&gt;

&lt;!-- States: so-timeline-item-completed, so-timeline-item-active --&gt;</code></pre>
        </div>
    </div>
</div>

<!-- Timeline with Cards -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Timeline with Cards</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Timeline items displayed as cards.</p>

        <div class="so-timeline so-timeline-cards">
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-primary">
                    <span class="material-icons">event</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-card so-card-bordered">
                        <div class="so-card-body">
                            <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                                <h6 class="so-mb-0">Team Meeting</h6>
                                <span class="so-badge so-badge-primary">Upcoming</span>
                            </div>
                            <p class="so-text-muted so-mb-2">Weekly standup with the development team to discuss progress and blockers.</p>
                            <div class="so-d-flex so-gap-3 so-text-sm so-text-muted">
                                <span><span class="material-icons so-text-sm">schedule</span> 10:00 AM</span>
                                <span><span class="material-icons so-text-sm">people</span> 8 attendees</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-success">
                    <span class="material-icons">task_alt</span>
                </div>
                <div class="so-timeline-connector"></div>
                <div class="so-timeline-content">
                    <div class="so-card so-card-bordered">
                        <div class="so-card-body">
                            <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                                <h6 class="so-mb-0">Sprint Completed</h6>
                                <span class="so-badge so-badge-success">Done</span>
                            </div>
                            <p class="so-text-muted so-mb-0">Sprint 14 was completed with all user stories delivered on time.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="so-timeline-item">
                <div class="so-timeline-marker so-timeline-marker-warning">
                    <span class="material-icons">warning</span>
                </div>
                <div class="so-timeline-content">
                    <div class="so-card so-card-bordered">
                        <div class="so-card-body">
                            <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
                                <h6 class="so-mb-0">Deadline Approaching</h6>
                                <span class="so-badge so-badge-warning">Alert</span>
                            </div>
                            <p class="so-text-muted so-mb-0">Project milestone deadline is in 3 days. Review required tasks.</p>
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
                <pre class="so-code-content"><code class="language-html">&lt;div class="so-timeline so-timeline-cards"&gt;
    &lt;div class="so-timeline-item"&gt;
        &lt;div class="so-timeline-marker so-timeline-marker-primary"&gt;
            &lt;span class="material-icons"&gt;event&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-timeline-connector"&gt;&lt;/div&gt;
        &lt;div class="so-timeline-content"&gt;
            &lt;div class="so-card so-card-bordered"&gt;
                &lt;div class="so-card-body"&gt;
                    &lt;h6&gt;Event Title&lt;/h6&gt;
                    &lt;p class="so-text-muted"&gt;Description...&lt;/p&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
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
