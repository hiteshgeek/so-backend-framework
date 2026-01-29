<?php
/**
 * Line-by-line Markdown to HTML Parser
 *
 * Design Philosophy:
 * - Clean, minimal design with focus on readability
 * - Consistent spacing using 8px grid system
 * - Blue primary color (#2563eb) for interactive elements
 * - Dark code blocks for contrast
 * - Numbered lists with circular badges
 * - Checkboxes with green success color when checked
 */
class MarkdownParser {
    private $lines = [];
    private $html = '';
    private $inCodeBlock = false;
    private $codeBlockLang = '';
    private $codeBlockContent = '';
    private $inList = false;
    private $listType = '';
    private $inTable = false;
    private $tableRows = [];
    private $inBlockquote = false;

    public function parse($markdown) {
        $this->lines = explode("\n", $markdown);
        $totalLines = count($this->lines);

        for ($i = 0; $i < $totalLines; $i++) {
            $line = $this->lines[$i];

            // Handle code blocks
            if (preg_match('/^```(\w*)$/', $line, $m)) {
                if (!$this->inCodeBlock) {
                    $this->closeOpenElements();
                    $this->inCodeBlock = true;
                    $this->codeBlockLang = $m[1] ?: 'code';
                    $this->codeBlockContent = '';
                } else {
                    $this->html .= $this->renderCodeBlock($this->codeBlockLang, $this->codeBlockContent);
                    $this->inCodeBlock = false;
                }
                continue;
            }

            if ($this->inCodeBlock) {
                $this->codeBlockContent .= $line . "\n";
                continue;
            }

            // Handle table rows
            if (preg_match('/^\|(.+)\|$/', $line)) {
                if (!$this->inTable) {
                    $this->closeOpenElements();
                    $this->inTable = true;
                    $this->tableRows = [];
                }
                if (!preg_match('/^\|[\s\-:\|]+\|$/', $line)) {
                    $this->tableRows[] = $line;
                }
                continue;
            } else if ($this->inTable) {
                $this->html .= $this->renderTable($this->tableRows);
                $this->inTable = false;
                $this->tableRows = [];
            }

            // Handle headers
            if (preg_match('/^(#{1,6})\s+(.+)$/', $line, $m)) {
                $this->closeOpenElements();
                $level = strlen($m[1]);
                $this->html .= $this->renderHeader($level, trim($m[2]));
                continue;
            }

            // Handle horizontal rule
            if (preg_match('/^-{3,}$/', $line) || preg_match('/^\*{3,}$/', $line)) {
                $this->closeOpenElements();
                $this->html .= '<hr class="divider">';
                continue;
            }

            // Handle blockquote
            if (preg_match('/^>\s*(.*)$/', $line, $m)) {
                if (!$this->inBlockquote) {
                    $this->closeOpenElements();
                    $this->inBlockquote = true;
                    $this->html .= '<blockquote class="quote-block"><span class="mdi mdi-format-quote-open quote-icon"></span><div class="quote-content">';
                }
                $this->html .= '<p>' . $this->parseInline($m[1]) . '</p>';
                continue;
            } else if ($this->inBlockquote) {
                $this->html .= '</div></blockquote>';
                $this->inBlockquote = false;
            }

            // Handle numbered list
            if (preg_match('/^(\d+)\.\s+(.+)$/', $line, $m)) {
                if (!$this->inList || $this->listType !== 'ol') {
                    $this->closeOpenElements();
                    $this->inList = true;
                    $this->listType = 'ol';
                    $this->html .= '<ol class="numbered-list">';
                }
                $this->html .= $this->renderListItem($m[2], $m[1]);
                continue;
            }

            // Handle bullet list
            if (preg_match('/^[-*]\s+(.+)$/', $line, $m)) {
                if (!$this->inList || $this->listType !== 'ul') {
                    $this->closeOpenElements();
                    $this->inList = true;
                    $this->listType = 'ul';
                    $this->html .= '<ul class="bullet-list">';
                }
                $this->html .= $this->renderBulletItem($m[1]);
                continue;
            }

            // Close list if we hit a non-list line
            if ($this->inList && !empty(trim($line))) {
                $this->closeOpenElements();
            }

            // Handle empty lines
            if (empty(trim($line))) {
                continue;
            }

            // Handle paragraph
            $this->closeOpenElements();
            $this->html .= '<p class="paragraph">' . $this->parseInline($line) . '</p>';
        }

        $this->closeOpenElements();
        return $this->html;
    }

