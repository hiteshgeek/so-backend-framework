// ============================================
// SIXORBIT UI ENGINE - DROPDOWN ELEMENT
// Dropdown menu
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Dropdown extends Element {
    static NAME = 'ui-dropdown';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'dropdown', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._trigger = config.trigger || null;
        this._triggerIcon = config.triggerIcon || null;
        this._items = config.items || [];
        this._direction = config.direction || 'down';
        this._alignment = config.alignment || 'start';
        this._variant = config.variant || 'secondary';
        this._split = config.split || false;
        this._buttonSize = config.size || null;
        this._dark = config.dark || false;
        this._autoClose = config.autoClose !== undefined ? config.autoClose : true;
    }

    trigger(text) { this._trigger = text; return this; }
    triggerIcon(icon) { this._triggerIcon = icon; return this; }
    items(items) { this._items = items; return this; }
    addItem(label, url = null, icon = null, active = false, disabled = false) {
        this._items.push({ type: 'item', label, url, icon, active, disabled });
        return this;
    }
    addDivider() { this._items.push({ type: 'divider' }); return this; }
    addHeader(text) { this._items.push({ type: 'header', label: text }); return this; }
    direction(dir) { this._direction = dir; return this; }
    dropDown() { return this.direction('down'); }
    dropUp() { return this.direction('up'); }
    dropStart() { return this.direction('start'); }
    dropEnd() { return this.direction('end'); }
    alignment(align) { this._alignment = align; return this; }
    alignEnd() { return this.alignment('end'); }
    variant(v) { this._variant = v; return this; }
    primary() { return this.variant('primary'); }
    secondary() { return this.variant('secondary'); }
    split(val = true) { this._split = val; return this; }
    size(s) { this._buttonSize = s; return this; }
    small() { return this.size('sm'); }
    large() { return this.size('lg'); }
    dark(val = true) { this._dark = val; return this; }
    autoClose(val) { this._autoClose = val; return this; }

    buildClassString() {
        if (this._split) {
            this._extraClasses.add(SixOrbit.cls('btn-group'));
        } else {
            this._extraClasses.add(SixOrbit.cls('dropdown'));
        }
        if (this._direction !== 'down') {
            this._extraClasses.add(SixOrbit.cls('drop' + this._direction));
        }
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('ui-init')] = 'dropdown';
        attrs[SixOrbit.data('ui-config')] = JSON.stringify({ autoClose: this._autoClose });
        return attrs;
    }

    renderContent() {
        let html = '';
        let btnClass = `${SixOrbit.cls('btn')} ${SixOrbit.cls('btn', this._variant)}`;
        if (this._buttonSize) btnClass += ` ${SixOrbit.cls('btn', this._buttonSize)}`;

        if (this._split) {
            html += `<button type="button" class="${btnClass}">`;
            if (this._triggerIcon) html += `<span class="material-icons">${this._escapeHtml(this._triggerIcon)}</span> `;
            html += this._escapeHtml(this._trigger || '');
            html += '</button>';
            html += `<button type="button" class="${btnClass} ${SixOrbit.cls('dropdown-toggle')} ${SixOrbit.cls('dropdown-toggle-split')}" ${SixOrbit.data('toggle')}="dropdown" aria-expanded="false">`;
            html += `<span class="${SixOrbit.cls('visually-hidden')}">Toggle Dropdown</span></button>`;
        } else {
            html += `<button type="button" class="${btnClass} ${SixOrbit.cls('dropdown-toggle')}" ${SixOrbit.data('toggle')}="dropdown" aria-expanded="false">`;
            if (this._triggerIcon) html += `<span class="material-icons">${this._escapeHtml(this._triggerIcon)}</span> `;
            html += this._escapeHtml(this._trigger || '');
            html += '</button>';
        }

        let menuClass = SixOrbit.cls('dropdown-menu');
        if (this._alignment === 'end') menuClass += ` ${SixOrbit.cls('dropdown-menu-end')}`;
        if (this._dark) menuClass += ` ${SixOrbit.cls('dropdown-menu-dark')}`;

        html += `<ul class="${menuClass}">`;
        this._items.forEach(item => {
            if (item.type === 'divider') {
                html += `<li><hr class="${SixOrbit.cls('dropdown-divider')}"></li>`;
            } else if (item.type === 'header') {
                html += `<li><h6 class="${SixOrbit.cls('dropdown-header')}">${this._escapeHtml(item.label)}</h6></li>`;
            } else {
                let itemClass = SixOrbit.cls('dropdown-item');
                if (item.active) itemClass += ` ${SixOrbit.cls('active')}`;
                if (item.disabled) itemClass += ' disabled';
                html += '<li>';
                html += `<a class="${itemClass}" href="${this._escapeHtml(item.url || '#')}"`;
                if (item.active) html += ' aria-current="true"';
                html += '>';
                if (item.icon) html += `<span class="material-icons ${SixOrbit.cls('me-2')}">${this._escapeHtml(item.icon)}</span>`;
                html += this._escapeHtml(item.label);
                html += '</a></li>';
            }
        });
        html += '</ul>';
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._trigger) config.trigger = this._trigger;
        if (this._triggerIcon) config.triggerIcon = this._triggerIcon;
        if (this._items.length > 0) config.items = this._items;
        if (this._direction !== 'down') config.direction = this._direction;
        if (this._alignment !== 'start') config.alignment = this._alignment;
        if (this._variant !== 'secondary') config.variant = this._variant;
        if (this._split) config.split = true;
        if (this._buttonSize) config.size = this._buttonSize;
        if (this._dark) config.dark = true;
        if (this._autoClose !== true) config.autoClose = this._autoClose;
        return config;
    }
}

export default Dropdown;
export { Dropdown };
