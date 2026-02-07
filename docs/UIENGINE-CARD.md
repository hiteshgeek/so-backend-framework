# Card Element

**A flexible card container with header, body, footer sections, action buttons, and drag-drop support.**

---

## Overview

The `Card` class provides a versatile container component for organizing content. It supports:

- Header, body, and footer sections (each accepts Element, string, or array)
- Border variants (primary, success, danger, warning, info, secondary)
- Full card color themes (primary, success, danger, warning, info, light, dark)
- Borderless header/footer sections
- Action buttons (collapse, refresh, maximize, close)
- Drag-drop reordering
- Full CSS class and attribute support from ContainerElement base class

> **Note:** The Card class extends `ContainerElement`, so it can contain child elements and supports all container methods.

---

## Dual Architecture: PHP & JavaScript

The Card element has **identical APIs** in both PHP and JavaScript, enabling true full-stack development with a single mental model.

### PHP Implementation

**Location:** `core/UiEngine/Elements/Display/Card.php`
**Extends:** `ContainerElement`
**Uses:** `HasDragDrop` trait

### JavaScript Implementation

**Location:** `frontend/src/js/ui-engine/elements/display/Card.js`
**Extends:** `ContainerElement`
**Uses:** `HasDragDrop` mixin

---

## Creation Methods

The Card element supports **8 creation patterns** - using either the UiEngine factory or direct class instantiation, in both fluent and config styles.

---

### UiEngine Factory Methods (Recommended)

#### 1. PHP UiEngine Fluent

```php
use Core\UiEngine\UiEngine;

$card = UiEngine::card()
    ->header('Card Title')
    ->body('This is the card content.')
    ->footer('Card footer')
    ->primary()
    ->collapsible()
    ->maximizable();

echo $card->render();
```

#### 2. PHP UiEngine Config

```php
use Core\UiEngine\UiEngine;

$card = UiEngine::fromConfig([
    'type' => 'card',
    'header' => 'Card Title',
    'body' => 'This is the card content.',
    'footer' => 'Card footer',
    'variant' => 'primary',
    'collapsible' => true,
    'maximizable' => true,
]);

echo $card->render();
```

#### 3. JavaScript UiEngine Fluent

```javascript
const card = UiEngine.card()
    .header('Card Title')
    .body('This is the card content.')
    .footer('Card footer')
    .primary()
    .collapsible()
    .maximizable();

document.body.appendChild(card.render());
```

#### 4. JavaScript UiEngine Config

```javascript
const card = UiEngine.fromConfig({
    type: 'card',
    header: 'Card Title',
    body: 'This is the card content.',
    footer: 'Card footer',
    variant: 'primary',
    collapsible: true,
    maximizable: true
});

document.body.appendChild(card.render());
```

---

### Direct Class Instantiation

#### 5. PHP Card::make() Fluent

```php
use Core\UiEngine\Elements\Display\Card;

$card = Card::make()
    ->header('Card Title')
    ->body('This is the card content.')
    ->footer('Card footer')
    ->primary()
    ->collapsible()
    ->maximizable();

echo $card->render();
```

#### 6. PHP Card::make() Config

```php
use Core\UiEngine\Elements\Display\Card;

$card = Card::make([
    'header' => 'Card Title',
    'body' => 'This is the card content.',
    'footer' => 'Card footer',
    'variant' => 'primary',
    'collapsible' => true,
    'maximizable' => true,
]);

echo $card->render();
```

#### 7. JavaScript new Card() Fluent

```javascript
import { Card } from './ui-engine/elements/display/Card.js';

const card = new Card({})
    .header('Card Title')
    .body('This is the card content.')
    .footer('Card footer')
    .primary()
    .collapsible()
    .maximizable();

document.body.appendChild(card.render());
```

#### 8. JavaScript new Card() Config

```javascript
import { Card } from './ui-engine/elements/display/Card.js';

const card = new Card({
    header: 'Card Title',
    body: 'This is the card content.',
    footer: 'Card footer',
    variant: 'primary',
    collapsible: true,
    maximizable: true
});

document.body.appendChild(card.render());
```

---

