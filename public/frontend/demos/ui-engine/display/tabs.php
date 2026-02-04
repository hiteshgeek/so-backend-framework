<?php
/**
 * SixOrbit UI Engine - Tabs Element Demo
 */

$pageTitle = 'Tabs - UI Engine';
$pageDescription = 'Tabbed navigation for organizing content';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Tabs</h1>
            <p class="so-page-subtitle">Tabbed navigation for organizing content into separate, switchable panels.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Tabs (Underline) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Tabs (Underline)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Default underline style tabs with content panels.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-tabs" role="tablist" data-so-tabs>
                        <button class="so-tab so-active" role="tab" data-so-target="#demo-home">Home</button>
                        <button class="so-tab" role="tab" data-so-target="#demo-profile">Profile</button>
                        <button class="so-tab" role="tab" data-so-target="#demo-settings">Settings</button>
                        <button class="so-tab so-disabled" role="tab">Disabled</button>
                    </div>
                    <div class="so-tab-content">
                        <div class="so-tab-pane so-fade so-show so-active" id="demo-home" role="tabpanel">
                            <p>This is the home tab content. Default underline style shows an indicator below the active tab.</p>
                        </div>
                        <div class="so-tab-pane so-fade" id="demo-profile" role="tabpanel">
                            <p>This is the profile tab content with user information.</p>
                        </div>
                        <div class="so-tab-pane so-fade" id="demo-settings" role="tabpanel">
                            <p>This is the settings tab content for configuration options.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-tabs', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$tabs = UiEngine::tabs('main-tabs')
    ->tab('Home', 'This is the home tab content.')
    ->tab('Profile', 'This is the profile tab content.')
    ->tab('Settings', 'This is the settings tab content.')
    ->tab('Disabled', 'Disabled content', null, true);

echo \$tabs->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const tabs = UiEngine.tabs('main-tabs')
    .tab('Home', 'This is the home tab content.')
    .tab('Profile', 'This is the profile tab content.')
    .tab('Settings', 'This is the settings tab content.')
    .tab('Disabled', 'Disabled content', null, true);

document.getElementById('container').innerHTML = tabs.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-tabs" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">Home</button>
    <button class="so-tab" role="tab" data-so-target="#panel2">Profile</button>
    <button class="so-tab" role="tab" data-so-target="#panel3">Settings</button>
    <button class="so-tab so-disabled" role="tab">Disabled</button>
