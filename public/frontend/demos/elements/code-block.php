<?php
/**
 * SixOrbit UI Demo - Code Block
 */
$pageTitle = 'Code Block';
$pageDescription = 'Styled code display components with syntax highlighting, line numbers, and copy functionality.';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

<!-- Inline Code -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Inline Code</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Use inline code for referencing code within text.</p>

        <p>Use the <code class="so-code">console.log()</code> function to output messages to the browser console.</p>
        <p>Install the package with <code class="so-code">npm install package-name</code> in your terminal.</p>
        <p>The <code class="so-code">Array.map()</code> method creates a new array with the results of calling a function.</p>
    </div>
</div>

<!-- Basic Code Block -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Code Block</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Multi-line code display with dark theme.</p>

        <div class="so-code-block">
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>function greetUser(name) {
    const greeting = `Hello, ${name}!`;
    console.log(greeting);
    return greeting;
}

greetUser('World');</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Code Block with Header -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Code Block with Header</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Code block with language label and copy button.</p>

        <div class="so-code-block">
            <div class="so-code-block-header">
                <span class="so-code-block-language">JavaScript</span>
                <button class="so-code-block-copy" onclick="copyCode(this)">
                    <span class="material-icons">content_copy</span>
                </button>
            </div>
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>const fetchData = async (url) => {
    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
};</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Code Block with Filename -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Code Block with Filename</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Display the filename in the header.</p>

        <div class="so-code-block">
            <div class="so-code-block-header">
                <div class="so-code-block-filename">
                    <span class="material-icons">description</span>
                    <span>components/Button.jsx</span>
                </div>
                <button class="so-code-block-copy" onclick="copyCode(this)">
                    <span class="material-icons">content_copy</span>
                </button>
            </div>
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>import React from 'react';