## Config Options Reference

When using config array/object syntax, these options are available:

| Option | Type | Description |
|--------|------|-------------|
| `header` | `string\|Element\|array` | Header content |
| `body` | `string\|Element\|array` | Body content |
| `footer` | `string\|Element\|array` | Footer content |
| `variant` | `string` | Border variant: primary, secondary, success, danger, warning, info |
| `color` | `string` | Full card color: primary, secondary, success, danger, warning, info, light, dark |
| `headerBorderless` | `bool` | Remove header bottom border |
| `footerBorderless` | `bool` | Remove footer top border |
| `borderlessSections` | `bool` | Remove both header and footer borders |
| `collapsible` | `bool` | Enable collapse action button |
| `refreshable` | `bool\|string` | Enable refresh action (string = handler name in PHP) |
| `maximizable` | `bool` | Enable fullscreen action button |
| `closeable` | `bool\|string` | Enable close action (string = confirm message) |
| `draggable` | `bool` | Enable drag-drop |
| `dragHandle` | `string` | CSS selector for drag handle |
| `dragGroup` | `string` | Drag group name for grouping |
| `liveReorder` | `bool` | Enable live reordering during drag |

---

## API Methods

### Content Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `header()` | Set card header content | `header(Element\|string\|array $content): static` | `header(content): this` |
| `body()` | Set card body content | `body(Element\|string\|array $content): static` | `body(content): this` |
| `footer()` | Set card footer content | `footer(Element\|string\|array $content): static` | `footer(content): this` |

### Border Variant Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `variant()` | Set border variant | `variant(string $variant): static` | `variant(variant): this` |
| `primary()` | Primary border | `primary(): static` | `primary(): this` |
| `secondary()` | Secondary border | `secondary(): static` | `secondary(): this` |
| `success()` | Success border | `success(): static` | `success(): this` |
| `danger()` | Danger border | `danger(): static` | `danger(): this` |
| `warning()` | Warning border | `warning(): static` | `warning(): this` |
| `info()` | Info border | `info(): static` | `info(): this` |

### Full Card Color Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `color()` | Set full card color | `color(string $color): static` | `color(color): this` |
| `colorPrimary()` | Primary background | `colorPrimary(): static` | `colorPrimary(): this` |
| `colorSecondary()` | Secondary background | `colorSecondary(): static` | `colorSecondary(): this` |
| `colorSuccess()` | Success background | `colorSuccess(): static` | `colorSuccess(): this` |
| `colorDanger()` | Danger background | `colorDanger(): static` | `colorDanger(): this` |
| `colorWarning()` | Warning background | `colorWarning(): static` | `colorWarning(): this` |
| `colorInfo()` | Info background | `colorInfo(): static` | `colorInfo(): this` |
| `colorLight()` | Light background | `colorLight(): static` | `colorLight(): this` |
| `colorDark()` | Dark background | `colorDark(): static` | `colorDark(): this` |

### Borderless Section Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `headerBorderless()` | Remove header bottom border | `headerBorderless(): static` | `headerBorderless(): this` |
| `footerBorderless()` | Remove footer top border | `footerBorderless(): static` | `footerBorderless(): this` |
| `borderlessSections()` | Remove both header and footer borders | `borderlessSections(): static` | `borderlessSections(): this` |

### Action Methods (Configuration)

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `collapsible()` | Enable collapse action | `collapsible(): static` | `collapsible(): this` |
| `refreshable()` | Enable refresh action | `refreshable(?string $handler = null): static` | `refreshable(handler): this` |
| `maximizable()` | Enable fullscreen action | `maximizable(): static` | `maximizable(): this` |
| `closeable()` | Enable close action | `closeable(bool $confirm = false, ?string $message = null): static` | `closeable(confirmMessage): this` |

### Action Methods (Runtime - JavaScript Only)

