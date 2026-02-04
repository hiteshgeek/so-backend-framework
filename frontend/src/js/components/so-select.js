// ============================================
// SIXORBIT UI - SELECT COMPONENT
// Modern, feature-rich select replacement
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOSelect - Custom select component
 * Supports single/multi-select, search, groups, and more
 */
class SOSelect extends SOComponent {
  static NAME = 'select';

  static DEFAULTS = {
    placeholder: 'Select an option',
    searchable: false,
    searchPlaceholder: 'Search...',
    multiple: false,
    clearable: false,
    closeOnSelect: true,
    disabled: false,
    options: [],
    noResultsText: 'No results found',
    loadingText: 'Loading...',

    // Selection limits
    minSelections: null,
    maxSelections: null,

    // Select All/None actions
    showActions: false,
    selectAllText: 'All',
    selectNoneText: 'None',

    // Display mode
    displayMode: 'text', // 'text', 'chips', 'chips-overflow'
    maxVisibleChips: 3,
    allSelectedText: null,
    multipleSelectedText: '{count} selected',
    overflowText: '+{count} more',

    // Selection style
    // For multiple: 'checkbox', 'checkbox-bg', 'icon', 'bg', 'icon-bg'
    // For single: 'radio', 'radio-bg', 'icon', 'bg', 'icon-bg'
    selectionStyle: 'icon-bg',
    selectionIcon: 'check',

    // Visual options
    size: null, // 'sm', 'lg', or null for default
    variant: null, // 'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'
    nowrap: false, // Prevent text wrapping in dropdown options

    // Async options
    async: false,
    asyncUrl: null,
    asyncMethod: 'GET',
    minSearchLength: 0,
    debounceTime: 300,
  };

