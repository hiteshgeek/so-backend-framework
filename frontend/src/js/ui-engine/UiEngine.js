// ============================================
// SIXORBIT UI ENGINE - MAIN FACTORY CLASS
// Entry point for the UI Engine
// ============================================

import { Element } from './core/Element.js';
import { FormElement } from './core/FormElement.js';
import { ContainerElement } from './core/ContainerElement.js';
import { ValidationEngine } from './validation/ValidationEngine.js';
import { ErrorReporter } from './validation/ErrorReporter.js';
import SixOrbit from '../core/so-config.js';

// Import all element categories
import * as FormElements from './elements/form/index.js';
import * as DisplayElements from './elements/display/index.js';
import * as LayoutElements from './elements/layout/index.js';
import * as NavigationElements from './elements/navigation/index.js';

/**
 * UiEngine - Main factory class for creating UI elements
 * Mirrors the PHP UiEngine class for symmetry
 */
class UiEngine {
    /**
     * Registered element types
     * @type {Object}
     */
    static elements = {};

    /**
     * Global configuration
     * @type {Object}
     */
    static config = {
        defaultInputSize: 'md',
        defaultButtonVariant: 'primary',
        useInlineEvents: false,
    };

    // ==================
    // Element Registration
    // ==================

    /**
     * Register an element type
     * @param {string} type
     * @param {Function} elementClass
     */
    static register(type, elementClass) {
        this.elements[type] = elementClass;
    }

    /**
     * Check if element type is registered
     * @param {string} type
     * @returns {boolean}
     */
    static hasElement(type) {
        return this.elements.hasOwnProperty(type);
    }

    /**
     * Get registered element class
     * @param {string} type
     * @returns {Function|null}
     */
    static getElementClass(type) {
        return this.elements[type] || null;
    }

    /**
     * Get all registered types
     * @returns {string[]}
     */
    static getElementTypes() {
        return Object.keys(this.elements);
    }

    // ==================
    // Configuration
    // ==================

    /**
     * Configure global options
     * @param {Object} options
     */
    static configure(options) {
        Object.assign(this.config, options);
    }

    /**
     * Get configuration value
     * @param {string} key
     * @param {*} defaultValue
     * @returns {*}
     */
    static getConfig(key, defaultValue = null) {
        return this.config[key] ?? defaultValue;
    }

    // ==================
    // Factory Methods
    // ==================

    /**
     * Create element from config
     * @param {Object} config
     * @returns {Element}
     */
    static fromConfig(config) {
        const type = config.type;

        if (!type) {
            throw new Error('Element config must include a "type" key');
        }

        const ElementClass = this.elements[type];

        if (!ElementClass) {
            // Fallback to base classes
            if (config.children) {
                return ContainerElement.make(config);
            }
            if (config.name) {
                return FormElement.make(config);
            }
            return Element.make(config);
        }

        return ElementClass.make(config);
    }

    /**
     * Create element from JSON string
     * @param {string} json
     * @returns {Element}
     */
    static fromJson(json) {
        const config = JSON.parse(json);
        return this.fromConfig(config);
    }

    /**
     * Create multiple elements from configs
     * @param {Array} configs
     * @returns {Element[]}
     */
    static fromConfigMany(configs) {
        return configs.map(config => this.fromConfig(config));
    }

    /**
     * Alias for fromConfig
     * @param {Object} config
     * @returns {Element}
     */
    static make(config) {
        return this.fromConfig(config);
    }

    // ==================
    // Shortcut Factories
    // ==================

    /**
     * Create input element
     * @param {string} name
     * @returns {FormElement}
     */
    static input(name = null) {
        return FormElement.make({
            type: 'input',
            tagName: 'input',
            name
        });
    }

    /**
     * Create email input
     * @param {string} name
     * @returns {FormElement}
     */
    static email(name = null) {
        const input = this.input(name);
        input.setAttr('type', 'email');
        input.email();
        return input;
    }

    /**
     * Create password input
     * @param {string} name
     * @returns {FormElement}
     */
    static password(name = null) {
        const input = this.input(name);
        input.setAttr('type', 'password');
        return input;
    }

    /**
     * Create textarea element
     * @param {string} name
     * @returns {FormElement}
     */
    static textarea(name = null) {
        return FormElement.make({
            type: 'textarea',
            tagName: 'textarea',
            name
        });
    }

