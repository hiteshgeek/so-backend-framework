<?php
/**
 * Feature Card Component
 *
 * Creates styled feature cards for highlighting capabilities.
 *
 * Usage:
 *   <?= featureCard('shield-lock', 'Security', 'Built-in CSRF, XSS protection') ?>
 *   <?= featureGrid([
 *       ['icon' => 'database', 'title' => 'ORM', 'description' => 'Active Record pattern'],
 *       ['icon' => 'routes', 'title' => 'Routing', 'description' => 'Laravel-style routing'],
 *   ]) ?>
 */

/**
 * Render a single feature card
 *
 * @param string $icon MDI icon name (without 'mdi-' prefix)
 * @param string $title Feature title
 * @param string $description Feature description
 * @param string|null $link Optional link URL
 * @return string HTML output
 */
function featureCard(string $icon, string $title, string $description, ?string $link = null): string
{
    $titleHtml = htmlspecialchars($title);
    $descHtml = htmlspecialchars($description);

    $content = <<<HTML
<div class="feature-card-icon">
    <span class="mdi mdi-{$icon}"></span>
</div>
<div class="feature-card-title">{$titleHtml}</div>
<div class="feature-card-description">{$descHtml}</div>
HTML;

    if ($link) {
        $linkHtml = htmlspecialchars($link);
        return <<<HTML
<a href="{$linkHtml}" class="feature-card" style="text-decoration: none;">
    {$content}
</a>
HTML;
    }

    return <<<HTML
<div class="feature-card">
    {$content}
</div>
HTML;
}

/**
 * Render a grid of feature cards
 *
 * @param array $features Array of feature definitions [['icon' => '', 'title' => '', 'description' => '', 'link' => '']]
 * @param int $columns Number of columns (2, 3, or 4)
 * @return string HTML output
 */
function featureGrid(array $features, int $columns = 3): string
{
    if (empty($features)) {
        return '';
    }

    $cardsHtml = '';
    foreach ($features as $feature) {
        $icon = $feature['icon'] ?? 'star';
        $title = $feature['title'] ?? '';
        $description = $feature['description'] ?? '';
        $link = $feature['link'] ?? null;

        $cardsHtml .= featureCard($icon, $title, $description, $link);
    }

    return <<<HTML
<div class="feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
    {$cardsHtml}
</div>
HTML;
}

/**
 * Render a compact feature list (for smaller spaces)
 *
 * @param array $features Array of feature definitions
 * @return string HTML output
 */
function featureList(array $features): string
{
    if (empty($features)) {
        return '';
    }

    $itemsHtml = '';
    foreach ($features as $feature) {
        $icon = $feature['icon'] ?? 'check';
        $title = htmlspecialchars($feature['title'] ?? '');
        $description = isset($feature['description']) ? ' - ' . htmlspecialchars($feature['description']) : '';

        $itemsHtml .= <<<HTML
<li class="list-item bullet-item">
    <span class="mdi mdi-{$icon} bullet-icon" style="color: var(--success);"></span>
    <span class="item-content"><strong>{$title}</strong>{$description}</span>
</li>
HTML;
    }

    return <<<HTML
<ul class="bullet-list">
    {$itemsHtml}
</ul>
HTML;
}
