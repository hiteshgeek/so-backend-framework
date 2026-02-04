// ============================================
// SIXORBIT UI ENGINE - NAVBAR ELEMENT
// Top navigation bar
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Navbar extends Element {
    static NAME = 'ui-navbar';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'navbar', tagName: 'nav' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._brand = config.brand || null;
        this._brandUrl = config.brandUrl || '/';
        this._brandImage = config.brandImage || null;
        this._items = config.items || [];
        this._rightItems = config.rightItems || [];
        this._colorScheme = config.colorScheme || 'light';
        this._background = config.background || null;
        this._expand = config.expand || 'lg';
        this._fixed = config.fixed || null;
        this._sticky = config.sticky || false;
        this._container = config.container || 'container';
    }

    brand(text, url = '/') { this._brand = text; this._brandUrl = url; return this; }
    brandImage(url) { this._brandImage = url; return this; }
    items(items) { this._items = items; return this; }
    addItem(label, url = '#', active = false, disabled = false) {
        this._items.push({ type: 'link', label, url, active, disabled });
        return this;
    }
    addDropdown(label, items) {
        this._items.push({ type: 'dropdown', label, items });
        return this;
    }
    rightItems(items) { this._rightItems = items; return this; }
    colorScheme(scheme) { this._colorScheme = scheme; return this; }
    light() { return this.colorScheme('light'); }
    dark() { return this.colorScheme('dark'); }
    background(bg) { this._background = bg; return this; }
    expand(bp) { this._expand = bp; return this; }
    fixed(pos) { this._fixed = pos; return this; }
    fixedTop() { return this.fixed('top'); }
    fixedBottom() { return this.fixed('bottom'); }
    sticky(val = true) { this._sticky = val; return this; }
    container(type) { this._container = type; return this; }
    fluid() { return this.container('container-fluid'); }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('navbar'));
        this._extraClasses.add(SixOrbit.cls('navbar-expand', this._expand));
        this._extraClasses.add(SixOrbit.cls(this._colorScheme === 'dark' ? 'navbar-dark' : 'navbar-light'));
        if (this._background) this._extraClasses.add(SixOrbit.cls('bg', this._background));
        if (this._fixed) this._extraClasses.add(SixOrbit.cls('fixed', this._fixed));
        if (this._sticky) this._extraClasses.add(SixOrbit.cls('sticky-top'));
        return super.buildClassString();
    }

    renderContent() {
        const navbarId = this._id || `navbar-${Math.random().toString(36).substr(2, 9)}`;
        let html = `<div class="${SixOrbit.cls(this._container)}">`;

        html += `<a class="${SixOrbit.cls('navbar-brand')}" href="${this._escapeHtml(this._brandUrl)}">`;
        if (this._brandImage) html += `<img src="${this._escapeHtml(this._brandImage)}" alt="${this._escapeHtml(this._brand || '')}" height="30">`;
        if (this._brand) html += this._escapeHtml(this._brand);
        html += '</a>';

        html += `<button class="${SixOrbit.cls('navbar-toggler')}" type="button" ${SixOrbit.data('toggle')}="collapse" ${SixOrbit.data('target')}="#${navbarId}-collapse">`;
        html += `<span class="${SixOrbit.cls('navbar-toggler-icon')}"></span></button>`;

        html += `<div class="${SixOrbit.cls('collapse')} ${SixOrbit.cls('navbar-collapse')}" id="${navbarId}-collapse">`;
        html += `<ul class="${SixOrbit.cls('navbar-nav')} ${SixOrbit.cls('me-auto')} ${SixOrbit.cls('mb-2')} ${SixOrbit.cls('mb-lg-0')}">`;
        html += this._renderNavItems(this._items);
        html += '</ul>';

        if (this._rightItems.length > 0) {
            html += `<ul class="${SixOrbit.cls('navbar-nav')} ${SixOrbit.cls('mb-2')} ${SixOrbit.cls('mb-lg-0')}">`;
            html += this._renderNavItems(this._rightItems);
            html += '</ul>';
        }

        html += '</div></div>';
        return html;
    }

    _renderNavItems(items) {
        let html = '';
        items.forEach(item => {
            if (item.type === 'dropdown') {
                html += `<li class="${SixOrbit.cls('nav-item')} ${SixOrbit.cls('dropdown')}">`;
                html += `<a class="${SixOrbit.cls('nav-link')} ${SixOrbit.cls('dropdown-toggle')}" href="#" ${SixOrbit.data('toggle')}="dropdown">${this._escapeHtml(item.label)}</a>`;
                html += `<ul class="${SixOrbit.cls('dropdown-menu')}">`;
                (item.items || []).forEach(sub => {
                    if (sub.type === 'divider') {
                        html += `<li><hr class="${SixOrbit.cls('dropdown-divider')}"></li>`;
                    } else {
                        html += `<li><a class="${SixOrbit.cls('dropdown-item')}" href="${this._escapeHtml(sub.url || '#')}">${this._escapeHtml(sub.label)}</a></li>`;
                    }
                });
                html += '</ul></li>';
            } else {
                let linkClass = SixOrbit.cls('nav-link');
                if (item.active) linkClass += ` ${SixOrbit.cls('active')}`;
                if (item.disabled) linkClass += ' disabled';
                html += `<li class="${SixOrbit.cls('nav-item')}">`;
                html += `<a class="${linkClass}" href="${this._escapeHtml(item.url || '#')}"`;
                if (item.active) html += ' aria-current="page"';
                html += `>${this._escapeHtml(item.label)}</a></li>`;
            }
        });
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._brand) config.brand = this._brand;
        if (this._brandUrl !== '/') config.brandUrl = this._brandUrl;
        if (this._brandImage) config.brandImage = this._brandImage;
        if (this._items.length > 0) config.items = this._items;
        if (this._rightItems.length > 0) config.rightItems = this._rightItems;
        if (this._colorScheme !== 'light') config.colorScheme = this._colorScheme;
        if (this._background) config.background = this._background;
        if (this._expand !== 'lg') config.expand = this._expand;
        if (this._fixed) config.fixed = this._fixed;
        if (this._sticky) config.sticky = true;
        if (this._container !== 'container') config.container = this._container;
        return config;
    }
}

export default Navbar;
export { Navbar };