| Method | Description | JS Signature |
|--------|-------------|--------------|
| `collapse()` | Collapse the card | `collapse(): this` |
| `expand()` | Expand the card | `expand(): this` |
| `toggleCollapse()` | Toggle collapse state | `toggleCollapse(): this` |
| `refresh()` | Trigger refresh | `refresh(handler?): Promise<this>` |
| `fullscreen()` | Enter fullscreen | `fullscreen(): this` |
| `exitFullscreen()` | Exit fullscreen | `exitFullscreen(): this` |
| `toggleFullscreen()` | Toggle fullscreen | `toggleFullscreen(): this` |
| `close()` | Close/remove card | `close(confirmMessage?): this` |

### Drag-Drop Methods

| Method | Description | PHP Signature | JS Signature |
|--------|-------------|---------------|--------------|
| `draggable()` | Enable drag-drop | `draggable(bool $value = true): static` | `draggable(value = true): this` |
| `dragHandle()` | Set drag handle selector | `dragHandle(string $selector): static` | `dragHandle(selector): this` |
| `dragGroup()` | Set drag group name | `dragGroup(string $group): static` | `dragGroup(group): this` |
| `liveReorder()` | Enable live reordering | `liveReorder(bool $value = true): static` | `liveReorder(value = true): this` |

---

## Variation Examples

### Basic Card

**PHP UiEngine Fluent:**
```php
$card = UiEngine::card()
    ->header('Card Title')
    ->body('This is the card content.')
    ->footer('Card footer');
```

**PHP UiEngine Config:**
```php
$card = UiEngine::fromConfig([
    'type' => 'card',
    'header' => 'Card Title',
    'body' => 'This is the card content.',
    'footer' => 'Card footer',
]);
```

**PHP Card::make() Fluent:**
```php
$card = Card::make()
    ->header('Card Title')
    ->body('This is the card content.')
    ->footer('Card footer');
```

**PHP Card::make() Config:**
```php
$card = Card::make([
    'header' => 'Card Title',
    'body' => 'This is the card content.',
    'footer' => 'Card footer',
]);
```

**JS UiEngine Fluent:**
```javascript
const card = UiEngine.card()
    .header('Card Title')
    .body('This is the card content.')
    .footer('Card footer');
```

**JS UiEngine Config:**
```javascript
const card = UiEngine.fromConfig({
    type: 'card',
    header: 'Card Title',
    body: 'This is the card content.',
    footer: 'Card footer'
});
```

**JS new Card() Fluent:**
```javascript
const card = new Card({})
    .header('Card Title')
    .body('This is the card content.')
    .footer('Card footer');
```

**JS new Card() Config:**
```javascript
const card = new Card({
    header: 'Card Title',
    body: 'This is the card content.',
    footer: 'Card footer'
});
```

**Output:**
```html
<div class="so-card">
    <div class="so-card-header">Card Title</div>
    <div class="so-card-body">This is the card content.</div>
    <div class="so-card-footer">Card footer</div>
</div>
```

---

### All Border Variants

**PHP UiEngine Fluent:**
```php
UiEngine::card()->header('Primary')->body('Content')->primary();
UiEngine::card()->header('Secondary')->body('Content')->secondary();
UiEngine::card()->header('Success')->body('Content')->success();
UiEngine::card()->header('Danger')->body('Content')->danger();
UiEngine::card()->header('Warning')->body('Content')->warning();
UiEngine::card()->header('Info')->body('Content')->info();
```

**PHP UiEngine Config:**
```php
UiEngine::fromConfig(['type' => 'card', 'header' => 'Primary', 'body' => 'Content', 'variant' => 'primary']);
UiEngine::fromConfig(['type' => 'card', 'header' => 'Success', 'body' => 'Content', 'variant' => 'success']);
UiEngine::fromConfig(['type' => 'card', 'header' => 'Danger', 'body' => 'Content', 'variant' => 'danger']);
```

**PHP Card::make() Fluent:**
```php
Card::make()->header('Primary')->body('Content')->primary();
Card::make()->header('Secondary')->body('Content')->secondary();
Card::make()->header('Success')->body('Content')->success();
Card::make()->header('Danger')->body('Content')->danger();
Card::make()->header('Warning')->body('Content')->warning();
Card::make()->header('Info')->body('Content')->info();
```

