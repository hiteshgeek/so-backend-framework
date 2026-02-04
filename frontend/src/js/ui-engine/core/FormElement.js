// ============================================
// SIXORBIT UI ENGINE - FORM ELEMENT BASE CLASS
// Foundation for all form elements
// ============================================

import { Element } from './Element.js';
import SixOrbit from '../../core/so-config.js';

/**
 * FormElement - Base class for all form elements
 * Extends Element with form-specific functionality
 */
class FormElement extends Element {
    static NAME = 'ui-form-element';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'form-element',
        inputType: 'text',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        // Form-specific properties
        this._name = config.name || null;
        this._label = config.label || null;
        this._value = config.value ?? null;
        this._placeholder = config.placeholder || null;
        this._help = config.help || null;
        this._disabled = config.disabled || false;
        this._readonly = config.readonly || false;
        this._required = config.required || false;
        this._error = config.error || null;

        // Validation
        this._rules = config.rules || {};
        this._messages = config.messages || {};

        // Events
        this._eventHandlers = config.events || {};
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set field name
     * @param {string} name
     * @returns {this}
     */
    setName(name) {
        this._name = name;
        return this;
    }

    /**
     * Get field name
     * @returns {string|null}
     */
    getName() {
        return this._name;
    }

    /**
     * Set label
     * @param {string} label
     * @returns {this}
     */
    setLabel(label) {
        this._label = label;
        return this;
    }

    /**
     * Get label
     * @returns {string|null}
     */
    getLabel() {
        return this._label;
    }

    /**
     * Set value
     * @param {*} value
     * @returns {this}
     */
    setValue(value) {
        this._value = value;
        if (this.element) {
            this.element.value = value;
        }
        return this;
    }

    /**
     * Get value
     * @returns {*}
     */
    getValue() {
        if (this.element) {
            return this.element.value;
        }
        return this._value;
    }

    /**
     * Set placeholder
     * @param {string} placeholder
     * @returns {this}
     */
    setPlaceholder(placeholder) {
        this._placeholder = placeholder;
        return this;
    }

    /**
     * Get placeholder
     * @returns {string|null}
     */
    getPlaceholder() {
        return this._placeholder;
    }

    /**
     * Set help text
     * @param {string} help
     * @returns {this}
     */
    setHelp(help) {
        this._help = help;
        return this;
    }

    /**
     * Get help text
     * @returns {string|null}
     */
    getHelp() {
        return this._help;
    }

    /**
     * Set disabled state
     * @param {boolean} disabled
     * @returns {this}
     */
    setDisabled(disabled = true) {
        this._disabled = disabled;
        if (this.element) {
            this.element.disabled = disabled;
        }
        return this;
    }

    /**
     * Check if disabled
     * @returns {boolean}
     */
    isDisabled() {
        return this._disabled;
    }

    /**
     * Set readonly state
     * @param {boolean} readonly
     * @returns {this}
     */
    setReadonly(readonly = true) {
        this._readonly = readonly;
        if (this.element) {
            this.element.readOnly = readonly;
        }
        return this;
    }

    /**
     * Check if readonly
     * @returns {boolean}
     */
    isReadonly() {
        return this._readonly;
    }

    /**
     * Set required state
     * @param {boolean} required
     * @returns {this}
     */
    setRequired(required = true) {
        this._required = required;
        if (!this._rules.required && required) {
            this._rules.required = true;
        }
        return this;
    }

    /**
     * Check if required
     * @returns {boolean}
     */
    isRequired() {
        return this._required || !!this._rules.required;
    }

    // ==================
    // Validation
    // ==================

    /**
     * Set validation rules
     * @param {Object|string} rules
     * @returns {this}
     */
    setRules(rules) {
        if (typeof rules === 'string') {
            this._rules = this._parseRuleString(rules);
        } else {
            this._rules = { ...this._rules, ...rules };
        }
        return this;
    }

