<?php
/**
 * SixOrbit UI Demo - Go to Top Button
 */
$pageTitle = 'Scroll Navigation';
$pageDescription = 'Scroll-to-top and scroll-to-bottom buttons with progress indicator';

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
            <h1 class="so-page-title">Scroll Navigation</h1>
            <p class="so-page-subtitle">Scroll-to-top and scroll-to-bottom buttons with progress indicator</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- Overview -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Overview</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Scroll navigation buttons that help users quickly navigate to the top or bottom of the page. Uses existing button classes for consistent styling.</p>

                <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                    <span class="material-icons">info</span>
                    <div>Scroll down this page to see the Go to Top button appear in the bottom-right corner.</div>
                </div>

                <h5 class="so-mb-3">Key Features</h5>
                <ul class="so-mb-0">
                    <li>Supports both <strong>Go to Top</strong> and <strong>Go to Bottom</strong> directions</li>
                    <li>Scroll progress indicator ring that fills based on page position</li>
                    <li>Paired mode: show both buttons that toggle based on scroll position</li>
                    <li>Appears after scrolling past a configurable threshold (default: 300px)</li>
                    <li>Smooth scroll animation</li>
                    <li>Uses existing <code>so-btn</code> classes - no custom button styles</li>
                    <li>Configurable position, size, icon, and button variant</li>
                    <li>Mobile responsive positioning</li>
                </ul>
            </div>
        </div>

        <!-- Basic Usage -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Usage</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">The simplest way to add a Go to Top button is using the JavaScript API.</p>

                <?= so_code_block('// Create a Go to Top button (auto-injected into body)
SOGoToTop.create();

// Or with options
SOGoToTop.create({
    showAfter: 400,      // Show after 400px scroll
    position: "bottom-right",
    variant: "primary",
    size: "md"
});', 'javascript') ?>

                <p class="so-text-secondary so-mt-4 so-mb-4">Or use HTML with data attributes:</p>

                <?= so_code_block('<!-- Manual HTML placement -->
<button class="so-btn so-btn-icon so-btn-circle so-btn-primary so-go-to-top so-go-to-top-bottom-right"
        data-so-go-to-top
        aria-label="Scroll to top">
    <span class="material-icons">arrow_upward</span>
</button>', 'html') ?>
            </div>
        </div>

        <!-- Position Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Position Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">The button can be positioned in different corners of the screen.</p>

                <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoPosition('bottom-right')">
                        Bottom Right
                    </button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoPosition('bottom-left')">
                        Bottom Left
                    </button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoPosition('bottom-center')">
                        Bottom Center
                    </button>
                </div>

                <?= so_code_block('// Position options
SOGoToTop.create({ position: "bottom-right" });  // Default
SOGoToTop.create({ position: "bottom-left" });
SOGoToTop.create({ position: "bottom-center" });', 'javascript') ?>
            </div>
        </div>

        <!-- Button Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Use any button variant from the framework.</p>

                <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="demoVariant('primary')">
                        Primary
                    </button>
                    <button type="button" class="so-btn so-btn-secondary so-btn-sm" onclick="demoVariant('secondary')">
                        Secondary
                    </button>
                    <button type="button" class="so-btn so-btn-success so-btn-sm" onclick="demoVariant('success')">
                        Success
                    </button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoVariant('outline')">
                        Outline
                    </button>
                    <button type="button" class="so-btn so-btn-ghost so-btn-sm" onclick="demoVariant('ghost')">
                        Ghost
                    </button>
                    <button type="button" class="so-btn so-btn-dark so-btn-sm" onclick="demoVariant('dark')">
                        Dark
                    </button>
                </div>

                <?= so_code_block('// Button variant options
SOGoToTop.create({ variant: "primary" });   // Default
SOGoToTop.create({ variant: "secondary" });
SOGoToTop.create({ variant: "success" });
SOGoToTop.create({ variant: "outline" });
SOGoToTop.create({ variant: "ghost" });
SOGoToTop.create({ variant: "dark" });', 'javascript') ?>
            </div>
        </div>

        <!-- Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Different button sizes for various use cases.</p>

                <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-xs" onclick="demoSize('xs')">
                        <span class="material-icons">arrow_upward</span>
                    </button>
                    <span class="so-text-muted">XS</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-sm" onclick="demoSize('sm')">
                        <span class="material-icons">arrow_upward</span>
                    </button>
                    <span class="so-text-muted">SM</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary" onclick="demoSize('md')">
                        <span class="material-icons">arrow_upward</span>
                    </button>
                    <span class="so-text-muted">MD (Default)</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-lg" onclick="demoSize('lg')">
                        <span class="material-icons">arrow_upward</span>
                    </button>
                    <span class="so-text-muted">LG</span>
                </div>

                <?= so_code_block('SOGoToTop.create({ size: "xs" });  // Extra small
SOGoToTop.create({ size: "sm" });  // Small
SOGoToTop.create({ size: "md" });  // Medium (default)
SOGoToTop.create({ size: "lg" });  // Large', 'javascript') ?>
            </div>
        </div>

        <!-- Custom Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Icons</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Use any Material Icon for the button.</p>

                <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary" onclick="demoIcon('arrow_upward')">
                        <span class="material-icons">arrow_upward</span>
                    </button>
                    <span class="so-text-muted">arrow_upward</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary" onclick="demoIcon('keyboard_arrow_up')">
                        <span class="material-icons">keyboard_arrow_up</span>
                    </button>
                    <span class="so-text-muted">keyboard_arrow_up</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary" onclick="demoIcon('expand_less')">
                        <span class="material-icons">expand_less</span>
                    </button>
                    <span class="so-text-muted">expand_less</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary" onclick="demoIcon('vertical_align_top')">
                        <span class="material-icons">vertical_align_top</span>
                    </button>
                    <span class="so-text-muted">vertical_align_top</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-circle so-btn-primary" onclick="demoIcon('north')">
                        <span class="material-icons">north</span>
                    </button>
                    <span class="so-text-muted">north</span>
                </div>

                <?= so_code_block('SOGoToTop.create({ icon: "arrow_upward" });       // Default
SOGoToTop.create({ icon: "keyboard_arrow_up" });
SOGoToTop.create({ icon: "expand_less" });
SOGoToTop.create({ icon: "vertical_align_top" });
SOGoToTop.create({ icon: "north" });', 'javascript') ?>
            </div>
        </div>

        <!-- Direction (Top/Bottom) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Direction (Top / Bottom)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">The component supports both scroll-to-top and scroll-to-bottom directions. Go to Bottom appears when you're near the top and disappears as you scroll down.</p>

                <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="demoDirection('top')">
                        <span class="material-icons so-me-1">arrow_upward</span> Go to Top
                    </button>
                    <button type="button" class="so-btn so-btn-secondary so-btn-sm" onclick="demoDirection('bottom')">
                        <span class="material-icons so-me-1">arrow_downward</span> Go to Bottom
                    </button>
                </div>

                <?= so_code_block('// Go to Top (default)
SOGoToTop.create({ direction: "top" });

// Go to Bottom - appears when near top, scrolls to page end
SOGoToTop.create({ direction: "bottom" });', 'javascript') ?>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Scroll Progress Indicator</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Enable a progress ring around the button that fills based on scroll position. The ring shows how far down the page you've scrolled.</p>

                <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoProgress(false)">
                        Without Progress
                    </button>
                    <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="demoProgress(true)">
                        With Progress Ring
                    </button>
                </div>

                <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                    <span class="material-icons">info</span>
                    <div>Scroll the page to see the progress ring fill around the button.</div>
                </div>

                <?= so_code_block('// Enable scroll progress indicator
SOGoToTop.create({
    showProgress: true,
    variant: "primary"
});

// Get current scroll progress (0-100)
const progress = gtt.getProgress();
console.log(`Scrolled ${progress}% of the page`);', 'javascript') ?>
            </div>
        </div>

        <!-- Paired Buttons (Top + Bottom) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Paired Buttons (Top + Bottom)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Create both go-to-top and go-to-bottom buttons that show/hide based on your scroll position. The buttons are stacked vertically.</p>

                <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoSingle()">
                        Single Button (Top only)
                    </button>
                    <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="demoPaired()">
                        Paired Buttons (Top + Bottom)
                    </button>
                </div>

                <?= so_code_block('// Create both buttons at once
const { top, bottom } = SOGoToTop.createPair({
    position: "bottom-right",
    variant: "primary",
    size: "md",
    showProgress: true,  // Progress shown on top button only
    topIcon: "arrow_upward",
    bottomIcon: "arrow_downward"
});

// Control individually
top.scrollToTop();
bottom.scrollToBottom();', 'javascript') ?>
            </div>
        </div>

        <!-- JavaScript API -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Full programmatic control over the Go to Top button.</p>

                <div class="so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="demoScrollToTop()">
                        Trigger Scroll to Top
                    </button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoShowHide()">
                        Toggle Visibility
                    </button>
                </div>

                <?= so_code_block('// Create with options
const gtt = SOGoToTop.create({
    showAfter: 300,
    position: "bottom-right",
    variant: "primary",
    size: "md",
    icon: "arrow_upward",
    smooth: true,
    onScrollToTop: () => console.log("Scrolled to top!")
});

// Methods
gtt.scrollToTop();     // Scroll to top
gtt.show();            // Show button
gtt.hide();            // Hide button
gtt.isVisible();       // Check visibility
gtt.destroy();         // Remove component

// Events
document.addEventListener("so:go-to-top:show", () => {
    console.log("Button is now visible");
});

document.addEventListener("so:go-to-top:hide", () => {
    console.log("Button is now hidden");
});

document.addEventListener("so:go-to-top:scroll", () => {
    console.log("Scrolling to top");
});', 'javascript') ?>
            </div>
        </div>

        <!-- Configuration Options -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Configuration Options</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Option</th>
                                <th>Default</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>direction</code></td>
                                <td><code>"top"</code></td>
                                <td>Scroll direction: "top" or "bottom"</td>
                            </tr>
                            <tr>
                                <td><code>showAfter</code></td>
                                <td><code>300</code></td>
                                <td>Pixels scrolled before showing (top) or pixels from bottom (bottom)</td>
                            </tr>
                            <tr>
                                <td><code>position</code></td>
                                <td><code>"bottom-right"</code></td>
                                <td>Button position: "bottom-right", "bottom-left", "bottom-center"</td>
                            </tr>
                            <tr>
                                <td><code>icon</code></td>
                                <td><code>auto</code></td>
                                <td>Material icon name (auto: arrow_upward for top, arrow_downward for bottom)</td>
                            </tr>
                            <tr>
                                <td><code>size</code></td>
                                <td><code>"md"</code></td>
                                <td>Button size: "xs", "sm", "md", "lg"</td>
                            </tr>
                            <tr>
                                <td><code>variant</code></td>
                                <td><code>"primary"</code></td>
                                <td>Button variant: "primary", "secondary", "success", "outline", "ghost", etc.</td>
                            </tr>
                            <tr>
                                <td><code>smooth</code></td>
                                <td><code>true</code></td>
                                <td>Use smooth scroll animation</td>
                            </tr>
                            <tr>
                                <td><code>showProgress</code></td>
                                <td><code>false</code></td>
                                <td>Show scroll progress indicator ring</td>
                            </tr>
                            <tr>
                                <td><code>container</code></td>
                                <td><code>document.body</code></td>
                                <td>Container to append the button to</td>
                            </tr>
                            <tr>
                                <td><code>onScrollToTop</code></td>
                                <td><code>null</code></td>
                                <td>Callback function when scrolled to top</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Spacer for scrolling demo -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Scroll Demo Area</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary">This extra content ensures you can scroll down to see the Go to Top button in action.</p>
                <div class="so-p-5 so-bg-light so-rounded-md so-text-center so-text-secondary" style="min-height: 600px;">
                    <span class="material-icons so-text-muted" style="font-size: 48px;">expand_more</span>
                    <p class="so-mt-2">Scroll down to see the Go to Top button appear</p>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
// Wait for DOM and scripts to load
document.addEventListener('DOMContentLoaded', function() {
    // Create the demo Go to Top button
    window.currentGtt = SOGoToTop.create({
        position: 'bottom-right',
        variant: 'primary',
        size: 'md'
    });
});

// Demo functions
function demoPosition(position) {
    if (window.currentGtt) window.currentGtt.destroy();
    // Remove old button from DOM
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        position: position,
        variant: 'primary',
        size: 'md'
    });
    SOToast?.info(`Position: ${position}`);
}

function demoVariant(variant) {
    if (window.currentGtt) window.currentGtt.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        position: 'bottom-right',
        variant: variant,
        size: 'md'
    });
    SOToast?.info(`Variant: ${variant}`);
}

function demoScrollToTop() {
    if (window.currentGtt) {
        window.currentGtt.scrollToTop();
    }
}

function demoShowHide() {
    if (window.currentGtt) {
        if (window.currentGtt.isVisible()) {
            window.currentGtt.hide();
            SOToast?.info('Button hidden');
        } else {
            window.currentGtt.show();
            SOToast?.info('Button shown');
        }
    }
}

function demoSize(size) {
    if (window.currentGtt) window.currentGtt.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        position: 'bottom-right',
        variant: 'primary',
        size: size
    });
    SOToast?.info(`Size: ${size}`);
}

function demoIcon(icon) {
    if (window.currentGtt) window.currentGtt.destroy();
    if (window.currentGttBottom) window.currentGttBottom.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        position: 'bottom-right',
        variant: 'primary',
        size: 'md',
        icon: icon
    });
    window.currentGttBottom = null;
    SOToast?.info(`Icon: ${icon}`);
}

function demoDirection(direction) {
    if (window.currentGtt) window.currentGtt.destroy();
    if (window.currentGttBottom) window.currentGttBottom.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        direction: direction,
        position: 'bottom-right',
        variant: direction === 'bottom' ? 'secondary' : 'primary',
        size: 'md'
    });
    window.currentGttBottom = null;
    SOToast?.info(`Direction: ${direction}`);
}

