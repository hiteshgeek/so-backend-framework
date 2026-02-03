# RTL Language Support

## Overview

The framework provides comprehensive support for Right-to-Left (RTL) languages including Arabic, Hebrew, Persian, and Urdu.

## Supported RTL Languages

- **Arabic (ar)** - العربية
- **Hebrew (he)** - עברית
- **Persian (fa)** - فارسی
- **Urdu (ur)** - اردو

## Automatic Direction Detection

The framework automatically detects and applies RTL direction based on the current locale:

```php
// In your layout
<html lang="<?= app()->getLocale() ?>" dir="<?= app()->getTextDirection() ?>">
```

## RTL Helper Functions

### Check if Current Locale is RTL

```php
if (is_rtl()) {
    // Current locale uses RTL
}

if (locale_is_rtl('ar')) {
    // Arabic is RTL
}
```

### Get Text Direction

```php
$direction = get_text_direction(); // 'rtl' or 'ltr'
```

## CSS Integration

### Automatic RTL Styles

The framework automatically applies RTL-specific styles:

```html
<!-- LTR (English) -->
<html dir="ltr">
    <link rel="stylesheet" href="/assets/css/app.css">
</html>

<!-- RTL (Arabic) -->
<html dir="rtl">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/rtl.css">
</html>
```

### RTL-Aware CSS Properties

Use logical properties that automatically flip for RTL:

```css
/* Instead of */
margin-left: 10px;
float: right;

/* Use */
margin-inline-start: 10px;
float: inline-end;
```

### Manual RTL Overrides

```css
/* LTR */
.element {
    text-align: left;
    padding-left: 20px;
}

/* RTL override */
[dir="rtl"] .element {
    text-align: right;
    padding-right: 20px;
    padding-left: 0;
}
```

## Blade/SOTemplate Directives

### @rtl Directive

```php
<div class="container">
    @rtl
        <p>This content only shows in RTL mode</p>
    @endrtl
</div>
```

### @ltr Directive

```php
<div class="container">
    @ltr
        <p>This content only shows in LTR mode</p>
    @endltr
</div>
```

### Conditional Classes

```php
<div class="@rtl('text-right', 'text-left')">
    Content with dynamic alignment
</div>
```

## UiEngine RTL Support

All UiEngine components automatically support RTL:

```php
use Core\UiEngine\UiEngine;

// Form automatically flips for RTL
$form = UiEngine::form()
    ->action('/submit')
    ->field(
        UiEngine::text('username')
            ->label('Username')  // Label positioned correctly for RTL
    );
```

## Formatting Numbers and Dates

### Numbers

```php
// English: 1,234.56
// Arabic: ١٬٢٣٤٫٥٦
echo format_number(1234.56, locale: 'ar');
```

### Dates

```php
// Format dates according to locale
echo format_date(now(), 'full', 'ar');
// الأحد، ٣ فبراير ٢٠٢٦
```

## Common RTL Issues and Solutions

### Issue: Icons and Images Not Flipping

**Solution:** Use CSS transform or RTL-aware icon libraries:

```css
[dir="rtl"] .icon-arrow-right {
    transform: scaleX(-1);
}
```

### Issue: Form Labels Misaligned

**Solution:** Use flexbox with `flex-direction: row-reverse`:

```css
[dir="rtl"] .form-label {
    flex-direction: row-reverse;
}
```

### Issue: Scrollbars on Wrong Side

**Solution:** Browser handles this automatically for `dir="rtl"`.

## Testing RTL Layouts

### Switch Locale in Browser

```php
// Add to your routes
Router::get('/locale/{locale}', function($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
```

### Test URLs

- English (LTR): `http://yourapp.test/locale/en`
- Arabic (RTL): `http://yourapp.test/locale/ar`
- Hebrew (RTL): `http://yourapp.test/locale/he`

## Best Practices

1. **Always use `dir` attribute** on `<html>` element
2. **Use logical CSS properties** (margin-inline-start instead of margin-left)
3. **Test with actual RTL content** - Lorem ipsum doesn't reveal layout issues
4. **Mirror icons appropriately** - arrows and chevrons should flip
5. **Don't flip logos or brand elements**
6. **Use separate RTL stylesheet** for overrides

## Related Documentation

- [Internationalization](/docs/localization)
- [RTL Layout Guide](/docs/dev-rtl-layouts)
- [Translation Commands](/docs/dev-translation-commands)

## External Resources

- [MDN: CSS Logical Properties](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Logical_Properties)
- [W3C: Structural Markup and Right-to-Left Text](https://www.w3.org/International/questions/qa-html-dir)
