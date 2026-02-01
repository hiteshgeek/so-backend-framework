# Internationalization (i18n) and Localization (l10n)

## Overview

The SO Backend Framework includes a comprehensive internationalization and localization system that supports:

- **Multi-language**: English, French, German (with pattern for adding more)
- **Multi-currency**: 15+ currencies with locale-specific formatting
- **Multi-timezone**: User-specific timezone preferences
- **Automatic locale detection**: From query parameters, user preferences, session, or HTTP headers
- **Translation system**: File-based translations with parameter replacement and pluralization

---

## Requirements

**PHP Intl Extension Required**

The localization system requires the PHP Intl extension for accurate currency, number, and date formatting across different locales.

### Installation

**Ubuntu/Debian:**
```bash
sudo apt-get install php8.3-intl
sudo service apache2 restart
# or for PHP-FPM:
sudo service php8.3-fpm restart
```

**CentOS/RHEL:**
```bash
sudo yum install php-intl
sudo systemctl restart httpd
```

**macOS (Homebrew):**
```bash
brew install php
# Intl is included by default in Homebrew PHP
```

**Verify Installation:**
```bash
php -m | grep intl
# Should output: intl
```

**Check in PHP Info:**
```php
phpinfo();
// Search for "intl" section
```

---

## Quick Start

### Basic Translation

```php
// Simple translation
echo trans('validation.required');
// Output: "The :attribute field is required."

// Translation with parameters
echo trans('validation.required', ['attribute' => 'email']);
// Output: "The email field is required."

// Translation with specific locale
echo trans('validation.required', ['attribute' => 'email'], 'fr');
// Output: "Le champ email est obligatoire."
```

### Setting User Locale

```php
// Get current locale
$locale = locale(); // Returns 'en', 'fr', 'de', etc.

// Set locale for current request
setLocale('fr');

// Set user's preferred locale (persists in database)
$user = auth()->user();
$user->setLocale('fr');
$user->setTimezone('Europe/Paris');
```

### Currency Formatting

```php
// Format currency with auto-detection
echo format_currency(1234.56);
// Output (en): "$1,234.56"
// Output (fr): "1 234,56 $"
// Output (de): "1.234,56 $"

// Explicit currency and locale
echo format_currency(1234.56, 'EUR', 'fr');
// Output: "1 234,56 €"

// Accounting format (negative in parentheses)
$formatter = app('currency.formatter');
echo $formatter->formatAccounting(-1234.56, 'USD', 'en');
// Output: "($1,234.56)"
```

### Number Formatting

```php
// Format numbers with locale-specific separators
echo format_number(1234567.89);
// Output (en): "1,234,567.89"
// Output (fr): "1 234 567,89"
// Output (de): "1.234.567,89"

// Percentage formatting
$formatter = app('number.formatter');
echo $formatter->formatPercent(0.1234);
// Output (en): "12.34%"

// File size formatting
echo $formatter->formatFileSize(1536000);
// Output: "1.46 MB"
```

### Date/Time Formatting

```php
// Format date with preset
echo format_date(new DateTime(), 'medium');
// Output (en): "Feb 1, 2026"
// Output (fr): "1 févr. 2026"
// Output (de): "1. Feb. 2026"

// Format datetime with timezone
echo format_datetime(new DateTime(), 'long', 'America/New_York');
// Output: "February 1, 2026 3:45 PM EST"

// Relative time
$formatter = app('datetime.formatter');
echo $formatter->formatRelative(new DateTime('-2 hours'));
// Output (en): "2 hours ago"
// Output (fr): "il y a 2 heures"
// Output (de): "vor 2 Stunden"
```

---

## API Integration

### Locale Switching via Query Parameter

