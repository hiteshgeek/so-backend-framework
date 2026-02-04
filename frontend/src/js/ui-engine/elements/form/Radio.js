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
        // For button style, add btn-check class
        if (this._buttonStyle) {
            this._extraClasses.add(SixOrbit.cls('btn-check'));
        }

        // Remove form-control (standard radio uses wrapper label pattern, no input class needed)
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
     * Render to DOM (matches PHP structure)
     * @returns {HTMLElement}
     */
    render() {
        // If options provided, render radio group
        if (this._options && this._options.length > 0) {
            const container = document.createElement('div');
            container.className = SixOrbit.cls('form-group');

            // Group label
            if (this._label) {
                const labelEl = document.createElement('label');
                labelEl.className = `${SixOrbit.cls('form-label')} ${SixOrbit.cls('mb-2')}`;
                labelEl.textContent = this._label;
                if (this._required) {
                    const required = document.createElement('span');
                    required.className = SixOrbit.cls('text-danger');
                    required.textContent = ' *';
                    labelEl.appendChild(required);
                }
                container.appendChild(labelEl);
            }

            // Button group or radio group wrapper
            const groupWrapper = document.createElement('div');
            if (this._buttonStyle) {
                groupWrapper.className = SixOrbit.cls('btn-group');
                groupWrapper.setAttribute('role', 'group');
            } else {
                groupWrapper.className = this._inline
                    ? `${SixOrbit.cls('radio-group')} ${SixOrbit.cls('radio-group-inline')}`
                    : `${SixOrbit.cls('radio-group')} ${SixOrbit.cls('radio-group-vertical')}`;
            }

            // Radio buttons
            this._options.forEach((opt, index) => {
                const value = opt.value ?? index;
                const label = opt.label ?? value;
                const disabled = opt.disabled ?? false;
                const optionId = this._id ? `${this._id}_${index}` : `${this._name}_${index}`;
                const checked = this._isSelected(value);

                if (this._buttonStyle) {
                    // Button style radio
                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.className = SixOrbit.cls('btn-check');
                    input.name = this._name;
                    input.id = optionId;
                    input.value = value;
                    input.setAttribute('autocomplete', 'off');
                    if (checked) input.checked = true;
                    if (disabled || this._disabled) input.disabled = true;
                    groupWrapper.appendChild(input);

                    const labelEl = document.createElement('label');
                    labelEl.className = `${SixOrbit.cls('btn')} ${SixOrbit.cls('btn', this._buttonVariant)}`;
                    labelEl.setAttribute('for', optionId);
                    labelEl.textContent = label;
                    groupWrapper.appendChild(labelEl);
                } else {
                    // Standard radio with so-radio structure
                    const wrapper = document.createElement('label');
                    wrapper.className = SixOrbit.cls('radio');
                    if (disabled || this._disabled) {
                        wrapper.classList.add(SixOrbit.cls('disabled'));
                    }
                    if (this._error) {
                        wrapper.classList.add(SixOrbit.cls('is-invalid'));
                    }

                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.name = this._name;
                    input.value = value;
                    if (checked) input.checked = true;
                    if (disabled || this._disabled) input.disabled = true;
                    if (this._required) input.required = true;
                    wrapper.appendChild(input);

                    const circle = document.createElement('span');
                    circle.className = SixOrbit.cls('radio-circle');
                    wrapper.appendChild(circle);

                    const labelSpan = document.createElement('span');
                    labelSpan.className = SixOrbit.cls('radio-label');
                    labelSpan.textContent = label;
                    wrapper.appendChild(labelSpan);

                    groupWrapper.appendChild(wrapper);
                }
            });

            container.appendChild(groupWrapper);

            // Help text
            if (this._help) {
                const helpEl = document.createElement('div');
                helpEl.className = SixOrbit.cls('form-text');
                helpEl.textContent = this._help;
                container.appendChild(helpEl);
            }

            // Error
            if (this._error) {
                const errorEl = document.createElement('div');
                errorEl.className = `${SixOrbit.cls('invalid-feedback')} ${SixOrbit.cls('d-block')}`;
                errorEl.textContent = this._error;
                container.appendChild(errorEl);
            }

            this.element = container;
            this._attachEventHandlers();
            return container;
        }

        // Single radio (fallback - rarely used)
        const input = document.createElement('input');
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                input.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                input.setAttribute(name, value);
            }
        });

        this.element = input;
        this._attachEventHandlers();
        return input;
    }

    /**
     * Render a standard radio option (matches PHP)
     * @param {string} id
     * @param {*} value
     * @param {string} label
     * @param {boolean} checked
     * @param {boolean} disabled
     * @returns {string}
     * @private
     */
    _renderStandardOption(id, value, label, checked, disabled) {
        // Wrapper label with so-radio class
        let labelClass = SixOrbit.cls('radio');
        if (disabled || this._disabled) {
            labelClass += ` ${SixOrbit.cls('disabled')}`;
        }
        if (this._error) {
            labelClass += ` ${SixOrbit.cls('is-invalid')}`;
        }

        let html = `<label class="${labelClass}">`;

        // Hidden input
        html += '<input type="radio"';
        html += ` name="${this._escapeHtml(this._name)}"`;
        html += ` value="${this._escapeHtml(String(value))}"`;

        if (checked) {
            html += ' checked';
        }

        if (disabled || this._disabled) {
            html += ' disabled';
        }

        if (this._required) {
            html += ' required';
        }

        html += '>';

        // Visual circle indicator
        html += `<span class="${SixOrbit.cls('radio-circle')}"></span>`;

        // Label text
        html += `<span class="${SixOrbit.cls('radio-label')}">${this._escapeHtml(String(label))}</span>`;

        html += '</label>';

        return html;
    }

    /**
     * Render a button-style radio option (matches PHP)
     * @param {string} id
     * @param {*} value
     * @param {string} label
     * @param {boolean} checked
     * @param {boolean} disabled
     * @returns {string}
     * @private
     */
    _renderButtonOption(id, value, label, checked, disabled) {
        let html = '';

        // Input (hidden visually)
        html += '<input type="radio"';
        html += ` class="${SixOrbit.cls('btn-check')}"`;
        html += ` name="${this._escapeHtml(this._name)}"`;
        html += ` id="${this._escapeHtml(id)}"`;
        html += ` value="${this._escapeHtml(String(value))}"`;
        html += ' autocomplete="off"';

        if (checked) {
            html += ' checked';
        }

        if (disabled || this._disabled) {
            html += ' disabled';
        }

        html += '>';

        // Label as button
        html += `<label class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn', this._buttonVariant)}" for="${this._escapeHtml(id)}">${this._escapeHtml(String(label))}</label>`;

        return html;
    }

    /**
     * Check if a value is selected
     * @param {*} value
     * @returns {boolean}
     * @private
     */
    _isSelected(value) {
        if (this._value === null || this._value === undefined) {
            return false;
        }
        return String(this._value) === String(value);
    }

    /**
     * Render to HTML string (matches PHP Radio.render())
     * @returns {string}
     */
    toHtml() {
        // If options provided, render radio group (PHP structure)
        if (this._options && this._options.length > 0) {
            let html = `<div class="${SixOrbit.cls('form-group')}">`;

            // Group label
            if (this._label) {
                html += `<label class="${SixOrbit.cls('form-label')} ${SixOrbit.cls('mb-2')}">${this._escapeHtml(this._label)}`;
                if (this._required) {
                    html += ` <span class="${SixOrbit.cls('text-danger')}">*</span>`;
                }
                html += '</label>';
            }

            // Button group wrapper for button style
            if (this._buttonStyle) {
                html += `<div class="${SixOrbit.cls('btn-group')}" role="group">`;
            } else {
                // Radio group wrapper
                let groupClass = SixOrbit.cls('radio-group');
                groupClass += this._inline
                    ? ` ${SixOrbit.cls('radio-group-inline')}`
                    : ` ${SixOrbit.cls('radio-group-vertical')}`;
                html += `<div class="${groupClass}">`;
            }

            // Radio buttons
            this._options.forEach((opt, index) => {
                const value = opt.value ?? index;
                const label = opt.label ?? value;
                const disabled = opt.disabled ?? false;
                const optionId = this._id ? `${this._id}_${index}` : `${this._name}_${index}`;
                const checked = this._isSelected(value);

                if (this._buttonStyle) {
                    html += this._renderButtonOption(optionId, value, label, checked, disabled);
                } else {
                    html += this._renderStandardOption(optionId, value, label, checked, disabled);
                }
            });

            // Close group wrapper
            html += '</div>';

            // Help text
            if (this._help) {
                html += `<div class="${SixOrbit.cls('form-text')}">${this._escapeHtml(this._help)}</div>`;
            }

            // Error
            if (this._error) {
                html += `<div class="${SixOrbit.cls('invalid-feedback')} ${SixOrbit.cls('d-block')}">${this._escapeHtml(this._error)}</div>`;
            }

            html += '</div>';

            return html;
        }

        // Single radio (fallback - rarely used)
        const attrs = this.buildAttributes();
        let attrStr = Object.entries(attrs)
            .filter(([, v]) => v !== false && v !== null && v !== undefined)
            .map(([k, v]) => v === true ? k : `${k}="${this._escapeHtml(String(v))}"`)
            .join(' ');

        return `<input ${attrStr}>`;
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