  static EVENTS = {
    OPEN: 'select:open',
    OPENED: 'select:opened',
    CLOSE: 'select:close',
    CLOSED: 'select:closed',
    CHANGE: 'select:change',
    SEARCH: 'select:search',
    CLEAR: 'select:clear',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  _init() {
    // Check if enhancing a native select
    this._isNativeSelect = this.element.tagName === 'SELECT';

    if (this._isNativeSelect) {
      this._enhanceNativeSelect();
    } else {
      this._initCustomSelect();
    }
  }

  /**
   * Enhance a native select element
   * @private
   */
  _enhanceNativeSelect() {
    // Read native select attributes into options
    if (this.element.multiple) {
      this.options.multiple = true;
    }
    if (this.element.disabled) {
      this.options.disabled = true;
    }

    // Parse options from native select
    this._parseNativeOptions();

    // Create custom select structure
    const wrapper = this._createSelectStructure();

    // Insert wrapper after native select
    this.element.parentNode.insertBefore(wrapper, this.element.nextSibling);

    // Hide native select
    this.element.classList.add('so-select-enhanced');

    // Store reference to wrapper
    this._wrapper = wrapper;
    this._nativeSelect = this.element;

    // Re-assign element to wrapper for component methods
    this.element = wrapper;

    // Store reference on wrapper for static methods (closeAllExcept, etc.)
    wrapper._soSelectInstance = this;

    // Cache elements
    this._cacheElements();

    // Initialize state
    this._initState();

    // Bind events
    this._bindEvents();

    // Apply modifier classes (size, variant, etc.)
    this._applyModifierClasses();

    // Sync initial value from native select
    this._syncFromNative();
  }

  /**
   * Initialize custom select (non-native)
   * @private
   */
  _initCustomSelect() {
    // Cache elements
    this._cacheElements();

    // Parse options from DOM or config
    if (this.options.options.length > 0) {
      this._renderOptions(this.options.options);
    } else {
      this._parseOptionsFromDOM();
    }

    // Initialize state
    this._initState();

    // Bind events
    this._bindEvents();

    // Apply initial classes
    this._applyModifierClasses();
  }

  /**
   * Parse options from native select element
   * @private
   */
  _parseNativeOptions() {
    const nativeOptions = [];
    const optgroups = this.element.querySelectorAll('optgroup');

    if (optgroups.length > 0) {
      // Has optgroups
      optgroups.forEach(group => {
        const groupOptions = [];
        group.querySelectorAll('option').forEach(opt => {
          if (opt.value) {
            groupOptions.push({
              value: opt.value,
              label: opt.textContent,
              icon: opt.dataset.icon || null,
              description: opt.dataset.description || null,
              disabled: opt.disabled,
              selected: opt.selected,
            });
          }
        });
        nativeOptions.push({
          label: group.label,
          options: groupOptions,
        });
      });

      // Also get options not in groups
      const rootOptions = [];
      this.element.querySelectorAll(':scope > option').forEach(opt => {
        if (opt.value) {
          rootOptions.push({
            value: opt.value,
            label: opt.textContent,
            icon: opt.dataset.icon || null,
            description: opt.dataset.description || null,
            disabled: opt.disabled,
            selected: opt.selected,
          });
        }
      });
      if (rootOptions.length > 0) {
        nativeOptions.unshift(...rootOptions);
      }
    } else {
      // No optgroups
      this.element.querySelectorAll('option').forEach(opt => {
        if (opt.value) {
          nativeOptions.push({
            value: opt.value,
            label: opt.textContent,
            icon: opt.dataset.icon || null,
            description: opt.dataset.description || null,
            disabled: opt.disabled,
            selected: opt.selected,
          });
        }
      });
    }

    this._optionsData = nativeOptions;
  }

  /**
   * Parse options from DOM structure
   * @private
   */
  _parseOptionsFromDOM() {
    this._optionsData = [];
    const groups = this.$$('.so-select-group');

    if (groups.length > 0) {
      groups.forEach(group => {
        const label = group.querySelector('.so-select-group-label')?.textContent || '';
        const options = [];
        group.querySelectorAll('.so-select-option').forEach(opt => {
          options.push(this._parseOptionElement(opt));
        });
        this._optionsData.push({ label, options });
      });
    } else {
      this.$$('.so-select-option').forEach(opt => {
        this._optionsData.push(this._parseOptionElement(opt));
      });
    }
  }

  /**
   * Parse a single option element
   * @param {Element} opt - Option element
   * @returns {Object} Option data
   * @private
   */
  _parseOptionElement(opt) {
    return {
      value: opt.dataset.value,
      label: opt.querySelector('.so-select-option-text')?.textContent ||
             opt.querySelector('.so-select-option-content')?.textContent ||
             opt.textContent.trim(),
      icon: opt.querySelector('.so-select-option-icon .material-icons')?.textContent,
      description: opt.querySelector('.so-select-option-desc')?.textContent,
      disabled: opt.classList.contains('so-disabled'),
      selected: opt.classList.contains('so-selected'),
    };
  }

  /**
   * Create select structure for native enhancement
   * @returns {HTMLElement} Wrapper element
   * @private
   */
  _createSelectStructure() {
    const wrapper = document.createElement('div');
    wrapper.className = 'so-select';

    // Copy data attributes from native select
    Array.from(this.element.attributes).forEach(attr => {
      if (attr.name.startsWith('data-so-') && attr.name !== 'data-so-select') {
        wrapper.setAttribute(attr.name, attr.value);
      }
    });

    // Build HTML structure
    wrapper.innerHTML = this._buildSelectHTML();

    return wrapper;
  }

  /**
   * Build select HTML structure
   * @returns {string} HTML string
   * @private
   */
  _buildSelectHTML() {
    const placeholder = this.options.placeholder;
    const selectionStyle = this.options.selectionStyle;
    const selectionIcon = this.options.selectionIcon;

    let optionsHTML = this._buildOptionsHTML(this._optionsData, selectionStyle, selectionIcon);

    let searchHTML = '';
    if (this.options.searchable) {
      searchHTML = `
        <div class="so-select-search">
          <span class="material-icons">search</span>
          <input type="text" class="so-select-search-input" placeholder="${this.options.searchPlaceholder}">
        </div>
      `;
    }

    let actionsHTML = '';
    if (this.options.multiple && this.options.showActions) {
      actionsHTML = `
        <div class="so-select-actions">
          <button type="button" class="so-select-action so-select-action-all">${this.options.selectAllText}</button>
          ${this.options.selectNoneText ? `
            <span class="so-select-action-separator">|</span>
            <button type="button" class="so-select-action so-select-action-none">${this.options.selectNoneText}</button>
          ` : ''}
        </div>
      `;
    }

    let clearHTML = '';
    if (this.options.clearable) {
      clearHTML = `
        <button type="button" class="so-select-clear" style="display: none;">
          <span class="material-icons">close</span>
        </button>
      `;
    }

    return `
      <div class="so-select-trigger" tabindex="0">
        ${this.options.multiple && this.options.displayMode !== 'text' ?
          '<div class="so-select-chips"></div>' :
          `<span class="so-select-placeholder">${placeholder}</span>`
        }
        ${clearHTML}
        <span class="so-select-arrow"><span class="material-icons">expand_more</span></span>
      </div>
      <div class="so-select-dropdown">
        ${searchHTML}
        ${actionsHTML}
        <div class="so-select-options">
          ${optionsHTML}
        </div>
        <div class="so-select-no-results" style="display: none;">${this.options.noResultsText}</div>
        <div class="so-select-loading-text" style="display: none;">${this.options.loadingText}</div>
      </div>
    `;
  }

  /**
   * Build options HTML
   * @param {Array} options - Options data
   * @param {string} selectionStyle - Selection style
   * @param {string} selectionIcon - Selection icon
   * @returns {string} HTML string
   * @private
   */
  _buildOptionsHTML(options, selectionStyle, selectionIcon) {
    if (!options || options.length === 0) return '';

    let html = '';

    options.forEach(item => {
      if (item.options) {
        // It's a group
        html += `<div class="so-select-group">`;
        html += `<div class="so-select-group-label">${item.label}</div>`;
        item.options.forEach(opt => {
          html += this._buildOptionHTML(opt, selectionStyle, selectionIcon);
        });
        html += `</div>`;
      } else {
        // It's a single option
        html += this._buildOptionHTML(item, selectionStyle, selectionIcon);
      }
    });

    return html;
  }

  /**
   * Build single option HTML
   * @param {Object} opt - Option data
   * @param {string} selectionStyle - Selection style
   * @param {string} selectionIcon - Selection icon
   * @returns {string} HTML string
   * @private
   */
  _buildOptionHTML(opt, selectionStyle, selectionIcon) {
    const classes = ['so-select-option'];
    if (opt.disabled) classes.push('so-disabled');
    if (opt.selected) classes.push('so-selected');

    // Checkbox indicator (for multiple select)
    let checkboxHTML = '';
    if (selectionStyle === 'checkbox' || selectionStyle === 'checkbox-bg') {
      checkboxHTML = `<span class="so-checkbox-box"><span class="material-icons">${selectionIcon}</span></span>`;
    }

    // Radio indicator (for single select) - uses existing so-radio-circle class
    let radioHTML = '';
    if (selectionStyle === 'radio' || selectionStyle === 'radio-bg') {
      radioHTML = `<span class="so-radio-circle"></span>`;
    }

    let iconHTML = '';
    if (opt.icon) {
      iconHTML = `<span class="so-select-option-icon"><span class="material-icons">${opt.icon}</span></span>`;
    }

    let contentHTML = '';
    if (opt.description) {
      contentHTML = `
        <div class="so-select-option-content">
          <span class="so-select-option-text">${opt.label}</span>
          <span class="so-select-option-desc">${opt.description}</span>
        </div>
      `;
    } else {
      contentHTML = `<span class="so-select-option-content">${opt.label}</span>`;
    }

    // Check icon (for icon and icon-bg styles)
    let checkHTML = '';
    const noCheckStyles = ['checkbox', 'checkbox-bg', 'radio', 'radio-bg', 'bg'];
    if (!noCheckStyles.includes(selectionStyle)) {
      checkHTML = `<span class="so-select-option-check"><span class="material-icons">${selectionIcon}</span></span>`;
    }

    return `
      <div class="${classes.join(' ')}" data-value="${opt.value}">
        ${checkboxHTML}
        ${radioHTML}
        ${iconHTML}
        ${contentHTML}
        ${checkHTML}
      </div>
    `;
  }

  /**
   * Cache DOM elements
   * @private
   */
  _cacheElements() {
    this._trigger = this.$('.so-select-trigger');
    this._dropdown = this.$('.so-select-dropdown');
    this._optionsList = this.$('.so-select-options');
    this._searchInput = this.$('.so-select-search-input');
    this._placeholder = this.$('.so-select-placeholder');
    this._valueEl = this.$('.so-select-value');
    this._chipsContainer = this.$('.so-select-chips');
    this._clearBtn = this.$('.so-select-clear');
    this._noResults = this.$('.so-select-no-results');
    this._loadingText = this.$('.so-select-loading-text');
    this._actionsAll = this.$('.so-select-action-all');
    this._actionsNone = this.$('.so-select-action-none');
  }

  /**
   * Initialize state
   * @private
   */
  _initState() {
    this._isOpen = false;
    this._disabled = this.options.disabled;
    this._selectedValues = [];
    this._selectedTexts = [];
    this._focusedIndex = -1;
    this._searchQuery = '';

    // Get initial selections
    this._getInitialSelections();
  }

  /**
   * Get initial selections from DOM
   * @private
   */
  _getInitialSelections() {
    const selected = this.$$('.so-select-option.so-selected');
    selected.forEach(opt => {
      this._selectedValues.push(opt.dataset.value);
      this._selectedTexts.push(this._getOptionText(opt));
    });

    // Update display
    this._updateDisplay();
  }

  /**
   * Apply modifier classes based on options
   * @private
   */
  _applyModifierClasses() {
    if (this.options.searchable) {
      this.addClass('so-select-searchable');
    }
    if (this.options.multiple) {
      this.addClass('so-select-multiple');
    }
    if (this.options.clearable) {
      this.addClass('so-select-clearable');
    }
    if (this.options.disabled) {
      this.addClass('so-select-disabled');
    }

    // Selection style
    if (this.options.selectionStyle !== 'icon-bg') {
      this.addClass(`so-select-style-${this.options.selectionStyle}`);
    }

    // Display mode
    if (this.options.displayMode !== 'text') {
      this.addClass(`so-select-display-${this.options.displayMode}`);
    }

    // Size variants
    if (this.options.size) {
      this.addClass(`so-select-${this.options.size}`);
    }

    // Color variants
    if (this.options.variant) {
      this.addClass(`so-select-${this.options.variant}`);
    }

    // Nowrap - prevent text wrapping in options
    if (this.options.nowrap) {
      this.addClass('so-select-nowrap');
    }
  }

  /**
   * Sync from native select
   * @private
   */
  _syncFromNative() {
    if (!this._nativeSelect) return;

    const selectedOptions = Array.from(this._nativeSelect.selectedOptions);
    this._selectedValues = [];
    this._selectedTexts = [];

    selectedOptions.forEach(opt => {
      if (opt.value) {
        this._selectedValues.push(opt.value);
        this._selectedTexts.push(opt.textContent);

        // Mark as selected in custom select
        const customOpt = this.$$(`.so-select-option[data-value="${opt.value}"]`);
        if (customOpt.length) {
          customOpt[0].classList.add('so-selected');
        }
      }
    });

    this._updateDisplay();
  }

  /**
   * Sync to native select
   * @private
   */
  _syncToNative() {
    if (!this._nativeSelect) return;

    // Set flag to prevent infinite loop with bidirectional sync
    this._syncingToNative = true;

    // Update native select options
    Array.from(this._nativeSelect.options).forEach(opt => {
      opt.selected = this._selectedValues.includes(opt.value);
    });

    // Trigger native change event
    this._nativeSelect.dispatchEvent(new Event('change', { bubbles: true }));

    // Clear flag after event propagation
    this._syncingToNative = false;
  }

  // ============================================
  // EVENT BINDING
  // ============================================

  _bindEvents() {
    // Trigger click
    this.on('click', this._handleTriggerClick, this._trigger);
    this.on('keydown', this._handleTriggerKeydown, this._trigger);

    // Option clicks
    this.delegate('click', '.so-select-option', this._handleOptionClick);

    // Search input
    if (this._searchInput) {
      this.on('input', this._handleSearch, this._searchInput);
      this.on('click', (e) => e.stopPropagation(), this._searchInput);
    }

    // Clear button
    if (this._clearBtn) {
      this.on('click', this._handleClear, this._clearBtn);
    }

    // Actions
    if (this._actionsAll) {
      this.on('click', this._handleSelectAll, this._actionsAll);
    }
    if (this._actionsNone) {
      this.on('click', this._handleSelectNone, this._actionsNone);
    }

    // Chip remove buttons
    this.delegate('click', '.so-select-chip-remove', this._handleChipRemove);

    // Outside click
    this.on('click', this._handleOutsideClick, document);

    // Keyboard navigation
    this.on('keydown', this._handleKeydown, this.element);

    // Listen for programmatic changes to native select (bidirectional sync)
    if (this._nativeSelect) {
      this._nativeChangeHandler = this._handleNativeChange.bind(this);
      this._nativeSelect.addEventListener('change', this._nativeChangeHandler);
    }
  }

  /**
   * Handle native select change (for bidirectional sync)
   * This allows external code to change the native select and have the custom UI update
   * @private
   */
  _handleNativeChange() {
    // Prevent infinite loop - only sync if change wasn't triggered by us
    if (this._syncingToNative) return;
    this._syncFromNativeExternal();
  }

  /**
   * Sync from native select when changed externally
   * @private
   */
  _syncFromNativeExternal() {
    if (!this._nativeSelect) return;

    // Clear current selections in custom UI
    this.$$('.so-select-option.so-selected').forEach(opt => {
      opt.classList.remove('so-selected');
    });

    // Get selected values from native
    const selectedOptions = Array.from(this._nativeSelect.selectedOptions);
    this._selectedValues = [];
    this._selectedTexts = [];

    selectedOptions.forEach(opt => {
      if (opt.value) {
        this._selectedValues.push(opt.value);
        this._selectedTexts.push(opt.textContent);

        // Mark as selected in custom select
        const customOpt = this.$$(`.so-select-option[data-value="${opt.value}"]`);
        if (customOpt.length) {
          customOpt[0].classList.add('so-selected');
        }
      }
    });

    this._updateDisplay();

    // Emit custom change event
    this.emit(SOSelect.EVENTS.CHANGE, {
      value: this._selectedValues[0] || null,
      values: [...this._selectedValues],
      text: this._selectedTexts[0] || null,
      texts: [...this._selectedTexts],
    });
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  _handleTriggerClick(e) {
    // Don't toggle if clicking on chip remove button
    if (e.target.closest('.so-select-chip-remove')) {
      e.stopPropagation();
      const chip = e.target.closest('.so-select-chip');
      if (chip?.dataset.value) {
        this.removeValue(chip.dataset.value);
      }
      return;
    }

    e.stopPropagation();
    if (this._disabled) return;
    this.toggle();
  }

  _handleTriggerKeydown(e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      this.toggle();
    } else if (e.key === 'ArrowDown' && !this._isOpen) {
      e.preventDefault();
      this.open();
    }
  }

  _handleOptionClick(e, item) {
    e.stopPropagation();

    if (item.classList.contains('so-disabled')) return;

    const value = item.dataset.value;
    const text = this._getOptionText(item);

    if (this.options.multiple) {
      this._toggleSelection(value, text, item);
    } else {
      this._selectSingle(value, text, item);
      if (this.options.closeOnSelect) {
        this.close();
      }
    }
  }

  _handleSearch(e) {
    const query = e.target.value.toLowerCase().trim();
    this._searchQuery = query;
    this._filterOptions(query);
    this.emit(SOSelect.EVENTS.SEARCH, { query });
  }

  _handleClear(e) {
    e.stopPropagation();
    this.clear();
  }

  _handleSelectAll(e) {
    e.preventDefault();
    e.stopPropagation();
    this.selectAll();
  }

  _handleSelectNone(e) {
    e.preventDefault();
    e.stopPropagation();
    this.selectNone();
  }

  _handleChipRemove(e, chip) {
    e.stopPropagation();
    const value = chip.closest('.so-select-chip')?.dataset.value;
    if (value) {
      this.removeValue(value);
    }
  }

  _handleOutsideClick(e) {
    if (!this._isOpen) return;
    // Skip if we just opened (prevents same-click-cycle closing from external triggers)
    if (this._justOpened) return;
    if (this.element.contains(e.target)) return;
    this.close();
  }

  _handleKeydown(e) {
    if (!this._isOpen) return;

    const items = this._getNavigableOptions();

    switch (e.key) {
      case 'Escape':
        e.preventDefault();
        this.close();
        this._trigger?.focus();
        break;

      case 'ArrowDown':
        e.preventDefault();
        this._focusNextOption(items, 1);
        break;

      case 'ArrowUp':
        e.preventDefault();
        this._focusNextOption(items, -1);
        break;

      case 'Enter':
      case ' ':
        e.preventDefault();
        if (this._focusedIndex >= 0 && items[this._focusedIndex]) {
          items[this._focusedIndex].click();
        }
        break;

      case 'Home':
        e.preventDefault();
        this._focusOption(items, 0);
        break;

      case 'End':
        e.preventDefault();
        this._focusOption(items, items.length - 1);
        break;
    }
  }

  // ============================================
  // SELECTION LOGIC
  // ============================================

  _selectSingle(value, text, item) {
    const previousValues = [...this._selectedValues];

    // Remove previous selection
    this.$$('.so-select-option.so-selected').forEach(opt => {
      opt.classList.remove('so-selected');
    });

    // Set new selection
    this._selectedValues = [value];
    this._selectedTexts = [text];
    item.classList.add('so-selected');

    // Update display
    this._updateDisplay();

    // Sync to native
    this._syncToNative();

    // Emit event
    this.emit(SOSelect.EVENTS.CHANGE, {
      value,
      text,
      values: this._selectedValues,
      texts: this._selectedTexts,
      previousValues,
    });
  }

  _toggleSelection(value, text, item) {
    const previousValues = [...this._selectedValues];
    const index = this._selectedValues.indexOf(value);

    if (index > -1) {
      // Deselect
      const minSelections = this.options.minSelections || 0;
      if (this._selectedValues.length <= minSelections) {
        return; // Can't deselect below minimum
      }

      this._selectedValues.splice(index, 1);
      this._selectedTexts.splice(index, 1);
      item.classList.remove('so-selected');
    } else {
      // Select
      if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
        return; // Can't exceed maximum
      }

      this._selectedValues.push(value);
      this._selectedTexts.push(text);
      item.classList.add('so-selected');
    }

    // Update display
    this._updateDisplay();

    // Sync to native
    this._syncToNative();

    // Emit event
    this.emit(SOSelect.EVENTS.CHANGE, {
      value,
      text,
      values: this._selectedValues,
      texts: this._selectedTexts,
      previousValues,
      action: index > -1 ? 'deselect' : 'select',
    });
  }

