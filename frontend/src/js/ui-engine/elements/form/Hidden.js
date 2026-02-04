// ============================================
// SIXORBIT UI ENGINE - HIDDEN INPUT ELEMENT
// Hidden form field
// ============================================

import { FormElement } from '../../core/FormElement.js';

/**
 * Hidden - Hidden input element
 */
class Hidden extends FormElement {
    static NAME = 'ui-hidden';

    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: 'hidden',
        tagName: 'input',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);
        // Hidden inputs don't need label, placeholder, etc.
        this._label = null;
        this._placeholder = null;
        this._help = null;
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
     * Build CSS classes (hidden inputs have no visual classes)
     * @returns {string}
     */
    buildClassString() {
        // Don't add form-control class
        this._extraClasses.delete('so-form-control');
        return Array.from(this._extraClasses).join(' ');
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = {};

        // ID
        if (this._id) attrs.id = this._id;

        // Name and value
        if (this._name) attrs.name = this._name;
        if (this._value !== null) attrs.value = this._value;

        // Type
        attrs.type = 'hidden';

        // Custom attributes
        this._extraAttributes.forEach((value, key) => {
            attrs[key] = value;
        });

        // Data attributes
        this._dataAttributes.forEach((value, key) => {
            attrs[`data-${this._kebabCase(key)}`] = value;
        });

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
     * Render without wrapper
     * @returns {HTMLElement}
     */
    render() {
        const el = document.createElement(this.getTagName());

        const attrs = this.buildAttributes();
        Object.entries(attrs).forEach(([name, value]) => {
            if (value === true) {
                el.setAttribute(name, '');
            } else if (value !== false && value !== null && value !== undefined) {
                el.setAttribute(name, value);
            }
        });

        this.element = el;
        return el;
    }

    /**
     * Render group (just the input, no wrapper needed)
     * @returns {HTMLElement}
     */
    renderGroup() {
        return this.render();
    }
}

export default Hidden;
export { Hidden };
