// ============================================
// SIXORBIT UI ENGINE - TABLE ELEMENT
// Data table display
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Table - Data table element
 */
class Table extends Element {
    static NAME = 'ui-table';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'table',
        tagName: 'table',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._columns = config.columns || [];
        this._rows = config.rows || [];
        this._striped = config.striped || false;
        this._bordered = config.bordered || false;
        this._borderless = config.borderless || false;
        this._hover = config.hover || false;
        this._small = config.small || false;
        this._responsive = config.responsive !== false;
        this._caption = config.caption || null;
        this._captionTop = config.captionTop || false;
        this._variant = config.variant || null;
        this._footer = config.footer || null;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Set columns
     * @param {Array} columns - [{key, label, sortable, width, align, render}]
     * @returns {this}
     */
    columns(columns) {
        this._columns = columns;
        return this;
    }

    /**
     * Add column
     * @param {Object} column
     * @returns {this}
     */
    addColumn(column) {
        this._columns.push(column);
        return this;
    }

    /**
     * Set rows
     * @param {Array} rows
     * @returns {this}
     */
    rows(rows) {
        this._rows = rows;
        return this;
    }

    /**
     * Add row
     * @param {Object} row
     * @returns {this}
     */
    addRow(row) {
        this._rows.push(row);
        return this;
    }

    /**
     * Set striped style
     * @param {boolean} striped
     * @returns {this}
     */
    striped(striped = true) {
        this._striped = striped;
        return this;
    }

    /**
     * Set bordered style
     * @param {boolean} bordered
     * @returns {this}
     */
    bordered(bordered = true) {
        this._bordered = bordered;
        return this;
    }

    /**
     * Set borderless style
     * @param {boolean} borderless
     * @returns {this}
     */
    borderless(borderless = true) {
        this._borderless = borderless;
        return this;
    }

    /**
     * Set hover style
     * @param {boolean} hover
     * @returns {this}
     */
    hover(hover = true) {
        this._hover = hover;
        return this;
    }

    /**
     * Set small size
     * @param {boolean} small
     * @returns {this}
     */
    small(small = true) {
        this._small = small;
        return this;
    }

    /**
     * Set responsive wrapper
     * @param {boolean} responsive
     * @returns {this}
     */
    responsive(responsive = true) {
        this._responsive = responsive;
        return this;
    }

    /**
     * Set caption
     * @param {string} caption
     * @param {boolean} top
     * @returns {this}
     */
    caption(caption, top = false) {
        this._caption = caption;
        this._captionTop = top;
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

    /** Dark variant */
    dark() { return this.variant('dark'); }

    /** Light variant */
    light() { return this.variant('light'); }

    /**
     * Set footer
     * @param {Array} footer - Row data for footer
     * @returns {this}
     */
    footer(footer) {
        this._footer = footer;
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
        this._extraClasses.add(SixOrbit.cls('table'));

        if (this._striped) {
            this._extraClasses.add(SixOrbit.cls('table-striped'));
        }

        if (this._bordered) {
            this._extraClasses.add(SixOrbit.cls('table-bordered'));
        }

        if (this._borderless) {
            this._extraClasses.add(SixOrbit.cls('table-borderless'));
        }

        if (this._hover) {
            this._extraClasses.add(SixOrbit.cls('table-hover'));
        }

        if (this._small) {
            this._extraClasses.add(SixOrbit.cls('table-sm'));
        }

        if (this._variant) {
            this._extraClasses.add(SixOrbit.cls('table', this._variant));
        }

        if (this._captionTop) {
            this._extraClasses.add(SixOrbit.cls('caption-top'));
        }

        return super.buildClassString();
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        // Caption
        if (this._caption) {
            html += `<caption>${this._escapeHtml(this._caption)}</caption>`;
        }

        // Header
        if (this._columns.length > 0) {
            html += '<thead>';
            html += '<tr>';
            this._columns.forEach(col => {
                let thAttrs = '';
                if (col.width) thAttrs += ` style="width: ${col.width}"`;
                if (col.align) thAttrs += ` class="${SixOrbit.cls('text', col.align)}"`;
                html += `<th scope="col"${thAttrs}>${this._escapeHtml(col.label || col.key)}</th>`;
            });
            html += '</tr>';
            html += '</thead>';
        }

        // Body
        html += '<tbody>';
        this._rows.forEach(row => {
            html += '<tr>';
            this._columns.forEach(col => {
                let value = row[col.key];
                if (col.render && typeof col.render === 'function') {
                    value = col.render(value, row);
                } else {
                    value = this._escapeHtml(value ?? '');
                }

                let tdAttrs = '';
                if (col.align) tdAttrs += ` class="${SixOrbit.cls('text', col.align)}"`;
                html += `<td${tdAttrs}>${value}</td>`;
            });
            html += '</tr>';
        });
        html += '</tbody>';

        // Footer
        if (this._footer) {
            html += '<tfoot>';
            html += '<tr>';
            this._footer.forEach((cell, index) => {
                const col = this._columns[index] || {};
                let tdAttrs = '';
                if (col.align) tdAttrs += ` class="${SixOrbit.cls('text', col.align)}"`;
                html += `<td${tdAttrs}>${this._escapeHtml(cell ?? '')}</td>`;
            });
            html += '</tr>';
            html += '</tfoot>';
        }

        return html;
    }

    /**
     * Render element (with optional responsive wrapper)
     * @returns {HTMLElement}
     */
    render() {
        const table = super.render();

        if (this._responsive) {
            const wrapper = document.createElement('div');
            wrapper.className = SixOrbit.cls('table-responsive');
            wrapper.appendChild(table);
            return wrapper;
        }

        return table;
    }

    /**
     * Generate HTML string
     * @returns {string}
     */
    toHtml() {
        const tableHtml = super.toHtml();

        if (this._responsive) {
            return `<div class="${SixOrbit.cls('table-responsive')}">${tableHtml}</div>`;
        }

        return tableHtml;
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

        if (this._columns.length > 0) config.columns = this._columns;
        if (this._rows.length > 0) config.rows = this._rows;
        if (this._striped) config.striped = true;
        if (this._bordered) config.bordered = true;
        if (this._borderless) config.borderless = true;
        if (this._hover) config.hover = true;
        if (this._small) config.small = true;
        if (!this._responsive) config.responsive = false;
        if (this._caption) config.caption = this._caption;
        if (this._captionTop) config.captionTop = true;
        if (this._variant) config.variant = this._variant;
        if (this._footer) config.footer = this._footer;

        return config;
    }
}

export default Table;
export { Table };