</div>
<div class="so-tab-content">
    <div class="so-tab-pane so-fade so-show so-active" id="panel1" role="tabpanel">...</div>
    <div class="so-tab-pane so-fade" id="panel2" role="tabpanel">...</div>
    <div class="so-tab-pane so-fade" id="panel3" role="tabpanel">...</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tab Styles -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Tab Styles</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different visual styles for tabs: pills, boxed, ghost, and bordered.</p>

                <!-- Pills -->
                <h5 class="so-mb-3">Pills Style</h5>
                <div class="so-mb-4">
                    <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
                        <button class="so-tab so-active" role="tab" data-so-target="#pills-1">Overview</button>
                        <button class="so-tab" role="tab" data-so-target="#pills-2">Features</button>
                        <button class="so-tab" role="tab" data-so-target="#pills-3">Pricing</button>
                    </div>
                    <div class="so-tab-content">
                        <div class="so-tab-pane so-fade so-show so-active" id="pills-1" role="tabpanel">Pills have a rounded background on the active tab.</div>
                        <div class="so-tab-pane so-fade" id="pills-2" role="tabpanel">Features content.</div>
                        <div class="so-tab-pane so-fade" id="pills-3" role="tabpanel">Pricing content.</div>
                    </div>
                </div>

                <!-- Boxed -->
                <h5 class="so-mb-3">Boxed/Segmented Style</h5>
                <div class="so-mb-4">
                    <div class="so-tabs so-tabs-boxed" role="tablist" data-so-tabs>
                        <button class="so-tab so-active" role="tab" data-so-target="#boxed-1">Day</button>
                        <button class="so-tab" role="tab" data-so-target="#boxed-2">Week</button>
                        <button class="so-tab" role="tab" data-so-target="#boxed-3">Month</button>
                    </div>
                    <div class="so-tab-content">
                        <div class="so-tab-pane so-fade so-show so-active" id="boxed-1" role="tabpanel">Boxed tabs look like a segmented control.</div>
                        <div class="so-tab-pane so-fade" id="boxed-2" role="tabpanel">Weekly view.</div>
                        <div class="so-tab-pane so-fade" id="boxed-3" role="tabpanel">Monthly view.</div>
                    </div>
                </div>

                <!-- Ghost -->
                <h5 class="so-mb-3">Ghost Style</h5>
                <div class="so-mb-4">
                    <div class="so-tabs so-tabs-ghost" role="tablist" data-so-tabs>
                        <button class="so-tab so-active" role="tab" data-so-target="#ghost-1">All</button>
                        <button class="so-tab" role="tab" data-so-target="#ghost-2">Active</button>
                        <button class="so-tab" role="tab" data-so-target="#ghost-3">Completed</button>
                    </div>
                    <div class="so-tab-content">
                        <div class="so-tab-pane so-fade so-show so-active" id="ghost-1" role="tabpanel">Ghost tabs have minimal styling.</div>
                        <div class="so-tab-pane so-fade" id="ghost-2" role="tabpanel">Active items.</div>
                        <div class="so-tab-pane so-fade" id="ghost-3" role="tabpanel">Completed items.</div>
                    </div>
                </div>

                <!-- Bordered -->
                <h5 class="so-mb-3">Bordered Style</h5>
                <div class="so-mb-4">
                    <div class="so-tabs so-tabs-bordered" role="tablist" data-so-tabs>
                        <button class="so-tab so-active" role="tab" data-so-target="#bordered-1">Details</button>
                        <button class="so-tab" role="tab" data-so-target="#bordered-2">Reviews</button>
                        <button class="so-tab" role="tab" data-so-target="#bordered-3">FAQ</button>
                    </div>
                    <div class="so-tab-content">
                        <div class="so-tab-pane so-fade so-show so-active" id="bordered-1" role="tabpanel">Bordered tabs have individual borders.</div>
                        <div class="so-tab-pane so-fade" id="bordered-2" role="tabpanel">Reviews content.</div>
                        <div class="so-tab-pane so-fade" id="bordered-3" role="tabpanel">FAQ content.</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tab-styles', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Pills style
UiEngine::tabs('pills-tabs')
    ->pills()
    ->tab('Overview', 'Overview content')
    ->tab('Features', 'Features content');

// Boxed/Segmented style
UiEngine::tabs('boxed-tabs')
    ->boxed()
    ->tab('Day', 'Daily view')
    ->tab('Week', 'Weekly view');

// Ghost style
UiEngine::tabs('ghost-tabs')
    ->ghost()
    ->tab('All', 'All items')
    ->tab('Active', 'Active items');

// Bordered style
UiEngine::tabs('bordered-tabs')
    ->bordered()
    ->tab('Details', 'Details content')
    ->tab('Reviews', 'Reviews content');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Pills style
UiEngine.tabs('pills-tabs')
    .pills()
    .tab('Overview', 'Overview content')
    .tab('Features', 'Features content');

// Boxed style
UiEngine.tabs('boxed-tabs')
    .boxed()
    .tab('Day', 'Daily view')
    .tab('Week', 'Weekly view');

// Ghost style
UiEngine.tabs('ghost-tabs')
    .ghost()
    .tab('All', 'All items');

// Bordered style
UiEngine.tabs('bordered-tabs')
    .bordered()
    .tab('Details', 'Details content');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Pills -->
<div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>...</div>