    /**
     * Create select element
     * @param {string} name
     * @returns {FormElement}
     */
    static select(name = null) {
        return FormElement.make({
            type: 'select',
            tagName: 'select',
            name
        });
    }

    /**
     * Create switch element
     * @param {string} name
     * @returns {SwitchElement}
     */
    static switch(name = null) {
        return FormElements.SwitchElement.make({
            type: 'switch',
            name
        });
    }

    /**
     * Create toggle element (alias for switch)
     * @param {string} name
     * @returns {SwitchElement}
     */
    static toggle(name = null) {
        return this.switch(name);
    }

    /**
     * Create button element
     * @param {string} text
     * @returns {Element}
     */
    static button(text = null) {
        const btn = Element.make({
            type: 'button',
            tagName: 'button',
            content: text
        });
        btn.setClass(`${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-primary')}`);
        return btn;
    }

    /**
     * Create submit button
     * @param {string} text
     * @returns {Element}
     */
    static submit(text = 'Submit') {
        const btn = this.button(text);
        btn.setAttr('type', 'submit');
        return btn;
    }

    /**
     * Create form element
     * @param {string} action
     * @returns {ContainerElement}
     */
    static form(action = null) {
        const form = ContainerElement.make({
            type: 'form',
            tagName: 'form'
        });
        if (action) {
            form.setAttr('action', action);
        }
        form.setAttr('method', 'POST');
        return form;
    }

    /**
     * Create row element
     * @returns {ContainerElement}
     */
    static row() {
        const row = ContainerElement.make({
            type: 'row',
            tagName: 'div'
        });
        row.setClass(SixOrbit.cls('row'));
        return row;
    }

    /**
     * Create column element
     * @param {number|string} size
     * @returns {ContainerElement}
     */
    static col(size = null) {
        const col = ContainerElement.make({
            type: 'column',
            tagName: 'div'
        });
        col.setClass(size ? SixOrbit.cls('col', size) : SixOrbit.cls('col'));
        return col;
    }

    /**
     * Create container element
     * @param {boolean} fluid
     * @returns {ContainerElement}
     */
    static container(fluid = false) {
        const container = ContainerElement.make({
            type: 'container',
            tagName: 'div'
        });
        container.setClass(fluid ? SixOrbit.cls('container-fluid') : SixOrbit.cls('container'));
        return container;
    }

    /**
     * Create card element
     * @param {string} title
     * @returns {ContainerElement}
     */
    static card(title = null) {
        const card = ContainerElement.make({
            type: 'card',
            tagName: 'div'
        });
        card.setClass(SixOrbit.cls('card'));
        if (title) {
            card._title = title;
        }
        return card;
    }

