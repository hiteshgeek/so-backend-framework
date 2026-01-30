<?php
/**
 * Code Block Component
 *
 * Creates styled code blocks with optional features.
 *
 * Usage:
 *   <?= codeBlock('php', '<?php echo "Hello"; ?>') ?>
 *   <?= codeBlock('bash', 'npm install', 'Install dependencies') ?>
 *   <?= codeBlockWithFile('php', $code, 'app/Controllers/UserController.php') ?>
 */

/**
 * Render a code block
 *
 * @param string $lang Programming language
 * @param string $code The code content
 * @param string|null $title Optional title/description
 * @param bool $showLineNumbers Whether to show line numbers
 * @return string HTML output
 */
function codeBlock(string $lang, string $code, ?string $title = null, bool $showLineNumbers = false): string
{
    $escapedCode = htmlspecialchars(trim($code));
    $langLabel = strtoupper($lang);

    $titleHtml = $title
        ? '<span class="code-title">' . htmlspecialchars($title) . '</span>'
        : '';

    $codeClass = $showLineNumbers ? 'code-block code-block-numbered' : 'code-block';

    if ($showLineNumbers) {
        $lines = explode("\n", $escapedCode);
        $escapedCode = implode("\n", array_map(fn($line) => '<span class="code-line">' . $line . '</span>', $lines));
    }

    $langClass = htmlspecialchars($lang);

    return <<<HTML
<div class="code-container">
    <div class="code-header">
        <div class="code-header-left">
            <span class="code-lang">{$langLabel}</span>
            {$titleHtml}
        </div>
        <button class="code-copy" onclick="navigator.clipboard.writeText(this.closest('.code-container').querySelector('code').textContent).then(() => { this.innerHTML = '<span class=\\'mdi mdi-check\\'></span>'; setTimeout(() => { this.innerHTML = '<span class=\\'mdi mdi-content-copy\\'></span>'; }, 2000); })">
            <span class="mdi mdi-content-copy"></span>
        </button>
    </div>
    <pre class="{$codeClass}"><code class="language-{$langClass}">{$escapedCode}</code></pre>
</div>
HTML;
}

/**
 * Render a code block with filename header
 *
 * @param string $lang Programming language
 * @param string $code The code content
 * @param string $filename The filename to display
 * @return string HTML output
 */
function codeBlockWithFile(string $lang, string $code, string $filename): string
{
    $escapedCode = htmlspecialchars(trim($code));
    $icon = getFileIcon(pathinfo($filename, PATHINFO_EXTENSION));
    $langClass = htmlspecialchars($lang);

    return <<<HTML
<div class="code-container">
    <div class="code-header">
        <div class="code-filename">
            <span class="mdi mdi-{$icon}"></span>
            <span>{$filename}</span>
        </div>
        <button class="code-copy" onclick="navigator.clipboard.writeText(this.closest('.code-container').querySelector('code').textContent).then(() => { this.innerHTML = '<span class=\\'mdi mdi-check\\'></span>'; setTimeout(() => { this.innerHTML = '<span class=\\'mdi mdi-content-copy\\'></span>'; }, 2000); })">
            <span class="mdi mdi-content-copy"></span>
        </button>
    </div>
    <pre class="code-block"><code class="language-{$langClass}">{$escapedCode}</code></pre>
</div>
HTML;
}

/**
 * Render inline code
 *
 * @param string $code The code content
 * @return string HTML output
 */
function inlineCode(string $code): string
{
    return '<code class="inline-code">' . htmlspecialchars($code) . '</code>';
}

/**
 * Get icon name for file extension
 *
 * @param string $ext File extension
 * @return string MDI icon name
 */
function getFileIcon(string $ext): string
{
    return match (strtolower($ext)) {
        'php' => 'language-php',
        'js' => 'language-javascript',
        'ts' => 'language-typescript',
        'json' => 'code-json',
        'css' => 'language-css3',
        'scss', 'sass' => 'sass',
        'html', 'htm' => 'language-html5',
        'md' => 'language-markdown',
        'sql' => 'database',
        'env' => 'cog',
        'yml', 'yaml' => 'file-cog',
        'xml' => 'xml',
        'sh', 'bash' => 'console',
        'py' => 'language-python',
        'rb' => 'language-ruby',
        'go' => 'language-go',
        'rs' => 'language-rust',
        'java' => 'language-java',
        'vue' => 'vuejs',
        'svelte' => 'svelte',
        'jsx', 'tsx' => 'react',
        default => 'file-document-outline',
    };
}

/**
 * Render a diff code block
 *
 * @param string $code Code with +/- prefixes for diff
 * @param string $lang Programming language
 * @return string HTML output
 */
function codeDiff(string $code, string $lang = 'diff'): string
{
    $lines = explode("\n", trim($code));
    $processedLines = [];

    foreach ($lines as $line) {
        if (str_starts_with($line, '+')) {
            $processedLines[] = '<span class="code-line code-line-added">' . htmlspecialchars($line) . '</span>';
        } elseif (str_starts_with($line, '-')) {
            $processedLines[] = '<span class="code-line code-line-removed">' . htmlspecialchars($line) . '</span>';
        } else {
            $processedLines[] = '<span class="code-line">' . htmlspecialchars($line) . '</span>';
        }
    }

    $escapedCode = implode("\n", $processedLines);
    $langLabel = strtoupper($lang);

    return <<<HTML
<div class="code-container">
    <div class="code-header">
        <span class="code-lang">{$langLabel}</span>
        <button class="code-copy" onclick="navigator.clipboard.writeText(this.closest('.code-container').querySelector('code').textContent)">
            <span class="mdi mdi-content-copy"></span>
        </button>
    </div>
    <pre class="code-block"><code class="language-diff">{$escapedCode}</code></pre>
</div>
HTML;
}
