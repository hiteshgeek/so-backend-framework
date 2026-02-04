<?php
/**
 * SixOrbit UI Demo - Scrollspy
 */
$pageTitle = 'Scrollspy';
$pageDescription = 'Scrollspy component for scroll-based navigation';

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
            <h1 class="so-page-title">Scrollspy</h1>
            <p class="so-page-subtitle">Scrollspy component for scroll-based navigation</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<div class="so-grid so-grid-cols-1 so-gap-6">

        <!-- Basic Scrollspy -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Scrollspy</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Automatically update navigation based on scroll position. Scroll the content below to see the navigation update.</p>

                <div class="so-grid so-grid-cols-12 so-gap-4 so-mb-6">
                    <!-- Navigation -->
                    <div class="so-col-span-3">
                        <nav class="so-scrollspy-nav so-scrollspy-bordered so-scrollspy-sticky" id="scrollspy-nav-1" data-so-scrollspy data-so-target="#scrollspy-content-1">
                            <a class="so-scrollspy-link so-active" href="#section1">Section 1</a>
                            <a class="so-scrollspy-link" href="#section2">Section 2</a>
                            <a class="so-scrollspy-link" href="#section3">Section 3</a>
                            <a class="so-scrollspy-link" href="#section4">Section 4</a>
                        </nav>
                    </div>

                    <!-- Scrollable Content -->
                    <div class="so-col-span-9">
                        <div id="scrollspy-content-1" class="so-border so-rounded-lg so-p-4" style="height: 300px; overflow-y: auto;" data-so-spy="scroll" data-so-target="#scrollspy-nav-1">
                            <section id="section1" data-so-scrollspy-section class="so-mb-6">
                                <h4>Section 1</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
                            </section>

                            <section id="section2" data-so-scrollspy-section class="so-mb-6">
                                <h4>Section 2</h4>
                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.</p>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                            </section>

                            <section id="section3" data-so-scrollspy-section class="so-mb-6">
                                <h4>Section 3</h4>
                                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.</p>
                                <p>Et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.</p>
                            </section>

                            <section id="section4" data-so-scrollspy-section class="so-mb-6">
                                <h4>Section 4</h4>
                                <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti.</p>
                            </section>
                        </div>
                    </div>
                </div>

