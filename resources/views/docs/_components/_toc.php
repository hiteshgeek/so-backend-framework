<?php
/**
 * Table of Contents Component
 *
 * Creates a styled TOC box for in-content navigation.
 *
 * Usage:
 *   <?= tocBox([
 *       ['id' => 'overview', 'title' => 'Overview'],
 *       ['id' => 'installation', 'title' => 'Installation'],
 *       ['id' => 'configuration', 'title' => 'Configuration'],
 *   ]) ?>
 *
 *   // Or with title override:
 *   <?= tocBox($items, 'Sections') ?>
 */

/**
 * Render a Table of Contents box
 *
 * @param array $items Array of items [['id' => '', 'title' => '']]
 * @param string $title Optional title (default: 'Table of Contents')
 * @param string $icon Optional MDI icon name (default: 'format-list-bulleted')
 * @return string HTML output
 */
function tocBox(array $items, string $title = 'Table of Contents', string $icon = 'format-list-bulleted'): string
{
    if (empty($items)) {
        return '';
    }

    $listItems = '';
    foreach ($items as $index => $item) {
        $id = htmlspecialchars($item['id'] ?? '');
        $itemTitle = htmlspecialchars($item['title'] ?? '');
        $num = $index + 1;

        $listItems .= <<<HTML
        <li class="toc-box-item">
            <a href="#{$id}" class="toc-box-link">
                <span class="toc-box-number">{$num}</span>
                <span class="toc-box-title">{$itemTitle}</span>
            </a>
        </li>
HTML;
    }

    return <<<HTML
<div class="toc-box">
    <h3 class="toc-box-header">
        <span class="mdi mdi-{$icon}"></span>
        <span>{$title}</span>
    </h3>
    <ol class="toc-box-list">
        {$listItems}
    </ol>
</div>
HTML;
}