function demoProgress(showProgress) {
    if (window.currentGtt) window.currentGtt.destroy();
    if (window.currentGttBottom) window.currentGttBottom.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        position: 'bottom-right',
        variant: 'primary',
        size: 'md',
        showProgress: showProgress
    });
    window.currentGttBottom = null;
    SOToast?.info(showProgress ? 'Progress indicator enabled' : 'Progress indicator disabled');
}

function demoSingle() {
    if (window.currentGtt) window.currentGtt.destroy();
    if (window.currentGttBottom) window.currentGttBottom.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    window.currentGtt = SOGoToTop.create({
        direction: 'top',
        position: 'bottom-right',
        variant: 'primary',
        size: 'md'
    });
    window.currentGttBottom = null;
    SOToast?.info('Single button mode (top only)');
}

function demoPaired() {
    if (window.currentGtt) window.currentGtt.destroy();
    if (window.currentGttBottom) window.currentGttBottom.destroy();
    document.querySelectorAll('.so-go-to-top').forEach(el => el.remove());

    const pair = SOGoToTop.createPair({
        position: 'bottom-right',
        variant: 'primary',
        size: 'md',
        showProgress: true
    });

    window.currentGtt = pair.top;
    window.currentGttBottom = pair.bottom;
    SOToast?.info('Paired buttons mode (top + bottom)');
}
</script>

<?php
require_once '../includes/footer.php';
?>
