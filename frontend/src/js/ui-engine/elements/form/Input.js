// ============================================
// SIXORBIT UI ENGINE - INPUT ELEMENT
// Text input with all HTML5 types support
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Input - Text input form element
 * Supports all HTML5 input types: text, email, password, number, tel, url, etc.
 */
class Input extends FormElement {
    static NAME = 'ui-input';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'input',
        tagName: 'input',
        inputType: 'text',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._inputType = config.inputType || 'text';
        this._min = config.min ?? null;
        this._max = config.max ?? null;
        this._step = config.step ?? null;
        this._maxlength = config.maxlength ?? null;
        this._minlength = config.minlength ?? null;
        this._pattern = config.pattern || null;
        this._autocomplete = config.autocomplete || null;
        this._prefix = config.prefix || null;
        this._suffix = config.suffix || null;
    }

    // ==================
    // Fluent API - Input Type
    // ==================

    /**
     * Set input type
     * @param {string} type
     * @returns {this}
     */
    inputType(type) {
        this._inputType = type;
        return this;
    }

    /** Set as email input */
    email() { return this.inputType('email'); }

    /** Set as password input */
    password() { return this.inputType('password'); }

    /** Set as number input */
    number() { return this.inputType('number'); }

    /** Set as telephone input */
    tel() { return this.inputType('tel'); }

    /** Set as URL input */
    url() { return this.inputType('url'); }

    /** Set as search input */
    search() { return this.inputType('search'); }

    /** Set as date input */
    date() { return this.inputType('date'); }

    /** Set as time input */
    time() { return this.inputType('time'); }

    /** Set as datetime-local input */
    datetime() { return this.inputType('datetime-local'); }

    /** Set as month input */
    month() { return this.inputType('month'); }

    /** Set as week input */
    week() { return this.inputType('week'); }

    /** Set as color input */
    color() { return this.inputType('color'); }

    /** Set as range input */
    range() { return this.inputType('range'); }

    // ==================
    // Fluent API - Constraints
    // ==================

    /**
     * Set minimum value
     * @param {*} min
     * @returns {this}
     */
    min(min) {
        this._min = min;
        return this;
    }

    /**
     * Set maximum value
     * @param {*} max
     * @returns {this}
     */
    max(max) {
        this._max = max;
        return this;
    }

    /**
     * Set step value
     * @param {*} step
     * @returns {this}
     */
    step(step) {
        this._step = step;
        return this;
    }

    /**
     * Set maximum length
     * @param {number} maxlength
     * @returns {this}
     */
    maxlength(maxlength) {
        this._maxlength = maxlength;
        return this;
    }

    /**
     * Set minimum length
     * @param {number} minlength
     * @returns {this}
     */
    minlength(minlength) {
        this._minlength = minlength;
        return this;
    }

    /**
     * Set validation pattern
     * @param {string} pattern
     * @returns {this}
     */
    pattern(pattern) {
        this._pattern = pattern;
        return this;
    }

    /**
     * Set autocomplete attribute
     * @param {string} autocomplete
     * @returns {this}
     */
    autocomplete(autocomplete) {
        this._autocomplete = autocomplete;
        return this;
    }

    /**
     * Disable autocomplete
     * @returns {this}
     */
    noAutocomplete() {
        return this.autocomplete('off');
    }

    /**
     * Set input prefix
     * @param {string} prefix
     * @returns {this}
     */
    prefix(prefix) {
        this._prefix = prefix;
        return this;
    }

    /**
     * Set input suffix
     * @param {string} suffix
     * @returns {this}
     */
    suffix(suffix) {
        this._suffix = suffix;
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
        return 'input';
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        attrs.type = this._inputType;

        if (this._min !== null) attrs.min = this._min;
        if (this._max !== null) attrs.max = this._max;
        if (this._step !== null) attrs.step = this._step;
        if (this._maxlength !== null) attrs.maxlength = this._maxlength;
        if (this._minlength !== null) attrs.minlength = this._minlength;
        if (this._pattern) attrs.pattern = this._pattern;
        if (this._autocomplete) attrs.autocomplete = this._autocomplete;

        return attrs;
    }

    /**
     * Render content (empty for input)
     * @returns {string}
     */
    renderContent() {
        return '';
    }

    /**
     * Render with prefix/suffix if needed
     * @returns {HTMLElement}
     */
    render() {
        // If no prefix/suffix, render normally
        if (!this._prefix && !this._suffix) {
            return super.render();
        }

        // Create input group wrapper
        const group = document.createElement('div');
        group.className = SixOrbit.cls('input-group');

        if (this._prefix) {
            const prefixEl = document.createElement('span');
            prefixEl.className = SixOrbit.cls('input-group-text');
            prefixEl.textContent = this._prefix;
            group.appendChild(prefixEl);
        }

        group.appendChild(super.render());

        if (this._suffix) {
            const suffixEl = document.createElement('span');
            suffixEl.className = SixOrbit.cls('input-group-text');
            suffixEl.textContent = this._suffix;
            group.appendChild(suffixEl);
        }

        return group;
    }

    /**
     * Render to HTML string
     * @returns {string}
     */
    toHtml() {
        if (!this._prefix && !this._suffix) {
            return super.toHtml();
        }

        // Build input HTML
        const inputHtml = super.toHtml();

        let html = `<div class="${SixOrbit.cls('input-group')}">`;

        if (this._prefix) {
            html += `<span class="${SixOrbit.cls('input-group-text')}">${this._escapeHtml(this._prefix)}</span>`;
        }

        html += inputHtml;

        if (this._suffix) {
            html += `<span class="${SixOrbit.cls('input-group-text')}">${this._escapeHtml(this._suffix)}</span>`;
        }

        html += '</div>';

        return html;
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

        if (this._inputType !== 'text') config.inputType = this._inputType;
        if (this._min !== null) config.min = this._min;
        if (this._max !== null) config.max = this._max;
        if (this._step !== null) config.step = this._step;
        if (this._maxlength !== null) config.maxlength = this._maxlength;
        if (this._minlength !== null) config.minlength = this._minlength;
        if (this._pattern) config.pattern = this._pattern;
        if (this._autocomplete) config.autocomplete = this._autocomplete;
        if (this._prefix) config.prefix = this._prefix;
        if (this._suffix) config.suffix = this._suffix;

        return config;
    }
}

export default Input;
export { Input };
