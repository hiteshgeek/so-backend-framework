<?php

namespace Core\UiEngine\Validation;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Contracts\ContainerInterface;
use Core\UiEngine\Contracts\ElementInterface;

/**
 * ClientRuleExporter - Exports PHP validation rules to JavaScript format
 *
 * Converts validation rules defined on form elements to a JSON format
 * that can be used by the JavaScript ValidationEngine.
 */
class ClientRuleExporter
{
    /**
     * Rules that should be exported to client
     *
     * @var array
     */
    protected static array $clientRules = [
        'required', 'email', 'url', 'numeric', 'integer', 'alpha',
        'alpha_num', 'min', 'max', 'between', 'in', 'not_in',
        'regex', 'confirmed', 'date', 'before', 'after',
        'same', 'different', 'accepted', 'digits', 'digits_between',
    ];

    /**
     * Rules that should NOT be exported (server-only)
     *
     * @var array
     */
    protected static array $serverOnlyRules = [
        'unique', 'exists', 'file', 'image', 'mimes', 'mimetypes',
        'dimensions', 'uploaded', 'database',
    ];

    /**
     * Export validation rules from elements
     *
     * @param array<ElementInterface> $elements
     * @return array<string, array>
     */
    public static function export(array $elements): array
    {
        $rules = [];

        foreach ($elements as $element) {
            // Handle containers recursively
            if ($element instanceof ContainerInterface) {
                $rules = array_merge($rules, static::export($element->getChildren()));
                continue;
            }

            // Export rules from form elements
            if ($element instanceof FormElement && $element->hasRules()) {
                $name = $element->getName();

                if ($name === null) {
                    continue;
                }

                $exported = static::exportElement($element);

                if (!empty($exported['rules'])) {
                    $rules[$name] = $exported;
                }
            }
        }

        return $rules;
    }

    /**
     * Export rules for a single element
     *
     * @param FormElement $element
     * @return array
     */
    public static function exportElement(FormElement $element): array
    {
        $elementRules = $element->getRules();
        $exportedRules = [];

        foreach ($elementRules as $rule => $params) {
            // Handle string-indexed rules (rule => params)
            if (is_string($rule)) {
                if (static::shouldExport($rule)) {
                    $exportedRules[$rule] = static::normalizeParams($params);
                }
            }
            // Handle numeric-indexed rules (pipe string)
            elseif (is_numeric($rule) && is_string($params)) {
                $parsed = static::parseRuleString($params);
                $exportedRules = array_merge($exportedRules, $parsed);
            }
        }

        return [
            'rules' => $exportedRules,
            'messages' => $element->getMessages(),
        ];
    }

    /**
     * Check if a rule should be exported to client
     *
     * @param string $rule
     * @return bool
     */
    protected static function shouldExport(string $rule): bool
    {
        // Exclude server-only rules
        if (in_array($rule, static::$serverOnlyRules, true)) {
            return false;
        }

        return true;
    }

    /**
     * Normalize rule parameters
     *
     * @param mixed $params
     * @return mixed
     */
    protected static function normalizeParams(mixed $params): mixed
    {
        // Boolean true means rule with no params
        if ($params === true) {
            return true;
        }

        // String params stay as string
        if (is_string($params)) {
            return $params;
        }

        // Arrays stay as arrays
        if (is_array($params)) {
            return $params;
        }

        // Numeric values
        if (is_numeric($params)) {
            return $params;
        }

        return $params;
    }

    /**
     * Parse pipe-separated rule string
     *
     * @param string $rules
     * @return array
     */
    public static function parseRuleString(string $rules): array
    {
        $parsed = [];

        foreach (explode('|', $rules) as $rule) {
            $rule = trim($rule);

            if (empty($rule)) {
                continue;
            }

            if (str_contains($rule, ':')) {
                [$name, $params] = explode(':', $rule, 2);

                if (!static::shouldExport($name)) {
                    continue;
                }

                // Handle comma-separated params
                if (str_contains($params, ',')) {
                    $parsed[$name] = explode(',', $params);
                } else {
                    $parsed[$name] = $params;
                }
            } else {
                if (static::shouldExport($rule)) {
                    $parsed[$rule] = true;
                }
            }
        }

        return $parsed;
    }

    /**
     * Convert rules to JavaScript code
     *
     * @param array $rules
     * @param int $flags JSON encoding flags
     * @return string
     */
    public static function toJson(array $rules, int $flags = JSON_PRETTY_PRINT): string
    {
        return json_encode($rules, $flags);
    }

    /**
     * Generate script tag with validation rules
     *
     * @param array<ElementInterface> $elements
     * @param string|null $formId
     * @return string
     */
    public static function toScript(array $elements, ?string $formId = null): string
    {
        $rules = static::export($elements);

        if (empty($rules)) {
            return '';
        }

        $json = static::toJson($rules);
        $formSelector = $formId ? '#' . $formId : 'form';

        return <<<HTML
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof UiEngine !== 'undefined') {
        UiEngine.loadValidation('{$formSelector}', {$json});
    }
});
</script>
HTML;
    }

    /**
     * Generate inline data attribute with rules
     *
     * @param FormElement $element
     * @return string
     */
    public static function toDataAttribute(FormElement $element): string
    {
        if (!$element->hasRules()) {
            return '';
        }

        $exported = static::exportElement($element);

        if (empty($exported['rules'])) {
            return '';
        }

        return 'data-so-rules="' . e(json_encode($exported['rules'])) . '"';
    }

    /**
     * Add server-only rule to list
     *
     * @param string $rule
     * @return void
     */
    public static function addServerOnlyRule(string $rule): void
    {
        if (!in_array($rule, static::$serverOnlyRules, true)) {
            static::$serverOnlyRules[] = $rule;
        }
    }

    /**
     * Remove rule from server-only list
     *
     * @param string $rule
     * @return void
     */
    public static function removeServerOnlyRule(string $rule): void
    {
        $key = array_search($rule, static::$serverOnlyRules, true);

        if ($key !== false) {
            unset(static::$serverOnlyRules[$key]);
            static::$serverOnlyRules = array_values(static::$serverOnlyRules);
        }
    }

    /**
     * Get list of server-only rules
     *
     * @return array
     */
    public static function getServerOnlyRules(): array
    {
        return static::$serverOnlyRules;
    }
}
