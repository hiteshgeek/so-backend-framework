# UiEngine Universal Nested Elements System

**Created:** 2026-02-05
**Purpose:** Central system for nesting elements at any level without custom methods

---

## Overview

The UiEngine now provides a universal way to nest Element objects inside any element at any level. This eliminates the need for custom `*Html()` methods like `titleHtml()`, `footerHtml()`, etc.

## Core Helper Method

### PHP: `renderMixed()`

```php
/**
 * Render mixed content (Element objects, strings, or arrays)
 *
 * @param Element|string|array|null $content
 * @return string
 */
protected function renderMixed(Element|string|array|null $content): string
```

### JavaScript: `_renderMixed()`

```javascript
/**
 * Render mixed content (Element objects, strings, or arrays)
 *
 * @param {Element|HTMLElement|string|Array|null} content
 * @returns {string}
 * @private
 */
_renderMixed(content)
```

---

## Features

### 1. **Element Nesting**
Pass Element objects directly to any method that previously only accepted strings:

```php
// PHP
UiEngine::card()
    ->title(UiEngine::badge()->text('New'))  // Element object!
    ->bodyText('Card with badge as title')
    ->render();
```

```javascript
// JavaScript
UiEngine.card()
    .title(UiEngine.badge().text('New'))  // Element object!
    .text('Card with badge as title')
    .render();
```

### 2. **Multiple Elements (Arrays)**
Pass multiple elements in a single property:

```php
// PHP - Multiple badges in title
UiEngine::card()
    ->title([
        'Project Status: ',
        UiEngine::badge()->text('Active')->success(),
        ' ',
        UiEngine::badge()->text('3 Issues')->warning()
    ])
    ->render();
```

```javascript
// JavaScript
UiEngine.card()
    .title([
        'Project Status: ',
        UiEngine.badge().text('Active').success(),
        ' ',
        UiEngine.badge().text('3 Issues').warning()
    ])
    .render();
```

### 3. **Infinite Nesting**
Elements can contain elements which contain elements, at any depth:

```php
// PHP - Deeply nested structure
UiEngine::card()
    ->title(
        UiEngine::flex()
            ->addClass('so-justify-content-between so-align-items-center')
            ->children([
                UiEngine::text('User Profile'),
                UiEngine::avatar('user.jpg')->online()
            ])
    )
    ->render();
```

### 4. **Mixed Content**
Combine strings, Element objects, and arrays freely:

```php
// PHP
$headerContent = [
    UiEngine::avatar('user.jpg')->small(),
    ' ',
    '<strong>John Doe</strong>',
    ' - ',
    UiEngine::badge()->text('Admin')->primary()
];

UiEngine::card()
    ->title($headerContent)
    ->render();
```

---

## Implementation Guide

### Updating Element Classes

To enable nesting in your element class:

#### Step 1: Update Property Type

```php
// OLD - string only
protected ?string $title = null;

// NEW - accept Element objects
protected Element|string|null $title = null;
```

#### Step 2: Update Method Signature

```php
// OLD - string only
public function title(string $title): static
{
    $this->title = $title;
    return $this;
}

// NEW - accept Element or string
public function title(Element|string $title): static
{
    $this->title = $title;
    return $this;
}
```

#### Step 3: Use renderMixed() in Rendering

```php
// In renderContent() or similar methods:

// OLD - direct concatenation
if ($this->title !== null) {
    $html .= '<h3>' . e($this->title) . '</h3>';
}

// NEW - use renderMixed()
if ($this->title !== null) {
    $html .= '<h3>' . $this->renderMixed($this->title) . '</h3>';
}
```

### JavaScript Implementation

```javascript
// Update property in constructor
this._title = null;  // Can be Element, string, or array

// Update method
title(title) {
    this._title = title;
    return this;
}

// Use _renderMixed() in rendering
if (this._title) {
    html += `<h3>${this._renderMixed(this._title)}</h3>`;
}
```

---

## Example: Refactoring Card Class

### Before (Old Way)