**PHP Card::make() Config:**
```php
Card::make(['header' => 'Primary', 'body' => 'Content', 'variant' => 'primary']);
Card::make(['header' => 'Secondary', 'body' => 'Content', 'variant' => 'secondary']);
Card::make(['header' => 'Success', 'body' => 'Content', 'variant' => 'success']);
```

**JS UiEngine Fluent:**
```javascript
UiEngine.card().header('Primary').body('Content').primary();
UiEngine.card().header('Secondary').body('Content').secondary();
UiEngine.card().header('Success').body('Content').success();
UiEngine.card().header('Danger').body('Content').danger();
UiEngine.card().header('Warning').body('Content').warning();
UiEngine.card().header('Info').body('Content').info();
```

**JS UiEngine Config:**
```javascript
UiEngine.fromConfig({ type: 'card', header: 'Primary', body: 'Content', variant: 'primary' });
UiEngine.fromConfig({ type: 'card', header: 'Success', body: 'Content', variant: 'success' });
```

**JS new Card() Fluent:**
```javascript
new Card({}).header('Primary').body('Content').primary();
new Card({}).header('Secondary').body('Content').secondary();
new Card({}).header('Success').body('Content').success();
```

**JS new Card() Config:**
```javascript
new Card({ header: 'Primary', body: 'Content', variant: 'primary' });
new Card({ header: 'Secondary', body: 'Content', variant: 'secondary' });
```

---

### All Full Card Colors

**PHP UiEngine Fluent:**
```php
UiEngine::card()->header('Primary')->body('Content')->colorPrimary();
UiEngine::card()->header('Secondary')->body('Content')->colorSecondary();
UiEngine::card()->header('Success')->body('Content')->colorSuccess();
UiEngine::card()->header('Danger')->body('Content')->colorDanger();
UiEngine::card()->header('Warning')->body('Content')->colorWarning();
UiEngine::card()->header('Info')->body('Content')->colorInfo();
UiEngine::card()->header('Light')->body('Content')->colorLight();
UiEngine::card()->header('Dark')->body('Content')->colorDark();
```

**PHP UiEngine Config:**
```php
UiEngine::fromConfig(['type' => 'card', 'header' => 'Primary', 'body' => 'Content', 'color' => 'primary']);
UiEngine::fromConfig(['type' => 'card', 'header' => 'Info', 'body' => 'Content', 'color' => 'info']);
UiEngine::fromConfig(['type' => 'card', 'header' => 'Dark', 'body' => 'Content', 'color' => 'dark']);
```

**PHP Card::make():**
```php
Card::make()->header('Primary')->body('Content')->colorPrimary();
Card::make(['header' => 'Primary', 'body' => 'Content', 'color' => 'primary']);
```

**JS UiEngine Fluent:**
```javascript
UiEngine.card().header('Primary').body('Content').colorPrimary();
UiEngine.card().header('Secondary').body('Content').colorSecondary();
UiEngine.card().header('Success').body('Content').colorSuccess();
UiEngine.card().header('Danger').body('Content').colorDanger();
UiEngine.card().header('Warning').body('Content').colorWarning();
UiEngine.card().header('Info').body('Content').colorInfo();
UiEngine.card().header('Light').body('Content').colorLight();
UiEngine.card().header('Dark').body('Content').colorDark();
```

**JS UiEngine Config:**
```javascript
UiEngine.fromConfig({ type: 'card', header: 'Primary', body: 'Content', color: 'primary' });
UiEngine.fromConfig({ type: 'card', header: 'Info', body: 'Content', color: 'info' });
```

**JS new Card():**
```javascript
new Card({}).header('Primary').body('Content').colorPrimary();
new Card({ header: 'Primary', body: 'Content', color: 'primary' });
```

---

### Borderless Sections

**PHP Fluent:**
```php
// Header borderless only
Card::make()
    ->header('Clean Header')
    ->body('Content')
    ->headerBorderless();

// Footer borderless only
Card::make()
    ->body('Content')
    ->footer('Clean Footer')
    ->footerBorderless();

// Both sections borderless
Card::make()
    ->header('Clean Header')
    ->body('Content')
    ->footer('Clean Footer')
    ->borderlessSections();
```