    /**
     * Get validation rules
     * @returns {Object}
     */
    getRules() {
        return this._rules;
    }

    /**
     * Check if has rules
     * @returns {boolean}
     */
    hasRules() {
        return Object.keys(this._rules).length > 0;
    }

    /**
     * Add a validation rule
     * @param {string} rule
     * @param {*} params
     * @returns {this}
     */
    addRule(rule, params = true) {
        this._rules[rule] = params;
        return this;
    }

    /**
     * Set custom validation messages
     * @param {Object} messages
     * @returns {this}
     */
    setMessages(messages) {
        this._messages = { ...this._messages, ...messages };
        return this;
    }

    /**
     * Get custom messages
     * @returns {Object}
     */
    getMessages() {
        return this._messages;
    }

    /**
     * Parse rule string like "required|email|max:255"
     * @param {string} rules
     * @returns {Object}
     * @private
     */
    _parseRuleString(rules) {
        const parsed = {};

        rules.split('|').forEach(rule => {
            rule = rule.trim();
            if (!rule) return;

            if (rule.includes(':')) {
                const [name, params] = rule.split(':', 2);
                parsed[name] = params.includes(',') ? params.split(',') : params;
            } else {
                parsed[rule] = true;
            }
        });

        return parsed;
    }

    // ==================
    // Error Handling
    // ==================

    /**
     * Set error message
     * @param {string|null} error
     * @returns {this}
     */
    setError(error) {
        this._error = error;

        if (this.element) {
            if (error) {
                this.element.classList.add(SixOrbit.cls('is-invalid'));
                this._updateErrorDisplay(error);
            } else {
                this.element.classList.remove(SixOrbit.cls('is-invalid'));
                this._updateErrorDisplay(null);
            }
        }

        return this;
    }

    /**
     * Get error message
     * @returns {string|null}
     */
    getError() {
        return this._error;
    }

    /**
     * Check if has error
     * @returns {boolean}
     */
    hasError() {
        return this._error !== null;
    }

    /**
     * Clear error
     * @returns {this}
     */
    clearError() {
        return this.setError(null);
    }