```php
// PHP
class Card extends Element
{
    protected ?string $title = null;
    protected ?string $titleHtml = null;  // Separate method needed

    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function titleHtml(string $html): static
    {
        $this->titleHtml = $html;
        return $this;
    }

    // In rendering:
    if ($this->titleHtml !== null) {
        $html .= '<h3>' . $this->titleHtml . '</h3>';
    } elseif ($this->title !== null) {
        $html .= '<h3>' . e($this->title) . '</h3>';
    }
}

// Usage - awkward
UiEngine::card()
    ->titleHtml(UiEngine::badge()->text('New')->render())
    ->render();
```

### After (New Way)

```php
// PHP
class Card extends Element
{
    protected Element|string|array|null $title = null;  // One property!

    public function title(Element|string|array $title): static
    {
        $this->title = $title;
        return $this;
    }

    // In rendering:
    if ($this->title !== null) {
        $html .= '<h3>' . $this->renderMixed($this->title) . '</h3>';
    }
}

// Usage - clean and intuitive
UiEngine::card()
    ->title(UiEngine::badge()->text('New'))  // Pass Element directly!
    ->render();
```

---

## Real-World Examples

### Example 1: Card with Badge in Title

```php
// PHP
UiEngine::card()
    ->title([
        'New Feature ',
        UiEngine::badge()->text('Beta')->warning()
    ])
    ->bodyText('Try our new experimental feature!')
    ->render();
```

```javascript
// JavaScript
UiEngine.card()
    .title([
        'New Feature ',
        UiEngine.badge().text('Beta').warning()
    ])
    .text('Try our new experimental feature!')
    .render();
```

### Example 2: Card with Avatar and Button in Header

```php
// PHP
UiEngine::card()
    ->title([
        UiEngine::avatar('user.jpg')->small()->online(),
        ' John Doe'
    ])
    ->headerAction(UiEngine::button()->iconOnly('more_vert')->variant('ghost'))
    ->bodyText('Posted 2 hours ago')
    ->render();
```

### Example 3: Complex Nested Structure

```php
// PHP
UiEngine::card()
    ->title(
        UiEngine::flex()
            ->addClass('so-justify-content-between so-w-full')
            ->children([
                UiEngine::flex()
                    ->addClass('so-gap-2')
                    ->children([
                        UiEngine::avatar('user.jpg')->medium(),
                        UiEngine::text('Sarah Wilson')
                    ]),
                UiEngine::badge()->text('Admin')->primary()
            ])
    )
    ->render();
```

### Example 4: Multiple Badges

```php
// PHP
UiEngine::card()
    ->title('Project Status')
    ->subtitle([
        UiEngine::badge()->text('Active')->soft()->success(),
        ' ',
        UiEngine::badge()->text('3 Tasks')->soft()->info(),
        ' ',
        UiEngine::badge()->text('High Priority')->soft()->danger()
    ])
    ->render();
```

---

## Benefits

### 1. **No More Custom *Html() Methods**
- Eliminates `titleHtml()`, `footerHtml()`, etc.
- Single method per property
- Cleaner API surface

### 2. **Type Safety**
- Union types ensure correctness
- IDE autocomplete works perfectly
- Catches errors at development time

### 3. **Composability**
- Build complex UIs from simple components
- Reuse components everywhere
- Natural component hierarchy

### 4. **Consistency**
- Same pattern across all elements
- PHP and JavaScript work identically
- Easy to learn and use

### 5. **Flexibility**
- Mix strings and elements freely
- Arrays for multiple items
- Infinite nesting depth

---

## renderMixed() Behavior

### Input → Output

| Input Type | Behavior | Example |
|------------|----------|---------|
| `null` | Returns empty string `""` | `renderMixed(null)` → `""` |
| `Element` | Calls `->render()` | `renderMixed(Badge::make())` → `"<span class='so-badge'>...</span>"` |
| `string` | Returns as-is | `renderMixed("Hello")` → `"Hello"` |
| `array` | Recursively renders each item | `renderMixed(['Hi', Badge::make()])` → `"Hi<span>...</span>"` |

### Recursive Handling

```php
// PHP - handles nested arrays
$content = [
    'Header: ',
    [
        UiEngine::badge()->text('New'),
        ' ',
        UiEngine::badge()->text('Hot')
    ],
    ' - ',
    'Description'
];

$this->renderMixed($content);
// Output: "Header: <span>New</span> <span>Hot</span> - Description"
```

---

## Migration Guide