**PHP Config:**
```php
Card::make([
    'header' => 'Clean Header',
    'body' => 'Content',
    'headerBorderless' => true,
]);

Card::make([
    'body' => 'Content',
    'footer' => 'Clean Footer',
    'footerBorderless' => true,
]);

Card::make([
    'header' => 'Clean Header',
    'body' => 'Content',
    'footer' => 'Clean Footer',
    'borderlessSections' => true,
]);
```

**JS Fluent:**
```javascript
new Card({}).header('Clean Header').body('Content').headerBorderless();
new Card({}).body('Content').footer('Clean Footer').footerBorderless();
new Card({}).header('Clean Header').body('Content').footer('Clean Footer').borderlessSections();
```

**JS Config:**
```javascript
new Card({ header: 'Clean Header', body: 'Content', headerBorderless: true });
new Card({ body: 'Content', footer: 'Clean Footer', footerBorderless: true });
new Card({ header: 'Clean', body: 'Content', footer: 'Footer', borderlessSections: true });
```

---

### Card with All Actions

**PHP UiEngine Fluent:**
```php
$card = UiEngine::card()
    ->header('Interactive Card')
    ->body('This card has all action buttons.')
    ->collapsible()
    ->refreshable('handleRefresh')
    ->maximizable()
    ->closeable(true, 'Are you sure you want to close this card?');
```

**PHP UiEngine Config:**
```php
$card = UiEngine::fromConfig([
    'type' => 'card',
    'header' => 'Interactive Card',
    'body' => 'This card has all action buttons.',
    'collapsible' => true,
    'refreshable' => 'handleRefresh',
    'maximizable' => true,
    'closeable' => 'Are you sure you want to close this card?',
]);
```

**PHP Card::make():**
```php
$card = Card::make()
    ->header('Interactive Card')
    ->body('This card has all action buttons.')
    ->collapsible()
    ->refreshable('handleRefresh')
    ->maximizable()
    ->closeable(true, 'Are you sure you want to close this card?');
```

**JS UiEngine Fluent:**
```javascript
const card = UiEngine.card()
    .header('Interactive Card')
    .body('This card has all action buttons.')
    .collapsible()
    .refreshable(async (card) => {
        const response = await fetch('/api/data');
        const data = await response.json();
        card.body(data.content);
    })
    .maximizable()
    .closeable('Are you sure you want to close this card?');
```

**JS UiEngine Config:**
```javascript
const card = UiEngine.fromConfig({
    type: 'card',
    header: 'Interactive Card',
    body: 'This card has all action buttons.',
    collapsible: true,
    refreshable: async (card) => {
        const response = await fetch('/api/data');
        const data = await response.json();
        card.body(data.content);
    },
    maximizable: true,
    closeable: 'Are you sure you want to close this card?'
});
```

**JS new Card():**
```javascript
const card = new Card({})
    .header('Interactive Card')
    .body('This card has all action buttons.')
    .collapsible()
    .refreshable(async (card) => { /* ... */ })
    .maximizable()
    .closeable('Are you sure?');
```

---

### Draggable Cards

**PHP Fluent:**
```php
// Simple draggable
$card = Card::make()
    ->header('Drag Me')
    ->body('This card can be dragged.')
    ->draggable();

// Drag by header only
$card = Card::make()
    ->header('Drag by Header')
    ->body('You can only drag this card by its header.')
    ->draggable()
    ->dragHandle('.so-card-header');

// With drag group
$card = Card::make()
    ->header('Group A')
    ->body('Can only be dropped in Group A containers.')
    ->draggable()
    ->dragGroup('group-a');

// With live reordering
$card = Card::make()
    ->header('Live Reorder')
    ->body('Cards reorder as you drag.')
    ->draggable()
    ->liveReorder();
```

