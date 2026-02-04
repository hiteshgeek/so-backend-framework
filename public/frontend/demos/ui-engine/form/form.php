<?php
/**
 * SixOrbit UI Engine - Form Element Demo
 *
 * Complete documentation and examples for the Form container element
 * with validation, AJAX submission, and field management.
 */

$pageTitle = 'Form - UI Engine';
$pageDescription = 'Form container with validation and submission handling';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Form</h1>
            <p class="so-page-subtitle">Form container element with built-in validation, AJAX submission, CSRF protection, and field management.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Form -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Form</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">A simple form with text input, email, and textarea fields.</p>

                <!-- Live Demo -->
                <div class="so-p-3 so-bg-light so-rounded so-mb-3">
                    <form action="/api/contact" method="POST" id="demo-basic-form">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-name">Name</label>
                            <input type="text" class="so-form-control" id="demo-name" name="name" required>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-email">Email</label>
                            <input type="email" class="so-form-control" id="demo-email" name="email" required>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-message">Message</label>
                            <textarea class="so-form-control" id="demo-message" name="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="so-btn so-btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-form', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\\UiEngine\\UiEngine;

\$form = UiEngine::form('/api/contact')
    ->id('contact-form')
    ->method('POST')
    ->add(UiEngine::input('name')
        ->label('Name')
        ->required())
    ->add(UiEngine::email('email')
        ->label('Email')
        ->required())
    ->add(UiEngine::textarea('message')
        ->label('Message')
        ->rows(3))
    ->add(UiEngine::submit('Submit')
        ->primary());

echo \$form->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { UiEngine } from 'sixorbit-ui';

const form = UiEngine.form('/api/contact')
    .id('contact-form')
    .method('POST')
    .add(UiEngine.input('name')
        .label('Name')
        .required())
    .add(UiEngine.email('email')
        .label('Email')
        .required())
    .add(UiEngine.textarea('message')
        .label('Message')
        .rows(3))
    .add(UiEngine.submit('Submit')
        .primary());