    /**
     * Update error display in DOM
     * @param {string|null} error
     * @private
     */
    _updateErrorDisplay(error) {
        // Find or create error element
        const wrapper = this.element.closest(SixOrbit.sel('form-group'));
        if (!wrapper) return;

        let errorEl = wrapper.querySelector(SixOrbit.sel('invalid-feedback'));

        if (error) {
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = SixOrbit.cls('invalid-feedback');
                wrapper.appendChild(errorEl);
            }
            errorEl.textContent = error;
            errorEl.style.display = 'block';
        } else if (errorEl) {
            errorEl.style.display = 'none';
        }
    }

    // ==================
    // Events
    // ==================

    /**
     * Set event handler
     * @param {string} event
     * @param {string|Function} handler
     * @returns {this}
     */
    onEvent(event, handler) {
        this._eventHandlers[event] = handler;
        return this;
    }

    /**
     * Set change handler
     * @param {string|Function} handler
     * @returns {this}
     */
    onChange(handler) {
        return this.onEvent('change', handler);
    }

    /**
     * Set blur handler
     * @param {string|Function} handler
     * @returns {this}
     */
    onBlur(handler) {
        return this.onEvent('blur', handler);
    }

    /**
     * Set focus handler
     * @param {string|Function} handler
     * @returns {this}
     */
    onFocus(handler) {
        return this.onEvent('focus', handler);
    }

    /**
     * Set input handler
     * @param {string|Function} handler
     * @returns {this}
     */
    onInput(handler) {
        return this.onEvent('input', handler);
    }

    // ==================
    // Validation Convenience
    // ==================

    /** Required validation */
    required() { return this.addRule('required', true); }

    /** Email validation */
    email() { return this.addRule('email', true); }

    /** Min length/value */
    min(value) { return this.addRule('min', value); }

    /** Max length/value */
    max(value) { return this.addRule('max', value); }

    /** Between range */
    between(min, max) { return this.addRule('between', [min, max]); }

    /** Numeric validation */
    numeric() { return this.addRule('numeric', true); }

    /** Integer validation */
    integer() { return this.addRule('integer', true); }

    /** URL validation */
    url() { return this.addRule('url', true); }

    /** Pattern validation */
    pattern(regex) { return this.addRule('regex', regex); }

    // ==================
    // Rendering
    // ==================

    /**
     * Build attributes including form-specific ones
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (this._name) attrs.name = this._name;
        if (this._placeholder) attrs.placeholder = this._placeholder;
        if (this._disabled) attrs.disabled = true;
        if (this._readonly) attrs.readonly = true;
        if (this.isRequired()) attrs.required = true;

        // Value (for input elements)
        if (this._value !== null && this._shouldRenderValueAttr()) {
            attrs.value = this._value;
        }

        return attrs;
    }

    /**
     * Whether to render value as attribute
     * @returns {boolean}
     * @protected
     */
    _shouldRenderValueAttr() {
        return true;
    }

    /**
     * Build CSS class string
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('form-control'));

        if (this._error) {
            this._extraClasses.add(SixOrbit.cls('is-invalid'));
        }

        return super.buildClassString();
    }

    /**
     * Render with label and help
     * @returns {HTMLElement}
     */
    renderGroup() {
        const group = document.createElement('div');
        group.className = SixOrbit.cls('form-group');

        // Label
        if (this._label) {
            const label = document.createElement('label');
            label.className = SixOrbit.cls('form-label');
            label.textContent = this._label;
            if (this._id) {
                label.setAttribute('for', this._id);
            }
            if (this.isRequired()) {
                const star = document.createElement('span');
                star.className = SixOrbit.cls('text-danger');
                star.textContent = ' *';
                label.appendChild(star);
            }
            group.appendChild(label);
        }

        // Input element
        group.appendChild(this.render());

        // Help text
        if (this._help) {
            const help = document.createElement('div');
            help.className = SixOrbit.cls('form-text');
            help.textContent = this._help;
            group.appendChild(help);
        }

        // Error
        if (this._error) {
            const error = document.createElement('div');
            error.className = SixOrbit.cls('invalid-feedback');
            error.style.display = 'block';
            error.textContent = this._error;
            group.appendChild(error);
        }

        return group;
    }

    /**
     * Attach event handlers after render
     * @protected
     */
    _attachEventHandlers() {
        if (!this.element) return;

        Object.entries(this._eventHandlers).forEach(([event, handler]) => {
            if (typeof handler === 'function') {
                this.element.addEventListener(event, handler);
            } else if (typeof handler === 'string' && typeof window[handler] === 'function') {
                this.element.addEventListener(event, window[handler]);
            }
        });
    }

    /**
     * Render to DOM
     * @returns {HTMLElement}
     */
    render() {
        const el = super.render();
        this._attachEventHandlers();
        return el;
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config object
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._name) config.name = this._name;
        if (this._label) config.label = this._label;
        if (this._value !== null) config.value = this._value;
        if (this._placeholder) config.placeholder = this._placeholder;
        if (this._help) config.help = this._help;
        if (this._disabled) config.disabled = true;
        if (this._readonly) config.readonly = true;
        if (this._required) config.required = true;
        if (Object.keys(this._rules).length > 0) config.rules = this._rules;
        if (Object.keys(this._messages).length > 0) config.messages = this._messages;
        if (Object.keys(this._eventHandlers).length > 0) config.events = this._eventHandlers;

        return config;
    }

    /**
     * Export validation for JS engine
     * @returns {Object}
     */
    exportValidation() {
        return {
            rules: this._rules,
            messages: this._messages,
        };
    }
}

export default FormElement;
export { FormElement };
