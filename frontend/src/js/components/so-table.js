// ============================================
// SIXORBIT UI - TABLE COMPONENT
// Interactive data tables with sorting, selection, expansion
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOTable - Interactive data table component
 * Supports sorting, row selection, row expansion, and more
 */
class SOTable extends SOComponent {
  static NAME = 'table';

  static DEFAULTS = {
    sortable: false,           // Enable column sorting
    selectable: false,         // Enable row selection
    expandable: false,         // Enable row expansion
    multiSelect: true,         // Allow multiple row selection
    selectOnClick: true,       // Select row when clicking anywhere on it
    sortColumn: null,          // Initial sort column (index or data-sort value)
    sortDirection: 'asc',      // Initial sort direction ('asc' or 'desc')
    sortIcons: {
      asc: 'arrow_upward',
      desc: 'arrow_downward',
      none: 'unfold_more',
    },
    expandIcon: 'expand_more',
    onSort: null,              // Callback when sorting changes
    onSelect: null,            // Callback when selection changes
    onExpand: null,            // Callback when row expands/collapses
  };

  static EVENTS = {
    SORT: 'table:sort',
    SELECT: 'table:select',
    SELECT_ALL: 'table:selectall',
    DESELECT_ALL: 'table:deselectall',
    EXPAND: 'table:expand',
    COLLAPSE: 'table:collapse',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  /**
   * Initialize the table component
   * @private
   */
  _init() {
    this._cacheElements();
    this._initState();
    this._setupFeatures();
    this._bindEvents();
  }

  /**
   * Cache DOM elements
   * @private
   */
  _cacheElements() {
    this._thead = this.$('thead');
    this._tbody = this.$('tbody');
    this._headers = this._thead ? Array.from(this._thead.querySelectorAll('th')) : [];
    this._rows = this._tbody ? Array.from(this._tbody.querySelectorAll('tr:not(.so-table-expand-row)')) : [];
    this._headerCheckbox = this.$('.so-table-check-all input[type="checkbox"]');
  }

  /**
   * Initialize state
   * @private
   */
  _initState() {
    this._sortColumn = null;
    this._sortDirection = 'asc';
    this._selectedRows = new Set();
    this._expandedRows = new Set();
    this._originalData = [];

    // Store original row data for sorting
    this._rows.forEach((row, index) => {
      row.dataset.rowIndex = index;
      this._originalData.push({
        element: row,
        cells: Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim()),
      });
    });
  }

  /**
   * Set up features based on options
   * @private
   */
  _setupFeatures() {
    // Add feature classes
    if (this.options.sortable) {
      this.addClass('so-table-sortable');
      this._setupSortableHeaders();
    }

    if (this.options.selectable) {
      this.addClass('so-table-selectable');
      this._setupSelectable();
    }

    if (this.options.expandable) {
      this.addClass('so-table-expandable');
      this._setupExpandable();
    }

    // Apply initial sort
    if (this.options.sortColumn !== null) {
      this._applySorting(this.options.sortColumn, this.options.sortDirection);
    }
  }

  /**
   * Set up sortable headers
   * @private
   */
  _setupSortableHeaders() {
    this._headers.forEach((header, index) => {
      const sortKey = header.dataset.sort;
      if (sortKey !== undefined) {
        // Only add sort structure if not already present
        if (!header.querySelector('.so-table-sort')) {
          const content = header.innerHTML;
          header.innerHTML = `
            <span class="so-table-sort">
              <span class="so-table-sort-text">${content}</span>
              <span class="so-table-sort-icon">
                <span class="material-icons">${this.options.sortIcons.none}</span>
              </span>
            </span>
          `;
        }

        // Set ARIA attribute
        header.setAttribute('aria-sort', 'none');
      }
    });
  }