    private function closeOpenElements() {
        if ($this->inList) {
            $this->html .= $this->listType === 'ol' ? '</ol>' : '</ul>';
            $this->inList = false;
            $this->listType = '';
        }
        if ($this->inBlockquote) {
            $this->html .= '</div></blockquote>';
            $this->inBlockquote = false;
        }
        if ($this->inTable) {
            $this->html .= $this->renderTable($this->tableRows);
            $this->inTable = false;
            $this->tableRows = [];
        }
    }

    private function renderHeader($level, $text) {
        // Remove bracket prefixes like [#], [->], [Docs], [Book], etc.
        $cleanText = preg_replace('/^\[[^\]]*\]\s*/', '', $text);
        $id = strtolower(preg_replace('/[^a-z0-9]+/', '-', $cleanText));
        $icons = [1 => 'book-open-variant', 2 => 'text-box-outline', 3 => 'chevron-right', 4 => 'chevron-right', 5 => 'minus', 6 => 'minus'];
        $icon = $icons[$level] ?? 'minus';
        return "<h{$level} id=\"{$id}\" class=\"heading heading-{$level}\"><span class=\"mdi mdi-{$icon} heading-icon\"></span><span class=\"heading-text\">{$this->parseInline($cleanText)}</span></h{$level}>";
    }

    private function renderCodeBlock($lang, $code) {
        // Check if this is an ASCII flowchart diagram
        if ($this->isFlowchartDiagram($code)) {
            return $this->renderFlowchartDiagram($code);
        }

        $escaped = htmlspecialchars(rtrim($code));
        return "<div class=\"code-container\"><div class=\"code-header\"><span class=\"code-lang\">{$lang}</span><button class=\"code-copy\" onclick=\"navigator.clipboard.writeText(this.closest('.code-container').querySelector('code').textContent)\"><span class=\"mdi mdi-content-copy\"></span></button></div><pre class=\"code-block\"><code>{$escaped}</code></pre></div>";
    }

    /**
     * Check if code block contains ASCII flowchart diagram
     */
    private function isFlowchartDiagram($code) {
        // Look for box-drawing characters or common flowchart patterns (Unicode flag required)
        return preg_match('/[┌┐└┘├┤│─┬┴▼▲→←]/u', $code) ||
               (preg_match('/\+[-]+\+/', $code) && preg_match('/\|/', $code));
    }