<!-- Boxed/Segmented -->
<div class="so-tabs so-tabs-boxed" role="tablist" data-so-tabs>...</div>

<!-- Ghost -->
<div class="so-tabs so-tabs-ghost" role="tablist" data-so-tabs>...</div>

<!-- Bordered -->
<div class="so-tabs so-tabs-bordered" role="tablist" data-so-tabs>...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tab Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Tab Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Small and large size variants for tabs.</p>

                <!-- Small -->
                <h5 class="so-mb-3">Small Tabs</h5>
                <div class="so-tabs so-tabs-pills so-tabs-sm so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Tab 1</button>
                    <button class="so-tab" role="tab">Tab 2</button>
                    <button class="so-tab" role="tab">Tab 3</button>
                </div>

                <!-- Default -->
                <h5 class="so-mb-3">Default Tabs</h5>
                <div class="so-tabs so-tabs-pills so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Tab 1</button>
                    <button class="so-tab" role="tab">Tab 2</button>
                    <button class="so-tab" role="tab">Tab 3</button>
                </div>

                <!-- Large -->
                <h5 class="so-mb-3">Large Tabs</h5>
                <div class="so-tabs so-tabs-pills so-tabs-lg so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Tab 1</button>
                    <button class="so-tab" role="tab">Tab 2</button>
                    <button class="so-tab" role="tab">Tab 3</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tab-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small tabs
UiEngine::tabs('sm-tabs')
    ->pills()
    ->small()  // or ->size('sm')
    ->tab('Tab 1', 'Content 1')
    ->tab('Tab 2', 'Content 2');

// Large tabs
UiEngine::tabs('lg-tabs')
    ->pills()
    ->large()  // or ->size('lg')
    ->tab('Tab 1', 'Content 1')
    ->tab('Tab 2', 'Content 2');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small tabs
UiEngine.tabs('sm-tabs')
    .pills()
    .small()
    .tab('Tab 1', 'Content 1')
    .tab('Tab 2', 'Content 2');

// Large tabs
UiEngine.tabs('lg-tabs')
    .pills()
    .large()
    .tab('Tab 1', 'Content 1');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small -->
<div class="so-tabs so-tabs-pills so-tabs-sm" role="tablist" data-so-tabs>...</div>

<!-- Default -->
<div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>...</div>

<!-- Large -->
<div class="so-tabs so-tabs-pills so-tabs-lg" role="tablist" data-so-tabs>...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Contextual color variants for tabs.</p>

                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4">
                    <div>
                        <h6 class="so-mb-2">Primary</h6>
                        <div class="so-tabs so-tabs-pills so-tabs-primary so-tabs-sm" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab">Active</button>
                            <button class="so-tab" role="tab">Tab 2</button>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Success</h6>
                        <div class="so-tabs so-tabs-pills so-tabs-success so-tabs-sm" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab">Active</button>
                            <button class="so-tab" role="tab">Tab 2</button>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Danger</h6>
                        <div class="so-tabs so-tabs-pills so-tabs-danger so-tabs-sm" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab">Active</button>
                            <button class="so-tab" role="tab">Tab 2</button>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Warning</h6>
                        <div class="so-tabs so-tabs-pills so-tabs-warning so-tabs-sm" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab">Active</button>
                            <button class="so-tab" role="tab">Tab 2</button>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Info</h6>
                        <div class="so-tabs so-tabs-pills so-tabs-info so-tabs-sm" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab">Active</button>
                            <button class="so-tab" role="tab">Tab 2</button>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Secondary</h6>
                        <div class="so-tabs so-tabs-pills so-tabs-secondary so-tabs-sm" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab">Active</button>
                            <button class="so-tab" role="tab">Tab 2</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tab-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Color variants
