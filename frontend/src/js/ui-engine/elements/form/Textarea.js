// ============================================
// SIXORBIT UI ENGINE - TEXTAREA ELEMENT
// Multi-line text input
// ============================================

import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Textarea - Multi-line text input element
 */
class Textarea extends FormElement {
    static NAME = 'ui-textarea';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'textarea',
        tagName: 'textarea',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._rows = config.rows ?? 3;
        this._cols = config.cols ?? null;
        this._maxlength = config.maxlength ?? null;
        this._minlength = config.minlength ?? null;
        this._wrap = config.wrap || null;
        this._resize = config.resize ?? null;
        this._autoResize = config.autoResize ?? false;
        this._showCounter = config.showCounter ?? false;
    }

    // ==================
    // Fluent API - Dimensions
    // ==================

    /**
     * Set rows
     * @param {number} rows
     * @returns {this}
     */
    rows(rows) {
        this._rows = rows;
        return this;
    }

    /**
     * Set cols
     * @param {number} cols
     * @returns {this}
     */
    cols(cols) {
        this._cols = cols;
        return this;
    }

    // ==================
    // Fluent API - Constraints
    // ==================

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
     * Set wrap mode (hard, soft, off)
     * @param {string} wrap
     * @returns {this}
     */
    wrap(wrap) {
        this._wrap = wrap;
        return this;
    }

    // ==================
    // Fluent API - Resize
    // ==================

    /**
     * Set resize behavior
     * @param {string} direction - 'none', 'vertical', 'horizontal', 'both'
     * @returns {this}
     */
    resize(direction) {
        this._resize = direction;
        return this;
    }

    /**
     * Disable resize
     * @returns {this}
     */
    noResize() {
        return this.resize('none');
    }

    /**
     * Allow only vertical resizing
     * @returns {this}
     */
    resizeVertical() {
        return this.resize('vertical');
    }

    /**
     * Allow only horizontal resizing
     * @returns {this}
     */
    resizeHorizontal() {
        return this.resize('horizontal');
    }

    // ==================
    // Fluent API - Features
    // ==================

    /**
     * Enable auto-resize based on content
     * @param {boolean|string} enable - true/false or size variant ('sm', 'lg')
     * @returns {this}
     */
    autoResize(enable = true) {
        if (typeof enable === 'string') {
            this._autoResizeSize = enable;
            this._autoResize = true;
        } else {
            this._autoResize = enable;
        }
        return this;
    }

    /**
     * Show character counter
     * @param {boolean} show
     * @returns {this}
     */
    showCounter(show = true) {
        this._showCounter = show;
        return this;
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Get current value
     * @returns {string}
     */
    getValue() {
        if (this.element) {
            return this.element.value;
        }
        return this._value || '';
    }

    /**
     * Set value programmatically
     * @param {string} value
     * @returns {this}
     */
    setValue(value) {
        this._value = value;
        if (this.element) {
            this.element.value = value;
            this.element.dispatchEvent(new Event('input', { bubbles: true }));
            this._triggerAutoResize();
        }
        return this;
    }

    /**
     * Clear the textarea
     * @returns {this}
     */
    clear() {
        return this.setValue('');
    }

    /**
     * Get character count
     * @returns {number}
     */
    getCharCount() {
        return this.getValue().length;
    }

    /**
     * Check if at max length
     * @returns {boolean}
     */
    isAtMaxLength() {
        if (!this._maxlength) return false;
        return this.getCharCount() >= this._maxlength;
    }

    /**
     * Get remaining characters (if maxlength set)
     * @returns {number|null}
     */
    getRemainingChars() {
        if (!this._maxlength) return null;
        return this._maxlength - this.getCharCount();
    }

    /**
     * Check if empty
     * @returns {boolean}
     */
    isEmpty() {
        return this.getValue().trim() === '';
    }

    /**
     * Focus the textarea
     * @returns {this}
     */
    focus() {
        if (this.element) {
            this.element.focus();
        }
        return this;
    }

    /**
     * Blur the textarea
     * @returns {this}
     */
    blur() {
        if (this.element) {
            this.element.blur();
        }
        return this;
    }

    /**
     * Select all text
     * @returns {this}
     */
    selectAll() {
        if (this.element) {
            this.element.select();
        }
        return this;
    }

    /**
     * Set selection range
     * @param {number} start
     * @param {number} end
     * @returns {this}
     */
    setSelectionRange(start, end) {
        if (this.element) {
            this.element.setSelectionRange(start, end);
        }
        return this;
    }

    /**
     * Insert text at cursor position
     * @param {string} text
     * @returns {this}
     */
    insertAtCursor(text) {
        if (this.element) {
            const start = this.element.selectionStart;
            const end = this.element.selectionEnd;
            const value = this.element.value;
            this.element.value = value.substring(0, start) + text + value.substring(end);
            this.element.selectionStart = this.element.selectionEnd = start + text.length;
            this.element.dispatchEvent(new Event('input', { bubbles: true }));
            this._triggerAutoResize();
        }
        return this;
    }

    /**
     * Append text to end
     * @param {string} text
     * @returns {this}
     */
    append(text) {
        return this.setValue(this.getValue() + text);
    }

    /**
     * Prepend text to start
     * @param {string} text
     * @returns {this}
     */
    prepend(text) {
        return this.setValue(text + this.getValue());
    }

    /**
     * Enable the textarea
     * @returns {this}
     */
    enable() {
        this._disabled = false;
        if (this.element) {
            this.element.disabled = false;
            this.element.classList.remove(SixOrbit.cls('disabled'));
        }
        return this;
    }

    /**
     * Disable the textarea
     * @param {boolean} disable
     * @returns {this}
     */
    disable(disable = true) {
        this._disabled = disable;
        if (this.element) {
            this.element.disabled = disable;
            if (disable) {
                this.element.classList.add(SixOrbit.cls('disabled'));
            } else {
                this.element.classList.remove(SixOrbit.cls('disabled'));
            }
        }
        return this;
    }

    /**
     * Set rows dynamically
     * @param {number} count
     * @returns {this}
     */
    setRows(count) {
        this._rows = count;
        if (this.element) {
            this.element.rows = count;
        }
        return this;
    }

    /**
     * Trigger auto-resize (if enabled)
     * @private
     */
    _triggerAutoResize() {
        if (this.element && this._autoResize) {
            // Reset height to recalculate
            this.element.style.height = 'auto';
            this.element.style.height = this.element.scrollHeight + 'px';

            // Dispatch custom event
            const event = new CustomEvent(SixOrbit.evt('autosize'), {
                detail: { height: this.element.scrollHeight },
                bubbles: true
            });
            this.element.dispatchEvent(event);
        }
    }

    /**
     * Listen to input events
     * @param {Function} callback
     * @returns {this}
     */
    onInput(callback) {
        return this.on('input', callback);
    }

    /**
     * Listen to change events
     * @param {Function} callback
     * @returns {this}
     */
    onChange(callback) {
        return this.on('change', callback);
    }

    /**
     * Listen to focus events
     * @param {Function} callback
     * @returns {this}
     */
    onFocus(callback) {
        return this.on('focus', callback);
    }

    /**
     * Listen to blur events
     * @param {Function} callback
     * @returns {this}
     */
    onBlur(callback) {
        return this.on('blur', callback);
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Get tag name
     * @returns {string}
     */
    getTagName() {
        return 'textarea';
    }

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        super.buildClassString();

        // Add resize class if specified
        if (this._resize !== null) {
            this._extraClasses.add(SixOrbit.cls('resize-' + this._resize));
        }

        return Array.from(this._extraClasses).join(' ');
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        if (this._rows) attrs.rows = this._rows;
        if (this._cols) attrs.cols = this._cols;
        if (this._maxlength) attrs.maxlength = this._maxlength;
        if (this._minlength) attrs.minlength = this._minlength;
        if (this._wrap) attrs.wrap = this._wrap;

        if (this._autoResize) {
            attrs[SixOrbit.data('auto-resize')] = 'true';
        }

        if (this._showCounter && this._maxlength) {
            attrs[SixOrbit.data('counter')] = 'true';
        }

        // Remove value attribute (textarea uses content)
        delete attrs.value;

        return attrs;
    }

    /**
     * Don't render value as attribute
     * @returns {boolean}
     */
    _shouldRenderValueAttr() {
        return false;
    }

    /**
     * Render content (the textarea value)
     * @returns {string}
     */
    renderContent() {
        return this._value !== null ? this._escapeHtml(String(this._value)) : '';
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

        // Set content/value
        if (this._value !== null) {
            el.value = this._value;
        }

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

        if (this._rows !== 3) config.rows = this._rows;
        if (this._cols) config.cols = this._cols;
        if (this._maxlength) config.maxlength = this._maxlength;
        if (this._minlength) config.minlength = this._minlength;
        if (this._wrap) config.wrap = this._wrap;
        if (this._resize !== null) config.resize = this._resize;
        if (this._autoResize) config.autoResize = true;
        if (this._showCounter) config.showCounter = true;

        return config;
    }
}

export default Textarea;
export { Textarea };
