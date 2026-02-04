/**
 * DataTable Plugin
 * Framework-agnostic plugin for displaying data tables using Tabulator
 * Version: 1.0.0
 *
 * Dependencies: Tabulator, datatable.css, sixorbit-common.css
 *
 * Usage:
 * const dataTable = new DataTable('container-id', {
 *     columns: [...],
 *     data: [...],
 *     dataUrl: 'https://api.example.com/data',
 *     filters: {...}
 * });
 */

(function(global) {
    'use strict';

    const DataTable = function(containerId, options) {
        this.containerId = containerId;
        this.container = document.getElementById(containerId);

        if (!this.container) {
            throw new Error(`Container with id "${containerId}" not found`);
        }

        this.options = Object.assign({
            columns: [],
            data: null,
            dataUrl: null,
            filters: {},
            height: null,
            layout: 'fitData',
            pagination: true,
            paginationSize: 50,
            paginationSizeSelector: [10, 25, 50, 100, 200],
            groupBy: null,
            enableColumnSelection: true,
            enableSearch: true,
            enableGrouping: true,
            onRowClick: null,
            showFooter: false,
            footerTotals: null, // Object with field names as keys and total values
            calcFooterTotals: true, // If true, calculate totals from data; if false, use footerTotals
            cellSpacing: 'normal', // 'compact', 'normal', or 'comfortable'
            enableCellSelection: true, // Enable cell range selection with sum display
            enableRowSelection: true, // Enable row selection with checkboxes
            onRowSelectionChange: null, // Callback when row selection changes
            groupTotalsInline: true, // Show group totals inline with group header instead of separate row
            showSerialNumber: false, // Show S.N. (serial number) column
            actions: [], // Array of action objects: [{ label: 'Edit', icon: 'edit', onClick: fn }, ...]
            onActionClick: null, // Callback when action is clicked: fn(action, rowData)
            enableRowExpand: false, // Enable row expand/collapse with + icon
            onRowExpand: null, // Callback when row is expanded: fn(rowData, callback) - call callback(htmlContent)
            cellVerticalAlign: 'top', // Vertical alignment for cell content: 'top', 'middle', 'bottom'
            exportFilename: 'export', // Base filename for exports (datetime will be appended)
            exportOptions: [] // Custom export options: [{ key: 'myOption', label: 'My Option', type: 'checkbox'|'number'|'text', default: value, group: 'groupName', excelOnly: false }]
        }, options);

        this.state = {
            tableInstance: null,
            selectedColumns: [],
            pendingSelectedColumns: [],
            searchQuery: '',
            currentGroupBy: this.options.groupBy,
            pendingGroupBy: [],
            selectedRows: [],
            cellSelectionActive: false,
            selectedCells: [],
            pinnedColumns: {}, // Track pinned columns: { field: 'left'|'right'|false }
            expandedRows: {}, // Track expanded rows: { rowId: htmlContent }
            originalColumnOrder: null, // Store original column order before grouping for AG Grid-style reordering
            columnWrapSettings: {}, // Track column wrap settings: { field: 'wrap'|'clip' }
            configChanged: false // Track if table config has unsaved changes
        };

        this.init();
    };

    DataTable.prototype.init = function() {
        const self = this;
        this.loadDependencies().then(function() {
            self.render();
            if (self.options.data) {
                self.initializeTable(self.options.data);
            } else if (self.options.dataUrl) {
                self.fetchData();
            }
        });
    };

    DataTable.prototype.loadDependencies = function() {
        const promises = [];

        // Load Google Fonts
        if (!document.querySelector('link[href*="Google+Sans"]')) {
            const fontLink = document.createElement('link');
            fontLink.rel = 'stylesheet';
            fontLink.href = 'https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;700&display=swap';
            document.head.appendChild(fontLink);
        }

        if (!document.querySelector('link[href*="Material+Symbols+Rounded"]')) {
            const iconsLink = document.createElement('link');
            iconsLink.rel = 'stylesheet';
            iconsLink.href = 'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200';
            document.head.appendChild(iconsLink);
        }

        // Load Tabulator CSS
        if (!document.querySelector('link[href*="tabulator"]')) {
            const tabulatorCSS = document.createElement('link');
            tabulatorCSS.rel = 'stylesheet';
            tabulatorCSS.href = 'https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css';
            document.head.appendChild(tabulatorCSS);
        }

        // Load Tabulator JS
        if (typeof Tabulator === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js';
            const loadPromise = new Promise(function(resolve) {
                script.onload = resolve;
            });
            document.head.appendChild(script);
            promises.push(loadPromise);
        }

        return Promise.all(promises);
    };

    DataTable.prototype.getTemplate = function() {
        return `
<div class="dt-statement spacing-${this.options.cellSpacing} valign-${this.options.cellVerticalAlign}">
    <div class="dt-card">
        <!-- Toolbar -->
        <div class="dt-toolbar">
            <div class="dt-toolbar-left">
                ${this.options.enableSearch ? `
                <div class="dt-search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" placeholder="Search..." class="dt-search-input" data-search />
                </div>
                ` : ''}
                ${this.options.pagination ? `
                <div class="dt-page-size-selector">
                    <label>Page Size:</label>
                    <select data-page-size>
                        ${this.options.paginationSizeSelector.map(size =>
                            `<option value="${size}" ${size === this.options.paginationSize ? 'selected' : ''}>${size}</option>`
                        ).join('')}
                    </select>
                </div>
                ` : ''}
            </div>

            <div class="dt-toolbar-right">
                ${this.options.enableColumnSelection ? `
                <div class="dt-dropdown" data-dropdown="columns">
                    <button class="dt-control-btn" data-action="toggle-columns" data-toolbar-item="table-only">
                        <span class="material-symbols-rounded">view_column</span>
                        Columns
                        <span class="dt-control-btn-badge" data-column-badge>${this.options.columns.length}</span>
                    </button>
                    <div class="dt-dropdown-menu" data-dropdown-menu="columns">
                        <div class="dt-dropdown-header">
                            Select Columns
                            <div class="dt-dropdown-header-count" data-column-count></div>
                        </div>
                        <div class="dt-dropdown-body" data-column-list></div>
                        <div class="dt-dropdown-footer">
                            <button class="dt-dropdown-apply-btn" data-action="apply-columns">Apply</button>
                        </div>
                    </div>
                </div>
                ` : ''}

                ${this.options.enableGrouping ? `
                <div class="dt-dropdown" data-dropdown="grouping">
                    <button class="dt-control-btn" data-action="toggle-grouping" data-toolbar-item="table-only">
                        <span class="material-symbols-rounded">group_work</span>
                        Group By
                    </button>
                    <div class="dt-dropdown-menu" data-dropdown-menu="grouping">
                        <div class="dt-grouping-order">
                            <div class="dt-grouping-order-header">Grouping Order (Drag to Reorder)</div>
                            <div class="dt-grouping-order-list" data-grouping-order-list></div>
                        </div>
                        <div class="dt-dropdown-header">Available Columns</div>
                        <div class="dt-dropdown-body" data-group-list></div>
                        <div class="dt-dropdown-footer">
                            <button class="dt-dropdown-apply-btn" data-action="apply-grouping">Apply</button>
                        </div>
                    </div>
                </div>
                ` : ''}

                <button class="dt-control-btn" data-action="open-export" title="Export Data">
                    <span class="material-symbols-rounded">download</span>
                    Export
                </button>

                <div class="dt-valign-dropdown" data-valign-dropdown>
                    <button class="dt-valign-btn" data-valign-toggle title="Vertical Alignment">
                        <span class="material-symbols-rounded" data-valign-icon>${this.options.cellVerticalAlign === 'middle' ? 'vertical_align_center' : this.options.cellVerticalAlign === 'bottom' ? 'vertical_align_bottom' : 'vertical_align_top'}</span>
                        <span class="material-symbols-rounded dt-valign-arrow">arrow_drop_down</span>
                    </button>
                    <div class="dt-valign-menu" data-valign-menu>
                        <div class="dt-valign-option ${this.options.cellVerticalAlign === 'top' ? 'active' : ''}" data-valign="top">
                            <span class="material-symbols-rounded">vertical_align_top</span>
                            <span>Top</span>
                        </div>
                        <div class="dt-valign-option ${this.options.cellVerticalAlign === 'middle' ? 'active' : ''}" data-valign="middle">
                            <span class="material-symbols-rounded">vertical_align_center</span>
                            <span>Middle</span>
                        </div>
                        <div class="dt-valign-option ${this.options.cellVerticalAlign === 'bottom' ? 'active' : ''}" data-valign="bottom">
                            <span class="material-symbols-rounded">vertical_align_bottom</span>
                            <span>Bottom</span>
                        </div>
                    </div>
                </div>

                <button class="dt-control-btn" data-action="refresh">
                    <span class="material-symbols-rounded">refresh</span>
                </button>

                <button class="dt-control-btn" data-action="fullscreen" title="Toggle Fullscreen">
                    <span class="material-symbols-rounded" data-fullscreen-icon>fullscreen</span>
                </button>

                <button class="dt-control-btn dt-save-btn" data-action="save-config" title="Save Table Configuration" disabled>
                    <span class="material-symbols-rounded">save</span>
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="dt-table-container" id="dt-table-${this.containerId}"></div>

        <!-- Multi-Row Operations Toolbar -->
        ${this.options.enableRowSelection ? `
        <div class="dt-row-operations" data-row-operations style="display: none;">
            <div class="dt-row-operations-left">
                <span class="dt-row-operations-count" data-row-operations-count>0 rows selected</span>
            </div>
            <div class="dt-row-operations-right">
                <button class="dt-operation-btn" data-operation="export">
                    <span class="material-symbols-rounded">download</span>
                    Export
                </button>
                <button class="dt-operation-btn" data-operation="delete">
                    <span class="material-symbols-rounded">delete</span>
                    Delete
                </button>
                <button class="dt-operation-btn" data-operation="copy">
                    <span class="material-symbols-rounded">content_copy</span>
                    Copy
                </button>
                <button class="dt-operation-btn" data-operation="print">
                    <span class="material-symbols-rounded">print</span>
                    Print
                </button>
                <div class="dt-operation-more-container">
                    <button class="dt-operation-btn" data-operation-more>
                        <span class="material-symbols-rounded">more_horiz</span>
                        More
                    </button>
                    <div class="dt-operation-more-menu" data-operation-more-menu style="display: none;">
                        <div class="dt-operation-more-item" data-operation="archive">
                            <span class="material-symbols-rounded">archive</span>
                            <span>Archive</span>
                        </div>
                        <div class="dt-operation-more-item" data-operation="share">
                            <span class="material-symbols-rounded">share</span>
                            <span>Share</span>
                        </div>
                        <div class="dt-operation-more-item" data-operation="email">
                            <span class="material-symbols-rounded">email</span>
                            <span>Email</span>
                        </div>
                        <div class="dt-operation-more-item" data-operation="tag">
                            <span class="material-symbols-rounded">label</span>
                            <span>Add Tag</span>
                        </div>
                    </div>
                </div>
                <button class="dt-operation-btn dt-operation-btn-close" data-operation="clear">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>
        </div>
        ` : ''}

        <!-- Cell Selection Summary -->
        ${this.options.enableCellSelection ? `
        <div class="dt-selection-summary" data-selection-summary style="display: none;">
            <span class="dt-selection-summary-label">Selected:</span>
            <span class="dt-selection-summary-count" data-selection-count>0 cells</span>
            <span class="dt-selection-summary-sum" data-selection-sum></span>
        </div>
        ` : ''}

        <!-- Export Popup Modal -->
        <div class="dt-export-modal" data-export-modal style="display: none;">
            <div class="dt-export-modal-backdrop" data-export-modal-close></div>
            <div class="dt-export-modal-content">
                <div class="dt-export-modal-header">
                    <h3 class="dt-export-modal-title">
                        <span class="material-symbols-rounded">download</span>
                        Export Data
                    </h3>
                    <button class="dt-export-modal-close" data-export-modal-close>
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
                <div class="dt-export-modal-body">
                    <div class="dt-export-filename-section">
                        <label class="dt-export-label">Filename</label>
                        <div class="dt-export-filename-input-wrapper">
                            <input type="text" class="dt-export-filename-input" data-export-filename placeholder="Enter filename">
                            <span class="dt-export-filename-ext" data-export-filename-ext>.xlsx</span>
                        </div>
                    </div>
                    <div class="dt-export-format-section">
                        <label class="dt-export-label">Export Format</label>
                        <div class="dt-export-format-row">
                            <div class="dt-export-format-options">
                                <label class="dt-export-format-option">
                                    <input type="radio" name="exportFormat_${this.containerId}" value="xlsx" checked>
                                    <span class="dt-export-format-icon material-symbols-rounded">table_chart</span>
                                    <span>Excel (.xlsx)</span>
                                </label>
                                <label class="dt-export-format-option">
                                    <input type="radio" name="exportFormat_${this.containerId}" value="csv">
                                    <span class="dt-export-format-icon material-symbols-rounded">description</span>
                                    <span>CSV (.csv)</span>
                                </label>
                            </div>
                            <div class="dt-export-additional-dropdown" data-export-additional-dropdown>
                                <button type="button" class="dt-export-additional-btn" data-export-additional-toggle>
                                    <span class="material-symbols-rounded">tune</span>
                                    <span>Options</span>
                                    <span class="dt-export-options-count" data-export-options-count></span>
                                    <span class="material-symbols-rounded dt-export-additional-arrow">expand_more</span>
                                </button>
                                <div class="dt-export-additional-menu" data-export-additional-menu>
                                    <!-- Options will be populated dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dt-export-columns-section">
                        <div class="dt-export-columns-toolbar">
                            <label class="dt-export-label">Columns to Export</label>
                            <div class="dt-export-columns-actions">
                                <span class="dt-export-columns-count" data-export-columns-count>0 of 0 selected</span>
                            </div>
                        </div>
                        <div class="dt-export-columns-table">
                            <div class="dt-export-columns-header">
                                <div class="dt-export-col-check">
                                    <input type="checkbox" class="dt-export-select-all-checkbox" data-export-select-all checked>
                                </div>
                                <div class="dt-export-col-name">Column</div>
                                <div class="dt-export-col-type">Type</div>
                                <div class="dt-export-col-format">Format Options</div>
                                <div class="dt-export-col-align">Align</div>
                            </div>
                            <div class="dt-export-columns-list" data-export-columns-list>
                                <!-- Columns will be populated dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dt-export-modal-footer">
                    <button class="dt-export-btn-cancel" data-export-modal-close>Cancel</button>
                    <button class="dt-export-btn-download" data-export-download>
                        <span class="material-symbols-rounded">download</span>
                        Download
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
`;
    };

    DataTable.prototype.render = function() {
        this.container.innerHTML = this.getTemplate();
        this.attachEventListeners();
        this.populateColumnSelector();
        this.populateGroupingSelector();
    };

    DataTable.prototype.attachEventListeners = function() {
        const self = this;
        const container = this.container.querySelector('.dt-statement');

        // Search
        if (this.options.enableSearch) {
            const searchInput = container.querySelector('[data-search]');
            searchInput.addEventListener('input', function(e) {
                self.state.searchQuery = e.target.value;
                if (self.state.tableInstance) {
                    self.state.tableInstance.setFilter(self.customFilter.bind(self));
                }
            });
        }

        // Page Size Selector
        if (this.options.pagination) {
            const pageSizeSelect = container.querySelector('[data-page-size]');
            if (pageSizeSelect) {
                pageSizeSelect.addEventListener('change', function(e) {
                    const newSize = parseInt(e.target.value);
                    if (self.state.tableInstance) {
                        self.state.tableInstance.setPageSize(newSize);
                    }
                });
            }
        }

        // Toggle Columns Dropdown
        const toggleColumnsBtn = container.querySelector('[data-action="toggle-columns"]');
        if (toggleColumnsBtn) {
            toggleColumnsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.toggleDropdown('columns');
            });
        }

        // Apply Columns Selection
        const applyColumnsBtn = container.querySelector('[data-action="apply-columns"]');
        if (applyColumnsBtn) {
            applyColumnsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.applyColumnSelection();
                self.toggleDropdown('columns');
            });
        }

        // Toggle Grouping Dropdown
        const toggleGroupingBtn = container.querySelector('[data-action="toggle-grouping"]');
        if (toggleGroupingBtn) {
            toggleGroupingBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.toggleDropdown('grouping');
            });
        }

        // Apply Grouping Selection
        const applyGroupingBtn = container.querySelector('[data-action="apply-grouping"]');
        if (applyGroupingBtn) {
            applyGroupingBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.applyGrouping();
                self.toggleDropdown('grouping');
            });
        }

        // Open Export popup
        const openExportBtn = container.querySelector('[data-action="open-export"]');
        if (openExportBtn) {
            openExportBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.showExportPopup();
            });
        }

        // Export modal close buttons
        const exportModalCloseButtons = container.querySelectorAll('[data-export-modal-close]');
        exportModalCloseButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.hideExportPopup();
            });
        });

        // Export download button
        const exportDownloadBtn = container.querySelector('[data-export-download]');
        if (exportDownloadBtn) {
            exportDownloadBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                self.executeExport();
            });
        }

        // Export select all checkbox
        const exportSelectAllCheckbox = container.querySelector('[data-export-select-all]');
        if (exportSelectAllCheckbox) {
            exportSelectAllCheckbox.addEventListener('change', function(e) {
                e.stopPropagation();
                self.exportSelectAll(this.checked);
            });
        }

        // Refresh
        const refreshBtn = container.querySelector('[data-action="refresh"]');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                self.fetchData();
            });
        }

        // Fullscreen Toggle
        const fullscreenBtn = container.querySelector('[data-action="fullscreen"]');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function() {
                self.toggleFullscreen();
            });
        }

        // Vertical Alignment Dropdown
        const valignToggle = container.querySelector('[data-valign-toggle]');
        const valignMenu = container.querySelector('[data-valign-menu]');
        const valignOptions = container.querySelectorAll('[data-valign]');

        if (valignToggle && valignMenu) {
            valignToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                valignMenu.classList.toggle('show');
            });

            valignOptions.forEach(function(option) {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const alignment = this.dataset.valign;
                    self.setCellVerticalAlign(alignment);

                    // Update active state on options
                    valignOptions.forEach(function(o) {
                        o.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Update the dropdown button icon
                    const icons = { top: 'vertical_align_top', middle: 'vertical_align_center', bottom: 'vertical_align_bottom' };
                    const iconEl = container.querySelector('[data-valign-icon]');
                    if (iconEl) {
                        iconEl.textContent = icons[alignment];
                    }

                    // Close the menu
                    valignMenu.classList.remove('show');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function() {
                valignMenu.classList.remove('show');
            });
        }

        // Save Config Button
        const saveConfigBtn = container.querySelector('[data-action="save-config"]');
        if (saveConfigBtn) {
            saveConfigBtn.addEventListener('click', function() {
                self.saveTableConfig();
            });
        }

        // Row Operations Event Listeners
        if (this.options.enableRowSelection) {
            const operationBtns = container.querySelectorAll('[data-operation]');
            operationBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const operation = this.dataset.operation;

                    if (operation === 'clear') {
                        self.deselectAllRows();
                    } else {
                        self.handleRowOperation(operation);
                    }
                });
            });

            // More button dropdown event listeners
            const moreBtn = container.querySelector('[data-operation-more]');
            const moreMenu = container.querySelector('[data-operation-more-menu]');

            if (moreBtn && moreMenu) {
                moreBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isVisible = moreMenu.style.display === 'block';
                    moreMenu.style.display = isVisible ? 'none' : 'block';
                });

                // More menu item clicks
                const moreItems = moreMenu.querySelectorAll('[data-operation]');
                moreItems.forEach(function(item) {
                    item.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const operation = this.dataset.operation;
                        self.handleRowOperation(operation);
                        moreMenu.style.display = 'none';
                    });
                });

                // Close more menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.dt-operation-more-container')) {
                        moreMenu.style.display = 'none';
                    }
                });
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Check if click is inside any dropdown or button
            const clickedInsideDropdown = e.target.closest('.dt-dropdown-menu');
            const clickedButton = e.target.closest('.dt-control-btn');

            if (!clickedInsideDropdown && !clickedButton) {
                const dropdowns = container.querySelectorAll('.dt-dropdown-menu');
                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.remove('show');
                });
                // Update button states based on actual usage, not just close state
                self.updateButtonStates();
            }
        });
    };

    DataTable.prototype.populateColumnSelector = function() {
        if (!this.options.enableColumnSelection) return;

        const columnList = this.container.querySelector('[data-column-list]');
        const self = this;

        this.state.selectedColumns = this.options.columns.map(function(col) { return col.field; });
        this.state.pendingSelectedColumns = this.state.selectedColumns.slice();

        // Initialize pinned columns from column definitions
        this.options.columns.forEach(function(col) {
            if (col.frozen === true || col.frozen === 'left') {
                self.state.pinnedColumns[col.field] = 'left';
            } else if (col.frozen === 'right') {
                self.state.pinnedColumns[col.field] = 'right';
            }
        });

        // Get column order from state or use default
        // This order is preserved - pinned columns are only visually reordered during table rendering
        if (!this.state.columnOrder) {
            this.state.columnOrder = this.options.columns.map(function(col) { return col.field; });
        }

        // Display columns in their original order (not reordered by pinning)
        // Pinned columns will be visually positioned correctly in the table, but the list shows original order
        let html = '';
        this.state.columnOrder.forEach(function(field) {
            const column = self.options.columns.find(function(col) { return col.field === field; });
            if (!column) return;

            const pinned = self.state.pinnedColumns[column.field] || false;
            const pinLeftClass = pinned === 'left' ? 'active' : '';
            const pinRightClass = pinned === 'right' ? 'active' : '';

            // Get wrap setting - check state first, then column config, default to 'clip'
            const wrapSetting = self.state.columnWrapSettings[column.field] || (column.wrap ? 'wrap' : 'clip');

            html += `
                <div class="dt-dropdown-item dt-column-item" data-column-field="${column.field}" draggable="true">
                    <span class="dt-column-drag-handle material-symbols-rounded" title="Drag to reorder">drag_indicator</span>
                    <input type="checkbox" value="${column.field}" checked data-column-toggle />
                    <span class="dt-column-name">${column.title}</span>
                    <div class="dt-column-controls">
                        <div class="dt-wrap-dropdown" data-wrap-dropdown="${column.field}">
                            <button class="dt-wrap-btn" data-wrap-toggle="${column.field}" title="Text wrapping">
                                <span class="material-symbols-rounded">${wrapSetting === 'wrap' ? 'wrap_text' : 'notes'}</span>
                                <span class="material-symbols-rounded dt-wrap-arrow">arrow_drop_down</span>
                            </button>
                            <div class="dt-wrap-menu" data-wrap-menu="${column.field}">
                                <div class="dt-wrap-option ${wrapSetting === 'clip' ? 'active' : ''}" data-wrap-value="clip" data-wrap-field="${column.field}">
                                    <span class="material-symbols-rounded">notes</span>
                                    <span>Clip</span>
                                </div>
                                <div class="dt-wrap-option ${wrapSetting === 'wrap' ? 'active' : ''}" data-wrap-value="wrap" data-wrap-field="${column.field}">
                                    <span class="material-symbols-rounded">wrap_text</span>
                                    <span>Wrap</span>
                                </div>
                            </div>
                        </div>
                        <button class="dt-resize-btn" data-resize-column="${column.field}" title="Auto-resize column">
                            <span class="material-symbols-rounded">width_normal</span>
                        </button>
                        <div class="dt-column-pin-controls">
                            <button class="dt-pin-btn ${pinLeftClass}" data-pin-column="${column.field}" data-pin-direction="left" title="Pin to left">
                                <span class="material-symbols-rounded">push_pin</span>
                            </button>
                            <button class="dt-pin-btn ${pinRightClass}" data-pin-column="${column.field}" data-pin-direction="right" title="Pin to right">
                                <span class="material-symbols-rounded">push_pin</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        columnList.innerHTML = html;

        // Update column count display
        this.updateColumnCount();

        // Add event listeners for checkboxes
        const checkboxes = columnList.querySelectorAll('[data-column-toggle]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                const field = this.value;
                if (this.checked) {
                    if (!self.state.pendingSelectedColumns.includes(field)) {
                        self.state.pendingSelectedColumns.push(field);
                    }
                } else {
                    self.state.pendingSelectedColumns = self.state.pendingSelectedColumns.filter(function(f) {
                        return f !== field;
                    });
                }
                self.updateColumnCount();
            });
        });

        // Add event listeners for resize buttons
        const resizeButtons = columnList.querySelectorAll('[data-resize-column]');
        resizeButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const field = this.dataset.resizeColumn;
                self.autoResizeColumn(field);
            });
        });

        // Add event listeners for pin buttons
        const pinButtons = columnList.querySelectorAll('[data-pin-column]');
        pinButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const field = this.dataset.pinColumn;
                const direction = this.dataset.pinDirection;
                self.toggleColumnPin(field, direction);
            });
        });

        // Add event listeners for wrap dropdown toggles
        const wrapToggles = columnList.querySelectorAll('[data-wrap-toggle]');
        wrapToggles.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const field = this.dataset.wrapToggle;
                const menu = columnList.querySelector('[data-wrap-menu="' + field + '"]');

                // Close all other wrap menus
                columnList.querySelectorAll('.dt-wrap-menu').forEach(function(m) {
                    if (m !== menu) m.classList.remove('show');
                });

                // Toggle this menu
                menu.classList.toggle('show');
            });
        });

        // Add event listeners for wrap options
        const wrapOptions = columnList.querySelectorAll('[data-wrap-value]');
        wrapOptions.forEach(function(option) {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                const field = this.dataset.wrapField;
                const value = this.dataset.wrapValue;
                self.setColumnWrap(field, value);

                // Close the menu
                const menu = this.closest('.dt-wrap-menu');
                if (menu) menu.classList.remove('show');
            });
        });

        // Close wrap menus when clicking outside
        document.addEventListener('click', function() {
            columnList.querySelectorAll('.dt-wrap-menu').forEach(function(m) {
                m.classList.remove('show');
            });
        });

        // Add drag and drop for reordering
        const columnItems = columnList.querySelectorAll('.dt-column-item');
        let draggedItem = null;

        columnItems.forEach(function(item) {
            // Scroll to column and highlight on hover
            item.addEventListener('mouseenter', function() {
                const field = this.dataset.columnField;
                self.scrollToColumn(field);
                self.highlightColumn(field, true);
            });

            item.addEventListener('mouseleave', function() {
                const field = this.dataset.columnField;
                self.highlightColumn(field, false);
            });

            item.addEventListener('dragstart', function(e) {
                draggedItem = this;
                this.style.opacity = '0.5';
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.innerHTML);
            });

            item.addEventListener('dragend', function() {
                this.style.opacity = '1';
            });

            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';

                if (this === draggedItem) return;

                // Check if the dragged item and target have compatible pinning
                const draggedField = draggedItem.dataset.columnField;
                const targetField = this.dataset.columnField;
                const draggedPin = self.state.pinnedColumns[draggedField] || false;
                const targetPin = self.state.pinnedColumns[targetField] || false;

                // Only allow reordering within the same pin group
                if (draggedPin !== targetPin) {
                    e.dataTransfer.dropEffect = 'none';
                    return;
                }

                const rect = this.getBoundingClientRect();
                const midpoint = rect.top + rect.height / 2;

                if (e.clientY < midpoint) {
                    this.parentNode.insertBefore(draggedItem, this);
                } else {
                    this.parentNode.insertBefore(draggedItem, this.nextSibling);
                }
            });

            item.addEventListener('drop', function(e) {
                e.stopPropagation();

                // Update column order in state
                const items = Array.from(columnList.querySelectorAll('.dt-column-item'));
                const newOrder = items.map(function(item) {
                    return item.dataset.columnField;
                });

                // Enforce pinned column order: left-pinned, unpinned, right-pinned
                const leftPinned = [];
                const unpinned = [];
                const rightPinned = [];

                newOrder.forEach(function(field) {
                    const pin = self.state.pinnedColumns[field];
                    if (pin === 'left') {
                        leftPinned.push(field);
                    } else if (pin === 'right') {
                        rightPinned.push(field);
                    } else {
                        unpinned.push(field);
                    }
                });

                // Combine in correct order
                self.state.columnOrder = leftPinned.concat(unpinned, rightPinned);

                // Mark config as changed
                self.markConfigChanged();

                // Apply the new order to the table immediately
                self.applyColumnOrder();

                return false;
            });
        });
    };

    DataTable.prototype.updateColumnCount = function() {
        const countElement = this.container.querySelector('[data-column-count]');
        const badgeElement = this.container.querySelector('[data-column-badge]');
        const totalColumns = this.options.columns.length;
        const selectedColumns = this.state.pendingSelectedColumns.length;

        if (countElement) {
            countElement.textContent = selectedColumns + ' of ' + totalColumns + ' selected';
        }

        if (badgeElement) {
            badgeElement.textContent = selectedColumns;
        }
    };

    DataTable.prototype.applyColumnSelection = function() {
        this.state.selectedColumns = this.state.pendingSelectedColumns.slice();
        if (this.state.tableInstance) {
            // Apply column order if changed
            this.applyColumnOrder();
            this.updateVisibleColumns();
        }
        this.updateButtonStates();
    };

    DataTable.prototype.applyColumnOrder = function() {
        if (!this.state.columnOrder || !this.state.tableInstance) return;

        // Rebuild table with new column order
        const currentData = this.state.tableInstance.getData();
        this.initializeTable(currentData);
    };

    DataTable.prototype.populateGroupingSelector = function() {
        if (!this.options.enableGrouping) return;

        const groupList = this.container.querySelector('[data-group-list]');
        const orderList = this.container.querySelector('[data-grouping-order-list]');
        const self = this;

        // Initialize pendingGroupBy with current grouping
        if (Array.isArray(this.state.currentGroupBy)) {
            this.state.pendingGroupBy = this.state.currentGroupBy.slice();
        } else if (this.state.currentGroupBy) {
            this.state.pendingGroupBy = [this.state.currentGroupBy];
        } else {
            this.state.pendingGroupBy = [];
        }

        // Render grouping order list
        this.renderGroupingOrder();

        // Populate available columns checkboxes
        let html = '';
        this.options.columns.forEach(function(column) {
            const isChecked = self.state.pendingGroupBy.includes(column.field);
            html += `
                <div class="dt-dropdown-item">
                    <input type="checkbox" value="${column.field}" ${isChecked ? 'checked' : ''} data-group-toggle />
                    <span>${column.title}</span>
                </div>
            `;
        });

        groupList.innerHTML = html;

        // Add event listeners for checkboxes
        const checkboxes = groupList.querySelectorAll('[data-group-toggle]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                const field = this.value;
                if (this.checked) {
                    if (!self.state.pendingGroupBy.includes(field)) {
                        self.state.pendingGroupBy.push(field);
                        self.renderGroupingOrder();
                    }
                } else {
                    self.state.pendingGroupBy = self.state.pendingGroupBy.filter(function(f) {
                        return f !== field;
                    });
                    self.renderGroupingOrder();

                    // Uncheck the checkbox
                    checkbox.checked = false;
                }
            });
        });
    };

    DataTable.prototype.renderGroupingOrder = function() {
        const orderList = this.container.querySelector('[data-grouping-order-list]');
        const self = this;

        if (!orderList) return;

        if (this.state.pendingGroupBy.length === 0) {
            orderList.innerHTML = '<div class="dt-grouping-order-empty">No columns selected for grouping</div>';
            return;
        }

        let html = '';
        this.state.pendingGroupBy.forEach(function(field, index) {
            const column = self.options.columns.find(function(col) { return col.field === field; });
            if (column) {
                html += `
                    <div class="dt-grouping-order-item" draggable="true" data-field="${field}" data-index="${index}">
                        <span class="dt-grouping-order-number">${index + 1}</span>
                        <span class="material-symbols-rounded dt-grouping-order-drag-handle">drag_indicator</span>
                        <span class="dt-grouping-order-name">${column.title}</span>
                        <span class="material-symbols-rounded dt-grouping-order-remove" data-remove-group="${field}">close</span>
                    </div>
                `;
            }
        });

        orderList.innerHTML = html;

        // Add drag and drop event listeners
        const items = orderList.querySelectorAll('.dt-grouping-order-item');
        items.forEach(function(item) {
            item.addEventListener('dragstart', function(e) {
                e.stopPropagation();
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.innerHTML);
                e.dataTransfer.setData('field', this.dataset.field);
            });

            item.addEventListener('dragend', function(e) {
                e.stopPropagation();
                this.classList.remove('dragging');
                orderList.querySelectorAll('.dt-grouping-order-item').forEach(function(i) {
                    i.classList.remove('drag-over');
                });
            });

            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.dataTransfer.dropEffect = 'move';

                const draggingItem = orderList.querySelector('.dragging');
                if (draggingItem && draggingItem !== this) {
                    this.classList.add('drag-over');
                }
            });

            item.addEventListener('dragleave', function(e) {
                e.stopPropagation();
                this.classList.remove('drag-over');
            });

            item.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const draggingItem = orderList.querySelector('.dragging');
                if (draggingItem && draggingItem !== this) {
                    const fromField = draggingItem.dataset.field;
                    const toField = this.dataset.field;

                    // Reorder pendingGroupBy array
                    const fromIndex = self.state.pendingGroupBy.indexOf(fromField);
                    const toIndex = self.state.pendingGroupBy.indexOf(toField);

                    self.state.pendingGroupBy.splice(fromIndex, 1);
                    self.state.pendingGroupBy.splice(toIndex, 0, fromField);

                    self.renderGroupingOrder();
                }

                this.classList.remove('drag-over');
            });
        });

        // Add remove button event listeners
        const removeButtons = orderList.querySelectorAll('[data-remove-group]');
        removeButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const field = this.dataset.removeGroup;
                self.state.pendingGroupBy = self.state.pendingGroupBy.filter(function(f) {
                    return f !== field;
                });
                self.renderGroupingOrder();

                // Uncheck the checkbox in the available columns list
                const checkbox = self.container.querySelector(`[data-group-toggle][value="${field}"]`);
                if (checkbox) {
                    checkbox.checked = false;
                }
            });
        });
    };

    DataTable.prototype.applyGrouping = function() {
        var needsReinit = false;

        if (this.state.pendingGroupBy.length === 0) {
            // Removing grouping - restore original column order if saved
            this.state.currentGroupBy = null;
            if (this.state.originalColumnOrder) {
                this.state.columnOrder = this.state.originalColumnOrder.slice();
                this.state.originalColumnOrder = null;
                needsReinit = true;
            }
            if (this.state.tableInstance) {
                this.state.tableInstance.setGroupBy(false);
            }
        } else {
            // Applying grouping - move grouped columns to left (AG Grid style)
            // Save original order if not already saved
            if (!this.state.originalColumnOrder) {
                this.state.originalColumnOrder = this.state.columnOrder ? this.state.columnOrder.slice() :
                    this.options.columns.map(function(col) { return col.field; });
            }

            // Get grouped fields as array
            var groupFields = this.state.pendingGroupBy.length === 1 ?
                [this.state.pendingGroupBy[0]] : this.state.pendingGroupBy.slice();

            // Reorder columns: grouped columns first (in grouping order), then remaining columns
            var currentOrder = this.state.columnOrder ? this.state.columnOrder.slice() :
                this.options.columns.map(function(col) { return col.field; });

            // Remove grouped fields from current order
            var remainingColumns = currentOrder.filter(function(field) {
                return groupFields.indexOf(field) === -1;
            });

            // New order: grouped fields first, then remaining
            this.state.columnOrder = groupFields.concat(remainingColumns);
            needsReinit = true;

            if (this.state.pendingGroupBy.length === 1) {
                this.state.currentGroupBy = this.state.pendingGroupBy[0];
            } else {
                this.state.currentGroupBy = this.state.pendingGroupBy.slice();
            }
        }

        // Reinitialize table if column order changed
        if (needsReinit && this.state.tableInstance) {
            var data = this.state.tableInstance.getData();
            this.initializeTable(data);
            this.populateColumnSelector();
        } else if (this.state.tableInstance) {
            // Just update grouping without reinit
            if (this.state.currentGroupBy) {
                this.state.tableInstance.setGroupBy(
                    Array.isArray(this.state.currentGroupBy) ? this.state.currentGroupBy : this.state.currentGroupBy
                );
            }
        }

        this.updateButtonStates();
    };

    DataTable.prototype.toggleDropdown = function(dropdownName) {
        const dropdown = this.container.querySelector(`[data-dropdown-menu="${dropdownName}"]`);
        const button = this.container.querySelector(`[data-dropdown="${dropdownName}"] .dt-control-btn`);
        const self = this;

        // Close all other dropdowns
        const allDropdowns = this.container.querySelectorAll('.dt-dropdown-menu');
        allDropdowns.forEach(function(d) {
            if (d !== dropdown) d.classList.remove('show');
        });

        // Toggle current dropdown
        if (dropdown) {
            const isCurrentlyOpen = dropdown.classList.contains('show');
            dropdown.classList.toggle('show');

            // If opening, add active class and position the dropdown
            // If closing, let updateButtonStates decide if it should stay active
            if (button) {
                if (!isCurrentlyOpen) {
                    button.classList.add('active');
                    // Position dropdown intelligently based on available space
                    self.positionDropdown(button, dropdown);
                } else {
                    // Closing - update state based on actual feature usage
                    self.updateButtonStates();
                }
            }
        }
    };

    DataTable.prototype.positionDropdown = function(button, dropdown) {
        const self = this;

        // Get the table container for relative positioning
        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        const tableHolder = tableEl ? tableEl.querySelector('.tabulator-tableholder') : null;

        if (!tableHolder) return;

        // Get button and dropdown dimensions
        const buttonRect = button.getBoundingClientRect();
        const dropdownRect = dropdown.getBoundingClientRect();
        const tableRect = tableHolder.getBoundingClientRect();

        // Calculate available space on left and right within the table
        const spaceOnLeft = buttonRect.right - tableRect.left;
        const spaceOnRight = tableRect.right - buttonRect.right;

        // Determine horizontal position based on available space in table
        // Prefer left side (default), only open right if insufficient space on left
        if (spaceOnLeft >= dropdownRect.width) {
            // Open to the left (default) - enough space available
            dropdown.style.left = 'auto';
            dropdown.style.right = '0';
        } else if (spaceOnRight >= dropdownRect.width) {
            // Open to the right - not enough space on left but enough on right
            dropdown.style.right = 'auto';
            dropdown.style.left = '0';
        } else {
            // Not enough space on either side, use the side with more space
            if (spaceOnLeft > spaceOnRight) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '0';
            } else {
                dropdown.style.right = 'auto';
                dropdown.style.left = '0';
            }
        }

        // Calculate optimal dropdown height based on table height
        // The dropdown should fit within the table bounds, accounting for:
        // - Space from bottom of button to bottom of table
        // - Padding for visual breathing room (20px)
        const spaceFromButtonToTableBottom = tableRect.bottom - buttonRect.bottom;
        const dropdownMaxHeight = spaceFromButtonToTableBottom - 20;

        // Set dynamic max-height
        // Minimum: 250px to ensure usability
        // Maximum: 600px to prevent excessively tall dropdowns, or available space
        const maxHeight = Math.max(250, Math.min(600, dropdownMaxHeight));
        dropdown.style.maxHeight = maxHeight + 'px';
    };

    DataTable.prototype.updateButtonStates = function() {
        // Update Columns button state - active if some columns are hidden
        const columnsBtn = this.container.querySelector('[data-action="toggle-columns"]');
        if (columnsBtn) {
            const totalColumns = this.options.columns.length;
            const selectedColumns = this.state.selectedColumns.length;
            const hasHiddenColumns = selectedColumns < totalColumns;

            if (hasHiddenColumns) {
                columnsBtn.classList.add('active');
            } else {
                columnsBtn.classList.remove('active');
            }
        }

        // Update Group By button state - active if grouping is applied
        const groupingBtn = this.container.querySelector('[data-action="toggle-grouping"]');
        if (groupingBtn) {
            const hasGrouping = this.state.currentGroupBy &&
                (Array.isArray(this.state.currentGroupBy) ? this.state.currentGroupBy.length > 0 : true);

            if (hasGrouping) {
                groupingBtn.classList.add('active');
            } else {
                groupingBtn.classList.remove('active');
            }
        }
    };

    DataTable.prototype.updateVisibleColumns = function() {
        const columns = this.state.tableInstance.getColumns();
        columns.forEach(function(column) {
            const field = column.getField();
            const definition = column.getDefinition();

            // Skip columns without a field (like row selection checkbox, S.N. column, and Actions column)
            // Also skip if column has 'serial-number-column' or 'dt-actions-column' CSS class
            if (!field ||
                (definition.cssClass &&
                 (definition.cssClass.includes('serial-number-column') ||
                  definition.cssClass.includes('dt-actions-column')))) {
                return;
            }

            const shouldShow = this.state.selectedColumns.includes(field);
            if (shouldShow) {
                column.show();
            } else {
                column.hide();
            }
        }.bind(this));
    };

    DataTable.prototype.customFilter = function(data, filterParams) {
        if (!this.state.searchQuery) return true;

        const query = this.state.searchQuery.toLowerCase();
        return Object.values(data).some(function(value) {
            return String(value).toLowerCase().includes(query);
        });
    };

    DataTable.prototype.fetchData = function() {
        if (!this.options.dataUrl) return;

        const self = this;
        const url = new URL(this.options.dataUrl);

        // Add filters to URL
        Object.keys(this.options.filters).forEach(function(key) {
            url.searchParams.append(key, self.options.filters[key]);
        });

        fetch(url.toString())
            .then(function(response) { return response.json(); })
            .then(function(data) {
                self.initializeTable(data);
            })
            .catch(function(error) {
                console.error('Error fetching data:', error);
                alert('Failed to fetch data. Using sample data instead.');
                self.initializeTable([]);
            });
    };

    DataTable.prototype.calculateFooterTotals = function(data) {
        const totals = {};
        const self = this;

        if (!data || data.length === 0) {
            return totals;
        }

        // Initialize totals for numeric columns
        this.options.columns.forEach(function(column) {
            if (column.field) {
                totals[column.field] = 0;
            }
        });

        // Calculate totals
        data.forEach(function(row) {
            self.options.columns.forEach(function(column) {
                const value = row[column.field];
                if (typeof value === 'number') {
                    totals[column.field] += value;
                }
            });
        });

        return totals;
    };

    DataTable.prototype.initializeTable = function(data) {
        const self = this;
        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);

        // Add row expand/collapse column if enabled
        let columns = [];
        if (this.options.enableRowExpand) {
            columns.push({
                title: '',
                field: '_expand',
                frozen: true,
                width: 50,
                headerSort: false,
                resizable: false,
                hozAlign: 'center',
                vertAlign: 'middle',
                cssClass: 'dt-expand-column',
                formatter: function(cell) {
                    const rowId = cell.getRow().getPosition();
                    const isExpanded = self.state.expandedRows[rowId];
                    const icon = isExpanded ? 'remove' : 'add';
                    return '<button class="dt-expand-btn" data-row-id="' + rowId + '" title="' + (isExpanded ? 'Collapse' : 'Expand') + '"><span class="material-symbols-rounded">' + icon + '</span></button>';
                },
                cellClick: function(e, cell) {
                    e.stopPropagation();
                    const btn = e.target.closest('.dt-expand-btn');
                    if (btn) {
                        self.toggleRowExpand(cell);
                    }
                },
                bottomCalc: function() {
                    return ''; // Prevent any content in footer
                }
            });
        }

        // Add row selection checkbox column if enabled
        if (this.options.enableRowSelection) {
            columns.push({
                formatter: 'rowSelection',
                titleFormatter: function(cell) {
                    // Create custom header checkbox with indeterminate support
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'dt-bulk-select-checkbox';
                    checkbox.addEventListener('change', function(e) {
                        if (self.state.tableInstance) {
                            if (checkbox.checked) {
                                self.state.tableInstance.selectRow();
                            } else {
                                self.state.tableInstance.deselectRow();
                            }
                        }
                    });
                    return checkbox;
                },
                hozAlign: 'center',
                headerSort: false,
                frozen: true,
                width: 50,
                cssClass: 'row-selection-checkbox',
                cellClick: function(e, cell) {
                    e.stopPropagation();
                },
                bottomCalc: function() {
                    return ''; // Prevent any content in footer
                }
            });
        }

        // Add serial number column if enabled
        if (this.options.showSerialNumber) {
            columns.push({
                title: 'S.N.',
                frozen: true,
                width: 45,
                headerSort: false,
                hozAlign: 'center',
                headerHozAlign: 'center',
                vertAlign: 'middle',
                formatter: function(cell) {
                    // Get the row's position among all data rows
                    var row = cell.getRow();
                    var table = row.getTable();

                    // Get all data rows (excludes group rows)
                    var allDataRows = table.getRows("active");
                    var rowIndex = allDataRows.indexOf(row);

                    if (rowIndex === -1) return '';

                    // rowIndex is already the position in the full dataset (0-based)
                    // Just add 1 to make it 1-based
                    return rowIndex + 1;
                },
                cssClass: 'serial-number-column',
                headerVertAlign: 'middle',
                bottomCalc: function() {
                    return ''; // Prevent any content in footer
                }
            });
        }

        // Prepare columns with footer calculations, pinning, sorting, and header menu
        // Use visual column order for rendering (left pinned first, unpinned middle, right pinned last)
        // This does not affect the actual column order stored in state
        const visualColumnOrder = this.getVisualColumnOrder();

        const dataColumns = visualColumnOrder.map(function(field) {
            const col = self.options.columns.find(function(c) { return c.field === field; });
            if (!col) return null;

            const column = Object.assign({}, col);

            // Apply stored column width if user has resized this column
            if (self.state.columnWidths && self.state.columnWidths[field]) {
                column.width = self.state.columnWidths[field];
            }

            // Apply column color if specified
            if (col.color) {
                var colorClass = 'dt-col-' + col.color;
                column.cssClass = column.cssClass ? column.cssClass + ' ' + colorClass : colorClass;
            }

            // Enable sorting for all columns by default
            if (column.headerSort === undefined) {
                column.headerSort = true;
            }

            // Enable resizing for all columns (including frozen/pinned)
            if (column.resizable === undefined) {
                column.resizable = true;
            }

            // Auto-detect numeric columns and right-align them
            // Check if column has numeric formatter or if data appears to be numeric
            var isNumericColumn = false;
            if (col.formatter === 'money' || col.formatter === 'number' || col.formatter === 'progress') {
                isNumericColumn = true;
            } else if (col.hozAlign === 'right') {
                // Already specified as right-aligned, likely numeric
                isNumericColumn = true;
            } else if (data && data.length > 0) {
                // Check first few rows of data to detect if column is numeric
                var sampleSize = Math.min(5, data.length);
                var numericCount = 0;
                for (var i = 0; i < sampleSize; i++) {
                    var value = data[i][col.field];
                    if (typeof value === 'number') {
                        numericCount++;
                    }
                }
                // If majority of samples are numeric, treat as numeric column
                if (numericCount > sampleSize / 2) {
                    isNumericColumn = true;
                }
            }

            // Apply right alignment for numeric columns
            if (isNumericColumn && column.hozAlign === undefined) {
                column.hozAlign = 'right';
                column.headerHozAlign = 'right';
            }

            // Handle wrap option - allow content to wrap instead of truncating
            // Check state first (user changed via UI), then column config
            var shouldWrap = self.state.columnWrapSettings[col.field] === 'wrap' ||
                             (self.state.columnWrapSettings[col.field] === undefined && col.wrap === true);
            if (shouldWrap) {
                // Store original formatter if exists
                var originalFormatter = column.formatter;
                var originalFormatterParams = column.formatterParams;

                // Create wrapper formatter that wraps content in a div with wrap styling
                column.formatter = function(cell, formatterParams, onRendered) {
                    var value = cell.getValue();

                    // If there was an original formatter, apply it first
                    if (originalFormatter && typeof originalFormatter === 'function') {
                        value = originalFormatter(cell, originalFormatterParams, onRendered);
                    } else if (originalFormatter === 'money') {
                        // Handle built-in money formatter
                        var params = originalFormatterParams || {};
                        var symbol = params.symbol || '$';
                        var precision = params.precision !== undefined ? params.precision : 2;
                        value = symbol + Number(value).toLocaleString(undefined, {
                            minimumFractionDigits: precision,
                            maximumFractionDigits: precision
                        });
                    }

                    return '<div class="dt-wrap-cell">' + (value !== null && value !== undefined ? value : '') + '</div>';
                };
            }

            // Add header menu function for each column
            column.headerMenu = function() {
                const menu = [];
                const field = col.field;
                const currentPin = self.state.pinnedColumns[field];

                // Sort options
                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">arrow_upward</span>Sort Ascending',
                    action: function(e, column) {
                        column.getTable().setSort(field, 'asc');
                    }
                });

                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">arrow_downward</span>Sort Descending',
                    action: function(e, column) {
                        column.getTable().setSort(field, 'desc');
                    }
                });

                menu.push({
                    separator: true
                });

                // Pin options
                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">push_pin</span>Pin Column<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-left:auto;">chevron_right</span>',
                    menu: [
                        {
                            label: '<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-right:6px;transform:rotate(-45deg);display:inline-block;">push_pin</span>Pin Left',
                            cssClass: currentPin === 'left' ? 'dt-menu-item-selected' : '',
                            action: function(e, column) {
                                self.toggleColumnPin(field, 'left');
                            }
                        },
                        {
                            label: '<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-right:6px;transform:rotate(45deg);display:inline-block;">push_pin</span>Pin Right',
                            cssClass: currentPin === 'right' ? 'dt-menu-item-selected' : '',
                            action: function(e, column) {
                                self.toggleColumnPin(field, 'right');
                            }
                        },
                        {
                            label: '<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-right:6px;">block</span>No Pin',
                            cssClass: !currentPin ? 'dt-menu-item-selected' : '',
                            action: function(e, column) {
                                delete self.state.pinnedColumns[field];
                                const data = self.state.tableInstance.getData();
                                self.initializeTable(data);
                                self.populateColumnSelector();
                            }
                        }
                    ]
                });

                menu.push({
                    separator: true
                });

                // Text wrapping options
                const currentWrap = self.state.columnWrapSettings[field] || (col.wrap ? 'wrap' : 'clip');
                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">wrap_text</span>Text Wrapping<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-left:auto;">chevron_right</span>',
                    menu: [
                        {
                            label: '<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-right:6px;">notes</span>Clip',
                            cssClass: currentWrap === 'clip' ? 'dt-menu-item-selected' : '',
                            action: function(e, column) {
                                self.setColumnWrap(field, 'clip');
                            }
                        },
                        {
                            label: '<span class="material-symbols-rounded" style="font-size:16px;vertical-align:middle;margin-right:6px;">wrap_text</span>Wrap',
                            cssClass: currentWrap === 'wrap' ? 'dt-menu-item-selected' : '',
                            action: function(e, column) {
                                self.setColumnWrap(field, 'wrap');
                            }
                        }
                    ]
                });

                menu.push({
                    separator: true
                });

                // Column sizing options
                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">width_normal</span>Autosize This Column',
                    action: function(e, column) {
                        self.autoResizeColumn(field);
                    }
                });

                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">view_week</span>Autosize All Columns',
                    action: function(e, column) {
                        column.getTable().redraw(true);
                    }
                });

                menu.push({
                    separator: true
                });

                // Reset options
                menu.push({
                    label: '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;margin-right:8px;">restart_alt</span>Reset Columns',
                    action: function(e, column) {
                        // Reset all pinning
                        self.state.pinnedColumns = {};
                        const data = self.state.tableInstance.getData();
                        self.initializeTable(data);
                        self.populateColumnSelector();
                    }
                });

                return menu;
            };

            // Handle column pinning from state (UI-controlled) or initial config
            const pinnedDirection = self.state.pinnedColumns[col.field] || col.frozen;
            if (pinnedDirection === true || pinnedDirection === 'left') {
                column.frozen = true;
            } else if (pinnedDirection === 'right') {
                column.frozen = true;
                column.frozenRight = true;
            } else {
                // Explicitly remove freezing if unpinned
                delete column.frozen;
                delete column.frozenRight;
            }

            if (self.options.showFooter) {
                // Add bottom calc function for totals
                column.bottomCalc = function(values, data, calcParams) {
                    // If using server-side totals
                    if (!self.options.calcFooterTotals && self.options.footerTotals) {
                        return self.options.footerTotals[col.field] || '';
                    }

                    // Calculate from data
                    if (values.length === 0) {
                        return '';
                    }

                    // Check if all values are numbers
                    const numericValues = values.filter(function(v) {
                        return typeof v === 'number';
                    });

                    if (numericValues.length === 0) {
                        // Return empty for non-numeric columns (first column might show "Total")
                        if (col === self.options.columns[0]) {
                            return 'Total';
                        }
                        return '';
                    }

                    // Sum the values
                    const sum = numericValues.reduce(function(acc, val) {
                        return acc + val;
                    }, 0);

                    return sum;
                };

                // Apply formatter to footer if column has formatter
                if (col.formatter) {
                    column.bottomCalcFormatter = col.formatter;
                    column.bottomCalcFormatterParams = col.formatterParams;
                }
            }

            return column;
        }).filter(function(col) { return col !== null; }); // Filter out null columns

        // Combine checkbox column with data columns
        columns = columns.concat(dataColumns);

        // Add Actions column if actions are defined
        if (this.options.actions && this.options.actions.length > 0) {
            columns.push({
                title: '',
                field: '_actions',
                frozen: 'right',
                width: 36,
                headerSort: false,
                resizable: false,
                hozAlign: 'center',
                vertAlign: 'middle',
                cssClass: 'dt-actions-column',
                formatter: function(cell) {
                    return '<button class="dt-actions-btn" data-row-id="' + cell.getRow().getPosition() + '" title="Actions"><span class="material-symbols-rounded">more_vert</span></button>';
                },
                cellClick: function(e, cell) {
                    e.stopPropagation();
                    const btn = e.target.closest('.dt-actions-btn');
                    if (btn) {
                        self.showActionsMenu(cell, btn);
                    }
                },
                bottomCalc: function() {
                    return ''; // Prevent any content in footer
                }
            });
        }

        const tabulatorConfig = {
            data: data,
            columns: columns,
            selectableRows: this.options.enableRowSelection,
            layout: this.options.layout,
            pagination: this.options.pagination,
            paginationSize: this.options.paginationSize,
            paginationSizeSelector: this.options.paginationSizeSelector,
            groupBy: this.state.currentGroupBy,
            columnCalcs: "table", // Show calculations only at table level, not in groups (we show inline in group header)
            columnHeaderVertAlign: 'middle',
            groupHeader: function(value, count, data, group) {
                // If inline totals are enabled, calculate and display totals aligned with columns (AG Grid style)
                if (self.options.groupTotalsInline && data && data.length > 0) {
                    // Get grouped fields to know which column shows the group value
                    var groupFields = self.state.currentGroupBy;
                    if (!Array.isArray(groupFields)) {
                        groupFields = groupFields ? [groupFields] : [];
                    }

                    // Determine which group level this is (0-based)
                    // Use the group component to get the field for this group level
                    var groupLevel = 0;
                    var currentGroupField = groupFields[0]; // Default to first group field

                    if (group && typeof group.getField === 'function') {
                        // Tabulator 5.x provides getField() method
                        currentGroupField = group.getField();
                        groupLevel = groupFields.indexOf(currentGroupField);
                    } else if (groupFields.length > 1) {
                        // Fallback: Try to determine level by checking data values
                        // Check if this field's value matches the group value
                        for (var i = 0; i < groupFields.length; i++) {
                            var field = groupFields[i];
                            var firstValue = data[0][field];
                            if (String(firstValue) === String(value)) {
                                currentGroupField = field;
                                groupLevel = i;
                                break;
                            }
                        }
                    }

                    // Build header with column-aligned values
                    let headerHTML = '<div class="dt-group-header-row" data-group-value="' + value + '" data-group-level="' + groupLevel + '">';

                    // Get current column order
                    var columnOrder = self.state.columnOrder || self.options.columns.map(function(c) { return c.field; });

                    // Calculate aggregates for each column
                    columnOrder.forEach(function(field) {
                        var col = self.options.columns.find(function(c) { return c.field === field; });
                        if (!col) return;

                        // Check if this column is visible
                        if (self.state.selectedColumns && self.state.selectedColumns.indexOf(field) === -1) {
                            return;
                        }

                        let cellHTML = '<span class="dt-group-cell" data-field="' + field + '">';

                        // If this is the current group's column, show the group value with count
                        if (field === currentGroupField) {
                            cellHTML += '<span class="dt-group-value">' + value + '</span>';
                            cellHTML += '<span class="dt-group-count">(' + count + ' items)</span>';
                        } else {
                            // For other columns, show aggregate if numeric
                            var values = data.map(function(row) {
                                return row[field];
                            }).filter(function(v) {
                                return typeof v === 'number';
                            });

                            if (values.length > 0) {
                                var sum = values.reduce(function(acc, val) {
                                    return acc + val;
                                }, 0);

                                // Format the value using column formatter if available
                                var formattedValue = sum;
                                if (col.formatter === 'money') {
                                    var params = col.formatterParams || {};
                                    var symbol = params.symbol || '$';
                                    var precision = params.precision !== undefined ? params.precision : 2;
                                    formattedValue = symbol + sum.toLocaleString(undefined, {
                                        minimumFractionDigits: precision,
                                        maximumFractionDigits: precision
                                    });
                                } else {
                                    formattedValue = sum.toLocaleString();
                                }

                                cellHTML += '<span class="dt-group-aggregate">' + formattedValue + '</span>';
                            }
                        }

                        cellHTML += '</span>';
                        headerHTML += cellHTML;
                    });

                    headerHTML += '</div>';
                    return headerHTML;
                } else {
                    // Default grouping header without inline totals
                    return value + " <span class='dt-group-count'>(" + count + " items)</span>";
                }
            },
            rowClick: function(e, row) {
                if (self.options.onRowClick) {
                    self.options.onRowClick(row.getData());
                }
            }
        };

        // Enable cell selection - Tabulator 5.5 range selection
        if (this.options.enableCellSelection) {
            // Enable range selection by click and drag
            tabulatorConfig.selectableRange = true;
        }

        // Enable column resizing for all columns including frozen/pinned
        tabulatorConfig.resizableColumns = true;
        tabulatorConfig.resizableColumnFit = true;
        tabulatorConfig.resizableColumnGuide = true;

        // Check if any column has wrap enabled - if so, enable variable row height
        // Check both state settings and column config
        var hasWrapColumn = this.options.columns.some(function(col) {
            return self.state.columnWrapSettings[col.field] === 'wrap' ||
                   (self.state.columnWrapSettings[col.field] === undefined && col.wrap === true);
        });
        if (hasWrapColumn) {
            tabulatorConfig.rowHeight = null; // Allow variable row heights
        }

        // Set height to use flexbox layout or custom height
        if (this.options.height) {
            tabulatorConfig.height = this.options.height;
        } else {
            tabulatorConfig.height = "100%";
        }

        this.state.tableInstance = new Tabulator(tableEl, tabulatorConfig);

        // Fix header layout after Tabulator renders
        this.state.tableInstance.on('tableBuilt', function() {
            self.fixHeaderLayout();
            self.addRightClickMenuToHeaders();
            self.updatePageInfo();
        });

        // Also fix layout after any redraw
        this.state.tableInstance.on('renderComplete', function() {
            self.fixHeaderLayout();
            self.updatePageInfo();

            // Clear inline height styles from rows and cells for variable height rows
            if (hasWrapColumn) {
                setTimeout(function() {
                    var rows = tableEl.querySelectorAll('.tabulator-row:not(.tabulator-calcs)');
                    rows.forEach(function(row) {
                        row.style.height = '';
                        var cells = row.querySelectorAll('.tabulator-cell');
                        cells.forEach(function(cell) {
                            cell.style.height = '';
                        });
                    });
                    // Also clear height from column resize handles
                    var resizeHandles = tableEl.querySelectorAll('.tabulator-col-resize-handle');
                    resizeHandles.forEach(function(handle) {
                        handle.style.height = '';
                    });
                }, 0);
            }
        });

        // Fix layout after sorting
        this.state.tableInstance.on('dataSorted', function() {
            self.fixHeaderLayout();
        });

        // Handle virtual scrolling - align group cells on scroll (no debounce for instant response)
        this.state.tableInstance.on('scrollVertical', function() {
            self.alignGroupHeaderCells(false); // false = use cached positions
        });

        // Handle column resize - recalculate and update group cell widths
        this.state.tableInstance.on('columnResized', function(column) {
            // Store the resized column width in state to persist across redraws
            var field = column.getField();
            var newWidth = column.getWidth();
            if (field && newWidth) {
                if (!self.state.columnWidths) {
                    self.state.columnWidths = {};
                }
                self.state.columnWidths[field] = newWidth;

                // Mark config as changed
                self.markConfigChanged();
            }

            // Clear positioned markers so all rows get updated
            var positionedRows = tableEl.querySelectorAll('.dt-group-header-row[data-positioned]');
            positionedRows.forEach(function(row) {
                row.removeAttribute('data-positioned');
            });
            self.alignGroupHeaderCells(true); // true = recalculate positions

            // Force row height recalculation for wrapped content
            // Clear inline height styles set by Tabulator so CSS height:auto takes effect
            if (hasWrapColumn) {
                setTimeout(function() {
                    var rows = tableEl.querySelectorAll('.tabulator-row:not(.tabulator-calcs)');
                    rows.forEach(function(row) {
                        row.style.height = '';
                        // Also clear height from cells
                        var cells = row.querySelectorAll('.tabulator-cell');
                        cells.forEach(function(cell) {
                            cell.style.height = '';
                        });
                    });
                    // Also clear height from column resize handles
                    var resizeHandles = tableEl.querySelectorAll('.tabulator-col-resize-handle');
                    resizeHandles.forEach(function(handle) {
                        handle.style.height = '';
                    });
                }, 0);
            }
        });

        // Update page info on pagination
        this.state.tableInstance.on('pageLoaded', function() {
            self.updatePageInfo();
            // Clear expanded rows state on page change
            self.state.expandedRows = {};
            // Trigger a redraw to fix frozen column heights, then restore column widths
            setTimeout(function() {
                if (self.state.tableInstance) {
                    self.state.tableInstance.redraw(true);
                    // Restore stored column widths after redraw
                    if (self.state.columnWidths) {
                        Object.keys(self.state.columnWidths).forEach(function(field) {
                            var column = self.state.tableInstance.getColumn(field);
                            if (column) {
                                column.setWidth(self.state.columnWidths[field]);
                            }
                        });
                    }
                }
            }, 0);
        });

        // Add row selection event listeners
        if (this.options.enableRowSelection) {
            this.state.tableInstance.on('rowSelectionChanged', function(data, rows) {
                self.state.selectedRows = data;
                self.updateRowOperationsToolbar(data.length);
                self.updateBulkSelectionCheckbox();

                if (self.options.onRowSelectionChange) {
                    self.options.onRowSelectionChange(data, rows);
                }
            });

            // Also listen for individual row select/deselect events
            this.state.tableInstance.on('rowSelected', function(row) {
                self.state.selectedRows = self.state.tableInstance.getSelectedData();
                self.updateBulkSelectionCheckbox();
            });

            this.state.tableInstance.on('rowDeselected', function(row) {
                self.state.selectedRows = self.state.tableInstance.getSelectedData();
                self.updateBulkSelectionCheckbox();
            });
        }

        // Add cell selection event listeners
        if (this.options.enableCellSelection) {
            // Listen for range selection events
            this.state.tableInstance.on('rangeSelected', function(cells) {
                self.handleCellSelection(cells);
            });

            // Also listen for range cleared
            this.state.tableInstance.on('rangeCleared', function() {
                const summaryEl = self.container.querySelector('[data-selection-summary]');
                if (summaryEl) {
                    summaryEl.style.display = 'none';
                }
            });
        }
    };

    DataTable.prototype.fixHeaderLayout = function() {
        // This function manually fixes header layout issues after Tabulator renders
        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        if (!tableEl) return;

        // Force sort arrows to be visible when sorted
        const sortedColumns = tableEl.querySelectorAll('.tabulator-col[aria-sort]');
        sortedColumns.forEach(function(col) {
            const title = col.querySelector('.tabulator-col-title');
            if (title) {
                // Add a data attribute to help CSS target sorted columns
                title.setAttribute('data-sorted', 'true');
                // Force the ::after pseudo-element to show by adding a visible class
                col.classList.add('dt-sorted-column');
            }
        });

        // Remove the sorted class from non-sorted columns
        const unsortedColumns = tableEl.querySelectorAll('.tabulator-col:not([aria-sort])');
        unsortedColumns.forEach(function(col) {
            col.classList.remove('dt-sorted-column');
            const title = col.querySelector('.tabulator-col-title');
            if (title) {
                title.removeAttribute('data-sorted');
            }
        });

        // Align group header cells with their respective columns
        this.alignGroupHeaderCells();
    };

    // Align group header cells to match column positions (AG Grid style)
    // recalculate: if true, recalculate column positions; if false, use cached positions
    DataTable.prototype.alignGroupHeaderCells = function(recalculate) {
        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        if (!tableEl || !this.state.currentGroupBy) return;

        // Get all group rows
        const groupRows = tableEl.querySelectorAll('.tabulator-group');
        if (groupRows.length === 0) return;

        // Recalculate column positions if needed or if not cached
        if (recalculate !== false || !this.state.cachedColumnPositions) {
            const headerCols = tableEl.querySelectorAll('.tabulator-headers .tabulator-col');
            if (headerCols.length === 0) return;

            const headerContainer = tableEl.querySelector('.tabulator-headers');
            if (!headerContainer) return;
            const headerContainerRect = headerContainer.getBoundingClientRect();

            // Build a map of field -> {left relative to header container, width}
            this.state.cachedColumnPositions = {};

            var self = this;
            headerCols.forEach(function(col) {
                const field = col.getAttribute('tabulator-field');
                if (field) {
                    const colRect = col.getBoundingClientRect();
                    self.state.cachedColumnPositions[field] = {
                        left: colRect.left - headerContainerRect.left,
                        width: col.offsetWidth
                    };
                }
            });
        }

        const columnPositions = this.state.cachedColumnPositions;
        if (!columnPositions) return;

        // Apply positions to each group row's cells
        groupRows.forEach(function(groupRow) {
            const headerRowEl = groupRow.querySelector('.dt-group-header-row');
            if (!headerRowEl) return;

            // Check if already positioned (optimization)
            if (headerRowEl.getAttribute('data-positioned') === 'true') return;

            const cells = headerRowEl.querySelectorAll('.dt-group-cell');
            cells.forEach(function(cell) {
                const field = cell.getAttribute('data-field');
                if (field && columnPositions[field]) {
                    const pos = columnPositions[field];
                    cell.style.cssText = 'position: absolute; left: ' + pos.left + 'px; width: ' + pos.width + 'px;';
                }
            });

            // Mark as positioned
            headerRowEl.setAttribute('data-positioned', 'true');
        });
    };


    DataTable.prototype.autoResizeColumn = function(field) {
        if (!this.state.tableInstance) return;

        var self = this;

        // Get the column by field
        const column = this.state.tableInstance.getColumn(field);
        if (column) {
            // Calculate max content width
            const cells = column.getCells();
            let maxWidth = 0;

            // Check header width
            const headerElement = column.getElement();
            if (headerElement) {
                const colContent = headerElement.querySelector('.tabulator-col-content');
                if (colContent) {
                    // Temporarily remove width constraint to measure natural width
                    const headerWidth = colContent.scrollWidth + 24; // Add padding
                    maxWidth = Math.max(maxWidth, headerWidth);
                }
            }

            // Check cell widths - need to measure actual content width
            cells.forEach(function(cell) {
                const cellElement = cell.getElement();
                if (cellElement) {
                    // Get the actual content width
                    const cellContent = cellElement.firstChild;
                    if (cellContent && cellContent.scrollWidth) {
                        const cellWidth = cellContent.scrollWidth + 24; // Add padding
                        maxWidth = Math.max(maxWidth, cellWidth);
                    } else {
                        // Fallback: measure text content
                        const textContent = cellElement.textContent || '';
                        const tempSpan = document.createElement('span');
                        tempSpan.style.visibility = 'hidden';
                        tempSpan.style.position = 'absolute';
                        tempSpan.style.whiteSpace = 'nowrap';
                        tempSpan.style.font = window.getComputedStyle(cellElement).font;
                        tempSpan.textContent = textContent;
                        document.body.appendChild(tempSpan);
                        const cellWidth = tempSpan.offsetWidth + 24; // Add padding
                        document.body.removeChild(tempSpan);
                        maxWidth = Math.max(maxWidth, cellWidth);
                    }
                }
            });

            // Set minimum and maximum bounds
            maxWidth = Math.max(80, Math.min(maxWidth, 500));

            // Use Tabulator's setWidth method to actually resize the column
            column.setWidth(maxWidth);

            // Store the new width in state to persist across redraws
            if (!self.state.columnWidths) {
                self.state.columnWidths = {};
            }
            self.state.columnWidths[field] = maxWidth;
        }
    };

    DataTable.prototype.updatePageInfo = function() {
        if (!this.state.tableInstance || !this.options.pagination) return;

        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        if (!tableEl) return;

        // Get pagination info
        const page = this.state.tableInstance.getPage();
        const pageSize = this.state.tableInstance.getPageSize();
        const totalRows = this.state.tableInstance.getDataCount();

        // Calculate range
        const startRow = totalRows === 0 ? 0 : ((page - 1) * pageSize) + 1;
        const endRow = Math.min(page * pageSize, totalRows);

        // Find or create the page info element
        let pageCounter = tableEl.querySelector('.tabulator-page-counter');
        if (pageCounter) {
            pageCounter.textContent = 'Showing ' + startRow + '-' + endRow + ' of ' + totalRows + ' rows';
        }
    };

    DataTable.prototype.addRightClickMenuToHeaders = function() {
        // Add right-click context menu to column headers
        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        if (!tableEl) return;

        const columns = tableEl.querySelectorAll('.tabulator-col');
        columns.forEach(function(colEl) {
            colEl.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                // Find the header menu button
                const menuButton = colEl.querySelector('.tabulator-header-popup-button');
                if (menuButton) {
                    // Create a synthetic click event with the correct coordinates
                    const clickEvent = new MouseEvent('click', {
                        bubbles: true,
                        cancelable: true,
                        view: window,
                        clientX: e.clientX,
                        clientY: e.clientY,
                        screenX: e.screenX,
                        screenY: e.screenY
                    });
                    menuButton.dispatchEvent(clickEvent);
                }
            });
        });
    };

    DataTable.prototype.handleCellSelection = function(cells) {
        this.state.selectedCells = cells;

        const summaryEl = this.container.querySelector('[data-selection-summary]');
        const countEl = this.container.querySelector('[data-selection-count]');
        const sumEl = this.container.querySelector('[data-selection-sum]');

        if (!summaryEl || !countEl || !sumEl) return;

        if (!cells || cells.length === 0) {
            summaryEl.style.display = 'none';
            return;
        }

        // Extract values from cells
        const values = [];
        const numericValues = [];

        cells.forEach(function(cell) {
            const value = cell.getValue();
            values.push(value);

            if (typeof value === 'number') {
                numericValues.push(value);
            }
        });

        // Update count
        countEl.textContent = cells.length + ' cell' + (cells.length !== 1 ? 's' : '');

        // Calculate and display sum if there are numeric values
        if (numericValues.length > 0) {
            const sum = numericValues.reduce(function(acc, val) {
                return acc + val;
            }, 0);

            sumEl.textContent = ' | Sum: ' + sum.toLocaleString();
            sumEl.style.display = '';
        } else {
            sumEl.textContent = '';
            sumEl.style.display = 'none';
        }

        summaryEl.style.display = 'flex';
    };

    DataTable.prototype.setData = function(data) {
        if (this.state.tableInstance) {
            this.state.tableInstance.setData(data);
        }
    };

    DataTable.prototype.setFilters = function(filters) {
        this.options.filters = filters;
        if (this.options.dataUrl) {
            this.fetchData();
        }
    };

    DataTable.prototype.getSelectedRows = function() {
        if (this.state.tableInstance) {
            return this.state.tableInstance.getSelectedData();
        }
        return [];
    };

    DataTable.prototype.getSelectedCells = function() {
        return this.state.selectedCells || [];
    };

    DataTable.prototype.deselectAllRows = function() {
        if (this.state.tableInstance) {
            this.state.tableInstance.deselectRow();
        }
    };

    DataTable.prototype.updateRowOperationsToolbar = function(count) {
        const toolbar = this.container.querySelector('[data-row-operations]');
        const countEl = this.container.querySelector('[data-row-operations-count]');

        if (!toolbar || !countEl) return;

        if (count > 0) {
            countEl.textContent = count + ' row' + (count !== 1 ? 's' : '') + ' selected';
            toolbar.style.display = 'flex';
        } else {
            toolbar.style.display = 'none';
            // Close the More menu when toolbar is hidden
            const moreMenu = this.container.querySelector('[data-operation-more-menu]');
            if (moreMenu) {
                moreMenu.style.display = 'none';
            }
        }
    };

    // Update the bulk selection checkbox in table header (indeterminate state)
    DataTable.prototype.updateBulkSelectionCheckbox = function() {
        if (!this.state.tableInstance) return;

        // Find our custom header checkbox within the table container
        var tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        if (!tableEl) {
            console.log('updateBulkSelectionCheckbox: tableEl not found');
            return;
        }

        var headerCheckbox = tableEl.querySelector('.dt-bulk-select-checkbox');
        if (!headerCheckbox) {
            console.log('updateBulkSelectionCheckbox: checkbox not found');
            return;
        }

        // Get total rows and selected rows count (use filtered data count for accuracy)
        var totalRows = this.state.tableInstance.getDataCount('active');
        var selectedRows = this.state.selectedRows ? this.state.selectedRows.length : 0;

        console.log('Bulk checkbox update: selected=' + selectedRows + ', total=' + totalRows);

        // Set checkbox state based on selection
        if (selectedRows === 0) {
            headerCheckbox.checked = false;
            headerCheckbox.indeterminate = false;
        } else if (selectedRows === totalRows) {
            headerCheckbox.checked = true;
            headerCheckbox.indeterminate = false;
        } else {
            headerCheckbox.checked = false;
            headerCheckbox.indeterminate = true;
        }
    };

    DataTable.prototype.handleRowOperation = function(operation) {
        const selectedRows = this.getSelectedRows();
        const selectedIds = selectedRows.map(function(row) {
            return row.id || row.employee_code || JSON.stringify(row);
        });

        // Alert with selected row IDs
        alert('Operation: ' + operation.toUpperCase() + '\n\nSelected Row IDs:\n' + selectedIds.join('\n') + '\n\nTotal: ' + selectedRows.length + ' rows');

        // You can add custom callback here
        if (this.options.onRowOperation) {
            this.options.onRowOperation(operation, selectedRows, selectedIds);
        }
    };

    DataTable.prototype.toggleRowExpand = function(cell) {
        const self = this;
        const row = cell.getRow();
        const rowId = row.getPosition();
        const rowData = row.getData();
        const rowElement = row.getElement();

        // Check if row is already expanded
        if (this.state.expandedRows[rowId]) {
            // Collapse the row
            this.collapseRow(row, rowId);
        } else {
            // Expand the row
            if (this.options.onRowExpand) {
                // Call the callback to get the content
                this.options.onRowExpand(rowData, function(htmlContent) {
                    self.expandRow(row, rowId, htmlContent);
                });
            } else {
                // Default content if no callback provided
                const defaultContent = '<div style="padding: 16px; background: #f8f9fa; border-top: 1px solid #e8eaed;">No expand callback defined. Use onRowExpand option.</div>';
                this.expandRow(row, rowId, defaultContent);
            }
        }
    };

    DataTable.prototype.expandRow = function(row, rowId, htmlContent) {
        const rowElement = row.getElement();

        // Store the content
        this.state.expandedRows[rowId] = htmlContent;

        // Create expand row element
        const expandRow = document.createElement('div');
        expandRow.className = 'dt-expand-row';
        expandRow.setAttribute('data-expand-row', rowId);
        expandRow.innerHTML = htmlContent;

        // Insert after the row
        rowElement.parentNode.insertBefore(expandRow, rowElement.nextSibling);

        // Update the button icon
        this.updateExpandButton(row, true);

        // Add expanded class to row
        rowElement.classList.add('dt-row-expanded');
    };

    DataTable.prototype.collapseRow = function(row, rowId) {
        const rowElement = row.getElement();

        // Remove the content from state
        delete this.state.expandedRows[rowId];

        // Find and remove the expand row element
        const expandRow = this.container.querySelector('[data-expand-row="' + rowId + '"]');
        if (expandRow) {
            expandRow.remove();
        }

        // Update the button icon
        this.updateExpandButton(row, false);

        // Remove expanded class from row
        rowElement.classList.remove('dt-row-expanded');
    };

    DataTable.prototype.updateExpandButton = function(row, isExpanded) {
        const cell = row.getCell('_expand');
        if (cell) {
            const icon = isExpanded ? 'remove' : 'add';
            const title = isExpanded ? 'Collapse' : 'Expand';
            const btn = cell.getElement().querySelector('.dt-expand-btn');
            if (btn) {
                btn.title = title;
                const iconEl = btn.querySelector('.material-symbols-rounded');
                if (iconEl) {
                    iconEl.textContent = icon;
                }
            }
        }
    };

    DataTable.prototype.showActionsMenu = function(cell, buttonEl) {
        const self = this;
        const rowData = cell.getRow().getData();
        const row = cell.getRow();

        // Remove any existing action menu and row highlight
        this.closeActionsMenu();

        // Create actions menu
        const menu = document.createElement('div');
        menu.className = 'dt-actions-menu';

        // Build menu items
        let menuHTML = '';
        this.options.actions.forEach(function(action) {
            const icon = action.icon || '';
            const label = action.label || '';
            const disabled = action.disabled && action.disabled(rowData) ? 'disabled' : '';

            menuHTML += `
                <div class="dt-actions-menu-item ${disabled}" data-action-id="${action.id || label}">
                    ${icon ? '<span class="material-symbols-rounded">' + icon + '</span>' : ''}
                    <span>${label}</span>
                </div>
            `;
        });

        menu.innerHTML = menuHTML;
        document.body.appendChild(menu);

        // Highlight the row
        const rowElement = row.getElement();
        rowElement.classList.add('dt-actions-menu-open');

        // Store reference to active menu and row
        this.state.activeActionsMenu = menu;
        this.state.activeActionsRow = row;
        this.state.activeActionsButton = buttonEl;

        // Position menu function
        const positionMenu = function() {
            const rect = buttonEl.getBoundingClientRect();
            const menuRect = menu.getBoundingClientRect();

            // Check if button is in viewport
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            const viewportWidth = window.innerWidth || document.documentElement.clientWidth;

            if (rect.bottom < 0 || rect.top > viewportHeight || rect.right < 0 || rect.left > viewportWidth) {
                // Button is out of view, close menu
                self.closeActionsMenu();
                return false;
            }

            // Position menu to the left of the button
            const menuHeight = menuRect.height;
            const menuWidth = menuRect.width;

            // Vertical position: align top of menu with top of button
            // Check if there's enough space below, otherwise open upward
            const spaceBelow = viewportHeight - rect.top;
            const spaceAbove = rect.bottom;

            let top;
            if (spaceBelow >= menuHeight || spaceBelow >= spaceAbove) {
                // Open downward - align top of menu with top of button
                top = rect.top + window.scrollY;

                // Make sure menu doesn't go below viewport
                if (top + menuHeight > window.scrollY + viewportHeight) {
                    top = window.scrollY + viewportHeight - menuHeight - 5;
                }
            } else {
                // Open upward - align bottom of menu with bottom of button
                top = rect.bottom + window.scrollY - menuHeight;

                // Make sure menu doesn't go above viewport
                if (top < window.scrollY) {
                    top = window.scrollY + 5;
                }
            }

            // Horizontal position: to the left of the button
            let left = rect.left + window.scrollX - menuWidth - 5;

            // On tablet/mobile screens (< 1200px), prefer opening to the right
            // because sidebar may overlay the content
            const isTabletOrMobile = viewportWidth < 1200;

            // If not enough space on left, position to the right of button
            // Also prefer right side on tablet/mobile screens
            if (left < window.scrollX || isTabletOrMobile) {
                left = rect.right + window.scrollX + 5;
            }

            menu.style.top = top + 'px';
            menu.style.left = left + 'px';

            return true;
        };

        // Initial position
        positionMenu();

        // Get table container for scroll events
        const tableEl = this.container.querySelector('#dt-table-' + this.containerId);
        const tableHolder = tableEl ? tableEl.querySelector('.tabulator-tableholder') : null;

        // Update position on scroll
        const scrollHandler = function() {
            if (!positionMenu()) {
                // Menu was closed, remove scroll listener
                if (tableHolder) {
                    tableHolder.removeEventListener('scroll', scrollHandler);
                }
                window.removeEventListener('scroll', scrollHandler);
            }
        };

        if (tableHolder) {
            tableHolder.addEventListener('scroll', scrollHandler);
        }
        window.addEventListener('scroll', scrollHandler);

        // Add click handlers
        const menuItems = menu.querySelectorAll('.dt-actions-menu-item:not(.disabled)');
        menuItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                const actionId = this.dataset.actionId;
                const action = self.options.actions.find(function(a) {
                    return (a.id || a.label) === actionId;
                });

                if (action) {
                    // Call action's onClick if exists
                    if (action.onClick) {
                        action.onClick(rowData);
                    }

                    // Call global onActionClick callback
                    if (self.options.onActionClick) {
                        self.options.onActionClick(action, rowData);
                    }
                }

                self.closeActionsMenu();
            });
        });

        // Close menu when clicking outside
        setTimeout(function() {
            const closeMenuHandler = function(e) {
                if (!menu.contains(e.target) && !buttonEl.contains(e.target)) {
                    self.closeActionsMenu();
                    document.removeEventListener('click', closeMenuHandler);
                }
            };
            document.addEventListener('click', closeMenuHandler);

            // Store handler so we can remove it later
            self.state.closeMenuHandler = closeMenuHandler;
        }, 0);
    };

    DataTable.prototype.closeActionsMenu = function() {
        // Remove menu
        const existingMenu = document.querySelector('.dt-actions-menu');
        if (existingMenu) {
            existingMenu.remove();
        }

        // Remove row highlight
        if (this.state.activeActionsRow) {
            const rowElement = this.state.activeActionsRow.getElement();
            if (rowElement) {
                rowElement.classList.remove('dt-actions-menu-open');
            }
        }

        // Clean up event listener
        if (this.state.closeMenuHandler) {
            document.removeEventListener('click', this.state.closeMenuHandler);
            this.state.closeMenuHandler = null;
        }

        // Clear state
        this.state.activeActionsMenu = null;
        this.state.activeActionsRow = null;
        this.state.activeActionsButton = null;
    };

    DataTable.prototype.toggleColumnPin = function(field, direction) {
        const currentPin = this.state.pinnedColumns[field];

        // Toggle pin: if already pinned in that direction, unpin; otherwise pin
        if (currentPin === direction) {
            delete this.state.pinnedColumns[field];
        } else {
            this.state.pinnedColumns[field] = direction;
        }

        // Mark config as changed
        this.markConfigChanged();

        // Rebuild the table with new pinning
        // Note: Column order is preserved - pinned columns are only visually reordered during rendering
        if (this.state.tableInstance) {
            const data = this.state.tableInstance.getData();

            // Save selected rows before rebuild
            const selectedRows = this.state.tableInstance.getSelectedData();

            this.initializeTable(data);

            // Restore row selection after rebuild
            if (this.options.enableRowSelection && selectedRows.length > 0) {
                // Wait for table to render, then restore selection
                const self = this;
                setTimeout(function() {
                    selectedRows.forEach(function(rowData) {
                        const row = self.state.tableInstance.searchRows('id', '=', rowData.id);
                        if (row && row[0]) {
                            row[0].select();
                        }
                    });
                }, 100);
            }
        }

        // Refresh the column selector UI
        this.populateColumnSelector();
    };

    DataTable.prototype.setColumnWrap = function(field, wrapValue) {
        // Store the wrap setting in state
        this.state.columnWrapSettings[field] = wrapValue;

        // Mark config as changed
        this.markConfigChanged();

        // Rebuild the table with new wrap setting
        if (this.state.tableInstance) {
            const data = this.state.tableInstance.getData();

            // Save selected rows before rebuild
            const selectedRows = this.state.tableInstance.getSelectedData();

            this.initializeTable(data);

            // Restore row selection after rebuild
            if (this.options.enableRowSelection && selectedRows.length > 0) {
                const self = this;
                setTimeout(function() {
                    selectedRows.forEach(function(rowData) {
                        const row = self.state.tableInstance.searchRows('id', '=', rowData.id);
                        if (row && row[0]) {
                            row[0].select();
                        }
                    });
                }, 100);
            }
        }

        // Refresh the column selector UI
        this.populateColumnSelector();
    };

    DataTable.prototype.reorderColumnsByPinning = function() {
        // This function now only ensures columnOrder is initialized
        // It no longer reorders columns - pinned columns are visually ordered during rendering
        if (!this.state.columnOrder) {
            this.state.columnOrder = this.options.columns.map(function(col) { return col.field; });
        }
    };

    // Get the visual render order for columns (left pinned first, then unpinned, then right pinned)
    // This does not modify the actual columnOrder state
    DataTable.prototype.getVisualColumnOrder = function() {
        const leftPinned = [];
        const middle = [];
        const rightPinned = [];

        // Use current columnOrder if available, otherwise use options.columns
        const currentOrder = this.state.columnOrder || this.options.columns.map(function(col) { return col.field; });

        // Separate columns into three groups based on pinning, preserving their relative order
        currentOrder.forEach(function(field) {
            const pinDirection = this.state.pinnedColumns[field];
            if (pinDirection === 'left') {
                leftPinned.push(field);
            } else if (pinDirection === 'right') {
                rightPinned.push(field);
            } else {
                middle.push(field);
            }
        }.bind(this));

        // Return visual order: left pinned, then middle, then right pinned
        return leftPinned.concat(middle, rightPinned);
    };

    // Build export options HTML
    DataTable.prototype.buildExportOptionsHTML = function() {
        var self = this;

        // Default built-in options
        var builtInOptions = [
            { key: 'serialNumber', label: 'Add S.N. column', type: 'checkbox', default: false, group: 'General', excelOnly: false },
            { key: 'totals', label: 'Include totals row', type: 'checkbox', default: false, group: 'Excel', excelOnly: true },
            { key: 'freezeHeader', label: 'Freeze header row', type: 'checkbox', default: true, group: 'Excel', excelOnly: true },
            { key: 'freezeColumns', label: 'Freeze left columns', type: 'number', default: 0, group: 'Excel', excelOnly: true, min: 0, max: 10 }
        ];

        // Merge with custom options from config
        var allOptions = builtInOptions.concat(this.options.exportOptions || []);

        // Group options
        var groups = {};
        allOptions.forEach(function(opt) {
            var groupName = opt.group || 'General';
            if (!groups[groupName]) {
                groups[groupName] = [];
            }
            groups[groupName].push(opt);
        });

        // Build HTML
        var html = '';
        Object.keys(groups).forEach(function(groupName) {
            var groupOptions = groups[groupName];
            var hasExcelOnly = groupOptions.some(function(opt) { return opt.excelOnly; });

            // Add group header if more than one group
            if (Object.keys(groups).length > 1) {
                html += '<div class="dt-export-options-group' + (hasExcelOnly ? ' dt-export-excel-only' : '') + '"' + (hasExcelOnly ? ' data-export-excel-option' : '') + '>';
                html += '<div class="dt-export-options-group-header">' + groupName + '</div>';
            }

            groupOptions.forEach(function(opt) {
                var excelOnlyClass = opt.excelOnly ? ' dt-export-excel-only' : '';
                var excelOnlyAttr = opt.excelOnly ? ' data-export-excel-option' : '';

                html += '<label class="dt-export-additional-item' + excelOnlyClass + '"' + excelOnlyAttr + '>';

                if (opt.type === 'checkbox') {
                    var checked = opt.default ? ' checked' : '';
                    html += '<input type="checkbox" data-export-option="' + opt.key + '"' + checked + '>';
                    html += '<span>' + opt.label + '</span>';
                } else if (opt.type === 'number') {
                    html += '<span>' + opt.label + ':</span>';
                    var min = opt.min !== undefined ? ' min="' + opt.min + '"' : '';
                    var max = opt.max !== undefined ? ' max="' + opt.max + '"' : '';
                    html += '<input type="number" data-export-option="' + opt.key + '" class="dt-export-freeze-input" value="' + (opt.default || 0) + '"' + min + max + '>';
                } else if (opt.type === 'text') {
                    html += '<span>' + opt.label + ':</span>';
                    html += '<input type="text" data-export-option="' + opt.key + '" class="dt-export-text-input" value="' + (opt.default || '') + '">';
                }

                html += '</label>';
            });

            if (Object.keys(groups).length > 1) {
                html += '</div>';
            }
        });

        return html;
    };

    // Show export popup with column details
    DataTable.prototype.showExportPopup = function() {
        var self = this;
        var modal = this.container.querySelector('[data-export-modal]');
        var columnsList = this.container.querySelector('[data-export-columns-list]');

        if (!modal || !columnsList) return;

        // Populate export options menu
        var optionsMenu = modal.querySelector('[data-export-additional-menu]');
        if (optionsMenu) {
            optionsMenu.innerHTML = this.buildExportOptionsHTML();
        }

        // Get visible columns
        var visibleColumns = this.options.columns.filter(function(col) {
            return self.state.selectedColumns.includes(col.field);
        });

        // Build columns list HTML
        var html = '';
        visibleColumns.forEach(function(col) {
            var columnType = self.getColumnType(col);
            var formatOptions = self.getColumnFormatOptions(col, columnType);
            var alignDisplay = self.getColumnAlignDisplay(col);

            html += '<div class="dt-export-column-row">';
            html += '<div class="dt-export-col-check">';
            html += '<input type="checkbox" checked data-export-column="' + col.field + '" onchange="this.closest(\'.dt-export-modal\').dispatchEvent(new CustomEvent(\'column-change\'))">';
            html += '</div>';
            html += '<div class="dt-export-col-name">' + col.title + '</div>';
            html += '<div class="dt-export-col-type"><span class="dt-export-type-badge dt-export-type-' + columnType + '">' + columnType + '</span></div>';
            html += '<div class="dt-export-col-format">' + formatOptions + '</div>';
            html += '<div class="dt-export-col-align">';
            html += '<div class="dt-export-align-btns" data-export-align-group="' + col.field + '">';
            html += '<button type="button" class="dt-export-align-btn' + (alignDisplay.value === 'left' ? ' active' : '') + '" data-export-align="' + col.field + '" data-align-value="left" title="Align Left">';
            html += '<span class="material-symbols-rounded">format_align_left</span>';
            html += '</button>';
            html += '<button type="button" class="dt-export-align-btn' + (alignDisplay.value === 'center' ? ' active' : '') + '" data-export-align="' + col.field + '" data-align-value="center" title="Align Center">';
            html += '<span class="material-symbols-rounded">format_align_center</span>';
            html += '</button>';
            html += '<button type="button" class="dt-export-align-btn' + (alignDisplay.value === 'right' ? ' active' : '') + '" data-export-align="' + col.field + '" data-align-value="right" title="Align Right">';
            html += '<span class="material-symbols-rounded">format_align_right</span>';
            html += '</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        });

        columnsList.innerHTML = html;

        // Update column count
        this.updateExportColumnCount();

        // Add listener for column count updates
        modal.addEventListener('column-change', function() {
            self.updateExportColumnCount();
        });

        // Add click handlers for alignment buttons
        var alignBtns = columnsList.querySelectorAll('.dt-export-align-btn');
        alignBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var field = this.dataset.exportAlign;
                var group = columnsList.querySelector('[data-export-align-group="' + field + '"]');
                if (group) {
                    group.querySelectorAll('.dt-export-align-btn').forEach(function(b) {
                        b.classList.remove('active');
                    });
                }
                this.classList.add('active');
            });
        });

        // Add change handlers for export format radio buttons
        var formatRadios = modal.querySelectorAll('.dt-export-format-option input[type="radio"]');
        formatRadios.forEach(function(radio) {
            if (!radio.hasAttribute('data-format-listener')) {
                radio.setAttribute('data-format-listener', 'true');
                radio.addEventListener('change', function() {
                    self.toggleExportFormatColumns(this.value);
                });
            }
        });

        // Initialize format/align columns based on current selection
        var selectedFormat = modal.querySelector('.dt-export-format-option input[type="radio"]:checked');
        if (selectedFormat) {
            this.toggleExportFormatColumns(selectedFormat.value);
        }

        // Set default filename with datetime
        var filenameInput = modal.querySelector('[data-export-filename]');
        if (filenameInput) {
            filenameInput.value = this.getExportFilename();
        }

        // Add toggle handler for additional options dropdown (only once)
        var additionalDropdown = modal.querySelector('[data-export-additional-dropdown]');
        var additionalToggle = modal.querySelector('[data-export-additional-toggle]');
        if (additionalToggle && additionalDropdown && !additionalToggle.hasAttribute('data-listener-attached')) {
            additionalToggle.setAttribute('data-listener-attached', 'true');
            additionalToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                additionalDropdown.classList.toggle('open');
            });

            // Close dropdown when clicking outside
            modal.addEventListener('click', function(e) {
                if (!additionalDropdown.contains(e.target)) {
                    additionalDropdown.classList.remove('open');
                }
            });
        }

        // Reset dropdown state when opening modal
        if (additionalDropdown) {
            additionalDropdown.classList.remove('open');
        }

        // Add change listeners for options inputs to update button color
        var optionInputs = modal.querySelectorAll('[data-export-option]');
        optionInputs.forEach(function(input) {
            if (!input.hasAttribute('data-option-listener')) {
                input.setAttribute('data-option-listener', 'true');
                // Use 'change' for checkboxes/selects and 'input' for number/text inputs
                var eventType = (input.type === 'number' || input.type === 'text') ? 'input' : 'change';
                input.addEventListener(eventType, function() {
                    self.updateExportOptionsButtonColor();
                });
            }
        });

        // Initial update of options button color
        this.updateExportOptionsButtonColor();

        // Show modal
        modal.style.display = 'flex';
    };

    // Update options button color based on selected options
    DataTable.prototype.updateExportOptionsButtonColor = function() {
        var modal = this.container.querySelector('[data-export-modal]');
        if (!modal) return;

        var optionsBtn = modal.querySelector('[data-export-additional-toggle]');
        if (!optionsBtn) return;

        // Get format to determine which options are applicable
        var formatRadio = modal.querySelector('.dt-export-format-option input[type="radio"]:checked');
        var isExcel = formatRadio && formatRadio.value === 'xlsx';

        // Get all option items from the dropdown menu
        var menuItems = modal.querySelectorAll('.dt-export-additional-item');
        var totalApplicable = 0;
        var selectedCount = 0;

        menuItems.forEach(function(item) {
            var isExcelOnly = item.classList.contains('dt-export-excel-only');

            // Only count if applicable to current format
            if (!isExcelOnly || isExcel) {
                totalApplicable++;

                // Find the input/select within this item
                var checkbox = item.querySelector('input[type="checkbox"]');
                var numberInput = item.querySelector('input[type="number"]');
                var textInput = item.querySelector('input[type="text"]');
                var selectInput = item.querySelector('select');

                if (checkbox && checkbox.checked) {
                    selectedCount++;
                } else if (numberInput && parseInt(numberInput.value) > 0) {
                    selectedCount++;
                } else if (textInput && textInput.value.trim() !== '') {
                    selectedCount++;
                } else if (selectInput && selectInput.value && selectInput.value !== '0') {
                    selectedCount++;
                }
            }
        });

        // Update count badge
        var countBadge = modal.querySelector('[data-export-options-count]');
        if (countBadge) {
            countBadge.textContent = selectedCount + '/' + totalApplicable;
        }

        // Remove existing color classes
        optionsBtn.classList.remove('options-none', 'options-some', 'options-all');

        // Add appropriate class based on selection
        if (selectedCount === 0) {
            optionsBtn.classList.add('options-none');
        } else if (selectedCount === totalApplicable) {
            optionsBtn.classList.add('options-all');
        } else {
            optionsBtn.classList.add('options-some');
        }
    };

    // Generate export filename with datetime
    DataTable.prototype.getExportFilename = function() {
        var baseName = this.options.exportFilename || 'export';
        var now = new Date();

        // Format: 25Nov2025_0630AM
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var day = now.getDate();
        var month = months[now.getMonth()];
        var year = now.getFullYear();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be 12
        var hoursStr = hours < 10 ? '0' + hours : hours;
        var minutesStr = minutes < 10 ? '0' + minutes : minutes;

        var datetime = day + month + year + '_' + hoursStr + minutesStr + ampm;

        return baseName + '_' + datetime;
    };

    // Toggle format and alignment columns based on export format
    DataTable.prototype.toggleExportFormatColumns = function(format) {
        var modal = this.container.querySelector('[data-export-modal]');
        if (!modal) return;

        var formatHeader = modal.querySelector('.dt-export-columns-header .dt-export-col-format');
        var alignHeader = modal.querySelector('.dt-export-columns-header .dt-export-col-align');
        var formatCells = modal.querySelectorAll('.dt-export-column-row .dt-export-col-format');
        var alignCells = modal.querySelectorAll('.dt-export-column-row .dt-export-col-align');
        var filenameExt = modal.querySelector('[data-export-filename-ext]');
        var excelOnlyOptions = modal.querySelectorAll('[data-export-excel-option]');

        var isCSV = format === 'csv';

        // Update file extension display
        if (filenameExt) {
            filenameExt.textContent = isCSV ? '.csv' : '.xlsx';
        }

        // Toggle Excel-only options
        excelOnlyOptions.forEach(function(option) {
            option.style.opacity = isCSV ? '0.4' : '1';
            option.style.pointerEvents = isCSV ? 'none' : 'auto';
        });

        // Toggle header visibility
        if (formatHeader) {
            formatHeader.style.opacity = isCSV ? '0.4' : '1';
            formatHeader.style.pointerEvents = isCSV ? 'none' : 'auto';
        }
        if (alignHeader) {
            alignHeader.style.opacity = isCSV ? '0.4' : '1';
            alignHeader.style.pointerEvents = isCSV ? 'none' : 'auto';
        }

        // Toggle cell visibility
        formatCells.forEach(function(cell) {
            cell.style.opacity = isCSV ? '0.4' : '1';
            cell.style.pointerEvents = isCSV ? 'none' : 'auto';
        });
        alignCells.forEach(function(cell) {
            cell.style.opacity = isCSV ? '0.4' : '1';
            cell.style.pointerEvents = isCSV ? 'none' : 'auto';
        });

        // Update options button color when format changes
        this.updateExportOptionsButtonColor();
    };

    // Update export column count display and select-all checkbox state
    DataTable.prototype.updateExportColumnCount = function() {
        var countEl = this.container.querySelector('[data-export-columns-count]');
        var selectAllCheckbox = this.container.querySelector('[data-export-select-all]');

        var totalCheckboxes = this.container.querySelectorAll('[data-export-column]');
        var checkedCheckboxes = this.container.querySelectorAll('[data-export-column]:checked');
        var totalCount = totalCheckboxes.length;
        var checkedCount = checkedCheckboxes.length;

        // Update count display
        if (countEl) {
            countEl.textContent = checkedCount + ' of ' + totalCount + ' selected';
        }

        // Update select-all checkbox state (checked, indeterminate, or unchecked)
        if (selectAllCheckbox) {
            if (checkedCount === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedCount === totalCount) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            }
        }
    };

    // Select/deselect all export columns
    DataTable.prototype.exportSelectAll = function(selectAll) {
        var checkboxes = this.container.querySelectorAll('[data-export-column]');
        checkboxes.forEach(function(cb) {
            cb.checked = selectAll;
        });
        this.updateExportColumnCount();
    };

    // Get column type based on formatter or data
    DataTable.prototype.getColumnType = function(col) {
        if (col.formatter === 'money') {
            return 'currency';
        }
        if (col.formatter === 'number' || col.formatterParams && col.formatterParams.precision !== undefined) {
            return 'number';
        }

        // Check sample data to determine type
        if (this.state.tableInstance) {
            var data = this.state.tableInstance.getData();
            if (data.length > 0) {
                var sampleValue = data[0][col.field];
                if (typeof sampleValue === 'number') {
                    return 'number';
                }
                if (sampleValue instanceof Date || (typeof sampleValue === 'string' && /^\d{4}-\d{2}-\d{2}/.test(sampleValue))) {
                    return 'date';
                }
            }
        }
        return 'text';
    };

    // Get format options HTML for column based on type
    DataTable.prototype.getColumnFormatOptions = function(col, columnType) {
        var field = col.field;

        if (columnType === 'date') {
            return '<select class="dt-export-format-select" data-export-format="' + field + '">' +
                '<option value="YYYY-MM-DD">2024-01-15</option>' +
                '<option value="DD/MM/YYYY">15/01/2024</option>' +
                '<option value="MM/DD/YYYY">01/15/2024</option>' +
                '<option value="DD-MMM-YYYY">15-Jan-2024</option>' +
                '</select>';
        }

        if (columnType === 'number') {
            return '<div class="dt-export-format-group">' +
                '<select class="dt-export-format-select dt-export-format-comma" data-export-comma="' + field + '">' +
                '<option value="yes">1,234</option>' +
                '<option value="no">1234</option>' +
                '</select>' +
                '<select class="dt-export-format-select dt-export-format-decimal" data-export-decimal="' + field + '">' +
                '<option value="0">No decimal</option>' +
                '<option value="1">.0</option>' +
                '<option value="2">.00</option>' +
                '<option value="3">.000</option>' +
                '<option value="4">.0000</option>' +
                '</select>' +
                '</div>';
        }

        if (columnType === 'currency') {
            var params = col.formatterParams || {};
            var symbol = params.symbol || '$';
            return '<div class="dt-export-format-group">' +
                '<select class="dt-export-format-select dt-export-format-symbol" data-export-symbol="' + field + '" data-symbol="' + symbol + '">' +
                '<option value="yes">' + symbol + '1,234</option>' +
                '<option value="no">1,234</option>' +
                '</select>' +
                '<select class="dt-export-format-select dt-export-format-decimal" data-export-decimal="' + field + '">' +
                '<option value="0">No decimal</option>' +
                '<option value="1">.0</option>' +
                '<option value="2" selected>.00</option>' +
                '<option value="3">.000</option>' +
                '<option value="4">.0000</option>' +
                '</select>' +
                '</div>';
        }

        return '<span class="dt-export-format-text">—</span>';
    };

    // Get alignment display for column
    DataTable.prototype.getColumnAlignDisplay = function(col) {
        var align = col.hozAlign || 'left';

        // Auto-detect alignment for numbers/currency
        if (!col.hozAlign) {
            if (col.formatter === 'money' || col.formatter === 'number') {
                align = 'right';
            } else {
                var columnType = this.getColumnType(col);
                if (columnType === 'number' || columnType === 'currency') {
                    align = 'right';
                }
            }
        }

        return {
            value: align,
            label: align.charAt(0).toUpperCase() + align.slice(1)
        };
    };

    // Hide export popup
    DataTable.prototype.hideExportPopup = function() {
        var modal = this.container.querySelector('[data-export-modal]');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // Execute the export based on popup selections
    DataTable.prototype.executeExport = function() {
        var self = this;
        var modal = this.container.querySelector('[data-export-modal]');

        // Get selected format
        var formatRadio = this.container.querySelector('.dt-export-format-option input[type="radio"]:checked');
        var format = formatRadio ? formatRadio.value : 'xlsx';

        // Get filename
        var filenameInput = this.container.querySelector('[data-export-filename]');
        var filename = filenameInput ? filenameInput.value.trim() : this.getExportFilename();
        if (!filename) {
            filename = this.getExportFilename();
        }

        // Get selected columns with their settings
        var selectedColumns = [];
        var columnSettings = {};
        var checkboxes = this.container.querySelectorAll('[data-export-column]:checked');
        checkboxes.forEach(function(cb) {
            var field = cb.dataset.exportColumn;
            selectedColumns.push(field);

            // Get format and alignment settings for this column
            var formatSelect = modal.querySelector('[data-export-format="' + field + '"]');
            var commaSelect = modal.querySelector('[data-export-comma="' + field + '"]');
            var decimalSelect = modal.querySelector('[data-export-decimal="' + field + '"]');
            var symbolSelect = modal.querySelector('[data-export-symbol="' + field + '"]');
            var alignGroup = modal.querySelector('[data-export-align-group="' + field + '"]');
            var activeAlign = alignGroup ? alignGroup.querySelector('.dt-export-align-btn.active') : null;

            columnSettings[field] = {
                format: formatSelect ? formatSelect.value : null,
                comma: commaSelect ? commaSelect.value : null,
                decimal: decimalSelect ? decimalSelect.value : null,
                symbol: symbolSelect ? symbolSelect.value : null,
                align: activeAlign ? activeAlign.dataset.alignValue : 'left'
            };
        });

        if (selectedColumns.length === 0) {
            alert('Please select at least one column to export.');
            return;
        }

        // Get all export options
        var exportOptions = {};
        var optionInputs = modal.querySelectorAll('[data-export-option]');
        optionInputs.forEach(function(input) {
            var key = input.dataset.exportOption;
            if (input.type === 'checkbox') {
                exportOptions[key] = input.checked;
            } else if (input.type === 'number') {
                exportOptions[key] = parseInt(input.value) || 0;
            } else {
                exportOptions[key] = input.value;
            }
        });

        // Build export info object
        var exportInfo = {
            filename: filename,
            format: format,
            columns: selectedColumns,
            columnSettings: columnSettings,
            options: exportOptions
        };

        // Console log all export information
        console.log('Export Info:', exportInfo);

        // Hide popup
        this.hideExportPopup();

        // Execute export
        if (format === 'xlsx') {
            this.downloadExcelWithColumns(selectedColumns, filename);
        } else {
            this.downloadCsvWithColumns(selectedColumns, filename);
        }
    };

    // Download Excel with selected columns
    DataTable.prototype.downloadExcelWithColumns = function(selectedColumns, filename) {
        if (typeof XLSX === 'undefined') {
            alert('Excel export requires SheetJS library. Please include it in your page.');
            return;
        }

        var self = this;
        var data = this.state.tableInstance.getData();

        // Create workbook
        var wb = XLSX.utils.book_new();

        // Prepare headers and data with proper formatting
        var headers = [];
        var columnFormats = {};
        var columnWidths = [];

        // Get columns in order
        var exportColumns = this.options.columns.filter(function(col) {
            return selectedColumns.includes(col.field);
        });

        exportColumns.forEach(function(col) {
            headers.push(col.title);
            columnFormats[col.field] = col;

            // Set column width
            var width = col.width ? col.width / 8 : Math.max(col.title.length + 2, 15);
            columnWidths.push({ wch: width });
        });

        // Prepare rows
        var rows = data.map(function(row) {
            return exportColumns.map(function(col) {
                return row[col.field];
            });
        });

        // Create worksheet
        var ws = XLSX.utils.aoa_to_sheet([headers].concat(rows));

        // Set column widths
        ws['!cols'] = columnWidths;

        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Data');

        // Generate and download
        XLSX.writeFile(wb, filename + '.xlsx');
    };

    // Download CSV with selected columns
    DataTable.prototype.downloadCsvWithColumns = function(selectedColumns, filename) {
        var self = this;
        var data = this.state.tableInstance.getData();

        // Get columns in order
        var exportColumns = this.options.columns.filter(function(col) {
            return selectedColumns.includes(col.field);
        });

        // Build CSV content
        var csvContent = '';

        // Headers
        csvContent += exportColumns.map(function(col) {
            return '"' + col.title.replace(/"/g, '""') + '"';
        }).join(',') + '\n';

        // Data rows
        data.forEach(function(row) {
            csvContent += exportColumns.map(function(col) {
                var value = row[col.field];
                if (value === null || value === undefined) {
                    return '';
                }
                if (typeof value === 'string') {
                    return '"' + value.replace(/"/g, '""') + '"';
                }
                return value;
            }).join(',') + '\n';
        });

        // Create and download file
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement('a');
        var url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename + '.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    DataTable.prototype.downloadExcel = function() {
        if (typeof XLSX === 'undefined') {
            alert('Excel export requires SheetJS library. Please include it in your page.');
            return;
        }

        const self = this;
        const data = this.state.tableInstance.getData();

        // Create workbook
        const wb = XLSX.utils.book_new();

        // Prepare headers and data with proper formatting
        const headers = [];
        const columnFormats = {};
        const columnWidths = [];

        // Get visible columns only
        const visibleColumns = this.options.columns.filter(function(col) {
            return self.state.selectedColumns.includes(col.field);
        });

        visibleColumns.forEach(function(col) {
            headers.push(col.title);
            columnFormats[col.field] = col;

            // Set column width based on title length or width property
            const width = col.width ? col.width / 8 : Math.max(col.title.length + 2, 15);
            columnWidths.push({ wch: width });
        });

        // Prepare rows with raw values
        const rows = data.map(function(row) {
            return visibleColumns.map(function(col) {
                return row[col.field];
            });
        });

        // Create worksheet
        const ws = XLSX.utils.aoa_to_sheet([headers].concat(rows));

        // Set column widths
        ws['!cols'] = columnWidths;

        // Apply formatting to cells
        const range = XLSX.utils.decode_range(ws['!ref']);

        // Format header row (bold)
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const address = XLSX.utils.encode_col(C) + "1";
            if (!ws[address]) continue;
            ws[address].s = {
                font: { bold: true },
                fill: { fgColor: { rgb: "F8F9FA" } },
                border: {
                    top: { style: "thin", color: { rgb: "E8EAED" } },
                    bottom: { style: "thin", color: { rgb: "E8EAED" } },
                    left: { style: "thin", color: { rgb: "E8EAED" } },
                    right: { style: "thin", color: { rgb: "E8EAED" } }
                }
            };
        }

        // Format data cells with proper number formatting
        for (let R = range.s.r + 1; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                const address = XLSX.utils.encode_cell({ r: R, c: C });
                if (!ws[address]) continue;

                const col = visibleColumns[C];
                const value = ws[address].v;

                // Apply formatting based on column type
                if (col.formatter === 'money' && typeof value === 'number') {
                    const params = col.formatterParams || {};
                    const symbol = params.symbol || '$';
                    const precision = params.precision !== undefined ? params.precision : 2;

                    // Set Excel number format for currency
                    ws[address].z = symbol + '#,##0' + (precision > 0 ? '.' + '0'.repeat(precision) : '');
                    ws[address].t = 'n'; // Ensure it's treated as number
                } else if (typeof value === 'number') {
                    // Generic number formatting
                    ws[address].z = '#,##0';
                    ws[address].t = 'n';
                }

                // Add cell borders
                ws[address].s = ws[address].s || {};
                ws[address].s.border = {
                    top: { style: "thin", color: { rgb: "F1F3F4" } },
                    bottom: { style: "thin", color: { rgb: "F1F3F4" } },
                    left: { style: "thin", color: { rgb: "F1F3F4" } },
                    right: { style: "thin", color: { rgb: "F1F3F4" } }
                };
            }
        }

        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, "Data");

        // Generate filename with timestamp
        const timestamp = new Date().toISOString().slice(0, 10);
        const filename = 'data_export_' + timestamp + '.xlsx';

        // Download file
        XLSX.writeFile(wb, filename);
    };

    // Toggle fullscreen mode for the table
    DataTable.prototype.toggleFullscreen = function() {
        const container = this.container.querySelector('.dt-statement');
        const fullscreenIcon = container.querySelector('[data-fullscreen-icon]');
        const fullscreenBtn = container.querySelector('[data-action="fullscreen"]');

        if (!container) return;

        const isFullscreen = container.classList.contains('dt-fullscreen');

        if (isFullscreen) {
            // Exit fullscreen
            container.classList.remove('dt-fullscreen');
            document.body.style.overflow = '';
            if (fullscreenIcon) {
                fullscreenIcon.textContent = 'fullscreen';
            }
            if (fullscreenBtn) {
                fullscreenBtn.title = 'Toggle Fullscreen';
                fullscreenBtn.classList.remove('active');
            }
        } else {
            // Enter fullscreen
            container.classList.add('dt-fullscreen');
            document.body.style.overflow = 'hidden';
            if (fullscreenIcon) {
                fullscreenIcon.textContent = 'fullscreen_exit';
            }
            if (fullscreenBtn) {
                fullscreenBtn.title = 'Exit Fullscreen';
                fullscreenBtn.classList.add('active');
            }
        }

        // Redraw table to adjust to new size
        if (this.state.tableInstance) {
            setTimeout(function() {
                this.state.tableInstance.redraw(true);
            }.bind(this), 100);
        }
    };

    // Set cell vertical alignment
    DataTable.prototype.setCellVerticalAlign = function(alignment) {
        const container = this.container.querySelector('.dt-statement');
        if (!container) return;

        // Remove existing alignment classes
        container.classList.remove('valign-top', 'valign-middle', 'valign-bottom');

        // Add new alignment class
        container.classList.add('valign-' + alignment);

        // Update option
        this.options.cellVerticalAlign = alignment;

        // Mark config as changed
        this.markConfigChanged();

        // Clear inline align-items and display styles from cells so CSS can take effect
        var cells = container.querySelectorAll('.tabulator-row:not(.tabulator-calcs) > .tabulator-cell');
        cells.forEach(function(cell) {
            cell.style.alignItems = '';
            cell.style.display = '';
        });
    };

    // Scroll to bring a column into view
    DataTable.prototype.scrollToColumn = function(field) {
        if (!this.state.tableInstance) return;

        var column = this.state.tableInstance.getColumn(field);
        if (!column) return;

        var columnEl = column.getElement();
        if (!columnEl) return;

        // Get the table holder element (scrollable container)
        var tableHolder = this.container.querySelector('.tabulator-tableholder');
        if (!tableHolder) return;

        // Get column position relative to table
        var columnRect = columnEl.getBoundingClientRect();
        var holderRect = tableHolder.getBoundingClientRect();

        // Check if column is frozen (pinned) - no need to scroll for frozen columns
        if (columnEl.classList.contains('tabulator-frozen')) return;

        // Calculate if column is out of view
        var isLeftOfView = columnRect.left < holderRect.left;
        var isRightOfView = columnRect.right > holderRect.right;

        if (isLeftOfView || isRightOfView) {
            // Scroll to bring column into view
            var scrollLeft = tableHolder.scrollLeft;
            var columnLeft = columnEl.offsetLeft;

            // Center the column in view if possible
            var targetScroll = columnLeft - (holderRect.width / 2) + (columnRect.width / 2);
            targetScroll = Math.max(0, targetScroll);

            tableHolder.scrollTo({
                left: targetScroll,
                behavior: 'smooth'
            });
        }
    };

    // Highlight column on hover in column list
    DataTable.prototype.highlightColumn = function(field, highlight) {
        if (!this.state.tableInstance) return;

        var column = this.state.tableInstance.getColumn(field);
        if (!column) return;

        // Get the header element
        var headerEl = column.getElement();
        if (headerEl) {
            if (highlight) {
                headerEl.classList.add('dt-column-highlight');
            } else {
                headerEl.classList.remove('dt-column-highlight');
            }
        }

        // Get all cells in this column
        var cells = column.getCells();
        cells.forEach(function(cell) {
            var cellEl = cell.getElement();
            if (cellEl) {
                if (highlight) {
                    cellEl.classList.add('dt-column-highlight');
                } else {
                    cellEl.classList.remove('dt-column-highlight');
                }
            }
        });
    };

    // Get table configuration - collects all user customizations
    DataTable.prototype.getTableConfig = function() {
        var self = this;
        var config = {
            // Vertical alignment setting
            cellVerticalAlign: this.options.cellVerticalAlign || 'top',

            // Column configurations
            columns: []
        };

        // Get column order from state
        var columnOrder = this.state.columnOrder || this.options.columns.map(function(col) { return col.field; });

        // Build column config for each column in order
        columnOrder.forEach(function(field, index) {
            var colConfig = {
                field: field,
                sequence: index,
                width: null,
                wrap: 'clip',
                pin: null
            };

            // Get width from state or from Tabulator column
            if (self.state.columnWidths && self.state.columnWidths[field]) {
                colConfig.width = self.state.columnWidths[field];
            } else if (self.state.tableInstance) {
                var column = self.state.tableInstance.getColumn(field);
                if (column) {
                    colConfig.width = column.getWidth();
                }
            }

            // Get wrap setting from state or column config
            var originalCol = self.options.columns.find(function(c) { return c.field === field; });
            if (self.state.columnWrapSettings[field]) {
                colConfig.wrap = self.state.columnWrapSettings[field];
            } else if (originalCol && originalCol.wrap) {
                colConfig.wrap = 'wrap';
            }

            // Get pin setting from state
            if (self.state.pinnedColumns[field]) {
                colConfig.pin = self.state.pinnedColumns[field]; // 'left' or 'right'
            }

            config.columns.push(colConfig);
        });

        return config;
    };

    // Mark configuration as changed - enables save button with red styling
    DataTable.prototype.markConfigChanged = function() {
        this.state.configChanged = true;
        var saveBtn = this.container.querySelector('[data-action="save-config"]');
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.classList.add('has-changes');
        }
    };

    // Reset config changed state - disables save button
    DataTable.prototype.resetConfigChanged = function() {
        this.state.configChanged = false;
        var saveBtn = this.container.querySelector('[data-action="save-config"]');
        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.classList.remove('has-changes');
        }
    };

    // Save table configuration - calls onSaveConfig callback or logs to console
    DataTable.prototype.saveTableConfig = function() {
        var config = this.getTableConfig();

        console.log('=== Table Configuration ===');
        console.log(JSON.stringify(config, null, 2));
        console.log('=== End Configuration ===');

        // If a callback is provided, call it with the config
        if (this.options.onSaveConfig && typeof this.options.onSaveConfig === 'function') {
            this.options.onSaveConfig(config);
        }

        // Show a brief notification to user
        this.showSaveNotification();

        // Reset the changed state
        this.resetConfigChanged();

        return config;
    };

    // Show a brief save notification
    DataTable.prototype.showSaveNotification = function() {
        var container = this.container.querySelector('.dt-statement');
        if (!container) return;

        // Create notification element
        var notification = document.createElement('div');
        notification.className = 'dt-save-notification';
        notification.innerHTML = '<span class="material-symbols-rounded">check_circle</span> Configuration saved';

        container.appendChild(notification);

        // Trigger animation
        setTimeout(function() {
            notification.classList.add('show');
        }, 10);

        // Remove after 2 seconds
        setTimeout(function() {
            notification.classList.remove('show');
            setTimeout(function() {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 2000);
    };

    // Load table configuration - applies saved config to the table
    DataTable.prototype.loadTableConfig = function(config) {
        if (!config) return;

        var self = this;

        // Apply vertical alignment
        if (config.cellVerticalAlign) {
            this.setCellVerticalAlign(config.cellVerticalAlign);

            // Update the alignment buttons
            var container = this.container.querySelector('.dt-statement');
            if (container) {
                var valignBtns = container.querySelectorAll('[data-valign]');
                valignBtns.forEach(function(btn) {
                    btn.classList.remove('active');
                    if (btn.dataset.valign === config.cellVerticalAlign) {
                        btn.classList.add('active');
                    }
                });
            }
        }

        // Apply column configurations
        if (config.columns && config.columns.length > 0) {
            // Build column order from config
            var newColumnOrder = config.columns
                .sort(function(a, b) { return a.sequence - b.sequence; })
                .map(function(col) { return col.field; });

            this.state.columnOrder = newColumnOrder;

            // Apply column settings
            config.columns.forEach(function(colConfig) {
                // Apply width
                if (colConfig.width) {
                    if (!self.state.columnWidths) {
                        self.state.columnWidths = {};
                    }
                    self.state.columnWidths[colConfig.field] = colConfig.width;
                }

                // Apply wrap setting
                if (colConfig.wrap) {
                    self.state.columnWrapSettings[colConfig.field] = colConfig.wrap;
                }

                // Apply pin setting
                if (colConfig.pin) {
                    self.state.pinnedColumns[colConfig.field] = colConfig.pin;
                } else {
                    delete self.state.pinnedColumns[colConfig.field];
                }
            });

            // Rebuild table with new config
            if (this.state.tableInstance) {
                var data = this.state.tableInstance.getData();
                this.initializeTable(data);
            }

            // Refresh column selector
            this.populateColumnSelector();
        }
    };

    // Export to global scope
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = DataTable;
    } else {
        global.DataTable = DataTable;
    }

})(this);