UiEngine::tabs('tabs')->pills()->primary()->tab('Tab', 'Content');
UiEngine::tabs('tabs')->pills()->success()->tab('Tab', 'Content');
UiEngine::tabs('tabs')->pills()->danger()->tab('Tab', 'Content');
UiEngine::tabs('tabs')->pills()->warning()->tab('Tab', 'Content');
UiEngine::tabs('tabs')->pills()->info()->tab('Tab', 'Content');
UiEngine::tabs('tabs')->pills()->secondary()->tab('Tab', 'Content');

// Or use variant() method
UiEngine::tabs('tabs')->pills()->variant('primary');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Color variants
UiEngine.tabs('tabs').pills().primary().tab('Tab', 'Content');
UiEngine.tabs('tabs').pills().success().tab('Tab', 'Content');
UiEngine.tabs('tabs').pills().danger().tab('Tab', 'Content');
UiEngine.tabs('tabs').pills().warning().tab('Tab', 'Content');
UiEngine.tabs('tabs').pills().info().tab('Tab', 'Content');

// Or use variant() method
UiEngine.tabs('tabs').pills().variant('primary');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-tabs so-tabs-pills so-tabs-primary">...</div>
<div class="so-tabs so-tabs-pills so-tabs-success">...</div>
<div class="so-tabs so-tabs-pills so-tabs-danger">...</div>
<div class="so-tabs so-tabs-pills so-tabs-warning">...</div>
<div class="so-tabs so-tabs-pills so-tabs-info">...</div>
<div class="so-tabs so-tabs-pills so-tabs-secondary">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tabs with Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Tabs with Icons</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add Material Icons to tabs for better visual recognition.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
                        <button class="so-tab so-active" role="tab" data-so-target="#icon-1">
                            <span class="material-icons">home</span>
                            Home
                        </button>
                        <button class="so-tab" role="tab" data-so-target="#icon-2">
                            <span class="material-icons">person</span>
                            Profile
                        </button>
                        <button class="so-tab" role="tab" data-so-target="#icon-3">
                            <span class="material-icons">settings</span>
                            Settings
                        </button>
                    </div>
                    <div class="so-tab-content">
                        <div class="so-tab-pane so-fade so-show so-active" id="icon-1" role="tabpanel">Home content with icon in tab.</div>
                        <div class="so-tab-pane so-fade" id="icon-2" role="tabpanel">Profile content.</div>
                        <div class="so-tab-pane so-fade" id="icon-3" role="tabpanel">Settings content.</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tabs-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$tabs = UiEngine::tabs('icon-tabs')
    ->pills()
    ->tab('Home', 'Home content', 'home')
    ->tab('Profile', 'Profile content', 'person')
    ->tab('Settings', 'Settings content', 'settings');

echo \$tabs->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const tabs = UiEngine.tabs('icon-tabs')
    .pills()
    .tab('Home', 'Home content', 'home')
    .tab('Profile', 'Profile content', 'person')
    .tab('Settings', 'Settings content', 'settings');

document.body.innerHTML = tabs.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">
        <span class="material-icons">home</span>
        Home
    </button>
    <button class="so-tab" role="tab" data-so-target="#panel2">
        <span class="material-icons">person</span>
        Profile
    </button>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Tabs -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Tabs</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Vertical tab layout for settings pages with many sections.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-tabs-container so-tabs-container-vertical">
                        <div class="so-tabs so-tabs-vertical" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab" data-so-target="#vert-1">General</button>
                            <button class="so-tab" role="tab" data-so-target="#vert-2">Security</button>
                            <button class="so-tab" role="tab" data-so-target="#vert-3">Notifications</button>
                            <button class="so-tab" role="tab" data-so-target="#vert-4">Privacy</button>
                        </div>
                        <div class="so-tab-content">
                            <div class="so-tab-pane so-fade so-show so-active" id="vert-1" role="tabpanel">
                                <h5>General Settings</h5>
                                <p>Configure your general application settings here.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="vert-2" role="tabpanel">
                                <h5>Security Settings</h5>
                                <p>Manage your security preferences.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="vert-3" role="tabpanel">
                                <h5>Notification Preferences</h5>
                                <p>Control which notifications you receive.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="vert-4" role="tabpanel">
                                <h5>Privacy Settings</h5>
                                <p>Manage your privacy preferences.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tabs-vertical', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$tabs = UiEngine::tabs('vertical-tabs')
    ->vertical()
    ->tab('General', 'General settings content')
    ->tab('Security', 'Security settings content')
    ->tab('Notifications', 'Notification settings')
    ->tab('Privacy', 'Privacy settings');