  // ============================================
  // DISPLAY UPDATE
  // ============================================

  _updateDisplay() {
    const count = this._selectedValues.length;

    // Show/hide clear button
    if (this._clearBtn) {
      this._clearBtn.style.display = count > 0 ? 'flex' : 'none';
    }

    if (count === 0) {
      this._showPlaceholder();
      return;
    }

    if (this.options.multiple) {
      this._updateMultipleDisplay();
    } else {
      this._updateSingleDisplay();
    }
  }

  _showPlaceholder() {
    if (this._placeholder) {
      this._placeholder.style.display = '';
      this._placeholder.textContent = this.options.placeholder;
    }
    if (this._valueEl) {
      this._valueEl.style.display = 'none';
    }
    if (this._chipsContainer) {
      this._chipsContainer.innerHTML = '';
    }
  }

  _updateSingleDisplay() {
    const text = this._selectedTexts[0];

    if (this._placeholder) {
      this._placeholder.textContent = text;
      this._placeholder.classList.remove('so-select-placeholder');
      this._placeholder.classList.add('so-select-value');
    }
  }

  _updateMultipleDisplay() {
    const count = this._selectedValues.length;
    const totalItems = this._getTotalSelectableOptions();
    const displayMode = this.options.displayMode;

    if (displayMode === 'chips' || displayMode === 'chips-overflow') {
      this._renderChips();
    } else {
      // Text mode
      let text;
      if (count === totalItems && this.options.allSelectedText) {
        text = this.options.allSelectedText.replace('{count}', count);
      } else {
        text = this.options.multipleSelectedText.replace('{count}', count);
      }

      if (this._placeholder) {
        this._placeholder.textContent = text;
        this._placeholder.classList.remove('so-select-placeholder');
        this._placeholder.classList.add('so-select-value');
      }
    }
  }

