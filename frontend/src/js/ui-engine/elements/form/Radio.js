// ============================================
// SIXORBIT UI ENGINE - RADIO ELEMENT
// Radio button input with group support
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Radio - Radio button form element
 */
class Radio extends FormElement {
    static NAME = 'ui-radio';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'radio',
        tagName: 'input',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._checked = config.checked || false;
        this._inline = config.inline || false;
        this._options = config.options || [];
        this._buttonStyle = config.buttonStyle || false;
        this._buttonVariant = config.buttonVariant || 'outline-primary';
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set checked state
     * @param {boolean} checked
     * @returns {this}
     */
    checked(checked = true) {
        this._checked = checked;
        if (this.element) {
            this.element.checked = checked;
        }
        return this;
    }

    /**
     * Check if checked
     * @returns {boolean}
     */
    isChecked() {
        if (this.element) {
            return this.element.checked;
        }
        return this._checked;
    }

    /**
     * Set radio options
     * @param {Array} opts - Array of {value, label, checked?, disabled?}
     * @returns {this}
     */
    options(opts) {
        this._options = opts;
        return this;
    }

    /**
     * Add a single option
     * @param {string|number} value
     * @param {string} label
     * @returns {this}
     */
    option(value, label) {
        this._options.push({ value, label });
        return this;
    }

    /**
     * Render inline
     * @param {boolean} val
     * @returns {this}
     */
    inline(val = true) {
        this._inline = val;
        return this;
    }

    /**
     * Use button style (toggle buttons)
     * @param {boolean} val
     * @returns {this}
     */
    buttonStyle(val = true) {
        this._buttonStyle = val;
        return this;
    }

    /**
     * Set button variant (for button style)
     * @param {string} variant
     * @returns {this}
     */
    buttonVariant(variant) {
        this._buttonVariant = variant;
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
     * Build CSS classes (for input)
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('form-check-input'));

        if (this._error) {
            this._extraClasses.add(SixOrbit.cls('is-invalid'));
        }

        // Remove form-control
        this._extraClasses.delete(SixOrbit.cls('form-control'));

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        attrs.type = 'radio';
        if (this._checked) attrs.checked = true;

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
     * Render single radio to DOM
     * @param {Object} option
     * @param {number} index
     * @returns {HTMLElement}
     * @private
     */
    _renderSingleRadio(option, index) {
        const wrapper = document.createElement('div');
        wrapper.className = SixOrbit.cls('form-check');

        if (this._inline) {
            wrapper.classList.add(SixOrbit.cls('form-check-inline'));
        }

        const input = document.createElement('input');
        input.type = 'radio';
        input.className = SixOrbit.cls('form-check-input');
        input.name = this._name;
        input.value = option.value ?? option;
        input.id = `${this._id || this._name}-${index}`;

        if (option.checked || this._value == input.value) {
            input.checked = true;
        }

        if (option.disabled || this._disabled) {
            input.disabled = true;
        }

        wrapper.appendChild(input);

        const label = document.createElement('label');
        label.className = SixOrbit.cls('form-check-label');
        label.setAttribute('for', input.id);
        label.textContent = option.label ?? option;
        wrapper.appendChild(label);

        return wrapper;
    }

    /**
     * Render to DOM
     * @returns {HTMLElement}
     */
    render() {
        // If options provided, render radio group
        if (this._options && this._options.length > 0) {
            const container = document.createElement('div');
            container.className = SixOrbit.cls('radio-group');

            this._options.forEach((opt, index) => {
                container.appendChild(this._renderSingleRadio(opt, index));
            });

            return container;
        }

        // Single radio
        const wrapper = document.createElement('div');
        wrapper.className = SixOrbit.cls('form-check');

        if (this._inline) {
            wrapper.classList.add(SixOrbit.cls('form-check-inline'));
        }

        const input = document.createElement('input');
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                input.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                input.setAttribute(name, value);
            }
        });

        wrapper.appendChild(input);
        this.element = input;

        if (this._label) {
            const label = document.createElement('label');
            label.className = SixOrbit.cls('form-check-label');
            label.textContent = this._label;
            if (this._id) {
                label.setAttribute('for', this._id);
            }
            wrapper.appendChild(label);
        }

        this._attachEventHandlers();
        return wrapper;
    }

    /**
     * Render to HTML string
     * @returns {string}
     */
    toHtml() {
        // If options provided, render radio group
        if (this._options && this._options.length > 0) {
            // Button style uses btn-group wrapper
            if (this._buttonStyle) {
                let html = `<div class="${SixOrbit.cls('btn-group')}" role="group">`;

                this._options.forEach((opt, index) => {
                    const value = opt.value ?? opt;
                    const label = opt.label ?? opt;
                    const id = `${this._id || this._name}-${index}`;
                    const checked = (opt.checked || this._value == value) ? ' checked' : '';
                    const disabled = (opt.disabled || this._disabled) ? ' disabled' : '';

                    html += `<input type="radio" class="${SixOrbit.cls('btn-check')}" name="${this._escapeHtml(this._name)}" value="${this._escapeHtml(String(value))}" id="${this._escapeHtml(id)}" autocomplete="off"${checked}${disabled}>`;
                    html += `<label class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn', this._buttonVariant)}" for="${this._escapeHtml(id)}">${this._escapeHtml(String(label))}</label>`;
                });

                html += '</div>';
                return html;
            }

            // Standard radio group
            let html = `<div class="${SixOrbit.cls('radio-group')}">`;

            this._options.forEach((opt, index) => {
                const value = opt.value ?? opt;
                const label = opt.label ?? opt;
                const id = `${this._id || this._name}-${index}`;
                const checked = (opt.checked || this._value == value) ? ' checked' : '';
                const disabled = (opt.disabled || this._disabled) ? ' disabled' : '';
                const inlineClass = this._inline ? ` ${SixOrbit.cls('form-check-inline')}` : '';

                html += `<div class="${SixOrbit.cls('form-check')}${inlineClass}">`;
                html += `<input type="radio" class="${SixOrbit.cls('form-check-input')}" name="${this._escapeHtml(this._name)}" value="${this._escapeHtml(String(value))}" id="${this._escapeHtml(id)}"${checked}${disabled}>`;
                html += `<label class="${SixOrbit.cls('form-check-label')}" for="${this._escapeHtml(id)}">${this._escapeHtml(String(label))}</label>`;
                html += '</div>';
            });

            html += '</div>';
            return html;
        }

        // Single radio
        const inlineClass = this._inline ? ` ${SixOrbit.cls('form-check-inline')}` : '';
        const attrs = this.buildAttributes();
        let attrStr = Object.entries(attrs)
            .filter(([, v]) => v !== false && v !== null && v !== undefined)
            .map(([k, v]) => v === true ? k : `${k}="${this._escapeHtml(String(v))}"`)
            .join(' ');

        let html = `<div class="${SixOrbit.cls('form-check')}${inlineClass}">`;
        html += `<input ${attrStr}>`;

        if (this._label) {
            const forAttr = this._id ? ` for="${this._escapeHtml(this._id)}"` : '';
            html += `<label class="${SixOrbit.cls('form-check-label')}"${forAttr}>${this._escapeHtml(this._label)}</label>`;
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

        if (this._checked) config.checked = true;
        if (this._inline) config.inline = true;
        if (this._options && this._options.length > 0) config.options = this._options;
        if (this._buttonStyle) {
            config.buttonStyle = true;
            config.buttonVariant = this._buttonVariant;
        }

        return config;
    }
}

export default Radio;
export { Radio };
