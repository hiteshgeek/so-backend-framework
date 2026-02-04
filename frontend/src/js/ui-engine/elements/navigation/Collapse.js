// ============================================
// SIXORBIT UI ENGINE - COLLAPSE ELEMENT
// Collapsible content
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

class Collapse extends ContainerElement {
    static NAME = 'ui-collapse';
    static DEFAULTS = { ...ContainerElement.DEFAULTS, type: 'collapse', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._collapseContent = config.content || null;
        this._trigger = config.trigger || null;
        this._triggerVariant = config.triggerVariant || 'primary';
        this._expanded = config.expanded || false;
        this._horizontal = config.horizontal || false;
        this._showTrigger = config.showTrigger !== false;
    }

    content(content) { this._collapseContent = content; return this; }
    trigger(text) { this._trigger = text; return this; }
    triggerVariant(v) { this._triggerVariant = v; return this; }
    expanded(val = true) { this._expanded = val; return this; }
    collapsed() { return this.expanded(false); }
    horizontal(val = true) { this._horizontal = val; return this; }
    showTrigger(val = true) { this._showTrigger = val; return this; }
    hideTrigger() { return this.showTrigger(false); }

    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs[SixOrbit.data('ui-init')] = 'collapse';
        attrs[SixOrbit.data('ui-config')] = JSON.stringify({
            expanded: this._expanded,
            horizontal: this._horizontal
        });
        return attrs;
    }

    toHtml() {
        const collapseId = this._id || `collapse-${Math.random().toString(36).substr(2, 9)}`;
        let html = '';

        if (this._showTrigger && this._trigger) {
            const btnClass = `${SixOrbit.cls('btn')} ${SixOrbit.cls('btn', this._triggerVariant)}`;
            html += `<button class="${btnClass}" type="button"`;
            html += ` ${SixOrbit.data('toggle')}="collapse"`;
            html += ` ${SixOrbit.data('target')}="#${collapseId}"`;
            html += ` aria-expanded="${this._expanded}"`;
            html += ` aria-controls="${collapseId}">`;
            html += this._escapeHtml(this._trigger);
            html += '</button>';
        }

        let collapseClass = SixOrbit.cls('collapse');
        if (this._horizontal) collapseClass += ` ${SixOrbit.cls('collapse-horizontal')}`;
        if (this._expanded) collapseClass += ` ${SixOrbit.cls('show')}`;

        html += `<div class="${collapseClass}" id="${collapseId}">`;
        if (this._horizontal) html += `<div class="${SixOrbit.cls('collapse-horizontal-inner')}">`;
        if (this._collapseContent) html += this._collapseContent;
        html += this.renderChildren();
        if (this._horizontal) html += '</div>';
        html += '</div>';

        return html;
    }

    toConfig() {
        const config = super.toConfig();
        if (this._collapseContent) config.content = this._collapseContent;
        if (this._trigger) config.trigger = this._trigger;
        if (this._triggerVariant !== 'primary') config.triggerVariant = this._triggerVariant;
        if (this._expanded) config.expanded = true;
        if (this._horizontal) config.horizontal = true;
        if (!this._showTrigger) config.showTrigger = false;
        return config;
    }
}

export default Collapse;
export { Collapse };
