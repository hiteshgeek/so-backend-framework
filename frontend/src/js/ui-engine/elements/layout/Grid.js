// ============================================
// SIXORBIT UI ENGINE - GRID ELEMENT
// CSS Grid layout wrapper
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

class Grid extends ContainerElement {
    static NAME = 'ui-grid';
    static DEFAULTS = { ...ContainerElement.DEFAULTS, type: 'grid', tagName: 'div' };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._columns = config.columns || null;
        this._rows = config.rows || null;
        this._gap = config.gap || null;
        this._rowGap = config.rowGap || null;
        this._columnGap = config.columnGap || null;
        this._justifyItems = config.justifyItems || null;
        this._alignItems = config.alignItems || null;
        this._areas = config.areas || null;
        this._autoFlow = config.autoFlow || null;
    }

    columns(val) { this._columns = val; return this; }
    rows(val) { this._rows = val; return this; }
    gap(val) { this._gap = val; return this; }
    rowGap(val) { this._rowGap = val; return this; }
    columnGap(val) { this._columnGap = val; return this; }
    justifyItems(val) { this._justifyItems = val; return this; }
    alignItems(val) { this._alignItems = val; return this; }
    areas(val) { this._areas = val; return this; }
    autoFlow(val) { this._autoFlow = val; return this; }
    flowRow() { return this.autoFlow('row'); }
    flowColumn() { return this.autoFlow('column'); }
    flowDense() { return this.autoFlow('dense'); }

    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('d-grid'));
        return super.buildClassString();
    }

    buildAttributes() {
        const attrs = super.buildAttributes();
        const styles = [];
        if (this._columns !== null) {
            styles.push(typeof this._columns === 'number'
                ? `grid-template-columns: repeat(${this._columns}, 1fr)`
                : `grid-template-columns: ${this._columns}`);
        }
        if (this._rows !== null) {
            styles.push(typeof this._rows === 'number'
                ? `grid-template-rows: repeat(${this._rows}, 1fr)`
                : `grid-template-rows: ${this._rows}`);
        }
        if (this._gap) styles.push(`gap: ${this._gap}`);
        if (this._rowGap) styles.push(`row-gap: ${this._rowGap}`);
        if (this._columnGap) styles.push(`column-gap: ${this._columnGap}`);
        if (this._justifyItems) styles.push(`justify-items: ${this._justifyItems}`);
        if (this._alignItems) styles.push(`align-items: ${this._alignItems}`);
        if (this._areas) {
            const areasStr = this._areas.map(row => `"${row}"`).join(' ');
            styles.push(`grid-template-areas: ${areasStr}`);
        }
        if (this._autoFlow) styles.push(`grid-auto-flow: ${this._autoFlow}`);
        if (styles.length > 0) {
            attrs.style = (attrs.style || '') + styles.join('; ');
        }
        return attrs;
    }

    renderContent() { return this.renderChildren(); }

    toConfig() {
        const config = super.toConfig();
        if (this._columns !== null) config.columns = this._columns;
        if (this._rows !== null) config.rows = this._rows;
        if (this._gap) config.gap = this._gap;
        if (this._rowGap) config.rowGap = this._rowGap;
        if (this._columnGap) config.columnGap = this._columnGap;
        if (this._justifyItems) config.justifyItems = this._justifyItems;
        if (this._alignItems) config.alignItems = this._alignItems;
        if (this._areas) config.areas = this._areas;
        if (this._autoFlow) config.autoFlow = this._autoFlow;
        return config;
    }
}

export default Grid;
export { Grid };
