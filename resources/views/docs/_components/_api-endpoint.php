<?php
/**
 * API Endpoint Component
 *
 * Displays REST API endpoints with method badges and descriptions.
 *
 * Usage:
 *   <?= apiEndpoint('GET', '/users/{id}', 'Get a user by ID') ?>
 *   <?= apiEndpoint('POST', '/users', 'Create a new user', [
 *       ['name' => 'name', 'type' => 'string', 'desc' => 'User name'],
 *       ['name' => 'email', 'type' => 'string', 'desc' => 'User email'],
 *   ]) ?>
 */

/**
 * Render an API endpoint display
 *
 * @param string $method HTTP method (GET, POST, PUT, DELETE, PATCH)
 * @param string $path API path with parameters in {braces}
 * @param string $description Endpoint description
 * @param array $params Optional array of parameters [['name' => '', 'type' => '', 'desc' => '']]
 * @return string HTML output
 */
function apiEndpoint(string $method, string $path, string $description = '', array $params = []): string
{
    $methodLower = strtolower($method);
    $methodUpper = strtoupper($method);

    // Highlight path parameters
    $pathHtml = preg_replace(
        '/\{([^}]+)\}/',
        '<span class="api-path-param">{$1}</span>',
        htmlspecialchars($path)
    );

    $descHtml = $description
        ? '<div class="api-description">' . $description . '</div>'
        : '';

    $paramsHtml = '';
    if (!empty($params)) {
        $paramsHtml = '<div class="api-params">';
        foreach ($params as $param) {
            $name = htmlspecialchars($param['name'] ?? '');
            $type = htmlspecialchars($param['type'] ?? 'string');
            $desc = htmlspecialchars($param['desc'] ?? '');
            $required = isset($param['required']) && $param['required'] ? ' <span class="badge badge-sm badge-delete">required</span>' : '';

            $paramsHtml .= <<<HTML
            <div class="api-param">
                <span class="api-param-name">{$name}{$required}</span>
                <span class="api-param-type">{$type}</span>
                <span class="api-param-desc">{$desc}</span>
            </div>
HTML;
        }
        $paramsHtml .= '</div>';
    }

    $bodyContent = $descHtml . $paramsHtml;
    $bodyHtml = $bodyContent
        ? '<div class="api-endpoint-body">' . $bodyContent . '</div>'
        : '';

    return <<<HTML
<div class="api-endpoint">
    <div class="api-endpoint-header">
        <span class="api-method api-method-{$methodLower}">{$methodUpper}</span>
        <span class="api-path">{$pathHtml}</span>
    </div>
    {$bodyHtml}
</div>
HTML;
}

/**
 * Render a group of related API endpoints
 *
 * @param string $title Group title
 * @param array $endpoints Array of endpoint definitions
 * @return string HTML output
 */
function apiEndpointGroup(string $title, array $endpoints): string
{
    $html = '<div class="api-group">';
    $html .= '<h4 class="heading-4">' . htmlspecialchars($title) . '</h4>';

    foreach ($endpoints as $endpoint) {
        $method = $endpoint['method'] ?? 'GET';
        $path = $endpoint['path'] ?? '/';
        $desc = $endpoint['description'] ?? '';
        $params = $endpoint['params'] ?? [];

        $html .= apiEndpoint($method, $path, $desc, $params);
    }

    $html .= '</div>';
    return $html;
}
