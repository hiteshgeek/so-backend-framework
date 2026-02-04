# ICU MessageFormat

## Overview

ICU MessageFormat provides advanced message formatting with support for pluralization, gender selection, and complex number patterns. This is essential for enterprise applications with sophisticated internationalization needs.

## Why ICU MessageFormat?

Standard string interpolation falls short for complex translations:

```php
// ❌ Simple but breaks in many languages
"You have {count} messages"

// ✅ ICU MessageFormat handles plurals correctly
"{count, plural, =0 {No messages} one {1 message} other {# messages}}"
```

## Basic Syntax

### Simple Substitution

```php
// Translation file
'greeting' => 'Hello, {name}!'

// Usage
trans('messages.greeting', ['name' => 'Ahmed'])
// Output: Hello, Ahmed!
```

### Number Formatting

```php
// Translation
'price' => 'Total: {amount, number, currency}'

// Usage
trans('messages.price', ['amount' => 1234.56])
// Output (en): Total: $1,234.56
// Output (ar): Total: ١٬٢٣٤٫٥٦ ر.س
```

## Plural Selection

### Basic Plurals

```php
// Translation
'items' => '{count, plural, =0 {No items} one {1 item} other {# items}}'

// Usage
trans('messages.items', ['count' => 0])  // "No items"
trans('messages.items', ['count' => 1])  // "1 item"
trans('messages.items', ['count' => 5])  // "5 items"
```

### Language-Specific Plurals

```php
// English (2 forms)
'messages' => '{count, plural, one {# message} other {# messages}}'

// Russian (3 forms)
'messages' => '{count, plural, one {# сообщение} few {# сообщения} other {# сообщений}}'

// Arabic (6 forms)
'messages' => '{count, plural,
    =0 {لا رسائل}
    one {رسالة واحدة}
    two {رسالتان}
    few {# رسائل}
    many {# رسالة}
    other {# رسالة}
}'
```

## Select (Gender/Choice)

### Gender Selection

```php
// Translation
'task_assigned' => '{gender, select,
    male {He was assigned the task}
    female {She was assigned the task}
    other {They were assigned the task}
}'

// Usage
trans('messages.task_assigned', ['gender' => 'female'])
// Output: She was assigned the task
```

### Custom Selection

```php
// Translation
'file_action' => '{action, select,
    upload {File uploaded successfully}
    delete {File deleted successfully}
    move {File moved successfully}
    other {File operation completed}
}'
```

## Nested Patterns

Combine plural, select, and number formatting:

```php
// Complex message
'notification' => '{gender, select,
    male {{count, plural,
        one {He sent you 1 message}
        other {He sent you # messages}
    }}
    female {{count, plural,
        one {She sent you 1 message}
        other {She sent you # messages}
    }}
    other {{count, plural,
        one {They sent you 1 message}
        other {They sent you # messages}
    }}
}'

// Usage
trans('messages.notification', [
    'gender' => 'female',
    'count' => 3
])
// Output: She sent you 3 messages
```

## Number Formatting Options

### Currency

```php
'price' => '{amount, number, ::currency/USD}'

trans('msg.price', ['amount' => 1234.56])
// Output (en): $1,234.56
// Output (ar): US$ ١٬٢٣٤٫٥٦
```

### Percentage

```php
'progress' => 'Progress: {percent, number, ::percent}'

trans('msg.progress', ['percent' => 0.75])
// Output: Progress: 75%
```

### Compact Numbers

```php
'views' => '{count, number, ::compact-short} views'

trans('msg.views', ['count' => 1500000])
// Output (en): 1.5M views
// Output (ar): ١٫٥ مليون مشاهدة
```

## Date and Time Formatting

### Date Formats

```php
// Translation
'published' => 'Published on {date, date, medium}'

// Usage
trans('messages.published', ['date' => now()])
// Output (en): Published on Feb 3, 2026
// Output (ar): Published on ٣ فبراير ٢٠٢٦
```

### Time Formats

```php
'event_time' => 'Event starts at {time, time, short}'

trans('messages.event_time', ['time' => now()])
// Output (en): Event starts at 2:30 PM
// Output (ar): Event starts at ٢:٣٠ م
```

### Relative Time

```php
'last_seen' => 'Last seen {time, time, relative}'

trans('messages.last_seen', ['time' => now()->subHours(2)])
// Output: Last seen 2 hours ago
```

## Practical Examples

### E-commerce

```php
// Cart summary
'cart_summary' => '{itemCount, plural,
    =0 {Your cart is empty}
    one {You have 1 item ({totalPrice, number, ::currency/USD})}
    other {You have # items ({totalPrice, number, ::currency/USD})}
}'

trans('cart.summary', [
    'itemCount' => 3,
    'totalPrice' => 149.97
])
// Output: You have 3 items ($149.97)
```

### Social Media

```php
'likes' => '{likeCount, plural,
    =0 {Be the first to like this}
    one {{userName} likes this}
    other {{userName} and {otherCount, number} others like this}
}'
```

### Email Notifications

```php
'task_notification' => '{assignerGender, select,
    male {{taskCount, plural,
        one {He assigned you 1 task}
        other {He assigned you # tasks}
    }}
    female {{taskCount, plural,
        one {She assigned you 1 task}
        other {She assigned you # tasks}
    }}
}'
```

## Configuration

### Enable ICU MessageFormat

**config/localization.php**
```php
return [
    'use_icu_format' => true,
    'fallback_locale' => 'en',
    'supported_locales' => ['en', 'ar', 'fr', 'ru'],
];
```

## Helper Functions

```php
// ICU message formatting
icu_trans('messages.items', ['count' => 5])

// With locale override
icu_trans('messages.items', ['count' => 5], 'ar')
```

## Best Practices

1. **Use plural rules** instead of conditionals
2. **Define all plural forms** for target language
3. **Use select for gender/variants** instead of separate messages
4. **Nest patterns** for complex scenarios
5. **Test with edge cases**: 0, 1, 2, 11, 21, etc.

## Common Patterns

```php
// Item count with actions
'{count, plural,
    =0 {No items. {action, select, add {Add one?} other {Get started}}}
    one {1 item}
    other {# items}
}'

// User activity
'{user} {action, select,
    like {liked your post}
    comment {commented on your post}
    share {shared your post}
    other {interacted with your post}
} {time, time, relative}'
```

## Related Documentation

- [Pluralization](/docs/pluralization)
- [Internationalization](/docs/localization)
- [Translation Commands](/docs/dev-translation-commands)

## External Resources

- [ICU User Guide](https://unicode-org.github.io/icu/userguide/format_parse/messages/)
- [MessageFormat Specification](https://unicode.org/reports/tr35/tr35-messageFormat.html)
