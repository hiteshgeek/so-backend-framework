// ============================================
// SIXORBIT UI ENGINE - CONTEXT MENU ELEMENT
// Right-click context menu
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class ContextMenu extends Element {
    static NAME = 'ui-context-menu';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'context-menu', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._items = config.items || [];
        this._target = config.target || null;
        this._dark = config.dark || false;
    }

    items(items) { this._items = items; return this; }
    addItem(label, icon = null, action = null, shortcut = null, disabled = false) {
        this._items.push({ type: 'item', label, icon, action, shortcut, disabled });
        return this;
    }
    addDivider() { this._items.push({ type: 'divider' }); return this; }
    addSubmenu(label, items, icon = null) {
        this._items.push({ type: 'submenu', label, icon, items });
        return this;
    }
    target(selector) { this._target = selector; return this; }
    dark(val = true) { this._dark = val; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('context-menu'));
        if (this._dark) this._extraClasses.add(SixOrbit.cls('context-menu-dark'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('ui-init')] = 'context-menu';
        attrs.role = 'menu';
        attrs['aria-hidden'] = 'true';
        const config = {};
        if (this._target) config.target = this._target;
        attrs[SixOrbit.data('ui-config')] = JSON.stringify(config);
        return attrs;
    }

    renderContent() {
        return this._renderMenuItems(this._items);
    }

    _renderMenuItems(items) {
        let html = `<ul class="${SixOrbit.cls('context-menu-list')}">`;
        items.forEach(item => {
            if (item.type === 'divider') {
                html += `<li class="${SixOrbit.cls('context-menu-divider')}"></li>`;
            } else if (item.type === 'submenu') {
                html += `<li class="${SixOrbit.cls('context-menu-item')} ${SixOrbit.cls('context-menu-submenu')}">`;
                html += `<button type="button" class="${SixOrbit.cls('context-menu-btn')}">`;
                if (item.icon) html += `<span class="material-icons ${SixOrbit.cls('context-menu-icon')}">${this._escapeHtml(item.icon)}</span>`;
                html += `<span class="${SixOrbit.cls('context-menu-label')}">${this._escapeHtml(item.label)}</span>`;
                html += `<span class="material-icons ${SixOrbit.cls('context-menu-arrow')}">chevron_right</span>`;
                html += '</button>';
                html += `<div class="${SixOrbit.cls('context-menu-nested')}">${this._renderMenuItems(item.items || [])}</div>`;
                html += '</li>';
            } else {
                let itemClass = SixOrbit.cls('context-menu-item');
                if (item.disabled) itemClass += ' disabled';
                html += `<li class="${itemClass}">`;
                html += `<button type="button" class="${SixOrbit.cls('context-menu-btn')}"`;
                if (item.action) html += ` ${SixOrbit.data('action')}="${this._escapeHtml(item.action)}"`;
                if (item.disabled) html += ' disabled';
                html += '>';
                if (item.icon) html += `<span class="material-icons ${SixOrbit.cls('context-menu-icon')}">${this._escapeHtml(item.icon)}</span>`;
                html += `<span class="${SixOrbit.cls('context-menu-label')}">${this._escapeHtml(item.label)}</span>`;
                if (item.shortcut) html += `<span class="${SixOrbit.cls('context-menu-shortcut')}">${this._escapeHtml(item.shortcut)}</span>`;
                html += '</button></li>';
            }
        });
        html += '</ul>';
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._items.length > 0) config.items = this._items;
        if (this._target) config.target = this._target;
        if (this._dark) config.dark = true;
        return config;
    }
}

export default ContextMenu;
export { ContextMenu };
