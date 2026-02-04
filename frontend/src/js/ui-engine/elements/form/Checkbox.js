// ============================================
// SIXORBIT UI ENGINE - CHECKBOX ELEMENT
// Checkbox input with label support
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Checkbox - Checkbox form element
 * Supports single checkbox and checkbox groups
 */
class Checkbox extends FormElement {
    static NAME = 'ui-checkbox';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'checkbox',
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
        this._indeterminate = config.indeterminate || false;
        this._switch = config.switch || false;
        this._inline = config.inline || false;
        this._options = config.options || [];
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set checked state
     * @param {boolean} val
     * @returns {this}
     */
    checked(val = true) {
        this._checked = val;
        if (this.element) {
            this.element.checked = val;
        }
        return this;
    }

    /**
     * Set unchecked state
     * @returns {this}
     */
    unchecked() {
        return this.checked(false);
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
     * Set indeterminate state
     * @param {boolean} val
     * @returns {this}
     */
    indeterminate(val = true) {
        this._indeterminate = val;
        if (this.element) {
            this.element.indeterminate = val;
        }
        return this;
    }

    /**
     * Render as switch style
     * @param {boolean} val
     * @returns {this}
     */
    switch(val = true) {
        this._switch = val;
        return this;
    }

    /**
     * Display inline
     * @param {boolean} val
     * @returns {this}
     */
    inline(val = true) {
        this._inline = val;
        return this;
    }

    /**
     * Set checkbox options (for groups)
     * @param {Array} options - Array of {value, label, checked?, disabled?}
     * @returns {this}
     */
    options(options) {
        this._options = options;
        return this;
    }

    /**
     * Add a single option
     * @param {string|number} value
     * @param {string} label
     * @param {boolean} checked
     * @returns {this}
     */
    option(value, label, checked = false) {
        this._options.push({ value, label, checked });
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build attributes for the input element
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = {};

        attrs.type = 'checkbox';

        if (this._name) {
            attrs.name = this._name;
        }

        if (this._id) {
            attrs.id = this._id;
        }

        if (this._value !== null && this._value !== undefined) {
            attrs.value = this._value;
        }

        if (this._checked) {
            attrs.checked = true;
        }

        if (this._disabled) {
            attrs.disabled = true;
        }

        if (this._indeterminate) {
            attrs[SixOrbit.data('indeterminate')] = 'true';
        }

        return attrs;
    }

    /**
     * Render to DOM with proper so-checkbox structure
     * @returns {HTMLElement}
     */
    render() {
        // If options are set, render as a group
        if (this._options.length > 0) {
            return this._renderCheckboxGroup();
        }

        // Single checkbox
        return this._renderSingleCheckbox();
    }

    /**
     * Render a single checkbox
     * @returns {HTMLElement}
     * @private
     */
    _renderSingleCheckbox() {
        // Create wrapper label
        const wrapper = document.createElement('label');
        wrapper.className = SixOrbit.cls('checkbox');

        if (this._disabled) {
            wrapper.classList.add(SixOrbit.cls('disabled'));
        }

        // Create input
        const input = document.createElement('input');
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                input.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                input.setAttribute(name, value);
            }
        });

        if (this._indeterminate) {
            input.indeterminate = true;
        }

        wrapper.appendChild(input);
        this.element = input;

        // Create checkbox box with icon
        const box = document.createElement('span');
        box.className = SixOrbit.cls('checkbox-box');

        const icon = document.createElement('span');
        icon.className = 'material-icons';
        icon.textContent = this._indeterminate ? 'remove' : 'check';
        box.appendChild(icon);

        wrapper.appendChild(box);

        // Create label text
        if (this._label) {
            const labelSpan = document.createElement('span');
            labelSpan.className = SixOrbit.cls('checkbox-label');
            labelSpan.textContent = this._label;
            wrapper.appendChild(labelSpan);
        }

        this._attachEventHandlers();
        return wrapper;
    }

    /**
     * Render checkbox group
     * @returns {HTMLElement}
     * @private
     */
    _renderCheckboxGroup() {
        const container = document.createElement('div');
        container.className = SixOrbit.cls('form-group');

        // Group label
        if (this._label) {
            const groupLabel = document.createElement('label');
            groupLabel.className = `${SixOrbit.cls('form-label')} ${SixOrbit.cls('mb-2')}`;
            groupLabel.textContent = this._label;
            container.appendChild(groupLabel);
        }

        // Checkbox group wrapper
        const group = document.createElement('div');
        group.className = SixOrbit.cls('checkbox-group');
        group.classList.add(this._inline
            ? SixOrbit.cls('checkbox-group-inline')
            : SixOrbit.cls('checkbox-group-vertical')
        );

        // Render each option
        this._options.forEach((opt, index) => {
            const value = opt.value ?? index;
            const label = opt.label ?? value;
            const checked = opt.checked ?? false;
            const optDisabled = opt.disabled ?? false;
            const isDisabled = optDisabled || this._disabled;

            const wrapper = document.createElement('label');
            wrapper.className = SixOrbit.cls('checkbox');
            if (isDisabled) {
                wrapper.classList.add(SixOrbit.cls('disabled'));
            }

            // Input
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.name = `${this._name}[]`;
            input.value = value;
            if (checked) input.checked = true;
            if (isDisabled) input.disabled = true;

            wrapper.appendChild(input);

            // Checkbox box with icon
            const box = document.createElement('span');
            box.className = SixOrbit.cls('checkbox-box');
            const icon = document.createElement('span');
            icon.className = 'material-icons';
            icon.textContent = 'check';
            box.appendChild(icon);
            wrapper.appendChild(box);

            // Label text
            const labelSpan = document.createElement('span');
            labelSpan.className = SixOrbit.cls('checkbox-label');
            labelSpan.textContent = label;
            wrapper.appendChild(labelSpan);

            group.appendChild(wrapper);
        });

        container.appendChild(group);

        return container;
    }

    /**
     * Render to HTML string
     * @returns {string}
     */
    toHtml() {
        // If options are set, render as a group
        if (this._options.length > 0) {
            return this._toHtmlGroup();
        }

        // Single checkbox
        return this._toHtmlSingle();
    }

    /**
     * Render single checkbox to HTML
     * @returns {string}
     * @private
     */
    _toHtmlSingle() {
        const labelClass = this._disabled
            ? `${SixOrbit.cls('checkbox')} ${SixOrbit.cls('disabled')}`
            : SixOrbit.cls('checkbox');

        const attrs = this.buildAttributes();
        const attrStr = Object.entries(attrs)
            .filter(([, v]) => v !== false && v !== null && v !== undefined)
            .map(([k, v]) => v === true ? k : `${k}="${this._escapeHtml(String(v))}"`)
            .join(' ');

        const icon = this._indeterminate ? 'remove' : 'check';

        let html = `<label class="${labelClass}">`;
        html += `<input ${attrStr}>`;
        html += `<span class="${SixOrbit.cls('checkbox-box')}">`;
        html += `<span class="material-icons">${icon}</span>`;
        html += '</span>';

        if (this._label) {
            html += `<span class="${SixOrbit.cls('checkbox-label')}">${this._escapeHtml(this._label)}</span>`;
        }

        html += '</label>';

        return html;
    }

    /**
     * Render checkbox group to HTML
     * @returns {string}
     * @private
     */
    _toHtmlGroup() {
        let html = `<div class="${SixOrbit.cls('form-group')}">`;

        // Group label
        if (this._label) {
            html += `<label class="${SixOrbit.cls('form-label')} ${SixOrbit.cls('mb-2')}">${this._escapeHtml(this._label)}</label>`;
        }

        // Checkbox group wrapper
        const groupClass = this._inline
            ? `${SixOrbit.cls('checkbox-group')} ${SixOrbit.cls('checkbox-group-inline')}`
            : `${SixOrbit.cls('checkbox-group')} ${SixOrbit.cls('checkbox-group-vertical')}`;

        html += `<div class="${groupClass}">`;

        // Render each option
        this._options.forEach((opt, index) => {
            const value = opt.value ?? index;
            const label = opt.label ?? value;
            const checked = opt.checked ?? false;
            const optDisabled = opt.disabled ?? false;
            const isDisabled = optDisabled || this._disabled;

            const labelClass = isDisabled
                ? `${SixOrbit.cls('checkbox')} ${SixOrbit.cls('disabled')}`
                : SixOrbit.cls('checkbox');

            html += `<label class="${labelClass}">`;
            html += `<input type="checkbox" name="${this._escapeHtml(this._name)}[]" value="${this._escapeHtml(String(value))}"`;
            if (checked) html += ' checked';
            if (isDisabled) html += ' disabled';
            html += '>';
            html += `<span class="${SixOrbit.cls('checkbox-box')}">`;
            html += '<span class="material-icons">check</span>';
            html += '</span>';
            html += `<span class="${SixOrbit.cls('checkbox-label')}">${this._escapeHtml(label)}</span>`;
            html += '</label>';
        });

        html += '</div>'; // End checkbox-group
        html += '</div>'; // End form-group

        return html;
    }

    /**
     * Get value
     * @returns {*}
     */
    getValue() {
        if (this.element) {
            return this.element.checked;
        }
        return this._checked;
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
        if (this._indeterminate) config.indeterminate = true;
        if (this._switch) config.switch = true;
        if (this._inline) config.inline = true;
        if (this._options.length > 0) config.options = this._options;

        return config;
    }
}

export default Checkbox;
export { Checkbox };
