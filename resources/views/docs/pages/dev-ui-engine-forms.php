<?php
/**
 * UiEngine Forms Guide
 *
 * Step-by-step guide to building forms with UiEngine.
 */

$pageTitle = 'UiEngine Forms Guide';
$pageIcon = 'form-select';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'step-1-simple-input', 'title' => 'Step 1: Simple Input', 'level' => 2],
    ['id' => 'step-2-validation', 'title' => 'Step 2: Adding Validation', 'level' => 2],
    ['id' => 'step-3-login-form', 'title' => 'Step 3: Login Form', 'level' => 2],
    ['id' => 'step-4-registration-form', 'title' => 'Step 4: Registration Form', 'level' => 2],
    ['id' => 'step-5-crud-form', 'title' => 'Step 5: CRUD Create/Edit Form', 'level' => 2],
    ['id' => 'step-6-file-uploads', 'title' => 'Step 6: Form with File Uploads', 'level' => 2],
    ['id' => 'step-7-dynamic-fields', 'title' => 'Step 7: Dynamic Form Fields', 'level' => 2],
    ['id' => 'step-8-ajax-submission', 'title' => 'Step 8: AJAX Form Submission', 'level' => 2],
    ['id' => 'common-patterns', 'title' => 'Common Patterns', 'level' => 2],
    ['id' => 'troubleshooting', 'title' => 'Troubleshooting', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development', 'url' => '/docs#dev-panel'], ['label' => 'UiEngine Forms Guide']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-ui-engine-forms" class="heading heading-1">
    <span class="mdi mdi-form-select heading-icon"></span>
    <span class="heading-text">UiEngine Forms Guide</span>
</h1>

<p class="text-lead">
    Step-by-step guide to building forms with UiEngine. From simple inputs to complete CRUD forms with validation, file uploads, and AJAX submission.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-guide">Guide</span>
    <span class="badge badge-new">New</span>
    <span class="badge badge-step-by-step">Step-by-Step</span>
</div>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<p>
    This guide walks you through building forms with UiEngine, from basic inputs to complex forms with validation and file uploads. Each step builds on the previous one.
</p>

<?= callout('info', '
    <strong>Prerequisites:</strong>
    <ul class="so-mb-0">
        <li>Basic understanding of PHP and the framework structure</li>
        <li>UiEngine classes are available at <code>Core\UiEngine\UiEngine</code></li>
        <li>CSRF protection is enabled (automatically included in forms)</li>
    </ul>
') ?>

<!-- Step 1: Simple Input -->
<h2 id="step-1-simple-input" class="heading heading-2">
    <span class="mdi mdi-numeric-1-circle heading-icon"></span>
    <span class="heading-text">Step 1: Simple Input</span>
</h2>

<p>
    Let's start with a basic text input. UiEngine provides factory methods for creating elements.
</p>

<?= codeTabs('step1', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Create a simple text input
$input = UiEngine::input(\'username\')
    ->label(\'Username\')
    ->placeholder(\'Enter your username\');

// Render just the input element
echo $input->render();

// Or render with form group (label + input + help + errors)
echo $input->renderGroup();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Create a simple text input
const input = UiEngine.input(\'username\')
    .label(\'Username\')
    .placeholder(\'Enter your username\');

// Render to HTML string
const html = input.toHtml();
document.getElementById(\'container\').innerHTML = html;'
    ],
    [
        'label' => 'HTML Output',
        'language' => 'html',
        'code' => '<div class="so-form-group">
    <label class="so-form-label" for="username">Username</label>
    <input type="text"
           class="so-form-control"
           id="username"
           name="username"
           placeholder="Enter your username">
</div>'
    ],
]) ?>

<p>
    Different input types are available as convenience methods:
</p>

<?= codeBlock('php', '// Email input
$email = UiEngine::email(\'email\')->label(\'Email Address\');

// Password input
$password = UiEngine::password(\'password\')->label(\'Password\');

// Number input
$age = UiEngine::number(\'age\')->label(\'Age\')->min(0)->max(120);

// Date input
$date = UiEngine::date(\'birthdate\')->label(\'Birth Date\');

// Generic input with custom type
$phone = UiEngine::input(\'phone\')->type(\'tel\')->label(\'Phone\');') ?>

<!-- Step 2: Adding Validation -->
<h2 id="step-2-validation" class="heading heading-2">
    <span class="mdi mdi-numeric-2-circle heading-icon"></span>
    <span class="heading-text">Step 2: Adding Validation</span>
</h2>

<p>
    Add validation rules using the <code>rules()</code> method. Rules can be specified as a pipe-separated string or an array.
</p>

<?= codeTabs('step2', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Input with validation rules
$email = UiEngine::email(\'email\')
    ->label(\'Email Address\')
    ->placeholder(\'you@example.com\')
    ->required()
    ->rules(\'required|email|max:255\')
    ->messages([
        \'required\' => \'Please enter your email address\',
        \'email\' => \'Please enter a valid email address\',
    ]);

// Password with minimum length
$password = UiEngine::password(\'password\')
    ->label(\'Password\')
    ->required()
    ->rules(\'required|min:8\')
    ->help(\'Minimum 8 characters\');

echo $email->renderGroup();
echo $password->renderGroup();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Input with validation rules
const email = UiEngine.email(\'email\')
    .label(\'Email Address\')
    .placeholder(\'you@example.com\')
    .required()
    .rules(\'required|email|max:255\')
    .messages({
        required: \'Please enter your email address\',
        email: \'Please enter a valid email address\',
    });

// Password with minimum length
const password = UiEngine.password(\'password\')
    .label(\'Password\')
    .required()
    .rules(\'required|min:8\')
    .help(\'Minimum 8 characters\');

document.body.innerHTML = email.toHtml() + password.toHtml();'
    ],
]) ?>

<?= callout('tip', '
    <strong>Available Validation Rules:</strong>
    <code>required</code>, <code>email</code>, <code>min:n</code>, <code>max:n</code>, <code>numeric</code>, <code>integer</code>, <code>url</code>, <code>alpha</code>, <code>alpha_dash</code>, <code>regex:pattern</code>, <code>confirmed</code>, <code>in:a,b,c</code>, <code>unique:table,column</code>
') ?>

<!-- Step 3: Login Form -->
<h2 id="step-3-login-form" class="heading heading-2">
    <span class="mdi mdi-numeric-3-circle heading-icon"></span>
    <span class="heading-text">Step 3: Login Form</span>
</h2>

<p>
    Now let's build a complete login form with email, password, and remember me checkbox.
</p>

<?= codeTabs('step3', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Set CSRF token globally (usually done in bootstrap)
UiEngine::setCsrfToken(csrf_token());

// Build the login form
$loginForm = UiEngine::form(\'/login\')
    ->method(\'POST\')
    ->id(\'login-form\')
    ->addClass(\'so-mx-auto\')
    ->style(\'max-width: 400px\')
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Email Address\')
            ->placeholder(\'you@example.com\')
            ->required()
            ->autofocus()
            ->rules(\'required|email\')
    )
    ->add(
        UiEngine::password(\'password\')
            ->label(\'Password\')
            ->placeholder(\'Enter your password\')
            ->required()
            ->rules(\'required\')
    )
    ->add(
        UiEngine::checkbox(\'remember\')
            ->label(\'Remember me\')
    )
    ->add(
        UiEngine::submit(\'Sign In\')
            ->addClass(\'so-w-100\')
    );

// Render the form
echo $loginForm->render();

// Export validation to JavaScript
echo $loginForm->exportValidationScript();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Build the login form
const loginForm = UiEngine.form(\'/login\')
    .method(\'POST\')
    .id(\'login-form\')
    .addClass(\'so-mx-auto\')
    .style(\'max-width: 400px\')
    .add(
        UiEngine.email(\'email\')
            .label(\'Email Address\')
            .placeholder(\'you@example.com\')
            .required()
            .autofocus()
            .rules(\'required|email\')
    )
    .add(
        UiEngine.password(\'password\')
            .label(\'Password\')
            .placeholder(\'Enter your password\')
            .required()
            .rules(\'required\')
    )
    .add(
        UiEngine.checkbox(\'remember\')
            .label(\'Remember me\')
    )
    .add(
        UiEngine.submit(\'Sign In\')
            .addClass(\'so-w-100\')
    );

document.getElementById(\'app\').innerHTML = loginForm.toHtml();'
    ],
    [
        'label' => 'HTML Output',
        'language' => 'html',
        'code' => '<form action="/login" method="POST" id="login-form" class="so-form so-mx-auto" style="max-width: 400px">
    <input type="hidden" name="_token" value="csrf_token_here">

    <div class="so-form-group">
        <label class="so-form-label" for="email">
            Email Address <span class="so-text-danger">*</span>
        </label>
        <input type="email" class="so-form-control" id="email" name="email"
               placeholder="you@example.com" required autofocus>
    </div>

    <div class="so-form-group">
        <label class="so-form-label" for="password">
            Password <span class="so-text-danger">*</span>
        </label>
        <input type="password" class="so-form-control" id="password" name="password"
               placeholder="Enter your password" required>
    </div>

    <div class="so-form-group">
        <div class="so-form-check">
            <input type="checkbox" class="so-form-check-input" id="remember" name="remember">
            <label class="so-form-check-label" for="remember">Remember me</label>
        </div>
    </div>

    <button type="submit" class="so-btn so-btn-primary so-w-100">Sign In</button>
</form>'
    ],
]) ?>

<!-- Step 4: Registration Form -->
<h2 id="step-4-registration-form" class="heading heading-2">
    <span class="mdi mdi-numeric-4-circle heading-icon"></span>
    <span class="heading-text">Step 4: Registration Form</span>
</h2>

<p>
    A registration form with two-column layout, password confirmation, and terms checkbox.
</p>

<?= codeTabs('step4', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

$registerForm = UiEngine::form(\'/register\')
    ->method(\'POST\')
    ->id(\'register-form\')
    // Row 1: First Name & Last Name
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
    // Row 2: Email
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Email Address\')
            ->required()
            ->rules(\'required|email|unique:users,email\')
            ->help(\'We\\\'ll never share your email.\')
    )
    // Row 3: Password & Confirmation
    ->add(
        UiEngine::row()
            ->add(
                UiEngine::col(6)->add(
                    UiEngine::password(\'password\')
                        ->label(\'Password\')
                        ->required()
                        ->rules(\'required|min:8\')
                        ->help(\'Minimum 8 characters\')
                )
            )
            ->add(
                UiEngine::col(6)->add(
                    UiEngine::password(\'password_confirmation\')
                        ->label(\'Confirm Password\')
                        ->required()
                        ->rules(\'required|confirmed\')
                )
            )
    )
    // Terms checkbox
    ->add(
        UiEngine::checkbox(\'terms\')
            ->label(\'I agree to the <a href="/terms">Terms of Service</a>\')
            ->required()
            ->rules(\'required\')
    )
    // Submit button
    ->add(
        UiEngine::submit(\'Create Account\')
            ->icon(\'account-plus\')
    );

echo $registerForm->render();
echo $registerForm->exportValidationScript();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Same structure works in JavaScript
const registerForm = UiEngine.form(\'/register\')
    .method(\'POST\')
    .id(\'register-form\')
    .add(
        UiEngine.row()
            .add(
                UiEngine.col(6).add(
                    UiEngine.input(\'first_name\')
                        .label(\'First Name\')
                        .required()
                        .rules(\'required|min:2|max:50\')
                )
            )
            .add(
                UiEngine.col(6).add(
                    UiEngine.input(\'last_name\')
                        .label(\'Last Name\')
                        .required()
                        .rules(\'required|min:2|max:50\')
                )
            )
    )
    .add(
        UiEngine.email(\'email\')
            .label(\'Email Address\')
            .required()
            .rules(\'required|email\')
    )
    // ... continue building form
    .add(
        UiEngine.submit(\'Create Account\')
            .icon(\'account-plus\')
    );

document.getElementById(\'app\').innerHTML = registerForm.toHtml();'
    ],
]) ?>

<!-- Step 5: CRUD Form -->
<h2 id="step-5-crud-form" class="heading heading-2">
    <span class="mdi mdi-numeric-5-circle heading-icon"></span>
    <span class="heading-text">Step 5: CRUD Create/Edit Form</span>
</h2>

<p>
    A reusable form for both creating and editing records. The form adapts based on whether an existing model is provided.
</p>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

/**
 * Reusable user form for create and edit
 *
 * @param User|null $user Existing user for edit, null for create
 */
function userForm(?User $user = null): string
{
    $isEdit = $user !== null;
    $action = $isEdit ? "/users/{$user->id}" : \'/users\';
    $method = $isEdit ? \'PUT\' : \'POST\';
    $buttonText = $isEdit ? \'Update User\' : \'Create User\';

    $form = UiEngine::form($action)
        ->method($method)
        ->id(\'user-form\')
        // Name fields
        ->add(
            UiEngine::row()
                ->add(
                    UiEngine::col(6)->add(
                        UiEngine::input(\'first_name\')
                            ->label(\'First Name\')
                            ->value($user?->first_name)
                            ->required()
                            ->rules(\'required|min:2|max:50\')
                    )
                )
                ->add(
                    UiEngine::col(6)->add(
                        UiEngine::input(\'last_name\')
                            ->label(\'Last Name\')
                            ->value($user?->last_name)
                            ->required()
                            ->rules(\'required|min:2|max:50\')
                    )
                )
        )
        // Email
        ->add(
            UiEngine::email(\'email\')
                ->label(\'Email Address\')
                ->value($user?->email)
                ->required()
                ->rules($isEdit
                    ? "required|email|unique:users,email,{$user->id}"
                    : \'required|email|unique:users,email\'
                )
        )
        // Role select
        ->add(
            UiEngine::select(\'role\')
                ->label(\'Role\')
                ->options([
                    \'admin\' => \'Administrator\',
                    \'manager\' => \'Manager\',
                    \'user\' => \'User\',
                ])
                ->value($user?->role ?? \'user\')
                ->required()
        )
        // Status toggle
        ->add(
            UiEngine::checkbox(\'active\')
                ->label(\'Account Active\')
                ->switch()
                ->checked($user?->active ?? true)
        );

    // Password fields only for create, optional for edit
    if (!$isEdit) {
        $form->add(
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
        );
    } else {
        $form->add(
            UiEngine::row()
                ->add(
                    UiEngine::col(6)->add(
                        UiEngine::password(\'password\')
                            ->label(\'New Password\')
                            ->help(\'Leave blank to keep current password\')
                            ->rules(\'nullable|min:8\')
                    )
                )
                ->add(
                    UiEngine::col(6)->add(
                        UiEngine::password(\'password_confirmation\')
                            ->label(\'Confirm New Password\')
                    )
                )
        );
    }

    // Action buttons
    $form->add(
        UiEngine::row()->addClass(\'so-mt-4\')
            ->add(
                UiEngine::col(12)->addClass(\'so-d-flex so-gap-2\')
                    ->add(
                        UiEngine::button(\'Cancel\')
                            ->secondary()
                            ->outline()
                            ->attr(\'onclick\', \'history.back()\')
                    )
                    ->add(
                        UiEngine::submit($buttonText)
                            ->icon($isEdit ? \'content-save\' : \'account-plus\')
                    )
            )
    );

    return $form->render() . $form->exportValidationScript();
}

// Usage in views:
// Create page
echo userForm();

// Edit page
echo userForm($user);') ?>

<!-- Step 6: File Uploads -->
<h2 id="step-6-file-uploads" class="heading heading-2">
    <span class="mdi mdi-numeric-6-circle heading-icon"></span>
    <span class="heading-text">Step 6: Form with File Uploads</span>
</h2>

<p>
    Forms with file uploads including image preview and drag & drop zones.
</p>

<?= codeTabs('step6', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Profile form with avatar upload
$profileForm = UiEngine::form(\'/profile\')
    ->method(\'PUT\')
    ->enctype(\'multipart/form-data\')
    ->add(
        UiEngine::input(\'name\')
            ->label(\'Display Name\')
            ->value($user->name)
            ->required()
    )
    ->add(
        UiEngine::file(\'avatar\')
            ->label(\'Profile Picture\')
            ->images()              // Accept only images
            ->maxSizeMB(5)          // Max 5MB
            ->preview()             // Show image preview
            ->currentValue($user->avatar_url)  // Show current image
            ->help(\'JPG, PNG or GIF. Max 5MB.\')
    )
    ->add(
        UiEngine::textarea(\'bio\')
            ->label(\'Bio\')
            ->value($user->bio)
            ->rows(4)
            ->maxlength(500)
            ->showCounter()
    )
    ->add(
        UiEngine::submit(\'Save Profile\')
    );

echo $profileForm->render();'
    ],
    [
        'label' => 'Dropzone Upload',
        'language' => 'php',
        'code' => '<?php
// Document upload with dropzone
$uploadForm = UiEngine::form(\'/documents\')
    ->method(\'POST\')
    ->enctype(\'multipart/form-data\')
    ->add(
        UiEngine::dropzone(\'files\')
            ->label(\'Upload Documents\')
            ->multiple()
            ->maxFiles(10)
            ->maxSizeMB(25)
            ->accept([
                \'application/pdf\',
                \'application/msword\',
                \'application/vnd.openxmlformats-officedocument.wordprocessingml.document\',
                \'image/*\',
            ])
            ->help(\'Drag & drop files or click to browse. Max 10 files, 25MB each.\')
    )
    ->add(
        UiEngine::select(\'category\')
            ->label(\'Category\')
            ->options([
                \'contracts\' => \'Contracts\',
                \'invoices\' => \'Invoices\',
                \'reports\' => \'Reports\',
            ])
    )
    ->add(
        UiEngine::submit(\'Upload Files\')
            ->icon(\'cloud-upload\')
    );

echo $uploadForm->render();'
    ],
]) ?>

<!-- Step 7: Dynamic Fields -->
<h2 id="step-7-dynamic-fields" class="heading heading-2">
    <span class="mdi mdi-numeric-7-circle heading-icon"></span>
    <span class="heading-text">Step 7: Dynamic Form Fields</span>
</h2>

<p>
    Build forms dynamically from database field definitions or API responses.
</p>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

/**
 * Generate form from field definitions
 *
 * @param array $fields Field definitions from database or config
 * @param string $action Form action URL
 * @param array $values Current values for edit
 */
function dynamicForm(array $fields, string $action, array $values = []): string
{
    $form = UiEngine::form($action)
        ->method(empty($values) ? \'POST\' : \'PUT\')
        ->id(\'dynamic-form\');

    foreach ($fields as $field) {
        $element = match($field[\'type\']) {
            \'text\', \'string\' => UiEngine::input($field[\'name\']),
            \'email\' => UiEngine::email($field[\'name\']),
            \'password\' => UiEngine::password($field[\'name\']),
            \'number\', \'integer\', \'decimal\' => UiEngine::number($field[\'name\']),
            \'textarea\', \'text_long\' => UiEngine::textarea($field[\'name\']),
            \'select\', \'dropdown\' => UiEngine::select($field[\'name\'])
                ->options($field[\'options\'] ?? []),
            \'checkbox\', \'boolean\' => UiEngine::checkbox($field[\'name\']),
            \'radio\' => UiEngine::radio($field[\'name\'])
                ->options($field[\'options\'] ?? []),
            \'date\' => UiEngine::date($field[\'name\']),
            \'datetime\' => UiEngine::datePicker($field[\'name\'])->withTime(),
            \'file\' => UiEngine::file($field[\'name\']),
            \'hidden\' => UiEngine::hidden($field[\'name\']),
            default => UiEngine::input($field[\'name\']),
        };

        // Apply common attributes
        if (!empty($field[\'label\'])) {
            $element->label($field[\'label\']);
        }
        if (!empty($field[\'placeholder\'])) {
            $element->placeholder($field[\'placeholder\']);
        }
        if (!empty($field[\'help\'])) {
            $element->help($field[\'help\']);
        }
        if (!empty($field[\'required\'])) {
            $element->required();
        }
        if (!empty($field[\'rules\'])) {
            $element->rules($field[\'rules\']);
        }
        if (isset($values[$field[\'name\']])) {
            $element->value($values[$field[\'name\']]);
        }

        $form->add($element);
    }

    $form->add(UiEngine::submit(empty($values) ? \'Create\' : \'Update\'));

    return $form->render() . $form->exportValidationScript();
}

// Example usage with field definitions from database
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
        \'options\' => [
            \'tech\' => \'Technology\',
            \'finance\' => \'Finance\',
            \'healthcare\' => \'Healthcare\',
        ],
    ],
    [
        \'name\' => \'employees\',
        \'type\' => \'number\',
        \'label\' => \'Number of Employees\',
    ],
    [
        \'name\' => \'description\',
        \'type\' => \'textarea\',
        \'label\' => \'Description\',
        \'help\' => \'Brief description of the company\',
    ],
];

echo dynamicForm($fieldDefinitions, \'/companies\');') ?>

<!-- Step 8: AJAX Submission -->
<h2 id="step-8-ajax-submission" class="heading heading-2">
    <span class="mdi mdi-numeric-8-circle heading-icon"></span>
    <span class="heading-text">Step 8: AJAX Form Submission</span>
</h2>

<p>
    Enable AJAX submission for forms to avoid page reloads.
</p>

<?= codeTabs('step8', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Enable AJAX mode on form
$form = UiEngine::form(\'/api/users\')
    ->method(\'POST\')
    ->ajax()  // Enables AJAX submission
    ->id(\'ajax-form\')
    ->add(UiEngine::input(\'name\')->label(\'Name\')->required())
    ->add(UiEngine::email(\'email\')->label(\'Email\')->required())
    ->add(UiEngine::submit(\'Save\'));

echo $form->render();
?>

<script>
// Listen for form events
document.getElementById(\'ajax-form\').addEventListener(\'so:form:success\', (e) => {
    console.log(\'Success!\', e.detail.data);
    SOToast.success(\'User created successfully!\');

    // Optionally redirect
    // window.location.href = \'/users/\' + e.detail.data.id;
});

document.getElementById(\'ajax-form\').addEventListener(\'so:form:error\', (e) => {
    console.log(\'Error!\', e.detail.errors);
    // Errors are automatically displayed by ErrorReporter
});
</script>'
    ],
    [
        'label' => 'API Controller',
        'language' => 'php',
        'code' => '<?php
namespace App\Controllers\Api;

use Core\Http\JsonResponse;

class UserApiController
{
    public function store(): JsonResponse
    {
        $validator = new Validator($_POST, [
            \'name\' => \'required|min:2|max:100\',
            \'email\' => \'required|email|unique:users,email\',
        ]);

        if ($validator->fails()) {
            return response()->json([
                \'success\' => false,
                \'errors\' => $validator->errors(),
            ], 422);
        }

        $user = User::create($validator->validated());

        return response()->json([
            \'success\' => true,
            \'message\' => \'User created successfully\',
            \'data\' => [\'id\' => $user->id],
        ], 201);
    }
}'
    ],
]) ?>

<!-- Common Patterns -->
<h2 id="common-patterns" class="heading heading-2">
    <span class="mdi mdi-puzzle heading-icon"></span>
    <span class="heading-text">Common Patterns</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Form in Card</span>
</h3>

<?= codeBlock('php', '// Wrap form in a card
echo UiEngine::card()
    ->header(\'<h5 class="so-mb-0\">Create User</h5>\')
    ->add(
        UiEngine::form(\'/users\')
            ->method(\'POST\')
            ->add(UiEngine::input(\'name\')->label(\'Name\'))
            ->add(UiEngine::email(\'email\')->label(\'Email\'))
            ->add(UiEngine::submit(\'Create\'))
    )
    ->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Form with Sections</span>
</h3>

<?= codeBlock('php', '// Form with visual sections using dividers
$form = UiEngine::form(\'/settings\')
    ->method(\'PUT\')
    // Account section
    ->add(UiEngine::divider(\'Account Information\'))
    ->add(UiEngine::input(\'username\')->label(\'Username\'))
    ->add(UiEngine::email(\'email\')->label(\'Email\'))
    // Security section
    ->add(UiEngine::divider(\'Security\'))
    ->add(UiEngine::password(\'current_password\')->label(\'Current Password\'))
    ->add(UiEngine::password(\'new_password\')->label(\'New Password\'))
    // Preferences section
    ->add(UiEngine::divider(\'Preferences\'))
    ->add(UiEngine::checkbox(\'notifications\')->label(\'Email Notifications\')->switch())
    ->add(UiEngine::checkbox(\'newsletter\')->label(\'Newsletter\')->switch())
    ->add(UiEngine::submit(\'Save Settings\'));') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Inline Forms</span>
</h3>

<?= codeBlock('php', '// Inline search form
echo UiEngine::form(\'/search\')
    ->method(\'GET\')
    ->inline()
    ->add(
        UiEngine::input(\'q\')
            ->placeholder(\'Search...\')
            ->addClass(\'so-me-2\')
    )
    ->add(
        UiEngine::submit(\'Search\')
            ->icon(\'magnify\')
    )
    ->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Checkbox Patterns</span>
</h3>

<?= codeBlock('php', '// Single checkbox with validation
$terms = UiEngine::checkbox(\'terms\')
    ->label(\'I agree to the Terms of Service\')
    ->required(\'You must accept the terms to continue\')
    ->onChange(\'validateTerms(this)\');

// Toggle switch style
$notifications = UiEngine::checkbox(\'notifications\')
    ->label(\'Email Notifications\')
    ->switch()
    ->checked(true)
    ->help(\'Receive updates about your account\');

// Checkbox group (vertical)
$interests = UiEngine::checkbox(\'interests\')
    ->label(\'Select your interests\')
    ->options([
        \'tech\' => \'Technology\',
        \'sports\' => \'Sports\',
        \'music\' => \'Music\',
        \'travel\' => \'Travel\',
    ])
    ->value([\'tech\', \'music\'])  // Pre-select multiple
    ->required(\'Please select at least one interest\');

// Inline checkbox group
$sizes = UiEngine::checkbox(\'sizes\')
    ->label(\'Available sizes\')
    ->inline()
    ->options([
        \'sm\' => \'Small\',
        \'md\' => \'Medium\',
        \'lg\' => \'Large\',
    ]);

// Building options dynamically
$permissions = UiEngine::checkbox(\'permissions\')
    ->label(\'User Permissions\');

foreach ($availablePermissions as $perm) {
    $permissions->option(
        $perm->id,
        $perm->name,
        in_array($perm->id, $userPermissions)  // Pre-check if user has permission
    );
}

// Indeterminate state (for "Select All" patterns)
$selectAll = UiEngine::checkbox(\'select_all\')
    ->label(\'Select All\')
    ->indeterminate()  // Adds data-so-indeterminate="true"
    ->onChange(\'toggleAllItems(this)\');') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Button Patterns</span>
</h3>

<?= codeBlock('php', '// Basic button variants
$primary = UiEngine::button(\'Save\')->primary();
$secondary = UiEngine::button(\'Cancel\')->secondary()->outline();
$danger = UiEngine::button(\'Delete\')->danger();

// Submit and reset buttons (factory methods)
$submit = UiEngine::submit(\'Create Account\');  // type="submit" + primary
$reset = UiEngine::reset(\'Reset Form\');        // type="reset" + secondary

// Buttons with icons
$saveBtn = UiEngine::button(\'Save Changes\')
    ->primary()
    ->icon(\'save\');           // Icon on left (default)

$nextBtn = UiEngine::button(\'Next\')
    ->primary()
    ->icon(\'arrow_forward\', \'right\');  // Icon on right

$deleteBtn = UiEngine::button(\'Delete\')
    ->danger()
    ->outline()
    ->icon(\'delete\');

// Icon-only buttons (for toolbars)
$editIcon = UiEngine::button(\'\')->iconOnly(\'edit\')->secondary()->outline();
$deleteIcon = UiEngine::button(\'\')->iconOnly(\'delete\')->danger()->outline();
$refreshIcon = UiEngine::button(\'\')->iconOnly(\'refresh\')->info();

// Button sizes
$smallBtn = UiEngine::button(\'Small\')->small()->secondary();
$normalBtn = UiEngine::button(\'Normal\')->secondary();
$largeBtn = UiEngine::button(\'Large\')->large()->secondary();

// Full-width button
$blockBtn = UiEngine::submit(\'Sign In\')
    ->block();  // Full width

// Loading state (for async operations)
$loadingBtn = UiEngine::button(\'Processing...\')
    ->primary()
    ->loading(true);

$loadingWithText = UiEngine::button(\'Submit\')
    ->primary()
    ->loading(true, \'Saving...\');  // Changes text when loading

// Link buttons (renders as <a> tag)
$linkBtn = UiEngine::button(\'View Profile\')
    ->secondary()
    ->outline()
    ->href(\'/users/123\');

$externalLink = UiEngine::button(\'Open Docs\')
    ->info()
    ->icon(\'open_in_new\', \'right\')
    ->href(\'https://docs.example.com\')
    ->newTab();  // Opens in new tab

// Button with click handler
$actionBtn = UiEngine::button(\'Show Modal\')
    ->primary()
    ->onClick(\'showModal(\"confirm\")\');

// Button groups in forms
$form->add(
    UiEngine::row()->addClass(\'so-mt-4 so-d-flex so-gap-2 so-justify-content-end\')
        ->add(UiEngine::button(\'Cancel\')->secondary()->outline()->onClick(\'history.back()\'))
        ->add(UiEngine::button(\'Save Draft\')->secondary()->onClick(\'saveDraft()\'))
        ->add(UiEngine::submit(\'Publish\')->success()->icon(\'check\'))
);

// Disabled button
$disabledBtn = UiEngine::button(\'Not Available\')
    ->secondary()
    ->disabled();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Color Input Patterns</span>
</h3>

<?= codeBlock('php', '// Basic color picker
$themeColor = UiEngine::color(\'theme_color\')
    ->label(\'Theme Color\')
    ->value(\'#3b82f6\')
    ->help(\'Choose your primary theme color\');

// With preset swatches
$brandColor = UiEngine::color(\'brand_color\')
    ->label(\'Brand Color\')
    ->presets([
        \'#ef4444\', // Red
        \'#f97316\', // Orange
        \'#eab308\', // Yellow
        \'#22c55e\', // Green
        \'#3b82f6\', // Blue
        \'#8b5cf6\', // Purple
    ])
    ->value(\'#3b82f6\');

// Using Bootstrap color palette
$accentColor = UiEngine::color(\'accent_color\')
    ->label(\'Accent Color\')
    ->bootstrapPresets()
    ->required();

// With text input for manual entry
$bgColor = UiEngine::color(\'bg_color\')
    ->label(\'Background Color\')
    ->showInput()  // Show text input alongside picker
    ->value(\'#ffffff\');

// Different color formats
$rgbColor = UiEngine::color(\'rgb_color\')
    ->label(\'RGB Color\')
    ->rgb()
    ->value(\'rgb(59, 130, 246)\');

// With alpha channel
$overlayColor = UiEngine::color(\'overlay_color\')
    ->label(\'Overlay Color\')
    ->rgb()
    ->alpha()
    ->value(\'rgba(0, 0, 0, 0.5)\');

// With change handler
$liveColor = UiEngine::color(\'live_color\')
    ->label(\'Preview Color\')
    ->value(\'#3b82f6\')
    ->onChange(\'updatePreview(this.value)\')
    ->onInput(\'livePreview(this.value)\');

// Size variants
$smallColor = UiEngine::color(\'small_color\')->small()->value(\'#ef4444\');
$largeColor = UiEngine::color(\'large_color\')->large()->value(\'#22c55e\');

// Disabled state
$lockedColor = UiEngine::color(\'locked_color\')
    ->label(\'Locked Color\')
    ->value(\'#9ca3af\')
    ->disabled();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Form Container Patterns</span>
</h3>

<?= codeBlock('php', '// Basic form with CSRF protection
$form = UiEngine::form(\'/api/users\')
    ->id(\'user-form\')
    ->post()
    ->csrf(csrf_token())
    ->add(UiEngine::input(\'name\')->label(\'Name\')->required())
    ->add(UiEngine::email(\'email\')->label(\'Email\')->required())
    ->add(UiEngine::submit(\'Create User\')->primary());

// AJAX form with loading state
$ajaxForm = UiEngine::form(\'/api/subscribe\')
    ->post()
    ->ajax()                // Enable AJAX submission
    ->showLoading()         // Show spinner on submit button
    ->add(UiEngine::email(\'email\')->placeholder(\'your@email.com\'))
    ->add(UiEngine::submit(\'Subscribe\')->primary());

// RESTful update form (PUT with method override)
$updateForm = UiEngine::form(\'/api/users/123\')
    ->put()                 // Adds hidden _method field
    ->csrf(csrf_token())
    ->add(UiEngine::input(\'name\')->label(\'Name\')->value($user->name))
    ->add(UiEngine::submit(\'Update\')->primary());

// Delete form
$deleteForm = UiEngine::form(\'/api/users/123\')
    ->delete()
    ->csrf(csrf_token())
    ->add(UiEngine::submit(\'Delete\')->danger()->icon(\'delete\'));

// Form with file upload
$uploadForm = UiEngine::form(\'/api/profile\')
    ->post()
    ->multipart()           // Set enctype for file uploads
    ->add(UiEngine::input(\'name\')->label(\'Name\'))
    ->add(UiEngine::file(\'avatar\')->label(\'Profile Picture\')->accept(\'image/*\'))
    ->add(UiEngine::submit(\'Update Profile\'));

// Export validation rules for JavaScript
$form = UiEngine::form(\'/api/users\')
    ->post()
    ->add(UiEngine::input(\'username\')
        ->rules(\'required|min:3|max:20\')
        ->messages([\'required\' => \'Username is required\']))
    ->add(UiEngine::email(\'email\')
        ->rules(\'required|email\'));

// Option 1: Render form with embedded validation script
echo $form->renderWithValidation();

// Option 2: Render separately
echo $form->render();
echo $form->exportValidationScript();

// Option 3: Get rules as JSON for custom handling
$rules = $form->exportValidation();
// Pass to JavaScript: data-validation="<?= e(json_encode($rules)) ?>"') ?>

<!-- Troubleshooting -->
<h2 id="troubleshooting" class="heading heading-2">
    <span class="mdi mdi-help-circle heading-icon"></span>
    <span class="heading-text">Troubleshooting</span>
</h2>

<?= callout('warning', '
    <strong>CSRF Token Missing</strong><br>
    If you see a 419 error, ensure CSRF token is set:
    <pre class="so-mb-0"><code>UiEngine::setCsrfToken(csrf_token());</code></pre>
    This should be done once in your bootstrap or base controller.
') ?>

<?= callout('warning', '
    <strong>Validation Not Working Client-Side</strong><br>
    Make sure to call <code>exportValidationScript()</code> after rendering the form:
    <pre class="so-mb-0"><code>echo $form->render();
echo $form->exportValidationScript();</code></pre>
') ?>

<?= callout('warning', '
    <strong>File Uploads Not Working</strong><br>
    Ensure the form has proper enctype:
    <pre class="so-mb-0"><code>$form->enctype(\'multipart/form-data\');</code></pre>
    This is set automatically when using <code>file()</code> or <code>dropzone()</code> elements.
') ?>

<?= callout('info', '
    <strong>See Also:</strong>
    <ul class="so-mb-0">
        <li><a href="/docs/dev-ui-engine">UiEngine Developer Guide</a></li>
        <li><a href="/docs/dev-ui-engine-elements">Element Reference</a></li>
        <li><a href="/docs/validation-system">Validation System</a></li>
    </ul>
') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
