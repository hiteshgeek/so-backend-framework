# Image Element

**Specialized image element extending Html with responsive image features, lazy loading, and error handling.**

---

## Overview

The `Image` class extends the `Html` element to provide specialized functionality for images. It supports:

- Image source (`src`) and alternative text (`alt`)
- Responsive images with `srcset` and `sizes`
- Lazy loading for performance optimization
- Error handling with fallback images
- Width and height attributes for layout stability
- All HTML element features (classes, attributes, etc.)

> **Note:** The Image class extends `Html`, which extends `ContainerElement`. However, images are typically self-closing and don't contain children.

---

## Dual Architecture: PHP & JavaScript

The Image element has **identical APIs** in both PHP and JavaScript, ensuring consistent behavior across server and client rendering.

### PHP Implementation

**Location:** `core/UiEngine/Elements/Image.php`
**Extends:** `Html`
**Factory:** `UiEngine::img()`, `UiEngine::image()`

### JavaScript Implementation

**Location:** `frontend/src/js/ui-engine/elements/Image.js`
**Extends:** `Html`
**Factory:** `UiEngine.img()`, `UiEngine.image()`

---

## Factory Methods

### PHP

```php
UiEngine::img(?string $src = null, ?string $alt = null): Image
UiEngine::image(?string $src = null, ?string $alt = null): Image
```

Both methods are aliases and create the same Image instance.

### JavaScript

```javascript
UiEngine.img(src = null, alt = null): Image
UiEngine.image(src = null, alt = null): Image
```

Both methods are aliases and create the same Image instance.

---

## API Methods

### Core Image Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `src()` | Set image source URL | `src(string $src): static` | `src(src: string): this` |
| `alt()` | Set alternative text | `alt(string $alt): static` | `alt(alt: string): this` |
| `width()` | Set image width | `width(int\|string $width): static` | `width(width: number\|string): this` |
| `height()` | Set image height | `height(int\|string $height): static` | `height(height: number\|string): this` |
| `lazy()` | Enable lazy loading | `lazy(bool $value = true): static` | `lazy(value = true): this` |
| `srcset()` | Set responsive image sources | `srcset(string $srcset): static` | `srcset(srcset: string): this` |
| `sizes()` | Set responsive image sizes | `sizes(string $sizes): static` | `sizes(sizes: string): this` |
| `fallback()` | Set fallback image on error | `fallback(string $src): static` | `fallback(src: string): this` |

### Inherited Methods

Since Image extends Html, you also get:

- All Element base methods (`addClass()`, `id()`, `data()`, `attr()`, etc.)
- Html methods (`tag()`, `selfClosing()`, etc.)

---

## Usage Examples

### Example 1: Basic Image

**PHP:**
```php
$image = UiEngine::img('/assets/logo.png', 'Company Logo')
    ->width(200)
    ->height(100)
    ->addClass('brand-logo');

echo $image->render();
// Output: <img src="/assets/logo.png" alt="Company Logo" width="200" height="100" class="brand-logo">
```

**JavaScript:**
```javascript
const image = UiEngine.img('/assets/logo.png', 'Company Logo')
    .width(200)
    .height(100)
    .addClass('brand-logo');

document.body.appendChild(image.render());
// Creates: <img src="/assets/logo.png" alt="Company Logo" width="200" height="100" class="brand-logo">
```

---

### Example 2: Lazy Loading Image

**PHP:**
```php
$image = UiEngine::img('/images/hero-banner.jpg', 'Hero Banner')
    ->lazy()
    ->width(1200)
    ->height(600)
    ->addClass('hero-image');

echo $image->render();
// Output: <img src="/images/hero-banner.jpg" alt="Hero Banner" width="1200" height="600" loading="lazy" class="hero-image">
```

**JavaScript:**
```javascript
const image = UiEngine.img('/images/hero-banner.jpg', 'Hero Banner')
    .lazy()
    .width(1200)
    .height(600)
    .addClass('hero-image');

document.body.appendChild(image.render());
// Creates: <img src="/images/hero-banner.jpg" alt="Hero Banner" width="1200" height="600" loading="lazy" class="hero-image">
```

---

### Example 3: Responsive Image with Srcset

**PHP:**
```php
$image = UiEngine::img('/images/product.jpg', 'Product Image')
    ->srcset('/images/product-480w.jpg 480w, /images/product-800w.jpg 800w, /images/product-1200w.jpg 1200w')
    ->sizes('(max-width: 600px) 480px, (max-width: 900px) 800px, 1200px')
    ->lazy()
    ->addClass('product-image');

echo $image->render();
```

**JavaScript:**
```javascript
const image = UiEngine.img('/images/product.jpg', 'Product Image')
    .srcset('/images/product-480w.jpg 480w, /images/product-800w.jpg 800w, /images/product-1200w.jpg 1200w')
    .sizes('(max-width: 600px) 480px, (max-width: 900px) 800px, 1200px')
    .lazy()
    .addClass('product-image');

document.body.appendChild(image.render());
```

---

### Example 4: Image with Fallback

**PHP:**
```php
$avatar = UiEngine::img('/avatars/user-123.jpg', 'User Avatar')
    ->fallback('/images/default-avatar.png')
    ->width(80)
    ->height(80)
    ->addClass('avatar');

echo $avatar->render();
// If user-123.jpg fails to load, it will show default-avatar.png
```

**JavaScript:**
```javascript
const avatar = UiEngine.img('/avatars/user-123.jpg', 'User Avatar')
    .fallback('/images/default-avatar.png')
    .width(80)
    .height(80)
    .addClass('avatar');

document.body.appendChild(avatar.render());
// If user-123.jpg fails to load, it will show default-avatar.png
```

---

## Key Features

### Lazy Loading

The `lazy()` method adds `loading="lazy"` attribute, which:

- Defers loading images until they're near the viewport
- Improves initial page load performance
- Reduces bandwidth for images below the fold
- Supported natively by modern browsers

### Responsive Images

Use `srcset()` and `sizes()` for responsive images:

- **srcset**: Provides multiple image sources at different resolutions
- **sizes**: Tells the browser which image size to use based on viewport width
- Browser automatically selects the best image for the device

### Fallback Images

The `fallback()` method (JavaScript only) adds an error handler that:

- Automatically replaces failed images with a fallback source
- Prevents broken image icons from showing
- Improves user experience with graceful degradation

---

## Best Practices

### 1. Always provide alt text for accessibility

```php
UiEngine::img('/logo.png', 'Company Name')
```

### 2. Specify width and height to prevent layout shift

```php
UiEngine::img('/banner.jpg', 'Banner')->width(1200)->height(400)
```

### 3. Use lazy loading for images below the fold

```php
UiEngine::img('/large-image.jpg', 'Description')->lazy()
```

### 4. Provide responsive images for better performance

```php
UiEngine::img('/image.jpg', 'Description')
    ->srcset('/image-small.jpg 480w, /image-large.jpg 1200w')
    ->sizes('(max-width: 600px) 480px, 1200px')
```

### 5. Add fallback images for critical visuals (JS)

```javascript
UiEngine.img('/avatar.jpg', 'User').fallback('/default-avatar.png')
```

---

## Related Documentation

- [Html Element](/docs/uiengine/html) - Base Html element that Image extends
- [UiEngine Guide](/docs/dev-ui-engine) - Complete UiEngine overview
- [Element Reference](/docs/dev-ui-engine-elements) - All 49 UiEngine elements
