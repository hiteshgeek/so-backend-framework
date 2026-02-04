// ============================================
// SIXORBIT UI ENGINE - SELECT ELEMENT
// Dropdown select with options support
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Select - Dropdown select element
 */
class Select extends FormElement {
    static NAME = 'ui-select';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'select',
        tagName: 'select',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._options = config.options || [];
        this._multiple = config.multiple || false;
        this._visibleSize = config.visibleSize || null;
        this._emptyOptionText = config.emptyOption ?? null;
        this._emptyOptionValue = config.emptyValue || '';
        this._searchable = config.searchable || false;
        this._enhanced = config.enhanced || false;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set options
     * @param {Array} opts - Array of {value, label, disabled?, selected?}
     * @returns {this}
     */
    options(opts) {
        this._options = opts;
        return this;
    }

    /**
     * Add single option
     * @param {string|number} value
     * @param {string} label
     * @param {boolean} disabled
     * @returns {this}
     */
    option(value, label, disabled = false) {
        const opt = { value, label };
        if (disabled) opt.disabled = true;
        this._options.push(opt);
        return this;
    }

    /**
     * Add option group
     * @param {string} label - Group label
     * @param {Array} opts - Options in the group
     * @returns {this}
     */
    optgroup(label, opts) {
        this._options.push({ label, options: opts });
        return this;
    }

    /**
     * Enable multiple selection
     * @param {boolean} val
     * @returns {this}
     */
    multiple(val = true) {
        this._multiple = val;
        return this;
    }

    /**
     * Set visible options size
     * @param {number} size
     * @returns {this}
     */
    visibleSize(size) {
        this._visibleSize = size;
        return this;
    }

    /**
     * Add empty/placeholder option
     * @param {string} text
     * @param {string} value
     * @returns {this}
     */
    emptyOption(text, value = '') {
        this._emptyOptionText = text;
        this._emptyOptionValue = value;
        return this;
    }

    /**
     * Enable searchable mode (for JS enhancement)
     * @param {boolean} val
     * @returns {this}
     */
    searchable(val = true) {
        this._searchable = val;
        return this;
    }

    /**
     * Enable enhanced SOSelect component
     * Adds data-so-select attribute to trigger JS enhancement
     * @param {boolean} val
     * @returns {this}
     */
    enhanced(val = true) {
        this._enhanced = val;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name
     * @returns {string}
     */
    getTagName() {
        return 'select';
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (this._multiple) attrs.multiple = true;
        if (this._visibleSize) attrs.size = this._visibleSize;
        if (this._searchable) attrs[SixOrbit.data('searchable')] = 'true';
        if (this._enhanced) attrs[SixOrbit.data('select')] = '';

        // Remove value attribute for select (handled by option selected)
        delete attrs.value;

        return attrs;
    }

    /**
     * Build CSS classes
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
     * Don't render value as attribute
     * @returns {boolean}
     */
    _shouldRenderValueAttr() {
        return false;
    }

    /**
     * Render options HTML
     * @returns {string}
     */
    _renderOptionsHtml() {
        let html = '';

        // Empty option
        if (this._emptyOptionText !== null) {
            const selected = this._isSelected(this._emptyOptionValue) ? ' selected' : '';
            html += `<option value="${this._escapeHtml(this._emptyOptionValue)}"${selected}>${this._escapeHtml(this._emptyOptionText)}</option>`;
        }

        // Regular options
        html += this._renderOptions(this._options);

        return html;
    }

    /**
     * Render options array (handles optgroups)
     * @param {Array} options
     * @returns {string}
     * @private
     */
    _renderOptions(options) {
        let html = '';

        options.forEach((opt, key) => {
            if (typeof opt === 'object' && opt.options) {
                // Option group
                const disabled = opt.disabled ? ' disabled' : '';
                html += `<optgroup label="${this._escapeHtml(opt.label)}"${disabled}>`;
                html += this._renderOptions(opt.options);
                html += '</optgroup>';
            } else if (typeof opt === 'object') {
                // Structured option: {value, label}
                const value = opt.value ?? key;
                const label = opt.label ?? value;
                const disabled = opt.disabled ? ' disabled' : '';
                const selected = this._isSelected(value) ? ' selected' : '';
                html += `<option value="${this._escapeHtml(String(value))}"${disabled}${selected}>${this._escapeHtml(String(label))}</option>`;
            } else {
                // Simple key => label format
                const selected = this._isSelected(key) ? ' selected' : '';
                html += `<option value="${this._escapeHtml(String(key))}"${selected}>${this._escapeHtml(String(opt))}</option>`;
            }
        });

        return html;
    }

    /**
     * Check if value is selected
     * @param {*} value
     * @returns {boolean}
     * @private
     */
    _isSelected(value) {
        if (this._multiple && Array.isArray(this._value)) {
            return this._value.includes(value);
        }
        return this._value == value;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        return this._renderOptionsHtml();
    }

    /**
     * Render to DOM
     * @returns {HTMLElement}
     */
    render() {
        const el = document.createElement(this.getTagName());

        // Apply attributes
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                el.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                el.setAttribute(name, value);
            }
        });

        // Add options via innerHTML (handles optgroups)
        el.innerHTML = this._renderOptionsHtml();

        this.element = el;
        this._attachEventHandlers();
        return el;
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._options.length > 0) config.options = this._options;
        if (this._multiple) config.multiple = true;
        if (this._visibleSize) config.visibleSize = this._visibleSize;
        if (this._emptyOptionText !== null) {
            config.emptyOption = this._emptyOptionText;
            config.emptyValue = this._emptyOptionValue;
        }
        if (this._searchable) config.searchable = true;
        if (this._enhanced) config.enhanced = true;

        return config;
    }
}

export default Select;
export { Select };