echo \$tabs->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const tabs = UiEngine.tabs('vertical-tabs')
    .vertical()
    .tab('General', 'General settings content')
    .tab('Security', 'Security settings content')
    .tab('Notifications', 'Notification settings');

document.body.innerHTML = tabs.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-tabs-container so-tabs-container-vertical">
    <div class="so-tabs so-tabs-vertical" role="tablist" data-so-tabs>
        <button class="so-tab so-active" role="tab" data-so-target="#panel1">General</button>
        <button class="so-tab" role="tab" data-so-target="#panel2">Security</button>
        <button class="so-tab" role="tab" data-so-target="#panel3">Notifications</button>
    </div>
    <div class="so-tab-content">
        <div class="so-tab-pane so-fade so-show so-active" id="panel1">...</div>
        <div class="so-tab-pane so-fade" id="panel2">...</div>
        <div class="so-tab-pane so-fade" id="panel3">...</div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Alignment Options -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Alignment Options</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Center, right-align, justify, or fill available space.</p>

                <!-- Center -->
                <h5 class="so-mb-3">Center Aligned</h5>
                <div class="so-tabs so-tabs-center so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Tab 1</button>
                    <button class="so-tab" role="tab">Tab 2</button>
                    <button class="so-tab" role="tab">Tab 3</button>
                </div>

                <!-- Right -->
                <h5 class="so-mb-3">Right Aligned</h5>
                <div class="so-tabs so-tabs-end so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Tab 1</button>
                    <button class="so-tab" role="tab">Tab 2</button>
                    <button class="so-tab" role="tab">Tab 3</button>
                </div>

                <!-- Justified -->
                <h5 class="so-mb-3">Justified (Equal Width)</h5>
                <div class="so-tabs so-tabs-justified so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Tab 1</button>
                    <button class="so-tab" role="tab">Tab 2</button>
                    <button class="so-tab" role="tab">Tab 3</button>
                </div>

                <!-- Fill -->
                <h5 class="so-mb-3">Fill (Proportional)</h5>
                <div class="so-tabs so-tabs-fill so-mb-4" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab">Short</button>
                    <button class="so-tab" role="tab">Much Longer Tab</button>
                    <button class="so-tab" role="tab">Tab</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tabs-alignment', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Center aligned
UiEngine::tabs('tabs')->centered()->tab('Tab 1', 'Content');

// Right aligned
UiEngine::tabs('tabs')->end()->tab('Tab 1', 'Content');

// Justified (equal width)
UiEngine::tabs('tabs')->justified()->tab('Tab 1', 'Content');

// Fill (proportional)
UiEngine::tabs('tabs')->fill()->tab('Tab 1', 'Content');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Center aligned
UiEngine.tabs('tabs').centered().tab('Tab 1', 'Content');

// Right aligned
UiEngine.tabs('tabs').end().tab('Tab 1', 'Content');

// Justified (equal width)
UiEngine.tabs('tabs').justified().tab('Tab 1', 'Content');

// Fill (proportional)
UiEngine.tabs('tabs').fill().tab('Tab 1', 'Content');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Center aligned -->
<div class="so-tabs so-tabs-center" role="tablist">...</div>

<!-- Right aligned -->
<div class="so-tabs so-tabs-end" role="tablist">...</div>