export function Button({ children, onClick, variant = 'primary' }) {
    return (
        &lt;button
            className={`btn btn-${variant}`}
            onClick={onClick}
        &gt;
            {children}
        &lt;/button&gt;
    );
}</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Code Block with Line Numbers -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Code Block with Line Numbers</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Show line numbers for easier reference.</p>

        <div class="so-code-block so-code-block-with-lines">
            <div class="so-code-block-header">
                <span class="so-code-block-language">Python</span>
                <button class="so-code-block-copy" onclick="copyCode(this)">
                    <span class="material-icons">content_copy</span>
                </button>
            </div>
            <div class="so-code-block-body">
                <div class="so-code-line-numbers">
                    <span>1</span>
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    <span>5</span>
                    <span>6</span>
                    <span>7</span>
                    <span>8</span>
                    <span>9</span>
                </div>
                <pre class="so-code-block-content"><code>def quicksort(arr):
    if len(arr) <= 1:
        return arr

    pivot = arr[len(arr) // 2]
    left = [x for x in arr if x < pivot]
    middle = [x for x in arr if x == pivot]
    right = [x for x in arr if x > pivot]
    return quicksort(left) + middle + quicksort(right)</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Highlighted Lines -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Highlighted Lines</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Highlight specific lines to draw attention.</p>

        <div class="so-code-block so-code-block-with-lines">
            <div class="so-code-block-header">
                <span class="so-code-block-language">JavaScript</span>
            </div>
            <div class="so-code-block-body">
                <div class="so-code-line-numbers">
                    <span>1</span>
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    <span>5</span>
                    <span>6</span>
                    <span>7</span>
                </div>
                <pre class="so-code-block-content"><code><span class="so-code-line">const config = {</span>
<span class="so-code-line">    apiUrl: 'https://api.example.com',</span>
<span class="so-code-line so-code-line-highlight">    apiKey: process.env.API_KEY, // Important!</span>
<span class="so-code-line">    timeout: 5000,</span>
<span class="so-code-line so-code-line-highlight">    retries: 3, // New setting</span>
<span class="so-code-line">    debug: false</span>
<span class="so-code-line">};</span></code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Diff View -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Diff View</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Show code changes with added/removed lines.</p>

        <div class="so-code-block so-code-block-with-lines">
            <div class="so-code-block-header">
                <span class="so-code-block-language">Diff</span>
            </div>
            <div class="so-code-block-body">
                <div class="so-code-line-numbers">
                    <span>1</span>
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    <span>5</span>
                    <span>6</span>
                    <span>7</span>
                    <span>8</span>
                </div>
                <pre class="so-code-block-content"><code><span class="so-code-line">function calculateTotal(items) {</span>
<span class="so-code-line so-code-line-removed">  let total = 0;</span>
<span class="so-code-line so-code-line-removed">  for (let item of items) {</span>
<span class="so-code-line so-code-line-removed">    total += item.price;</span>
<span class="so-code-line so-code-line-removed">  }</span>
<span class="so-code-line so-code-line-added">  const total = items.reduce((sum, item) => sum + item.price, 0);</span>
<span class="so-code-line">  return total;</span>
<span class="so-code-line">}</span></code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Light Theme -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Light Theme</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Code block with light background.</p>

        <div class="so-code-block so-code-block-light">
            <div class="so-code-block-header">
                <span class="so-code-block-language">CSS</span>
                <button class="so-code-block-copy" onclick="copyCode(this)">
                    <span class="material-icons">content_copy</span>
                </button>
            </div>
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>.button {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Terminal Style -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Terminal Style</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Command line terminal appearance.</p>

        <div class="so-code-block so-code-terminal">
            <div class="so-code-block-header">
                <span class="so-code-block-filename">Terminal</span>
            </div>
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code><span class="so-code-prompt">$</span> npm install sixorbit-ui
<span class="so-code-prompt">$</span> npm run build
Building project...
✓ Compiled successfully in 2.3s
<span class="so-code-prompt">$</span> npm run dev
Server running at http://localhost:3000</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Size Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Size Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Different font sizes for code blocks.</p>

        <h6 class="so-text-muted so-mb-2">Small</h6>
        <div class="so-code-block so-code-block-sm so-mb-4">
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>const small = "Compact code display for dense content";</code></pre>
            </div>
        </div>

        <h6 class="so-text-muted so-mb-2">Default</h6>
        <div class="so-code-block so-mb-4">
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>const normal = "Standard size for most use cases";</code></pre>
            </div>
        </div>

        <h6 class="so-text-muted so-mb-2">Large</h6>
        <div class="so-code-block so-code-block-lg">
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code>const large = "Larger text for presentations";</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Syntax Highlighting -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Syntax Highlighting</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Manual syntax highlighting with token classes.</p>

        <div class="so-code-block">
            <div class="so-code-block-header">
                <span class="so-code-block-language">JavaScript</span>
            </div>
            <div class="so-code-block-body">
                <pre class="so-code-block-content"><code><span class="so-code-keyword">const</span> <span class="so-code-variable">user</span> <span class="so-code-operator">=</span> <span class="so-code-punctuation">{</span>
    <span class="so-code-property">name</span><span class="so-code-punctuation">:</span> <span class="so-code-string">'John Doe'</span><span class="so-code-punctuation">,</span>
    <span class="so-code-property">age</span><span class="so-code-punctuation">:</span> <span class="so-code-number">30</span><span class="so-code-punctuation">,</span>
    <span class="so-code-property">isActive</span><span class="so-code-punctuation">:</span> <span class="so-code-keyword">true</span>
<span class="so-code-punctuation">}</span><span class="so-code-punctuation">;</span>

<span class="so-code-comment">// Get user's full info</span>
<span class="so-code-keyword">function</span> <span class="so-code-function">getUserInfo</span><span class="so-code-punctuation">(</span><span class="so-code-variable">user</span><span class="so-code-punctuation">)</span> <span class="so-code-punctuation">{</span>
    <span class="so-code-keyword">return</span> <span class="so-code-string">`</span><span class="so-code-variable">${user.name}</span><span class="so-code-string"> is </span><span class="so-code-variable">${user.age}</span><span class="so-code-string"> years old`</span><span class="so-code-punctuation">;</span>
<span class="so-code-punctuation">}</span></code></pre>
            </div>
        </div>
    </div>
</div>

<!-- Multiple Languages -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Multiple Languages</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Examples in different programming languages.</p>

        <div class="so-row so-g-4">
            <div class="so-col-md-6">
                <div class="so-code-block">
                    <div class="so-code-block-header">
                        <span class="so-code-block-language">HTML</span>
                    </div>
                    <div class="so-code-block-body">
                        <pre class="so-code-block-content"><code>&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;title&gt;Hello World&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Welcome&lt;/h1&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                    </div>
                </div>
            </div>
            <div class="so-col-md-6">
                <div class="so-code-block">
                    <div class="so-code-block-header">
                        <span class="so-code-block-language">PHP</span>
                    </div>
                    <div class="so-code-block-body">
                        <pre class="so-code-block-content"><code>&lt;?php
class User {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function greet() {
        return "Hello, {$this->name}!";
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const code = codeBlock.querySelector('.so-code-block-content code').textContent;

    navigator.clipboard.writeText(code).then(() => {
        button.classList.add('copied');
        button.innerHTML = '<span class="material-icons">check</span>';

        setTimeout(() => {
            button.classList.remove('copied');
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
