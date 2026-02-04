// ============================================
// SIXORBIT UI ENGINE - RATING ELEMENT
// Star rating
// ============================================

import { Element } from '../../core/Element.js';
import { FormElement } from '../../core/FormElement.js';
import SixOrbit from '../../../core/so-config.js';

class Rating extends FormElement {
    static NAME = 'ui-rating';
    static DEFAULTS = { ...FormElement.DEFAULTS, type: 'rating', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        // Ensure value is initialized (FormElement sets it, but make sure it's a number)
        if (this._value === null || this._value === undefined) {
            this._value = 0;
        }
        this._maxRating = config.maxRating || 5;
        this._allowHalf = config.allowHalf || false;
        this._icon = config.icon || 'star';
        this._emptyIcon = config.emptyIcon || 'star_border';
        this._halfIcon = config.halfIcon || 'star_half';
        this._color = config.color || 'warning';
        this._size = config.size || null;
        this._showValue = config.showValue || false;
    }

    // Configuration methods
    value(val) { this._value = parseFloat(val) || 0; return this; }

    maxRating(max) { this._maxRating = max; return this; }
    max(m) { return this.maxRating(m); } // Alias for consistency with PHP

    allowHalf(val = true) { this._allowHalf = val; return this; }
    half(val = true) { return this.allowHalf(val); } // Alias for consistency with PHP

    icon(icon) { this._icon = icon; return this; }
    emptyIcon(icon) { this._emptyIcon = icon; return this; }
    halfIcon(icon) { this._halfIcon = icon; return this; }
    icons(filled, empty, half = null) {
        this._icon = filled;
        this._emptyIcon = empty;
        if (half !== null) this._halfIcon = half;
        return this;
    }

    color(c) { this._color = c; return this; }

    size(s) { this._size = s; return this; }
    small() { return this.size('sm'); }
    large() { return this.size('lg'); }

    showValue(val = true) { this._showValue = val; return this; }

    interactive(val = true) { this.setReadonly(!val); return this; }
    editable(val = true) { return this.interactive(val); }

    name(n) { return this.setName(n); } // Alias for consistency with PHP

    buildClassString() {
        // Don't add form-control class - ratings are not form inputs
        this._extraClasses.add(SixOrbit.cls('rating'));
        if (this._size) this._extraClasses.add(SixOrbit.cls('rating', this._size));
        if (this._readonly) this._extraClasses.add(SixOrbit.cls('rating-readonly'));

        // Call Element.buildClassString() instead of FormElement to skip form-control
        return Element.prototype.buildClassString.call(this);
    }

    buildAttributes() {
        const attrs = super.buildAttributes();

        // Remove invalid value attribute (ratings show value via stars)
        delete attrs.value;

        attrs[SixOrbit.data('ui-init')] = 'rating';

        const configObj = {
            maxRating: this._maxRating,
            allowHalf: this._allowHalf,
            value: this._value
        };
        const configJson = JSON.stringify(configObj);

        attrs[SixOrbit.data('ui-config')] = configJson;
        return attrs;
    }

    // Override to prevent value attribute from being added
    _shouldRenderValueAttr() {
        return false;
    }

