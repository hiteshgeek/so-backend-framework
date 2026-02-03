# Translation Commands

*This is an alias for the [Translation CLI Guide](/docs/dev-translation-cli).*

## Quick Reference

```bash
# Create translation file
php sixorbit make:translation <file> <locale>

# Find missing translations
php sixorbit translations:missing [--locale=LOCALE]

# Sync translations across locales
php sixorbit translations:sync [--target=LOCALE]

# Check translation status
php sixorbit translations:status

# Export translations
php sixorbit translations:export [--format=json|csv|xliff]

# Import translations
php sixorbit translations:import <file> --locale=LOCALE
```

For complete documentation, see [Translation CLI Guide](/docs/dev-translation-cli).