    /**
     * Create alert element
     * @param {string} message
     * @returns {Element}
     */
    static alert(message = null) {
        const alert = Element.make({
            type: 'alert',
            tagName: 'div',
            content: message
        });
        alert.setClass(`${SixOrbit.cls('alert')} ${SixOrbit.cls('alert-info')}`);
        alert.setAttr('role', 'alert');
        return alert;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Render elements to container
     * @param {Element[]} elements
     * @param {HTMLElement|string} container
     */
    static render(elements, container) {
        const target = typeof container === 'string'
            ? document.querySelector(container)
            : container;

        if (!target) return;

        const fragment = document.createDocumentFragment();
        elements.forEach(el => {
            if (el instanceof Element) {
                fragment.appendChild(el.render());
            }
        });
        target.appendChild(fragment);
    }

    /**
     * Render config to container
     * @param {Object[]} configs
     * @param {HTMLElement|string} container
     */
    static renderFromConfig(configs, container) {
        const elements = this.fromConfigMany(configs);
        this.render(elements, container);
    }

    // ==================
    // Validation
    // ==================

    /**
     * Load validation rules from PHP export
     * @param {string|Object} formSelectorOrRules
     * @param {Object} [rules]
     */
    static loadValidation(formSelectorOrRules, rules = null) {
        ValidationEngine.loadRules(formSelectorOrRules, rules);
    }

    /**
     * Validate a form
     * @param {HTMLFormElement|Element} form
     * @returns {{valid: boolean, errors: Object}}
     */
    static validateForm(form) {
        return ValidationEngine.validateForm(form);
    }

    /**
     * Validate a field
     * @param {HTMLElement|FormElement} field
     * @returns {{valid: boolean, errors: string[]}}
     */
    static validateField(field) {
        return ValidationEngine.validateField(field);
    }

    /**
     * Register custom validation rule
     * @param {string} name
     * @param {Function} validator
     * @param {string} message
     */
    static registerRule(name, validator, message = null) {
        ValidationEngine.registerRule(name, validator, message);
    }

    /**
     * Attach form validation
     * @param {HTMLFormElement|string} form
     * @param {Object} options
     */
    static attachValidation(form, options = {}) {
        const { onSuccess, onError, validateOnBlur = true } = options;

        if (validateOnBlur) {
            ValidationEngine.attachBlurValidation(form);
        }

        ValidationEngine.attachSubmitValidation(form, onSuccess, onError);
    }

    // ==================
    // Error Reporter
    // ==================

    /**
     * Get error reporter instance
     * @returns {ErrorReporter}
     */
    static get errors() {
        return ErrorReporter.getInstance();
    }

    /**
     * Show errors
     * @param {Object} errors
     */
    static showErrors(errors) {
        this.errors.showAll(errors);
    }

    /**
     * Clear all errors
     */
    static clearErrors() {
        this.errors.clearAll();
    }

    /**
     * Configure error reporter
     * @param {Object} options
     */
    static configureErrors(options) {
        this.errors.configure(options);
    }

    // ==================
    // Auto-Initialization
    // ==================

    /**
     * Initialize all PHP-rendered UiEngine elements on the page
     * Call once after DOM ready or after AJAX content load
     *
     * @param {Element|Document} container - Scope to search within (default: document)
     * @returns {Map} Map of initialized elements by ID or element reference
     */
    static init(container = document) {
        const initialized = new Map();
        const selector = `[${SixOrbit.data('ui-init')}]`;

        container.querySelectorAll(selector).forEach(el => {
            // Skip already initialized
            if (el._uiEngineInstance) return;

            const type = el.getAttribute(SixOrbit.data('ui-init'));
            const configAttr = el.getAttribute(SixOrbit.data('ui-config'));
            const config = configAttr ? JSON.parse(configAttr) : {};

            const instance = this.initElement(el, type, config);
            if (instance) {
                initialized.set(el.id || el, instance);
            }
        });

        return initialized;
    }

    /**
     * Initialize a single element from existing DOM
     *
     * @param {Element} el - DOM element
     * @param {string} type - Element type (modal, dropdown, etc.)
     * @param {Object} config - Configuration options
     * @returns {Object|null} Instance or null if type not found
     */
    static initElement(el, type, config = {}) {
        const ElementClass = this.elements[type];
        if (!ElementClass) {
            console.warn(`UiEngine: Unknown element type "${type}"`);
            return null;
        }

        // Create instance from existing DOM element
        // Pass the element as _domElement in config
        const instance = new ElementClass({
            ...config,
            _domElement: el,
            id: el.id || config.id
        });

        // Store reference for later retrieval
        el._uiEngineInstance = instance;

        return instance;
    }

    /**
     * Get existing UiEngine instance from DOM element
     *
     * @param {Element|string} element - DOM element or CSS selector
     * @returns {Object|null} Instance or null if not initialized
     */
    static getInstance(element) {
        const el = typeof element === 'string'
            ? document.querySelector(element)
            : element;
        return el?._uiEngineInstance || null;
    }

    /**
     * Get or initialize an element by selector
     *
     * If the element has already been initialized, returns existing instance.
     * Otherwise initializes it based on data-so-ui-init attribute.
     *
     * @param {string} selector - CSS selector
     * @param {Object} config - Optional config override
     * @returns {Object|null} Instance or null if element not found
     */
    static get(selector, config = {}) {
        const el = document.querySelector(selector);
        if (!el) return null;

        // Return existing instance if available
        if (el._uiEngineInstance) return el._uiEngineInstance;

        // Initialize based on data attribute
        const type = el.getAttribute(SixOrbit.data('ui-init'));
        if (type) {
            const configAttr = el.getAttribute(SixOrbit.data('ui-config'));
            const baseConfig = configAttr ? JSON.parse(configAttr) : {};
            return this.initElement(el, type, { ...baseConfig, ...config });
        }

        return null;
    }

    /**
     * Re-initialize elements in a container (useful after AJAX content load)
     *
     * @param {string|Element} container - Container selector or element
     * @returns {Map} Map of newly initialized elements
     */
    static reinit(container) {
        const target = typeof container === 'string'
            ? document.querySelector(container)
            : container;

        if (!target) return new Map();

        return this.init(target);
    }

    /**
     * Destroy instance and clean up
     *
     * @param {Element|string} element - DOM element or selector
     * @returns {boolean} True if instance was destroyed
     */
    static destroy(element) {
        const el = typeof element === 'string'
            ? document.querySelector(element)
            : element;

        if (!el || !el._uiEngineInstance) return false;

        // Call destroy method if available
        if (typeof el._uiEngineInstance.destroy === 'function') {
            el._uiEngineInstance.destroy();
        }

        delete el._uiEngineInstance;
        return true;
    }
}

// ==================
// Register Base Types
// ==================

UiEngine.register('element', Element);
UiEngine.register('form-element', FormElement);
UiEngine.register('container', ContainerElement);

// ==================
// Register Form Elements
// ==================

UiEngine.register('input', FormElements.Input);
UiEngine.register('select', FormElements.Select);
UiEngine.register('checkbox', FormElements.Checkbox);
UiEngine.register('radio', FormElements.Radio);
UiEngine.register('textarea', FormElements.Textarea);
UiEngine.register('button', FormElements.Button);
UiEngine.register('file-input', FormElements.FileInput);
UiEngine.register('hidden', FormElements.Hidden);
UiEngine.register('form', FormElements.Form);
UiEngine.register('autocomplete', FormElements.Autocomplete);
UiEngine.register('color-input', FormElements.ColorInput);
UiEngine.register('date-picker', FormElements.DatePicker);
UiEngine.register('time-picker', FormElements.TimePicker);
UiEngine.register('switch', FormElements.SwitchElement);
UiEngine.register('toggle', FormElements.Toggle); // backwards compatibility alias
UiEngine.register('slider', FormElements.Slider);
UiEngine.register('dropzone', FormElements.Dropzone);
UiEngine.register('otp-input', FormElements.OtpInput);

// ==================
// Register Display Elements
// ==================

UiEngine.register('accordion', DisplayElements.Accordion);
UiEngine.register('alert', DisplayElements.Alert);
UiEngine.register('badge', DisplayElements.Badge);
UiEngine.register('card', DisplayElements.Card);
UiEngine.register('modal', DisplayElements.Modal);
UiEngine.register('progress', DisplayElements.Progress);
UiEngine.register('table', DisplayElements.Table);
UiEngine.register('tabs', DisplayElements.Tabs);
UiEngine.register('toast', DisplayElements.Toast);
UiEngine.register('tooltip', DisplayElements.Tooltip);
UiEngine.register('breadcrumb', DisplayElements.Breadcrumb);
UiEngine.register('pagination', DisplayElements.Pagination);
UiEngine.register('carousel', DisplayElements.Carousel);
UiEngine.register('timeline', DisplayElements.Timeline);
UiEngine.register('stepper', DisplayElements.Stepper);
UiEngine.register('list-group', DisplayElements.ListGroup);
UiEngine.register('rating', DisplayElements.Rating);
UiEngine.register('spinner', DisplayElements.Spinner);
UiEngine.register('skeleton', DisplayElements.Skeleton);
UiEngine.register('empty-state', DisplayElements.EmptyState);
UiEngine.register('media-object', DisplayElements.MediaObject);
UiEngine.register('code-block', DisplayElements.CodeBlock);

// ==================
// Register Navigation Elements
// ==================

UiEngine.register('dropdown', NavigationElements.Dropdown);
UiEngine.register('context-menu', NavigationElements.ContextMenu);
UiEngine.register('navbar', NavigationElements.Navbar);
UiEngine.register('collapse', NavigationElements.Collapse);

// ==================
// Register Layout Elements
// ==================

UiEngine.register('row', LayoutElements.Row);
UiEngine.register('column', LayoutElements.Column);
UiEngine.register('col', LayoutElements.Column); // alias
UiEngine.register('divider', LayoutElements.Divider);
UiEngine.register('grid', LayoutElements.Grid);
UiEngine.register('flex', LayoutElements.Flex);

// Make available globally
window.UiEngine = UiEngine;

export default UiEngine;
export { UiEngine };
