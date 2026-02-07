# Advanced Card Features - Implementation Roadmap

**Date:** 2026-02-07
**Status:** Partially Implemented (2/15 features completed)
**Last Updated:** 2026-02-07
**Inspired By:** Vuexy Premium Template Analysis

---

## Overview

This document outlines advanced card features that can be implemented to make our card component more powerful and interactive. The goal is to create a reusable plugin system that works anywhere in the application.

### ✅ Completed Features

1. **Card Actions (Interactive Controls)** - Collapse, Refresh, Fullscreen, Close
2. **Draggable & Sortable Cards** - Reusable SODragDrop plugin with persistence

### 📋 Pending Features

13 additional features are planned for future implementation (see below).

---

## Feature Categories

### **1. Card Actions (Interactive Controls)** ✅ COMPLETED

**Status:** ✅ Implemented on 2026-02-07

**Description:** Toolbar actions that control card behavior

**Implemented Features:**
- ✅ **Collapse/Expand** - Toggle card content visibility with smooth animation
- ✅ **Refresh/Reload** - Refresh card content with loading indicator
- ✅ **Fullscreen/Maximize** - Expand card to fullscreen mode with ESC key to exit
- ✅ **Close/Remove** - Remove card from DOM with optional confirmation
- ⏸️ **Minimize** - Not implemented (similar to collapse)

**Implementation Details:**
- **PHP API:** `collapsible()`, `refreshable()`, `maximizable()`, `closeable(confirm, message)`
- **JavaScript API:** `collapse()`, `expand()`, `toggleCollapse()`, `refresh(handler)`, `fullscreen()`, `exitFullscreen()`, `close(confirmMsg)`
- **Events:** `so:card:beforeCollapse`, `so:card:collapse`, `so:card:refresh`, `so:card:fullscreen`, `so:card:close`, etc.
- **CSS Classes:** `.so-card-collapsed`, `.so-card-fullscreen`, `.so-card-loading`
- **Action Buttons:** Rendered in card header with Material Icons
- **Keyboard Support:** ESC key to exit fullscreen

**Demo Location:** `/public/frontend/demos/elements/cards.php` - "Card Actions" section

**Files Modified:**
- `/frontend/src/js/ui-engine/elements/display/Card.js` - Added action methods
- `/core/UiEngine/Elements/Display/Card.php` - Added PHP fluent API
- `/frontend/src/scss/components/_cards.scss` - Added action button styles

---

### **2. Draggable & Sortable Cards** ✅ COMPLETED

**Status:** ✅ Implemented on 2026-02-07

**Description:** Allow users to reorder cards by dragging

**Implemented Features:**
- ✅ **Drag and Drop** - Reorder cards by dragging using HTML5 Drag & Drop API (vanilla JS, no libraries)
- ✅ **Grid Rearrangement** - Works with any grid/flexbox container
- ✅ **Persistence** - Save card positions to localStorage/sessionStorage
- ✅ **Handle-based Dragging** - Only drag when clicking specific handle area (configurable)
- ✅ **Visual Feedback** - Ghost/placeholder, drag-over states, chosen element highlighting
- ✅ **Reusable Plugin** - `SODragDrop` component works with any elements (cards, tabs, lists, tables)

**Implementation Details:**
- **Component:** `SODragDrop` - Standalone reusable drag-drop plugin
- **PHP API:** `draggable(config)` method on Card class
- **JavaScript API:** `draggable(enabled, config)`, `getOrder()`, `setOrder(index)`
- **Events:** `dragdrop:start`, `dragdrop:end`, `dragdrop:move`, `dragdrop:reorder`, `so:card:reorder`
- **Configuration Options:**
  - `items` - Selector for draggable items
  - `handle` - Drag handle selector (e.g., `.so-card-header`)
  - `storage` - 'localStorage' or 'sessionStorage'
  - `storageKey` - Key for storage persistence
  - `ghostClass`, `dragClass`, `chosenClass` - CSS class names
- **CSS Classes:** `.so-dragging`, `.so-ghost`, `.so-chosen`, `.so-drag-over`, `.so-drag-handle`
- **Technology:** HTML5 Drag & Drop API (native, modern, performant, no external libraries)

**Demo Location:** `/public/frontend/demos/elements/cards.php` - "Draggable Cards" and "Combined" sections

**Files Created:**
- `/frontend/src/js/components/so-dragdrop.js` - NEW reusable SODragDrop component