  _renderChips() {
    if (!this._chipsContainer) return;

    const displayMode = this.options.displayMode;
    const maxChips = this.options.maxVisibleChips;
    let chips = '';

    const valuesToShow = displayMode === 'chips-overflow'
      ? this._selectedValues.slice(0, maxChips)
      : this._selectedValues;

    valuesToShow.forEach((value, i) => {
      const text = this._selectedTexts[i] || value;
      chips += `
        <span class="so-select-chip" data-value="${value}">
          <span>${text}</span>
          <button type="button" class="so-select-chip-remove">
            <span class="material-icons">close</span>
          </button>
        </span>
      `;
    });

    // Add overflow indicator
    if (displayMode === 'chips-overflow' && this._selectedValues.length > maxChips) {
      const overflowCount = this._selectedValues.length - maxChips;
      const overflowText = this.options.overflowText.replace('{count}', overflowCount);
      chips += `<span class="so-select-overflow">${overflowText}</span>`;
    }

    this._chipsContainer.innerHTML = chips;

    // Hide placeholder if we have chips
    if (this._placeholder) {
      this._placeholder.style.display = 'none';
    }
  }

  // ============================================
  // FILTERING
  // ============================================

  _filterOptions(query) {
    const options = this.$$('.so-select-option');
    const groups = this.$$('.so-select-group');
    let visibleCount = 0;

    options.forEach(opt => {
      const text = this._getOptionText(opt).toLowerCase();
      const matches = !query || text.includes(query);
      opt.style.display = matches ? '' : 'none';
      if (matches) visibleCount++;
    });

    // Hide empty groups
    groups.forEach(group => {
      const visibleOptions = group.querySelectorAll('.so-select-option:not([style*="display: none"])');
      group.style.display = visibleOptions.length > 0 ? '' : 'none';
    });

    // Show/hide no results
    if (this._noResults) {
      this._noResults.style.display = visibleCount === 0 ? '' : 'none';
    }
  }

