<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * CodeBlock - Code display with syntax highlighting
 *
 * Displays code with optional syntax highlighting and copy button
 */
class CodeBlock extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'code-block';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Code content
     *
     * @var string
     */
    protected string $code = '';

    /**
     * Language for syntax highlighting
     *
     * @var string|null
     */
    protected ?string $language = null;

    /**
     * Show line numbers
     *
     * @var bool
     */
    protected bool $lineNumbers = false;

    /**
     * Starting line number
     *
     * @var int
     */
    protected int $startLine = 1;

    /**
     * Show copy button
     *
     * @var bool
     */
    protected bool $copyButton = true;

    /**
     * Show language badge
     *
     * @var bool
     */
    protected bool $showLanguage = true;

    /**
     * Maximum height (scrollable)
     *
     * @var string|null
     */
    protected ?string $maxHeight = null;

    /**
     * Highlight specific lines
     *
     * @var array
     */
    protected array $highlightLines = [];

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['code'])) {
            $this->code = $config['code'];
        }

        if (isset($config['language'])) {
            $this->language = $config['language'];
        }

        if (isset($config['lineNumbers'])) {
            $this->lineNumbers = (bool) $config['lineNumbers'];
        }

        if (isset($config['startLine'])) {
            $this->startLine = (int) $config['startLine'];
        }

        if (isset($config['copyButton'])) {
            $this->copyButton = (bool) $config['copyButton'];
        }

        if (isset($config['showLanguage'])) {
            $this->showLanguage = (bool) $config['showLanguage'];
        }

        if (isset($config['maxHeight'])) {
            $this->maxHeight = $config['maxHeight'];
        }

        if (isset($config['highlightLines'])) {
            $this->highlightLines = $config['highlightLines'];
        }
    }

    /**
     * Set code content
     *
     * @param string $code
     * @return static
     */
    public function code(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return static
     */
    public function language(string $language): static
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Language shortcuts
     */
    public function php(): static { return $this->language('php'); }
    public function javascript(): static { return $this->language('javascript'); }
    public function js(): static { return $this->language('javascript'); }
    public function html(): static { return $this->language('html'); }
    public function css(): static { return $this->language('css'); }
    public function json(): static { return $this->language('json'); }
    public function sql(): static { return $this->language('sql'); }
    public function bash(): static { return $this->language('bash'); }
    public function python(): static { return $this->language('python'); }

    /**
     * Show/hide line numbers
     *
     * @param bool $show
     * @return static
     */
    public function lineNumbers(bool $show = true): static
    {
        $this->lineNumbers = $show;
        return $this;
    }

    /**
     * Set starting line number
     *
     * @param int $line
     * @return static
     */
    public function startLine(int $line): static
    {
        $this->startLine = $line;
        return $this;
    }

    /**
     * Show/hide copy button
     *
     * @param bool $show
     * @return static
     */
    public function copyButton(bool $show = true): static
    {
        $this->copyButton = $show;
        return $this;
    }

    /**
     * Show/hide language badge
     *
     * @param bool $show
     * @return static
     */
    public function showLanguage(bool $show = true): static
    {
        $this->showLanguage = $show;
        return $this;
    }

    /**
     * Set maximum height
     *
     * @param string $height
     * @return static
     */
    public function maxHeight(string $height): static
    {
        $this->maxHeight = $height;
        return $this;
    }

    /**
     * Highlight specific lines
     *
     * @param array $lines
     * @return static
     */
    public function highlightLines(array $lines): static
    {
        $this->highlightLines = $lines;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('code-block'));

        if ($this->lineNumbers) {
            $this->addClass(CssPrefix::cls('code-block-numbered'));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        if ($this->copyButton) {
            $attrs[CssPrefix::data('ui-init')] = 'code-block';
            $config = [
                'copyButton' => true,
            ];
            $attrs[CssPrefix::data('ui-config')] = htmlspecialchars(json_encode($config), ENT_QUOTES);
        }

        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Header
        if ($this->showLanguage || $this->copyButton) {
            $html .= '<div class="' . CssPrefix::cls('code-block-header') . '">';

            // Language badge
            if ($this->showLanguage && $this->language !== null) {
                $html .= '<span class="' . CssPrefix::cls('code-block-language') . '">' . e($this->language) . '</span>';
            }

            // Copy button
            if ($this->copyButton) {
                $html .= '<button type="button" class="' . CssPrefix::cls('code-block-copy') . '" title="Copy to clipboard">';
                $html .= '<span class="material-icons">content_copy</span>';
                $html .= '</button>';
            }

            $html .= '</div>';
        }

        // Code container
        $preStyle = '';
        if ($this->maxHeight !== null) {
            $preStyle = ' style="max-height: ' . e($this->maxHeight) . '; overflow: auto;"';
        }

        $codeClass = '';
        if ($this->language !== null) {
            $codeClass = ' class="language-' . e($this->language) . '"';
        }

        $html .= '<pre class="' . CssPrefix::cls('code-block-pre') . '"' . $preStyle . '>';

        // Line numbers
        if ($this->lineNumbers) {
            $lines = explode("\n", $this->code);
            $html .= '<code' . $codeClass . '>';

            foreach ($lines as $index => $line) {
                $lineNum = $this->startLine + $index;
                $lineClass = CssPrefix::cls('code-line');

                if (in_array($lineNum, $this->highlightLines)) {
                    $lineClass .= ' ' . CssPrefix::cls('code-line-highlight');
                }

                $html .= '<span class="' . $lineClass . '">';
                $html .= '<span class="' . CssPrefix::cls('code-line-number') . '">' . $lineNum . '</span>';
                $html .= '<span class="' . CssPrefix::cls('code-line-content') . '">' . e($line) . '</span>';
                $html .= '</span>';

                if ($index < count($lines) - 1) {
                    $html .= "\n";
                }
            }

            $html .= '</code>';
        } else {
            $html .= '<code' . $codeClass . '>' . e($this->code) . '</code>';
        }

        $html .= '</pre>';

        return $html;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        $config['code'] = $this->code;

        if ($this->language !== null) {
            $config['language'] = $this->language;
        }

        if ($this->lineNumbers) {
            $config['lineNumbers'] = true;
        }

        if ($this->startLine !== 1) {
            $config['startLine'] = $this->startLine;
        }

        if (!$this->copyButton) {
            $config['copyButton'] = false;
        }

        if (!$this->showLanguage) {
            $config['showLanguage'] = false;
        }

        if ($this->maxHeight !== null) {
            $config['maxHeight'] = $this->maxHeight;
        }

        if (!empty($this->highlightLines)) {
            $config['highlightLines'] = $this->highlightLines;
        }

        return $config;
    }
}