**Files Modified:**
- `/frontend/src/js/ui-engine/elements/display/Card.js` - Added draggable integration
- `/core/UiEngine/Elements/Display/Card.php` - Added draggable() method
- `/frontend/src/scss/components/_cards.scss` - Added drag state styles
- `/frontend/src/js/sixorbit-full.js` - Added SODragDrop to bundle

---

### **3. Loading & Skeleton States**

**Description:** Visual feedback during data loading

- **Loading Overlay** - Semi-transparent overlay with spinner during refresh
- **Skeleton Screen** - Placeholder content while data loads
- **Progress Bar** - Linear/circular progress indicator in header
- **Shimmer Effect** - Animated gradient for loading placeholders

**Use Cases:**
- Initial page load - show skeleton until data arrives
- AJAX refresh - show overlay while fetching new data
- Long operations - show progress bar for multi-step processes
- Perceived performance - shimmer effect feels faster than spinner

**Technical Approach:**
- CSS classes: `.card-loading`, `.card-skeleton`
- JavaScript methods: `card.showLoading()`, `card.hideLoading()`
- Skeleton templates: Define placeholder structure matching content
- Progress API: `card.setProgress(percent)`

---

### **4. Card Toolbar & Header Elements**

**Description:** Rich header controls beyond basic title

- **Action Buttons** - Multiple action buttons in header (refresh, settings, etc.)
- **Dropdown Menu** - Settings/options dropdown in header
- **Badge/Counter** - Notification badges in header
- **Search Box** - Inline search within card header
- **Filter Controls** - Dropdown filters or toggle switches
- **Date Range Picker** - Quick date selection in header

**Use Cases:**
- Data tables with search and filter
- Lists with sorting options
- Charts with date range selection
- Settings panels with multiple actions

**Technical Approach:**
- Header zones: `.card-header-left`, `.card-header-center`, `.card-header-right`
- Fluent API: `card.addHeaderButton(options)`, `card.addHeaderDropdown(options)`
- Component integration: Works with existing Button, Dropdown, Badge components
- Responsive: Stack on mobile, horizontal on desktop

---

### **5. Card State Management**

**Description:** Track and visualize card states

- **Pin/Unpin** - Keep card always visible or at top
- **Favorite/Bookmark** - Mark important cards
- **Read/Unread** - Track viewed state
- **Dirty/Modified** - Indicate unsaved changes
- **Error State** - Show validation or error state
- **Success State** - Highlight successful operations

**Use Cases:**
- Pinned widgets always show at top of dashboard
- Favorite items for quick access
- Form cards show unsaved changes warning
- API response cards show success/error states

**Technical Approach:**
- State classes: `.card-pinned`, `.card-favorite`, `.card-dirty`, `.card-error`, `.card-success`
- State methods: `card.setState('error')`, `card.getState()`
- Visual indicators: Border colors, icons, badges
- Persistence: Save state to localStorage/server

---

### **6. Interactive Content**

**Description:** Rich content inside cards

- **Tabs Integration** - Tab navigation inside card header
- **Accordion** - Multiple collapsible sections within card
- **Carousel/Slider** - Image or content slider in card body
- **Timeline** - Vertical timeline content
- **Chart Integration** - Embed charts with responsive sizing

**Use Cases:**
- Multi-section forms with tabs
- FAQ cards with accordion
- Product galleries with image slider
- Activity feeds with timeline
- Analytics cards with charts

**Technical Approach:**
- Integration with existing components (Tabs, Accordion, etc.)
- Responsive sizing: Charts resize when card resizes
- Event coordination: Card actions affect nested components
- Layout helpers: `.card-tabbed`, `.card-timeline`

---

### **7. Advanced Layouts**

**Description:** Alternative card visual presentations

- **Split Card** - Left/right divided content areas
- **Stacked Cards** - Cards stacked behind each other (3D effect)
- **Flip Card** - Front/back flip animation on hover/click
- **Reveal Card** - Slide overlay content from sides
- **Expandable Detail** - Click to expand inline details

**Use Cases:**
- Product cards: image left, details right
- Pricing cards: stacked layers for emphasis
- Profile cards: flip to show additional info
- Quick actions: reveal menu from side
- List items: expand to show full details

**Technical Approach:**
- Layout classes: `.card-split`, `.card-stack`, `.card-flip`, `.card-reveal`
- CSS Grid/Flexbox for split layouts
- CSS 3D transforms for flip effect
- JavaScript for reveal animations
- Mobile-friendly: Simplify on small screens

