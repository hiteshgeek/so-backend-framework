// ============================================
// SIXORBIT UI ENGINE - MODAL ELEMENT
// Modal dialog with show/hide functionality
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Modal - Modal dialog element
 *
 * Creates modal dialogs with header, body, and footer sections.
 * Generates proper .so-modal structure matching CSS framework.
 */
class Modal extends ContainerElement {
    static NAME = 'ui-modal';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'modal',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._title = config.title || null;
        this._footerButtons = config.footerButtons || [];
        this._size = config.size || 'md';
        this._scrollable = config.scrollable || false;
        this._centered = config.centered || false;
        this._staticBackdrop = config.staticBackdrop || false;
        this._showClose = config.showClose !== false;
        this._keyboard = config.keyboard !== false;
        this._focus = config.focus !== false;
    }

    // ==================
    // Content Methods
    // ==================

    /**
     * Set modal title
     * @param {string} title
     * @returns {this}
     */
    title(title) {
        this._title = title;
        return this;
    }

    /**
     * Add footer button
     * @param {string} text
     * @param {string} variant
     * @param {boolean} dismiss
     * @param {Object} attributes
     * @returns {this}
     */
    addButton(text, variant = 'secondary', dismiss = false, attributes = {}) {
        this._footerButtons.push({
            text,
            variant,
            dismiss,
            attributes,
        });
        return this;
    }

    /**
     * Add close button to footer
     * @param {string} text
     * @returns {this}
     */
    closeButton(text = 'Close') {
        return this.addButton(text, 'secondary', true);
    }

    /**
     * Add save/submit button to footer
     * @param {string} text
     * @param {string} variant
     * @returns {this}
     */
    saveButton(text = 'Save', variant = 'primary') {
        return this.addButton(text, variant, false, { type: 'submit' });
    }

    // ==================
    // Size Methods
    // ==================

    /**
     * Set modal size
     * @param {string} size - sm|md|lg|xl|fullscreen
     * @returns {this}
     */
    size(size) {
        this._size = size;
        this._triggerEvent('so:modal:sizeChanged', { size });
        return this;
    }

    /**
     * Small modal
     * @returns {this}
     */
    small() {
        return this.size('sm');
    }

    /**
     * Large modal
     * @returns {this}
     */
    large() {
        return this.size('lg');
    }

    /**
     * Extra large modal
     * @returns {this}
     */
    extraLarge() {
        return this.size('xl');
    }

    /**
     * Fullscreen modal
     * @returns {this}
     */
    fullscreen() {
        return this.size('fullscreen');
    }

    // ==================
    // Behavior Methods
    // ==================

    /**
     * Make modal scrollable
     * @param {boolean} scrollable
     * @returns {this}
     */
    scrollable(scrollable = true) {
        this._scrollable = scrollable;
        this._triggerEvent('so:modal:scrollableChanged', { scrollable });
        return this;
    }

    /**
     * Center modal vertically
     * @param {boolean} centered
     * @returns {this}
     */
    centered(centered = true) {
        this._centered = centered;
        this._triggerEvent('so:modal:centeredChanged', { centered });
        return this;
    }

    /**
     * Use static backdrop
     * @param {boolean} staticBackdrop
     * @returns {this}
     */
    staticBackdrop(staticBackdrop = true) {
        this._staticBackdrop = staticBackdrop;
        this._triggerEvent('so:modal:staticBackdropChanged', { staticBackdrop });
        return this;
    }

    /**
     * Hide close button
     * @returns {this}
     */
    hideClose() {
        this._showClose = false;
        this._triggerEvent('so:modal:closeButtonChanged', { showClose: false });
        return this;
    }

    /**
     * Disable keyboard close
     * @returns {this}
     */
    noKeyboard() {
        this._keyboard = false;
        this._triggerEvent('so:modal:keyboardChanged', { keyboard: false });
        return this;
    }

    /**
     * Disable focus
     * @returns {this}
     */
    noFocus() {
        this._focus = false;
        this._triggerEvent('so:modal:focusChanged', { focus: false });
        return this;
    }

    // ==================
    // Dynamic Update Methods
    // ==================

    /**
     * Update title dynamically
     * @param {string} title
     * @returns {this}
     */
    setTitle(title) {
        this._title = title;
        if (this._element) {
            const titleEl = this._element.querySelector(SixOrbit.sel('modal-title'));
            if (titleEl) {
                titleEl.textContent = title;
            }
        }
        this._triggerEvent('so:modal:titleChanged', { title });
        return this;
    }

    /**
     * Update body content dynamically
     * @param {string} content
     * @returns {this}
     */
    setBody(content) {
        if (this._element) {
            const bodyEl = this._element.querySelector(SixOrbit.sel('modal-body'));
            if (bodyEl) {
                bodyEl.innerHTML = content;
            }
        }
        this._triggerEvent('so:modal:bodyChanged', { content });
        return this;
    }

    /**
     * Add button dynamically
     * @param {string} text
     * @param {string} variant
     * @param {boolean} dismiss
     * @param {Object} attributes
     * @returns {this}
     */
    addButtonDynamic(text, variant = 'secondary', dismiss = false, attributes = {}) {
        this._footerButtons.push({ text, variant, dismiss, attributes });

        if (this._element) {
            const footerEl = this._element.querySelector(SixOrbit.sel('modal-footer'));
            if (footerEl) {
                const button = document.createElement('button');
                button.className = `${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-' + variant)}`;
                button.textContent = text;

                if (dismiss) {
                    button.setAttribute('data-dismiss', 'modal');
                    button.addEventListener('click', () => this.hide());
                }

                Object.entries(attributes).forEach(([key, value]) => {
                    button.setAttribute(key, value);
                });

                footerEl.appendChild(button);
            }
        }

        this._triggerEvent('so:modal:buttonAdded', { text, variant, dismiss });
        return this;
    }

    /**
     * Clear all footer buttons dynamically
     * @returns {this}
     */
    clearButtons() {
        this._footerButtons = [];

        if (this._element) {
            const footerEl = this._element.querySelector(SixOrbit.sel('modal-footer'));
            if (footerEl) {
                footerEl.innerHTML = '';
            }
        }

        this._triggerEvent('so:modal:buttonsCleared');
        return this;
    }

    // ==================
    // Getters
    // ==================

    /**
     * Get modal title
     * @returns {string|null}
     */
    getTitle() {
        return this._title;
    }

    /**
     * Get footer buttons
     * @returns {Array}
     */
    getButtons() {
        return this._footerButtons;
    }

    /**
     * Get size
     * @returns {string}
     */
    getSize() {
        return this._size;
    }

    /**
     * Get scrollable state
     * @returns {boolean}
     */
    isScrollable() {
        return this._scrollable;
    }

    /**
     * Get centered state
     * @returns {boolean}
     */
    isCentered() {
        return this._centered;
    }

    /**
     * Get static backdrop state
     * @returns {boolean}
     */
    hasStaticBackdrop() {
        return this._staticBackdrop;
    }

    /**
     * Check if modal is visible
     * @returns {boolean}
     */
    isVisible() {
        return this._element?.classList.contains(SixOrbit.cls('show')) || false;
    }

    // ==================
    // Event Methods
    // ==================

    /**
     * Add show event listener
     * @param {Function} callback
     * @returns {this}
     */
    onShow(callback) {
        return this.on('so:modal:show', callback);
    }

    /**
     * Add shown event listener (after animation)
     * @param {Function} callback
     * @returns {this}
     */
    onShown(callback) {
        return this.on('so:modal:shown', callback);
    }

    /**
     * Add hide event listener
     * @param {Function} callback
     * @returns {this}
     */
    onHide(callback) {
        return this.on('so:modal:hide', callback);
    }

    /**
     * Add hidden event listener (after animation)
     * @param {Function} callback
     * @returns {this}
     */
    onHidden(callback) {
        return this.on('so:modal:hidden', callback);
    }

    /**
     * Add dismiss event listener (when user cancels/closes)
     * @param {Function} callback
     * @returns {this}
     */
    onDismiss(callback) {
        return this.on('so:modal:dismiss', callback);
    }

    /**
     * Trigger custom event
     * @param {string} eventName
     * @param {Object} detail
     * @private
     */
    _triggerEvent(eventName, detail = {}) {
        if (this._element) {
            const event = new CustomEvent(eventName, {
                detail: { ...detail, modal: this },
                bubbles: true,
                cancelable: true,
            });
            this._element.dispatchEvent(event);
        }
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('modal'));

        // Size classes on outer modal
        if (this._size !== 'md') {
            if (this._size === 'fullscreen') {
                this._extraClasses.add(SixOrbit.cls('modal-fullscreen'));
            } else {
                this._extraClasses.add(SixOrbit.cls('modal-' + this._size));
            }
        }

        // Scrollable on outer modal
        if (this._scrollable) {
            this._extraClasses.add(SixOrbit.cls('modal-scrollable'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        attrs.tabindex = '-1';
        attrs['aria-hidden'] = 'true';
        attrs.role = 'dialog';

        if (this._title) {
            const labelId = (this._id || 'modal') + '-label';
            attrs['aria-labelledby'] = labelId;
        }

        if (this._staticBackdrop) {
            attrs[SixOrbit.data('backdrop')] = 'static';
        }

        if (!this._keyboard) {
            attrs[SixOrbit.data('keyboard')] = 'false';
        }

        if (!this._focus) {
            attrs[SixOrbit.data('focus')] = 'false';
        }

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let dialogClass = SixOrbit.cls('modal-dialog');

        // Centered dialog modifier
        if (this._centered) {
            dialogClass += ' ' + SixOrbit.cls('modal-dialog-centered');
        }

        let html = `<div class="${dialogClass}">`;

        // Header
        html += this._renderHeader();

        // Body
        html += this._renderBody();

        // Footer
        if (this._footerButtons.length > 0) {
            html += this._renderFooter();
        }

        html += '</div>';

        return html;
    }

    /**
     * Render modal header
     * @returns {string}
     * @private
     */
    _renderHeader() {
        if (!this._title && !this._showClose) {
            return '';
        }

        let html = `<div class="${SixOrbit.cls('modal-header')}">`;

        if (this._title) {
            const labelId = (this._id || 'modal') + '-label';
            html += `<h5 class="${SixOrbit.cls('modal-title')}" id="${this._escapeHtml(labelId)}">${this._escapeHtml(this._title)}</h5>`;
        }

        if (this._showClose) {
            html += `<button class="${SixOrbit.cls('modal-close')}" data-dismiss="modal">`;
            html += '<span class="material-icons">close</span>';
            html += '</button>';
        }

        html += '</div>';

        return html;
    }

    /**
     * Render modal body
     * @returns {string}
     * @private
     */
    _renderBody() {
        let html = `<div class="${SixOrbit.cls('modal-body')}">`;
        html += this.renderChildren();
        html += '</div>';

        return html;
    }

    /**
     * Render modal footer
     * @returns {string}
     * @private
     */
    _renderFooter() {
        let html = `<div class="${SixOrbit.cls('modal-footer')}">`;

        this._footerButtons.forEach(button => {
            const btnClass = `${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-' + (button.variant || 'secondary'))}`;
            const attrs = button.attributes || {};

            let attrStr = `class="${btnClass}"`;

            if (button.dismiss) {
                attrStr += ' data-dismiss="modal"';
            }

            Object.entries(attrs).forEach(([name, value]) => {
                attrStr += ` ${this._escapeHtml(name)}="${this._escapeHtml(value)}"`;
            });

            html += `<button ${attrStr}>${this._escapeHtml(button.text)}</button>`;
        });

        html += '</div>';

        return html;
    }

    // ==================
    // Modal Methods
    // ==================

    /**
     * Show the modal
     * @returns {this}
     */
    show() {
        if (!this._element) {
            return this;
        }

        // Trigger show event (cancelable)
        const showEvent = new CustomEvent('so:modal:show', {
            detail: { modal: this },
            bubbles: true,
            cancelable: true,
        });
        this._element.dispatchEvent(showEvent);

        if (showEvent.defaultPrevented) {
            return this;
        }

        this._element.classList.add(SixOrbit.cls('show'));
        this._element.style.display = 'block';
        this._element.setAttribute('aria-hidden', 'false');
        document.body.classList.add(SixOrbit.cls('modal-open'));

        // Create backdrop
        if (!this._staticBackdrop && !document.querySelector(SixOrbit.sel('modal-backdrop'))) {
            const backdrop = document.createElement('div');
            backdrop.className = `${SixOrbit.cls('modal-backdrop')} ${SixOrbit.cls('show')}`;
            backdrop.addEventListener('click', () => {
                if (!this._staticBackdrop) {
                    this.hide();
                }
            });
            document.body.appendChild(backdrop);
        }

        // Focus first focusable element
        if (this._focus) {
            setTimeout(() => {
                const focusable = this._element.querySelector('input, button, textarea, select, [tabindex]:not([tabindex="-1"])');
                if (focusable) {
                    focusable.focus();
                }
            }, 100);
        }

        // Trigger shown event (after animation)
        setTimeout(() => {
            this._triggerEvent('so:modal:shown');
        }, 150);

        return this;
    }

    /**
     * Hide the modal
     * @returns {this}
     */
    hide() {
        if (!this._element) {
            return this;
        }

        // Trigger hide event (cancelable)
        const hideEvent = new CustomEvent('so:modal:hide', {
            detail: { modal: this },
            bubbles: true,
            cancelable: true,
        });
        this._element.dispatchEvent(hideEvent);

        if (hideEvent.defaultPrevented) {
            return this;
        }

        this._element.classList.remove(SixOrbit.cls('show'));
        this._element.setAttribute('aria-hidden', 'true');
        document.body.classList.remove(SixOrbit.cls('modal-open'));

        // Remove backdrop
        const backdrop = document.querySelector(SixOrbit.sel('modal-backdrop'));
        if (backdrop) {
            backdrop.remove();
        }

        // Trigger dismiss event
        this._triggerEvent('so:modal:dismiss');

        // Hide after animation
        setTimeout(() => {
            this._element.style.display = 'none';
            this._triggerEvent('so:modal:hidden');
        }, 150);

        return this;
    }

    /**
     * Toggle the modal
     * @returns {this}
     */
    toggle() {
        if (this.isVisible()) {
            this.hide();
        } else {
            this.show();
        }
        return this;
    }

    /**
     * Dispose the modal (cleanup)
     * @returns {void}
     */
    dispose() {
        this.hide();

        if (this._element) {
            this._element.remove();
        }

        this._triggerEvent('so:modal:disposed');
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

        if (this._title) config.title = this._title;
        if (this._footerButtons.length > 0) config.footerButtons = this._footerButtons;
        if (this._size !== 'md') config.size = this._size;
        if (this._scrollable) config.scrollable = true;
        if (this._centered) config.centered = true;
        if (this._staticBackdrop) config.staticBackdrop = true;
        if (!this._showClose) config.showClose = false;
        if (!this._keyboard) config.keyboard = false;
        if (!this._focus) config.focus = false;

        return config;
    }
}

export default Modal;
export { Modal };
