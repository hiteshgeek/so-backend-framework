<?php
/**
 * SixOrbit UI Engine - Collapse Element Demo
 */

$pageTitle = 'Collapse - UI Engine';
$pageDescription = 'Toggle visibility of content with smooth animations';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Collapse</h1>
            <p class="so-page-subtitle">Toggle the visibility of content with smooth CSS transitions and animations.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Collapse -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Collapse</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <button class="so-btn so-btn-primary so-mb-3" type="button" data-so-toggle="collapse" data-so-target="#collapseDemo">
                    Toggle Content
                </button>
                <div class="so-collapse so-show" id="collapseDemo">
                    <div class="so-card so-card-body">
                        This is collapsible content. It can contain any HTML elements including text, images, forms, and other components.
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-collapse', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Create collapse with trigger button
\$collapse = UiEngine::collapse('my-collapse')
    ->trigger('Toggle Content')      // Creates button automatically
    ->triggerVariant('primary')      // Button variant
    ->content('This is collapsible content.');

echo \$collapse->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Create collapse with trigger button
const collapse = UiEngine.collapse('my-collapse')
    .trigger('Toggle Content')
    .triggerVariant('primary')
    .content('This is collapsible content.');

document.getElementById('container').innerHTML = collapse.toHtml();

// Or use the collapse API directly
const collapseEl = document.getElementById('my-collapse');

// Toggle programmatically
SOCollapse.toggle(collapseEl);
SOCollapse.show(collapseEl);
SOCollapse.hide(collapseEl);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button class="so-btn so-btn-primary" type="button"
        data-so-toggle="collapse" data-so-target="#my-collapse">
    Toggle Content
</button>