  /**
   * Set up selectable rows
   * @private
   */
  _setupSelectable() {
    // Add checkboxes to rows if they don't exist
    this._rows.forEach((row, index) => {
      if (!row.querySelector('.so-table-check')) {
        const firstCell = row.querySelector('td');
        if (firstCell && firstCell.classList.contains('so-table-check')) {
          return; // Already has checkbox cell
        }
      }
    });
  }

  /**
   * Set up expandable rows
   * @private
   */
  _setupExpandable() {
    this._rows.forEach((row, index) => {
      const expandBtn = row.querySelector('.so-table-expand-btn');
      if (expandBtn && !expandBtn.dataset.initialized) {
        expandBtn.dataset.initialized = 'true';
        const icon = expandBtn.querySelector('.material-icons');
        if (icon) {
          icon.textContent = this.options.expandIcon;
        }
      }
    });
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Sortable headers
    if (this.options.sortable) {
      this.delegate('click', 'th[data-sort]', this._handleHeaderClick);
    }

    // Row selection
    if (this.options.selectable) {
      // Checkbox clicks
      this.delegate('change', '.so-table-check input[type="checkbox"]', this._handleCheckboxChange);

      // Header checkbox (select all)
      if (this._headerCheckbox) {
        this.on('change', this._handleSelectAllChange, this._headerCheckbox);
      }

      // Row click selection
      if (this.options.selectOnClick) {
        this.delegate('click', 'tbody tr:not(.so-table-expand-row)', this._handleRowClick);
      }
    }

    // Row expansion
    if (this.options.expandable) {
      this.delegate('click', '.so-table-expand-btn', this._handleExpandClick);
    }
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  /**
   * Handle header click for sorting
   * @param {Event} e - Click event
   * @param {Element} header - Header element
   * @private
   */
  _handleHeaderClick(e, header) {
    const sortKey = header.dataset.sort;
    const columnIndex = this._headers.indexOf(header);

    if (sortKey === undefined) return;

    // Determine new sort direction
    let direction = 'asc';
    if (this._sortColumn === columnIndex) {
      direction = this._sortDirection === 'asc' ? 'desc' : 'asc';
    }

    this._applySorting(columnIndex, direction);
  }

  /**
   * Handle checkbox change
   * @param {Event} e - Change event
   * @param {Element} checkbox - Checkbox element
   * @private
   */
  _handleCheckboxChange(e, checkbox) {
    e.stopPropagation();
    const row = checkbox.closest('tr');
    if (!row || row.closest('thead')) return;

    const rowIndex = parseInt(row.dataset.rowIndex, 10);

    if (checkbox.checked) {
      this.selectRow(rowIndex);
    } else {
      this.deselectRow(rowIndex);
    }
  }

  /**
   * Handle select all checkbox
   * @param {Event} e - Change event
   * @private
   */
  _handleSelectAllChange(e) {
    if (e.target.checked) {
      this.selectAll();
    } else {
      this.deselectAll();
    }
  }

  /**
   * Handle row click for selection
   * @param {Event} e - Click event
   * @param {Element} row - Row element
   * @private
   */
  _handleRowClick(e, row) {
    // Don't select if clicking on a checkbox, button, link, or checkbox cell
    if (e.target.closest('input, button, a, .so-table-expand-btn, .so-table-check, .so-checkbox')) return;

    const rowIndex = parseInt(row.dataset.rowIndex, 10);

    if (this.options.multiSelect) {
      this.toggleRow(rowIndex);
    } else {
      // Single select - deselect others first
      this.deselectAll();
      this.selectRow(rowIndex);
    }
  }

  /**
   * Handle expand button click
   * @param {Event} e - Click event
   * @param {Element} btn - Expand button element
   * @private
   */
  _handleExpandClick(e, btn) {
    e.stopPropagation();
    const row = btn.closest('tr');
    if (!row) return;

    const rowIndex = parseInt(row.dataset.rowIndex, 10);
    this.toggleExpand(rowIndex);
  }

  // ============================================
  // SORTING METHODS
  // ============================================

  /**
   * Apply sorting to the table
   * @param {number|string} column - Column index or data-sort value
   * @param {string} direction - Sort direction ('asc' or 'desc')
   * @private
   */
  _applySorting(column, direction) {
    // Find column index if string provided
    let columnIndex = column;
    if (typeof column === 'string') {
      columnIndex = this._headers.findIndex(h => h.dataset.sort === column);
    }

    if (columnIndex < 0 || columnIndex >= this._headers.length) return;

    // Update state
    const prevColumn = this._sortColumn;
    this._sortColumn = columnIndex;
    this._sortDirection = direction;

    // Update header icons
    this._headers.forEach((header, index) => {
      const sortKey = header.dataset.sort;
      if (sortKey === undefined) return;

      const icon = header.querySelector('.so-table-sort-icon .material-icons');
      if (!icon) return;

      if (index === columnIndex) {
        header.setAttribute('aria-sort', direction === 'asc' ? 'ascending' : 'descending');
        icon.textContent = this.options.sortIcons[direction];
      } else {
        header.setAttribute('aria-sort', 'none');
        icon.textContent = this.options.sortIcons.none;
      }
    });

    // Sort the data
    const sortedData = [...this._originalData].sort((a, b) => {
      const aVal = a.cells[columnIndex] || '';
      const bVal = b.cells[columnIndex] || '';

      // Try numeric comparison
      const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, ''));
      const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, ''));