```bash
# English (default)
curl http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"wrong"}'

# Response:
{
  "success": false,
  "message": "Invalid email or password."
}

# French
curl http://localhost:8000/api/auth/login?locale=fr \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"wrong"}'

# Response:
{
  "success": false,
  "message": "Email ou mot de passe invalide."
}

# German
curl http://localhost:8000/api/auth/login?locale=de \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"wrong"}'

# Response:
{
  "success": false,
  "message": "Ungültige E-Mail oder Passwort."
}
```

### Validation Errors

```bash
curl http://localhost:8000/api/auth/register?locale=fr \
  -H "Content-Type: application/json" \
  -d '{"email":"invalid","password":"123"}'

# Response (in French):
{
  "success": false,
  "message": "La validation a échoué.",
  "errors": {
    "email": "Le champ adresse e-mail doit être une adresse e-mail valide.",
    "password": "Le champ mot de passe doit contenir au moins 8 caractères."
  }
}
```

---

## Locale Detection Priority

The system automatically detects the locale in this order:

1. **Query Parameter** (`?locale=fr`) - Highest priority
2. **User Preference** - If user is logged in and has saved locale
3. **Session** - Locale stored in current session
4. **Accept-Language Header** - Browser preference
5. **Default** - From config (`app.locale`)

---

## Available Locales

### Production-Ready Languages

| Code | Language | Native Name | Direction | Currency | Timezone |
|------|----------|-------------|-----------|----------|----------|
| `en` | English | English | LTR | USD | UTC |
| `fr` | French | Français | LTR | EUR | Europe/Paris |
| `de` | German | Deutsch | LTR | EUR | Europe/Berlin |

### Supported (Configuration Ready)

- `es` - Spanish (Español)
- `ar` - Arabic (العربية) - RTL support
- `zh` - Chinese (中文)
- `ja` - Japanese (日本語)
- `pt` - Portuguese (Português)
- `it` - Italian (Italiano)
- `ru` - Russian (Русский)
- `hi` - Hindi (हिन्दी)
- `ko` - Korean (한국어)

---

## Translation Files Structure

```
resources/lang/
├── en/                          # English
│   ├── validation.php          # Validation messages (24+)
│   ├── auth.php                # Authentication (40+)
│   ├── messages.php            # General API messages (50+)
│   ├── notifications.php       # Notification templates (30+)
│   ├── status.php              # Status labels (50+)
│   └── errors.php              # HTTP errors (30+)
├── fr/                          # French (same structure)
├── de/                          # German (same structure)
└── locales.php                 # Per-locale configuration
```

---

## Using Translations in Controllers

### Before (Hardcoded)

```php
public function register(Request $request): Response
{
    $validator = Validator::make($request->all(), [...]);

    if ($validator->fails()) {
        return JsonResponse::error('Validation failed', 422, [
            'errors' => $validator->errors()
        ]);
    }

    // ... create user ...

    return JsonResponse::success([
        'message' => 'Account created successfully!',
        'user' => $user,
    ]);
}
```

### After (Translatable)

```php
public function register(Request $request): Response
{
    $validator = Validator::make($request->all(), [...]);

    if ($validator->fails()) {
        return JsonResponse::error(trans('validation.failed'), 422, [
            'errors' => $validator->errors()
        ]);
    }

    // ... create user ...

    return JsonResponse::success([
        'message' => trans('auth.registration_success'),
        'user' => $user,
    ]);
}
```

---

## Configuration

### Environment Variables

```env
# .env
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_TIMEZONE=Asia/Kolkata
DEFAULT_CURRENCY=INR
LOCALE_DETECTION_ENABLED=true
```

### Configuration Files

**config/app.php**
```php
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
'timezone' => env('APP_TIMEZONE', 'Asia/Kolkata'),
'available_locales' => ['en', 'fr', 'de', 'es', 'ar', 'zh'],
```