<?= so_code_block('<!-- Navigation -->
<nav class="so-scrollspy-nav so-scrollspy-bordered" id="myScrollspy" data-so-scrollspy>
    <a class="so-scrollspy-link" href="#section1">Section 1</a>
    <a class="so-scrollspy-link" href="#section2">Section 2</a>
</nav>

<!-- Scrollable Content -->
<div data-so-spy="scroll" data-so-target="#myScrollspy">
    <section id="section1" data-so-scrollspy-section>...</section>
    <section id="section2" data-so-scrollspy-section>...</section>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Scrollspy Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Navigation Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different navigation styles for scrollspy.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-6 so-mb-6">
                    <!-- Default -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Default</label>
                        <nav class="so-scrollspy-nav">
                            <a class="so-scrollspy-link so-active" href="#">Overview</a>
                            <a class="so-scrollspy-link" href="#">Features</a>
                            <a class="so-scrollspy-link" href="#">Pricing</a>
                            <a class="so-scrollspy-link" href="#">FAQ</a>
                        </nav>
                    </div>

                    <!-- Bordered -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Bordered (.so-scrollspy-bordered)</label>
                        <nav class="so-scrollspy-nav so-scrollspy-bordered">
                            <a class="so-scrollspy-link so-active" href="#">Overview</a>
                            <a class="so-scrollspy-link" href="#">Features</a>
                            <a class="so-scrollspy-link" href="#">Pricing</a>
                            <a class="so-scrollspy-link" href="#">FAQ</a>
                        </nav>
                    </div>

                    <!-- Pills -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Pills (.so-scrollspy-pills)</label>
                        <nav class="so-scrollspy-nav so-scrollspy-pills">
                            <a class="so-scrollspy-link so-active" href="#">Overview</a>
                            <a class="so-scrollspy-link" href="#">Features</a>
                            <a class="so-scrollspy-link" href="#">Pricing</a>
                            <a class="so-scrollspy-link" href="#">FAQ</a>
                        </nav>
                    </div>

                    <!-- Numbered -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Numbered (.so-scrollspy-numbered)</label>
                        <nav class="so-scrollspy-nav so-scrollspy-numbered">
                            <a class="so-scrollspy-link so-active" href="#">Overview</a>
                            <a class="so-scrollspy-link" href="#">Features</a>
                            <a class="so-scrollspy-link" href="#">Pricing</a>
                            <a class="so-scrollspy-link" href="#">FAQ</a>
                        </nav>
                    </div>
                </div>

<?= so_code_block('<nav class="so-scrollspy-nav">...</nav>
<nav class="so-scrollspy-nav so-scrollspy-bordered">...</nav>
<nav class="so-scrollspy-nav so-scrollspy-pills">...</nav>
<nav class="so-scrollspy-nav so-scrollspy-numbered">...</nav>', 'html') ?>
            </div>
        </div>

        <!-- Horizontal Scrollspy -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal / Underline Scrollspy</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Horizontal navigation styles.</p>

                <div class="so-mb-6">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Underline (.so-scrollspy-underline)</label>
                    <nav class="so-scrollspy-nav so-scrollspy-underline">
                        <a class="so-scrollspy-link so-active" href="#">Overview</a>
                        <a class="so-scrollspy-link" href="#">Features</a>
                        <a class="so-scrollspy-link" href="#">Pricing</a>
                        <a class="so-scrollspy-link" href="#">FAQ</a>
                    </nav>
                </div>

                <div class="so-mb-6">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Horizontal (.so-scrollspy-horizontal)</label>
                    <nav class="so-scrollspy-nav so-scrollspy-horizontal">
                        <a class="so-scrollspy-link so-active" href="#">Overview</a>
                        <a class="so-scrollspy-link" href="#">Features</a>
                        <a class="so-scrollspy-link" href="#">Pricing</a>
                        <a class="so-scrollspy-link" href="#">FAQ</a>
                        <a class="so-scrollspy-link" href="#">Support</a>
                        <a class="so-scrollspy-link" href="#">Contact</a>
                    </nav>
                </div>

<?= so_code_block('<nav class="so-scrollspy-nav so-scrollspy-underline">...</nav>
<nav class="so-scrollspy-nav so-scrollspy-horizontal">...</nav>', 'html') ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add Material Icons to navigation items.</p>

                <nav class="so-scrollspy-nav so-scrollspy-bordered so-mb-6" style="max-width: 250px;">
                    <a class="so-scrollspy-link so-active" href="#">
                        <span class="material-icons">home</span>
                        Overview
                    </a>
                    <a class="so-scrollspy-link" href="#">
                        <span class="material-icons">star</span>
                        Features
                    </a>
                    <a class="so-scrollspy-link" href="#">
                        <span class="material-icons">attach_money</span>
                        Pricing
                    </a>
                    <a class="so-scrollspy-link" href="#">
                        <span class="material-icons">help</span>
                        FAQ
                    </a>
                </nav>

<?= so_code_block('<a class="so-scrollspy-link" href="#">
    <span class="material-icons">home</span>
    Overview
</a>', 'html') ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Contextual color variants for scrollspy navigation.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-3 so-gap-4 so-mb-6">
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Primary</label>
                        <nav class="so-scrollspy-nav so-scrollspy-bordered so-scrollspy-primary">
                            <a class="so-scrollspy-link so-active" href="#">Active</a>
                            <a class="so-scrollspy-link" href="#">Link</a>
                            <a class="so-scrollspy-link" href="#">Link</a>
                        </nav>
                    </div>
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Success</label>
                        <nav class="so-scrollspy-nav so-scrollspy-bordered so-scrollspy-success">
                            <a class="so-scrollspy-link so-active" href="#">Active</a>
                            <a class="so-scrollspy-link" href="#">Link</a>
                            <a class="so-scrollspy-link" href="#">Link</a>
                        </nav>
                    </div>
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Danger</label>
                        <nav class="so-scrollspy-nav so-scrollspy-bordered so-scrollspy-danger">
                            <a class="so-scrollspy-link so-active" href="#">Active</a>
                            <a class="so-scrollspy-link" href="#">Link</a>
                            <a class="so-scrollspy-link" href="#">Link</a>
                        </nav>
                    </div>
                </div>

<?= so_code_block('<nav class="so-scrollspy-nav so-scrollspy-bordered so-scrollspy-primary">...</nav>
<nav class="so-scrollspy-nav so-scrollspy-pills so-scrollspy-success">...</nav>', 'html') ?>
            </div>
        </div>

        <!-- JavaScript API & Events -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API & Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control scrollspy programmatically and listen to events.</p>

                <div class="so-alert so-alert-info so-mb-4" id="scrollspy-event-log">
                    <span class="material-icons">info</span>
                    <span>Scroll the content in the Basic Scrollspy section above to see events fire here.</span>
                </div>

<?= so_code_block('// Initialize scrollspy
SOScrollspy.init();

// Get instance
const scrollspy = SOScrollspy.getInstance(element);

// Refresh when content changes
scrollspy.refresh();

// Events
element.addEventListener(\'so:scrollspy:activate\', (e) => {
    console.log(\'Activated section:\', e.detail.relatedTarget);
});

element.addEventListener(\'so:scrollspy:change\', (e) => {
    console.log(\'Active link changed:\', e.detail.target);
});', 'javascript') ?>

                <h5 class="so-mt-6 so-mb-3">Available Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                                <th>Detail Properties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so:scrollspy:activate</code></td>
                                <td>Fires when a new section becomes active</td>
                                <td><code>{ relatedTarget }</code></td>
                            </tr>
                            <tr>
                                <td><code>so:scrollspy:change</code></td>
                                <td>Fires when the active link changes</td>
                                <td><code>{ target, relatedTarget }</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-scrollspy-nav</code></td>
                                <td>Base navigation container</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-link</code></td>
                                <td>Navigation link</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-bordered</code></td>
                                <td>Left border indicator style</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-pills</code></td>
                                <td>Pill style links</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-underline</code></td>
                                <td>Horizontal underline style</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-horizontal</code></td>
                                <td>Horizontal layout</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-numbered</code></td>
                                <td>Auto-numbered items</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-sticky</code></td>
                                <td>Sticky positioning</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-{color}</code></td>
                                <td>Color variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-scrollspy-sm / .so-scrollspy-lg</code></td>
                                <td>Size variants</td>
                            </tr>
                            <tr>
                                <td><code>[data-so-scrollspy-section]</code></td>
                                <td>Target section marker</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<script>
// SOScrollspy Class
class SOScrollspy {
    static instances = new Map();

    constructor(element, options = {}) {
        this.nav = element;
        this.links = element.querySelectorAll('.so-scrollspy-link');
        this.options = {
            offset: options.offset || 10,
            ...options
        };

        this._init();
        SOScrollspy.instances.set(element, this);
    }

    static getInstance(element) {
        return SOScrollspy.instances.get(element);
    }

    static init() {
        document.querySelectorAll('[data-so-scrollspy]').forEach(nav => {
            if (!SOScrollspy.instances.has(nav)) {
                new SOScrollspy(nav);
            }
        });

        // Also init scroll containers
        document.querySelectorAll('[data-so-spy="scroll"]').forEach(container => {
            const targetNav = container.dataset.soTarget;
            if (targetNav) {
                const nav = document.querySelector(targetNav);
                if (nav) {
                    const spy = SOScrollspy.getInstance(nav) || new SOScrollspy(nav);
                    spy.setContainer(container);
                }
            }
        });
    }

    _init() {
        this.links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    setContainer(container) {
        this.container = container;
        this.sections = [];

        this.links.forEach(link => {
            const targetId = link.getAttribute('href');
            const target = container.querySelector(targetId);
            if (target) {
                this.sections.push({ link, target });
            }
        });

        // Only add scroll listener once
        if (!this._scrollBound) {
            this._scrollHandler = () => this._onScroll();
            container.addEventListener('scroll', this._scrollHandler);
            this._scrollBound = true;
        }
        this._onScroll(); // Initial check
    }

    _onScroll() {
        if (!this.container || !this.sections.length) return;

        const scrollTop = this.container.scrollTop;
        const containerHeight = this.container.clientHeight;
        let activeSection = null;

        // Find the section that is currently most visible in the viewport
        this.sections.forEach(({ link, target }) => {
            const targetTop = target.offsetTop - this.options.offset;

            // A section is active if its top is at or above the scroll position
            if (scrollTop >= targetTop - 20) {
                activeSection = { link, target };
            }
        });

        // Default to first section if at the very top
        if (!activeSection && this.sections.length) {
            activeSection = this.sections[0];
        }

        if (activeSection) {
            const previousActive = this.nav.querySelector('.so-scrollspy-link.active');

            if (previousActive !== activeSection.link) {
                this.links.forEach(l => l.classList.remove('active'));
                activeSection.link.classList.add('active');

                // Dispatch events
                this.nav.dispatchEvent(new CustomEvent('so:scrollspy:activate', {
                    bubbles: true,
                    detail: { relatedTarget: activeSection.target }
                }));

                this.nav.dispatchEvent(new CustomEvent('so:scrollspy:change', {
                    bubbles: true,
                    detail: {
                        target: activeSection.link,
                        relatedTarget: previousActive
                    }
                }));

                // Update event log if exists
                const eventLog = document.getElementById('scrollspy-event-log');
                if (eventLog) {
                    eventLog.innerHTML = '<span class="material-icons">check_circle</span><span><strong>so:scrollspy:activate</strong> - Active section: ' + activeSection.target.id + '</span>';
                }
            }
        }
    }

    refresh() {
        if (this.container) {
            this._onScroll();
        }
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    SOScrollspy.init();

    // Re-initialize scrollspy when its tab becomes visible
    const scrollspyPane = document.getElementById('pane-scrollspy');
    if (scrollspyPane) {
        // Use MutationObserver to detect when tab becomes visible
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (scrollspyPane.classList.contains('active')) {
                        // Small delay to ensure layout is calculated
                        setTimeout(() => {
                            SOScrollspy.init();
                            // Refresh all instances
                            SOScrollspy.instances.forEach((spy) => spy.refresh());
                        }, 100);
                    }
                }
            });
        });

        observer.observe(scrollspyPane, { attributes: true });
    }

    // Also listen for tab shown event
    document.addEventListener('so:tab:shown', function(e) {
        if (e.target.dataset.soTarget === '#pane-scrollspy') {
            setTimeout(() => {
                SOScrollspy.init();
                SOScrollspy.instances.forEach((spy) => spy.refresh());
            }, 100);
        }
    });
});
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
