<?php
/**
 * Tabs Component
 *
 * Creates tabbed content sections for code examples or content variants.
 *
 * Usage:
 *   <?= tabs([
 *       ['label' => 'PHP', 'icon' => 'language-php', 'content' => $phpCode],
 *       ['label' => 'Response', 'icon' => 'code-json', 'content' => $jsonCode],
 *   ]) ?>
 */

/**
 * Render a tabbed content container
 *
 * @param array $tabs Array of tab definitions [['label' => '', 'content' => '', 'icon' => '']]
 * @param string $id Optional unique ID for the tabs container
 * @return string HTML output
 */
function tabs(array $tabs, string $id = ''): string
{
    if (empty($tabs)) {
        return '';
    }

    $tabId = $id ?: 'tabs-' . uniqid();

    // Build tab buttons
    $buttonsHtml = '';
    $contentsHtml = '';

    foreach ($tabs as $index => $tab) {
        $label = htmlspecialchars($tab['label'] ?? 'Tab ' . ($index + 1));
        $content = $tab['content'] ?? '';
        $icon = $tab['icon'] ?? null;
        $isActive = $index === 0 ? ' active' : '';

        $iconHtml = $icon ? '<span class="mdi mdi-' . htmlspecialchars($icon) . '"></span>' : '';

        $buttonsHtml .= <<<HTML
<button class="tab-button{$isActive}" data-tab="{$tabId}-{$index}" onclick="switchTab(this, '{$tabId}')">
    {$iconHtml}
    {$label}
</button>
HTML;

        $contentsHtml .= <<<HTML
<div class="tab-content{$isActive}" id="{$tabId}-{$index}">
    {$content}
</div>
HTML;
    }

    return <<<HTML
<div class="tabs-container" id="{$tabId}">
    <div class="tabs-header">
        {$buttonsHtml}
    </div>
    {$contentsHtml}
</div>
<script>
function switchTab(button, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    // Remove active from all buttons and contents
    container.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    container.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

    // Add active to clicked button and corresponding content
    button.classList.add('active');
    const targetId = button.getAttribute('data-tab');
    const targetContent = document.getElementById(targetId);
    if (targetContent) {
        targetContent.classList.add('active');
    }
}
</script>
HTML;
}

/**
 * Render code tabs (specialized for code examples)
 *
 * @param array $codeExamples Array of code examples [['label' => '', 'lang' => '', 'code' => '']]
 * @return string HTML output
 */
function codeTabs(array $codeExamples): string
{
    $tabs = [];

    $langIcons = [
        'php' => 'language-php',
        'javascript' => 'language-javascript',
        'js' => 'language-javascript',
        'typescript' => 'language-typescript',
        'ts' => 'language-typescript',
        'json' => 'code-json',
        'html' => 'language-html5',
        'css' => 'language-css3',
        'bash' => 'console',
        'shell' => 'console',
        'sql' => 'database',
        'python' => 'language-python',
        'ruby' => 'language-ruby',
        'go' => 'language-go',
        'response' => 'code-braces',
        'output' => 'console-line',
    ];

    foreach ($codeExamples as $example) {
        $label = $example['label'] ?? ucfirst($example['lang'] ?? 'Code');
        $lang = strtolower($example['lang'] ?? 'text');
        $code = $example['code'] ?? '';
        $icon = $langIcons[$lang] ?? 'file-code';

        // Generate code block content
        $escapedCode = htmlspecialchars(trim($code));
        $langLabel = strtoupper($lang);

        $content = <<<HTML
<div class="code-container" style="margin: 0; border-radius: 0; box-shadow: none;">
    <pre class="code-block"><code>{$escapedCode}</code></pre>
</div>
HTML;

        $tabs[] = [
            'label' => $label,
            'icon' => $icon,
            'content' => $content,
        ];
    }

    return tabs($tabs);
}
