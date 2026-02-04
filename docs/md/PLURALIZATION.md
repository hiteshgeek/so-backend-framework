# CLDR Pluralization

## Overview

The framework includes comprehensive pluralization support based on CLDR (Common Locale Data Repository) standards, handling complex plural forms across 6 language families.

## Language Families Supported

### 1. Germanic Languages (2 forms)
- English, German, Dutch, Swedish, Danish, Norwegian

### 2. Romance Languages (2 forms)
- French, Italian, Spanish, Portuguese, Romanian

### 3. Slavic Languages (3-4 forms)
- Russian, Polish, Czech, Croatian, Ukrainian

### 4. Arabic (6 forms)
- Arabic (zero, one, two, few, many, other)

### 5. Asian Languages (1 form)
- Chinese, Japanese, Korean, Thai, Vietnamese

### 6. Complex Rules
- Welsh, Maltese, Irish Gaelic

## Usage

### Basic Pluralization

```php
use Core\Localization\Pluralizer;

// English (2 forms: one, other)
echo trans_choice('messages.items', 1);  // "1 item"
echo trans_choice('messages.items', 5);  // "5 items"

// Russian (3 forms: one, few, many)
echo trans_choice('messages.items', 1);   // "1 предмет"
echo trans_choice('messages.items', 2);   // "2 предмета"
echo trans_choice('messages.items', 5);   // "5 предметов"

// Arabic (6 forms)
echo trans_choice('messages.items', 0);   // "لا عناصر"
echo trans_choice('messages.items', 1);   // "عنصر واحد"
echo trans_choice('messages.items', 2);   // "عنصران"
echo trans_choice('messages.items', 11);  // "11 عنصراً"
```

### Translation Files

**resources/lang/en/messages.php**
```php
return [
    'items' => '{0} No items|{1} :count item|[2,*] :count items',
];
```

**resources/lang/ru/messages.php**
```php
return [
    'items' => '{0} Нет предметов|{1} :count предмет|[2,4] :count предмета|[5,*] :count предметов',
];
```

**resources/lang/ar/messages.php**
```php
return [
    'items' => '{0} لا عناصر|{1} عنصر واحد|{2} عنصران|[3,10] :count عناصر|[11,*] :count عنصراً',
];
```

## Plural Rules by Language

### English (en)
- **one**: n = 1
- **other**: everything else

### Russian (ru)
- **one**: n mod 10 = 1 and n mod 100 ≠ 11
- **few**: n mod 10 = 2-4 and n mod 100 ≠ 12-14
- **many**: everything else

### Arabic (ar)
- **zero**: n = 0
- **one**: n = 1
- **two**: n = 2
- **few**: n mod 100 = 3-10
- **many**: n mod 100 = 11-99
- **other**: everything else

### Polish (pl)
- **one**: n = 1
- **few**: n mod 10 = 2-4 and n mod 100 ≠ 12-14
- **many**: everything else

## Custom Plural Rules

Define custom pluralization logic:

```php
use Core\Localization\Pluralizer;

Pluralizer::extend('custom', function($count) {
    if ($count === 0) return 'zero';
    if ($count === 1) return 'one';
    if ($count >= 2 && $count <= 10) return 'few';
    return 'many';
});
```

## Best Practices

1. **Always use trans_choice()** for countable items
2. **Include all plural forms** for target languages
3. **Use :count placeholder** for number substitution
4. **Test with edge cases**: 0, 1, 2, 11, 21, 100, 101

## Common Patterns

```php
// Items count
trans_choice('messages.items', $count)

// Time periods
trans_choice('messages.days_ago', $days)
trans_choice('messages.hours_remaining', $hours)

// User counts
trans_choice('messages.users_online', $userCount)

// File sizes
trans_choice('messages.files_uploaded', $fileCount)
```

## Related Documentation

- [Internationalization](/docs/localization)
- [ICU MessageFormat](/docs/icu-messageformat)
- [Localization Implementation](/docs/dev-localization)

## References

- [CLDR Plural Rules](https://cldr.unicode.org/index/cldr-spec/plural-rules)
- [Unicode LDML](https://unicode.org/reports/tr35/tr35-numbers.html#Language_Plural_Rules)
