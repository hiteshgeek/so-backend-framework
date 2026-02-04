<?php
/**
 * SixOrbit UI Engine - Timeline Element Demo
 */

$pageTitle = 'Timeline - UI Engine';
$pageDescription = 'Vertical timeline for displaying events';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Timeline</h1>
            <p class="so-page-subtitle">Vertical timeline for displaying chronological events and activity feeds.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Timeline -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Timeline</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-timeline so-mb-4">
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker"></div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Jan 15, 2026</div>
                            <h6 class="so-timeline-title">Project Started</h6>
                            <p class="so-timeline-text">Initial project setup and configuration</p>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker"></div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Jan 22, 2026</div>
                            <h6 class="so-timeline-title">Design Complete</h6>
                            <p class="so-timeline-text">UI/UX design finalized and approved</p>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker"></div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Feb 1, 2026</div>
                            <h6 class="so-timeline-title">Development</h6>
                            <p class="so-timeline-text">Backend and frontend development in progress</p>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker"></div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Feb 10, 2026</div>
                            <h6 class="so-timeline-title">Testing</h6>
                            <p class="so-timeline-text">QA testing and bug fixes</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-timeline', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$timeline = UiEngine::timeline()
    ->event('Project Started', 'Initial project setup and configuration', 'Jan 15, 2026')
    ->event('Design Complete', 'UI/UX design finalized and approved', 'Jan 22, 2026')
    ->event('Development', 'Backend and frontend development in progress', 'Feb 1, 2026')
    ->event('Testing', 'QA testing and bug fixes', 'Feb 10, 2026');

echo \$timeline->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timeline = UiEngine.timeline()
    .event('Project Started', 'Initial project setup and configuration', 'Jan 15, 2026')
    .event('Design Complete', 'UI/UX design finalized and approved', 'Jan 22, 2026')
    .event('Development', 'Backend and frontend development in progress', 'Feb 1, 2026')
    .event('Testing', 'QA testing and bug fixes', 'Feb 10, 2026');