    /**
     * Convert ASCII flowchart to styled HTML
     */
    private function renderFlowchartDiagram($code) {
        $lines = explode("\n", rtrim($code));
        $html = '<div class="flowchart-container">';

        $boxes = [];
        $currentBox = null;
        $currentBoxLines = [];
        $connectors = [];

        $i = 0;
        while ($i < count($lines)) {
            $line = $lines[$i];

            // Detect box start (┌ or REQUEST, etc) - use Unicode flag
            if (preg_match('/^[\s]*┌/u', $line) || preg_match('/^\s*REQUEST\s*$/u', $line)) {
                // Start collecting box content
                $currentBoxLines = [$line];
                $i++;

                // Collect all lines until box end (└)
                while ($i < count($lines) && !preg_match('/^[\s]*└/u', $lines[$i])) {
                    $currentBoxLines[] = $lines[$i];
                    $i++;
                }

                // Add closing line if exists
                if ($i < count($lines)) {
                    $currentBoxLines[] = $lines[$i];
                }

                // Parse the box content
                $box = $this->parseFlowchartBox($currentBoxLines);
                if ($box) {
                    $boxes[] = $box;
                }
            }
            // Detect connector arrows (│, ▼, ├──, etc) - skip these
            else if (preg_match('/^\s*[│▼▲→←]+\s*$/u', $line) ||
                     preg_match('/^\s*[├└]──/u', $line) ||
                     preg_match('/^\s*│\s*$/u', $line)) {
                // Skip connectors - they become implicit in the visual flow
            }
            // Detect simple tree-style lines
            else if (preg_match('/^\s*[├└│]/u', $line) && !preg_match('/[┌┐]/u', $line)) {
                // This is a tree item, collect it
                $connectors[] = $line;
            }

            $i++;
        }

        // Render all boxes as flowchart steps
        foreach ($boxes as $index => $box) {
            $stepNum = $index + 1;
            $isFirst = $index === 0;
            $isLast = $index === count($boxes) - 1;

            $boxClass = 'flowchart-box';
            if ($isFirst) $boxClass .= ' flowchart-box-start';
            if ($isLast) $boxClass .= ' flowchart-box-end';
            if ($box['type'] === 'header') $boxClass .= ' flowchart-box-header';

            $html .= '<div class="flowchart-step">';

            // Add connector arrow (except for first box)
            if (!$isFirst) {
                $html .= '<div class="flowchart-connector"><span class="mdi mdi-arrow-down"></span></div>';
            }

            $html .= '<div class="' . $boxClass . '">';

            // Box header with number and title
            if (!empty($box['title'])) {
                $html .= '<div class="flowchart-box-header">';
                if ($box['number']) {
                    $html .= '<span class="flowchart-number">' . htmlspecialchars($box['number']) . '</span>';
                }
                $html .= '<span class="flowchart-title">' . htmlspecialchars($box['title']) . '</span>';
                if (!empty($box['subtitle'])) {
                    $html .= '<span class="flowchart-subtitle">' . htmlspecialchars($box['subtitle']) . '</span>';
                }
                $html .= '</div>';
            }

            // Box content items
            if (!empty($box['items'])) {
                $html .= '<ul class="flowchart-items">';
                foreach ($box['items'] as $item) {
                    $icon = $this->getFlowchartIcon($item);
                    $html .= '<li><span class="mdi mdi-' . $icon . '"></span>' . htmlspecialchars($item) . '</li>';
                }
                $html .= '</ul>';
            }

            $html .= '</div></div>';
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Parse a single flowchart box from lines
     */
    private function parseFlowchartBox($lines) {
        $box = [
            'type' => 'step',
            'number' => null,
            'title' => '',
            'subtitle' => '',
            'items' => []
        ];

        foreach ($lines as $line) {
            // Remove box border characters and trim
            $content = preg_replace('/[┌┐└┘─│├┬┴┤]/u', '', $line);
            $content = trim($content);

            if (empty($content)) continue;

            // Check if it's a numbered header (1. title (subtitle))
            if (preg_match('/^(\d+)\.\s*([^(]+?)(?:\s*\(([^)]+)\))?$/u', $content, $hm)) {
                $box['number'] = $hm[1];
                $box['title'] = trim($hm[2]);
                if (isset($hm[3]) && !empty($hm[3])) {
                    $box['subtitle'] = trim($hm[3]);
                }
            }
            // Check if it's a tree item (starts with tree characters after cleanup)
            else if (preg_match('/^[├└]\s*[─]*\s*(.+)$/u', $line, $im)) {
                $itemContent = preg_replace('/[┌┐└┘─│├┬┴┤]/u', '', $im[1]);
                $itemContent = trim($itemContent);
                if (!empty($itemContent)) {
                    $box['items'][] = $itemContent;
                }
            }
            // Check if this is a header line (all caps or mostly caps)
            else if (mb_strtoupper($content) === $content && mb_strlen($content) > 3) {
                if (empty($box['title'])) {
                    $box['title'] = $content;
                    $box['type'] = 'header';
                } else if (empty($box['subtitle'])) {
                    $box['subtitle'] = $content;
                }
            }
            // Regular content line (not a border character remnant)
            else if (mb_strlen($content) > 2) {
                if (empty($box['title'])) {
                    $box['title'] = $content;
                } else if (empty($box['subtitle']) && count($box['items']) === 0) {
                    $box['subtitle'] = $content;
                }
            }
        }

        // Only return if we have meaningful content
        if (!empty($box['title']) || !empty($box['items'])) {
            return $box;
        }

        return null;
    }

    /**
     * Get appropriate icon for flowchart item
     */
    private function getFlowchartIcon($text) {
        $text = strtolower($text);

        if (strpos($text, 'load') !== false || strpos($text, 'autoload') !== false) return 'package-variant';
        if (strpos($text, 'bootstrap') !== false) return 'rocket-launch';
        if (strpos($text, 'route') !== false) return 'routes';
        if (strpos($text, 'request') !== false) return 'web';
        if (strpos($text, 'middleware') !== false) return 'filter';
        if (strpos($text, 'auth') !== false) return 'shield-lock';
        if (strpos($text, 'csrf') !== false) return 'shield-check';
        if (strpos($text, 'validate') !== false) return 'check-decagram';
        if (strpos($text, 'controller') !== false) return 'cog';
        if (strpos($text, 'service') !== false) return 'layers';
        if (strpos($text, 'model') !== false) return 'database';
        if (strpos($text, 'query') !== false) return 'database-search';
        if (strpos($text, 'database') !== false || strpos($text, 'pdo') !== false) return 'database';
        if (strpos($text, 'response') !== false) return 'reply';
        if (strpos($text, 'view') !== false) return 'eye';
        if (strpos($text, 'html') !== false) return 'language-html5';
        if (strpos($text, 'json') !== false) return 'code-json';
        if (strpos($text, 'cookie') !== false || strpos($text, 'session') !== false) return 'cookie';
        if (strpos($text, 'header') !== false) return 'text-box-outline';
        if (strpos($text, 'transaction') !== false) return 'swap-horizontal';
        if (strpos($text, 'relationship') !== false) return 'link';
        if (strpos($text, 'soft delete') !== false) return 'delete-outline';
        if (strpos($text, 'scope') !== false) return 'magnify';
        if (strpos($text, 'throttle') !== false || strpos($text, 'rate') !== false) return 'speedometer';
        if (strpos($text, 'cors') !== false) return 'earth';
        if (strpos($text, 'log') !== false) return 'text-box-check';
        if (strpos($text, 'return') !== false) return 'keyboard-return';
        if (strpos($text, 'register') !== false) return 'plus-circle';
        if (strpos($text, 'pass') !== false) return 'arrow-right';
        if (strpos($text, 'match') !== false) return 'target';
        if (strpos($text, 'extract') !== false) return 'code-brackets';
        if (strpos($text, 'determine') !== false) return 'help-circle';
        if (strpos($text, 'receive') !== false) return 'download';
        if (strpos($text, 'call') !== false) return 'phone';
        if (strpos($text, 'process') !== false) return 'cog-outline';
        if (strpos($text, 'interact') !== false) return 'swap-vertical';
        if (strpos($text, 'prepare') !== false) return 'shield';
        if (strpos($text, 'output') !== false || strpos($text, 'send') !== false) return 'send';
        if (strpos($text, 'set') !== false) return 'pencil';
        if (strpos($text, 'create') !== false) return 'plus';

        return 'chevron-right';
    }

    private function renderTable($rows) {
        if (empty($rows)) return '';
        $html = '<div class="table-container"><table class="data-table"><thead><tr>';
        $headerCells = array_map('trim', explode('|', trim($rows[0], '|')));
        foreach ($headerCells as $cell) {
            $html .= '<th>' . $this->parseInline($cell) . '</th>';
        }
        $html .= '</tr></thead>';
        if (count($rows) > 1) {
            $html .= '<tbody>';
            for ($i = 1; $i < count($rows); $i++) {
                $cells = array_map('trim', explode('|', trim($rows[$i], '|')));
                $html .= '<tr>';
                foreach ($cells as $cell) {
                    $html .= '<td>' . $this->parseInline($cell) . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }
        return $html . '</table></div>';
    }

    private function renderListItem($text, $num) {
        return "<li class=\"list-item numbered-item\"><span class=\"item-number\">{$num}</span><span class=\"item-content\">{$this->parseInline($text)}</span></li>";
    }

    private function renderBulletItem($text) {
        // Check for checkbox
        if (preg_match('/^\[x\]\s*(.+)$/i', $text, $m)) {
            return "<li class=\"list-item checkbox-item checked\"><span class=\"checkbox\"><span class=\"mdi mdi-check\"></span></span><span class=\"item-content\">{$this->parseInline($m[1])}</span></li>";
        }
        if (preg_match('/^\[ \]\s*(.+)$/', $text, $m)) {
            return "<li class=\"list-item checkbox-item\"><span class=\"checkbox\"></span><span class=\"item-content\">{$this->parseInline($m[1])}</span></li>";
        }
        return "<li class=\"list-item bullet-item\"><span class=\"mdi mdi-circle-small bullet-icon\"></span><span class=\"item-content\">{$this->parseInline($text)}</span></li>";
    }

    private function parseInline($text) {
        $text = htmlspecialchars($text);

        // Convert checkboxes [x] and [ ] anywhere in text
        $text = preg_replace('/\[x\]/i', '<span class="checkbox-inline checked"><span class="mdi mdi-check-circle"></span></span>', $text);
        $text = preg_replace('/\[ \]/', '<span class="checkbox-inline"><span class="mdi mdi-checkbox-blank-circle-outline"></span></span>', $text);

        // Bold and italic
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*([^*]+)\*/', '<em>$1</em>', $text);

        // Inline code
        $text = preg_replace('/`([^`]+)`/', '<code class="inline-code">$1</code>', $text);

        // Images (must come before links)
        $text = preg_replace('/!\[([^\]]*)\]\(([^\)]+)\)/', '<img src="$2" alt="$1" class="inline-image">', $text);

        // Links
        $text = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2" class="link">$1</a>', $text);

        return $text;
    }

    public function extractToc($markdown) {
        $toc = [];
        foreach (explode("\n", $markdown) as $line) {
            if (preg_match('/^##\s+(.+)$/', $line, $m)) {
                $title = $this->cleanTocTitle(trim($m[1]));
                $toc[] = ['level' => 2, 'title' => $title, 'id' => strtolower(preg_replace('/[^a-z0-9]+/', '-', $title))];
            } else if (preg_match('/^###\s+(.+)$/', $line, $m)) {
                $title = $this->cleanTocTitle(trim($m[1]));
                $toc[] = ['level' => 3, 'title' => $title, 'id' => strtolower(preg_replace('/[^a-z0-9]+/', '-', $title))];
            }
        }
        return $toc;
    }

    /**
     * Clean up TOC title by removing markdown syntax
     */
    private function cleanTocTitle($title) {
        // Remove bracket prefixes like [#], [->], [Docs], [Book], [Date], etc.
        $title = preg_replace('/^\[[^\]]*\]\s*/', '', $title);

        // Remove checkbox syntax [x] and [ ]
        $title = preg_replace('/^\[x\]\s*/i', '', $title);
        $title = preg_replace('/^\[ \]\s*/', '', $title);

        // Remove numbered list prefix (1. 2. etc)
        $title = preg_replace('/^\d+\.\s*/', '', $title);

        // Remove bold/italic markers
        $title = preg_replace('/\*\*(.+?)\*\*/', '$1', $title);
        $title = preg_replace('/\*([^*]+)\*/', '$1', $title);

        // Remove inline code backticks
        $title = preg_replace('/`([^`]+)`/', '$1', $title);

        // Remove link syntax [text](url) -> text
        $title = preg_replace('/\[([^\]]+)\]\([^\)]+\)/', '$1', $title);

        return trim($title);
    }
}

/**
 * Helper functions for views
 */
function parseMarkdown($markdown) {
    $parser = new MarkdownParser();
    return $parser->parse($markdown);
}

function extractToc($markdown) {
    $parser = new MarkdownParser();
    return $parser->extractToc($markdown);
}