---

### **8. Real-time Features**

**Description:** Live updating content

- **Auto-refresh** - Periodic content updates with countdown
- **Live Updates** - Real-time data binding with highlights
- **Notification Dot** - Indicate new/updated content
- **Pulse Animation** - Attention-drawing pulse effect

**Use Cases:**
- Dashboard metrics updating every 30 seconds
- Live chat messages
- Stock price cards with real-time updates
- Notification cards showing unread count

**Technical Approach:**
- Auto-refresh: `card.enableAutoRefresh(interval)`
- WebSocket/SSE integration for real-time data
- Highlight changes: Flash animation on update
- Performance: Only refresh visible cards (Intersection Observer)

---

### **9. User Interactions**

**Description:** Common user actions on card content

- **Click to Copy** - Copy content/code with click
- **Share** - Social media or link sharing buttons
- **Print** - Print-friendly card content
- **Export** - Download as PDF, CSV, or image
- **QR Code** - Generate QR for card content

**Use Cases:**
- Code snippet cards with copy button
- Article cards with social sharing
- Invoice cards with print button
- Data cards with CSV export
- Contact cards with QR code

**Technical Approach:**
- Copy: Clipboard API (`navigator.clipboard.writeText`)
- Share: Web Share API + fallback social links
- Print: Print-specific CSS + `window.print()`
- Export: HTML to PDF libraries (jsPDF), HTML2Canvas
- QR: QRCode.js library

---

### **10. Responsive Behaviors**

**Description:** Mobile-optimized card interactions

- **Mobile Card Drawer** - Slide up from bottom on mobile
- **Swipe Actions** - Swipe left/right for actions (mobile)
- **Compact Mode** - Reduced padding for dense layouts
- **Breakpoint Variants** - Different layouts per screen size

**Use Cases:**
- Mobile: Full card slides up as modal
- Mobile: Swipe to delete/archive
- Dense dashboards: Compact mode fits more cards
- Responsive: Horizontal on desktop, vertical on mobile

**Technical Approach:**
- Media queries for responsive classes
- Touch events: `touchstart`, `touchmove`, `touchend`
- Hammer.js for swipe gestures
- Modal integration for drawer behavior
- Viewport-based layout switching

---

### **11. Visual Enhancements**

**Description:** Eye-catching visual effects

- **Glow Effect** - Animated border glow on focus/hover
- **Parallax Background** - Subtle depth effect
- **Glassmorphism** - Frosted glass effect
- **Gradient Animation** - Animated gradient backgrounds
- **Shadow Transitions** - Elevation changes on hover

**Use Cases:**
- Featured cards with glow effect
- Hero cards with parallax background
- Modern UI with glassmorphism
- Promotional cards with animated gradients
- Interactive cards with shadow elevation

**Technical Approach:**
- CSS animations/transitions
- Backdrop-filter for glassmorphism
- CSS custom properties for gradient animation
- Box-shadow transitions
- GPU-accelerated transforms

---

### **12. Content Features**

**Description:** Smart content handling

- **Read More/Less** - Truncate long content with expand
- **Lazy Loading** - Load images/content when visible
- **Infinite Scroll** - Load more items in card
- **Virtual Scrolling** - Optimize long lists inside cards
- **Empty State** - Placeholder for no-content scenarios

**Use Cases:**
- Blog cards: Truncate description with "Read more"
- Image galleries: Lazy load off-screen images
- Activity feeds: Load more as user scrolls
- Large lists: Virtual scrolling for performance
- No data: Show helpful empty state

**Technical Approach:**
- Truncation: CSS line-clamp + JavaScript toggle
- Lazy loading: Intersection Observer API
- Infinite scroll: Detect scroll position, trigger load
- Virtual scrolling: Only render visible items (RecyclerListView pattern)
- Empty states: Template system with customizable messages

---

### **13. Accessibility Features**

**Description:** Ensure cards are usable by everyone

- **Keyboard Navigation** - Tab through card actions
- **Screen Reader Support** - Proper ARIA labels
- **Focus Management** - Visual focus indicators
- **Reduced Motion** - Respect prefers-reduced-motion

**Use Cases:**
- Keyboard-only users can interact with all card features
- Screen readers announce card content and state
- Focus visible for keyboard navigation
- Animations disabled for motion-sensitive users

