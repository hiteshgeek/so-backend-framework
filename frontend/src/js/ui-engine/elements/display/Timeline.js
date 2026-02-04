// ============================================
// SIXORBIT UI ENGINE - TIMELINE ELEMENT
// Vertical timeline
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Timeline extends Element {
    static NAME = 'ui-timeline';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'timeline', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._items = config.items || [];
        this._variant = config.variant || 'default';
        this._alternate = config.alternate || false;
    }

    items(items) { this._items = items; return this; }
    addItem(title, content, date = null, icon = null, variant = null) {
        this._items.push({ title, content, date, icon, variant });
        return this;
    }
    variant(v) { this._variant = v; return this; }
    alternate(val = true) { this._alternate = val; return this; }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('timeline'));
        if (this._alternate) this._extraClasses.add(SixOrbit.cls('timeline-alternate'));
        if (this._variant !== 'default') this._extraClasses.add(SixOrbit.cls('timeline', this._variant));
        return super.buildClassString();
    }

    renderContent() {
        let html = '';
        this._items.forEach((item, idx) => {
            const itemVariant = item.variant || this._variant;
            html += `<div class="${SixOrbit.cls('timeline-item')}">`;
            html += `<div class="${SixOrbit.cls('timeline-marker')} ${SixOrbit.cls('bg', itemVariant)}">`;
            if (item.icon) {
                html += `<span class="material-icons">${this._escapeHtml(item.icon)}</span>`;
            }
            html += '</div>';
            html += `<div class="${SixOrbit.cls('timeline-content')}">`;
            if (item.date) {
                html += `<span class="${SixOrbit.cls('timeline-date')}">${this._escapeHtml(item.date)}</span>`;
            }
            if (item.title) {
                html += `<h5 class="${SixOrbit.cls('timeline-title')}">${this._escapeHtml(item.title)}</h5>`;
            }
            if (item.content) {
                html += `<p class="${SixOrbit.cls('timeline-text')}">${this._escapeHtml(item.content)}</p>`;
            }
            html += '</div></div>';
        });
        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._items.length > 0) config.items = this._items;
        if (this._variant !== 'default') config.variant = this._variant;
        if (this._alternate) config.alternate = true;
        return config;
    }
}

export default Timeline;
export { Timeline };
