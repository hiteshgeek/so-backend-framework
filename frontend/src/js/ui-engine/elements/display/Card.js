// ============================================
// SIXORBIT UI ENGINE - CARD ELEMENT
// Simple card container with header, body, and footer
// ============================================

import { Element } from '../../core/Element.js';
import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';
import HasDragDrop from '../../mixins/HasDragDrop.js';

/**
 * Card - Simple card container
 *
 * A flexible container that accepts nested elements for complex layouts.
 * Supports full card colors, borderless sections, actions, and drag-drop.
 *
 * Config Example:
 *   new Card({
 *       header: 'Card Title',
 *       body: 'Card content',
 *       color: 'primary',
 *       headerBorderless: true,
 *       collapsible: true,
 *       draggable: true,
 *       dragHandle: '.so-card-header',
 *   });
 *
 * Fluent API Example:
 *   new Card({})
 *       .header('Card Title')
 *       .body('Card content')
 *       .colorPrimary()
 *       .headerBorderless()
 *       .collapsible()
 *       .draggable()
 *       .dragHandle('.so-card-header');
 */
class Card extends HasDragDrop(ContainerElement) {
    static NAME = 'ui-card';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'card',
        tagName: 'div',
    };

    /**
     * Initialize from config
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        // Content
        this._header = config.header || null;
        this._body = config.body || null;
        this._footer = config.footer || null;

        // Border variant
        this._variant = config.variant || null;

        // Full card color
        this._color = config.color || null;

        // Borderless sections
        this._headerBorderless = config.headerBorderless || false;
        this._footerBorderless = config.footerBorderless || false;
        if (config.borderlessSections) {
            this._headerBorderless = true;
            this._footerBorderless = true;
        }

        // Action states
        this._actions = new Map();
        this._closeConfirm = null;

        // Process action config
        if (config.collapsible) {
            this._actions.set('collapsible', true);
        }
        if (config.refreshable) {
            this._actions.set('refreshable', true);
            if (typeof config.refreshable === 'function') {
                this._actions.set('refresh', config.refreshable);
            }
        }
        if (config.maximizable) {
            this._actions.set('maximizable', true);
        }
        if (config.closeable) {
            this._actions.set('closeable', true);
            if (typeof config.closeable === 'string') {
                this._closeConfirm = config.closeable;
            }
        }

        // Runtime state
        this._collapsed = false;
        this._fullscreen = false;
        this._loading = false;
        this._previousStyles = null;
        this._escHandler = null;

        // Initialize drag-drop from config (from HasDragDrop mixin)
        this._initDragDrop(config);
    }

    // ==================
    // Content Configuration
    // ==================

    /**
     * Set card header content
     * @param {Element|string|array} content
     * @returns {this}
     */
    header(content) {
        this._header = content;
        return this;
    }

    /**
     * Set card body content
     * @param {Element|string|array} content
     * @returns {this}
     */
    body(content) {
        this._body = content;
        return this;
    }

    /**
     * Set card footer content
     * @param {Element|string|array} content
     * @returns {this}
     */
    footer(content) {
        this._footer = content;
        return this;
    }

    // ==================
    // Border Variant Methods
    // ==================

    /**
     * Set card border variant
     * @param {string} variant - primary, secondary, success, danger, warning, info
     * @returns {this}
     */
    variant(variant) {
        this._variant = variant;
        return this;
    }

    // Variant shortcuts
    primary() { return this.variant('primary'); }
    secondary() { return this.variant('secondary'); }
    success() { return this.variant('success'); }
    danger() { return this.variant('danger'); }
    warning() { return this.variant('warning'); }
    info() { return this.variant('info'); }

    // ==================
    // Full Card Color Methods
    // ==================

    /**
     * Set full card background color
     * @param {string} color - primary, secondary, success, danger, warning, info, light, dark
     * @returns {this}
     */
    color(color) {
        this._color = color;
        return this;
    }

    // Color shortcuts
    colorPrimary() { return this.color('primary'); }
    colorSecondary() { return this.color('secondary'); }
    colorSuccess() { return this.color('success'); }
    colorDanger() { return this.color('danger'); }
    colorWarning() { return this.color('warning'); }
    colorInfo() { return this.color('info'); }
    colorLight() { return this.color('light'); }
    colorDark() { return this.color('dark'); }

    // ==================
    // Borderless Section Methods
    // ==================

    /**
     * Remove header bottom border
     * @returns {this}
     */
    headerBorderless() {
        this._headerBorderless = true;
        return this;
    }

    /**
     * Remove footer top border
     * @returns {this}
     */
    footerBorderless() {
        this._footerBorderless = true;
        return this;
    }

    /**
     * Remove both header and footer borders
     * @returns {this}
     */
    borderlessSections() {
        this._headerBorderless = true;
        this._footerBorderless = true;
        return this;
    }

    // ==================
    // Action Configuration
    // ==================

    /**
     * Enable collapse action
     * @returns {this}
     */
    collapsible() {
        this._actions.set('collapsible', true);
        return this;
    }

    /**
     * Enable refresh action with handler
     * @param {Function} handler - Async function to call on refresh
     * @returns {this}
     */
    refreshable(handler) {
        this._actions.set('refreshable', true);
        if (handler) {
            this._actions.set('refresh', handler);
        }
        return this;
    }

    /**
     * Enable fullscreen/maximize action
     * @returns {this}
     */
    maximizable() {
        this._actions.set('maximizable', true);
        return this;
    }

    /**
     * Enable close action
     * @param {string|null} confirmMessage - Optional confirmation message
     * @returns {this}
     */
    closeable(confirmMessage = null) {
        this._actions.set('closeable', true);
        this._closeConfirm = confirmMessage;
        return this;
    }

    // ==================
    // Collapse/Expand Actions
    // ==================

    /**
     * Collapse the card
     * @returns {this}
     */
    collapse() {
        if (!this.element) {
            console.warn('Card must be rendered before collapsing');
            return this;
        }

        if (!this.emit('so:card:beforeCollapse', {}, true, true)) {
            return this;
        }

        this._collapsed = true;
        this.element.classList.add(SixOrbit.cls('card-collapsed'));

        // Smooth height transition
        const body = this.element.querySelector(`.${SixOrbit.cls('card-body')}`);
        if (body) {
            body.style.maxHeight = body.scrollHeight + 'px';
            requestAnimationFrame(() => {
                body.style.maxHeight = '0';
            });
        }

        this.emit('so:card:collapse');
        return this;
    }

    /**
     * Expand the card
     * @returns {this}
     */
    expand() {
        if (!this.element) {
            console.warn('Card must be rendered before expanding');
            return this;
        }

        if (!this.emit('so:card:beforeExpand', {}, true, true)) {
            return this;
        }

        this._collapsed = false;
        this.element.classList.remove(SixOrbit.cls('card-collapsed'));

        // Smooth height transition
        const body = this.element.querySelector(`.${SixOrbit.cls('card-body')}`);
        if (body) {
            body.style.maxHeight = body.scrollHeight + 'px';
            setTimeout(() => {
                body.style.maxHeight = '';
            }, 300);
        }

        this.emit('so:card:expand');
        return this;
    }

    /**
     * Toggle collapse state
     * @returns {this}
     */
    toggleCollapse() {
        return this._collapsed ? this.expand() : this.collapse();
    }

    // ==================
    // Refresh Action
    // ==================

    /**
     * Refresh card content
     * @param {Function} handler - Optional handler to override configured handler
     * @returns {Promise<this>}
     */
    async refresh(handler) {
        if (!this.element) {
            console.warn('Card must be rendered before refreshing');
            return this;
        }

        if (!this.emit('so:card:beforeRefresh', {}, true, true)) {
            return this;
        }

        this._loading = true;
        this.element.classList.add(SixOrbit.cls('card-loading'));

        try {
            // Get handler from parameter or config
            const refreshHandler = handler || this._actions.get('refresh');
            if (!refreshHandler) {
                throw new Error('No refresh handler defined');
            }

            // Call handler (can be async)
            await refreshHandler(this);

            this.emit('so:card:refresh');
        } catch (error) {
            console.error('Card refresh error:', error);
            this.emit('so:card:refreshError', { error });
        } finally {
            this._loading = false;
            this.element.classList.remove(SixOrbit.cls('card-loading'));
        }

        return this;
    }

    // ==================
    // Fullscreen Actions
    // ==================

    /**
     * Enter fullscreen mode
     * @returns {this}
     */
    fullscreen() {
        if (!this.element) {
            console.warn('Card must be rendered before entering fullscreen');
            return this;
        }

        if (!this.emit('so:card:beforeFullscreen', {}, true, true)) {
            return this;
        }

        this._fullscreen = true;

        // Save current styles
        this._previousStyles = {
            position: this.element.style.position,
            width: this.element.style.width,
            height: this.element.style.height,
            top: this.element.style.top,
            left: this.element.style.left,
            zIndex: this.element.style.zIndex,
        };

        this.element.classList.add(SixOrbit.cls('card-fullscreen'));
        document.body.style.overflow = 'hidden';

        // ESC key handler
        this._escHandler = (e) => {
            if (e.key === 'Escape') this.exitFullscreen();
        };
        document.addEventListener('keydown', this._escHandler);

        this.emit('so:card:fullscreen');
        return this;
    }

    /**
     * Exit fullscreen mode
     * @returns {this}
     */
    exitFullscreen() {
        if (!this._fullscreen || !this.element) {
            return this;
        }

        this._fullscreen = false;
        this.element.classList.remove(SixOrbit.cls('card-fullscreen'));

        // Restore previous styles
        if (this._previousStyles) {
            Object.assign(this.element.style, this._previousStyles);
            this._previousStyles = null;
        }

        document.body.style.overflow = '';

        // Remove ESC handler
        if (this._escHandler) {
            document.removeEventListener('keydown', this._escHandler);
            this._escHandler = null;
        }

        this.emit('so:card:exitFullscreen');
        return this;
    }

    /**
     * Toggle fullscreen state
     * @returns {this}
     */
    toggleFullscreen() {
        return this._fullscreen ? this.exitFullscreen() : this.fullscreen();
    }

    // ==================
    // Close Action
    // ==================

    /**
     * Close/remove the card
     * @param {string|null} confirmMessage - Optional confirmation message (overrides configured message)
     * @returns {this}
     */
    close(confirmMessage = null) {
        if (!this.element) {
            console.warn('Card must be rendered before closing');
            return this;
        }

        const confirmMsg = confirmMessage || this._closeConfirm;
        if (confirmMsg && !window.confirm(confirmMsg)) {
            return this;
        }

        if (!this.emit('so:card:beforeClose', {}, true, true)) {
            return this;
        }

        this.emit('so:card:close');

        // Fade out animation
        this.element.style.transition = 'opacity 300ms ease';
        this.element.style.opacity = '0';

        setTimeout(() => {
            this.element.remove();
            this.emit('so:card:closed');
            if (this.destroy) {
                this.destroy();
            }
        }, 300);

        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Check if card has any actions enabled
     * @returns {boolean}
     */
    _hasActions() {
        return this._actions.has('collapsible') ||
               this._actions.has('refreshable') ||
               this._actions.has('maximizable') ||
               this._actions.has('closeable');
    }

    /**
     * Render action buttons HTML
     * @returns {string}
     */
    _renderActions() {
        if (!this._hasActions()) return '';

        let html = `<div class="${SixOrbit.cls('card-header-actions')}">`;

        if (this._actions.get('collapsible')) {
            html += `<button type="button" class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-icon')} ${SixOrbit.cls('btn-ghost')} ${SixOrbit.cls('btn-sm')} ${SixOrbit.cls('card-action-btn')}" data-action="collapse" title="Collapse">
                <span class="material-icons">expand_less</span>
            </button>`;
        }

        if (this._actions.get('refreshable')) {
            html += `<button type="button" class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-icon')} ${SixOrbit.cls('btn-ghost')} ${SixOrbit.cls('btn-sm')} ${SixOrbit.cls('card-action-btn')}" data-action="refresh" title="Refresh">
                <span class="material-icons">refresh</span>
            </button>`;
        }

        if (this._actions.get('maximizable')) {
            html += `<button type="button" class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-icon')} ${SixOrbit.cls('btn-ghost')} ${SixOrbit.cls('btn-sm')} ${SixOrbit.cls('card-action-btn')}" data-action="fullscreen" title="Fullscreen">
                <span class="material-icons">fullscreen</span>
            </button>`;
        }

        if (this._actions.get('closeable')) {
            const confirmAttr = this._closeConfirm ? ` data-confirm="${this._escapeHtml(this._closeConfirm)}"` : '';
            html += `<button type="button" class="${SixOrbit.cls('btn')} ${SixOrbit.cls('btn-icon')} ${SixOrbit.cls('btn-ghost')} ${SixOrbit.cls('btn-sm')} ${SixOrbit.cls('card-action-btn')}" data-action="close"${confirmAttr} title="Close">
                <span class="material-icons">close</span>
            </button>`;
        }

        html += '</div>';
        return html;
    }

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this.addClass(SixOrbit.cls('card'));

        // Border variant class
        if (this._variant) {
            this.addClass(SixOrbit.cls('card-border-' + this._variant));
        }

        // Full card color class
        if (this._color) {
            this.addClass(SixOrbit.cls('card-' + this._color));
        }

        // Borderless section classes
        if (this._headerBorderless) {
            this.addClass(SixOrbit.cls('card-header-borderless'));
        }
        if (this._footerBorderless) {
            this.addClass(SixOrbit.cls('card-footer-borderless'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes including drag attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        // Merge in drag attributes (from HasDragDrop mixin)
        const dragAttrs = this._buildDragAttributes();
        Object.assign(attrs, dragAttrs);

        return attrs;
    }

    /**
     * Render mixed content to HTML string
     * @param {Element|string|array|Object} content
     * @returns {string}
     * @private
     */
    _renderMixed(content) {
        if (content === null || content === undefined) return '';

        if (Array.isArray(content)) {
            return content.map(item => this._renderMixed(item)).join('');
        }

        if (content instanceof Element) {
            return content.toHtml();
        }

        if (content instanceof HTMLElement) {
            return content.outerHTML;
        }

        if (typeof content === 'object' && content.type) {
            // Config object - convert to Element using UiEngine
            if (window.UiEngine) {
                const element = window.UiEngine.fromConfig(content);
                return element.toHtml();
            }
            return '';
        }

        // String content - escape HTML
        return this._escapeHtml(String(content));
    }

    /**
     * Escape HTML special characters
     * @param {string} str
     * @returns {string}
     * @private
     */
    _escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    /**
     * Render card content (HTML string version for toHtml())
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Header (include actions if present)
        if (this._header !== null || this._hasActions()) {
            html += `<div class="${SixOrbit.cls('card-header')}">`;
            if (this._header !== null) {
                html += this._renderMixed(this._header);
            }
            html += this._renderActions();
            html += '</div>';
        }

        // Body
        if (this._body !== null) {
            html += `<div class="${SixOrbit.cls('card-body')}">`;
            html += this._renderMixed(this._body);
            html += '</div>';
        }

        // Render children (if using add() method)
        html += this.renderChildren();

        // Footer
        if (this._footer !== null) {
            html += `<div class="${SixOrbit.cls('card-footer')}">`;
            html += this._renderMixed(this._footer);
            html += '</div>';
        }

        return html;
    }

    /**
     * Render to DOM element
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

        // Render header (with actions)
        if (this._header !== null || this._hasActions()) {
            const headerDiv = document.createElement('div');
            headerDiv.className = SixOrbit.cls('card-header');
            if (this._header !== null) {
                this._appendMixed(headerDiv, this._header);
            }
            // Append action buttons
            if (this._hasActions()) {
                const actionsHtml = this._renderActions();
                const wrapper = document.createElement('div');
                wrapper.innerHTML = actionsHtml;
                while (wrapper.firstChild) {
                    headerDiv.appendChild(wrapper.firstChild);
                }
            }
            el.appendChild(headerDiv);
        }

        // Render body
        if (this._body !== null) {
            const bodyDiv = document.createElement('div');
            bodyDiv.className = SixOrbit.cls('card-body');
            this._appendMixed(bodyDiv, this._body);
            el.appendChild(bodyDiv);
        }

        // Render children (if using add() method)
        const childrenFragment = this.renderChildrenDOM();
        if (childrenFragment) {
            el.appendChild(childrenFragment);
        }

        // Render footer
        if (this._footer !== null) {
            const footerDiv = document.createElement('div');
            footerDiv.className = SixOrbit.cls('card-footer');
            this._appendMixed(footerDiv, this._footer);
            el.appendChild(footerDiv);
        }

        this.element = el;
        this._setupActions();

        // Auto-enable drag-drop if configured
        if (this._draggable) {
            // Use setTimeout to ensure element is in DOM first
            setTimeout(() => this.enableDragDrop(), 0);
        }

        return el;
    }

    /**
     * Render children as DOM fragment
     * @returns {DocumentFragment|null}
     */
    renderChildrenDOM() {
        if (!this._children || this._children.length === 0) {
            return null;
        }

        const fragment = document.createDocumentFragment();
        this._children.forEach(child => {
            if (child instanceof Element) {
                fragment.appendChild(child.render());
            } else if (child instanceof HTMLElement) {
                fragment.appendChild(child);
            }
        });
        return fragment;
    }

    /**
     * Setup action button event handlers
     * @private
     */
    _setupActions() {
        if (!this.element) return;

        // Delegate action button clicks
        this.element.addEventListener('click', (e) => {
            const actionBtn = e.target.closest('[data-action]');
            if (!actionBtn) return;

            const action = actionBtn.getAttribute('data-action');

            switch (action) {
                case 'collapse':
                    this.toggleCollapse();
                    break;
                case 'refresh':
                    this.refresh();
                    break;
                case 'fullscreen':
                    this.toggleFullscreen();
                    break;
                case 'close':
                    const confirmMsg = actionBtn.getAttribute('data-confirm');
                    this.close(confirmMsg);
                    break;
            }
        });
    }

    /**
     * Append mixed content to a container element
     * @param {HTMLElement} container
     * @param {Element|string|array|Object} content
     * @private
     */
    _appendMixed(container, content) {
        if (content === null || content === undefined) return;

        if (Array.isArray(content)) {
            content.forEach(item => this._appendMixed(container, item));
            return;
        }

        if (content instanceof Element) {
            container.appendChild(content.render());
        } else if (content instanceof HTMLElement) {
            container.appendChild(content);
        } else if (typeof content === 'object' && content.type) {
            // Config object - convert to Element using UiEngine
            if (window.UiEngine) {
                const element = window.UiEngine.fromConfig(content);
                container.appendChild(element.render());
            }
        } else {
            // String content
            const wrapper = document.createElement('div');
            wrapper.innerHTML = String(content);
            while (wrapper.firstChild) {
                container.appendChild(wrapper.firstChild);
            }
        }
    }

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._header) config.header = this._header;
        if (this._body) config.body = this._body;
        if (this._footer) config.footer = this._footer;
        if (this._variant) config.variant = this._variant;
        if (this._color) config.color = this._color;
        if (this._headerBorderless) config.headerBorderless = true;
        if (this._footerBorderless) config.footerBorderless = true;
        if (this._draggable) {
            config.draggable = true;
            if (this._dragHandle) config.dragHandle = this._dragHandle;
            if (this._dragGroup) config.dragGroup = this._dragGroup;
            if (this._liveReorder) config.liveReorder = true;
        }

        return config;
    }
}

export default Card;
export { Card };