<!-- Justified (equal width) -->
<div class="so-tabs so-tabs-justified" role="tablist">...</div>

<!-- Fill (proportional) -->
<div class="so-tabs so-tabs-fill" role="tablist">...</div>'
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
                                <td><code>tab()</code></td>
                                <td><code>string $title, mixed $content, ?string $icon, bool $disabled</code></td>
                                <td>Add a tab</td>
                            </tr>
                            <tr>
                                <td><code>activeTab()</code></td>
                                <td><code>int $index</code></td>
                                <td>Set active tab by index (0-based)</td>
                            </tr>
                            <tr>
                                <td><code>pills()</code></td>
                                <td>-</td>
                                <td>Use pills style</td>
                            </tr>
                            <tr>
                                <td><code>boxed()</code></td>
                                <td>-</td>
                                <td>Use boxed/segmented style</td>
                            </tr>
                            <tr>
                                <td><code>ghost()</code></td>
                                <td>-</td>
                                <td>Use ghost style</td>
                            </tr>
                            <tr>
                                <td><code>bordered()</code></td>
                                <td>-</td>
                                <td>Use bordered style</td>
                            </tr>
                            <tr>
                                <td><code>vertical()</code></td>
                                <td>-</td>
                                <td>Vertical layout</td>
                            </tr>
                            <tr>
                                <td><code>small()</code></td>
                                <td>-</td>
                                <td>Small size</td>
                            </tr>
                            <tr>
                                <td><code>large()</code></td>
                                <td>-</td>
                                <td>Large size</td>
                            </tr>
                            <tr>
                                <td><code>centered()</code></td>
                                <td>-</td>
                                <td>Center align tabs</td>
                            </tr>
                            <tr>
                                <td><code>end()</code></td>
                                <td>-</td>
                                <td>Right align tabs</td>
                            </tr>
                            <tr>
                                <td><code>fill()</code></td>
                                <td>-</td>
                                <td>Fill available width proportionally</td>
                            </tr>
                            <tr>
                                <td><code>justified()</code></td>
                                <td>-</td>
                                <td>Equal width tabs</td>
                            </tr>
                            <tr>
                                <td><code>primary()</code></td>
                                <td>-</td>
                                <td>Primary color variant</td>
                            </tr>
                            <tr>
                                <td><code>success()</code></td>
                                <td>-</td>
                                <td>Success color variant</td>
                            </tr>
                            <tr>
                                <td><code>danger()</code></td>
                                <td>-</td>
                                <td>Danger color variant</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">CSS Classes Reference</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-tabs</code></td>
                                <td>Tab container</td>
                            </tr>
                            <tr>
                                <td><code>.so-tab</code></td>
                                <td>Individual tab button</td>
                            </tr>
                            <tr>
                                <td><code>.so-tab-content</code></td>
                                <td>Content panels container</td>
                            </tr>
                            <tr>
                                <td><code>.so-tab-pane</code></td>
                                <td>Individual content panel</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-pills</code></td>
                                <td>Pills style</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-boxed</code></td>
                                <td>Boxed/segmented style</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-ghost</code></td>
                                <td>Ghost style</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-bordered</code></td>
                                <td>Bordered style</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-vertical</code></td>
                                <td>Vertical layout</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-sm/lg</code></td>
                                <td>Size variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-{color}</code></td>
                                <td>Color variants (primary, success, etc.)</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-center</code></td>
                                <td>Center aligned</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-end</code></td>
                                <td>Right aligned</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-justified</code></td>
                                <td>Equal width tabs</td>
                            </tr>
                            <tr>
                                <td><code>.so-tabs-fill</code></td>
                                <td>Proportional fill</td>
                            </tr>
                            <tr>
                                <td><code>.so-active</code></td>
                                <td>Active state</td>
                            </tr>
                            <tr>
                                <td><code>.so-disabled</code></td>
                                <td>Disabled state</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
