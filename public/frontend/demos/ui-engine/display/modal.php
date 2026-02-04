<?php
/**
 * SixOrbit UI Engine - Modal Element Demo
 *
 * Comprehensive demonstration of the Modal element with:
 * - Basic usage examples
 * - UiEngine PHP and JavaScript API
 * - Complete API reference
 * - Validation patterns
 * - Error handling
 * - Configuration passing
 */

$pageTitle = 'Modal - UI Engine';
$pageDescription = 'Flexible modal dialogs for displaying content, forms, and confirmations with various sizes and behaviors';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Modal</h1>
            <p class="so-page-subtitle">Flexible modal dialogs for displaying content, forms, and confirmations with support for various sizes, scrollable content, and custom behaviors.</p>
        </div>
    </div>

    <div class="so-page-body">

        <!-- Quick Links -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Quick Navigation</h3>
            </div>
            <div class="so-card-body">
                <div class="so-d-flex so-flex-wrap so-gap-2">
                    <a href="#basic" class="so-btn so-btn-sm so-btn-outline-primary">Basic Modal</a>
                    <a href="#sizes" class="so-btn so-btn-sm so-btn-outline-primary">Modal Sizes</a>
                    <a href="#scrollable" class="so-btn so-btn-sm so-btn-outline-primary">Scrollable Modal</a>
                    <a href="#centered" class="so-btn so-btn-sm so-btn-outline-primary">Centered Modal</a>
                    <a href="#static" class="so-btn so-btn-sm so-btn-outline-primary">Static Backdrop</a>
                    <a href="#uiengine" class="so-btn so-btn-sm so-btn-outline-primary">UiEngine API</a>
                    <a href="#api-reference" class="so-btn so-btn-sm so-btn-outline-primary">API Reference</a>
                    <a href="#validation" class="so-btn so-btn-sm so-btn-outline-primary">Validation</a>
                    <a href="#error-handling" class="so-btn so-btn-sm so-btn-outline-primary">Error Handling</a>
                    <a href="#demo-link" class="so-btn so-btn-sm so-btn-success">Full CSS Demo</a>
                </div>
            </div>
        </div>

        <!-- Basic Modal -->
        <div class="so-card so-mb-4" id="basic">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Modal Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A standard modal dialog with title, body content, and action buttons.</p>

                <!-- Live Demo -->
                <button type="button" class="so-btn so-btn-primary so-mb-4" onclick="document.getElementById('basic-modal').classList.add('so-show'); createBackdrop();">
                    Launch Basic Modal
                </button>

                <div class="so-modal" id="basic-modal" tabindex="-1" aria-labelledby="basic-modal-label" aria-hidden="true">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title" id="basic-modal-label">Modal Title</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal('basic-modal')">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This is a basic modal dialog. You can put any content here including text, forms, images, or other components.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal" onclick="closeModal('basic-modal')">Close</button>
                            <button type="button" class="so-btn so-btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-modal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Create basic modal
\$modal = UiEngine::modal('basic-modal')
    ->title('Modal Title')
    ->body('<p>This is a basic modal dialog. You can put any content here including text, forms, images, or other components.</p>')
    ->closeButton('Close')
    ->saveButton('Save Changes');

echo \$modal;

// Trigger button
\$trigger = UiEngine::button()
    ->text('Launch Basic Modal')
    ->variant('primary')
    ->attr('data-so-toggle', 'modal')
    ->attr('data-so-target', '#basic-modal');

echo \$trigger;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { UiEngine } from './ui-engine/UiEngine.js';

// Create basic modal
const modal = UiEngine.modal('basic-modal')
    .title('Modal Title')
    .body('<p>This is a basic modal dialog. You can put any content here including text, forms, images, or other components.</p>')
    .closeButton('Close')
    .saveButton('Save Changes');

document.body.insertAdjacentHTML('beforeend', modal.render());

// Trigger button
const trigger = UiEngine.button()
    .text('Launch Basic Modal')
    .variant('primary')
    .attr('data-so-toggle', 'modal')
    .attr('data-so-target', '#basic-modal');

document.getElementById('container').innerHTML = trigger.render();