### Step 1: Identify Custom *Html() Methods

Find all methods like:
- `titleHtml()`
- `subtitleHtml()`
- `footerHtml()`
- `headerHtml()`
- Any method ending in `Html()`

### Step 2: Update Property Types

```php
// Change from:
protected ?string $title = null;

// To:
protected Element|string|array|null $title = null;
```

### Step 3: Update Method Signatures

```php
// Change from:
public function title(string $title): static

// To:
public function title(Element|string|array $title): static
```

### Step 4: Update Rendering Logic

```php
// Change from:
$html .= '<h3>' . e($this->title) . '</h3>';

// To:
$html .= '<h3>' . $this->renderMixed($this->title) . '</h3>';
```

### Step 5: Remove *Html() Methods

Delete the `*Html()` methods since the base method now handles both cases.

### Step 6: Update Tests and Docs

Update examples to show Element nesting instead of `*Html()` methods.

---

## Best Practices

### ✅ DO

```php
// Use Element nesting
UiEngine::card()
    ->title(UiEngine::badge()->text('New'))
    ->render();

// Use arrays for multiple items
UiEngine::card()
    ->title(['Status: ', UiEngine::badge()->text('Active')])
    ->render();

// Combine with strings
UiEngine::card()
    ->title([
        'User: ',
        UiEngine::avatar('user.jpg'),
        ' John'
    ])
    ->render();
```

### ❌ DON'T

```php
// Don't call render() manually
UiEngine::card()
    ->title(UiEngine::badge()->text('New')->render())  // ❌ No!
    ->render();

// Don't use *Html() methods anymore
UiEngine::card()
    ->titleHtml('<span>HTML</span>')  // ❌ Deprecated!
    ->render();
```

---

## Performance Considerations

### Rendering Cost

- `renderMixed()` adds minimal overhead
- Only renders when needed
- Recursive calls are optimized
- No performance impact for simple strings

### Memory

- Element objects are lightweight
- No deep cloning
- Efficient array handling

---

## Backward Compatibility

### Existing Code

Code using `*Html()` methods will continue to work during transition:

```php
// Old code still works
UiEngine::card()
    ->titleHtml('<span>Title</span>')
    ->render();

// But new code is preferred
UiEngine::card()
    ->title(UiEngine::text('Title'))
    ->render();
```

### Migration Period

1. **Phase 1** (Current): Both methods coexist
2. **Phase 2**: Deprecate `*Html()` methods
3. **Phase 3**: Remove `*Html()` methods in next major version

---

## Testing

### Unit Tests

```php
// Test Element nesting
public function test_title_accepts_element()
{
    $badge = UiEngine::badge()->text('New');
    $card = UiEngine::card()->title($badge);

    $html = $card->render();

    $this->assertStringContainsString('<span class="so-badge">New</span>', $html);
}

// Test arrays
public function test_title_accepts_array()
{
    $card = UiEngine::card()->title([
        'Status: ',
        UiEngine::badge()->text('Active')
    ]);

    $html = $card->render();

    $this->assertStringContainsString('Status:', $html);
    $this->assertStringContainsString('<span class="so-badge">Active</span>', $html);
}

// Test nesting depth
public function test_deep_nesting()
{
    $card = UiEngine::card()->title(
        UiEngine::flex()->children([
            UiEngine::text('Title'),
            UiEngine::badge()->text('New')
        ])
    );

    $html = $card->render();

    $this->assertStringContainsString('<div class="so-flex">', $html);
    $this->assertStringContainsString('<span class="so-badge">New</span>', $html);
}
```

---

## Conclusion

The universal nesting system makes the UiEngine more powerful and easier to use. By eliminating custom `*Html()` methods and enabling natural component composition, we've created a cleaner, more intuitive API that works consistently across PHP and JavaScript.

**Key Takeaway:** Any element can now contain any other element at any nesting level, using a single unified approach.

---

## See Also

- [UIENGINE-PHP-JS-COMPARISON.md](./UIENGINE-PHP-JS-COMPARISON.md) - Component class reference
- [Card Component Documentation](../core/UiEngine/Elements/Display/Card.php) - Example implementation
- [Element Base Class](../core/UiEngine/Elements/Element.php) - Core implementation
