// ============================================
// SIXORBIT UI ENGINE - TABS ELEMENT
// Tabbed navigation component
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Tabs - Tabbed navigation element
 */
class Tabs extends ContainerElement {
    static NAME = 'ui-tabs';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'tabs',
        tagName: 'div',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._tabs = config.tabs || [];
        this._variant = config.variant || 'tabs'; // tabs, pills, underline
        this._fill = config.fill || false;
        this._justified = config.justified || false;
        this._vertical = config.vertical || false;
        this._fade = config.fade !== false;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Add tab
     * @param {Object} tab - {id, title, content, active, disabled, icon}
     * @returns {this}
     */
    addTab(tab) {
        this._tabs.push(tab);
        return this;
    }

    /**
     * Set multiple tabs
     * @param {Array} tabs
     * @returns {this}
     */
    tabs(tabs) {
        this._tabs = tabs;
        return this;
    }

    /**
     * Set variant
     * @param {string} variant
     * @returns {this}
     */
    variant(variant) {
        this._variant = variant;
        return this;
    }

    /** Tabs style */
    tabsStyle() { return this.variant('tabs'); }

    /** Pills style */
    pills() { return this.variant('pills'); }

    /** Underline style */
    underline() { return this.variant('underline'); }

    /**
     * Set fill mode
     * @param {boolean} fill
     * @returns {this}
     */
    fill(fill = true) {
        this._fill = fill;
        return this;
    }

    /**
     * Set justified mode
     * @param {boolean} justified
     * @returns {this}
     */
    justified(justified = true) {
        this._justified = justified;
        return this;
    }

    /**
     * Set vertical mode
     * @param {boolean} vertical
     * @returns {this}
     */
    vertical(vertical = true) {
        this._vertical = vertical;
        return this;
    }

    /**
     * Set fade animation
     * @param {boolean} fade
     * @returns {this}
     */
    fade(fade = true) {
        this._fade = fade;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        if (this._vertical) {
            this._extraClasses.add(SixOrbit.cls('d-flex'));
            this._extraClasses.add(SixOrbit.cls('align-items-start'));
        }
        return super.buildClassString();
    }

    /**
     * Build nav classes
     * @returns {string}
     */
    _buildNavClass() {
        let cls = SixOrbit.cls('nav');

        if (this._variant === 'tabs') {
            cls += ` ${SixOrbit.cls('nav-tabs')}`;
        } else if (this._variant === 'pills') {
            cls += ` ${SixOrbit.cls('nav-pills')}`;
        } else if (this._variant === 'underline') {
            cls += ` ${SixOrbit.cls('nav-underline')}`;
        }

        if (this._fill) {
            cls += ` ${SixOrbit.cls('nav-fill')}`;
        }

        if (this._justified) {
            cls += ` ${SixOrbit.cls('nav-justified')}`;
        }

        if (this._vertical) {
            cls += ` ${SixOrbit.cls('flex-column')}`;
            cls += ` ${SixOrbit.cls('me-3')}`;
        }

        return cls;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        const tabsId = this._id || `tabs-${Math.random().toString(36).substr(2, 9)}`;
        let html = '';

        // Nav tabs
        html += `<ul class="${this._buildNavClass()}" id="${tabsId}-nav" role="tablist">`;

        this._tabs.forEach((tab, index) => {
            const tabId = tab.id || `${tabsId}-tab-${index}`;
            const paneId = `${tabId}-pane`;
            const active = tab.active || (index === 0 && !this._tabs.some(t => t.active));
            const disabled = tab.disabled || false;

            html += `<li class="${SixOrbit.cls('nav-item')}" role="presentation">`;
            html += `<button class="${SixOrbit.cls('nav-link')}${active ? ` ${SixOrbit.cls('active')}` : ''}${disabled ? ' disabled' : ''}" `;
            html += `id="${tabId}" `;
            html += `${SixOrbit.data('toggle')}="tab" `;
            html += `${SixOrbit.data('target')}="#${paneId}" `;
            html += `type="button" `;
            html += `role="tab" `;
            html += `aria-controls="${paneId}" `;
            html += `aria-selected="${active}"`;
            if (disabled) html += ' disabled';
            html += '>';

            if (tab.icon) {
                html += `<span class="material-icons ${SixOrbit.cls('me-1')}">${this._escapeHtml(tab.icon)}</span>`;
            }

            html += this._escapeHtml(tab.title);
            html += '</button></li>';
        });

        html += '</ul>';

        // Tab content
        html += `<div class="${SixOrbit.cls('tab-content')}${this._vertical ? ` ${SixOrbit.cls('flex-grow-1')}` : ''}" id="${tabsId}-content">`;

        this._tabs.forEach((tab, index) => {
            const tabId = tab.id || `${tabsId}-tab-${index}`;
            const paneId = `${tabId}-pane`;
            const active = tab.active || (index === 0 && !this._tabs.some(t => t.active));

            let paneClass = SixOrbit.cls('tab-pane');
            if (this._fade) {
                paneClass += ` ${SixOrbit.cls('fade')}`;
            }
            if (active) {
                paneClass += ` ${SixOrbit.cls('show')} ${SixOrbit.cls('active')}`;
            }

            html += `<div class="${paneClass}" `;
            html += `id="${paneId}" `;
            html += `role="tabpanel" `;
            html += `aria-labelledby="${tabId}" `;
            html += `tabindex="0">`;
            html += tab.content || '';
            html += '</div>';
        });

        html += '</div>';

        // Render children
        html += this.renderChildren();

        return html;
    }

    // ==================
    // Tab Methods
    // ==================

    /**
     * Show tab by index or id
     * @param {number|string} indexOrId
     */
    show(indexOrId) {
        if (!this.element) return;

        let tabButton;
        if (typeof indexOrId === 'number') {
            tabButton = this.element.querySelectorAll(`${SixOrbit.sel('nav-link')}`)[indexOrId];
        } else {
            tabButton = this.element.querySelector(`#${indexOrId}`);
        }

        if (tabButton) {
            // Remove active from all
            this.element.querySelectorAll(SixOrbit.sel('nav-link')).forEach(btn => {
                btn.classList.remove(SixOrbit.cls('active'));
                btn.setAttribute('aria-selected', 'false');
            });
            this.element.querySelectorAll(SixOrbit.sel('tab-pane')).forEach(pane => {
                pane.classList.remove(SixOrbit.cls('show'), SixOrbit.cls('active'));
            });

            // Activate selected
            tabButton.classList.add(SixOrbit.cls('active'));
            tabButton.setAttribute('aria-selected', 'true');

            const targetId = tabButton.getAttribute(SixOrbit.data('target'));
            const targetPane = this.element.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add(SixOrbit.cls('show'), SixOrbit.cls('active'));
            }
        }
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

        if (this._tabs.length > 0) config.tabs = this._tabs;
        if (this._variant !== 'tabs') config.variant = this._variant;
        if (this._fill) config.fill = true;
        if (this._justified) config.justified = true;
        if (this._vertical) config.vertical = true;
        if (!this._fade) config.fade = false;

        return config;
    }
}

export default Tabs;
export { Tabs };