// Show modal programmatically
modal.show();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary" onclick="document.getElementById(\'basic-modal\').classList.add(\'so-show\'); createBackdrop();">
    Launch Basic Modal
</button>

<div class="so-modal" id="basic-modal" tabindex="-1" aria-labelledby="basic-modal-label" aria-hidden="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header">
            <h5 class="so-modal-title" id="basic-modal-label">Modal Title</h5>
            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(\'basic-modal\')">
                <span class="material-icons">close</span>
            </button>
        </div>
        <div class="so-modal-body">
            <p>This is a basic modal dialog...</p>
        </div>
        <div class="so-modal-footer">
            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="so-btn so-btn-primary">Save Changes</button>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Modal Sizes -->
        <div class="so-card so-mb-4" id="sizes">
            <div class="so-card-header">
                <h3 class="so-card-title">Modal Sizes Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control the modal size using predefined size classes: small, medium (default), large, extra large, and fullscreen.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" onclick="document.getElementById('modal-sm').classList.add('so-show'); createBackdrop();">Small Modal</button>
                    <button type="button" class="so-btn so-btn-primary" onclick="document.getElementById('modal-md').classList.add('so-show'); createBackdrop();">Medium Modal</button>
                    <button type="button" class="so-btn so-btn-primary" onclick="document.getElementById('modal-lg').classList.add('so-show'); createBackdrop();">Large Modal</button>
                    <button type="button" class="so-btn so-btn-primary" onclick="document.getElementById('modal-xl').classList.add('so-show'); createBackdrop();">Extra Large Modal</button>
                    <button type="button" class="so-btn so-btn-primary" onclick="document.getElementById('modal-fullscreen').classList.add('so-show'); createBackdrop();">Fullscreen Modal</button>
                </div>

                <!-- Small Modal -->
                <div class="so-modal so-modal-sm" id="modal-sm" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Small Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This is a small modal, perfect for simple confirmations or short messages.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Medium Modal -->
                <div class="so-modal" id="modal-md" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Medium Modal (Default)</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This is a medium-sized modal, the default size for most use cases.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Large Modal -->
                <div class="so-modal so-modal-lg" id="modal-lg" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Large Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This is a large modal, suitable for more complex content like forms or detailed information.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Extra Large Modal -->
                <div class="so-modal so-modal-xl" id="modal-xl" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Extra Large Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This is an extra large modal, ideal for displaying extensive content, tables, or complex layouts.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Fullscreen Modal -->
                <div class="so-modal so-modal-fullscreen" id="modal-fullscreen" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Fullscreen Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This is a fullscreen modal, taking up the entire viewport. Perfect for immersive experiences or detailed workflows.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('modal-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small modal
\$modalSm = UiEngine::modal('modal-sm')
    ->title('Small Modal')
    ->body('<p>This is a small modal, perfect for simple confirmations.</p>')
    ->small()  // or ->size('sm')
    ->closeButton();

// Medium modal (default)
\$modalMd = UiEngine::modal('modal-md')
    ->title('Medium Modal (Default)')
    ->body('<p>This is a medium-sized modal, the default size.</p>')
    ->closeButton();

// Large modal
\$modalLg = UiEngine::modal('modal-lg')
    ->title('Large Modal')
    ->body('<p>This is a large modal, suitable for more complex content.</p>')
    ->large()  // or ->size('lg')
    ->closeButton();

// Extra large modal
\$modalXl = UiEngine::modal('modal-xl')
    ->title('Extra Large Modal')
    ->body('<p>This is an extra large modal, ideal for extensive content.</p>')
    ->extraLarge()  // or ->size('xl')
    ->closeButton();

// Fullscreen modal
\$modalFs = UiEngine::modal('modal-fullscreen')
    ->title('Fullscreen Modal')
    ->body('<p>This is a fullscreen modal, taking up the entire viewport.</p>')
    ->fullscreen()
    ->closeButton();

echo \$modalSm . \$modalMd . \$modalLg . \$modalXl . \$modalFs;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small modal
const modalSm = UiEngine.modal('modal-sm')
    .title('Small Modal')
    .body('<p>This is a small modal, perfect for simple confirmations.</p>')
    .small()  // or .size('sm')
    .closeButton();

// Medium modal (default)
const modalMd = UiEngine.modal('modal-md')
    .title('Medium Modal (Default)')
    .body('<p>This is a medium-sized modal, the default size.</p>')
    .closeButton();

// Large modal
const modalLg = UiEngine.modal('modal-lg')
    .title('Large Modal')
    .body('<p>This is a large modal, suitable for more complex content.</p>')
    .large()  // or .size('lg')
    .closeButton();

// Extra large modal
const modalXl = UiEngine.modal('modal-xl')
    .title('Extra Large Modal')
    .body('<p>This is an extra large modal, ideal for extensive content.</p>')
    .extraLarge()  // or .size('xl')
    .closeButton();

// Fullscreen modal
const modalFs = UiEngine.modal('modal-fullscreen')
    .title('Fullscreen Modal')
    .body('<p>This is a fullscreen modal, taking up the entire viewport.</p>')
    .fullscreen()
    .closeButton();

document.body.insertAdjacentHTML('beforeend', modalSm.render() + modalMd.render() + modalLg.render() + modalXl.render() + modalFs.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small Modal -->
<div class="so-modal so-modal-sm" id="modal-sm" tabindex="-1" aria-hidden="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header">...</div>
        <div class="so-modal-body">...</div>
        <div class="so-modal-footer">...</div>
    </div>
</div>

<!-- Large Modal -->
<div class="so-modal so-modal-lg" id="modal-lg" tabindex="-1" aria-hidden="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header">...</div>
        <div class="so-modal-body">...</div>
        <div class="so-modal-footer">...</div>
    </div>
</div>

<!-- Extra Large Modal -->
<div class="so-modal so-modal-xl" id="modal-xl" tabindex="-1" aria-hidden="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header">...</div>
        <div class="so-modal-body">...</div>
        <div class="so-modal-footer">...</div>
    </div>
</div>

<!-- Fullscreen Modal -->
<div class="so-modal so-modal-fullscreen" id="modal-fullscreen" tabindex="-1" aria-hidden="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header">...</div>
        <div class="so-modal-body">...</div>
        <div class="so-modal-footer">...</div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Scrollable Modal -->
        <div class="so-card so-mb-4" id="scrollable">
            <div class="so-card-header">
                <h3 class="so-card-title">Scrollable Modal Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Enable scrollable content within the modal body when content exceeds viewport height.</p>

                <!-- Live Demo -->
                <button type="button" class="so-btn so-btn-primary so-mb-4" onclick="document.getElementById('scrollable-modal').classList.add('so-show'); createBackdrop();">
                    Launch Scrollable Modal
                </button>

                <div class="so-modal so-modal-scrollable" id="scrollable-modal" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog so-modal-dialog-scrollable">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Scrollable Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This modal has scrollable content. When the content exceeds the viewport height, it will scroll within the modal body.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                            <p>Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.</p>
                            <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="so-btn so-btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('scrollable-modal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$modal = UiEngine::modal('scrollable-modal')
    ->title('Scrollable Modal')
    ->body('<p>This modal has scrollable content...</p><p>Lorem ipsum...</p>')
    ->scrollable()
    ->closeButton()
    ->saveButton();

echo \$modal;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const modal = UiEngine.modal('scrollable-modal')
    .title('Scrollable Modal')
    .body('<p>This modal has scrollable content...</p><p>Lorem ipsum...</p>')
    .scrollable()
    .closeButton()
    .saveButton();

document.body.insertAdjacentHTML('beforeend', modal.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-modal" id="scrollable-modal" tabindex="-1" aria-hidden="true">
    <div class="so-modal-dialog so-modal-dialog-scrollable">
            <div class="so-modal-header">
                <h5 class="so-modal-title">Scrollable Modal</h5>
                <button class="so-modal-close" data-dismiss="modal">
                    <span class="material-icons">close</span>
                </button>
            </div>
            <div class="so-modal-body">
                <p>This modal has scrollable content...</p>
            </div>
            <div class="so-modal-footer">
                <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="so-btn so-btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Centered Modal -->
        <div class="so-card so-mb-4" id="centered">
            <div class="so-card-header">
                <h3 class="so-card-title">Centered Modal Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Vertically center the modal in the viewport for better visual balance.</p>

                <!-- Live Demo -->
                <button type="button" class="so-btn so-btn-primary so-mb-4" onclick="document.getElementById('centered-modal').classList.add('so-show'); createBackdrop();">
                    Launch Centered Modal
                </button>

                <div class="so-modal" id="centered-modal" tabindex="-1" aria-hidden="true">
                    <div class="so-modal-dialog so-modal-dialog-centered">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Centered Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This modal is vertically centered in the viewport, providing a more balanced visual appearance.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="so-btn so-btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('centered-modal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$modal = UiEngine::modal('centered-modal')
    ->title('Centered Modal')
    ->body('<p>This modal is vertically centered in the viewport.</p>')
    ->centered()
    ->closeButton()
    ->saveButton();

echo \$modal;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const modal = UiEngine.modal('centered-modal')
    .title('Centered Modal')
    .body('<p>This modal is vertically centered in the viewport.</p>')
    .centered()
    .closeButton()
    .saveButton();

document.body.insertAdjacentHTML('beforeend', modal.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-modal" id="centered-modal" tabindex="-1" aria-hidden="true">
    <div class="so-modal-dialog so-modal-dialog-centered">
        <div class="so-modal-content">
            <div class="so-modal-header">
                <h5 class="so-modal-title">Centered Modal</h5>
                <button class="so-modal-close" data-dismiss="modal">
                    <span class="material-icons">close</span>
                </button>
            </div>
            <div class="so-modal-body">
                <p>This modal is vertically centered in the viewport.</p>
            </div>
            <div class="so-modal-footer">
                <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="so-btn so-btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Static Backdrop -->
        <div class="so-card so-mb-4" id="static">
            <div class="so-card-header">
                <h3 class="so-card-title">Static Backdrop Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Prevent modal from closing when clicking outside of it or pressing Escape key.</p>

                <!-- Live Demo -->
                <button type="button" class="so-btn so-btn-primary so-mb-4" onclick="document.getElementById('static-modal').classList.add('so-show'); createBackdrop();">
                    Launch Static Backdrop Modal
                </button>

                <div class="so-modal" id="static-modal" tabindex="-1" aria-hidden="true" data-so-backdrop="static" data-so-keyboard="false">
                    <div class="so-modal-dialog">
                        <div class="so-modal-header">
                            <h5 class="so-modal-title">Static Backdrop Modal</h5>
                            <button class="so-modal-close" data-dismiss="modal" onclick="closeModal(this.closest('.so-modal').id)">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="so-modal-body">
                            <p>This modal cannot be dismissed by clicking outside or pressing Escape. You must click the Close button to dismiss it.</p>
                        </div>
                        <div class="so-modal-footer">
                            <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="so-btn so-btn-primary">Understood</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('static-modal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$modal = UiEngine::modal('static-modal')
    ->title('Static Backdrop Modal')
    ->body('<p>This modal cannot be dismissed by clicking outside or pressing Escape.</p>')
    ->staticBackdrop()
    ->noKeyboard()
    ->closeButton()
    ->addButton('Understood', 'primary');

echo \$modal;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const modal = UiEngine.modal('static-modal')
    .title('Static Backdrop Modal')
    .body('<p>This modal cannot be dismissed by clicking outside or pressing Escape.</p>')
    .staticBackdrop()
    .noKeyboard()
    .closeButton()
    .addButton('Understood', 'primary');

document.body.insertAdjacentHTML('beforeend', modal.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-modal" id="static-modal" tabindex="-1" aria-hidden="true" data-so-backdrop="static" data-so-keyboard="false">
    <div class="so-modal-dialog">
        <div class="so-modal-content">
            <div class="so-modal-header">
                <h5 class="so-modal-title">Static Backdrop Modal</h5>
                <button class="so-modal-close" data-dismiss="modal">
                    <span class="material-icons">close</span>
                </button>
            </div>
            <div class="so-modal-body">
                <p>This modal cannot be dismissed by clicking outside or pressing Escape.</p>
            </div>
            <div class="so-modal-footer">
                <button type="button" class="so-btn so-btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="so-btn so-btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- UiEngine Usage -->
        <div class="so-card so-mb-4" id="uiengine">
            <div class="so-card-header">
                <h3 class="so-card-title">UiEngine Usage</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    The UiEngine provides identical PHP and JavaScript APIs for server-side and client-side rendering.
                </p>

                <?php
                $phpContent = so_code_block('<?php
use Core\UiEngine\UiEngine;

// Basic modal
$modal = UiEngine::modal(\'my-modal\')
    ->title(\'Modal Title\')
    ->body(\'<p>Modal content goes here.</p>\')
    ->closeButton()
    ->saveButton();

echo $modal;

// Modal with custom buttons
$confirmModal = UiEngine::modal(\'confirm-modal\')
    ->title(\'Confirm Action\')
    ->body(\'<p>Are you sure you want to proceed?</p>\')
    ->closeButton(\'Cancel\')
    ->addButton(\'Confirm\', \'danger\', [\'data-action\' => \'confirm\']);

echo $confirmModal;

// Advanced configuration
$advancedModal = UiEngine::modal(\'advanced-modal\')
    ->title(\'Advanced Modal\')
    ->body(\'<form>...</form>\')
    ->large()
    ->scrollable()
    ->centered()
    ->staticBackdrop()
    ->noKeyboard()
    ->hideClose()
    ->addButton(\'Cancel\', \'secondary\', [\'data-so-dismiss\' => \'modal\'])
    ->addButton(\'Submit\', \'primary\', [\'type\' => \'submit\']);

echo $advancedModal;

// Programmatic control (requires JavaScript)
// Show modal
$modal->show();

// Hide modal
$modal->hide();

// Toggle modal
$modal->toggle();

// Getters
$title = $modal->getTitle();
$body = $modal->getBody();
$size = $modal->getSize();
$isScrollable = $modal->isScrollable();', 'php');

                $jsContent = so_code_block('import { UiEngine } from \'./ui-engine/UiEngine.js\';

// Basic modal
const modal = UiEngine.modal(\'my-modal\')
    .title(\'Modal Title\')
    .body(\'<p>Modal content goes here.</p>\')
    .closeButton()
    .saveButton();

document.body.insertAdjacentHTML(\'beforeend\', modal.render());

// Modal with custom buttons
const confirmModal = UiEngine.modal(\'confirm-modal\')
    .title(\'Confirm Action\')
    .body(\'<p>Are you sure you want to proceed?</p>\')
    .closeButton(\'Cancel\')
    .addButton(\'Confirm\', \'danger\', {\'data-action\': \'confirm\'});

document.body.insertAdjacentHTML(\'beforeend\', confirmModal.render());

// Advanced configuration
const advancedModal = UiEngine.modal(\'advanced-modal\')
    .title(\'Advanced Modal\')
    .body(\'<form>...</form>\')
    .large()
    .scrollable()
    .centered()
    .staticBackdrop()
    .noKeyboard()
    .hideClose()
    .addButton(\'Cancel\', \'secondary\', {\'data-so-dismiss\': \'modal\'})
    .addButton(\'Submit\', \'primary\', {type: \'submit\'});

document.body.insertAdjacentHTML(\'beforeend\', advancedModal.render());

// Programmatic control
modal.show();   // Show modal
modal.hide();   // Hide modal
modal.toggle(); // Toggle visibility

// Dynamic updates
modal.setTitle(\'New Title\');
modal.setBody(\'<p>New content</p>\');
modal.addButtonDynamic(\'Delete\', \'danger\');
modal.clearButtons();

// Event handling
modal.onShow((e) => {
    console.log(\'Modal is about to show\');
});

modal.onShown((e) => {
    console.log(\'Modal is now visible\');
});

modal.onHide((e) => {
    console.log(\'Modal is about to hide\');
});

modal.onHidden((e) => {
    console.log(\'Modal is now hidden\');
});

modal.onDismiss((e) => {
    console.log(\'Modal was dismissed\');
});

// Getters
const title = modal.getTitle();
const body = modal.getBody();
const size = modal.getSize();
const isScrollable = modal.isScrollable();
const isVisible = modal.isVisible();', 'javascript');

                $configContent = so_code_block('// Configuration array format (works in both PHP and JS)
const config = {
    type: \'modal\',
    id: \'my-modal\',
    title: \'Modal Title\',
    body: \'<p>Modal content goes here.</p>\',
    size: \'md\',  // sm, md, lg, xl, fullscreen
    scrollable: false,
    centered: false,
    staticBackdrop: false,
    keyboard: true,
    focus: true,
    hideClose: false,
    buttons: [
        {
            text: \'Close\',
            variant: \'secondary\',
            dismiss: true
        },
        {
            text: \'Save Changes\',
            variant: \'primary\',
            attrs: {
                \'data-action\': \'save\'
            }
        }
    ],
    fade: true,
    attrs: {
        \'aria-labelledby\': \'my-modal-label\'
    }
};

// PHP: Create from config
$modal = UiEngine::fromConfig($config);

// JavaScript: Create from config
const modal = UiEngine.fromConfig(config);

// Export to config
const exportedConfig = modal.toConfig();  // JS
$exportedConfig = $modal->toArray();      // PHP', 'javascript');

                echo so_tabs('uiengine-tabs', [
                    [
                        'id' => 'php-usage',
                        'label' => 'PHP (Server-side)',
                        'active' => true,
                        'content' => $phpContent
                    ],
                    [
                        'id' => 'js-usage',
                        'label' => 'JavaScript (Client-side)',
                        'content' => $jsContent
                    ],
                    [
                        'id' => 'config-usage',
                        'label' => 'Configuration',
                        'content' => $configContent
                    ]
                ]);
                ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4" id="api-reference">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete API reference for all Modal methods. All methods support chaining and are available in both PHP and JavaScript.</p>

                <!-- Tab Navigation -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-content-methods" aria-selected="true" aria-controls="api-content-methods">Content Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-size-behavior" aria-selected="false" aria-controls="api-size-behavior">Size & Behavior</button>
                    <button class="so-tab" role="tab" data-so-target="#api-dynamic-updates" aria-selected="false" aria-controls="api-dynamic-updates">Dynamic Updates</button>
                    <button class="so-tab" role="tab" data-so-target="#api-state-actions" aria-selected="false" aria-controls="api-state-actions">State & Actions</button>
                    <button class="so-tab" role="tab" data-so-target="#api-events" aria-selected="false" aria-controls="api-events">Events</button>
                    <button class="so-tab" role="tab" data-so-target="#api-inherited" aria-selected="false" aria-controls="api-inherited">Inherited</button>
                </div>

                <div class="so-tab-content">
                <!-- Content Methods -->
                <div class="so-tab-pane so-fade so-show so-active" id="api-content-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>title(string $title)</code></td>
                                    <td>Set the modal title. Renders as <code>&lt;h5&gt;</code> with class <code>.so-modal-title</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>body(string $content)</code></td>
                                    <td>Set the modal body content. Can include HTML.</td>
                                </tr>
                                <tr>
                                    <td><code>addButton(string $text, string $variant = 'primary', array $attrs = [])</code></td>
                                    <td>Add a custom button to the footer. Variant: <code>primary</code>, <code>secondary</code>, <code>success</code>, <code>danger</code>, <code>warning</code>, <code>info</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>closeButton(string $text = 'Close')</code></td>
                                    <td>Add a close button with <code>data-dismiss="modal"</code> attribute. Defaults to secondary variant.</td>
                                </tr>
                                <tr>
                                    <td><code>saveButton(string $text = 'Save Changes')</code></td>
                                    <td>Add a primary save button to the footer.</td>
                                </tr>
                                <tr>
                                    <td><code>getTitle()</code></td>
                                    <td>Get the current modal title.</td>
                                </tr>
                                <tr>
                                    <td><code>getBody()</code></td>
                                    <td>Get the current modal body content.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
$modal = UiEngine::modal(\'my-modal\')
    ->title(\'Edit Profile\')
    ->body(\'<form>...</form>\')
    ->closeButton(\'Cancel\')
    ->saveButton(\'Update Profile\')
    ->addButton(\'Delete Account\', \'danger\', [\'data-action\' => \'delete\']);

$title = $modal->getTitle();  // \'Edit Profile\'
$body = $modal->getBody();    // \'<form>...</form>\'

// JavaScript
const modal = UiEngine.modal(\'my-modal\')
    .title(\'Edit Profile\')
    .body(\'<form>...</form>\')
    .closeButton(\'Cancel\')
    .saveButton(\'Update Profile\')
    .addButton(\'Delete Account\', \'danger\', {\'data-action\': \'delete\'});

const title = modal.getTitle();  // \'Edit Profile\'
const body = modal.getBody();    // \'<form>...</form>\'', 'php') ?>
                </div>

                <!-- Size & Behavior -->
                <div class="so-tab-pane so-fade" id="api-size-behavior" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>size(string $size)</code></td>
                                    <td>Set modal size: <code>sm</code>, <code>md</code> (default), <code>lg</code>, <code>xl</code>, <code>fullscreen</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>small()</code></td>
                                    <td>Set modal to small size. Alias for <code>size('sm')</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>large()</code></td>
                                    <td>Set modal to large size. Alias for <code>size('lg')</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>extraLarge()</code></td>
                                    <td>Set modal to extra large size. Alias for <code>size('xl')</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>fullscreen()</code></td>
                                    <td>Set modal to fullscreen. Adds <code>.so-modal-fullscreen</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>scrollable(bool $scrollable = true)</code></td>
                                    <td>Enable scrollable modal body. Adds <code>.so-modal-dialog-scrollable</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>centered(bool $centered = true)</code></td>
                                    <td>Vertically center modal. Adds <code>.so-modal-dialog-centered</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>staticBackdrop(bool $static = true)</code></td>
                                    <td>Prevent closing by clicking backdrop. Sets <code>data-so-backdrop="static"</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>hideClose(bool $hide = true)</code></td>
                                    <td>Hide the close button (×) in the header.</td>
                                </tr>
                                <tr>
                                    <td><code>noKeyboard(bool $noKeyboard = true)</code></td>
                                    <td>Disable closing with Escape key. Sets <code>data-so-keyboard="false"</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>noFocus(bool $noFocus = true)</code></td>
                                    <td>Disable auto-focus on modal open. Sets <code>data-so-focus="false"</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>getSize()</code></td>
                                    <td>Get current modal size.</td>
                                </tr>
                                <tr>
                                    <td><code>isScrollable()</code></td>
                                    <td>Check if modal is scrollable.</td>
                                </tr>
                                <tr>
                                    <td><code>isCentered()</code></td>
                                    <td>Check if modal is centered.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
$modal = UiEngine::modal(\'config-modal\')
    ->title(\'Settings\')
    ->body(\'<form>...</form>\')
    ->large()
    ->scrollable()
    ->centered()
    ->staticBackdrop()
    ->noKeyboard()
    ->hideClose();

$size = $modal->getSize();           // \'lg\'
$isScrollable = $modal->isScrollable();  // true
$isCentered = $modal->isCentered();      // true

// JavaScript
const modal = UiEngine.modal(\'config-modal\')
    .title(\'Settings\')
    .body(\'<form>...</form>\')
    .large()
    .scrollable()
    .centered()
    .staticBackdrop()
    .noKeyboard()
    .hideClose();

const size = modal.getSize();           // \'lg\'
const isScrollable = modal.isScrollable();  // true
const isCentered = modal.isCentered();      // true', 'php') ?>
                </div>

                <!-- Dynamic Updates -->
                <div class="so-tab-pane so-fade" id="api-dynamic-updates" role="tabpanel">
                    <p class="so-text-muted so-mb-3"><strong>JavaScript Only:</strong> Methods for dynamically updating modal content after rendering.</p>

                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>setTitle(string $title)</code></td>
                                    <td>Dynamically update modal title. Fires <code>so:modal:titleChanged</code> event.</td>
                                </tr>
                                <tr>
                                    <td><code>setBody(string $content)</code></td>
                                    <td>Dynamically update modal body content. Fires <code>so:modal:bodyChanged</code> event.</td>
                                </tr>
                                <tr>
                                    <td><code>addButtonDynamic(string $text, string $variant, object $attrs)</code></td>
                                    <td>Add a button to the footer after rendering. Fires <code>so:modal:buttonAdded</code> event.</td>
                                </tr>
                                <tr>
                                    <td><code>clearButtons()</code></td>
                                    <td>Remove all buttons from the footer. Fires <code>so:modal:buttonsCleared</code> event.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// JavaScript - Dynamic updates
const modal = UiEngine.modal(\'dynamic-modal\')
    .title(\'Initial Title\')
    .body(\'<p>Initial content</p>\')
    .closeButton();

document.body.insertAdjacentHTML(\'beforeend\', modal.render());

// Update title
modal.setTitle(\'Updated Title\');

// Update body content
modal.setBody(\'<p>New content loaded via AJAX</p>\');

// Add button dynamically
modal.addButtonDynamic(\'Confirm\', \'primary\', {\'data-action\': \'confirm\'});

// Clear all buttons
modal.clearButtons();

// Re-add new buttons
modal.addButtonDynamic(\'Cancel\', \'secondary\', {\'data-so-dismiss\': \'modal\'});
modal.addButtonDynamic(\'Delete\', \'danger\', {\'data-action\': \'delete\'});', 'javascript') ?>
                </div>

                <!-- State & Actions -->
                <div class="so-tab-pane so-fade" id="api-state-actions" role="tabpanel">
                    <p class="so-text-muted so-mb-3"><strong>JavaScript Only:</strong> Methods for controlling modal state and visibility.</p>

                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>show()</code></td>
                                    <td>Show the modal. Fires <code>so:modal:show</code> and <code>so:modal:shown</code> events.</td>
                                </tr>
                                <tr>
                                    <td><code>hide()</code></td>
                                    <td>Hide the modal. Fires <code>so:modal:hide</code> and <code>so:modal:hidden</code> events.</td>
                                </tr>
                                <tr>
                                    <td><code>toggle()</code></td>
                                    <td>Toggle modal visibility. Shows if hidden, hides if shown.</td>
                                </tr>
                                <tr>
                                    <td><code>dispose()</code></td>
                                    <td>Destroy the modal instance and remove event listeners. Fires <code>so:modal:disposed</code> event.</td>
                                </tr>
                                <tr>
                                    <td><code>isVisible()</code></td>
                                    <td>Check if modal is currently visible. Returns boolean.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// JavaScript - State and actions
const modal = UiEngine.modal(\'action-modal\')
    .title(\'Action Modal\')
    .body(\'<p>Content</p>\')
    .closeButton();

document.body.insertAdjacentHTML(\'beforeend\', modal.render());

// Show modal
modal.show();

// Check visibility
if (modal.isVisible()) {
    console.log(\'Modal is visible\');
}

// Hide modal after 3 seconds
setTimeout(() => {
    modal.hide();
}, 3000);

// Toggle modal
modal.toggle();

// Dispose modal
modal.dispose();', 'javascript') ?>
                </div>

                <!-- Events -->
                <div class="so-tab-pane so-fade" id="api-events" role="tabpanel">
                    <p class="so-text-muted so-mb-3"><strong>JavaScript Only:</strong> Event handling methods for modal lifecycle and interactions.</p>

                    <div class="so-table-responsive so-mb-4">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>onShow(callback)</code></td>
                                    <td>Listen for show event (before modal is shown). Can prevent with <code>e.preventDefault()</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>onShown(callback)</code></td>
                                    <td>Listen for shown event (after modal is fully visible with transitions complete).</td>
                                </tr>
                                <tr>
                                    <td><code>onHide(callback)</code></td>
                                    <td>Listen for hide event (before modal is hidden). Can prevent with <code>e.preventDefault()</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>onHidden(callback)</code></td>
                                    <td>Listen for hidden event (after modal is fully hidden with transitions complete).</td>
                                </tr>
                                <tr>
                                    <td><code>onDismiss(callback)</code></td>
                                    <td>Listen for dismiss action (when user clicks close button or backdrop).</td>
                                </tr>
                                <tr>
                                    <td><code>on(eventName, callback)</code></td>
                                    <td>Generic event listener (inherited from Element).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="so-mb-3">Custom Events (so: prefixed)</h5>
                    <div class="so-table-responsive so-mb-4">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Event</th>
                                    <th style="width: 65%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so:modal:show</code></td>
                                    <td>Fired before modal is shown. Cancelable. <code>detail: {modal}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:shown</code></td>
                                    <td>Fired after modal is fully shown. <code>detail: {modal}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:hide</code></td>
                                    <td>Fired before modal is hidden. Cancelable. <code>detail: {modal}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:hidden</code></td>
                                    <td>Fired after modal is fully hidden. <code>detail: {modal}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:dismiss</code></td>
                                    <td>Fired when modal is dismissed by user. <code>detail: {modal, trigger}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:titleChanged</code></td>
                                    <td>Fired when title is updated. <code>detail: {title}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:bodyChanged</code></td>
                                    <td>Fired when body content is updated. <code>detail: {body}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:buttonAdded</code></td>
                                    <td>Fired when button is added. <code>detail: {button}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:buttonsCleared</code></td>
                                    <td>Fired when all buttons are cleared. <code>detail: {modal}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:modal:disposed</code></td>
                                    <td>Fired when modal is disposed. <code>detail: {modal}</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// JavaScript - Event handling
const modal = UiEngine.modal(\'event-modal\')
    .title(\'Event Demo\')
    .body(\'<p>Content</p>\')
    .closeButton();

// Before modal is shown
modal.onShow((e) => {
    console.log(\'About to show modal\');
    // Prevent showing if needed
    // e.preventDefault();
});

// After modal is fully visible
modal.onShown((e) => {
    console.log(\'Modal is now visible\');
    // Focus first input, start animation, etc.
});

// Before modal is hidden
modal.onHide((e) => {
    console.log(\'About to hide modal\');
    // Show confirmation dialog
    // e.preventDefault();
});

// After modal is fully hidden
modal.onHidden((e) => {
    console.log(\'Modal is now hidden\');
    // Clean up, reset form, etc.
});

// When user dismisses modal
modal.onDismiss((e) => {
    console.log(\'Modal dismissed\', e.detail.trigger);
});

// Listen for custom events
modal.on(\'so:modal:titleChanged\', (e) => {
    console.log(\'Title changed to:\', e.detail.title);
});

modal.on(\'so:modal:bodyChanged\', (e) => {
    console.log(\'Body changed\');
});

document.body.insertAdjacentHTML(\'beforeend\', modal.render());', 'javascript') ?>
                </div>

                <!-- Inherited Methods -->
                <div class="so-tab-pane so-fade" id="api-inherited" role="tabpanel">
                    <p class="so-text-muted so-mb-3">Modal inherits these methods from the base ContainerElement class:</p>

                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>id(string $id)</code></td>
                                    <td>Set element ID attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>addClass(string $class)</code></td>
                                    <td>Add CSS class(es). Space-separated for multiple.</td>
                                </tr>
                                <tr>
                                    <td><code>removeClass(string $class)</code></td>
                                    <td>Remove CSS class(es).</td>
                                </tr>
                                <tr>
                                    <td><code>attr(string $name, mixed $value)</code></td>
                                    <td>Set HTML attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>data(string $key, mixed $value)</code></td>
                                    <td>Set data attribute (auto-prefixes with <code>data-so-</code>).</td>
                                </tr>
                                <tr>
                                    <td><code>style(string $property, string $value)</code></td>
                                    <td>Set inline CSS style property.</td>
                                </tr>
                                <tr>
                                    <td><code>render()</code></td>
                                    <td><strong>JavaScript:</strong> Return rendered HTML string.</td>
                                </tr>
                                <tr>
                                    <td><code>__toString()</code></td>
                                    <td><strong>PHP:</strong> Automatically called when echoing.</td>
                                </tr>
                                <tr>
                                    <td><code>toArray() / toConfig()</code></td>
                                    <td>Export element configuration.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP - Using inherited methods
$modal = UiEngine::modal(\'custom-modal\')
    ->title(\'Custom Modal\')
    ->body(\'<p>Content</p>\')
    ->id(\'my-custom-modal\')
    ->addClass(\'custom-class theme-dark\')
    ->attr(\'role\', \'dialog\')
    ->attr(\'aria-label\', \'Custom dialog\')
    ->data(\'user-id\', \'12345\')
    ->data(\'action\', \'edit\')
    ->style(\'z-index\', \'9999\');

echo $modal;  // Calls __toString()

// Export configuration
$config = $modal->toArray();

// JavaScript - Using inherited methods
const modal = UiEngine.modal(\'custom-modal\')
    .title(\'Custom Modal\')
    .body(\'<p>Content</p>\')
    .id(\'my-custom-modal\')
    .addClass(\'custom-class theme-dark\')
    .attr(\'role\', \'dialog\')
    .attr(\'aria-label\', \'Custom dialog\')
    .data(\'user-id\', \'12345\')
    .data(\'action\', \'edit\')
    .style(\'z-index\', \'9999\');

const html = modal.render();
document.body.insertAdjacentHTML(\'beforeend\', html);

// Export configuration
const config = modal.toConfig();', 'php') ?>
                </div>
                </div>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4" id="validation">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Modal is primarily a display component, but when used with forms, you should validate form data before processing.
                </p>

                <div class="so-alert so-alert-info so-mb-4">
                    <div class="so-alert-icon">
                        <span class="material-icons">info</span>
                    </div>
                    <div class="so-alert-content">
                        <strong>Note:</strong> Modals themselves don't require validation, but the forms and content within them should be validated appropriately.
                    </div>
                </div>

                <h5 class="so-mb-3">Proper vs Improper Usage</h5>
                <?= so_code_block('<?php
// ✓ PROPER: Modal with validated form submission
use Core\Validation\Validator;
use Core\UiEngine\UiEngine;

function createUserModal(array $data = []): string
{
    $formContent = \'
        <form id="user-form" method="POST">
            <div class="so-form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="so-form-control" required>
            </div>
            <div class="so-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="so-form-control" required>
            </div>
        </form>
    \';

    $modal = UiEngine::modal(\'user-modal\')
        ->title(\'Create User\')
        ->body($formContent)
        ->large()
        ->closeButton(\'Cancel\')
        ->addButton(\'Create User\', \'primary\', [\'form\' => \'user-form\', \'type\' => \'submit\']);

    return (string) $modal;
}

// Server-side validation
function handleUserSubmission(array $data): array
{
    $validator = new Validator($data, [
        \'name\' => \'required|string|min:2|max:100\',
        \'email\' => \'required|email|unique:users,email\',
    ]);

    if ($validator->fails()) {
        return [
            \'success\' => false,
            \'errors\' => $validator->errors()
        ];
    }

    // Process valid data
    return [\'success\' => true];
}

// ✗ IMPROPER: No validation on form data
function improperUserModal(): string
{
    $modal = UiEngine::modal(\'user-modal\')
        ->title(\'Create User\')
        ->body(\'<input type="text" name="name">\')  // No validation
        ->saveButton();  // Submits without checks

    return (string) $modal;
}', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Modal Configuration Validation</h5>
                <?= so_code_block('<?php
// Validate modal configuration before rendering
function createValidatedModal(array $config): ?string
{
    $validator = new Validator($config, [
        \'id\' => \'required|string|regex:/^[a-zA-Z0-9_-]+$/\',
        \'title\' => \'required|string|max:200\',
        \'body\' => \'required|string\',
        \'size\' => \'nullable|in:sm,md,lg,xl,fullscreen\',
        \'scrollable\' => \'nullable|boolean\',
        \'centered\' => \'nullable|boolean\',
        \'staticBackdrop\' => \'nullable|boolean\',
    ]);

    if ($validator->fails()) {
        error_log(\'Invalid modal config: \' . json_encode($validator->errors()));
        return null;
    }

    $modal = UiEngine::modal($config[\'id\'])
        ->title($config[\'title\'])
        ->body($config[\'body\']);

    // Apply optional configurations
    if (!empty($config[\'size\'])) {
        $modal->size($config[\'size\']);
    }

    if (!empty($config[\'scrollable\'])) {
        $modal->scrollable();
    }

    if (!empty($config[\'centered\'])) {
        $modal->centered();
    }

    if (!empty($config[\'staticBackdrop\'])) {
        $modal->staticBackdrop();
    }

    return (string) $modal;
}

// Usage
$modalConfig = [
    \'id\' => \'settings-modal\',
    \'title\' => \'Settings\',
    \'body\' => \'<form>...</form>\',
    \'size\' => \'lg\',
    \'scrollable\' => true,
    \'centered\' => true
];

$html = createValidatedModal($modalConfig);', 'php') ?>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4" id="error-handling">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Common error scenarios and how to handle them when working with Modal.
                </p>

                <h5 class="so-mb-3">Common Scenarios</h5>
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Scenario</th>
                                <th style="width: 35%;">Issue</th>
                                <th style="width: 40%;">Solution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Missing ID</td>
                                <td>Modal rendered without unique ID</td>
                                <td>Always provide unique ID to constructor</td>
                            </tr>
                            <tr>
                                <td>Duplicate IDs</td>
                                <td>Multiple modals with same ID</td>
                                <td>Use unique identifiers for each modal</td>
                            </tr>
                            <tr>
                                <td>Modal not showing</td>
                                <td>JavaScript not initialized</td>
                                <td>Ensure modal JS is loaded and initialized</td>
                            </tr>
                            <tr>
                                <td>Backdrop not working</td>
                                <td>Backdrop clicks don\'t close modal</td>
                                <td>Check staticBackdrop setting</td>
                            </tr>
                            <tr>
                                <td>Content overflow</td>
                                <td>Content exceeds modal height</td>
                                <td>Use scrollable() method</td>
                            </tr>
                            <tr>
                                <td>Form submission</td>
                                <td>Form submits but modal stays open</td>
                                <td>Manually call hide() after successful submission</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Error Handling Examples</h5>
                <?= so_code_block('<?php
// PHP - Handle missing or invalid data
function renderModal(array $config): string
{
    // Validate required fields
    if (empty($config[\'id\'])) {
        throw new InvalidArgumentException(\'Modal ID is required\');
    }

    if (empty($config[\'title\']) || empty($config[\'body\'])) {
        error_log(\'Missing modal title or body\');
        return \'\'; // Or return default modal
    }

    // Sanitize ID
    $id = preg_replace(\'/[^a-zA-Z0-9_-]/\', \'\', $config[\'id\']);
    if ($id !== $config[\'id\']) {
        error_log(\'Invalid modal ID, sanitized to: \' . $id);
    }

    // Validate size
    $validSizes = [\'sm\', \'md\', \'lg\', \'xl\', \'fullscreen\'];
    $size = !empty($config[\'size\']) && in_array($config[\'size\'], $validSizes)
        ? $config[\'size\']
        : \'md\';

    try {
        $modal = UiEngine::modal($id)
            ->title(htmlspecialchars($config[\'title\'], ENT_QUOTES, \'UTF-8\'))
            ->body($config[\'body\'])  // Assumes pre-sanitized HTML
            ->size($size);

        if (!empty($config[\'scrollable\'])) {
            $modal->scrollable();
        }

        if (!empty($config[\'centered\'])) {
            $modal->centered();
        }

        $modal->closeButton();

        return (string) $modal;
    } catch (Exception $e) {
        error_log(\'Error creating modal: \' . $e->getMessage());
        return \'\';
    }
}

// Usage with error handling
try {
    $modalConfig = [
        \'id\' => \'user-modal\',
        \'title\' => \'Edit User\',
        \'body\' => \'<form>...</form>\',
        \'size\' => \'lg\'
    ];

    $html = renderModal($modalConfig);
    echo $html;
} catch (Exception $e) {
    error_log(\'Failed to render modal: \' . $e->getMessage());
    echo \'<div class="so-alert so-alert-danger">Unable to display modal</div>\';
}', 'php') ?>

                <hr class="so-my-4">

                <?= so_code_block('// JavaScript - Error handling with modals
function createModal(config) {
    // Validate config
    if (!config.id) {
        console.error(\'Modal ID is required\');
        return null;
    }

    if (!config.title || !config.body) {
        console.warn(\'Missing modal title or body\');
        config.title = config.title || \'Notice\';
        config.body = config.body || \'No content available\';
    }

    try {
        const modal = UiEngine.modal(config.id)
            .title(config.title)
            .body(config.body);

        // Apply optional configurations safely
        if (config.size) {
            const validSizes = [\'sm\', \'md\', \'lg\', \'xl\', \'fullscreen\'];
            if (validSizes.includes(config.size)) {
                modal.size(config.size);
            } else {
                console.warn(`Invalid modal size: ${config.size}, using default`);
            }
        }

        if (config.scrollable) modal.scrollable();
        if (config.centered) modal.centered();

        modal.closeButton();

        // Handle show errors
        modal.onShow((e) => {
            try {
                // Pre-show validation
                console.log(\'Modal showing\');
            } catch (error) {
                console.error(\'Error in onShow:\', error);
                e.preventDefault();
            }
        });

        // Handle hide errors
        modal.onHide((e) => {
            try {
                // Pre-hide cleanup
                console.log(\'Modal hiding\');
            } catch (error) {
                console.error(\'Error in onHide:\', error);
            }
        });

        return modal;
    } catch (error) {
        console.error(\'Error creating modal:\', error);
        return null;
    }
}

// Usage with error handling
try {
    const modalConfig = {
        id: \'user-modal\',
        title: \'Edit User\',
        body: \'<form>...</form>\',
        size: \'lg\',
        scrollable: true
    };

    const modal = createModal(modalConfig);

    if (modal) {
        document.body.insertAdjacentHTML(\'beforeend\', modal.render());
        modal.show();
    } else {
        throw new Error(\'Failed to create modal\');
    }
} catch (error) {
    console.error(\'Modal error:\', error);
    alert(\'Unable to display modal. Please try again.\');
}

// Handle form submission errors
document.addEventListener(\'submit\', async (e) => {
    if (e.target.closest(\'#user-modal\')) {
        e.preventDefault();

        try {
            const formData = new FormData(e.target);
            const response = await fetch(\'/api/users\', {
                method: \'POST\',
                body: formData
            });

            if (!response.ok) {
                throw new Error(\'Submission failed\');
            }

            const result = await response.json();

            if (result.success) {
                // Close modal on success
                const modal = UiEngine.modal(\'user-modal\');
                modal.hide();
            } else {
                // Show errors in modal
                const modal = UiEngine.modal(\'user-modal\');
                modal.setBody(`<div class="so-alert so-alert-danger">${result.message}</div>`);
            }
        } catch (error) {
            console.error(\'Form submission error:\', error);
            alert(\'An error occurred. Please try again.\');
        }
    }
});', 'javascript') ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Pass Modal configuration from PHP to JavaScript for client-side hydration and interactivity.
                </p>

                <h5 class="so-mb-3">Method 1: Data Attributes</h5>
                <?= so_code_block('<?php
// PHP - Export config to data attribute
$modal = UiEngine::modal(\'notification-modal\')
    ->title(\'Notification\')
    ->body(\'<p>You have a new message.</p>\')
    ->small()
    ->centered()
    ->closeButton();

$config = $modal->toArray();
?>

<div id="modal-container" data-modal-config=\'<?= json_encode($config) ?>\'></div>

<script type="module">
import { UiEngine } from \'./ui-engine/UiEngine.js\';

// JavaScript - Hydrate from config
const container = document.getElementById(\'modal-container\');
const config = JSON.parse(container.dataset.modalConfig);

const modal = UiEngine.fromConfig(config);
document.body.insertAdjacentHTML(\'beforeend\', modal.render());

// Add interactivity
modal.onShown(() => {
    console.log(\'Modal is visible\');
});

// Show modal
modal.show();
</script>', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Method 2: Inline Script</h5>
                <?= so_code_block('<?php
$modal = UiEngine::modal(\'confirm-modal\')
    ->title(\'Confirm Action\')
    ->body(\'<p>Are you sure you want to delete this item?</p>\')
    ->centered()
    ->closeButton(\'Cancel\')
    ->addButton(\'Delete\', \'danger\', [\'data-action\' => \'delete\']);

$config = $modal->toArray();
?>

<div id="modal-target"></div>

<script type="module">
import { UiEngine } from \'./ui-engine/UiEngine.js\';

const config = <?= json_encode($config) ?>;
const modal = UiEngine.fromConfig(config);

document.body.insertAdjacentHTML(\'beforeend\', modal.render());

// Add event handlers
modal.onShown(() => {
    console.log(\'Confirm modal shown\');
});

// Handle delete action
document.addEventListener(\'click\', (e) => {
    if (e.target.dataset.action === \'delete\') {
        console.log(\'Delete confirmed\');
        modal.hide();
    }
});
</script>', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Method 3: API Endpoint</h5>
                <?= so_code_block('// PHP - API endpoint returning modal config
Route::get(\'/api/modal/user-profile\', function() {
    $user = Auth::user();

    $modal = UiEngine::modal(\'user-profile-modal\')
        ->title(\'User Profile\')
        ->body(view(\'modals.user-profile\', [\'user\' => $user])->render())
        ->large()
        ->scrollable()
        ->closeButton()
        ->addButton(\'Save Changes\', \'primary\', [\'data-action\' => \'save\']);

    return response()->json([
        \'modal\' => $modal->toArray()
    ]);
});', 'php') ?>

                <?= so_code_block('// JavaScript - Fetch and render
import { UiEngine } from \'./ui-engine/UiEngine.js\';

async function loadUserProfileModal() {
    try {
        const response = await fetch(\'/api/modal/user-profile\');
        const data = await response.json();

        const modal = UiEngine.fromConfig(data.modal);
        document.body.insertAdjacentHTML(\'beforeend\', modal.render());

        // Add event handlers
        modal.onShown(() => {
            console.log(\'User profile modal shown\');
        });

        modal.onHidden(() => {
            console.log(\'User profile modal hidden\');
        });

        // Handle save action
        document.addEventListener(\'click\', (e) => {
            if (e.target.dataset.action === \'save\') {
                saveUserProfile(modal);
            }
        });

        // Show modal
        modal.show();
    } catch (error) {
        console.error(\'Failed to load modal:\', error);
    }
}

async function saveUserProfile(modal) {
    // Save logic here
    const formData = new FormData(document.querySelector(\'#user-profile-modal form\'));

    try {
        const response = await fetch(\'/api/user/profile\', {
            method: \'POST\',
            body: formData
        });

        if (response.ok) {
            modal.hide();
            alert(\'Profile saved successfully\');
        }
    } catch (error) {
        console.error(\'Save failed:\', error);
    }
}

// Load modal when needed
loadUserProfileModal();', 'javascript') ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete reference of CSS classes used by Modal.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Class</th>
                                <th style="width: 60%;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-modal</code></td>
                                <td>Base modal container (backdrop layer)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-dialog</code></td>
                                <td>Modal dialog box container</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-content</code></td>
                                <td>Modal content wrapper (header, body, footer)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-header</code></td>
                                <td>Modal header section</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-title</code></td>
                                <td>Modal title (h5 by default)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-body</code></td>
                                <td>Modal body content area</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-footer</code></td>
                                <td>Modal footer with action buttons</td>
                            </tr>
                            <tr>
                                <td><code>.so-btn-close</code></td>
                                <td>Close button (×) in header</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-sm</code></td>
                                <td>Small modal (max-width: 300px)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-lg</code></td>
                                <td>Large modal (max-width: 800px)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-xl</code></td>
                                <td>Extra large modal (max-width: 1140px)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-fullscreen</code></td>
                                <td>Fullscreen modal (100% width and height)</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-dialog-scrollable</code></td>
                                <td>Enable scrollable body content</td>
                            </tr>
                            <tr>
                                <td><code>.so-modal-dialog-centered</code></td>
                                <td>Vertically center modal in viewport</td>
                            </tr>
                            <tr>
                                <td><code>.so-fade</code></td>
                                <td>Fade transition effect</td>
                            </tr>
                            <tr>
                                <td><code>.so-show</code></td>
                                <td>Applied when modal is visible</td>
                            </tr>
                            <tr>
                                <td><code>[data-so-toggle="modal"]</code></td>
                                <td>Trigger button attribute</td>
                            </tr>
                            <tr>
                                <td><code>[data-so-target="#id"]</code></td>
                                <td>Target modal ID attribute</td>
                            </tr>
                            <tr>
                                <td><code>[data-dismiss="modal"]</code></td>
                                <td>Dismiss/close modal attribute</td>
                            </tr>
                            <tr>
                                <td><code>[data-so-backdrop="static"]</code></td>
                                <td>Prevent backdrop click closing</td>
                            </tr>
                            <tr>
                                <td><code>[data-so-keyboard="false"]</code></td>
                                <td>Disable Escape key closing</td>
                            </tr>
                            <tr>
                                <td><code>[data-so-focus="false"]</code></td>
                                <td>Disable auto-focus on open</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Demo Link -->
        <div class="so-card so-mb-4" id="demo-link">
            <div class="so-card-header">
                <h3 class="so-card-title">Additional Examples</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    For more CSS-based examples without UiEngine, visit the full demo page:
                </p>
                <a href="/demo/elements/modal" class="so-btn so-btn-primary">
                    <span class="material-icons so-me-2">open_in_new</span>
                    View Full CSS Demo
                </a>
            </div>
        </div>

    </div>
</main>

<script>
// Modal helper functions
function createBackdrop() {
    if (document.querySelector('.so-modal-backdrop')) return;

    const backdrop = document.createElement('div');
    backdrop.className = 'so-modal-backdrop so-show';
    document.body.appendChild(backdrop);
    document.body.classList.add('so-modal-open');

    backdrop.addEventListener('click', function() {
        const openModal = document.querySelector('.so-modal.so-show');
        if (openModal && !openModal.hasAttribute('data-so-backdrop')) {
            closeModal(openModal.id);
        }
    });
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('so-show');
        modal.setAttribute('aria-hidden', 'true');
    }

    const backdrop = document.querySelector('.so-modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }

    document.body.classList.remove('so-modal-open');
}

// Handle all data-dismiss="modal" clicks
document.addEventListener('click', function(e) {
    if (e.target.closest('[data-dismiss="modal"]')) {
        const modal = e.target.closest('.so-modal');
        if (modal) {
            closeModal(modal.id);
        }
    }
});

// Handle escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const openModal = document.querySelector('.so-modal.so-show');
        if (openModal && openModal.getAttribute('data-so-keyboard') !== 'false') {
            closeModal(openModal.id);
        }
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
