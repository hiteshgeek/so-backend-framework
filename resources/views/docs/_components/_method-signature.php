<?php
/**
 * Method Signature Component
 *
 * Displays PHP method signatures with syntax highlighting.
 *
 * Usage:
 *   <?= methodSignature('public', 'findById', [['type' => 'int', 'name' => 'id']], '?User') ?>
 *   <?= methodSignature('public static', 'create', [['type' => 'array', 'name' => 'data']], 'self') ?>
 */

/**
 * Render a method signature
 *
 * @param string $visibility Visibility (public, protected, private, public static, etc.)
 * @param string $name Method name
 * @param array $params Array of parameters [['type' => '', 'name' => '', 'default' => '']]
 * @param string|null $returnType Return type
 * @return string HTML output
 */
function methodSignature(string $visibility, string $name, array $params = [], ?string $returnType = null): string
{
    // Parse visibility
    $visibilityParts = explode(' ', trim($visibility));
    $visibilityHtml = '';

    foreach ($visibilityParts as $part) {
        $part = strtolower(trim($part));
        if ($part === 'static') {
            $visibilityHtml .= '<span class="method-static">static</span> ';
        } elseif (in_array($part, ['public', 'protected', 'private'])) {
            $visibilityHtml .= '<span class="method-visibility">' . $part . '</span> ';
        }
    }

    // Build parameters
    $paramsHtml = [];
    foreach ($params as $param) {
        $type = isset($param['type']) ? '<span class="method-type">' . htmlspecialchars($param['type']) . '</span> ' : '';
        $paramName = '<span class="method-param">$' . htmlspecialchars($param['name']) . '</span>';
        $default = isset($param['default']) ? ' <span class="method-punctuation">=</span> <span class="method-value">' . htmlspecialchars($param['default']) . '</span>' : '';

        $paramsHtml[] = $type . $paramName . $default;
    }

    $paramsStr = implode('<span class="method-punctuation">, </span>', $paramsHtml);

    // Build return type
    $returnHtml = $returnType
        ? '<span class="method-punctuation">: </span><span class="method-return">' . htmlspecialchars($returnType) . '</span>'
        : '';

    $nameHtml = '<span class="method-name">' . htmlspecialchars($name) . '</span>';

    return <<<HTML
<div class="method-signature">
    {$visibilityHtml}<span class="method-keyword">function</span> {$nameHtml}<span class="method-punctuation">(</span>{$paramsStr}<span class="method-punctuation">)</span>{$returnHtml}
</div>
HTML;
}

/**
 * Render a property signature
 *
 * @param string $visibility Visibility
 * @param string $type Property type
 * @param string $name Property name
 * @param string|null $default Default value
 * @return string HTML output
 */
function propertySignature(string $visibility, string $type, string $name, ?string $default = null): string
{
    $visibilityParts = explode(' ', trim($visibility));
    $visibilityHtml = '';

    foreach ($visibilityParts as $part) {
        $part = strtolower(trim($part));
        if ($part === 'static') {
            $visibilityHtml .= '<span class="method-static">static</span> ';
        } elseif (in_array($part, ['public', 'protected', 'private'])) {
            $visibilityHtml .= '<span class="method-visibility">' . $part . '</span> ';
        }
    }

    $typeHtml = '<span class="method-type">' . htmlspecialchars($type) . '</span>';
    $nameHtml = '<span class="method-param">$' . htmlspecialchars($name) . '</span>';
    $defaultHtml = $default !== null
        ? ' <span class="method-punctuation">=</span> <span class="method-value">' . htmlspecialchars($default) . '</span>'
        : '';

    return <<<HTML
<div class="method-signature">
    {$visibilityHtml}{$typeHtml} {$nameHtml}{$defaultHtml}<span class="method-punctuation">;</span>
</div>
HTML;
}

/**
 * Render a class signature
 *
 * @param string $name Class name
 * @param string|null $extends Parent class
 * @param array $implements Implemented interfaces
 * @param bool $isAbstract Is abstract class
 * @param bool $isFinal Is final class
 * @return string HTML output
 */
function classSignature(string $name, ?string $extends = null, array $implements = [], bool $isAbstract = false, bool $isFinal = false): string
{
    $prefixHtml = '';
    if ($isAbstract) {
        $prefixHtml .= '<span class="method-visibility">abstract</span> ';
    }
    if ($isFinal) {
        $prefixHtml .= '<span class="method-visibility">final</span> ';
    }

    $nameHtml = '<span class="method-class">' . htmlspecialchars($name) . '</span>';

    $extendsHtml = $extends
        ? ' <span class="method-keyword">extends</span> <span class="method-type">' . htmlspecialchars($extends) . '</span>'
        : '';

    $implementsHtml = '';
    if (!empty($implements)) {
        $interfacesHtml = implode('<span class="method-punctuation">, </span>', array_map(
            fn($i) => '<span class="method-type">' . htmlspecialchars($i) . '</span>',
            $implements
        ));
        $implementsHtml = ' <span class="method-keyword">implements</span> ' . $interfacesHtml;
    }

    return <<<HTML
<div class="method-signature">
    {$prefixHtml}<span class="method-keyword">class</span> {$nameHtml}{$extendsHtml}{$implementsHtml}
</div>
HTML;
}
