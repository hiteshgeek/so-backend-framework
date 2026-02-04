<?php
/**
 * SixOrbit UI Demo - Accordion
 */
$pageTitle = 'Accordion';
$pageDescription = 'Accordion component for collapsible content sections';

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
            <h1 class="so-page-title">Accordion</h1>
            <p class="so-page-subtitle">Accordion component for collapsible content sections</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<div class="so-grid so-grid-cols-1 so-gap-6">

        <!-- Basic Accordion -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Accordion</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Collapsible content panels. By default, only one panel can be open at a time.</p>

                        <div class="so-accordion" id="basicAccordion" data-so-accordion>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#collapse1">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="collapse1" class="so-accordion-collapse so-show" data-so-parent="#basicAccordion">
                                    <div class="so-accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                                    </div>
                                </div>
                            </div>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#collapse2">
                                        Accordion Item #2
                                    </button>
                                </h2>
                                <div id="collapse2" class="so-accordion-collapse" data-so-parent="#basicAccordion">
                                    <div class="so-accordion-body">
                                        <strong>This is the second item's accordion body.</strong> Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.
                                    </div>
                                </div>
                            </div>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#collapse3">
                                        Accordion Item #3
                                    </button>
                                </h2>
                                <div id="collapse3" class="so-accordion-collapse" data-so-parent="#basicAccordion">
                                    <div class="so-accordion-body">
                                        <strong>This is the third item's accordion body.</strong> Aenean lacinia bibendum nulla sed consectetur.
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= so_code_block('<div class="so-accordion" id="myAccordion" data-so-accordion>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#collapse1">
                Accordion Item #1
            </button>
        </h2>
        <div id="collapse1" class="so-accordion-collapse so-show" data-so-parent="#myAccordion">
            <div class="so-accordion-body">
                Content here...
            </div>
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Always Open -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Always Open (Multiple)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Omit <code>data-so-parent</code> to allow multiple panels to be open simultaneously.</p>

                        <div class="so-accordion" id="alwaysOpenAccordion" data-so-accordion>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#openCollapse1">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="openCollapse1" class="so-accordion-collapse so-show">
                                    <div class="so-accordion-body">
                                        <strong>First panel.</strong> This accordion allows multiple panels to be open at the same time.
                                    </div>
                                </div>
                            </div>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#openCollapse2">
                                        Accordion Item #2
                                    </button>
                                </h2>
                                <div id="openCollapse2" class="so-accordion-collapse so-show">
                                    <div class="so-accordion-body">
                                        <strong>Second panel.</strong> Both can be open without closing the other.
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= so_code_block('<!-- No data-so-parent attribute allows multiple open -->
<div id="openCollapse1" class="so-accordion-collapse so-show">
    <!-- No data-so-parent here -->
</div>', 'html') ?>
            </div>
        </div>

        <!-- Flush Variant -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Flush Variant</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Remove borders and rounded corners with <code>.so-accordion-flush</code>.</p>

                        <div class="so-accordion so-accordion-flush" id="flushAccordion" data-so-accordion>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#flushCollapse1">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="flushCollapse1" class="so-accordion-collapse so-show" data-so-parent="#flushAccordion">
                                    <div class="so-accordion-body">
                                        Content for the first flush accordion item.
                                    </div>
                                </div>
                            </div>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#flushCollapse2">
                                        Accordion Item #2
                                    </button>
                                </h2>
                                <div id="flushCollapse2" class="so-accordion-collapse" data-so-parent="#flushAccordion">
                                    <div class="so-accordion-body">
                                        Content for the second flush accordion item.
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= so_code_block('<div class="so-accordion so-accordion-flush">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Apply color themes to accordions.</p>

                        <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                            <div class="so-accordion so-accordion-primary" data-so-accordion>
                                <div class="so-accordion-item">
                                    <h2 class="so-accordion-header">
                                        <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#colorPrimary">
                                            Primary Accordion
                                        </button>
                                    </h2>
                                    <div id="colorPrimary" class="so-accordion-collapse so-show">
                                        <div class="so-accordion-body">Primary color theme content.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="so-accordion so-accordion-success" data-so-accordion>
                                <div class="so-accordion-item">
                                    <h2 class="so-accordion-header">
                                        <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#colorSuccess">
                                            Success Accordion
                                        </button>
                                    </h2>
                                    <div id="colorSuccess" class="so-accordion-collapse so-show">
                                        <div class="so-accordion-body">Success color theme content.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= so_code_block('<div class="so-accordion so-accordion-primary">...</div>
<div class="so-accordion so-accordion-success">...</div>
<div class="so-accordion so-accordion-danger">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Icon Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Icon Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different icon styles for the accordion toggle.</p>

                        <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                            <!-- Plus/Minus -->
                            <div>
                                <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Plus/Minus (.so-accordion-plus-minus)</label>
                                <div class="so-accordion so-accordion-plus-minus" data-so-accordion>
                                    <div class="so-accordion-item">
                                        <h2 class="so-accordion-header">
                                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#plusMinusCollapse">
                                                Plus/Minus Icon
                                            </button>
                                        </h2>
                                        <div id="plusMinusCollapse" class="so-accordion-collapse so-show">
                                            <div class="so-accordion-body">Content with plus/minus icon.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Arrow -->
                            <div>
                                <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Arrow (.so-accordion-arrow)</label>
                                <div class="so-accordion so-accordion-arrow" data-so-accordion>
                                    <div class="so-accordion-item">
                                        <h2 class="so-accordion-header">
                                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#arrowCollapse">
                                                Arrow Icon
                                            </button>
                                        </h2>
                                        <div id="arrowCollapse" class="so-accordion-collapse so-show">
                                            <div class="so-accordion-body">Content with arrow icon.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Icon Left -->
                            <div>
                                <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Icon Left (.so-accordion-icon-left)</label>
                                <div class="so-accordion so-accordion-icon-left" data-so-accordion>
                                    <div class="so-accordion-item">
                                        <h2 class="so-accordion-header">
                                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#iconLeftCollapse">
                                                Icon on Left
                                            </button>
                                        </h2>
                                        <div id="iconLeftCollapse" class="so-accordion-collapse so-show">
                                            <div class="so-accordion-body">Content with icon on the left.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- No Icon -->
                            <div>
                                <label class="so-d-block so-mb-2 so-text-sm so-font-medium">No Icon (.so-accordion-no-icon)</label>
                                <div class="so-accordion so-accordion-no-icon" data-so-accordion>
                                    <div class="so-accordion-item">
                                        <h2 class="so-accordion-header">
                                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#noIconCollapse">
                                                No Icon
                                            </button>
                                        </h2>
                                        <div id="noIconCollapse" class="so-accordion-collapse so-show">
                                            <div class="so-accordion-body">Content without any icon.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= so_code_block('<div class="so-accordion so-accordion-plus-minus">...</div>
<div class="so-accordion so-accordion-arrow">...</div>
<div class="so-accordion so-accordion-icon-left">...</div>
<div class="so-accordion so-accordion-no-icon">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Small and large accordion sizes.</p>

                        <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                            <div>
                                <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Small (.so-accordion-sm)</label>
                                <div class="so-accordion so-accordion-sm" data-so-accordion>
                                    <div class="so-accordion-item">
                                        <h2 class="so-accordion-header">
                                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#smCollapse">
                                                Small Accordion
                                            </button>
                                        </h2>
                                        <div id="smCollapse" class="so-accordion-collapse so-show">
                                            <div class="so-accordion-body">Compact content.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Large (.so-accordion-lg)</label>
                                <div class="so-accordion so-accordion-lg" data-so-accordion>
                                    <div class="so-accordion-item">
                                        <h2 class="so-accordion-header">
                                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#lgCollapse">
                                                Large Accordion
                                            </button>
                                        </h2>
                                        <div id="lgCollapse" class="so-accordion-collapse so-show">
                                            <div class="so-accordion-body">More spacious content area.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= so_code_block('<div class="so-accordion so-accordion-sm">...</div>
<div class="so-accordion so-accordion-lg">...</div>', 'html') ?>
            </div>
        </div>

        <!-- JavaScript API & Events -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API & Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control accordions programmatically and listen to events.</p>

                        <div class="so-accordion so-mb-4" id="apiAccordion" data-so-accordion>
                            <div class="so-accordion-item">
                                <h2 class="so-accordion-header">
                                    <button class="so-accordion-button so-collapsed" data-so-toggle="collapse" data-so-target="#apiCollapse1">
                                        API Demo Panel
                                    </button>
                                </h2>
                                <div id="apiCollapse1" class="so-accordion-collapse" data-so-parent="#apiAccordion">
                                    <div class="so-accordion-body">
                                        This panel can be controlled via JavaScript API.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                            <button class="so-btn so-btn-sm so-btn-primary" onclick="SOAccordion.show(document.getElementById('apiCollapse1'))">Show</button>
                            <button class="so-btn so-btn-sm so-btn-secondary" onclick="SOAccordion.hide(document.getElementById('apiCollapse1'))">Hide</button>
                            <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="SOAccordion.toggle(document.getElementById('apiCollapse1'))">Toggle</button>
                        </div>

                        <div class="so-alert so-alert-info so-mb-4" id="accordion-event-log">
                            <span class="material-icons">info</span>
                            <span>Event log will appear here. Interact with the accordion above.</span>
                        </div>
                    <?= so_code_block('// Programmatic control
SOAccordion.show(element);   // Open panel
SOAccordion.hide(element);   // Close panel
SOAccordion.toggle(element); // Toggle panel

// Events
element.addEventListener(\'so:accordion:show\', (e) => {
    console.log(\'About to show\');
});

element.addEventListener(\'so:accordion:shown\', (e) => {
    console.log(\'Shown\');
});

element.addEventListener(\'so:accordion:hide\', (e) => {
    console.log(\'About to hide\');
});

element.addEventListener(\'so:accordion:hidden\', (e) => {
    console.log(\'Hidden\');
});', 'javascript') ?>

                <h5 class="so-mt-6 so-mb-3">Available Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so:accordion:show</code></td>
                                <td>Fires immediately when show is called</td>
                            </tr>
                            <tr>
                                <td><code>so:accordion:shown</code></td>
                                <td>Fires when panel is fully visible</td>
                            </tr>
                            <tr>
                                <td><code>so:accordion:hide</code></td>
                                <td>Fires immediately when hide is called</td>
                            </tr>
                            <tr>
                                <td><code>so:accordion:hidden</code></td>
                                <td>Fires when panel is fully hidden</td>
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
                                <td><code>.so-accordion</code></td>
                                <td>Base accordion container</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-item</code></td>
                                <td>Individual accordion panel</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-header</code></td>
                                <td>Panel header container</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-button</code></td>
                                <td>Toggle button</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-collapse</code></td>
                                <td>Collapsible content wrapper</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-body</code></td>
                                <td>Content container</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-flush</code></td>
                                <td>Remove borders/corners</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-{color}</code></td>
                                <td>Color variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-sm / .so-accordion-lg</code></td>
                                <td>Size variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-plus-minus</code></td>
                                <td>Plus/minus icon style</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-arrow</code></td>
                                <td>Arrow icon style</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-icon-left</code></td>
                                <td>Icon on left side</td>
                            </tr>
                            <tr>
                                <td><code>.so-accordion-no-icon</code></td>
                                <td>No icon</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<script>
// SOAccordion Class
class SOAccordion {
    static init() {
        document.querySelectorAll('[data-so-accordion]').forEach(accordion => {
            accordion.querySelectorAll('[data-so-toggle="collapse"]').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(button.dataset.soTarget);
                    if (target) {
                        SOAccordion.toggle(target);
                    }
                });
            });
        });
    }

    static toggle(element) {
        if (element.classList.contains('so-show')) {
            SOAccordion.hide(element);
        } else {
            SOAccordion.show(element);
        }
    }

    static show(element) {
        const parent = element.dataset.soParent ? document.querySelector(element.dataset.soParent) : null;
        const button = document.querySelector(`[data-so-target="#${element.id}"]`);

        // Close siblings if parent exists
        if (parent) {
            parent.querySelectorAll('.so-accordion-collapse.so-show').forEach(sibling => {
                if (sibling !== element) {
                    SOAccordion.hide(sibling);
                }
            });
        }

        // Dispatch show event
        element.dispatchEvent(new CustomEvent('so:accordion:show', { bubbles: true }));

        // Show element
        element.classList.add('so-collapsing');
        element.classList.remove('so-show');
        element.style.display = 'block';
        const height = element.scrollHeight;
        element.style.height = '0px';

        // Force reflow
        element.offsetHeight;

        element.style.height = height + 'px';

        if (button) {
            button.classList.remove('so-collapsed');
            button.setAttribute('aria-expanded', 'true');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            element.classList.add('so-show');
            element.style.height = '';
            element.dispatchEvent(new CustomEvent('so:accordion:shown', { bubbles: true }));
        }, 350);
    }

    static hide(element) {
        const button = document.querySelector(`[data-so-target="#${element.id}"]`);

        // Dispatch hide event
        element.dispatchEvent(new CustomEvent('so:accordion:hide', { bubbles: true }));

        element.style.height = element.scrollHeight + 'px';
        element.offsetHeight; // Force reflow
        element.classList.add('so-collapsing');
        element.classList.remove('so-show');
        element.style.height = '0px';

        if (button) {
            button.classList.add('so-collapsed');
            button.setAttribute('aria-expanded', 'false');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            element.style.display = '';
            element.style.height = '';
            element.dispatchEvent(new CustomEvent('so:accordion:hidden', { bubbles: true }));
        }, 350);
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    SOAccordion.init();

    // Event log demo
    const apiCollapse = document.getElementById('apiCollapse1');
    const eventLog = document.getElementById('accordion-event-log');

    if (apiCollapse && eventLog) {
        apiCollapse.addEventListener('so:accordion:show', () => {
            eventLog.innerHTML = '<span class="material-icons">play_arrow</span><span><strong>so:accordion:show</strong> - Panel is about to open</span>';
        });
        apiCollapse.addEventListener('so:accordion:shown', () => {
            eventLog.innerHTML = '<span class="material-icons">check_circle</span><span><strong>so:accordion:shown</strong> - Panel is now fully open</span>';
        });
        apiCollapse.addEventListener('so:accordion:hide', () => {
            eventLog.innerHTML = '<span class="material-icons">close</span><span><strong>so:accordion:hide</strong> - Panel is about to close</span>';
        });
        apiCollapse.addEventListener('so:accordion:hidden', () => {
            eventLog.innerHTML = '<span class="material-icons">check</span><span><strong>so:accordion:hidden</strong> - Panel is now fully closed</span>';
        });
    }
});

function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const activePane = codeBlock.querySelector('.so-code-pane.so-active') || codeBlock;
    const code = activePane.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
