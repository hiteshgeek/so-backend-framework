// ============================================
// SIXORBIT UI ENGINE - STANDALONE BUNDLE ENTRY
// Separate build for UiEngine functionality
// ============================================

import SixOrbit from '../core/so-config.js';

// Core classes
export { Element } from './core/Element.js';
export { FormElement } from './core/FormElement.js';
export { ContainerElement } from './core/ContainerElement.js';

// All UI Elements
export * from './elements/index.js';

// Validation system
export { ValidationEngine } from './validation/ValidationEngine.js';
export { ErrorReporter } from './validation/ErrorReporter.js';

// Main UiEngine class
export { UiEngine } from './UiEngine.js';
export { default } from './UiEngine.js';

// Import UiEngine for initialization
import { UiEngine } from './UiEngine.js';

// Global registration
window.UiEngine = UiEngine;
window.SixOrbit = SixOrbit;

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => UiEngine.init());
} else {
    // DOM already ready
    UiEngine.init();
}
