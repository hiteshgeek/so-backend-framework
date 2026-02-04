<?php
/**
 * SixOrbit UI Engine - Code Block Element Demo
 */

$pageTitle = 'Code Block - UI Engine';
$pageDescription = 'Syntax-highlighted code display';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Code Block</h1>
            <p class="so-page-subtitle">Display code with syntax highlighting, line numbers, and copy functionality.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Code Block -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Code Block</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-code-block so-mb-4">
                    <pre class="so-code-content"><code class="language-php">&lt;?php
echo "Hello, World!";
?&gt;</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-code', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$code = UiEngine::codeBlock()
    ->language('php')
    ->code('<?php
echo \"Hello, World!\";
');

echo \$code->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const code = UiEngine.codeBlock()
    .language('javascript')
    .code(`function greet(name) {
    return 'Hello, ' + name + '!';
}`);

document.getElementById('container').innerHTML = code.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-code-block">
    <pre class="so-code-content"><code class="language-php">&lt;?php
echo "Hello, World!";
?&gt;</code></pre>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Line Numbers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Line Numbers</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-code-block so-code-block-numbered so-mb-4">
                    <pre class="so-code-content"><code class="language-javascript"><span class="so-line-number">1</span>function fibonacci(n) {
<span class="so-line-number">2</span>    if (n <= 1) return n;
<span class="so-line-number">3</span>    return fibonacci(n - 1) + fibonacci(n - 2);
<span class="so-line-number">4</span>}
<span class="so-line-number">5</span>
<span class="so-line-number">6</span>console.log(fibonacci(10));</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('code-lines', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$code = UiEngine::codeBlock()
    ->language('javascript')
    ->lineNumbers()  // Show line numbers
    ->code('function fibonacci(n) {
    if (n <= 1) return n;
    return fibonacci(n - 1) + fibonacci(n - 2);
}

console.log(fibonacci(10));');

echo \$code->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const code = UiEngine.codeBlock()
    .language('javascript')
    .lineNumbers()
    .code(`function fibonacci(n) {
    if (n <= 1) return n;
    return fibonacci(n - 1) + fibonacci(n - 2);
}

console.log(fibonacci(10));`);

document.getElementById('container').innerHTML = code.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-code-block so-code-block-numbered">
    <pre class="so-code-content"><code class="language-javascript">
<span class="so-line-number">1</span>function fibonacci(n) {
<span class="so-line-number">2</span>    if (n <= 1) return n;
...
</code></pre>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Line Highlighting -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Line Highlighting</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-code-block so-code-block-numbered so-mb-4">
                    <pre class="so-code-content"><code class="language-php"><span class="so-line-number">1</span>$users = User::where("active", true)
<span class="so-line-number">2</span>    ->orderBy("name")
<span class="so-line-number">3</span><mark class="so-code-highlight">    ->limit(10)      // highlighted</mark>
<span class="so-line-number">4</span><mark class="so-code-highlight">    ->offset(0)      // highlighted</mark>
<span class="so-line-number">5</span><mark class="so-code-highlight">    ->get();         // highlighted</mark>
<span class="so-line-number">6</span>
<span class="so-line-number">7</span>foreach ($users as $user) {
<span class="so-line-number">8</span>    echo $user->name;
<span class="so-line-number">9</span>}</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('code-highlight', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$code = UiEngine::codeBlock()
    ->language('php')
    ->lineNumbers()
    ->highlight([3, 4, 5])  // Highlight specific lines
    ->code('\$users = User::where(\"active\", true)
    ->orderBy(\"name\")
    ->limit(10)      // highlighted
    ->offset(0)      // highlighted
    ->get();         // highlighted

foreach (\$users as \$user) {
    echo \$user->name;
}');

echo \$code->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const code = UiEngine.codeBlock()
    .language('php')
    .lineNumbers()
    .highlight([3, 4, 5])
    .code(`...`);

// Or highlight a range
code.highlight('3-5');  // Lines 3 through 5"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-code-block so-code-block-numbered">
    <pre class="so-code-content"><code>
<span class="so-line-number">1</span>$users = User::where("active", true)
<span class="so-line-number">2</span>    ->orderBy("name")
<span class="so-line-number">3</span><mark class="so-code-highlight">    ->limit(10)</mark>
...
</code></pre>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Copy Button -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Copy Button</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-code-block so-mb-4">
                    <div class="so-code-header">
                        <button class="so-code-copy" onclick="navigator.clipboard.writeText('npm install @sixorbit/ui-engine')">
                            <span class="material-icons">content_copy</span>
                        </button>
                    </div>
                    <pre class="so-code-content"><code class="language-bash">npm install @sixorbit/ui-engine</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('code-copy', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$code = UiEngine::codeBlock()
    ->language('bash')
    ->copyable()  // Add copy button
    ->code('npm install @sixorbit/ui-engine');

echo \$code->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const code = UiEngine.codeBlock()
    .language('bash')
    .copyable()
    .code('npm install @sixorbit/ui-engine')
    .onCopy(() => {
        console.log('Code copied!');
    });

document.getElementById('container').innerHTML = code.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-code-block">
    <div class="so-code-header">
        <button class="so-code-copy">
            <span class="material-icons">content_copy</span>
        </button>
    </div>
    <pre class="so-code-content"><code class="language-bash">npm install @sixorbit/ui-engine</code></pre>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Filename/Title -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Filename</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-code-block so-code-block-numbered so-mb-4">
                    <div class="so-code-header">
                        <span class="so-code-filename">app.js</span>
                        <button class="so-code-copy" onclick="navigator.clipboard.writeText(this.closest('.so-code-block').querySelector('code').textContent)">
                            <span class="material-icons">content_copy</span>
                        </button>
                    </div>
                    <pre class="so-code-content"><code class="language-javascript"><span class="so-line-number">1</span>import { UiEngine } from "@sixorbit/ui-engine";
<span class="so-line-number">2</span>
<span class="so-line-number">3</span>const app = UiEngine.create({
<span class="so-line-number">4</span>    theme: "light",
<span class="so-line-number">5</span>    locale: "en",
<span class="so-line-number">6</span>});
<span class="so-line-number">7</span>
<span class="so-line-number">8</span>export default app;</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('code-filename', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$code = UiEngine::codeBlock()
    ->language('javascript')
    ->filename('app.js')  // Show filename header
    ->lineNumbers()
    ->copyable()
    ->code('import { UiEngine } from \"@sixorbit/ui-engine\";

const app = UiEngine.create({
    theme: \"light\",
    locale: \"en\",
});

export default app;');

echo \$code->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const code = UiEngine.codeBlock()
    .language('javascript')
    .filename('app.js')
    .lineNumbers()
    .copyable()
    .code(`...`);

document.getElementById('container').innerHTML = code.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-code-block so-code-block-numbered">
    <div class="so-code-header">
        <span class="so-code-filename">app.js</span>
        <button class="so-code-copy">
            <span class="material-icons">content_copy</span>
        </button>
    </div>
    <pre class="so-code-content"><code class="language-javascript">
import { UiEngine } from "@sixorbit/ui-engine";
...
</code></pre>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Multiple Languages Example -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Different Languages</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo Python -->
                <p class="so-text-muted so-mb-2">Python</p>
                <div class="so-code-block so-mb-3">
                    <pre class="so-code-content"><code class="language-python">def hello(name):
    return f"Hello, {name}!"

print(hello("World"))</code></pre>
                </div>

                <!-- Live Demo SQL -->
                <p class="so-text-muted so-mb-2">SQL</p>
                <div class="so-code-block so-mb-3">
                    <pre class="so-code-content"><code class="language-sql">SELECT * FROM users WHERE active = 1 ORDER BY name;</code></pre>
                </div>

                <!-- Live Demo JSON -->
                <p class="so-text-muted so-mb-2">JSON</p>
                <div class="so-code-block so-mb-4">
                    <pre class="so-code-content"><code class="language-json">{
    "name": "example",
    "version": "1.0.0",
    "dependencies": {}
}</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('code-languages', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Common languages supported:
// php, javascript, typescript, html, css, scss
// json, xml, yaml, python, ruby, go, rust
// java, c, cpp, csharp, sql, bash, shell, markdown

UiEngine::codeBlock()
    ->language('python')
    ->code('def hello(name):
    return f\"Hello, {name}!\"');

UiEngine::codeBlock()
    ->language('sql')
    ->code('SELECT * FROM users WHERE active = 1;');

UiEngine::codeBlock()
    ->language('json')
    ->code('{
    \"name\": \"example\",
    \"version\": \"1.0.0\"
}');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.codeBlock()
    .language('python')
    .code(`def hello(name):
    return f\"Hello, {name}!\"`);

UiEngine.codeBlock()
    .language('sql')
    .code('SELECT * FROM users WHERE active = 1;');

UiEngine.codeBlock()
    .language('json')
    .code(JSON.stringify({name: 'example'}, null, 2));"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-code-block">
    <pre class="so-code-content"><code class="language-python">def hello(name):
    return f"Hello, {name}!"</code></pre>
</div>

<div class="so-code-block">
    <pre class="so-code-content"><code class="language-sql">SELECT * FROM users WHERE active = 1;</code></pre>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Themes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Code Block Themes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo Light -->
                <p class="so-text-muted so-mb-2">Light Theme (Default)</p>
                <div class="so-code-block so-code-theme-light so-mb-3">
                    <pre class="so-code-content"><code class="language-php">echo "Light theme";</code></pre>
                </div>

                <!-- Live Demo Dark -->
                <p class="so-text-muted so-mb-2">Dark Theme</p>
                <div class="so-code-block so-code-theme-dark so-mb-4">
                    <pre class="so-code-content"><code class="language-php">echo "Dark theme";</code></pre>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('code-themes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Light theme (default)
UiEngine::codeBlock()
    ->theme('light')
    ->language('php')
    ->code('...');

// Dark theme
UiEngine::codeBlock()
    ->theme('dark')
    ->language('php')
    ->code('...');

// GitHub theme
UiEngine::codeBlock()
    ->theme('github')
    ->language('php')
    ->code('...');

// Monokai theme
UiEngine::codeBlock()
    ->theme('monokai')
    ->language('php')
    ->code('...');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Available themes:
// 'light', 'dark', 'github', 'monokai',
// 'dracula', 'nord', 'one-dark'

UiEngine.codeBlock()
    .theme('dracula')
    .language('javascript')
    .code(`...`);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Light theme -->
<div class="so-code-block so-code-theme-light">
    <pre class="so-code-content"><code>...</code></pre>
</div>

<!-- Dark theme -->
<div class="so-code-block so-code-theme-dark">
    <pre class="so-code-content"><code>...</code></pre>
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
                                <td><code>code()</code></td>
                                <td><code>string $code</code></td>
                                <td>Set the code content</td>
                            </tr>
                            <tr>
                                <td><code>language()</code></td>
                                <td><code>string $lang</code></td>
                                <td>Set syntax highlighting language</td>
                            </tr>
                            <tr>
                                <td><code>lineNumbers()</code></td>
                                <td>-</td>
                                <td>Show line numbers</td>
                            </tr>
                            <tr>
                                <td><code>highlight()</code></td>
                                <td><code>array|string $lines</code></td>
                                <td>Highlight specific lines</td>
                            </tr>
                            <tr>
                                <td><code>copyable()</code></td>
                                <td>-</td>
                                <td>Add copy to clipboard button</td>
                            </tr>
                            <tr>
                                <td><code>filename()</code></td>
                                <td><code>string $name</code></td>
                                <td>Show filename header</td>
                            </tr>
                            <tr>
                                <td><code>theme()</code></td>
                                <td><code>string $theme</code></td>
                                <td>Set color theme</td>
                            </tr>
                            <tr>
                                <td><code>maxHeight()</code></td>
                                <td><code>int $pixels</code></td>
                                <td>Set max height with scroll</td>
                            </tr>
                            <tr>
                                <td><code>wordWrap()</code></td>
                                <td>-</td>
                                <td>Enable word wrapping</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
