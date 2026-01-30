<?php
/**
 * Validation System Documentation Page
 *
 * Complete guide to input validation with 27+ built-in rules.
 */

$pageTitle = 'Validation System';
$pageIcon = 'check-decagram';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'available-rules', 'title' => 'Available Rules', 'level' => 2],
    ['id' => 'custom-rules', 'title' => 'Custom Rules', 'level' => 2],
    ['id' => 'error-messages', 'title' => 'Error Messages', 'level' => 2],
    ['id' => 'advanced-usage', 'title' => 'Advanced Usage', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
];
$prevPage = ['url' => '/docs/security-layer', 'title' => 'Security Layer'];
$nextPage = ['url' => '/docs/session-system', 'title' => 'Session System'];
$breadcrumbs = [['label' => 'Validation System']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="validation-system" class="heading heading-1">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Validation System</span>
</h1>

<p class="text-lead">
    A clean, expressive way to validate user input with 27+ built-in rules and custom validation support.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-stable">Production Ready</span>
    <span class="badge badge-success">93% Test Coverage</span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<?= callout('danger', '
    <strong>Without Validation:</strong>
    <pre class="code-block mt-2"><code>$user = User::create([
    \'email\' => $_POST[\'email\'], // Could be anything!
    \'age\' => $_POST[\'age\'],     // Could be negative, string, etc.
]);
// → Database errors, security issues, data corruption</code></pre>
', 'Bad Practice', 'close-circle') ?>

<?= callout('success', '
    <strong>With Validation:</strong>
    <pre class="code-block mt-2"><code>$validated = validate($_POST, [
    \'email\' => \'required|email|unique:users,email\',
    \'age\' => \'required|integer|min:18|max:120\',
]);
$user = User::create($validated);
// → Clean, validated data only</code></pre>
', 'Good Practice', 'check-circle') ?>

<h4 class="heading heading-4 mt-4">Features</h4>

<?= featureGrid([
    ['icon' => 'format-list-checks', 'title' => '27+ Built-in Rules', 'description' => 'Required, email, min/max, unique, and more'],
    ['icon' => 'code-braces', 'title' => 'Custom Rules', 'description' => 'Closures or rule classes for custom logic'],
    ['icon' => 'message-alert', 'title' => 'Custom Messages', 'description' => 'Per-field error messages'],
    ['icon' => 'database', 'title' => 'Database Rules', 'description' => 'unique and exists validation'],
    ['icon' => 'code-array', 'title' => 'Array Validation', 'description' => 'Validate complex nested structures'],
    ['icon' => 'alert-circle', 'title' => 'Exception Handling', 'description' => 'ValidationException with 422 status'],
], 3) ?>

<!-- Quick Start -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<h4 class="heading heading-4">Basic Usage</h4>

<?= codeBlock('php', 'use Core\Validation\Validator;

$data = [
    \'email\' => \'user@example.com\',
    \'password\' => \'secret123\',
    \'age\' => 25,
];

$rules = [
    \'email\' => \'required|email\',
    \'password\' => \'required|min:8\',
    \'age\' => \'integer|min:18\',
];

$validator = new Validator($data, $rules);

if ($validator->fails()) {
    $errors = $validator->errors();
} else {
    $validated = $validator->validated();
}') ?>

<h4 class="heading heading-4 mt-4">Using Helper Function</h4>

<?= codeBlock('php', 'try {
    $validated = validate($_POST, [
        \'email\' => \'required|email\',
        \'password\' => \'required|min:8\',
    ]);

    User::create($validated);

} catch (ValidationException $e) {
    $errors = $e->getErrors();
    return Response::json([\'errors\' => $errors], 422);
}') ?>

<h4 class="heading heading-4 mt-4">In Controllers</h4>

<?= codeBlockWithFile('php', 'class UserController
{
    public function store(Request $request)
    {
        $validated = validate($request->all(), [
            \'name\' => \'required|string|max:255\',
            \'email\' => \'required|email|unique:users,email\',
            \'password\' => \'required|min:8|confirmed\',
            \'age\' => \'integer|min:18|max:120\',
        ]);

        $user = User::create($validated);

        return Response::json([\'user\' => $user], 201);
    }
}', 'app/Controllers/UserController.php') ?>

<!-- Available Rules -->
<h2 id="available-rules" class="heading heading-2">
    <span class="mdi mdi-format-list-checks heading-icon"></span>
    <span class="heading-text">Available Rules</span>
</h2>

<h4 class="heading heading-4">Required Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Example'],
    [
        ['<code class="code-inline">required</code>', 'Field must be present and not empty', '<code class="code-inline">\'email\' => \'required\'</code>'],
        ['<code class="code-inline">required_if:field,value</code>', 'Required if another field equals value', '<code class="code-inline">\'billing\' => \'required_if:payment,card\'</code>'],
        ['<code class="code-inline">required_with:field</code>', 'Required if another field is present', '<code class="code-inline">\'confirm\' => \'required_with:password\'</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">Type Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Valid Examples'],
    [
        ['<code class="code-inline">string</code>', 'Must be a string', '<code class="code-inline">\'John\'</code>'],
        ['<code class="code-inline">integer</code>', 'Must be an integer', '<code class="code-inline">25</code>, <code class="code-inline">\'25\'</code>'],
        ['<code class="code-inline">numeric</code>', 'Must be numeric', '<code class="code-inline">99.99</code>, <code class="code-inline">100</code>'],
        ['<code class="code-inline">boolean</code>', 'Must be boolean-like', '<code class="code-inline">true</code>, <code class="code-inline">1</code>, <code class="code-inline">\'1\'</code>'],
        ['<code class="code-inline">array</code>', 'Must be an array', '<code class="code-inline">[\'a\', \'b\']</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">String Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Valid Examples'],
    [
        ['<code class="code-inline">email</code>', 'Valid email address', '<code class="code-inline">user@example.com</code>'],
        ['<code class="code-inline">url</code>', 'Valid URL', '<code class="code-inline">https://example.com</code>'],
        ['<code class="code-inline">ip</code>', 'Valid IP address', '<code class="code-inline">192.168.1.1</code>'],
        ['<code class="code-inline">alpha</code>', 'Only alphabetic', '<code class="code-inline">JohnDoe</code>'],
        ['<code class="code-inline">alpha_num</code>', 'Only alphanumeric', '<code class="code-inline">john123</code>'],
        ['<code class="code-inline">alpha_dash</code>', 'Alphanumeric + dashes/underscores', '<code class="code-inline">my-awesome-post</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">Size Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Example'],
    [
        ['<code class="code-inline">min:value</code>', 'Minimum value/length', '<code class="code-inline">\'password\' => \'min:8\'</code>'],
        ['<code class="code-inline">max:value</code>', 'Maximum value/length', '<code class="code-inline">\'name\' => \'max:255\'</code>'],
        ['<code class="code-inline">between:min,max</code>', 'Between min and max', '<code class="code-inline">\'rating\' => \'between:1,5\'</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">Comparison Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Example'],
    [
        ['<code class="code-inline">same:field</code>', 'Same as another field', '<code class="code-inline">\'confirm\' => \'same:password\'</code>'],
        ['<code class="code-inline">different:field</code>', 'Different from another field', '<code class="code-inline">\'new\' => \'different:old\'</code>'],
        ['<code class="code-inline">confirmed</code>', 'Must have _confirmation field', '<code class="code-inline">\'password\' => \'confirmed\'</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">List Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Example'],
    [
        ['<code class="code-inline">in:val1,val2</code>', 'Must be one of values', '<code class="code-inline">\'status\' => \'in:draft,published\'</code>'],
        ['<code class="code-inline">not_in:val1,val2</code>', 'Must NOT be one of values', '<code class="code-inline">\'role\' => \'not_in:admin\'</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">Date Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Example'],
    [
        ['<code class="code-inline">date</code>', 'Must be a valid date', '<code class="code-inline">\'birth\' => \'date\'</code>'],
        ['<code class="code-inline">before:date</code>', 'Must be before date', '<code class="code-inline">\'start\' => \'before:2025-01-01\'</code>'],
        ['<code class="code-inline">after:date</code>', 'Must be after date', '<code class="code-inline">\'end\' => \'after:today\'</code>'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">Database Rules</h4>

<?= dataTable(
    ['Rule', 'Description', 'Example'],
    [
        ['<code class="code-inline">unique:table,column,except</code>', 'Must be unique in database', '<code class="code-inline">\'email\' => \'unique:users,email,\' . $id</code>'],
        ['<code class="code-inline">exists:table,column</code>', 'Must exist in database', '<code class="code-inline">\'category_id\' => \'exists:categories,id\'</code>'],
    ]
) ?>

<!-- Custom Rules -->
<h2 id="custom-rules" class="heading heading-2">
    <span class="mdi mdi-code-braces heading-icon"></span>
    <span class="heading-text">Custom Rules</span>
</h2>

<h4 class="heading heading-4">Closure-Based Rules</h4>

<?= codeBlock('php', '$rules = [
    \'discount\' => [
        \'required\',
        \'numeric\',
        function($value) {
            if ($value > 50) {
                return \'Discount cannot exceed 50%\';
            }
            return null; // Passes
        }
    ],
];') ?>

<h4 class="heading heading-4 mt-4">Rule Classes</h4>

<?= codeTabs([
    ['label' => 'Create Rule', 'lang' => 'php', 'code' => '<?php
// app/Validation/Rules/UppercaseRule.php
use Core\Validation\Rule;

class UppercaseRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return $value === strtoupper($value);
    }

    public function message(): string
    {
        return \'The :attribute must be uppercase.\';
    }
}'],
    ['label' => 'Use Rule', 'lang' => 'php', 'code' => 'use App\Validation\Rules\UppercaseRule;

$rules = [
    \'country_code\' => [\'required\', \'string\', new UppercaseRule()],
];

validate($data, $rules);
// \'US\' ✓
// \'us\' ✗ "The country code must be uppercase."'],
]) ?>

<!-- Error Messages -->
<h2 id="error-messages" class="heading heading-2">
    <span class="mdi mdi-message-alert heading-icon"></span>
    <span class="heading-text">Error Messages</span>
</h2>

<h4 class="heading heading-4">Custom Messages</h4>

<?= codeBlock('php', '$rules = [
    \'email\' => \'required|email\',
    \'password\' => \'required|min:8\',
];

$messages = [
    \'email.required\' => \'Please enter your email address.\',
    \'email.email\' => \'Please enter a valid email address.\',
    \'password.min\' => \'Password must be at least 8 characters long.\',
];

$validator = new Validator($data, $rules, $messages);') ?>

<h4 class="heading heading-4 mt-4">Available Placeholders</h4>

<?= dataTable(
    ['Placeholder', 'Description'],
    [
        ['<code class="code-inline">:attribute</code>', 'Field name'],
        ['<code class="code-inline">:min</code>', 'Minimum value'],
        ['<code class="code-inline">:max</code>', 'Maximum value'],
        ['<code class="code-inline">:other</code>', 'Other field name'],
        ['<code class="code-inline">:values</code>', 'List of values'],
    ]
) ?>

<!-- Advanced Usage -->
<h2 id="advanced-usage" class="heading heading-2">
    <span class="mdi mdi-cogs heading-icon"></span>
    <span class="heading-text">Advanced Usage</span>
</h2>

<h4 class="heading heading-4">Array Validation</h4>

<?= codeBlock('php', '$data = [
    \'users\' => [
        [\'name\' => \'John\', \'email\' => \'john@example.com\'],
        [\'name\' => \'Jane\', \'email\' => \'jane@example.com\'],
    ],
];

$rules = [
    \'users\' => \'required|array\',
    \'users.*.name\' => \'required|string\',
    \'users.*.email\' => \'required|email\',
];') ?>

<h4 class="heading heading-4 mt-4">Conditional Validation</h4>

<?= codeBlock('php', '$rules = [
    \'payment_method\' => \'required|in:cash,credit_card\',
    \'card_number\' => \'required_if:payment_method,credit_card|numeric\',
    \'cvv\' => \'required_if:payment_method,credit_card|numeric|between:3,4\',
];') ?>

<h4 class="heading heading-4 mt-4">Multiple Rule Formats</h4>

<?= codeBlock('php', '// Pipe syntax (string)
\'email\' => \'required|email|max:255\'

// Array syntax
\'email\' => [\'required\', \'email\', \'max:255\']

// Mixed (with closures)
\'email\' => [
    \'required\',
    \'email\',
    function($value) { /* custom logic */ }
]') ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<div class="space-y-3">
    <?= callout('success', '<strong>Always Validate User Input</strong><br>Never trust user input. Validate everything before processing.') ?>
    <?= callout('success', '<strong>Use Appropriate Rules</strong><br><code class="code-inline">\'age\' => \'integer|min:18|max:120\'</code> - not just <code class="code-inline">integer</code>') ?>
    <?= callout('success', '<strong>Database Rules for Relationships</strong><br><code class="code-inline">\'category_id\' => \'required|exists:categories,id\'</code>') ?>
    <?= callout('success', '<strong>Unique Checks for Updates</strong><br><code class="code-inline">\'email\' => \'unique:users,email,\' . $user->id</code> to exclude current record') ?>
</div>

<?php include __DIR__ . '/../_layout-end.php'; ?>
