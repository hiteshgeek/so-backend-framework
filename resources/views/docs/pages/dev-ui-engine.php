<?php
/**
 * UiEngine Developer Guide
 *
 * Step-by-step guide to building UIs with UiEngine.
 */

$pageTitle = 'UiEngine Developer Guide';
$pageIcon = 'code-braces';
$toc = [
    ['id' => 'getting-started', 'title' => 'Getting Started', 'level' => 2],
    ['id' => 'building-forms', 'title' => 'Building Forms', 'level' => 2],
    ['id' => 'form-validation', 'title' => 'Form Validation', 'level' => 2],
    ['id' => 'layouts', 'title' => 'Building Layouts', 'level' => 2],
    ['id' => 'complete-examples', 'title' => 'Complete Examples', 'level' => 2],
    ['id' => 'ajax-forms', 'title' => 'AJAX Forms', 'level' => 2],
    ['id' => 'dynamic-forms', 'title' => 'Dynamic Forms', 'level' => 2],
    ['id' => 'custom-elements', 'title' => 'Custom Elements', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development', 'url' => '/docs#dev-panel'], ['label' => 'UiEngine Guide']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-ui-engine" class="heading heading-1">
    <span class="mdi mdi-code-braces heading-icon"></span>
    <span class="heading-text">UiEngine Developer Guide</span>
</h1>

<p class="text-lead">
    Step-by-step guide to building forms, layouts, and complete interfaces with UiEngine. Includes working code examples.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-guide">Guide</span>
    <span class="badge badge-new">New</span>
</div>

<!-- Getting Started -->
<h2 id="getting-started" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Getting Started</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Step 1: Import UiEngine</span>
</h3>

<?= codeBlock('php', '<?php
// At the top of your controller or view
use Core\UiEngine\UiEngine;') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Step 2: Create Your First Element</span>
</h3>

<?= codeBlock('php', '// Create a simple input
$input = UiEngine::input(\'username\')
    ->label(\'Username\')
    ->placeholder(\'Enter username\')
    ->required();

// Render it (outputs HTML string)
echo $input->render();

// Or render as part of form group (includes label, help text, errors)
echo $input->renderGroup();') ?>

<p>This outputs:</p>

<?= codeBlock('html', '<div class="so-form-group">
    <label class="so-form-label" for="username">
        Username <span class="so-text-danger">*</span>
    </label>
    <input type="text"
           class="so-form-control"
           id="username"
           name="username"
           placeholder="Enter username"
           required>
</div>') ?>

<!-- Building Forms -->
<h2 id="building-forms" class="heading heading-2">
    <span class="mdi mdi-form-textbox heading-icon"></span>
    <span class="heading-text">Building Forms</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Example: Login Form</span>
</h3>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

// Set CSRF token globally (usually in bootstrap or middleware)
UiEngine::setCsrfToken(csrf_token());

// Build the login form
$loginForm = UiEngine::form(\'/login\')
    ->method(\'POST\')
    ->id(\'login-form\')
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Email Address\')
            ->placeholder(\'you@example.com\')
            ->required()
            ->autofocus()
    )
    ->add(
        UiEngine::password(\'password\')
            ->label(\'Password\')
            ->placeholder(\'Enter your password\')
            ->required()
    )
    ->add(
        UiEngine::checkbox(\'remember\')
            ->label(\'Remember me\')
    )
    ->add(
        UiEngine::submit(\'Sign In\')
            ->addClass(\'so-w-100\') // Full width
    );

// Render the form
echo $loginForm->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Example: Registration Form</span>
</h3>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

$registerForm = UiEngine::form(\'/register\')
    ->method(\'POST\')
    ->add(
        UiEngine::row()
            ->add(
                UiEngine::col(6)->add(
                    UiEngine::input(\'first_name\')
                        ->label(\'First Name\')
                        ->required()
                        ->rules(\'required|min:2|max:50\')
                )
            )
            ->add(
                UiEngine::col(6)->add(
                    UiEngine::input(\'last_name\')
                        ->label(\'Last Name\')
                        ->required()
                        ->rules(\'required|min:2|max:50\')
                )
            )
    )
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Email Address\')
            ->required()
            ->rules(\'required|email|unique:users,email\')
            ->help(\'We\'ll never share your email.\')
    )
    ->add(
        UiEngine::password(\'password\')
            ->label(\'Password\')
            ->required()
            ->rules(\'required|min:8\')
            ->help(\'Minimum 8 characters\')
    )
    ->add(
        UiEngine::password(\'password_confirmation\')
            ->label(\'Confirm Password\')
            ->required()
            ->rules(\'required|confirmed\')
    )
    ->add(
        UiEngine::checkbox(\'terms\')
            ->label(\'I agree to the Terms of Service\')
            ->required()
    )
    ->add(
        UiEngine::submit(\'Create Account\')
    );

// Render form and validation script
echo $registerForm->render();
echo $registerForm->exportValidationScript();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Example: Contact Form</span>
</h3>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

$contactForm = UiEngine::form(\'/contact\')
    ->method(\'POST\')
    ->add(
        UiEngine::input(\'name\')
            ->label(\'Your Name\')
            ->required()
            ->rules(\'required|min:2\')
    )
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Your Email\')
            ->required()
            ->rules(\'required|email\')
    )
    ->add(
        UiEngine::select(\'subject\')
            ->label(\'Subject\')
            ->required()
            ->placeholder(\'Select a topic\')
            ->options([
                \'general\' => \'General Inquiry\',
                \'support\' => \'Technical Support\',
                \'billing\' => \'Billing Question\',
                \'other\' => \'Other\',
            ])
    )
    ->add(
        UiEngine::textarea(\'message\')
            ->label(\'Message\')
            ->required()
            ->rows(6)
            ->maxlength(1000)
            ->showCounter()
            ->rules(\'required|min:10|max:1000\')
    )
    ->add(
        UiEngine::submit(\'Send Message\')
            ->icon(\'send\')
    );

echo $contactForm->render();
echo $contactForm->exportValidationScript();') ?>

<!-- Form Validation -->
<h2 id="form-validation" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Form Validation</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Server-Side Validation</span>
</h3>

<?= codeBlock('php', '<?php
// In your controller
use Core\UiEngine\UiEngine;
use Core\Validation\Validator;

class UserController
{
    public function store()
    {
        // Get validation rules from form config (optional)
        // or define rules directly
        $rules = [
            \'first_name\' => \'required|min:2|max:50\',
            \'last_name\' => \'required|min:2|max:50\',
            \'email\' => \'required|email|unique:users,email\',
            \'password\' => \'required|min:8\',
            \'password_confirmation\' => \'required|same:password\',
        ];

        $validator = new Validator($_POST, $rules);

        if ($validator->fails()) {
            // For web requests - redirect back with errors
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();

            // For API requests - return JSON
            return response()->json([
                \'success\' => false,
                \'errors\' => $validator->errors(),
            ], 422);
        }

        // Validation passed - create user
        $user = User::create($validator->validated());

        return redirect(\'/users\')->with(\'success\', \'User created!\');
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Client-Side Validation</span>
</h3>

<p>
    When you call <code>exportValidationScript()</code>, UiEngine automatically exports PHP validation rules to JavaScript. The ValidationEngine validates on the client before submission.
</p>

<?= codeBlock('php', '// In your view
echo $form->render();
echo $form->exportValidationScript(); // This is key!') ?>

<p>The JavaScript validation runs automatically. You can also manually trigger it:</p>

<?= codeBlock('javascript', '// Manual validation
document.getElementById(\'my-form\').addEventListener(\'submit\', (e) => {
    e.preventDefault();

    const form = e.target;
    const result = ValidationEngine.validateForm(form);

    if (result.valid) {
        form.submit(); // or use fetch() for AJAX
    }
    // Errors automatically shown by ErrorReporter
});') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Custom Error Messages</span>
</h3>

<?= codeBlock('php', '// Per-field custom messages
UiEngine::email(\'email\')
    ->label(\'Email\')
    ->rules(\'required|email|unique:users,email\')
    ->messages([
        \'required\' => \'Please enter your email address\',
        \'email\' => \'This doesn\'t look like a valid email\',
        \'unique\' => \'This email is already registered\',
    ]);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Displaying Errors</span>
</h3>

<p>
    Errors can be displayed in multiple ways:
</p>

<?= codeBlock('php', '// 1. Inline with field (default) - errors show below each input
UiEngine::input(\'name\')
    ->error($errors[\'name\'] ?? null); // Set error from server

// 2. Centralized Error Reporter
// JavaScript automatically uses ErrorReporter for client-side validation
// Configure position:
?>
<script>
UiEngine.errors.configure({
    position: \'top-right\',  // Options: top-right, top-left, top-center,
                            //          bottom-right, bottom-left, bottom-center,
                            //          inline-top, inline-bottom
    autoHide: false,
    dismissible: true,
});
</script>') ?>

<!-- Building Layouts -->
<h2 id="layouts" class="heading heading-2">
    <span class="mdi mdi-view-grid heading-icon"></span>
    <span class="heading-text">Building Layouts</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Grid System</span>
</h3>

<?= codeBlock('php', '// Two columns (50/50)
echo UiEngine::row()
    ->add(UiEngine::col(6)->add($leftContent))
    ->add(UiEngine::col(6)->add($rightContent))
    ->render();

// Three columns (responsive)
echo UiEngine::row()
    ->add(UiEngine::col()->md(4)->sm(6)->add($col1))
    ->add(UiEngine::col()->md(4)->sm(6)->add($col2))
    ->add(UiEngine::col()->md(4)->sm(12)->add($col3))
    ->render();

// Unequal columns (main content + sidebar)
echo UiEngine::row()
    ->add(UiEngine::col(8)->add($mainContent))
    ->add(UiEngine::col(4)->add($sidebar))
    ->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Nested Layouts</span>
</h3>

<?= codeBlock('php', '// Card with form inside
echo UiEngine::card(\'User Settings\')
    ->add(
        UiEngine::row()
            ->add(
                UiEngine::col(6)->add(
                    UiEngine::input(\'first_name\')->label(\'First Name\')
                )
            )
            ->add(
                UiEngine::col(6)->add(
                    UiEngine::input(\'last_name\')->label(\'Last Name\')
                )
            )
    )
    ->add(UiEngine::email(\'email\')->label(\'Email\'))
    ->add(UiEngine::submit(\'Save Changes\'))
    ->render();') ?>

<!-- Complete Examples -->
<h2 id="complete-examples" class="heading heading-2">
    <span class="mdi mdi-file-document heading-icon"></span>
    <span class="heading-text">Complete Examples</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Example: User Management Page</span>
</h3>

<?= codeBlock('php', '<?php
// resources/views/users/create.php
use Core\UiEngine\UiEngine;

UiEngine::setCsrfToken(csrf_token());

// Build the complete page
$page = UiEngine::container()
    ->add(
        UiEngine::row()->addClass(\'so-mb-4\')
            ->add(
                UiEngine::col(12)->add(
                    UiEngine::card()
                        ->header(\'<h4 class="so-mb-0">Create New User</h4>\')
                        ->add(
                            UiEngine::form(\'/users\')
                                ->method(\'POST\')
                                ->id(\'create-user-form\')
                                // Row 1: Name
                                ->add(
                                    UiEngine::row()
                                        ->add(
                                            UiEngine::col(6)->add(
                                                UiEngine::input(\'first_name\')
                                                    ->label(\'First Name\')
                                                    ->required()
                                                    ->rules(\'required|min:2|max:50\')
                                            )
                                        )
                                        ->add(
                                            UiEngine::col(6)->add(
                                                UiEngine::input(\'last_name\')
                                                    ->label(\'Last Name\')
                                                    ->required()
                                                    ->rules(\'required|min:2|max:50\')
                                            )
                                        )
                                )
                                // Row 2: Email & Role
                                ->add(
                                    UiEngine::row()
                                        ->add(
                                            UiEngine::col(6)->add(
                                                UiEngine::email(\'email\')
                                                    ->label(\'Email Address\')
                                                    ->required()
                                                    ->rules(\'required|email|unique:users,email\')
                                            )
                                        )
                                        ->add(
                                            UiEngine::col(6)->add(
                                                UiEngine::select(\'role\')
                                                    ->label(\'Role\')
                                                    ->required()
                                                    ->options([
                                                        \'admin\' => \'Administrator\',
                                                        \'manager\' => \'Manager\',
                                                        \'user\' => \'User\',
                                                    ])
                                            )
                                        )
                                )
                                // Row 3: Password
                                ->add(
                                    UiEngine::row()
                                        ->add(
                                            UiEngine::col(6)->add(
                                                UiEngine::password(\'password\')
                                                    ->label(\'Password\')
                                                    ->required()
                                                    ->rules(\'required|min:8\')
                                            )
                                        )
                                        ->add(
                                            UiEngine::col(6)->add(
                                                UiEngine::password(\'password_confirmation\')
                                                    ->label(\'Confirm Password\')
                                                    ->required()
                                            )
                                        )
                                )
                                // Options
                                ->add(
                                    UiEngine::checkbox(\'send_welcome_email\')
                                        ->label(\'Send welcome email\')
                                        ->checked()
                                )
                                ->add(
                                    UiEngine::checkbox(\'active\')
                                        ->label(\'Account is active\')
                                        ->checked()
                                        ->switch()
                                )
                                // Buttons
                                ->add(
                                    UiEngine::row()->addClass(\'so-mt-4\')
                                        ->add(
                                            UiEngine::col(12)->add(
                                                UiEngine::button(\'Cancel\')
                                                    ->secondary()
                                                    ->outline()
                                                    ->attr(\'onclick\', \'history.back()\')
                                            )->add(
                                                UiEngine::submit(\'Create User\')
                                                    ->addClass(\'so-ms-2\')
                                            )
                                        )
                                )
                        )
                )
            )
    );

// Render everything
echo $page->render();

// Export validation for client-side
$form = $page->find(\'#create-user-form\');
if ($form) {
    echo $form->exportValidationScript();
}
?>') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Example: Settings Page with Tabs</span>
</h3>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

// Profile tab content
$profileTab = UiEngine::form(\'/settings/profile\')
    ->method(\'PUT\')
    ->add(UiEngine::input(\'name\')->label(\'Display Name\')->value($user->name))
    ->add(UiEngine::email(\'email\')->label(\'Email\')->value($user->email))
    ->add(UiEngine::textarea(\'bio\')->label(\'Bio\')->rows(4)->value($user->bio))
    ->add(UiEngine::file(\'avatar\')->label(\'Profile Picture\')->images()->preview())
    ->add(UiEngine::submit(\'Save Profile\'));

// Security tab content
$securityTab = UiEngine::form(\'/settings/password\')
    ->method(\'PUT\')
    ->add(UiEngine::password(\'current_password\')->label(\'Current Password\')->required())
    ->add(UiEngine::password(\'password\')->label(\'New Password\')->required()->rules(\'min:8\'))
    ->add(UiEngine::password(\'password_confirmation\')->label(\'Confirm New Password\')->required())
    ->add(UiEngine::submit(\'Change Password\'));

// Notifications tab content
$notificationsTab = UiEngine::form(\'/settings/notifications\')
    ->method(\'PUT\')
    ->add(
        UiEngine::checkbox(\'email_notifications\')
            ->label(\'Email Notifications\')
            ->switch()
            ->checked($user->email_notifications)
    )
    ->add(
        UiEngine::checkbox(\'push_notifications\')
            ->label(\'Push Notifications\')
            ->switch()
            ->checked($user->push_notifications)
    )
    ->add(
        UiEngine::checkbox(\'marketing_emails\')
            ->label(\'Marketing Emails\')
            ->switch()
            ->checked($user->marketing_emails)
    )
    ->add(UiEngine::submit(\'Save Preferences\'));

// Build tabs
echo UiEngine::card()
    ->noPadding()
    ->add(
        UiEngine::tabs()
            ->tab(\'profile\', \'Profile\', $profileTab->render())
            ->tab(\'security\', \'Security\', $securityTab->render())
            ->tab(\'notifications\', \'Notifications\', $notificationsTab->render())
    )
    ->render();
?>') ?>

<!-- AJAX Forms -->
<h2 id="ajax-forms" class="heading heading-2">
    <span class="mdi mdi-cloud-sync heading-icon"></span>
    <span class="heading-text">AJAX Forms</span>
</h2>

<?= codeBlock('php', '<?php
// Enable AJAX mode on form
$form = UiEngine::form(\'/api/users\')
    ->method(\'POST\')
    ->ajax() // Enables AJAX submission
    ->add(UiEngine::input(\'name\')->label(\'Name\'))
    ->add(UiEngine::email(\'email\')->label(\'Email\'))
    ->add(UiEngine::submit(\'Save\'));

echo $form->render();
?>

<script>
// The form automatically submits via AJAX when ajax() is enabled
// Listen for success/error events:
document.getElementById(\'<?= $form->getId() ?>\').addEventListener(\'so:form:success\', (e) => {
    console.log(\'Success!\', e.detail.data);
    SOToast.success(\'User created successfully!\');
});

document.getElementById(\'<?= $form->getId() ?>\').addEventListener(\'so:form:error\', (e) => {
    console.log(\'Error!\', e.detail.errors);
    // Errors are automatically displayed by ErrorReporter
});
</script>') ?>

<!-- Dynamic Forms -->
<h2 id="dynamic-forms" class="heading heading-2">
    <span class="mdi mdi-cog-sync heading-icon"></span>
    <span class="heading-text">Dynamic Forms (From Database)</span>
</h2>

<p>
    Generate forms dynamically from database field definitions:
</p>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

// Field definitions from database or API
$fieldDefinitions = [
    [
        \'name\' => \'company_name\',
        \'type\' => \'text\',
        \'label\' => \'Company Name\',
        \'required\' => true,
        \'rules\' => \'required|max:255\',
    ],
    [
        \'name\' => \'industry\',
        \'type\' => \'select\',
        \'label\' => \'Industry\',
        \'required\' => true,
        \'options\' => [
            \'tech\' => \'Technology\',
            \'finance\' => \'Finance\',
            \'healthcare\' => \'Healthcare\',
            \'retail\' => \'Retail\',
        ],
    ],
    [
        \'name\' => \'employees\',
        \'type\' => \'number\',
        \'label\' => \'Number of Employees\',
        \'min\' => 1,
        \'max\' => 100000,
    ],
    [
        \'name\' => \'description\',
        \'type\' => \'textarea\',
        \'label\' => \'Description\',
        \'rows\' => 4,
        \'maxlength\' => 1000,
    ],
];

// Build form dynamically
$form = UiEngine::form(\'/companies\')->method(\'POST\');

foreach ($fieldDefinitions as $field) {
    $element = match($field[\'type\']) {
        \'text\' => UiEngine::input($field[\'name\']),
        \'email\' => UiEngine::email($field[\'name\']),
        \'number\' => UiEngine::number($field[\'name\']),
        \'select\' => UiEngine::select($field[\'name\'])->options($field[\'options\'] ?? []),
        \'textarea\' => UiEngine::textarea($field[\'name\']),
        \'checkbox\' => UiEngine::checkbox($field[\'name\']),
        default => UiEngine::input($field[\'name\']),
    };

    $element->label($field[\'label\'] ?? $field[\'name\']);

    if ($field[\'required\'] ?? false) {
        $element->required();
    }
    if (isset($field[\'rules\'])) {
        $element->rules($field[\'rules\']);
    }
    if (isset($field[\'rows\'])) {
        $element->rows($field[\'rows\']);
    }
    if (isset($field[\'min\'])) {
        $element->min($field[\'min\']);
    }
    if (isset($field[\'max\'])) {
        $element->max($field[\'max\']);
    }
    if (isset($field[\'maxlength\'])) {
        $element->maxlength($field[\'maxlength\']);
    }

    $form->add($element);
}

$form->add(UiEngine::submit(\'Submit\'));

echo $form->render();
echo $form->exportValidationScript();
?>') ?>

<!-- Custom Elements -->
<h2 id="custom-elements" class="heading heading-2">
    <span class="mdi mdi-puzzle-outline heading-icon"></span>
    <span class="heading-text">Custom Elements</span>
</h2>

<p>
    You can register custom element types:
</p>

<?= codeBlock('php', '<?php
namespace App\UiEngine\Elements;

use Core\UiEngine\Elements\FormElement;

class DateRangePicker extends FormElement
{
    protected string $type = \'daterange\';
    protected string $tagName = \'div\';

    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected string $format = \'Y-m-d\';

    public function startDate(?string $date): static
    {
        $this->startDate = $date;
        return $this;
    }

    public function endDate(?string $date): static
    {
        $this->endDate = $date;
        return $this;
    }

    public function format(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function render(): string
    {
        $html = \'<div class="so-daterange-picker">\';
        $html .= \'<input type="date" name="\' . e($this->name) . \'_start" value="\' . e($this->startDate) . \'">\';
        $html .= \'<span class="so-daterange-separator">to</span>\';
        $html .= \'<input type="date" name="\' . e($this->name) . \'_end" value="\' . e($this->endDate) . \'">\';
        $html .= \'</div>\';
        return $html;
    }
}

// Register the custom element
UiEngine::registerElement(\'daterange\', DateRangePicker::class);

// Use it
$picker = UiEngine::fromConfig([
    \'type\' => \'daterange\',
    \'name\' => \'booking_dates\',
    \'label\' => \'Booking Period\',
]);

echo $picker->render();
?>') ?>

<?= callout('tip', '
    <strong>Best Practice:</strong> Keep your custom elements in <code>app/UiEngine/Elements/</code> and register them in a service provider or bootstrap file.
', 'Organization') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