  // ============================================
  // KEYBOARD NAVIGATION
  // ============================================

  _getNavigableOptions() {
    return this.$$('.so-select-option').filter(opt =>
      !opt.classList.contains('so-disabled') &&
      opt.style.display !== 'none'
    );
  }

  _focusNextOption(items, direction) {
    if (items.length === 0) return;

    let newIndex = this._focusedIndex + direction;
    if (newIndex < 0) newIndex = items.length - 1;
    if (newIndex >= items.length) newIndex = 0;

    this._focusOption(items, newIndex);
  }

  _focusOption(items, index) {
    // Remove focus from all
    this.$$('.so-select-option').forEach(opt => opt.classList.remove('so-focused'));

    // Set new focus
    this._focusedIndex = index;
    if (items[index]) {
      items[index].classList.add('so-focused');
      items[index].scrollIntoView({ block: 'nearest' });
    }
  }

  _clearFocus() {
    this.$$('.so-select-option').forEach(opt => opt.classList.remove('so-focused'));
    this._focusedIndex = -1;
  }

  // ============================================
  // UTILITY METHODS
  // ============================================

  _getOptionText(opt) {
    // Get text from specific elements, avoiding check icons and checkboxes
    const textEl = opt.querySelector('.so-select-option-text');
    if (textEl) return textEl.textContent;

    const contentEl = opt.querySelector('.so-select-option-content');
    if (contentEl) return contentEl.textContent;

    // Fallback: clone the node and remove check/checkbox elements before getting text
    const clone = opt.cloneNode(true);
    clone.querySelectorAll('.so-select-option-check, .so-checkbox-box').forEach(el => el.remove());
    return clone.textContent.trim();
  }

