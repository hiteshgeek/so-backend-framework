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

// Auto-initialize elements with data-so-dragdrop attribute
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-so-dragdrop]').forEach(el => {
    SODragDrop.getInstance(el);
  });
});

// ES module exports
export { SixOrbit, SOComponent, SODragDrop };
export default SODragDrop;