**PHP Config:**
```php
Card::make([
    'header' => 'Drag Me',
    'body' => 'This card can be dragged.',
    'draggable' => true,
]);

Card::make([
    'header' => 'Drag by Header',
    'body' => 'You can only drag this card by its header.',
    'draggable' => true,
    'dragHandle' => '.so-card-header',
]);

Card::make([
    'header' => 'Group A',
    'body' => 'Can only be dropped in Group A containers.',
    'draggable' => true,
    'dragGroup' => 'group-a',
]);

Card::make([
    'header' => 'Live Reorder',
    'body' => 'Cards reorder as you drag.',
    'draggable' => true,
    'liveReorder' => true,
]);
```

**JS Fluent:**
```javascript
new Card({}).header('Drag Me').body('This card can be dragged.').draggable();

new Card({})
    .header('Drag by Header')
    .body('You can only drag this card by its header.')
    .draggable()
    .dragHandle('.so-card-header');

new Card({})
    .header('Group A')
    .body('Can only be dropped in Group A containers.')
    .draggable()
    .dragGroup('group-a');

new Card({})
    .header('Live Reorder')
    .body('Cards reorder as you drag.')
    .draggable()
    .liveReorder();
```

**JS Config:**
```javascript
new Card({ header: 'Drag Me', body: 'Draggable.', draggable: true });

new Card({
    header: 'Drag by Header',
    body: 'Drag by header only.',
    draggable: true,
    dragHandle: '.so-card-header',
});

new Card({
    header: 'Group A',
    body: 'Group A container only.',
    draggable: true,
    dragGroup: 'group-a',
});

new Card({
    header: 'Live Reorder',
    body: 'Cards reorder as you drag.',
    draggable: true,
    liveReorder: true,
});
```

---

### Nested Elements in Body

**PHP Fluent:**
```php
use Core\UiEngine\Elements\Form\Button;

$card = Card::make()
    ->header('Card with Buttons')
    ->body([
        'Some content here.',
        Button::make()->text('Save')->primary(),
        Button::make()->text('Cancel')->secondary(),
    ]);
```

**PHP Config:**
```php
$card = Card::make([
    'header' => 'Card with Buttons',
    'body' => [
        'Some content here.',
        ['type' => 'button', 'text' => 'Save', 'variant' => 'primary'],
        ['type' => 'button', 'text' => 'Cancel', 'variant' => 'secondary'],
    ],
]);
```

**JS Fluent:**
```javascript
import { Button } from './ui-engine/elements/form/Button.js';

const card = new Card({})
    .header('Card with Buttons')
    .body([
        'Some content here.',
        new Button({}).text('Save').primary(),
        new Button({}).text('Cancel').secondary(),
    ]);
```

**JS Config:**
```javascript
const card = new Card({
    header: 'Card with Buttons',
    body: [
        'Some content here.',
        new Button({ text: 'Save', variant: 'primary' }),
        new Button({ text: 'Cancel', variant: 'secondary' }),
    ],
});
```

---

### Complete Example with All Features

**PHP Fluent:**
```php
$card = Card::make()
    ->header('Dashboard Widget')
    ->body('Real-time statistics and metrics.')
    ->footer('Last updated: Just now')
    ->colorInfo()
    ->headerBorderless()
    ->collapsible()
    ->refreshable('refreshDashboard')
    ->maximizable()
    ->closeable(true, 'Remove this widget?')
    ->draggable()
    ->dragHandle('.so-card-header')
    ->addClass('dashboard-widget')
    ->id('widget-stats');

echo $card->render();
```

**PHP Config:**
```php
$card = Card::make([
    'header' => 'Dashboard Widget',
    'body' => 'Real-time statistics and metrics.',
    'footer' => 'Last updated: Just now',
    'color' => 'info',
    'headerBorderless' => true,
    'collapsible' => true,
    'refreshable' => 'refreshDashboard',
    'maximizable' => true,
    'closeable' => 'Remove this widget?',
    'draggable' => true,
    'dragHandle' => '.so-card-header',
    'class' => 'dashboard-widget',
    'id' => 'widget-stats',
]);

echo $card->render();
```

