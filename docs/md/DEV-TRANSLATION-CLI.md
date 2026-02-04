# Translation CLI Commands

## Overview

The framework provides powerful CLI commands for managing translations, finding missing keys, and syncing translation files across locales.

## Available Commands

### make:translation

Create a new translation file for a specific locale.

```bash
# Create a new translation file
php sixorbit make:translation messages ar

# Output:
# Created: resources/lang/ar/messages.php
```

**Options:**
- `--template=FILE` - Copy structure from template file
- `--empty` - Create empty translation file

```bash
# Create from template
php sixorbit make:translation errors ar --template=resources/lang/en/errors.php

# Create empty file
php sixorbit make:translation custom ar --empty
```

### translations:missing

Find missing translation keys across all or specific locales.

```bash
# Find all missing translations
php sixorbit translations:missing

# Output:
# Missing translations in [ar]:
#   - messages.welcome
#   - messages.goodbye
#   - errors.404
#
# Missing translations in [fr]:
#   - messages.welcome
```

**Options:**
- `--locale=LOCALE` - Check specific locale only
- `--file=FILE` - Check specific translation file
- `--json` - Output in JSON format

```bash
# Check specific locale
php sixorbit translations:missing --locale=ar

# Check specific file
php sixorbit translations:missing --file=messages

# JSON output
php sixorbit translations:missing --json
```

### translations:sync

Synchronize translation keys across locales, adding missing keys with placeholder values.

```bash
# Sync all translations
php sixorbit translations:sync

# Output:
# Syncing translations...
# Added 3 missing keys to [ar]
# Added 1 missing key to [fr]
# Sync complete!
```

**Options:**
- `--source=LOCALE` - Source locale (default: en)
- `--target=LOCALE` - Target locale(s) to sync
- `--dry-run` - Show changes without applying
- `--placeholder=TEXT` - Custom placeholder text

```bash
# Sync from English to Arabic
php sixorbit translations:sync --source=en --target=ar

# Sync to multiple locales
php sixorbit translations:sync --target=ar,fr,es

# Dry run (preview changes)
php sixorbit translations:sync --dry-run

# Custom placeholder
php sixorbit translations:sync --placeholder="[NEEDS TRANSLATION]"
```

### translations:export

Export translations to various formats (JSON, CSV, XLIFF).

```bash
# Export to JSON
php sixorbit translations:export --format=json --output=translations.json

# Export to CSV
php sixorbit translations:export --format=csv --output=translations.csv

# Export specific locale
php sixorbit translations:export --locale=ar --format=json
```

### translations:import

Import translations from external files.

```bash
# Import from JSON
php sixorbit translations:import translations.json --locale=ar

# Import from CSV
php sixorbit translations:import translations.csv --locale=fr
```

### translations:status

Show translation completion status for all locales.

```bash
php sixorbit translations:status

# Output:
# Translation Status
# ==================
#
# Locale | Progress | Missing | Total
# -------|----------|---------|-------
# en     | 100%     | 0       | 150
# ar     | 85%      | 23      | 150
# fr     | 92%      | 12      | 150
# es     | 78%      | 33      | 150
```

## Practical Workflows

### Adding a New Locale

```bash
# 1. Create translation directory
mkdir -p resources/lang/de

# 2. Create translation files from English template
php sixorbit make:translation messages de --template=resources/lang/en/messages.php
php sixorbit make:translation errors de --template=resources/lang/en/errors.php
php sixorbit make:translation validation de --template=resources/lang/en/validation.php

# 3. Sync all keys from English
php sixorbit translations:sync --source=en --target=de

# 4. Check status
php sixorbit translations:status
```

### Finding and Fixing Missing Translations

```bash
# 1. Find missing translations
php sixorbit translations:missing --locale=ar

# 2. Review the missing keys

# 3. Sync to add placeholders
php sixorbit translations:sync --target=ar --placeholder="[TRANSLATE]"

# 4. Manually translate the placeholders in editor

# 5. Verify completion
php sixorbit translations:status
```

### Bulk Translation Update

```bash
# 1. Export current translations
php sixorbit translations:export --locale=ar --format=csv --output=ar_translations.csv

# 2. Send CSV to translation service

# 3. Import updated translations
php sixorbit translations:import ar_translations_updated.csv --locale=ar

# 4. Verify
php sixorbit translations:status
```

## Configuration

**config/localization.php**

```php
return [
    'default_locale' => 'en',
    'fallback_locale' => 'en',
    'supported_locales' => ['en', 'ar', 'fr', 'es', 'de'],

    // Translation sync settings
    'sync' => [
        'placeholder' => '[TODO]',
        'preserve_existing' => true,
    ],

    // Export settings
    'export' => [
        'formats' => ['json', 'csv', 'xliff'],
        'include_metadata' => true,
    ],
];
```

## Best Practices

1. **Use English as source** - Keep English (en) as the complete reference
2. **Sync regularly** - Run `translations:sync` after adding new keys
3. **Check status** - Monitor completion with `translations:status`
4. **Version control** - Commit translation files to git
5. **Placeholder convention** - Use consistent placeholders like `[TODO]`
6. **Review before deploy** - Check missing translations before production

## Integration with CI/CD

### Check for Missing Translations in CI

```bash
#!/bin/bash
# .github/workflows/translations.yml

# Fail if translations are missing
MISSING=$(php sixorbit translations:missing --json | jq '.total_missing')

if [ "$MISSING" -gt 0 ]; then
    echo "❌ Found $MISSING missing translations"
    php sixorbit translations:missing
    exit 1
fi

echo "✅ All translations present"
```

### Auto-sync in Development

```bash
# Add to composer.json
{
    "scripts": {
        "post-update-cmd": [
            "php sixorbit translations:sync --dry-run"
        ]
    }
}
```

## Translation File Structure

**resources/lang/en/messages.php**
```php
<?php

return [
    'welcome' => 'Welcome to our application',
    'goodbye' => 'Goodbye, :name!',

    'items' => '{0} No items|{1} One item|[2,*] :count items',

    'nested' => [
        'key' => 'Nested translation value',
    ],
];
```

**After sync to Arabic (resources/lang/ar/messages.php)**
```php
<?php

return [
    'welcome' => '[TODO]', // Auto-added placeholder
    'goodbye' => '[TODO]',

    'items' => '[TODO]',

    'nested' => [
        'key' => '[TODO]',
    ],
];
```

## Error Handling

```bash
# Command with validation
php sixorbit translations:sync --target=invalid_locale
# Error: Locale 'invalid_locale' is not supported

# Missing source file
php sixorbit translations:sync --source=nonexistent
# Error: Source locale 'nonexistent' does not exist
```

## Related Documentation

- [Translation Commands](/docs/dev-translation-commands)
- [Localization Implementation](/docs/dev-localization)
- [Internationalization](/docs/localization)
- [CLI Commands](/docs/dev-cli-commands)