  _getTotalSelectableOptions() {
    return this.$$('.so-select-option').filter(opt =>
      !opt.classList.contains('so-disabled')
    ).length;
  }

  _findOptionByValue(value) {
    return this.$(`.so-select-option[data-value="${value}"]`);
  }

  // ============================================
  // PUBLIC API - DROPDOWN CONTROL
  // ============================================

  open() {
    if (this._isOpen || this._disabled) return this;

    const allowed = this.emit(SOSelect.EVENTS.OPEN, {}, true, true);
    if (!allowed) return this;

    // Close any other open selects before opening this one
    SOSelect.closeAllExcept(this);

    this._isOpen = true;
    this.addClass('so-select-open');

    // Prevent immediate close from same click event (for programmatic open)
    this._justOpened = true;
    requestAnimationFrame(() => {
      this._justOpened = false;
    });

    // Focus search input if present
    if (this._searchInput) {
      setTimeout(() => this._searchInput.focus(), 50);
    }

    // Reset focus
    this._focusedIndex = -1;

    setTimeout(() => {
      this.emit(SOSelect.EVENTS.OPENED);
    }, 150);

    return this;
  }

  close() {
    if (!this._isOpen) return this;

    const allowed = this.emit(SOSelect.EVENTS.CLOSE, {}, true, true);
    if (!allowed) return this;

    this._isOpen = false;
    this.removeClass('so-select-open');

    // Clear search
    if (this._searchInput) {
      this._searchInput.value = '';
      this._filterOptions('');
    }

    // Clear focus
    this._clearFocus();

    setTimeout(() => {
      this.emit(SOSelect.EVENTS.CLOSED);
    }, 150);

    return this;
  }

  toggle() {
    return this._isOpen ? this.close() : this.open();
  }

  // ============================================
  // PUBLIC API - VALUE MANAGEMENT
  // ============================================

  getValue() {
    return this._selectedValues[0] || null;
  }

  getValues() {
    return [...this._selectedValues];
  }

  getText() {
    return this._selectedTexts[0] || null;
  }

  getTexts() {
    return [...this._selectedTexts];
  }

  setValue(value) {
    const opt = this._findOptionByValue(value);
    if (opt) {
      const text = this._getOptionText(opt);
      this._selectSingle(value, text, opt);
    }
    return this;
  }

  setValues(values) {
    if (!this.options.multiple) {
      return this.setValue(values[0]);
    }

    // Clear current
    this._selectedValues = [];
    this._selectedTexts = [];
    this.$$('.so-select-option.so-selected').forEach(opt => {
      opt.classList.remove('so-selected');
    });

    // Add new values
    values.forEach(value => {
      const opt = this._findOptionByValue(value);
      if (opt && !opt.classList.contains('so-disabled')) {
        this._selectedValues.push(value);
        this._selectedTexts.push(this._getOptionText(opt));
        opt.classList.add('so-selected');
      }
    });

    this._updateDisplay();
    this._syncToNative();

    return this;
  }