document.getElementById('container').innerHTML = timeline.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-timeline">
    <div class="so-timeline-item">
        <div class="so-timeline-marker"></div>
        <div class="so-timeline-content">
            <div class="so-timeline-time">Jan 15, 2026</div>
            <h6 class="so-timeline-title">Project Started</h6>
            <p class="so-timeline-text">Initial project setup and configuration</p>
        </div>
    </div>
    <!-- More items... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-timeline so-mb-4">
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-primary">
                            <span class="material-icons" style="font-size:16px;color:white;">shopping_cart</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">10:30 AM</div>
                            <h6 class="so-timeline-title">Order Placed</h6>
                            <p class="so-timeline-text">Your order has been placed</p>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-success">
                            <span class="material-icons" style="font-size:16px;color:white;">payment</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">10:32 AM</div>
                            <h6 class="so-timeline-title">Payment Confirmed</h6>
                            <p class="so-timeline-text">Payment received successfully</p>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-info">
                            <span class="material-icons" style="font-size:16px;color:white;">inventory</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">11:00 AM</div>
                            <h6 class="so-timeline-title">Processing</h6>
                            <p class="so-timeline-text">Order is being prepared</p>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-warning">
                            <span class="material-icons" style="font-size:16px;color:white;">local_shipping</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">2:00 PM</div>
                            <h6 class="so-timeline-title">Shipped</h6>
                            <p class="so-timeline-text">Package dispatched</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('timeline-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$timeline = UiEngine::timeline()
    ->event('Order Placed', 'Your order has been placed', '10:30 AM', [
        'icon' => 'shopping_cart',
        'color' => 'primary',
    ])
    ->event('Payment Confirmed', 'Payment received successfully', '10:32 AM', [
        'icon' => 'payment',
        'color' => 'success',
    ])
    ->event('Processing', 'Order is being prepared', '11:00 AM', [
        'icon' => 'inventory',
        'color' => 'info',
    ])
    ->event('Shipped', 'Package dispatched', '2:00 PM', [
        'icon' => 'local_shipping',
        'color' => 'warning',
    ]);

echo \$timeline->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timeline = UiEngine.timeline()
    .event('Order Placed', 'Your order has been placed', '10:30 AM', {
        icon: 'shopping_cart',
        color: 'primary',
    })
    .event('Payment Confirmed', 'Payment received successfully', '10:32 AM', {
        icon: 'payment',
        color: 'success',
    })
    .event('Processing', 'Order is being prepared', '11:00 AM', {
        icon: 'inventory',
        color: 'info',
    })
    .event('Shipped', 'Package dispatched', '2:00 PM', {
        icon: 'local_shipping',
        color: 'warning',
    });

document.getElementById('container').innerHTML = timeline.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-timeline">
    <div class="so-timeline-item">
        <div class="so-timeline-marker so-bg-primary">
            <span class="material-icons">shopping_cart</span>
        </div>
        <div class="so-timeline-content">
            <div class="so-timeline-time">10:30 AM</div>
            <h6 class="so-timeline-title">Order Placed</h6>
            <p class="so-timeline-text">Your order has been placed</p>
        </div>
    </div>
    <!-- More items with different colors... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Activity Feed</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-timeline so-timeline-feed so-mb-4">
                    <div class="so-timeline-item">
                        <div class="so-timeline-avatar">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=667eea&color=fff" alt="John Doe">
                        </div>
                        <div class="so-timeline-connector"></div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-header">
                                <strong>John Doe</strong>
                                <span class="so-text-muted">created a new project</span>
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
                                <span class="so-text-muted">commented on the task</span>
                            </div>
                            <div class="so-timeline-time">4 hours ago</div>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-avatar">
                            <img src="https://ui-avatars.com/api/?name=Bob+Wilson&background=4facfe&color=fff" alt="Bob Wilson">
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-header">
                                <strong>Bob Wilson</strong>
                                <span class="so-text-muted">completed the milestone</span>
                            </div>
                            <div class="so-timeline-time">Yesterday</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('timeline-activity', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$timeline = UiEngine::timeline()
    ->feed()  // Activity feed style with avatars
    ->event(null, '<strong>John Doe</strong> created a new project', '2 hours ago', [
        'avatar' => '/avatars/john.jpg',
    ])
    ->event(null, '<strong>Jane Smith</strong> commented on the task', '4 hours ago', [
        'avatar' => '/avatars/jane.jpg',
    ])
    ->event(null, '<strong>Bob Wilson</strong> completed the milestone', 'Yesterday', [
        'avatar' => '/avatars/bob.jpg',
    ]);

echo \$timeline->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timeline = UiEngine.timeline()
    .feed()
    .event(null, '<strong>John Doe</strong> created a new project', '2 hours ago', {
        avatar: '/avatars/john.jpg',
    })
    .event(null, '<strong>Jane Smith</strong> commented on the task', '4 hours ago', {
        avatar: '/avatars/jane.jpg',
    })
    .event(null, '<strong>Bob Wilson</strong> completed the milestone', 'Yesterday', {
        avatar: '/avatars/bob.jpg',
    });

document.getElementById('container').innerHTML = timeline.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-timeline so-timeline-feed">
    <div class="so-timeline-item">
        <div class="so-timeline-avatar">
            <img src="/avatars/john.jpg" alt="John Doe">
        </div>
        <div class="so-timeline-connector"></div>
        <div class="so-timeline-content">
            <div class="so-timeline-header">
                <strong>John Doe</strong>
                <span class="so-text-muted">created a new project</span>
            </div>
            <div class="so-timeline-time">2 hours ago</div>
        </div>
    </div>
    <!-- More items... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Alternating Layout -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Alternating Layout</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Events alternate between left and right sides for a centered timeline look.</p>

                <!-- Live Demo -->
                <div class="so-timeline so-timeline-alternating so-mb-4">
                    <div class="so-timeline-item so-timeline-left">
                        <div class="so-timeline-marker so-bg-primary">
                            <span class="material-icons" style="font-size:14px;color:white;">rocket_launch</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">2020</div>
                            <h6 class="so-timeline-title">Company Founded</h6>
                            <p class="so-timeline-text">Started with a small team of 3 passionate developers.</p>
                        </div>
                    </div>
                    <div class="so-timeline-item so-timeline-right">
                        <div class="so-timeline-marker so-bg-success">
                            <span class="material-icons" style="font-size:14px;color:white;">trending_up</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">2021</div>
                            <h6 class="so-timeline-title">Series A Funding</h6>
                            <p class="so-timeline-text">Raised $5M in funding to scale operations.</p>
                        </div>
                    </div>
                    <div class="so-timeline-item so-timeline-left">
                        <div class="so-timeline-marker so-bg-info">
                            <span class="material-icons" style="font-size:14px;color:white;">public</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">2022</div>
                            <h6 class="so-timeline-title">Global Expansion</h6>
                            <p class="so-timeline-text">Opened offices in 5 countries across 3 continents.</p>
                        </div>
                    </div>
                    <div class="so-timeline-item so-timeline-right">
                        <div class="so-timeline-marker so-bg-warning">
                            <span class="material-icons" style="font-size:14px;color:white;">emoji_events</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">2023</div>
                            <h6 class="so-timeline-title">IPO</h6>
                            <p class="so-timeline-text">Successfully went public on the stock exchange.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('timeline-alternating', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$timeline = UiEngine::timeline()
    ->alternating()  // Events alternate left/right
    ->event('2020', 'Company Founded', 'Started with a small team of 3')
    ->event('2021', 'Series A', 'Raised \$5M in funding')
    ->event('2022', 'Global Expansion', 'Opened offices in 5 countries')
    ->event('2023', 'IPO', 'Successfully went public');

echo \$timeline->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timeline = UiEngine.timeline()
    .alternating()
    .event('2020', 'Company Founded', 'Started with a small team of 3')
    .event('2021', 'Series A', 'Raised $5M in funding')
    .event('2022', 'Global Expansion', 'Opened offices in 5 countries')
    .event('2023', 'IPO', 'Successfully went public');

document.getElementById('container').innerHTML = timeline.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-timeline so-timeline-alternating">
    <div class="so-timeline-item so-timeline-left">
        <div class="so-timeline-marker"></div>
        <div class="so-timeline-content">
            <div class="so-timeline-time">2020</div>
            <h6 class="so-timeline-title">Company Founded</h6>
            <p class="so-timeline-text">Started with a small team of 3</p>
        </div>
    </div>
    <div class="so-timeline-item so-timeline-right">
        <!-- Right side content -->
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Custom Content -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Custom Content</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Embed rich content like cards, alerts, or any custom HTML inside timeline events.</p>

                <!-- Live Demo -->
                <div class="so-timeline so-mb-4">
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-primary">
                            <span class="material-icons" style="font-size:14px;color:white;">event</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Tomorrow</div>
                            <h6 class="so-timeline-title">Meeting Scheduled</h6>
                            <div class="so-card so-card-sm so-mt-2">
                                <div class="so-card-body so-py-2 so-px-3">
                                    <p class="so-mb-1">Team sync meeting</p>
                                    <small class="so-text-muted">10:00 AM - 11:00 AM</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-success">
                            <span class="material-icons" style="font-size:14px;color:white;">check_circle</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Today</div>
                            <h6 class="so-timeline-title">Task Completed</h6>
                            <div class="so-alert so-alert-success so-alert-sm so-mt-2 so-py-2">
                                <span class="material-icons so-me-1" style="font-size:16px;">thumb_up</span>
                                Great job! All tests passed.
                            </div>
                        </div>
                    </div>
                    <div class="so-timeline-item">
                        <div class="so-timeline-marker so-bg-info">
                            <span class="material-icons" style="font-size:14px;color:white;">attach_file</span>
                        </div>
                        <div class="so-timeline-content">
                            <div class="so-timeline-time">Yesterday</div>
                            <h6 class="so-timeline-title">File Uploaded</h6>
                            <div class="so-d-flex so-align-items-center so-gap-2 so-mt-2 so-p-2 so-bg-light so-rounded">
                                <span class="material-icons so-text-muted">description</span>
                                <span>project-report.pdf</span>
                                <span class="so-badge so-badge-secondary so-ms-auto">2.4 MB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('timeline-custom', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$timeline = UiEngine::timeline()
    ->event('Meeting Scheduled', UiEngine::card()
        ->body('Team sync meeting')
        ->footer('10:00 AM - 11:00 AM')
        ->render()
    , 'Tomorrow', ['icon' => 'event'])
    ->event('Task Completed', UiEngine::alert('Great job!')
        ->variant('success')
        ->render()
    , 'Today', ['icon' => 'check_circle', 'color' => 'success']);

echo \$timeline->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timeline = UiEngine.timeline()
    .event('Meeting Scheduled', UiEngine.card()
        .body('Team sync meeting')
        .footer('10:00 AM - 11:00 AM')
        .toHtml()
    , 'Tomorrow', {icon: 'event'})
    .event('Task Completed', UiEngine.alert('Great job!')
        .variant('success')
        .toHtml()
    , 'Today', {icon: 'check_circle', color: 'success'});

document.getElementById('container').innerHTML = timeline.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-timeline">
    <div class="so-timeline-item">
        <div class="so-timeline-marker">
            <span class="material-icons">event</span>
        </div>
        <div class="so-timeline-content">
            <div class="so-timeline-time">Tomorrow</div>
            <h6 class="so-timeline-title">Meeting Scheduled</h6>
            <div class="so-card">
                <div class="so-card-body">Team sync meeting</div>
                <div class="so-card-footer">10:00 AM - 11:00 AM</div>
            </div>
        </div>
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
                                <td><code>event()</code></td>
                                <td><code>string $title, string $content, string $time, array $options</code></td>
                                <td>Add a timeline event</td>
                            </tr>
                            <tr>
                                <td><code>events()</code></td>
                                <td><code>array $events</code></td>
                                <td>Add multiple events</td>
                            </tr>
                            <tr>
                                <td><code>compact()</code></td>
                                <td>-</td>
                                <td>Use compact style (minimal spacing)</td>
                            </tr>
                            <tr>
                                <td><code>feed()</code></td>
                                <td>-</td>
                                <td>Activity feed style with avatar support</td>
                            </tr>
                            <tr>
                                <td><code>alternating()</code></td>
                                <td>-</td>
                                <td>Alternate left/right layout</td>
                            </tr>
                            <tr>
                                <td><code>reverse()</code></td>
                                <td>-</td>
                                <td>Reverse event order</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
