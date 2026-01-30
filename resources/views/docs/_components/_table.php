<?php
/**
 * Table Component
 *
 * Creates styled data tables with various options.
 *
 * Usage:
 *   <?= dataTable(['Name', 'Type', 'Description'], [
 *       ['id', 'int', 'User ID'],
 *       ['name', 'string', 'User name'],
 *   ]) ?>
 */

/**
 * Render a data table
 *
 * @param array $headers Table headers
 * @param array $rows Table rows (array of arrays)
 * @param array $options Options: striped, hover, compact
 * @return string HTML output
 */
function dataTable(array $headers, array $rows, array $options = []): string
{
    if (empty($headers) && empty($rows)) {
        return '';
    }

    $tableClass = 'data-table';
    if ($options['striped'] ?? true) {
        $tableClass .= ' table-striped';
    }
    if ($options['compact'] ?? false) {
        $tableClass .= ' table-compact';
    }

    // Build headers
    $headersHtml = '';
    if (!empty($headers)) {
        $headersHtml = '<thead><tr>';
        foreach ($headers as $header) {
            $headersHtml .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $headersHtml .= '</tr></thead>';
    }

    // Build rows
    $rowsHtml = '<tbody>';
    foreach ($rows as $row) {
        $rowsHtml .= '<tr>';
        foreach ($row as $cell) {
            // Check if cell is an array with special formatting
            if (is_array($cell)) {
                $content = htmlspecialchars($cell['content'] ?? '');
                $class = isset($cell['class']) ? ' class="' . htmlspecialchars($cell['class']) . '"' : '';
                $rowsHtml .= "<td{$class}>{$content}</td>";
            } else {
                $rowsHtml .= '<td>' . htmlspecialchars((string)$cell) . '</td>';
            }
        }
        $rowsHtml .= '</tr>';
    }
    $rowsHtml .= '</tbody>';

    return <<<HTML
<div class="table-container">
    <table class="{$tableClass}">
        {$headersHtml}
        {$rowsHtml}
    </table>
</div>
HTML;
}

/**
 * Render a key-value definition table
 *
 * @param array $items Associative array of key => value pairs
 * @param string $keyHeader Header for key column
 * @param string $valueHeader Header for value column
 * @return string HTML output
 */
function definitionTable(array $items, string $keyHeader = 'Property', string $valueHeader = 'Value'): string
{
    $rows = [];
    foreach ($items as $key => $value) {
        $rows[] = [$key, $value];
    }

    return dataTable([$keyHeader, $valueHeader], $rows);
}

/**
 * Render a comparison table
 *
 * @param array $headers Headers including first column for features
 * @param array $rows Rows with feature names and comparison values
 * @return string HTML output
 */
function comparisonTable(array $headers, array $rows): string
{
    $rowsWithIcons = [];

    foreach ($rows as $row) {
        $newRow = [];
        foreach ($row as $index => $cell) {
            if ($index === 0) {
                // First column is feature name
                $newRow[] = $cell;
            } elseif ($cell === true || $cell === 'yes' || $cell === '✓') {
                $newRow[] = '<span class="mdi mdi-check-circle" style="color: var(--success); font-size: 18px;"></span>';
            } elseif ($cell === false || $cell === 'no' || $cell === '✗') {
                $newRow[] = '<span class="mdi mdi-close-circle" style="color: #ef4444; font-size: 18px;"></span>';
            } elseif ($cell === 'partial' || $cell === '~') {
                $newRow[] = '<span class="mdi mdi-minus-circle" style="color: #f59e0b; font-size: 18px;"></span>';
            } else {
                $newRow[] = $cell;
            }
        }
        $rowsWithIcons[] = $newRow;
    }

    // Build custom table with raw HTML cells
    $headersHtml = '<thead><tr>';
    foreach ($headers as $header) {
        $headersHtml .= '<th>' . htmlspecialchars($header) . '</th>';
    }
    $headersHtml .= '</tr></thead>';

    $rowsHtml = '<tbody>';
    foreach ($rowsWithIcons as $row) {
        $rowsHtml .= '<tr>';
        foreach ($row as $index => $cell) {
            if ($index === 0) {
                $rowsHtml .= '<td>' . htmlspecialchars($cell) . '</td>';
            } else {
                // Allow HTML for icon cells
                $rowsHtml .= '<td style="text-align: center;">' . $cell . '</td>';
            }
        }
        $rowsHtml .= '</tr>';
    }
    $rowsHtml .= '</tbody>';

    return <<<HTML
<div class="table-container">
    <table class="data-table">
        {$headersHtml}
        {$rowsHtml}
    </table>
</div>
HTML;
}