      if (!isNaN(aNum) && !isNaN(bNum)) {
        return direction === 'asc' ? aNum - bNum : bNum - aNum;
      }

      // String comparison
      const comparison = aVal.localeCompare(bVal, undefined, { numeric: true, sensitivity: 'base' });
      return direction === 'asc' ? comparison : -comparison;
    });

    // Reorder DOM
    sortedData.forEach(item => {
      this._tbody.appendChild(item.element);
    });

    // Emit event
    this.emit(SOTable.EVENTS.SORT, {
      column: columnIndex,
      columnKey: this._headers[columnIndex]?.dataset.sort,
      direction,
    });

    // Callback
    if (typeof this.options.onSort === 'function') {
      this.options.onSort({
        column: columnIndex,
        columnKey: this._headers[columnIndex]?.dataset.sort,
        direction,
      });
    }
  }

  /**
   * Sort by column
   * @param {number|string} column - Column index or data-sort value
   * @param {string} [direction='asc'] - Sort direction
   */
  sort(column, direction = 'asc') {
    this._applySorting(column, direction);
  }

  /**
   * Clear sorting and restore original order
   */
  clearSort() {
    this._sortColumn = null;
    this._sortDirection = 'asc';

    // Reset header icons
    this._headers.forEach(header => {
      const sortKey = header.dataset.sort;
      if (sortKey === undefined) return;

      header.setAttribute('aria-sort', 'none');
      const icon = header.querySelector('.so-table-sort-icon .material-icons');
      if (icon) {
        icon.textContent = this.options.sortIcons.none;
      }
    });

    // Restore original order
    this._originalData.forEach(item => {
      this._tbody.appendChild(item.element);
    });
  }

  // ============================================
  // SELECTION METHODS
  // ============================================

  /**
   * Select a row by index
   * @param {number} index - Row index
   */
  selectRow(index) {
    const row = this._rows[index];
    if (!row) return;

    this._selectedRows.add(index);
    row.classList.add('so-selected');

    // Update checkbox
    const checkbox = row.querySelector('.so-table-check input[type="checkbox"]');
    if (checkbox) {
      checkbox.checked = true;
    }

    this._updateHeaderCheckbox();

    // Emit event
    this.emit(SOTable.EVENTS.SELECT, {
      rowIndex: index,
      row,
      selected: true,
      selectedRows: this.getSelectedRows(),
    });

    // Callback
    if (typeof this.options.onSelect === 'function') {
      this.options.onSelect({
        rowIndex: index,
        row,
        selected: true,
        selectedRows: this.getSelectedRows(),
      });
    }
  }

  /**
   * Deselect a row by index
   * @param {number} index - Row index
   */
  deselectRow(index) {
    const row = this._rows[index];
    if (!row) return;

    this._selectedRows.delete(index);
    row.classList.remove('so-selected');

    // Update checkbox
    const checkbox = row.querySelector('.so-table-check input[type="checkbox"]');
    if (checkbox) {
      checkbox.checked = false;
    }

    this._updateHeaderCheckbox();

    // Emit event
    this.emit(SOTable.EVENTS.SELECT, {
      rowIndex: index,
      row,
      selected: false,
      selectedRows: this.getSelectedRows(),
    });

    // Callback
    if (typeof this.options.onSelect === 'function') {
      this.options.onSelect({
        rowIndex: index,
        row,
        selected: false,
        selectedRows: this.getSelectedRows(),
      });
    }
  }

  /**
   * Toggle row selection
   * @param {number} index - Row index
   */
  toggleRow(index) {
    if (this._selectedRows.has(index)) {
      this.deselectRow(index);
    } else {
      this.selectRow(index);
    }
  }

  /**
   * Select all rows
   */
  selectAll() {
    this._rows.forEach((row, index) => {
      this._selectedRows.add(index);
      row.classList.add('so-selected');

      const checkbox = row.querySelector('.so-table-check input[type="checkbox"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });

    this._updateHeaderCheckbox();

    // Emit event
    this.emit(SOTable.EVENTS.SELECT_ALL, {
      selectedRows: this.getSelectedRows(),
    });
  }

  /**
   * Deselect all rows
   */
  deselectAll() {
    this._rows.forEach((row, index) => {
      row.classList.remove('so-selected');

      const checkbox = row.querySelector('.so-table-check input[type="checkbox"]');
      if (checkbox) {
        checkbox.checked = false;
      }
    });

    this._selectedRows.clear();
    this._updateHeaderCheckbox();

    // Emit event
    this.emit(SOTable.EVENTS.DESELECT_ALL, {
      selectedRows: [],
    });
  }

  /**
   * Get selected rows
   * @returns {Array} Array of selected row data
   */
  getSelectedRows() {
    return Array.from(this._selectedRows).map(index => ({
      index,
      element: this._rows[index],
      data: this._getRowData(this._rows[index]),
    }));
  }

  /**
   * Get row data from cells
   * @param {Element} row - Row element
   * @returns {Object} Row data
   * @private
   */
  _getRowData(row) {
    const data = {};
    const cells = row.querySelectorAll('td');

    this._headers.forEach((header, index) => {
      const key = header.dataset.sort || header.dataset.key || `col${index}`;
      const cell = cells[index];
      if (cell) {
        data[key] = cell.textContent.trim();
      }
    });

    return data;
  }

  /**
   * Update header checkbox state
   * @private
   */
  _updateHeaderCheckbox() {
    if (!this._headerCheckbox) return;

    const total = this._rows.length;
    const selected = this._selectedRows.size;

    if (selected === 0) {
      this._headerCheckbox.checked = false;
      this._headerCheckbox.indeterminate = false;
    } else if (selected === total) {
      this._headerCheckbox.checked = true;
      this._headerCheckbox.indeterminate = false;
    } else {
      this._headerCheckbox.checked = false;
      this._headerCheckbox.indeterminate = true;
    }
  }

  // ============================================
  // EXPANSION METHODS
  // ============================================

  /**
   * Expand a row
   * @param {number} index - Row index
   */
  expandRow(index) {
    const row = this._rows[index];
    if (!row) return;

    const expandBtn = row.querySelector('.so-table-expand-btn');
    const expandRow = row.nextElementSibling;

    if (!expandRow || !expandRow.classList.contains('so-table-expand-row')) return;

    this._expandedRows.add(index);

    if (expandBtn) {
      expandBtn.classList.add('so-expanded');
    }

    expandRow.removeAttribute('hidden');

    // Emit event
    this.emit(SOTable.EVENTS.EXPAND, {
      rowIndex: index,
      row,
      expandRow,
    });

    // Callback
    if (typeof this.options.onExpand === 'function') {
      this.options.onExpand({
        rowIndex: index,
        row,
        expandRow,
        expanded: true,
      });
    }
  }

  /**
   * Collapse a row
   * @param {number} index - Row index
   */
  collapseRow(index) {
    const row = this._rows[index];
    if (!row) return;

    const expandBtn = row.querySelector('.so-table-expand-btn');
    const expandRow = row.nextElementSibling;

    if (!expandRow || !expandRow.classList.contains('so-table-expand-row')) return;

    this._expandedRows.delete(index);

    if (expandBtn) {
      expandBtn.classList.remove('so-expanded');
    }

    expandRow.setAttribute('hidden', '');

    // Emit event
    this.emit(SOTable.EVENTS.COLLAPSE, {
      rowIndex: index,
      row,
      expandRow,
    });

    // Callback
    if (typeof this.options.onExpand === 'function') {
      this.options.onExpand({
        rowIndex: index,
        row,
        expandRow,
        expanded: false,
      });
    }
  }

  /**
   * Toggle row expansion
   * @param {number} index - Row index
   */
  toggleExpand(index) {
    if (this._expandedRows.has(index)) {
      this.collapseRow(index);
    } else {
      this.expandRow(index);
    }
  }

  /**
   * Expand all rows
   */
  expandAll() {
    this._rows.forEach((row, index) => {
      this.expandRow(index);
    });
  }

  /**
   * Collapse all rows
   */
  collapseAll() {
    this._rows.forEach((row, index) => {
      this.collapseRow(index);
    });
  }

  // ============================================
  // UTILITY METHODS
  // ============================================

  /**
   * Refresh table (re-cache elements and state)
   */
  refresh() {
    this._cacheElements();
    this._initState();

    // Re-apply current sort
    if (this._sortColumn !== null) {
      this._applySorting(this._sortColumn, this._sortDirection);
    }
  }

  /**
   * Get table data as array
   * @returns {Array} Array of row data objects
   */
  getData() {
    return this._rows.map(row => this._getRowData(row));
  }

  /**
   * Get current sort state
   * @returns {Object} Sort state
   */
  getSortState() {
    return {
      column: this._sortColumn,
      columnKey: this._sortColumn !== null ? this._headers[this._sortColumn]?.dataset.sort : null,
      direction: this._sortDirection,
    };
  }

  /**
   * Get selection count
   * @returns {number} Number of selected rows
   */
  getSelectionCount() {
    return this._selectedRows.size;
  }

  /**
   * Check if a row is selected
   * @param {number} index - Row index
   * @returns {boolean} Whether the row is selected
   */
  isSelected(index) {
    return this._selectedRows.has(index);
  }

  /**
   * Check if a row is expanded
   * @param {number} index - Row index
   * @returns {boolean} Whether the row is expanded
   */
  isExpanded(index) {
    return this._expandedRows.has(index);
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Get or create instance
   * @param {Element|string} element - Element or selector
   * @param {Object} [options] - Options
   * @returns {SOTable} Instance
   */
  static getInstance(element, options = {}) {
    const el = typeof element === 'string'
      ? document.querySelector(element)
      : element;

    return SixOrbit.getInstance(el, this.NAME, options);
  }

  /**
   * Initialize all tables on page
   * @param {string} [selector] - Custom selector
   * @param {Object} [options] - Default options
   * @returns {Array<SOTable>} Array of instances
   */
  static initAll(selector, options = {}) {
    const sel = selector || SixOrbit.dataSel(this.NAME);
    const elements = document.querySelectorAll(sel);

    return Array.from(elements).map(el => this.getInstance(el, options));
  }
}

// Register component
SOTable.register = function() {
  SixOrbit.registerComponent(this.NAME, this);
};

// Auto-register
SOTable.register();

// Export
window.SOTable = SOTable;
export default SOTable;