**JS Fluent:**
```javascript
const card = new Card({})
    .header('Dashboard Widget')
    .body('Real-time statistics and metrics.')
    .footer('Last updated: Just now')
    .colorInfo()
    .headerBorderless()
    .collapsible()
    .refreshable(async (card) => {
        const data = await fetch('/api/stats').then(r => r.json());
        card.body(data.content);
        card.footer('Last updated: ' + new Date().toLocaleTimeString());
    })
    .maximizable()
    .closeable('Remove this widget?')
    .draggable()
    .dragHandle('.so-card-header')
    .addClass('dashboard-widget')
    .id('widget-stats');

document.querySelector('.dashboard').appendChild(card.render());
```

**JS Config:**
```javascript
const card = new Card({
    header: 'Dashboard Widget',
    body: 'Real-time statistics and metrics.',
    footer: 'Last updated: Just now',
    color: 'info',
    headerBorderless: true,
    collapsible: true,
    refreshable: async (card) => {
        const data = await fetch('/api/stats').then(r => r.json());
        card.body(data.content);
        card.footer('Last updated: ' + new Date().toLocaleTimeString());
    },
    maximizable: true,
    closeable: 'Remove this widget?',
    draggable: true,
    dragHandle: '.so-card-header',
    class: 'dashboard-widget',
    id: 'widget-stats',
});

document.querySelector('.dashboard').appendChild(card.render());
```

---

## Programmatic Control (JavaScript)

After creating a card, you can control it programmatically:

```javascript
const card = new Card({})
    .header('Controllable Card')
    .body('Content')
    .collapsible()
    .maximizable();

document.body.appendChild(card.render());

// Collapse/Expand
card.collapse();
card.expand();
card.toggleCollapse();

// Fullscreen
card.fullscreen();
card.exitFullscreen();
card.toggleFullscreen();

// Refresh (with optional handler)
await card.refresh();
await card.refresh(async (c) => {
    c.body('New content');
});

// Close
card.close();
card.close('Are you sure?'); // With confirmation
```

---

## Events (JavaScript)

The Card element emits the following events:

| Event | Description | Cancelable |
|-------|-------------|------------|
| `so:card:beforeCollapse` | Before collapse animation | Yes |
| `so:card:collapse` | After collapse | No |
| `so:card:beforeExpand` | Before expand animation | Yes |
| `so:card:expand` | After expand | No |
| `so:card:beforeRefresh` | Before refresh | Yes |
| `so:card:refresh` | After successful refresh | No |
| `so:card:refreshError` | On refresh error | No |
| `so:card:beforeFullscreen` | Before entering fullscreen | Yes |
| `so:card:fullscreen` | After entering fullscreen | No |
| `so:card:exitFullscreen` | After exiting fullscreen | No |
| `so:card:beforeClose` | Before close | Yes |
| `so:card:close` | Close initiated | No |
| `so:card:closed` | After removed from DOM | No |

**Example:**
```javascript
card.on('so:card:collapse', () => {
    console.log('Card collapsed');
});

card.on('so:card:beforeClose', (e) => {
    if (hasUnsavedChanges) {
        e.preventDefault(); // Cancel close
    }
});

card.on('so:card:refresh', () => {
    console.log('Card refreshed successfully');
});
```

---

## CSS Classes

The Card component uses these CSS classes:

| Class | Description |
|-------|-------------|
| `.so-card` | Main card wrapper |
| `.so-card-header` | Header section |
| `.so-card-body` | Body section |
| `.so-card-footer` | Footer section |
| `.so-card-header-actions` | Action buttons container |
| `.so-card-action-btn` | Individual action button |
| `.so-card-border-{variant}` | Border variant (primary, success, etc.) |
| `.so-card-{color}` | Full card color (primary, success, etc.) |
| `.so-card-header-borderless` | Remove header bottom border |
| `.so-card-footer-borderless` | Remove footer top border |
| `.so-card-collapsed` | Collapsed state |
| `.so-card-fullscreen` | Fullscreen state |
| `.so-card-loading` | Loading/refresh state |

---

## Related Documentation

- [Html Element](/docs/uiengine/html) - Generic HTML element
- [Image Element](/docs/uiengine/image) - Image element
- [UiEngine Guide](/docs/dev-ui-engine) - Complete UiEngine overview
- [Element Reference](/docs/dev-ui-engine-elements) - All UiEngine elements