**config/localization.php**
```php
'detection' => [
    'enabled' => env('LOCALE_DETECTION_ENABLED', true),
    'sources' => ['query', 'user', 'session', 'header', 'default'],
    'query_parameter' => 'locale',
    'session_key' => 'locale',
],

'currencies' => [
    'default' => env('DEFAULT_CURRENCY', 'INR'),
    'available' => ['USD', 'EUR', 'GBP', 'JPY', 'CNY', 'AED', 'SAR', 'INR'],
],
```

---

## Database Migration

Run the migration to add locale columns to users table:

```bash
./sixorbit migrate
```

This adds:
- `locale` VARCHAR(10) DEFAULT 'en'
- `timezone` VARCHAR(50) DEFAULT 'UTC'

---

## Adding New Languages

### 1. Create Translation Files

Copy the English translation directory and translate:

```bash
cp -r resources/lang/en resources/lang/es
# Edit all 6 files in resources/lang/es/
```

### 2. Update Configuration

**resources/lang/locales.php**
```php
'es' => [
    'name' => 'Spanish',
    'native' => 'Español',
    'direction' => 'ltr',
    'timezone' => 'Europe/Madrid',
    'currency' => 'EUR',
    'date_format' => 'd/m/Y',
    'first_day_of_week' => 1, // Monday
],
```

**config/localization.php**
```php
'available_locales' => [
    'en' => 'English',
    'fr' => 'Français',
    'de' => 'Deutsch',
    'es' => 'Español', // Add this
],
```

### 3. Test

```bash
curl http://localhost:8000/api/auth/login?locale=es
```

---

## Best Practices

### 1. Always Use Translation Keys

❌ **Bad:**
```php
return JsonResponse::error('User not found', 404);
```

✅ **Good:**
```php
return JsonResponse::error(trans('messages.not_found'), 404);
```

### 2. Use Descriptive Keys

❌ **Bad:**
```php
trans('msg1') // What does this mean?
```

✅ **Good:**
```php
trans('auth.login_success')
trans('validation.email')
trans('messages.user_created')
```

### 3. Organize by Context

- `validation.*` - Form validation messages
- `auth.*` - Authentication/authorization
- `messages.*` - General API messages
- `notifications.*` - Notification templates
- `status.*` - Status labels
- `errors.*` - Error messages

### 4. Use Parameters for Dynamic Content

```php
trans('messages.user_deleted', ['name' => $userName])
trans('validation.min', ['attribute' => 'password', 'min' => 8])
trans('notifications.order.shipped', ['order_id' => $orderId, 'tracking_number' => $tracking])
```

---

## Troubleshooting

### Translation Not Found

If a translation key is not found:
1. Returns the key itself (e.g., "validation.required")
2. Falls back to `fallback_locale` (usually 'en')
3. Logs a warning (if logging enabled)

### Locale Not Detected

Check:
1. Is locale detection enabled? (`LOCALE_DETECTION_ENABLED=true`)
2. Is the locale in `available_locales`?
3. Check middleware is registered
4. Check browser Accept-Language header

### Application Fails to Start

**Error:** "Required PHP extension 'intl' is not loaded"

**Solution:**
1. Install the extension (see Requirements section above)
2. Verify installation: `php -m | grep intl`
3. Restart your web server
4. Check `php.ini` to ensure `extension=intl.so` is uncommented (or `extension=intl.dll` on Windows)

---

## Performance

- **Translation Loading**: Lazy-loaded on first use
- **Caching**: In-memory per-request (OpCode cache for files)
- **No Database Queries**: All translations from files
- **Minimal Overhead**: ~1-2ms per request

---

## Security

- **Input Validation**: Locale codes validated against whitelist
- **XSS Prevention**: Always escape translated strings in views with `e()`
- **Directory Traversal**: Prevented by locale code validation
- **No User Input**: Translation keys are hardcoded in application

---

## Support

For issues or questions:
- See implementation plan: `/home/hitesh/.claude/plans/woolly-stargazing-planet.md`
- See progress tracker: `I18N_IMPLEMENTATION_PROGRESS.md`
- Framework documentation: `docs/index.php`