  addValue(value) {
    if (!this.options.multiple) return this.setValue(value);

    const opt = this._findOptionByValue(value);
    if (opt && !this._selectedValues.includes(value)) {
      const text = this._getOptionText(opt);
      this._toggleSelection(value, text, opt);
    }
    return this;
  }

  removeValue(value) {
    const index = this._selectedValues.indexOf(value);
    if (index > -1) {
      const opt = this._findOptionByValue(value);
      if (opt) {
        const text = this._selectedTexts[index];
        this._toggleSelection(value, text, opt);
      }
    }
    return this;
  }

  clear() {
    const previousValues = [...this._selectedValues];

    this._selectedValues = [];
    this._selectedTexts = [];
    this.$$('.so-select-option.so-selected').forEach(opt => {
      opt.classList.remove('so-selected');
    });

    this._updateDisplay();
    this._syncToNative();

    this.emit(SOSelect.EVENTS.CLEAR, { previousValues });
    this.emit(SOSelect.EVENTS.CHANGE, {
      value: null,
      text: null,
      values: [],
      texts: [],
      previousValues,
      action: 'clear',
    });

    return this;
  }

  selectAll() {
    if (!this.options.multiple) return this;

    const previousValues = [...this._selectedValues];
    this._selectedValues = [];
    this._selectedTexts = [];

    this.$$('.so-select-option').forEach(opt => {
      if (opt.classList.contains('so-disabled') || opt.style.display === 'none') {
        return;
      }

      if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
        return;
      }

      const value = opt.dataset.value;
      const text = this._getOptionText(opt);
      this._selectedValues.push(value);
      this._selectedTexts.push(text);
      opt.classList.add('so-selected');
    });

    this._updateDisplay();
    this._syncToNative();

    this.emit(SOSelect.EVENTS.CHANGE, {
      value: this._selectedValues[0] || null,
      text: this._selectedTexts[0] || null,
      values: this._selectedValues,
      texts: this._selectedTexts,
      previousValues,
      action: 'selectAll',
    });