    renderContent() {
        const value = parseFloat(this._value) || 0;
        let html = '';

        for (let i = 1; i <= this._maxRating; i++) {
            let icon = this._emptyIcon;
            let stateClass = '';

            if (i <= Math.floor(value)) {
                icon = this._icon;
                stateClass = ` ${SixOrbit.cls('rating-filled')}`;
            } else if (this._allowHalf && i - 0.5 <= value) {
                icon = this._halfIcon;
                stateClass = ` ${SixOrbit.cls('rating-half')}`;
            }

            html += `<span class="${SixOrbit.cls('rating-star')}${stateClass}" ${SixOrbit.data('value')}="${i}">`;
            html += `<span class="material-icons">${icon}</span>`;
            html += '</span>';
        }

        if (this._showValue) {
            html += ` <span class="${SixOrbit.cls('rating-value')}">${value}</span>`;
        }

        // Hidden input for form submission
        if (this._name) {
            html += `<input type="hidden" name="${this._escapeHtml(this._name)}" value="${value}">`;
        }

        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._maxRating !== 5) config.maxRating = this._maxRating;
        if (this._allowHalf) config.allowHalf = true;
        if (this._icon !== 'star') config.icon = this._icon;
        if (this._emptyIcon !== 'star_border') config.emptyIcon = this._emptyIcon;
        if (this._halfIcon !== 'star_half') config.halfIcon = this._halfIcon;
        if (this._color !== 'warning') config.color = this._color;
        if (this._size) config.size = this._size;
        if (this._showValue) config.showValue = true;
        return config;
    }

    // Static methods for DOM interaction
    static getInstance(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        return element?._ratingInstance || null;
    }

    static initAll() {
        const elements = document.querySelectorAll(`[${SixOrbit.data('ui-init')}="rating"]`);
        elements.forEach(el => {
            if (!el._ratingInstance) {
                Rating._initElement(el);
            }
        });
    }

    static _initElement(element) {
        const configAttr = element.getAttribute(SixOrbit.data('ui-config'));
        let config = {};

        if (configAttr) {
            try {
                // Decode HTML entities if present
                const textarea = document.createElement('textarea');
                textarea.innerHTML = configAttr;
                const decodedConfig = textarea.value;
                config = JSON.parse(decodedConfig);
            } catch (e) {
                console.error('Failed to parse rating config:', e);
                config = {};
            }
        }

        // Create instance and store reference
        const instance = new Rating(config);
        element._ratingInstance = instance;

        // Set up interactive handlers if not readonly
        if (!instance._readonly && !element.hasAttribute(SixOrbit.data('rating-initialized'))) {
            Rating._setupInteractive(element, instance);
            element.setAttribute(SixOrbit.data('rating-initialized'), 'true');
        }
    }

    static _setupInteractive(element, instance) {
        const stars = element.querySelectorAll(`.${SixOrbit.cls('rating-star')}`);
        const hiddenInput = element.querySelector('input[type="hidden"]');

        stars.forEach(star => {
            // Click handler
            star.addEventListener('click', () => {
                const value = parseFloat(star.getAttribute(SixOrbit.data('value')));
                const oldValue = instance._value;

                instance.setValue(value);
                if (hiddenInput) hiddenInput.value = value;

                // Update star display
                Rating._updateStarDisplay(element, stars, value, instance);

                // Dispatch change event
                const changeEvent = new CustomEvent(SixOrbit.evt('rating:change'), {
                    bubbles: true,
                    cancelable: true,
                    detail: { value, oldValue, instance }
                });
                element.dispatchEvent(changeEvent);
            });

            // Hover preview
            star.addEventListener('mouseenter', () => {
                const value = parseFloat(star.getAttribute(SixOrbit.data('value')));
                Rating._updateStarDisplay(element, stars, value, instance);
            });
        });

        // Reset on mouse leave
        element.addEventListener('mouseleave', () => {
            Rating._updateStarDisplay(element, stars, instance._value, instance);
        });
    }

    static _updateStarDisplay(_element, stars, value, instance) {
        stars.forEach(star => {
            const starValue = parseFloat(star.getAttribute(SixOrbit.data('value')));
            const iconSpan = star.querySelector('.material-icons');

            if (starValue <= Math.floor(value)) {
                iconSpan.textContent = instance._icon;
                star.classList.add(SixOrbit.cls('rating-filled'));
                star.classList.remove(SixOrbit.cls('rating-half'));
            } else if (instance._allowHalf && starValue - 0.5 <= value) {
                iconSpan.textContent = instance._halfIcon;
                star.classList.add(SixOrbit.cls('rating-half'));
                star.classList.remove(SixOrbit.cls('rating-filled'));
            } else {
                iconSpan.textContent = instance._emptyIcon;
                star.classList.remove(SixOrbit.cls('rating-filled'), SixOrbit.cls('rating-half'));
            }
        });
    }
}

// Auto-initialize on DOM ready
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => Rating.initAll());
    } else {
        Rating.initAll();
    }
}

export default Rating;
export { Rating };
