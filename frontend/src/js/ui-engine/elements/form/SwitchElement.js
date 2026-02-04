// ============================================
// SIXORBIT UI ENGINE - SWITCH ELEMENT
// Toggle switch input matching PHP SwitchElement
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * SwitchElement - Toggle switch input
 *
 * Generates the following DOM structure:
 * <label class="so-switch so-switch-primary">
 *     <input type="checkbox" name="..." id="...">
 *     <span class="so-switch-track"></span>
 *     <span class="so-switch-label">Label text</span>
 * </label>
 *
 * With icons:
 * <label class="so-switch so-switch-icon so-switch-success">
 *     <input type="checkbox">
 *     <span class="so-switch-track">
 *         <span class="so-switch-on"><span class="material-icons">check</span></span>
 *         <span class="so-switch-off"><span class="material-icons">close</span></span>
 *     </span>
 *     <span class="so-switch-label">Icon switch</span>
 * </label>
 */
class SwitchElement extends FormElement {
    static NAME = 'ui-switch';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'switch',
        tagName: 'label', // Wrapper is a label
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._checked = config.checked || false;
        this._variant = config.variant || 'primary';
        this._switchSize = config.switchSize || null;
        this._iconMode = config.iconMode || false;
        this._textMode = config.textMode || false;
        this._onLabel = config.onLabel || 'ON';
        this._offLabel = config.offLabel || 'OFF';
        this._onIcon = config.onIcon || 'check';
        this._offIcon = config.offIcon || 'close';
        this._title = config.title || null;
        this._description = config.description || null;
    }

    // ==================
    // Fluent API - State
    // ==================

    /**
     * Set checked state
     * @param {boolean} val
     * @returns {this}
     */
    checked(val = true) {
        this._checked = val;
        return this;
    }

    /**
     * Set unchecked state
     * @returns {this}
     */
    unchecked() {
        return this.checked(false);
    }

    // ==================
    // Fluent API - Variant
    // ==================

    /**
     * Set variant/color
     * @param {string} v
     * @returns {this}
     */
    variant(v) {
        this._variant = v;
        return this;
    }

    /**
     * Alias for variant
     * @param {string} c
     * @returns {this}
     */
    color(c) {
        return this.variant(c);
    }

    primary() { return this.variant('primary'); }
    secondary() { return this.variant('secondary'); }
    success() { return this.variant('success'); }
    danger() { return this.variant('danger'); }
    warning() { return this.variant('warning'); }
    info() { return this.variant('info'); }

    // ==================
    // Fluent API - Size
    // ==================

    /**
     * Set switch size
     * @param {string} s - sm|lg
     * @returns {this}
     */
    size(s) {
        this._switchSize = s;
        return this;
    }

    small() { return this.size('sm'); }
    large() { return this.size('lg'); }
    sm() { return this.size('sm'); }
    lg() { return this.size('lg'); }

    // ==================
    // Fluent API - Display Modes
    // ==================

    /**
     * Enable icon mode
     * @param {boolean} enable
     * @returns {this}
     */
    icon(enable = true) {
        this._iconMode = enable;
        return this;
    }

    /**
     * Enable text mode
     * @param {boolean} enable
     * @returns {this}
     */
    text(enable = true) {
        this._textMode = enable;
        return this;
    }

    /**
     * Set on icon (Material icon name)
     * @param {string} iconName
     * @returns {this}
     */
    onIcon(iconName) {
        this._onIcon = iconName;
        this._iconMode = true;
        return this;
    }

    /**
     * Set off icon (Material icon name)
     * @param {string} iconName
     * @returns {this}
     */
    offIcon(iconName) {
        this._offIcon = iconName;
        this._iconMode = true;
        return this;
    }

    /**
     * Set on text
     * @param {string} text
     * @returns {this}
     */
    onText(text) {
        this._onLabel = text;
        this._textMode = true;
        return this;
    }

    /**
     * Set off text
     * @param {string} text
     * @returns {this}
     */
    offText(text) {
        this._offLabel = text;
        this._textMode = true;
        return this;
    }

    /**
     * Set on/off labels
     * @param {string} on
     * @param {string} off
     * @returns {this}
     */
    labels(on, off) {
        this._onLabel = on;
        this._offLabel = off;
        this._textMode = true;
        return this;
    }

    /**
     * Set title for settings layout
     * @param {string} title
     * @returns {this}
     */
    title(title) {
        this._title = title;
        return this;
    }

    /**
     * Set description for settings layout
     * @param {string} desc
     * @returns {this}
     */
    description(desc) {
        this._description = desc;
        return this;
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Toggle the switch state
     * @returns {this}
     */
    toggle() {
        if (this.element) {
            const input = this.element.querySelector('input[type="checkbox"]');
            if (input) {
                input.checked = !input.checked;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
        this._checked = !this._checked;
        return this;
    }

    /**
     * Get current checked state
     * @returns {boolean}
     */
    isChecked() {
        if (this.element) {
            const input = this.element.querySelector('input[type="checkbox"]');
            return input ? input.checked : this._checked;
        }
        return this._checked;
    }

    /**
     * Set checked state programmatically
     * @param {boolean} val
     * @returns {this}
     */
    setChecked(val) {
        this._checked = val;
        if (this.element) {
            const input = this.element.querySelector('input[type="checkbox"]');
            if (input) {
                input.checked = val;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
        return this;
    }

    /**
     * Listen to change events
     * @param {Function} callback
     * @returns {this}
     */
    onChange(callback) {
        return this.on('change', (e) => {
            callback(e.target.checked, e);
        });
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name (wrapper label)
     * @returns {string}
     */
    getTagName() {
        return 'label';
    }

    /**
     * Build wrapper CSS classes
     * @returns {string}
     */
    buildClassString() {
        const classes = new Set();

        classes.add(SixOrbit.cls('switch'));

        // Size variant
        if (this._switchSize) {
            classes.add(SixOrbit.cls('switch', this._switchSize));
        }

        // Color variant
        classes.add(SixOrbit.cls('switch', this._variant));

        // Display modes
        if (this._iconMode) {
            classes.add(SixOrbit.cls('switch-icon'));
        }
        if (this._textMode) {
            classes.add(SixOrbit.cls('switch-text'));
        }
        if (this._iconMode && this._textMode) {
            classes.add(SixOrbit.cls('switch-icon-text'));
        }

        // Disabled
        if (this._disabled) {
            classes.add(SixOrbit.cls('disabled'));
        }

        // Add user-defined classes
        this._extraClasses.forEach(cls => classes.add(cls));

        return Array.from(classes).join(' ');
    }

    /**
     * Build wrapper attributes (minimal for label)
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = {};

        // Custom data attributes
        Object.entries(this._dataAttributes).forEach(([key, value]) => {
            attrs[SixOrbit.data(key)] = value;
        });

        return attrs;
    }

    /**
     * Render content (input, track, and label)
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Render input
        html += this._renderInput();

        // Render track
        html += this._renderTrack();

        // Render label text
        if (this._label) {
            html += `<span class="${SixOrbit.cls('switch-label')}">${this._escapeHtml(this._label)}</span>`;
        }

        return html;
    }

    /**
     * Render the checkbox input
     * @returns {string}
     * @private
     */
    _renderInput() {
        const attrs = {
            type: 'checkbox'
        };

        if (this._id) {
            attrs.id = this._id;
        }

        if (this._name) {
            attrs.name = this._name;
        }

        if (this._checked) {
            attrs.checked = true;
        }

        if (this._disabled) {
            attrs.disabled = true;
        }

        if (this._value !== null && this._value !== undefined) {
            attrs.value = this._value;
        }

        return this._buildInputTag(attrs);
    }

    /**
     * Build an input tag from attributes
     * @param {Object} attrs
     * @returns {string}
     * @private
     */
    _buildInputTag(attrs) {
        let html = '<input';

        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                html += ` ${name}`;
            } else if (value !== false && value !== null && value !== undefined) {
                html += ` ${name}="${this._escapeHtml(String(value))}"`;
            }
        });

        html += '>';

        return html;
    }

    /**
     * Render the track structure
     * @returns {string}
     * @private
     */
    _renderTrack() {
        let html = `<span class="${SixOrbit.cls('switch-track')}">`;

        // Add inner content for icon/text modes
        if (this._iconMode || this._textMode) {
            // On state content
            html += `<span class="${SixOrbit.cls('switch-on')}">`;
            if (this._iconMode) {
                html += `<span class="material-icons">${this._escapeHtml(this._onIcon)}</span>`;
            }
            if (this._textMode) {
                html += this._escapeHtml(this._onLabel);
            }
            html += '</span>';

            // Off state content
            html += `<span class="${SixOrbit.cls('switch-off')}">`;
            if (this._textMode) {
                html += this._escapeHtml(this._offLabel);
            }
            if (this._iconMode) {
                html += `<span class="material-icons">${this._escapeHtml(this._offIcon)}</span>`;
            }
            html += '</span>';
        }

        html += '</span>';

        return html;
    }

    /**
     * Render to DOM element
     * @returns {HTMLElement}
     */
    render() {
        const el = document.createElement(this.getTagName());

        // Apply classes
        el.className = this.buildClassString();

        // Apply attributes
        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true || value === '') {
                el.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                el.setAttribute(name, value);
            }
        });

        // Add content (input, track, label)
        el.innerHTML = this.renderContent();

        this.element = el;
        this._attachEventHandlers();
        return el;
    }

    /**
     * Render as setting item (for settings pages)
     * @returns {string}
     */
    toSettingItem() {
        const switchHtml = this.toHtml();

        let html = `<div class="${SixOrbit.cls('list-group-item')} ${SixOrbit.cls('d-flex')} ${SixOrbit.cls('justify-content-between')} ${SixOrbit.cls('align-items-center')}">`;
        html += '<div>';
        if (this._title) {
            html += `<div class="${SixOrbit.cls('fw-medium')}">${this._escapeHtml(this._title)}</div>`;
        }
        if (this._description) {
            html += `<small class="${SixOrbit.cls('text-muted')}">${this._escapeHtml(this._description)}</small>`;
        }
        html += '</div>';
        html += switchHtml.replace('class="' + SixOrbit.cls('switch'), 'class="' + SixOrbit.cls('switch') + ' ' + SixOrbit.cls('mb-0'));
        html += '</div>';

        return html;
    }

    /**
     * Render setting item to DOM element
     * @returns {HTMLElement}
     */
    renderSettingItem() {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = this.toSettingItem();
        return wrapper.firstElementChild;
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

        if (this._checked) config.checked = true;
        if (this._variant !== 'primary') config.variant = this._variant;
        if (this._switchSize) config.switchSize = this._switchSize;

        if (this._iconMode) {
            config.iconMode = true;
            config.onIcon = this._onIcon;
            config.offIcon = this._offIcon;
        }

        if (this._textMode) {
            config.textMode = true;
            config.onLabel = this._onLabel;
            config.offLabel = this._offLabel;
        }

        if (this._title) config.title = this._title;
        if (this._description) config.description = this._description;

        return config;
    }
}

// Also export as Toggle for backwards compatibility
const Toggle = SwitchElement;

export default SwitchElement;
export { SwitchElement, Toggle };