<div class="so-collapse" id="my-collapse">
    This is collapsible content.
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Link Toggle -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Link Toggle</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <a class="so-btn so-btn-link" data-so-toggle="collapse" href="#collapseLinkDemo">
                    Show More <span class="material-icons so-align-middle">expand_more</span>
                </a>
                <div class="so-collapse" id="collapseLinkDemo">
                    <div class="so-mt-3 so-p-3 so-bg-white so-rounded so-border">
                        Additional content revealed when the link is clicked. This pattern is useful for "read more" functionality.
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('collapse-link', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Using collapse with link variant trigger
\$collapse = UiEngine::collapse('more-content')
    ->trigger('Show More')
    ->triggerVariant('link')  // Renders as a link-style button
    ->content('Additional content revealed when the link is clicked.');

echo \$collapse->render();

// Or use hideTrigger() for external toggle control:
\$collapse = UiEngine::collapse('more-content')
    ->hideTrigger()  // No built-in trigger
    ->content('Content...');

// Then use manual HTML/JS for the trigger"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Using collapse with link variant trigger
const collapse = UiEngine.collapse('more-content')
    .trigger('Show More')
    .triggerVariant('link')
    .content('Additional content revealed when clicked.');

document.getElementById('container').innerHTML = collapse.toHtml();

// Or for external trigger with manual HTML:
// <a data-so-toggle=\"collapse\" href=\"#more-content\">Show More</a>"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Horizontal Collapse -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal Collapse</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <button class="so-btn so-btn-primary so-mb-3" type="button" data-so-toggle="collapse" data-so-target="#collapseHorizontal">
                    Toggle Width
                </button>
                <div style="min-height:100px;">
                    <div class="so-collapse so-collapse-horizontal so-show" id="collapseHorizontal">
                        <div class="so-card so-card-body" style="width:300px;">
                            This collapses horizontally instead of vertically!
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('collapse-horizontal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$collapse = UiEngine::collapse('sidebar')
    ->trigger('Toggle Width')
    ->triggerVariant('primary')
    ->horizontal()  // Collapse horizontally instead of vertically
    ->content('<div style=\"width:300px;\">Sidebar content</div>');

echo \$collapse->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const collapse = UiEngine.collapse('sidebar')
    .trigger('Toggle Width')
    .triggerVariant('primary')
    .horizontal()
    .content('<div style=\"width:300px;\">Sidebar content</div>');

document.getElementById('container').innerHTML = collapse.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Multiple Targets -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Multiple Targets</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-mb-3">
                    <button class="so-btn so-btn-primary" type="button" data-so-toggle="collapse" data-so-target="#multiCollapse1">
                        Toggle First
                    </button>
                    <button class="so-btn so-btn-secondary" type="button" data-so-toggle="collapse" data-so-target="#multiCollapse2">
                        Toggle Second
                    </button>
                    <button class="so-btn so-btn-success" type="button" data-so-toggle="collapse" data-so-target=".multi-collapse">
                        Toggle Both
                    </button>
                </div>
                <div class="so-grid so-grid-cols-2">
                    <div class="so-collapse multi-collapse so-show" id="multiCollapse1">
                        <div class="so-card so-card-body">First collapsible element</div>
                    </div>
                    <div class="so-collapse multi-collapse" id="multiCollapse2">
                        <div class="so-card so-card-body">Second collapsible element</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('collapse-multiple', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create separate collapses with hideTrigger() for external control
\$panel1 = UiEngine::collapse('panel1')
    ->hideTrigger()  // No built-in trigger
    ->addClass('panels')
    ->content('First panel');

\$panel2 = UiEngine::collapse('panel2')
    ->hideTrigger()
    ->addClass('panels')
    ->content('Second panel');

echo \$panel1->render();
echo \$panel2->render();

// Use manual HTML buttons with data attributes:
// <button data-so-toggle=\"collapse\" data-so-target=\"#panel1\">Toggle First</button>
// <button data-so-toggle=\"collapse\" data-so-target=\".panels\">Toggle Both</button>"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Create collapses without built-in triggers
const panel1 = UiEngine.collapse('panel1')
    .hideTrigger()
    .addClass('panels')
    .content('First panel');

const panel2 = UiEngine.collapse('panel2')
    .hideTrigger()
    .addClass('panels')
    .content('Second panel');

// Multiple targets can be toggled with class selectors:
// data-so-target=\".panels\" targets all elements with 'panels' class"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Initially Shown -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Initially Shown</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <button class="so-btn so-btn-primary so-mb-3" type="button" data-so-toggle="collapse" data-so-target="#collapseShownDemo" aria-expanded="true">
                    Hide Details
                </button>
                <div class="so-collapse so-show" id="collapseShownDemo">
                    <div class="so-card so-card-body">
                        This content is visible by default. Click the button above to toggle visibility.
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('collapse-shown', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Content visible by default
\$collapse = UiEngine::collapse('details')
    ->trigger('Hide Details')
    ->triggerVariant('primary')
    ->expanded()  // Initially expanded (visible)
    ->content('This content is visible by default.');

echo \$collapse->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Content visible by default
const collapse = UiEngine.collapse('details')
    .trigger('Hide Details')
    .triggerVariant('primary')
    .expanded()  // Initially expanded
    .content('This content is visible by default.');

document.getElementById('container').innerHTML = collapse.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Event Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Event Handling</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <button class="so-btn so-btn-primary so-mb-3" type="button" data-so-toggle="collapse" data-so-target="#collapseEventsDemo">
                    Toggle Content
                </button>
                <div class="so-collapse so-show" id="collapseEventsDemo">
                    <div class="so-card so-card-body">
                        Toggle this content and watch the event log below.
                    </div>
                </div>
                <div class="so-alert so-alert-info so-mt-3" id="collapse-event-log">
                    <span class="material-icons">info</span>
                    <span>Event log: Interact with the collapse above to see events.</span>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('collapse-events', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Events are handled in JavaScript
// PHP just renders the markup

\$collapse = UiEngine::collapse('animated')
    ->content('Content with event handling');

echo \$collapse->render();
// Add JS event listeners separately"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const collapseEl = document.getElementById('my-collapse');

// Event fires when show() is called
collapseEl.addEventListener('show.so.collapse', () => {
    console.log('Starting to show');
});

// Event fires when fully shown
collapseEl.addEventListener('shown.so.collapse', () => {
    console.log('Fully visible');
});

// Event fires when hide() is called
collapseEl.addEventListener('hide.so.collapse', () => {
    console.log('Starting to hide');
});

// Event fires when fully hidden
collapseEl.addEventListener('hidden.so.collapse', () => {
    console.log('Fully hidden');
});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Accordion Pattern -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Accordion Pattern</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use the parent attribute to create accordion behavior where only one item can be open at a time.</p>

                <!-- Live Demo -->
                <div class="so-accordion so-mb-4" id="accordionDemo" data-so-accordion>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header">
                            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#accordionItem1" aria-expanded="true">
                                Section 1
                            </button>
                        </h2>
                        <div id="accordionItem1" class="so-accordion-collapse so-show" data-so-parent="#accordionDemo">
                            <div class="so-accordion-body">
                                This is the first accordion item content. When you open another section, this one will automatically close.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header">
                            <button class="so-accordion-button so-collapsed" data-so-toggle="collapse" data-so-target="#accordionItem2" aria-expanded="false">
                                Section 2
                            </button>
                        </h2>
                        <div id="accordionItem2" class="so-accordion-collapse" data-so-parent="#accordionDemo">
                            <div class="so-accordion-body">
                                This is the second accordion item content. Only one section can be open at a time.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header">
                            <button class="so-accordion-button so-collapsed" data-so-toggle="collapse" data-so-target="#accordionItem3" aria-expanded="false">
                                Section 3
                            </button>
                        </h2>
                        <div id="accordionItem3" class="so-accordion-collapse" data-so-parent="#accordionDemo">
                            <div class="so-accordion-body">
                                This is the third accordion item content. Click the headers to toggle sections.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('collapse-accordion', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Use the dedicated accordion component
\$accordion = UiEngine::accordion('myAccordion')
    ->item('Section 1', 'First content', ['show' => true])
    ->item('Section 2', 'Second content')
    ->item('Section 3', 'Third content');

echo \$accordion->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Use the dedicated accordion component
const accordion = UiEngine.accordion('myAccordion')
    .item('Section 1', 'First content', {show: true})
    .item('Section 2', 'Second content')
    .item('Section 3', 'Third content');

document.getElementById('container').innerHTML = accordion.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-accordion" id="myAccordion" data-so-accordion>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button" data-so-toggle="collapse"
                    data-so-target="#collapse1" aria-expanded="true">
                Section 1
            </button>
        </h2>
        <div id="collapse1" class="so-accordion-collapse so-show"
             data-so-parent="#myAccordion">
            <div class="so-accordion-body">
                First content
            </div>
        </div>
    </div>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button so-collapsed"
                    data-so-toggle="collapse" data-so-target="#collapse2">
                Section 2
            </button>
        </h2>
        <div id="collapse2" class="so-accordion-collapse"
             data-so-parent="#myAccordion">
            <div class="so-accordion-body">
                Second content
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
                                <td><code>content()</code></td>
                                <td><code>string $html</code></td>
                                <td>Set collapse content</td>
                            </tr>
                            <tr>
                                <td><code>trigger()</code></td>
                                <td><code>string $text</code></td>
                                <td>Set trigger button text</td>
                            </tr>
                            <tr>
                                <td><code>triggerVariant()</code></td>
                                <td><code>string $variant</code></td>
                                <td>Set trigger button variant (primary, secondary, link, etc.)</td>
                            </tr>
                            <tr>
                                <td><code>expanded()</code></td>
                                <td><code>bool $expanded = true</code></td>
                                <td>Initially expanded (visible)</td>
                            </tr>
                            <tr>
                                <td><code>collapsed()</code></td>
                                <td>-</td>
                                <td>Initially collapsed (hidden) - default</td>
                            </tr>
                            <tr>
                                <td><code>horizontal()</code></td>
                                <td><code>bool $horizontal = true</code></td>
                                <td>Collapse horizontally instead of vertically</td>
                            </tr>
                            <tr>
                                <td><code>showTrigger()</code></td>
                                <td><code>bool $show = true</code></td>
                                <td>Show/hide the trigger button</td>
                            </tr>
                            <tr>
                                <td><code>hideTrigger()</code></td>
                                <td>-</td>
                                <td>Hide trigger button for external control</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4">JavaScript Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>show.so.collapse</code></td>
                                <td>Fires when show transition starts</td>
                            </tr>
                            <tr>
                                <td><code>shown.so.collapse</code></td>
                                <td>Fires when element is fully visible</td>
                            </tr>
                            <tr>
                                <td><code>hide.so.collapse</code></td>
                                <td>Fires when hide transition starts</td>
                            </tr>
                            <tr>
                                <td><code>hidden.so.collapse</code></td>
                                <td>Fires when element is fully hidden</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// SOCollapse Class - Handles collapse toggle functionality
class SOCollapse {
    static init() {
        document.querySelectorAll('[data-so-toggle="collapse"]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();

                // Get target(s)
                const targetSelector = trigger.dataset.soTarget || trigger.getAttribute('href');
                if (!targetSelector) return;

                const targets = document.querySelectorAll(targetSelector);
                targets.forEach(target => {
                    SOCollapse.toggle(target);
                });
            });
        });
    }

    static toggle(element) {
        if (element.classList.contains('so-show')) {
            SOCollapse.hide(element);
        } else {
            SOCollapse.show(element);
        }
    }

    static show(element) {
        if (element.classList.contains('so-show') || element.classList.contains('so-collapsing')) return;

        const trigger = document.querySelector(`[data-so-target="#${element.id}"], [href="#${element.id}"]`);
        const isHorizontal = element.classList.contains('so-collapse-horizontal');
        const isAccordion = element.classList.contains('so-accordion-collapse');

        // Handle accordion behavior - close other items in the same parent
        const parentSelector = element.dataset.soParent;
        if (parentSelector) {
            const parent = document.querySelector(parentSelector);
            if (parent) {
                // Support both collapse and accordion collapse elements
                const selector = isAccordion ? '.so-accordion-collapse.so-show' : '.so-collapse.so-show';
                parent.querySelectorAll(selector).forEach(sibling => {
                    if (sibling !== element) {
                        SOCollapse.hide(sibling);
                    }
                });
            }
        }

        // Dispatch show event
        element.dispatchEvent(new CustomEvent('show.so.collapse', { bubbles: true }));

        // Remove hidden state first
        element.classList.remove('so-collapse', 'so-accordion-collapse');
        element.style.display = 'block';

        // Measure target dimensions
        const targetHeight = element.scrollHeight;
        const targetWidth = element.scrollWidth;

        // Set initial dimension to 0
        if (isHorizontal) {
            element.style.width = '0px';
            element.style.overflow = 'hidden';
        } else {
            element.style.height = '0px';
            element.style.overflow = 'hidden';
        }

        // Add collapsing class for transition
        element.classList.add('so-collapsing');

        // Force reflow to apply initial state
        element.offsetHeight;

        // Animate to full size
        if (isHorizontal) {
            element.style.width = targetWidth + 'px';
        } else {
            element.style.height = targetHeight + 'px';
        }

        if (trigger) {
            trigger.classList.remove('so-collapsed');
            trigger.setAttribute('aria-expanded', 'true');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            // Add appropriate classes based on element type
            if (isAccordion) {
                element.classList.add('so-accordion-collapse', 'so-show');
            } else {
                element.classList.add('so-collapse', 'so-show');
            }
            element.style.display = '';
            element.style.height = '';
            element.style.width = '';
            element.style.overflow = '';
            element.dispatchEvent(new CustomEvent('shown.so.collapse', { bubbles: true }));
        }, 350);
    }

    static hide(element) {
        if (!element.classList.contains('so-show') || element.classList.contains('so-collapsing')) return;

        const trigger = document.querySelector(`[data-so-target="#${element.id}"], [href="#${element.id}"]`);
        const isHorizontal = element.classList.contains('so-collapse-horizontal');
        const isAccordion = element.classList.contains('so-accordion-collapse');

        // Dispatch hide event
        element.dispatchEvent(new CustomEvent('hide.so.collapse', { bubbles: true }));

        // Set explicit dimensions before animating
        if (isHorizontal) {
            element.style.width = element.scrollWidth + 'px';
        } else {
            element.style.height = element.scrollHeight + 'px';
        }
        element.style.overflow = 'hidden';

        // Force reflow
        element.offsetHeight;

        // Remove show state, add collapsing for transition
        element.classList.remove('so-collapse', 'so-accordion-collapse', 'so-show');
        element.classList.add('so-collapsing');

        // Force reflow before animating to 0
        element.offsetHeight;

        // Animate to 0
        if (isHorizontal) {
            element.style.width = '0px';
        } else {
            element.style.height = '0px';
        }

        if (trigger) {
            trigger.classList.add('so-collapsed');
            trigger.setAttribute('aria-expanded', 'false');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            // Add appropriate class based on element type
            if (isAccordion) {
                element.classList.add('so-accordion-collapse');
            } else {
                element.classList.add('so-collapse');
            }
            element.style.display = '';
            element.style.height = '';
            element.style.width = '';
            element.style.overflow = '';
            element.dispatchEvent(new CustomEvent('hidden.so.collapse', { bubbles: true }));
        }, 350);
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    SOCollapse.init();

    // Event log demo
    const eventsDemo = document.getElementById('collapseEventsDemo');
    const eventLog = document.getElementById('collapse-event-log');

    if (eventsDemo && eventLog) {
        eventsDemo.addEventListener('show.so.collapse', () => {
            eventLog.innerHTML = '<span class="material-icons">play_arrow</span><span><strong>show.so.collapse</strong> - Starting to expand</span>';
        });
        eventsDemo.addEventListener('shown.so.collapse', () => {
            eventLog.innerHTML = '<span class="material-icons">check_circle</span><span><strong>shown.so.collapse</strong> - Fully expanded</span>';
        });
        eventsDemo.addEventListener('hide.so.collapse', () => {
            eventLog.innerHTML = '<span class="material-icons">close</span><span><strong>hide.so.collapse</strong> - Starting to collapse</span>';
        });
        eventsDemo.addEventListener('hidden.so.collapse', () => {
            eventLog.innerHTML = '<span class="material-icons">check</span><span><strong>hidden.so.collapse</strong> - Fully collapsed</span>';
        });
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
