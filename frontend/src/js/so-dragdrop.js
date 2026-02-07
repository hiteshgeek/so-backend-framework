// ============================================
// SIXORBIT UI - STANDALONE DRAGDROP BUNDLE
// Lightweight drag-drop component for reorderable elements
// ============================================

import SixOrbit from './core/so-config.js';
import SOComponent from './core/so-component.js';
import SODragDrop from './components/so-dragdrop.js';

// Expose to window for inline script usage
window.SixOrbit = SixOrbit;
window.SOComponent = SOComponent;
window.SODragDrop = SODragDrop;

/**
 * Auto-initialize drag-drop from data attributes
 * Supports two patterns:
 * 1. Container with data-so-dragdrop attribute (original pattern)
 * 2. UiEngine elements with data-so-draggable="true" (new pattern)
 */
document.addEventListener('DOMContentLoaded', () => {
  // Pattern 1: Containers with data-so-dragdrop attribute
  document.querySelectorAll('[data-so-dragdrop]').forEach(el => {
    SODragDrop.getInstance(el);
  });

  // Pattern 2: UiEngine elements with data-so-draggable="true"
  // Group by parent container and initialize once per container
  const containers = new Map();

  document.querySelectorAll('[data-so-draggable="true"]').forEach(el => {
    const container = el.parentElement;
    if (!container || containers.has(container)) return;

    // Build config from data attributes on the first draggable element
    const config = {
      items: '[data-so-draggable="true"]'
    };

    // Read config from data attributes
    if (el.dataset.soHandle) {
      config.handle = el.dataset.soHandle;
    }
    if (el.dataset.soGroup) {
      config.group = el.dataset.soGroup;
    }
    if (el.dataset.soItems) {
      config.items = el.dataset.soItems;
    }
    if (el.dataset.soLiveReorder === 'true') {
      config.liveReorder = true;
    }
    if (el.dataset.soStorage) {
      config.storage = el.dataset.soStorage;
    }
    if (el.dataset.soStorageKey) {
      config.storageKey = el.dataset.soStorageKey;
    }

    // Parse JSON config if present (for additional options)
    if (el.dataset.soDragConfig) {
      try {
        Object.assign(config, JSON.parse(el.dataset.soDragConfig));
      } catch (e) {
        console.warn('SODragDrop: Invalid JSON in data-so-drag-config:', e);
      }
    }

    // Initialize SODragDrop on the container
    containers.set(container, SODragDrop.getInstance(container, config));
  });
});

// ES module exports
export { SixOrbit, SOComponent, SODragDrop };
export default SODragDrop;
