# Html Element

**Generic HTML element for creating any HTML tag (div, span, p, a, etc.) with a fluent API and symmetric PHP/JavaScript implementation.**

---

## Overview

The `Html` class provides a flexible way to create any HTML element programmatically using the UiEngine. It supports:

- Creating any HTML tag (div, span, p, a, section, article, etc.)
- Setting text content (escaped) or raw HTML (innerHTML)
- Link attributes (href, target)
- Self-closing tags (img, br, hr, etc.)
- Full CSS class and attribute support from Element base class

> **Note:** The Html class extends `ContainerElement`, so it can contain child elements just like Form, Card, Row, and Column.

---

## Dual Architecture: PHP & JavaScript

The Html element has **identical APIs** in both PHP and JavaScript, enabling true full-stack development with a single mental model.

### PHP Implementation

**Location:** `core/UiEngine/Elements/Html.php`
**Extends:** `ContainerElement`
**Factory:** `UiEngine::html()`, `UiEngine::div()`, etc.

### JavaScript Implementation

**Location:** `frontend/src/js/ui-engine/elements/Html.js`
**Extends:** `ContainerElement`
**Factory:** `UiEngine.html()`, `UiEngine.div()`, etc.

---

## Factory Methods

### PHP

```php
UiEngine::html(string $tag = 'div', ?string $content = null): Html
UiEngine::div(?string $content = null): Html
UiEngine::span(?string $content = null): Html
UiEngine::p(?string $content = null): Html
UiEngine::a(?string $href = null, ?string $text = null): Html
```

### JavaScript

```javascript
UiEngine.html(tag = 'div', content = null): Html
UiEngine.div(content = null): Html
UiEngine.span(content = null): Html
UiEngine.p(content = null): Html
UiEngine.a(href = null, text = null): Html
```

---

## API Methods

### Core Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `tag()` | Set HTML tag name | `tag(string $tag): static` | `tag(tag: string): this` |
| `text()` | Set text content (escaped) | `text(string $text): static` | `text(text: string): this` |
| `html()` | Set innerHTML (raw HTML) - **replaces** content | `html(string $html): static` | `html(html: string): this` |
| `href()` | Set href attribute (for links) | `href(string $href): static` | `href(href: string): this` |
| `target()` | Set target attribute | `target(string $target): static` | `target(target: string): this` |
| `newTab()` | Open link in new tab (_blank) | `newTab(): static` | `newTab(): this` |
| `selfClosing()` | Mark as self-closing tag | `selfClosing(bool $value = true): static` | `selfClosing(value = true): this` |

> **Important:** The `html()` method on Html elements **replaces** innerHTML. To add multiple HTML children, use `appendHtml()` or `prependHtml()` from the parent ContainerElement.

---

## Usage Examples

### Example 1: Creating a Simple Div

**PHP:**
```php
$div = UiEngine::div('Hello World')
    ->addClass('container')
    ->id('main-content');

echo $div->render();
// Output: <div id="main-content" class="container">Hello World</div>
```

**JavaScript:**
```javascript
const div = UiEngine.div('Hello World')
    .addClass('container')
    .id('main-content');

document.body.appendChild(div.render());
// Creates: <div id="main-content" class="container">Hello World</div>
```

---

### Example 2: Creating a Link

**PHP:**
```php
$link = UiEngine::a('/docs', 'Documentation')
    ->addClass('nav-link')
    ->newTab();

echo $link->render();
// Output: <a href="/docs" class="nav-link" target="_blank">Documentation</a>
```

**JavaScript:**
```javascript
const link = UiEngine.a('/docs', 'Documentation')
    .addClass('nav-link')
    .newTab();

document.body.appendChild(link.render());
// Creates: <a href="/docs" class="nav-link" target="_blank">Documentation</a>
```

---

### Example 3: Adding Multiple HTML Children

**PHP:**
```php
$buttonGroup = UiEngine::div()
    ->addClass('button-group');

// Use appendHtml() for multiple children
$buttonGroup->appendHtml(
    UiEngine::button()->text('Save')->primary()->render()
);
$buttonGroup->appendHtml(
    UiEngine::button()->text('Cancel')->secondary()->render()
);

echo $buttonGroup->render();
```

**JavaScript:**
```javascript
const buttonGroup = UiEngine.div()
    .addClass('button-group');

// Use appendHtml() for multiple children
buttonGroup.appendHtml(
    UiEngine.button().text('Save').primary().render()
);
buttonGroup.appendHtml(
    UiEngine.button().text('Cancel').secondary().render()
);

document.body.appendChild(buttonGroup.render());
```

---

## Key Behaviors

### Html vs ContainerElement Methods

The Html class extends ContainerElement, which means it inherits two sets of methods:

- **ContainerElement::html()** - Adds HTML as a child element (creates an Html wrapper)
- **Html::html()** - Sets innerHTML property (replaces content)

When you call `html()` on an Html element instance, it uses the Html class's version which replaces content:

**PHP Behavior:**
```php
$div = UiEngine::div();

// This REPLACES content (Html::html())
$div->html('<p>First</p>');
$div->html('<p>Second</p>'); // Replaces first

// Use appendHtml() to ADD content
$div->appendHtml('<p>First</p>');
$div->appendHtml('<p>Second</p>'); // Adds second
```

**JavaScript Behavior:**
```javascript
const div = UiEngine.div();

// This REPLACES content (Html.html())
div.html('<p>First</p>');
div.html('<p>Second</p>'); // Replaces first

// Use appendHtml() to ADD content
div.appendHtml('<p>First</p>');
div.appendHtml('<p>Second</p>'); // Adds second
```

---

## Related Documentation

- [Image Element](/docs/uiengine/image) - Image-specific element extending Html
- [UiEngine Guide](/docs/dev-ui-engine) - Complete UiEngine overview
- [Element Reference](/docs/dev-ui-engine-elements) - All 49 UiEngine elements
