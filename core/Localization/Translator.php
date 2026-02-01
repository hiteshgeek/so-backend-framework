<?php

namespace Core\Localization;

/**
 * Translator
 *
 * Main translation engine with parameter replacement and pluralization support.
 * Supports dot notation (validation.required), parameter replacement (:attribute),
 * and pluralization rules ({0} No items|{1} One item|[2,*] :count items).
 */
class Translator
{
    /**
     * Translation loader instance
     */
    protected TranslationLoader $loader;

    /**
     * Current locale
     */
    protected string $locale;

    /**
     * Fallback locale
     */
    protected string $fallback;

    /**
     * Loaded translation groups (in-memory cache per request)
     */
    protected array $loaded = [];

    /**
     * Constructor
     *
     * @param TranslationLoader $loader Translation file loader
     * @param string $locale Current locale
     * @param string $fallback Fallback locale
     */
    public function __construct(TranslationLoader $loader, string $locale, string $fallback)
    {
        $this->loader = $loader;
        $this->locale = $locale;
        $this->fallback = $fallback;
    }

    /**
     * Get translation for the given key
     *
     * @param string $key Translation key (e.g., 'validation.required')
     * @param array $replace Replacement parameters
     * @param string|null $locale Override locale
     * @return string
     */
    public function get(string $key, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?? $this->locale;

        // Get translation from current locale
        $translation = $this->getTranslation($key, $locale);

        // If not found, try fallback locale
        if ($translation === $key && $locale !== $this->fallback) {
            $translation = $this->getTranslation($key, $this->fallback);
        }

        // Replace parameters
        return $this->makeReplacements($translation, $replace);
    }

    /**
     * Get translation with pluralization support
     *
     * @param string $key Translation key
     * @param int $count Count for pluralization
     * @param array $replace Replacement parameters
     * @param string|null $locale Override locale
     * @return string
     */
    public function choice(string $key, int $count, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?? $this->locale;

        // Get the plural form
        $translation = $this->get($key, $replace, $locale);

        // Parse pluralization rules: {0} No items|{1} One item|[2,*] :count items
        $translation = $this->choosePlural($translation, $count);

        // Replace :count parameter
        $replace = array_merge($replace, ['count' => $count]);

        return $this->makeReplacements($translation, $replace);
    }

    /**
     * Check if translation exists
     *
     * @param string $key Translation key
     * @param string|null $locale Override locale
     * @return bool
     */
    public function has(string $key, ?string $locale = null): bool
    {
        $locale = $locale ?? $this->locale;
        $translation = $this->getTranslation($key, $locale);

        return $translation !== $key;
    }

    /**
     * Get current locale
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Set current locale
     *
     * @param string $locale
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * Get fallback locale
     *
     * @return string
     */
    public function getFallback(): string
    {
        return $this->fallback;
    }

    /**
     * Add namespace for translations
     *
     * @param string $namespace Namespace identifier
     * @param string $path Path to translation files
     * @return void
     */
    public function addNamespace(string $namespace, string $path): void
    {
        $this->loader->addNamespace($namespace, $path);
    }

    /**
     * Get translation from loaded translations
     *
     * @param string $key Translation key (e.g., 'validation.required')
     * @param string $locale Locale
     * @return string
     */
    protected function getTranslation(string $key, string $locale): string
    {
        // Parse key: validation.required.string or vendor::validation.required
        list($namespace, $group, $item) = $this->parseKey($key);

        // Load translation group if not already loaded
        $this->loadGroup($locale, $group, $namespace);

        // Get translation from loaded groups
        $cacheKey = $locale . '::' . $namespace . '::' . $group;

        if (!isset($this->loaded[$cacheKey])) {
            return $key;
        }

        // Navigate nested array structure
        return $this->getNestedValue($this->loaded[$cacheKey], $item, $key);
    }

    /**
     * Load translation group
     *
     * @param string $locale Locale
     * @param string $group Group name (e.g., 'validation')
     * @param string|null $namespace Namespace
     * @return void
     */
    protected function loadGroup(string $locale, string $group, ?string $namespace = null): void
    {
        $cacheKey = $locale . '::' . $namespace . '::' . $group;

        // Already loaded
        if (isset($this->loaded[$cacheKey])) {
            return;
        }

        // Load from file
        $translations = $this->loader->load($locale, $group, $namespace);
        $this->loaded[$cacheKey] = $translations;
    }

    /**
     * Parse translation key
     *
     * @param string $key Translation key
     * @return array [namespace, group, item]
     */
    protected function parseKey(string $key): array
    {
        // Check for namespaced key: vendor::validation.required
        if (str_contains($key, '::')) {
            list($namespace, $key) = explode('::', $key, 2);
        } else {
            $namespace = '*'; // Default namespace
        }

        // Split group and item: validation.required.string
        $segments = explode('.', $key);
        $group = array_shift($segments);
        $item = implode('.', $segments);

        return [$namespace, $group, $item];
    }

    /**
     * Get nested array value using dot notation
     *
     * @param array $array Array to search
     * @param string $key Dot notation key (e.g., 'min.string')
     * @param mixed $default Default value if not found
     * @return mixed
     */
    protected function getNestedValue(array $array, string $key, mixed $default = null): mixed
    {
        if (empty($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        // Navigate nested structure
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Make parameter replacements
     *
     * @param string $translation Translation string
     * @param array $replace Replacement parameters
     * @return string
     */
    protected function makeReplacements(string $translation, array $replace): string
    {
        if (empty($replace)) {
            return $translation;
        }

        // Replace :key with value
        foreach ($replace as $key => $value) {
            $translation = str_replace(
                [':' . $key, ':' . strtoupper($key), ':' . ucfirst($key)],
                [$value, strtoupper($value), ucfirst($value)],
                $translation
            );
        }

        return $translation;
    }

    /**
     * Choose plural form based on count
     *
     * Supports formats:
     * - {0} No items|{1} One item|[2,*] :count items
     * - {0} None|[1,*] :count items
     * - item|items
     *
     * @param string $translation Translation with plural rules
     * @param int $count Count
     * @return string
     */
    protected function choosePlural(string $translation, int $count): string
    {
        // If no plural rules, return as-is
        if (!str_contains($translation, '|')) {
            return $translation;
        }

        $segments = explode('|', $translation);

        // Find matching segment
        foreach ($segments as $segment) {
            $segment = trim($segment);

            // Exact match: {0}, {1}, {2}, etc.
            if (preg_match('/^\{(\d+)\}\s*(.*)$/', $segment, $matches)) {
                if ((int)$matches[1] === $count) {
                    return trim($matches[2]);
                }
                continue;
            }

            // Range match: [2,*], [0,19], etc.
            if (preg_match('/^\[(\d+),(\d+|\*)\]\s*(.*)$/', $segment, $matches)) {
                $min = (int)$matches[1];
                $max = $matches[2] === '*' ? PHP_INT_MAX : (int)$matches[2];

                if ($count >= $min && $count <= $max) {
                    return trim($matches[3]);
                }
                continue;
            }
        }

        // Simple plural (last segment for count != 1, first for count === 1)
        if (count($segments) === 2) {
            return trim($count === 1 ? $segments[0] : $segments[1]);
        }

        // Default to first segment
        return trim($segments[0]);
    }
}