**Technical Approach:**
- Tab order: `tabindex` attributes
- ARIA: `role`, `aria-label`, `aria-expanded`, `aria-live`
- Focus styles: `:focus-visible` pseudo-class
- Reduced motion: `@media (prefers-reduced-motion: reduce)`
- Semantic HTML: Proper heading hierarchy

---

### **14. Grid & Layout Management**

**Description:** Advanced grid systems for card layouts

- **Masonry Layout** - Pinterest-style grid
- **Grid Resize** - Drag to resize card width/height
- **Column Span** - Cards spanning multiple columns
- **Auto-fit Grid** - Responsive auto-sizing

**Use Cases:**
- Image galleries with variable heights
- Dashboard widgets users can resize
- Featured cards spanning 2 columns
- Responsive grids that auto-fit

**Technical Approach:**
- Masonry: Masonry.js or CSS Grid masonry (when widely supported)
- Resize: ResizeObserver API + drag handles
- Column span: CSS Grid `grid-column: span 2`
- Auto-fit: CSS Grid `repeat(auto-fit, minmax(300px, 1fr))`

---

### **15. Reusable Plugin Architecture**

**Description:** Modular system for card features

- **Plugin System** - Modular feature activation
- **Event Hooks** - Before/after action hooks
- **Custom Actions** - Register custom actions
- **Theme Variants** - Multiple visual themes
- **Configuration Presets** - Quick setup templates

**Use Cases:**
- Enable only needed features per card type
- Hook into card events for custom logic
- Add custom toolbar actions
- Apply different themes per card
- Quick setup for common card patterns

**Technical Approach:**
- Plugin registration: `SOCard.registerPlugin('draggable', DraggablePlugin)`
- Feature flags: `card.use('draggable', 'refresh', 'fullscreen')`
- Event system: `card.on('beforeRefresh', callback)`
- Theme classes: `.card-theme-primary`, `.card-theme-dark`
- Preset configs: `SOCard.createFromPreset('dashboard-widget')`

---

## Implementation Priority

### **Phase 1 - Essential (Must Have)**
**Target:** MVP - Core functionality

1. **Card Actions** - Collapse, Refresh, Fullscreen, Close
2. **Loading States** - Overlay, Spinner, Progress
3. **Basic Toolbar** - Action buttons, dropdown menu
4. **Accessibility** - Keyboard navigation, ARIA labels

**Estimated Effort:** 2-3 weeks
**Dependencies:** None
**Value:** High - Immediate usability improvement

---

### **Phase 2 - Interactive (Should Have)**
**Target:** Enhanced UX

1. **Draggable & Sortable** - Full drag-drop support
2. **State Management** - Pin, Favorite, Dirty tracking
3. **Tabs Integration** - Tabs in card header
4. **Content Features** - Read more, Lazy loading
5. **Responsive Behaviors** - Mobile drawer, Swipe actions

**Estimated Effort:** 3-4 weeks
**Dependencies:** Phase 1
**Value:** Medium-High - Significant UX enhancement

---

### **Phase 3 - Advanced (Nice to Have)**
**Target:** Premium features

1. **Flip/Reveal Animations** - Advanced transitions
2. **Auto-refresh** - Real-time updates
3. **Advanced Layouts** - Split, Stack, Reveal
4. **User Interactions** - Copy, Share, Export, QR
5. **Skeleton States** - Shimmer effect

**Estimated Effort:** 2-3 weeks
**Dependencies:** Phase 1, Phase 2
**Value:** Medium - Differentiation features

---

### **Phase 4 - Polish (Future)**
**Target:** Premium enhancements

1. **Visual Enhancements** - Glow, Parallax, Glassmorphism
2. **Grid Management** - Masonry, Resize, Column span
3. **Virtual Scrolling** - Performance optimization
4. **Real-time** - WebSocket integration, Live updates
5. **Plugin System** - Full extensibility

**Estimated Effort:** 3-4 weeks
**Dependencies:** Phase 1, Phase 2, Phase 3
**Value:** Low-Medium - Nice-to-have polish

---

## Technical Architecture

### Plugin Structure

```javascript
// Example plugin architecture
class SOCardPlugin {
    constructor(card, options) {
        this.card = card;
        this.options = options;
    }

    init() {
        // Plugin initialization
    }

    destroy() {
        // Cleanup
    }
}

// Registration
SOCard.registerPlugin('pluginName', SOCardPlugin);

// Usage
const card = SOCard.getInstance(element);
card.use('pluginName', { option1: 'value' });
```

### Event System