document.getElementById('container').appendChild(form.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<form action="/api/contact" method="POST" id="contact-form">
    <div class="so-form-group">
        <label class="so-form-label" for="name">Name</label>
        <input type="text" class="so-form-control" id="name" name="name" required>
    </div>
    <div class="so-form-group">
        <label class="so-form-label" for="email">Email</label>
        <input type="email" class="so-form-control" id="email" name="email" required>
    </div>
    <div class="so-form-group">
        <label class="so-form-label" for="message">Message</label>
        <textarea class="so-form-control" id="message" name="message" rows="3"></textarea>
    </div>
    <button type="submit" class="so-btn so-btn-primary">Submit</button>
</form>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- HTTP Methods -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">HTTP Methods</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Forms support GET, POST, PUT, PATCH, and DELETE methods. Non-standard methods use a hidden <code>_method</code> field for method spoofing.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('http-methods', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// GET form (search, filters)
\$searchForm = UiEngine::form('/search')
    ->get()
    ->add(UiEngine::input('q')->placeholder('Search...'))
    ->add(UiEngine::submit('Search'));

// POST form (create)
\$createForm = UiEngine::form('/api/users')
    ->post()
    ->add(UiEngine::input('name')->label('Name'))
    ->add(UiEngine::submit('Create'));

// PUT form (full update) - adds hidden _method field
\$updateForm = UiEngine::form('/api/users/123')
    ->put()
    ->add(UiEngine::input('name')->label('Name'))
    ->add(UiEngine::submit('Update'));

// PATCH form (partial update)
\$patchForm = UiEngine::form('/api/users/123')
    ->patch()
    ->add(UiEngine::input('email')->label('Email'))
    ->add(UiEngine::submit('Update Email'));

// DELETE form (delete action)
\$deleteForm = UiEngine::form('/api/users/123')
    ->delete()
    ->add(UiEngine::submit('Delete')->danger());"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// GET form (search, filters)
const searchForm = UiEngine.form('/search')
    .get()
    .add(UiEngine.input('q').placeholder('Search...'))
    .add(UiEngine.submit('Search'));

// POST form (create)
const createForm = UiEngine.form('/api/users')
    .post()
    .add(UiEngine.input('name').label('Name'))
    .add(UiEngine.submit('Create'));

// PUT form (full update) - adds hidden _method field
const updateForm = UiEngine.form('/api/users/123')
    .put()
    .add(UiEngine.input('name').label('Name'))
    .add(UiEngine.submit('Update'));

// PATCH form (partial update)
const patchForm = UiEngine.form('/api/users/123')
    .patch()
    .add(UiEngine.input('email').label('Email'))
    .add(UiEngine.submit('Update Email'));

// DELETE form (delete action)
const deleteForm = UiEngine.form('/api/users/123')
    .delete()
    .add(UiEngine.submit('Delete').danger());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- PUT form with method override -->
<form action="/api/users/123" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <div class="so-form-group">
        <label class="so-form-label">Name</label>
        <input type="text" class="so-form-control" name="name">
    </div>
    <button type="submit" class="so-btn so-btn-primary">Update</button>
</form>

<!-- DELETE form with method override -->
<form action="/api/users/123" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit" class="so-btn so-btn-danger">Delete</button>
</form>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- CSRF Protection -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSRF Protection</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add CSRF token protection to prevent cross-site request forgery attacks.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('csrf', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Add CSRF token with default field name '_token'
\$form = UiEngine::form('/api/users')
    ->post()
    ->csrf(csrf_token())
    ->add(UiEngine::input('name')->label('Name'))
    ->add(UiEngine::submit('Create'));

// Custom field name
\$form = UiEngine::form('/api/users')
    ->post()
    ->csrf(csrf_token(), 'csrf_token')
    ->add(UiEngine::input('name')->label('Name'))
    ->add(UiEngine::submit('Create'));"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<form action="/api/users" method="POST">
    <input type="hidden" name="_token" value="abc123...">
    <div class="so-form-group">
        <label class="so-form-label">Name</label>
        <input type="text" class="so-form-control" name="name">
    </div>
    <button type="submit" class="so-btn so-btn-primary">Create</button>
</form>'
                    ],
                ]) ?>

                <div class="so-alert so-alert-info so-mt-3">
                    <strong>Note:</strong> CSRF protection is server-side only. The JavaScript Form class does not include CSRF methods as tokens should be generated server-side.
                </div>
            </div>
        </div>

        <!-- Form with Validation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Form with Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Enable client-side validation with custom rules and error messages.</p>

                <!-- Live Demo -->
                <div class="so-p-3 so-bg-light so-rounded so-mb-3">
                    <form action="/api/register" method="POST" id="demo-validation-form" novalidate>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-username">Username <span class="so-text-danger">*</span></label>
                            <input type="text" class="so-form-control" id="demo-username" name="username" required minlength="3" maxlength="20">
                            <div class="so-form-text">3-20 characters, letters and numbers only</div>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-reg-email">Email <span class="so-text-danger">*</span></label>
                            <input type="email" class="so-form-control" id="demo-reg-email" name="email" required>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-password">Password <span class="so-text-danger">*</span></label>
                            <input type="password" class="so-form-control" id="demo-password" name="password" required minlength="8">
                            <div class="so-form-text">At least 8 characters</div>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-password-confirm">Confirm Password <span class="so-text-danger">*</span></label>
                            <input type="password" class="so-form-control" id="demo-password-confirm" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="so-btn so-btn-primary">Register</button>
                    </form>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('form-validation', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$form = UiEngine::form('/api/register')
    ->id('registration-form')
    ->method('POST')
    ->novalidate()  // Disable browser validation, use custom
    ->add(UiEngine::input('username')
        ->label('Username')
        ->required()
        ->rules('required|min:3|max:20|alpha_num')
        ->messages([
            'required' => 'Username is required',
            'min' => 'Username must be at least 3 characters',
            'max' => 'Username cannot exceed 20 characters',
            'alpha_num' => 'Username can only contain letters and numbers',
        ])
        ->help('3-20 characters, letters and numbers only'))
    ->add(UiEngine::email('email')
        ->label('Email')
        ->required()
        ->rules('required|email')
        ->messages([
            'required' => 'Email is required',
            'email' => 'Please enter a valid email address',
        ]))
    ->add(UiEngine::password('password')
        ->label('Password')
        ->required()
        ->rules('required|min:8')
        ->messages([
            'required' => 'Password is required',
            'min' => 'Password must be at least 8 characters',
        ])
        ->help('At least 8 characters'))
    ->add(UiEngine::password('password_confirmation')
        ->label('Confirm Password')
        ->required()
        ->rules('required|same:password')
        ->messages([
            'required' => 'Please confirm your password',
            'same' => 'Passwords do not match',
        ]))
    ->add(UiEngine::submit('Register')->primary());

// Render with validation script
echo \$form->renderWithValidation();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const form = UiEngine.form('/api/register')
    .id('registration-form')
    .method('POST')
    .novalidate()
    .add(UiEngine.input('username')
        .label('Username')
        .required()
        .setRules({
            required: true,
            min: 3,
            max: 20,
            alpha_num: true
        })
        .setMessages({
            required: 'Username is required',
            min: 'Username must be at least 3 characters',
            max: 'Username cannot exceed 20 characters',
            alpha_num: 'Username can only contain letters and numbers'
        })
        .setHelp('3-20 characters, letters and numbers only'))
    .add(UiEngine.email('email')
        .label('Email')
        .required()
        .setRules({ required: true, email: true })
        .setMessages({
            required: 'Email is required',
            email: 'Please enter a valid email address'
        }))
    .add(UiEngine.password('password')
        .label('Password')
        .required()
        .setRules({ required: true, min: 8 })
        .setMessages({
            required: 'Password is required',
            min: 'Password must be at least 8 characters'
        })
        .setHelp('At least 8 characters'))
    .add(UiEngine.password('password_confirmation')
        .label('Confirm Password')
        .required()
        .setRules({ required: true, same: 'password' })
        .setMessages({
            required: 'Please confirm your password',
            same: 'Passwords do not match'
        }))
    .add(UiEngine.submit('Register').primary());

document.getElementById('container').appendChild(form.render());"
                    ],
                    [
                        'label' => 'Validation Rules',
                        'language' => 'javascript',
                        'icon' => 'check_circle',
                        'code' => "// Available validation rules
{
    required: true,              // Field must have a value
    email: true,                 // Must be valid email format
    url: true,                   // Must be valid URL
    numeric: true,               // Must be numeric
    integer: true,               // Must be an integer
    alpha: true,                 // Letters only
    alpha_num: true,             // Letters and numbers only
    min: 3,                      // Minimum length or value
    max: 20,                     // Maximum length or value
    between: [3, 20],            // Between min and max
    regex: /^[a-z]+\$/i,          // Must match regex pattern
    same: 'field_name',          // Must match another field
    different: 'field_name',     // Must differ from another field
    in: ['opt1', 'opt2'],        // Must be one of values
    not_in: ['banned'],          // Must not be one of values
    date: true,                  // Must be valid date
    before: '2025-12-31',        // Date must be before
    after: '2020-01-01',         // Date must be after
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- AJAX Form Submission -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">AJAX Form Submission</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Submit forms via AJAX with loading states, success callbacks, and error handling.</p>

                <!-- Live Demo -->
                <div class="so-p-3 so-bg-light so-rounded so-mb-3">
                    <form action="/api/subscribe" method="POST" id="demo-ajax-form" data-so-ajax="true">
                        <div class="so-d-flex so-gap-2 so-align-items-end">
                            <div class="so-form-group so-mb-0" style="flex: 1;">
                                <label class="so-form-label" for="demo-subscribe-email">Email <span class="so-text-danger">*</span></label>
                                <input type="email" class="so-form-control" id="demo-subscribe-email" name="email" placeholder="your@email.com" required>
                            </div>
                            <button type="submit" class="so-btn so-btn-primary">Subscribe</button>
                        </div>
                    </form>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('form-ajax', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$form = UiEngine::form('/api/subscribe')
    ->id('subscribe-form')
    ->method('POST')
    ->ajax()  // Enable AJAX submission
    ->showLoading()  // Show loading state on submit button
    ->on('submit', 'handleSubscribe')  // PHP event attribute
    ->add(UiEngine::email('email')
        ->label('Email')
        ->placeholder('your@email.com')
        ->required())
    ->add(UiEngine::submit('Subscribe')->primary());

echo \$form->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const form = UiEngine.form('/api/subscribe')
    .id('subscribe-form')
    .method('POST')
    .ajax()
    .showLoading()
    .onSubmit(async (e, formInstance) => {
        e.preventDefault();

        // Validate before submit
        if (!formInstance.validate()) {
            formInstance.reportValidity();
            return;
        }

        try {
            const response = await fetch(formInstance._action, {
                method: 'POST',
                body: formInstance.getFormData()
            });

            const data = await response.json();

            if (response.ok) {
                alert('Subscribed successfully!');
                formInstance.resetForm();
            } else {
                // Handle validation errors
                if (data.errors) {
                    formInstance.setErrors(data.errors);
                }
            }
        } catch (error) {
            console.error('Subscription failed:', error);
        }
    })
    .add(UiEngine.email('email')
        .label('Email')
        .placeholder('your@email.com')
        .required())
    .add(UiEngine.submit('Subscribe').primary());

document.getElementById('container').appendChild(form.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<form action="/api/subscribe" method="POST" id="subscribe-form" data-so-ajax="true">
    <div class="so-form-group">
        <label class="so-form-label" for="email">Email <span class="so-text-danger">*</span></label>
        <input type="email" class="so-form-control" id="email" name="email" placeholder="your@email.com" required>
    </div>
    <button type="submit" class="so-btn so-btn-primary">Subscribe</button>
</form>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Form Layouts -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Form Layouts</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Different form layouts: vertical (default), horizontal, and inline.</p>

                <!-- Horizontal Layout Demo -->
                <h6 class="so-mb-3">Horizontal Layout</h6>
                <div class="so-p-3 so-bg-light so-rounded so-mb-4">
                    <form>
                        <div class="so-grid so-grid-cols-12 so-gap-3 so-mb-3 so-align-items-center">
                            <label class="so-col-span-3 so-form-label so-mb-0">Email</label>
                            <div class="so-col-span-9">
                                <input type="email" class="so-form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="so-grid so-grid-cols-12 so-gap-3 so-mb-3 so-align-items-center">
                            <label class="so-col-span-3 so-form-label so-mb-0">Password</label>
                            <div class="so-col-span-9">
                                <input type="password" class="so-form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="so-grid so-grid-cols-12 so-gap-3">
                            <div class="so-col-span-9 so-col-start-4">
                                <button type="submit" class="so-btn so-btn-primary">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Inline Layout Demo -->
                <h6 class="so-mb-3">Inline Layout</h6>
                <div class="so-p-3 so-bg-light so-rounded so-mb-3">
                    <form class="so-d-flex so-gap-2 so-align-items-end so-flex-wrap">
                        <div class="so-form-group so-mb-0">
                            <label class="so-form-label" for="inline-search">Search</label>
                            <input type="text" class="so-form-control" id="inline-search" placeholder="Search...">
                        </div>
                        <div class="so-form-group so-mb-0">
                            <label class="so-form-label" for="inline-category">Category</label>
                            <select class="so-form-select" id="inline-category">
                                <option value="">All</option>
                                <option value="1">Electronics</option>
                                <option value="2">Clothing</option>
                            </select>
                        </div>
                        <button type="submit" class="so-btn so-btn-primary">Search</button>
                    </form>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('form-layouts', [
                    [
                        'label' => 'Horizontal',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Horizontal form using grid layout
\$form = UiEngine::form('/login')
    ->post()
    ->add(
        UiEngine::row()
            ->addClass('so-align-items-center so-mb-3')
            ->add(UiEngine::col(3)->add(
                UiEngine::label('Email')->addClass('so-mb-0')
            ))
            ->add(UiEngine::col(9)->add(
                UiEngine::email('email')->placeholder('Email')
            ))
    )
    ->add(
        UiEngine::row()
            ->addClass('so-align-items-center so-mb-3')
            ->add(UiEngine::col(3)->add(
                UiEngine::label('Password')->addClass('so-mb-0')
            ))
            ->add(UiEngine::col(9)->add(
                UiEngine::password('password')->placeholder('Password')
            ))
    )
    ->add(
        UiEngine::row()
            ->add(UiEngine::col(9)->offset(3)->add(
                UiEngine::submit('Sign in')->primary()
            ))
    );"
                    ],
                    [
                        'label' => 'Inline',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Inline form layout
\$form = UiEngine::form('/search')
    ->get()
    ->addClass('so-d-flex so-gap-2 so-align-items-end so-flex-wrap')
    ->add(UiEngine::input('q')
        ->label('Search')
        ->placeholder('Search...'))
    ->add(UiEngine::select('category')
        ->label('Category')
        ->options([
            '' => 'All',
            '1' => 'Electronics',
            '2' => 'Clothing',
        ]))
    ->add(UiEngine::submit('Search')->primary());"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Horizontal form
const horizontalForm = UiEngine.form('/login')
    .post()
    .add(
        UiEngine.row()
            .addClass('so-align-items-center so-mb-3')
            .add(UiEngine.col(3).add(
                UiEngine.label('Email').addClass('so-mb-0')
            ))
            .add(UiEngine.col(9).add(
                UiEngine.email('email').placeholder('Email')
            ))
    );

// Inline form
const inlineForm = UiEngine.form('/search')
    .get()
    .addClass('so-d-flex so-gap-2 so-align-items-end so-flex-wrap')
    .add(UiEngine.input('q').label('Search').placeholder('Search...'))
    .add(UiEngine.select('category').label('Category').options({
        '': 'All',
        '1': 'Electronics',
        '2': 'Clothing'
    }))
    .add(UiEngine.submit('Search').primary());"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Form with File Upload -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Form with File Upload</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Enable file uploads with <code>multipart()</code> method which sets <code>enctype="multipart/form-data"</code>.</p>

                <!-- Live Demo -->
                <div class="so-p-3 so-bg-light so-rounded so-mb-3">
                    <form action="/api/profile" method="POST" enctype="multipart/form-data" id="demo-file-form">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-profile-name">Name <span class="so-text-danger">*</span></label>
                            <input type="text" class="so-form-control" id="demo-profile-name" name="name" required>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label" for="demo-avatar">Profile Picture</label>
                            <input type="file" class="so-form-control" id="demo-avatar" name="avatar" accept="image/*">
                            <div class="so-form-text">Max size: 2MB. Accepted formats: JPG, PNG, GIF</div>
                        </div>
                        <button type="submit" class="so-btn so-btn-primary">Update Profile</button>
                    </form>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('form-file', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$form = UiEngine::form('/api/profile')
    ->method('POST')
    ->multipart()  // Enable file uploads
    ->add(UiEngine::input('name')
        ->label('Name')
        ->required())
    ->add(UiEngine::file('avatar')
        ->label('Profile Picture')
        ->accept('image/*')
        ->help('Max size: 2MB. Accepted formats: JPG, PNG, GIF'))
    ->add(UiEngine::submit('Update Profile')->primary());

echo \$form->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const form = UiEngine.form('/api/profile')
    .method('POST')
    .multipart()
    .add(UiEngine.input('name')
        .label('Name')
        .required())
    .add(UiEngine.file('avatar')
        .label('Profile Picture')
        .accept('image/*')
        .setHelp('Max size: 2MB. Accepted formats: JPG, PNG, GIF'))
    .add(UiEngine.submit('Update Profile').primary());

document.getElementById('container').appendChild(form.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<form action="/api/profile" method="POST" enctype="multipart/form-data">
    <div class="so-form-group">
        <label class="so-form-label" for="name">Name <span class="so-text-danger">*</span></label>
        <input type="text" class="so-form-control" id="name" name="name" required>
    </div>
    <div class="so-form-group">
        <label class="so-form-label" for="avatar">Profile Picture</label>
        <input type="file" class="so-form-control" id="avatar" name="avatar" accept="image/*">
        <div class="so-form-text">Max size: 2MB. Accepted formats: JPG, PNG, GIF</div>
    </div>
    <button type="submit" class="so-btn so-btn-primary">Update Profile</button>
</form>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Form States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Form Attributes & States</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Configure form behavior with various attributes.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('form-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Disable browser validation (use custom validation)
\$form = UiEngine::form('/api/data')
    ->novalidate();

// Disable autocomplete (for sensitive forms)
\$form = UiEngine::form('/api/login')
    ->noAutocomplete();
    // or
    ->autocomplete('off');

// Open in new tab
\$form = UiEngine::form('/external/process')
    ->newTab();
    // or
    ->target('_blank');

// Custom target frame
\$form = UiEngine::form('/api/report')
    ->target('report-frame');

// Disable loading state on submit
\$form = UiEngine::form('/api/data')
    ->ajax()
    ->showLoading(false);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Disable browser validation
const form = UiEngine.form('/api/data')
    .novalidate();

// Disable autocomplete
const loginForm = UiEngine.form('/api/login')
    .noAutocomplete();

// Open in new tab
const externalForm = UiEngine.form('/external/process')
    .newTab();

// Custom target
const reportForm = UiEngine.form('/api/report')
    .target('report-frame');

// AJAX without loading state
const silentForm = UiEngine.form('/api/data')
    .ajax()
    .showLoading(false);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Novalidate -->
<form action="/api/data" method="POST" novalidate>...</form>

<!-- No autocomplete -->
<form action="/api/login" method="POST" autocomplete="off">...</form>

<!-- New tab -->
<form action="/external/process" method="POST" target="_blank">...</form>

<!-- AJAX form -->
<form action="/api/data" method="POST" data-so-ajax="true">...</form>

<!-- AJAX without loading state -->
<form action="/api/data" method="POST" data-so-ajax="true" data-so-no-loading="true">...</form>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- JavaScript Interactivity -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript Interactivity</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Runtime methods for form manipulation, data access, and submission.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('js-methods', [
                    [
                        'label' => 'Form Data',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get FormData object (for AJAX submission)
const formData = form.getFormData();

// Get all values as object
const values = form.getValues();
console.log(values);
// { username: 'john', email: 'john@example.com', ... }

// Set multiple values at once
form.setValues({
    username: 'jane',
    email: 'jane@example.com',
    bio: 'Hello world'
});

// Reset form to initial state
form.resetForm();

// Programmatically submit
form.submitForm();"
                    ],
                    [
                        'label' => 'Validation',
                        'language' => 'javascript',
                        'icon' => 'check_circle',
                        'code' => "// Check if form is valid (silent)
const isValid = form.validate();

// Check validity and show browser UI feedback
const isValidWithUI = form.reportValidity();

// Export all validation rules from child elements
const validationRules = form.exportValidation();
console.log(validationRules);
// {
//   username: { rules: { required: true, min: 3 }, messages: { ... } },
//   email: { rules: { required: true, email: true }, messages: { ... } }
// }

// Manual validation with custom logic
form.onSubmit((e, formInstance) => {
    e.preventDefault();

    if (!formInstance.validate()) {
        formInstance.reportValidity();
        return;
    }

    // Custom validation
    const values = formInstance.getValues();
    if (values.password !== values.password_confirmation) {
        alert('Passwords do not match');
        return;
    }

    // Proceed with submission
    submitData(values);
});"
                    ],
                    [
                        'label' => 'Children',
                        'language' => 'javascript',
                        'icon' => 'account_tree',
                        'code' => "// Add elements dynamically
form.add(UiEngine.input('phone').label('Phone'));

// Add multiple elements
form.addMany([
    UiEngine.input('address').label('Address'),
    UiEngine.input('city').label('City')
]);

// Prepend element
form.prepend(UiEngine.hidden('action', 'create'));

// Insert at specific position
form.insertAt(2, UiEngine.input('middle_name').label('Middle Name'));

// Remove element by instance or ID
form.remove(phoneInput);
form.remove('phone-input');

// Clear all children
form.clear();

// Find element by ID
const emailField = form.find('email-input');

// Find by field name
const usernameField = form.findByName('username');

// Get all form elements
const allFields = form.getFormElements();

// Iterate over children
form.each(child => {
    console.log(child.getName?.());
});"
                    ],
                    [
                        'label' => 'Error Handling',
                        'language' => 'javascript',
                        'icon' => 'error',
                        'code' => "// Set errors on multiple fields (from server response)
form.setErrors({
    username: 'Username is already taken',
    email: ['Invalid email format', 'Email domain not allowed']
});

// Clear all errors
form.clearErrors();

// Fill form with data (e.g., for edit mode)
form.fill({
    username: 'johndoe',
    email: 'john@example.com',
    bio: 'Developer'
});

// Example: Handle server validation errors
async function handleSubmit(e, formInstance) {
    e.preventDefault();
    formInstance.clearErrors();

    try {
        const response = await fetch(formInstance._action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formInstance.getValues())
        });

        const data = await response.json();

        if (!response.ok) {
            // Display validation errors
            if (data.errors) {
                formInstance.setErrors(data.errors);
            }
            return;
        }

        // Success
        window.location.href = data.redirect || '/success';

    } catch (error) {
        console.error('Submission failed:', error);
    }
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Events -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Form elements use native DOM events. Listen for these events to respond to user interactions.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('events', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Add event handlers via PHP (renders as HTML attributes)
\$form = UiEngine::form('/api/data')
    ->on('submit', 'handleFormSubmit(event)')
    ->on('reset', 'handleFormReset(event)')
    ->add(UiEngine::input('name')
        ->on('input', 'validateField(this)')
        ->on('blur', 'formatField(this)'));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Using the onSubmit fluent method
const form = UiEngine.form('/api/data')
    .onSubmit((e, formInstance) => {
        e.preventDefault();
        console.log('Form submitted:', formInstance.getValues());
    });

// Attach events after render
const formEl = form.render();

// Native form events
formEl.addEventListener('submit', (e) => {
    e.preventDefault();
    console.log('Submit event');
});

formEl.addEventListener('reset', () => {
    console.log('Form reset');
});

formEl.addEventListener('change', (e) => {
    console.log('Field changed:', e.target.name, e.target.value);
});

formEl.addEventListener('input', (e) => {
    console.log('Input event:', e.target.name);
});

// FormData event (modern browsers)
formEl.addEventListener('formdata', (e) => {
    // Modify form data before submission
    e.formData.append('timestamp', Date.now());
});"
                    ],
                    [
                        'label' => 'Event Types',
                        'language' => 'javascript',
                        'icon' => 'list',
                        'code' => "// Native form events (no so: prefix needed)
// These are standard DOM events

'submit'     // Form is submitted
'reset'      // Form is reset
'change'     // A form field value changes (after blur)
'input'      // User types in a field (immediate)
'invalid'    // Field fails validation
'formdata'   // FormData object is constructed

// Note: Form elements use native events because
// they integrate with browser form handling.
// Custom so: prefixed events are used for
// UI components that don't have native equivalents."
                    ],
                ]) ?>

                <div class="so-alert so-alert-info so-mt-3">
                    <strong>Note:</strong> Form elements use native DOM events (<code>submit</code>, <code>reset</code>, <code>change</code>, <code>input</code>) rather than custom <code>so:</code> prefixed events. This ensures compatibility with browser form handling and accessibility features.
                </div>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Handle validation errors from server responses and display them on form fields.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('error-handling', [
                    [
                        'label' => 'PHP Server',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// In your controller - return validation errors as JSON
public function store(Request \$request)
{
    \$validator = Validator::make(\$request->all(), [
        'username' => 'required|min:3|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
    ]);

    if (\$validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => \$validator->errors()
        ], 422);
    }

    // Create user...

    return response()->json([
        'success' => true,
        'redirect' => '/dashboard'
    ]);
}

// Pre-populate form with errors (non-AJAX)
\$form = UiEngine::form('/api/users')
    ->post();

// If there are validation errors from previous submission
if (\$errors = session('errors')) {
    \$form->add(UiEngine::input('username')
        ->label('Username')
        ->value(old('username'))
        ->error(\$errors->first('username')));

    \$form->add(UiEngine::email('email')
        ->label('Email')
        ->value(old('email'))
        ->error(\$errors->first('email')));
}"
                    ],
                    [
                        'label' => 'JavaScript Client',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Handle server validation errors
async function submitForm(form) {
    // Clear previous errors
    form.clearErrors();

    try {
        const response = await fetch(form._action, {
            method: form._method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content
            },
            body: JSON.stringify(form.getValues())
        });

        const data = await response.json();

        if (!response.ok) {
            // 422 Validation Error
            if (response.status === 422 && data.errors) {
                form.setErrors(data.errors);

                // Scroll to first error
                const firstError = document.querySelector('.so-is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            } else {
                // Other errors
                alert(data.message || 'An error occurred');
            }
            return;
        }

        // Success
        if (data.redirect) {
            window.location.href = data.redirect;
        }

    } catch (error) {
        console.error('Network error:', error);
        alert('Network error. Please try again.');
    }
}

// Error response format expected:
// {
//   \"success\": false,
//   \"errors\": {
//     \"username\": [\"Username is already taken\"],
//     \"email\": [\"Invalid email format\"]
//   }
// }"
                    ],
                    [
                        'label' => 'Manual Errors',
                        'language' => 'javascript',
                        'icon' => 'error',
                        'code' => "// Set error on specific field
const usernameField = form.findByName('username');
if (usernameField) {
    usernameField.setError('Username is already taken');
}

// Clear error on specific field
usernameField.clearError();

// Set multiple errors at once
form.setErrors({
    username: 'Username is required',
    email: 'Please enter a valid email',
    password: ['Password is too short', 'Password must contain a number']
});

// Clear all form errors
form.clearErrors();

// Check if form has any errors
const hasErrors = form.getFormElements().some(el =>
    typeof el.hasError === 'function' && el.hasError()
);"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Pass form configuration from PHP to JavaScript for dynamic initialization.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('php-to-js', [
                    [
                        'label' => 'PHP Export',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Build form in PHP
\$form = UiEngine::form('/api/users')
    ->id('user-form')
    ->post()
    ->add(UiEngine::input('username')
        ->label('Username')
        ->required()
        ->rules('required|min:3'))
    ->add(UiEngine::email('email')
        ->label('Email')
        ->required()
        ->rules('required|email'))
    ->add(UiEngine::submit('Create User')->primary());

// Export as JSON config
\$config = \$form->toArray();

// Export validation rules for JS
\$validation = \$form->exportValidation();

// Render with embedded config
?>
<div id=\"form-container\"
     data-form-config=\"<?= e(json_encode(\$config)) ?>\"
     data-form-validation=\"<?= e(json_encode(\$validation)) ?>\">
    <?= \$form->render() ?>
</div>

<script>
// Access config in JavaScript
const container = document.getElementById('form-container');
const config = JSON.parse(container.dataset.formConfig);
const validation = JSON.parse(container.dataset.formValidation);

console.log('Form config:', config);
console.log('Validation rules:', validation);
</script>"
                    ],
                    [
                        'label' => 'JS Initialization',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Initialize form from PHP config
const container = document.getElementById('form-container');
const config = JSON.parse(container.dataset.formConfig);

// Create form instance from config
const form = UiEngine.fromConfig(config);

// Or manually initialize validation on existing form
const existingForm = document.getElementById('user-form');
const validation = JSON.parse(container.dataset.formValidation);

// Apply validation rules to form fields
Object.entries(validation).forEach(([fieldName, fieldRules]) => {
    const field = existingForm.querySelector('[name=\"' + fieldName + '\"]');
    if (field) {
        // Store validation config on element
        field.dataset.validation = JSON.stringify(fieldRules);
    }
});

// Load validation via UiEngine helper
UiEngine.loadValidation('user-form', validation);"
                    ],
                    [
                        'label' => 'Config Structure',
                        'language' => 'javascript',
                        'icon' => 'code',
                        'code' => "// Form config structure from toArray()
{
    \"type\": \"form\",
    \"id\": \"user-form\",
    \"action\": \"/api/users\",
    \"method\": \"POST\",
    \"ajax\": false,
    \"showLoading\": true,
    \"children\": [
        {
            \"type\": \"input\",
            \"name\": \"username\",
            \"label\": \"Username\",
            \"required\": true,
            \"rules\": {
                \"required\": true,
                \"min\": 3
            },
            \"messages\": {
                \"required\": \"Username is required\"
            }
        },
        {
            \"type\": \"email\",
            \"name\": \"email\",
            \"label\": \"Email\",
            \"required\": true
        }
    ]
}

// Validation export structure
{
    \"username\": {
        \"rules\": { \"required\": true, \"min\": 3 },
        \"messages\": { \"required\": \"Username is required\" }
    },
    \"email\": {
        \"rules\": { \"required\": true, \"email\": true },
        \"messages\": {}
    }
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th style="width: 35%;">Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so-form-group</code></td>
                                <td>Wrapper for label + input + help text + error</td>
                            </tr>
                            <tr>
                                <td><code>so-form-label</code></td>
                                <td>Label element styling</td>
                            </tr>
                            <tr>
                                <td><code>so-form-control</code></td>
                                <td>Base input/textarea/select styling</td>
                            </tr>
                            <tr>
                                <td><code>so-form-select</code></td>
                                <td>Select element styling</td>
                            </tr>
                            <tr>
                                <td><code>so-form-text</code></td>
                                <td>Help text below input</td>
                            </tr>
                            <tr>
                                <td><code>so-is-invalid</code></td>
                                <td>Error state for form controls</td>
                            </tr>
                            <tr>
                                <td><code>so-is-valid</code></td>
                                <td>Valid state for form controls</td>
                            </tr>
                            <tr>
                                <td><code>so-invalid-feedback</code></td>
                                <td>Error message display</td>
                            </tr>
                            <tr>
                                <td><code>so-valid-feedback</code></td>
                                <td>Success message display</td>
                            </tr>
                            <tr>
                                <td><code>so-form-floating</code></td>
                                <td>Floating label wrapper</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <!-- Tabs Navigation -->
                <div class="so-tabs so-mb-3" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#form-methods">Form Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#container-methods">Container Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#runtime-methods">Runtime Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#base-methods">Base Element</button>
                </div>

                <!-- Tab Panes -->
                <div class="so-tab-content">
                    <!-- Form Methods -->
                    <div class="so-tab-pane so-fade so-show so-active" id="form-methods">
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 40%;">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Constructor</strong></td></tr>
                                    <tr>
                                        <td><code>UiEngine::form($action)</code></td>
                                        <td>Create form with optional action URL</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>HTTP Methods</strong></td></tr>
                                    <tr>
                                        <td><code>action($url)</code></td>
                                        <td>Set form action URL</td>
                                    </tr>
                                    <tr>
                                        <td><code>method($method)</code></td>
                                        <td>Set HTTP method: GET, POST, PUT, PATCH, DELETE</td>
                                    </tr>
                                    <tr>
                                        <td><code>get()</code></td>
                                        <td>Shortcut for GET method</td>
                                    </tr>
                                    <tr>
                                        <td><code>post()</code></td>
                                        <td>Shortcut for POST method</td>
                                    </tr>
                                    <tr>
                                        <td><code>put()</code></td>
                                        <td>PUT method (adds _method hidden field)</td>
                                    </tr>
                                    <tr>
                                        <td><code>patch()</code></td>
                                        <td>PATCH method (adds _method hidden field)</td>
                                    </tr>
                                    <tr>
                                        <td><code>delete()</code></td>
                                        <td>DELETE method (adds _method hidden field)</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Form Attributes</strong></td></tr>
                                    <tr>
                                        <td><code>enctype($type)</code></td>
                                        <td>Set encoding type</td>
                                    </tr>
                                    <tr>
                                        <td><code>multipart()</code></td>
                                        <td>Enable multipart/form-data for file uploads</td>
                                    </tr>
                                    <tr>
                                        <td><code>target($target)</code></td>
                                        <td>Set form target (_self, _blank, frame name)</td>
                                    </tr>
                                    <tr>
                                        <td><code>newTab()</code></td>
                                        <td>Open result in new tab (target="_blank")</td>
                                    </tr>
                                    <tr>
                                        <td><code>novalidate($val = true)</code></td>
                                        <td>Disable browser validation</td>
                                    </tr>
                                    <tr>
                                        <td><code>autocomplete($val)</code></td>
                                        <td>Set autocomplete: on, off</td>
                                    </tr>
                                    <tr>
                                        <td><code>noAutocomplete()</code></td>
                                        <td>Disable autocomplete</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>AJAX & Security (PHP only)</strong></td></tr>
                                    <tr>
                                        <td><code>ajax($val = true)</code></td>
                                        <td>Enable AJAX submission (data-so-ajax)</td>
                                    </tr>
                                    <tr>
                                        <td><code>showLoading($val = true)</code></td>
                                        <td>Show loading state on submit button</td>
                                    </tr>
                                    <tr>
                                        <td><code>csrf($token, $field = '_token')</code></td>
                                        <td>Add CSRF token hidden field (PHP only)</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Rendering</strong></td></tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render form HTML</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderWithValidation()</code></td>
                                        <td>Render with validation script (PHP only)</td>
                                    </tr>
                                    <tr>
                                        <td><code>exportValidation()</code></td>
                                        <td>Export validation rules as array</td>
                                    </tr>
                                    <tr>
                                        <td><code>exportValidationScript()</code></td>
                                        <td>Export validation as script tag (PHP only)</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray() / toConfig()</code></td>
                                        <td>Export form configuration</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Container Methods -->
                    <div class="so-tab-pane so-fade" id="container-methods">
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 40%;">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Child Management</strong></td></tr>
                                    <tr>
                                        <td><code>add($element)</code></td>
                                        <td>Add child element to form</td>
                                    </tr>
                                    <tr>
                                        <td><code>addMany($elements)</code></td>
                                        <td>Add multiple children</td>
                                    </tr>
                                    <tr>
                                        <td><code>prepend($element)</code></td>
                                        <td>Add child at beginning</td>
                                    </tr>
                                    <tr>
                                        <td><code>insertAt($index, $element)</code></td>
                                        <td>Insert at specific position</td>
                                    </tr>
                                    <tr>
                                        <td><code>remove($element)</code></td>
                                        <td>Remove child by instance or ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeAt($index)</code></td>
                                        <td>Remove child at index</td>
                                    </tr>
                                    <tr>
                                        <td><code>clear()</code></td>
                                        <td>Remove all children</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Finding Elements</strong></td></tr>
                                    <tr>
                                        <td><code>find($id)</code></td>
                                        <td>Find child by ID (recursive)</td>
                                    </tr>
                                    <tr>
                                        <td><code>findByName($name)</code></td>
                                        <td>Find form element by name attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>findFirst($callback)</code></td>
                                        <td>Find first matching callback</td>
                                    </tr>
                                    <tr>
                                        <td><code>findAll($callback)</code></td>
                                        <td>Find all matching callback</td>
                                    </tr>
                                    <tr>
                                        <td><code>getFormElements()</code></td>
                                        <td>Get all form input elements</td>
                                    </tr>
                                    <tr>
                                        <td><code>getChildren()</code></td>
                                        <td>Get all direct children</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Iteration</strong></td></tr>
                                    <tr>
                                        <td><code>each($callback)</code></td>
                                        <td>Execute callback for each child</td>
                                    </tr>
                                    <tr>
                                        <td><code>map($callback)</code></td>
                                        <td>Map over children</td>
                                    </tr>
                                    <tr>
                                        <td><code>filter($callback)</code></td>
                                        <td>Filter children by callback</td>
                                    </tr>
                                    <tr>
                                        <td><code>count()</code></td>
                                        <td>Get number of children</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasChildren()</code></td>
                                        <td>Check if has children</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Runtime Methods (JS only) -->
                    <div class="so-tab-pane so-fade" id="runtime-methods">
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 40%;">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Data Access (JS only)</strong></td></tr>
                                    <tr>
                                        <td><code>getFormData()</code></td>
                                        <td>Get FormData object for AJAX submission</td>
                                    </tr>
                                    <tr>
                                        <td><code>getValues()</code></td>
                                        <td>Get all form values as object</td>
                                    </tr>
                                    <tr>
                                        <td><code>setValues($values)</code></td>
                                        <td>Set multiple form values</td>
                                    </tr>
                                    <tr>
                                        <td><code>fill($data)</code></td>
                                        <td>Fill form elements with data</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Form Actions (JS only)</strong></td></tr>
                                    <tr>
                                        <td><code>resetForm()</code></td>
                                        <td>Reset form to initial state</td>
                                    </tr>
                                    <tr>
                                        <td><code>submitForm()</code></td>
                                        <td>Programmatically submit the form</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Validation (JS only)</strong></td></tr>
                                    <tr>
                                        <td><code>validate()</code></td>
                                        <td>Check form validity (silent)</td>
                                    </tr>
                                    <tr>
                                        <td><code>reportValidity()</code></td>
                                        <td>Check validity with UI feedback</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Error Handling (JS only)</strong></td></tr>
                                    <tr>
                                        <td><code>setErrors($errors)</code></td>
                                        <td>Set errors on form fields</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearErrors()</code></td>
                                        <td>Clear all form errors</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Events (JS only)</strong></td></tr>
                                    <tr>
                                        <td><code>onSubmit($handler)</code></td>
                                        <td>Set submit event handler</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Base Element Methods -->
                    <div class="so-tab-pane so-fade" id="base-methods">
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 40%;">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Identity</strong></td></tr>
                                    <tr>
                                        <td><code>id($id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>getId()</code></td>
                                        <td>Get element ID</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>CSS Classes</strong></td></tr>
                                    <tr>
                                        <td><code>addClass($class)</code></td>
                                        <td>Add CSS class(es)</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass($class)</code></td>
                                        <td>Remove CSS class(es)</td>
                                    </tr>
                                    <tr>
                                        <td><code>toggleClass($class)</code></td>
                                        <td>Toggle CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasClass($class)</code></td>
                                        <td>Check if has class</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Attributes</strong></td></tr>
                                    <tr>
                                        <td><code>attr($name, $value)</code></td>
                                        <td>Set attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>attrs($array)</code></td>
                                        <td>Set multiple attributes</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeAttr($name)</code></td>
                                        <td>Remove attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>getAttr($name)</code></td>
                                        <td>Get attribute value</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Data Attributes</strong></td></tr>
                                    <tr>
                                        <td><code>data($key, $value)</code></td>
                                        <td>Set data-so-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>getData($key)</code></td>
                                        <td>Get data attribute value</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeData($key)</code></td>
                                        <td>Remove data attribute</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Styles</strong></td></tr>
                                    <tr>
                                        <td><code>style($prop, $value)</code></td>
                                        <td>Set inline style</td>
                                    </tr>
                                    <tr>
                                        <td><code>styles($array)</code></td>
                                        <td>Set multiple styles</td>
                                    </tr>
                                    <tr>
                                        <td><code>show() / hide()</code></td>
                                        <td>Show/hide element</td>
                                    </tr>
                                    <tr><td colspan="2" class="so-bg-light"><strong>Events (PHP)</strong></td></tr>
                                    <tr>
                                        <td><code>on($event, $handler)</code></td>
                                        <td>Add event handler attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>onMany($events)</code></td>
                                        <td>Add multiple event handlers</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>

<script>
// Demo: Prevent actual form submissions
document.querySelectorAll('form[id^="demo-"]').forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Form would submit to: ' + form.action);
    });
});
</script>
