<?php
/**
 * SixOrbit UI Demo - Video Tutorials (LMS)
 */
require_once 'includes/config.php';
$pageTitle = 'Video Tutorials - ' . DEMO_COMPANY_NAME;
$currentPage = 'video-tutorial';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="so-main-content">
        <!-- Breadcrumb Bar -->
        <div class="so-breadcrumb-bar">
            <a href="index.php" class="so-breadcrumb-bar-home" title="Dashboard">
                <span class="material-icons">home</span>
            </a>
            <span class="so-breadcrumb-bar-separator">
                <span class="material-icons">chevron_right</span>
            </span>
            <span class="so-breadcrumb-bar-item so-active">Video Tutorials</span>
        </div>

        <div class="demo-content" style="padding: 16px;">
            <!-- Page Header -->
            <div class="so-lms-header">
                <div class="so-lms-header-content">
                    <h1 class="so-lms-header-title">Video Tutorials</h1>
                    <p class="so-lms-header-subtitle">Learn how to use SixOrbit ERP with step-by-step video guides</p>
                </div>
                <div class="so-lms-header-stats">
                    <div class="so-lms-stat">
                        <span class="so-lms-stat-value">24</span>
                        <span class="so-lms-stat-label">Total Videos</span>
                    </div>
                    <div class="so-lms-stat">
                        <span class="so-lms-stat-value">8</span>
                        <span class="so-lms-stat-label">Completed</span>
                    </div>
                    <div class="so-lms-stat">
                        <span class="so-lms-stat-value">33%</span>
                        <span class="so-lms-stat-label">Progress</span>
                    </div>
                </div>
            </div>

            <!-- Category Tabs -->
            <div class="so-lms-categories">
                <button class="so-lms-category-btn so-active" data-category="all">
                    <span class="material-icons">apps</span>
                    All
                </button>
                <button class="so-lms-category-btn" data-category="getting-started">
                    <span class="material-icons">play_circle</span>
                    Getting Started
                </button>
                <button class="so-lms-category-btn" data-category="sales">
                    <span class="material-icons">shopping_cart</span>
                    Sales
                </button>
                <button class="so-lms-category-btn" data-category="inventory">
                    <span class="material-icons">inventory_2</span>
                    Inventory
                </button>
                <button class="so-lms-category-btn" data-category="finance">
                    <span class="material-icons">account_balance</span>
                    Finance
                </button>
            </div>

            <!-- Video Grid -->
            <div class="so-lms-grid">
                <!-- Getting Started Videos -->
                <div class="so-lms-card" data-category="getting-started">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Introduction to SixOrbit">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">5:30</span>
                        <span class="so-lms-card-badge completed">
                            <span class="material-icons">check</span>
                        </span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Getting Started</span>
                        <h3 class="so-lms-card-title">Introduction to SixOrbit ERP</h3>
                        <p class="so-lms-card-desc">Overview of the platform and key features</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="getting-started">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Dashboard Navigation">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">8:15</span>
                        <span class="so-lms-card-badge completed">
                            <span class="material-icons">check</span>
                        </span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Getting Started</span>
                        <h3 class="so-lms-card-title">Navigating the Dashboard</h3>
                        <p class="so-lms-card-desc">Learn to use the dashboard effectively</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="getting-started">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="User Settings">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">6:45</span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Getting Started</span>
                        <h3 class="so-lms-card-title">Setting Up Your Profile</h3>
                        <p class="so-lms-card-desc">Configure user preferences and settings</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 45%"></div>
                        </div>
                    </div>
                </div>

                <!-- Sales Videos -->
                <div class="so-lms-card" data-category="sales">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Creating Sales Invoice">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">12:20</span>
                        <span class="so-lms-card-badge completed">
                            <span class="material-icons">check</span>
                        </span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Sales</span>
                        <h3 class="so-lms-card-title">Creating Sales Invoices</h3>
                        <p class="so-lms-card-desc">Step-by-step guide to create invoices</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="sales">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Managing Customers">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">9:30</span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Sales</span>
                        <h3 class="so-lms-card-title">Managing Customers</h3>
                        <p class="so-lms-card-desc">Add, edit, and manage customer records</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="sales">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Sales Reports">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">15:00</span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Sales</span>
                        <h3 class="so-lms-card-title">Sales Reports & Analytics</h3>
                        <p class="so-lms-card-desc">Understanding sales performance reports</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Videos -->
                <div class="so-lms-card" data-category="inventory">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Stock Management">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">11:45</span>
                        <span class="so-lms-card-badge completed">
                            <span class="material-icons">check</span>
                        </span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Inventory</span>
                        <h3 class="so-lms-card-title">Stock Management Basics</h3>
                        <p class="so-lms-card-desc">Learn to manage inventory effectively</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="inventory">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Purchase Orders">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">10:15</span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Inventory</span>
                        <h3 class="so-lms-card-title">Creating Purchase Orders</h3>
                        <p class="so-lms-card-desc">Manage supplier orders efficiently</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 25%"></div>
                        </div>
                    </div>
                </div>

                <!-- Finance Videos -->
                <div class="so-lms-card" data-category="finance">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Financial Reports">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">18:30</span>
                        <span class="so-lms-card-badge completed">
                            <span class="material-icons">check</span>
                        </span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Finance</span>
                        <h3 class="so-lms-card-title">Understanding Financial Reports</h3>
                        <p class="so-lms-card-desc">P&L, Balance Sheet, and Cash Flow</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="finance">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Bank Reconciliation">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">14:00</span>
                        <span class="so-lms-card-badge completed">
                            <span class="material-icons">check</span>
                        </span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Finance</span>
                        <h3 class="so-lms-card-title">Bank Reconciliation</h3>
                        <p class="so-lms-card-desc">Match bank statements with records</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="finance">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="GST Returns">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">20:00</span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Finance</span>
                        <h3 class="so-lms-card-title">GST Returns Filing</h3>
                        <p class="so-lms-card-desc">Complete guide to GST compliance</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="so-lms-card" data-category="finance">
                    <div class="so-lms-card-thumbnail">
                        <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="TDS Management">
                        <div class="so-lms-card-play">
                            <span class="material-icons">play_arrow</span>
                        </div>
                        <span class="so-lms-card-duration">16:45</span>
                    </div>
                    <div class="so-lms-card-content">
                        <span class="so-lms-card-category">Finance</span>
                        <h3 class="so-lms-card-title">TDS Management</h3>
                        <p class="so-lms-card-desc">Handling TDS deductions and returns</p>
                        <div class="so-lms-card-progress">
                            <div class="so-lms-card-progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>

<script>
    // Category filter functionality
    document.querySelectorAll('.so-lms-category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.so-lms-category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Filter cards
            const category = this.dataset.category;
            document.querySelectorAll('.so-lms-card').forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Video card click handler
    document.querySelectorAll('.so-lms-card').forEach(card => {
        card.addEventListener('click', function() {
            // In a real app, this would open a video player
            alert('Video player would open here in a real implementation');
        });
    });
</script>