```javascript
// Event hooks
card.on('beforeCollapse', (event) => {
    // Can prevent default
    if (someCondition) {
        event.preventDefault();
    }
});

card.on('afterCollapse', () => {
    // React to state change
});

// Trigger custom events
card.trigger('customEvent', { data: 'value' });
```

### Configuration Presets

```javascript
// Preset definitions
SOCard.definePreset('dashboard-widget', {
    actions: ['collapse', 'refresh', 'fullscreen'],
    draggable: true,
    autoRefresh: 30000,
    theme: 'default'
});

// Usage
const widget = SOCard.createFromPreset('dashboard-widget', element);
```

---

## File Structure

```
frontend/src/js/ui-engine/
├── card/
│   ├── Card.js                    # Core card class
│   ├── CardActions.js             # Action handlers (collapse, refresh, etc.)
│   ├── CardState.js               # State management
│   ├── CardLoader.js              # Loading states
│   ├── plugins/
│   │   ├── DraggablePlugin.js     # Drag & drop
│   │   ├── AutoRefreshPlugin.js   # Auto-refresh
│   │   ├── FlipPlugin.js          # Flip animation
│   │   ├── SkeletonPlugin.js      # Skeleton loading
│   │   └── ...
│   └── presets/
│       ├── DashboardWidget.js     # Dashboard preset
│       ├── DataCard.js            # Data display preset
│       └── FormCard.js            # Form preset
```

---

## Integration Points

### With Existing Components

- **Dropdown** - Header action menus
- **Button** - Toolbar actions
- **Badge** - Notification counts
- **Tabs** - Tabbed content
- **Accordion** - Collapsible sections
- **Modal** - Fullscreen mode, Mobile drawer

### With Form System

- **Dirty Tracking** - Unsaved changes warning
- **Validation** - Error state display
- **Auto-save** - Periodic form saving
- **Progress** - Multi-step form progress

### With Data Tables

- **Search** - Filter table content
- **Sort** - Column sorting controls
- **Pagination** - Load more data
- **Export** - Download table data

---

## Browser Support

- **Modern Browsers:** Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- **Mobile:** iOS Safari 14+, Chrome Android 90+
- **Graceful Degradation:** Fallbacks for older browsers
- **Progressive Enhancement:** Core features work everywhere, enhancements where supported

---

## Performance Considerations

1. **Lazy Initialization** - Only initialize active features
2. **Event Delegation** - Single listener for multiple cards
3. **Debouncing** - Throttle expensive operations (resize, scroll)
4. **Virtual Scrolling** - Only render visible items
5. **Web Workers** - Offload heavy processing
6. **CSS Containment** - Optimize rendering performance
7. **Intersection Observer** - Lazy load, auto-refresh only visible cards

---

## Testing Strategy

### Unit Tests
- Card initialization
- State management
- Event system
- Plugin registration

### Integration Tests
- Card actions (collapse, refresh, etc.)
- Drag and drop
- Responsive behaviors
- Accessibility

### E2E Tests
- User workflows
- Multi-card interactions
- Cross-browser compatibility
- Mobile gestures

---

## Documentation Requirements

1. **API Reference** - All methods, options, events
2. **Usage Examples** - Common patterns and recipes
3. **Plugin Development** - How to create custom plugins
4. **Migration Guide** - Upgrade from basic cards
5. **Accessibility Guide** - Best practices
6. **Performance Guide** - Optimization tips

---

## Success Metrics

1. **Adoption** - % of cards using advanced features
2. **Performance** - No impact on page load time
3. **Accessibility** - WCAG 2.1 AA compliance
4. **Developer Experience** - Easy to use API
5. **User Satisfaction** - Positive feedback on interactions

---

## Next Steps

1. **Review & Prioritize** - Team discussion on features
2. **Prototype Phase 1** - Build core actions + loading states
3. **User Testing** - Gather feedback on prototypes
4. **Design System** - Visual design for all states
5. **Implementation** - Develop per phase plan
6. **Documentation** - Write guides and examples
7. **Release** - Gradual rollout with feature flags

---

## References

- **Vuexy Template:** `/var/www/html/vuexy/html/vertical-menu-template/cards-actions.html`
- **SortableJS:** https://github.com/SortableJS/Sortable
- **Masonry:** https://masonry.desandro.com/
- **WCAG Guidelines:** https://www.w3.org/WAI/WCAG21/quickref/

---

**Note:** This is a comprehensive planning document. Features will be refined based on implementation findings, user feedback, and technical constraints. Not all features may be implemented in the final version.
