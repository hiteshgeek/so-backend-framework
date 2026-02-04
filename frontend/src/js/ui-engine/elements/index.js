// ============================================
// SIXORBIT UI ENGINE - ELEMENTS INDEX
// Exports all UI elements
// ============================================

// Form Elements
export * from './form/index.js';

// Display Elements
export * from './display/index.js';

// Layout Elements
export * from './layout/index.js';

// Navigation Elements
export * from './navigation/index.js';

// Re-export grouped
import * as FormElements from './form/index.js';
import * as DisplayElements from './display/index.js';
import * as LayoutElements from './layout/index.js';
import * as NavigationElements from './navigation/index.js';

export {
    FormElements,
    DisplayElements,
    LayoutElements,
    NavigationElements,
};

// Default export with all elements categorized
export default {
    form: FormElements,
    display: DisplayElements,
    layout: LayoutElements,
    navigation: NavigationElements,
};