    return this;
  }

  selectNone() {
    if (!this.options.multiple) return this;

    const minSelections = this.options.minSelections || 0;
    if (minSelections > 0) return this;

    return this.clear();
  }

  // ============================================
  // PUBLIC API - STATE CONTROL
  // ============================================

  enable() {
    this._disabled = false;
    this.removeClass('so-select-disabled');
    if (this._trigger) {
      this._trigger.removeAttribute('disabled');
    }
    return this;
  }

  disable() {
    this._disabled = true;
    this.addClass('so-select-disabled');
    if (this._trigger) {
      this._trigger.setAttribute('disabled', '');
    }
    if (this._isOpen) {
      this.close();
    }
    return this;
  }

  isDisabled() {
    return this._disabled;
  }

  isOpen() {
    return this._isOpen;
  }

  setOptionDisabled(value, disabled = true) {
    const opt = this._findOptionByValue(value);
    if (opt) {
      opt.classList.toggle('so-disabled', disabled);
    }
    return this;
  }

  // ============================================
  // PUBLIC API - OPTION MANAGEMENT
  // ============================================

  setOptions(options) {
    this._optionsData = options;
    this._renderOptions(options);
    this._selectedValues = [];
    this._selectedTexts = [];
    this._updateDisplay();
    return this;
  }

  getOptions() {
    return [...this._optionsData];
  }

  _renderOptions(options) {
    if (!this._optionsList) return;

    const html = this._buildOptionsHTML(
      options,
      this.options.selectionStyle,
      this.options.selectionIcon
    );
    this._optionsList.innerHTML = html;
  }

  addOption(option) {
    return this.addOptionAt(option, -1);
  }

  prependOption(option) {
    return this.addOptionAt(option, 0);
  }

  appendOption(option) {
    return this.addOption(option);
  }

  addOptionAt(option, index) {
    const html = this._buildOptionHTML(
      option,
      this.options.selectionStyle,
      this.options.selectionIcon
    );
    const temp = document.createElement('div');
    temp.innerHTML = html;
    const newOpt = temp.firstElementChild;

    const options = this.$$('.so-select-option');
    if (index < 0 || index >= options.length) {
      this._optionsList.appendChild(newOpt);
    } else {
      options[index].before(newOpt);
    }

    // Update data
    if (index < 0 || index >= this._optionsData.length) {
      this._optionsData.push(option);
    } else {
      this._optionsData.splice(index, 0, option);
    }

    return this;
  }

  addOptionBefore(option, beforeValue) {
    const beforeOpt = this._findOptionByValue(beforeValue);
    if (beforeOpt) {
      const html = this._buildOptionHTML(
        option,
        this.options.selectionStyle,
        this.options.selectionIcon
      );
      beforeOpt.insertAdjacentHTML('beforebegin', html);
    }
    return this;
  }

  addOptionAfter(option, afterValue) {
    const afterOpt = this._findOptionByValue(afterValue);
    if (afterOpt) {
      const html = this._buildOptionHTML(
        option,
        this.options.selectionStyle,
        this.options.selectionIcon
      );
      afterOpt.insertAdjacentHTML('afterend', html);
    }
    return this;
  }

  addOptionToGroup(option, groupLabel) {
    const group = this._findGroupByLabel(groupLabel);
    if (group) {
      const html = this._buildOptionHTML(
        option,
        this.options.selectionStyle,
        this.options.selectionIcon
      );
      group.insertAdjacentHTML('beforeend', html);
    }
    return this;
  }

  addGroup(label, options = []) {
    let html = `<div class="so-select-group">`;
    html += `<div class="so-select-group-label">${label}</div>`;
    options.forEach(opt => {
      html += this._buildOptionHTML(opt, this.options.selectionStyle, this.options.selectionIcon);
    });
    html += `</div>`;

    this._optionsList.insertAdjacentHTML('beforeend', html);
    this._optionsData.push({ label, options });

    return this;
  }

  removeOption(value) {
    const opt = this._findOptionByValue(value);
    if (opt) {
      opt.remove();

      // Remove from selected if needed
      const index = this._selectedValues.indexOf(value);
      if (index > -1) {
        this._selectedValues.splice(index, 1);
        this._selectedTexts.splice(index, 1);
        this._updateDisplay();
        this._syncToNative();
      }
    }
    return this;
  }

  removeGroup(label) {
    const group = this._findGroupByLabel(label);
    if (group) {
      // Remove all selected values from this group
      group.querySelectorAll('.so-select-option').forEach(opt => {
        const value = opt.dataset.value;
        const index = this._selectedValues.indexOf(value);
        if (index > -1) {
          this._selectedValues.splice(index, 1);
          this._selectedTexts.splice(index, 1);
        }
      });

      group.remove();
      this._updateDisplay();
      this._syncToNative();
    }
    return this;
  }

  clearOptions() {
    this._optionsList.innerHTML = '';
    this._optionsData = [];
    this._selectedValues = [];
    this._selectedTexts = [];
    this._updateDisplay();
    this._syncToNative();
    return this;
  }

  updateOption(value, newOption) {
    const opt = this._findOptionByValue(value);
    if (opt) {
      const wasSelected = opt.classList.contains('so-selected');
      const html = this._buildOptionHTML(
        { ...newOption, value: newOption.value || value, selected: wasSelected },
        this.options.selectionStyle,
        this.options.selectionIcon
      );
      opt.outerHTML = html;

      // Update text if selected
      const index = this._selectedValues.indexOf(value);
      if (index > -1 && newOption.label) {
        this._selectedTexts[index] = newOption.label;
        this._updateDisplay();
      }
    }
    return this;
  }

  getOption(value) {
    const opt = this._findOptionByValue(value);
    if (opt) {
      return this._parseOptionElement(opt);
    }
    return null;
  }

  hasOption(value) {
    return !!this._findOptionByValue(value);
  }

  /**
   * Destroy the component and clean up
   */
  destroy() {
    // Remove native select change listener
    if (this._nativeSelect && this._nativeChangeHandler) {
      this._nativeSelect.removeEventListener('change', this._nativeChangeHandler);
    }

    // Show native select again
    if (this._nativeSelect) {
      this._nativeSelect.classList.remove('so-select-enhanced');
    }

    // Remove custom element
    if (this.element && this.element.parentNode) {
      this.element.parentNode.removeChild(this.element);
    }

    // Call parent destroy if exists
    if (super.destroy) {
      super.destroy();
    }

    return this;
  }

  _findGroupByLabel(label) {
    const groups = this.$$('.so-select-group');
    return groups.find(g => {
      const groupLabel = g.querySelector('.so-select-group-label')?.textContent;
      return groupLabel === label;
    });
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  static create(options = {}) {
    const wrapper = document.createElement('div');
    wrapper.className = 'so-select';

    // Set data attributes
    if (options.searchable) wrapper.setAttribute('data-so-searchable', 'true');
    if (options.multiple) wrapper.setAttribute('data-so-multiple', 'true');
    if (options.clearable) wrapper.setAttribute('data-so-clearable', 'true');
    if (options.placeholder) wrapper.setAttribute('data-so-placeholder', options.placeholder);

    // Create instance
    const instance = new SOSelect(wrapper, options);
    instance.element = wrapper;

    // Build and render
    instance._optionsData = options.options || [];
    wrapper.innerHTML = instance._buildSelectHTML();
    instance._cacheElements();
    instance._initState();
    instance._bindEvents();
    instance._applyModifierClasses();

    return instance;
  }

  static createFromSelect(selectElement, options = {}) {
    return SOSelect.getInstance(selectElement, options);
  }

  /**
   * Close all open selects except the specified one
   * @param {SOSelect} exceptInstance - Instance to exclude from closing
   */
  static closeAllExcept(exceptInstance = null) {
    const openSelects = document.querySelectorAll('.so-select.so-select-open');
    openSelects.forEach(wrapperEl => {
      // Get instance from wrapper's stored reference
      const instance = wrapperEl._soSelectInstance;
      if (instance && instance !== exceptInstance && instance._isOpen) {
        instance.close();
      }
    });
  }

  /**
   * Close all open selects
   */
  static closeAll() {
    SOSelect.closeAllExcept(null);
  }
}

// Register component
SOSelect.register();

// Expose to global scope
window.SOSelect = SOSelect;

// Export for ES modules
export default SOSelect;
export { SOSelect };
