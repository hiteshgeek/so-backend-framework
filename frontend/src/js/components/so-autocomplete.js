// ============================================
// SIXORBIT UI - AUTOCOMPLETE COMPONENT
// Autocomplete/Token Input with full features
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOAutocomplete - Autocomplete/Token Input component
 * Supports single/multi-select, async data, free solo mode, and more
 */
class SOAutocomplete extends SOComponent {
  static NAME = 'autocomplete';

  static DEFAULTS = {
    // Basic options
    placeholder: 'Type to search...',
    noResultsText: 'No results found',
    loadingText: 'Loading...',
    clearable: true,
    disabled: false,
    autoFocus: false,

    // Mode options
    multiple: false,        // Enable multiple selection with tokens
    freeSolo: false,        // Allow custom values not in predefined options

    // Data source options
    options: [],            // Static options array: [{ value, text, disabled, group }, ...]
    async: false,           // Enable async data loading
    asyncUrl: null,         // Remote API endpoint
    asyncMethod: 'GET',     // HTTP method
    asyncParam: 'q',        // Query parameter name
    minSearchLength: 0,     // Minimum characters before search
    debounceTime: 300,      // Debounce delay in milliseconds
    loadOnOpen: false,      // Load data when dropdown opens

    // Filtering options
    filterFunction: null,   // Custom filter function
    caseSensitive: false,   // Case-sensitive filtering
    highlightMatches: true, // Highlight typed text in results

    // Display options (multiple mode)
    displayMode: 'chips',   // 'chips', 'text', 'chips-overflow'
    maxVisibleTokens: 3,    // Max visible tokens before "+N more"
    tokenSize: null,        // 'sm', 'lg', or null
    overflowText: '+{count} more',
    multipleSelectedText: '{count} selected',

    // Selection options
    minSelections: null,    // Minimum selections (multiple mode)
    maxSelections: null,    // Maximum selections (multiple mode)
    closeOnSelect: true,    // Close dropdown after selection (single mode)
    allowDuplicates: false, // Allow duplicate tokens (free solo)

    // Token options (free solo + multiple)
    tokenDelimiters: [',', ';'], // Characters that create tokens
    tokenValidation: null,  // Function to validate tokens: (value) => boolean

    // Grouping options
    grouped: false,         // Enable option grouping
    groupBy: null,          // Function to group options: (option) => groupName

    // Visual options
    size: null,             // 'sm', 'lg', or null for default
    variant: null,          // 'primary', 'secondary', 'success', 'danger', 'warning', 'info'
    maxDropdownHeight: 280, // Max dropdown height in pixels

    // Template options
    optionTemplate: null,   // Custom option render function: (option) => HTML string
    tokenTemplate: null,    // Custom token render function: (token) => HTML string
    noDataTemplate: null,   // Custom no data template: () => HTML string

    // Behavior options
    openOnFocus: false,     // Open dropdown on input focus
    selectOnTab: false,     // Select focused option on Tab key
    clearOnEscape: false,   // Clear input on Escape key
    createOnBlur: false,    // Create token on blur (free solo)
  };

  static EVENTS = {
    // Dropdown events
    OPEN: 'autocomplete:open',
    OPENED: 'autocomplete:opened',
    CLOSE: 'autocomplete:close',
    CLOSED: 'autocomplete:closed',

    // Selection events
    SELECT: 'autocomplete:select',
    DESELECT: 'autocomplete:deselect',
    CHANGE: 'autocomplete:change',

    // Token events (multiple mode)
    TOKEN_ADD: 'autocomplete:token-add',
    TOKEN_REMOVE: 'autocomplete:token-remove',

    // Data events
    SEARCH: 'autocomplete:search',
    INPUT: 'autocomplete:input',
    CLEAR: 'autocomplete:clear',
    CREATE: 'autocomplete:create',

    // Async events
    LOAD_START: 'autocomplete:load-start',
    LOAD_END: 'autocomplete:load-end',
    LOAD_ERROR: 'autocomplete:load-error',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  _init() {
    // State
    this._isOpen = false;
    this._isLoading = false;
    this._disabled = this.options.disabled;
    this._selectedValues = [];
    this._selectedTexts = [];
    this._tokens = [];
    this._allOptions = [];
    this._filteredOptions = [];
    this._focusedIndex = -1;
    this._debounceTimer = null;
    this._abortController = null;

    // Build HTML structure
    this._buildStructure();

    // Cache elements
    this._cacheElements();

    // Set initial options
    if (this.options.options.length > 0) {
      this.setOptions(this.options.options);
    }

    // Bind events
    this._bindEvents();

    // Apply modifier classes
    this._applyModifierClasses();

    // Apply disabled state
    if (this._disabled) {
      this.disable();
    }
  }

  /**
   * Build the HTML structure programmatically
   * @private
   */
  _buildStructure() {
    // Determine if element is just a wrapper or needs full creation
    const existingInput = this.element.querySelector('.so-autocomplete-input');

    if (!existingInput) {
      // Create from scratch
      const structure = this._createStructureHTML();
      this.element.innerHTML = structure;
      this.element.classList.add('so-autocomplete');

      if (this.options.multiple) {
        this.element.classList.add('so-autocomplete-multiple');
      }
    } else {
      // Element already has structure, ensure it has the right classes
      this.element.classList.add('so-autocomplete');

      if (this.options.multiple) {
        this.element.classList.add('so-autocomplete-multiple');
      }
    }
  }

  /**
   * Create HTML structure
   * @private
   * @returns {string} HTML string
   */
  _createStructureHTML() {
    const containerId = `autocomplete-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    const dropdownId = `${containerId}-dropdown`;

    // Multiple mode has tokens container
    const inputArea = this.options.multiple
      ? `<div class="so-autocomplete-tokens">
           <input type="text"
                  class="so-autocomplete-input"
                  placeholder="${this.options.placeholder}"
                  autocomplete="off"
                  role="combobox"
                  aria-expanded="false"
                  aria-haspopup="listbox"
                  aria-owns="${dropdownId}"
                  aria-autocomplete="list">
         </div>`
      : `<input type="text"
                class="so-autocomplete-input"
                placeholder="${this.options.placeholder}"
                autocomplete="off"
                role="combobox"
                aria-expanded="false"
                aria-haspopup="listbox"
                aria-owns="${dropdownId}"
                aria-autocomplete="list">`;

    return `
      <div class="so-autocomplete-container" id="${containerId}">
        ${inputArea}
        <button type="button" class="so-autocomplete-clear" style="display: none;" aria-label="Clear all">
          <span class="material-icons">close</span>
        </button>
        <span class="so-autocomplete-arrow">
          <span class="material-icons">expand_more</span>
        </span>
      </div>
      <div class="so-autocomplete-dropdown" id="${dropdownId}" role="listbox">
        <div class="so-autocomplete-loading" style="display: none;">
          <span class="so-spinner so-spinner-sm"></span>
          <span>${this.options.loadingText}</span>
        </div>
        <div class="so-autocomplete-options"></div>
        <div class="so-autocomplete-no-results" style="display: none;">
          ${this.options.noResultsText}
        </div>
      </div>
    `;
  }

  /**
   * Cache DOM elements
   * @private
   */
  _cacheElements() {
    this._container = this.$('.so-autocomplete-container');
    this._input = this.$('.so-autocomplete-input');
    this._clearBtn = this.$('.so-autocomplete-clear');
    this._arrow = this.$('.so-autocomplete-arrow');
    this._dropdown = this.$('.so-autocomplete-dropdown');
    this._loadingEl = this.$('.so-autocomplete-loading');
    this._optionsContainer = this.$('.so-autocomplete-options');
    this._noResultsEl = this.$('.so-autocomplete-no-results');

    if (this.options.multiple) {
      this._tokensContainer = this.$('.so-autocomplete-tokens');
    }
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Input events
    if (this._input) {
      this.on('input', this._handleInput, this._input);
      this.on('focus', this._handleFocus, this._input);
      this.on('blur', this._handleBlur, this._input);
      this.on('keydown', this._handleKeydown, this._input);
      this.on('click', this._handleInputClick, this._input);
    }

    // Container click (for all modes)
    if (this._container) {
      this.on('click', this._handleContainerClick, this._container);
    }

    // Clear button
    if (this._clearBtn) {
      this.on('click', this._handleClearClick, this._clearBtn);
    }

    // Arrow click
    if (this._arrow) {
      this.on('click', this._handleArrowClick, this._arrow);
    }

    // Option selection (event delegation)
    this.delegate('click', '.so-autocomplete-option', this._handleOptionClick);
    this.delegate('mouseenter', '.so-autocomplete-option', this._handleOptionHover);

    // Outside click
    this.on('click', this._handleOutsideClick, document);

    // Paste event (for free solo mode)
    if (this.options.freeSolo && this.options.multiple && this._input) {
      this.on('paste', this._handlePaste, this._input);
    }
  }

  /**
   * Apply modifier classes based on options
   * @private
   */
  _applyModifierClasses() {
    // Size variant
    if (this.options.size) {
      this.element.classList.add(`so-autocomplete-${this.options.size}`);
    }

    // Color variant
    if (this.options.variant) {
      this.element.classList.add(`so-autocomplete-${this.options.variant}`);
    }

    // Display mode (multiple)
    if (this.options.multiple) {
      this.element.classList.add(`so-autocomplete-display-${this.options.displayMode}`);
    }
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  /**
   * Handle input event
   * @private
   */
  _handleInput(e) {
    const query = e.target.value;

    // Emit input event
    this.emit(SOAutocomplete.EVENTS.INPUT, { query });

    // Debounce search
    this._debounceSearch(query);

    // Update clear button visibility
    this._updateClearButton();
  }

  /**
   * Handle focus event
   * @private
   */
  _handleFocus(e) {
    this.element.classList.add('so-autocomplete-focused');

    // Always open on focus (or use openOnFocus option)
    if (this.options.openOnFocus !== false) {
      this.open();
    }
  }

  /**
   * Handle blur event
   * @private
   */
  _handleBlur(e) {
    // Delay to allow click on dropdown
    setTimeout(() => {
      // Only blur if not clicking inside dropdown
      if (!this._dropdown.contains(document.activeElement) &&
          !this._container.contains(document.activeElement)) {
        this.element.classList.remove('so-autocomplete-focused');

        // Create token on blur (free solo + multiple)
        if (this.options.createOnBlur && this.options.freeSolo && this.options.multiple) {
          const value = this._input.value.trim();
          if (value) {
            this._createToken(value);
            this._input.value = '';
          }
        }
      }
    }, 200);
  }

  /**
   * Handle keydown event
   * @private
   */
  _handleKeydown(e) {
    switch (e.key) {
      case 'ArrowDown':
        e.preventDefault();
        if (!this._isOpen) {
          this.open();
        } else {
          this._focusNextOption();
        }
        break;

      case 'ArrowUp':
        e.preventDefault();
        if (this._isOpen) {
          this._focusPreviousOption();
        }
        break;

      case 'Enter':
        e.preventDefault();
        if (this._isOpen && this._focusedIndex >= 0) {
          this._selectFocusedOption();
        } else if (this.options.freeSolo && this.options.multiple) {
          // Create token from input value
          const value = this._input.value.trim();
          if (value) {
            this._createToken(value);
            this._input.value = '';
          }
        }
        break;

      case 'Escape':
        e.preventDefault();
        if (this._isOpen) {
          this.close();
        } else if (this.options.clearOnEscape) {
          this.clear();
        }
        break;

      case 'Tab':
        if (this.options.selectOnTab && this._isOpen && this._focusedIndex >= 0) {
          e.preventDefault();
          this._selectFocusedOption();
        }
        break;

      case 'Backspace':
        // Remove last token if input is empty (multiple mode)
        if (this.options.multiple && !this._input.value && this._tokens.length > 0) {
          e.preventDefault();
          this.removeToken(this._tokens.length - 1);
        }
        break;

      case 'Home':
        if (this._isOpen) {
          e.preventDefault();
          this._focusOptionAt(0);
        }
        break;

      case 'End':
        if (this._isOpen) {
          e.preventDefault();
          this._focusOptionAt(this._filteredOptions.length - 1);
        }
        break;

      default:
        // Check for delimiters (free solo + multiple)
        if (this.options.freeSolo && this.options.multiple) {
          if (this.options.tokenDelimiters.includes(e.key)) {
            e.preventDefault();
            const value = this._input.value.trim();
            if (value) {
              this._createToken(value);
              this._input.value = '';
            }
          }
        }
        break;
    }
  }

  /**
   * Handle input click
   * @private
   */
  _handleInputClick() {
    if (!this._isOpen) {
      this.open();
    }
  }

  /**
   * Handle container click
   * @private
   */
  _handleContainerClick(e) {
    // Don't handle if clicking on clear or arrow button
    if (e.target.closest('.so-autocomplete-clear, .so-autocomplete-arrow')) {
      return;
    }

    // Don't handle if clicking on token remove button
    if (e.target.closest('.so-autocomplete-token-remove')) {
      return;
    }

    // Focus input and open dropdown when clicking anywhere in the container
    if (this._input && !this._disabled) {
      this._input.focus();
      if (!this._isOpen) {
        this.open();
      }
    }
  }

  /**
   * Handle clear button click
   * @private
   */
  _handleClearClick(e) {
    e.stopPropagation();
    const wasOpen = this._isOpen;
    this.clear();
    this._input.focus();

    // Open dropdown to show all options if it wasn't already open
    if (!wasOpen) {
      this.open();
    }
  }

  /**
   * Handle arrow click
   * @private
   */
  _handleArrowClick(e) {
    e.stopPropagation();
    if (this._disabled) return;

    this.toggle();
  }

  /**
   * Handle option click
   * @private
   */
  _handleOptionClick(e) {
    const optionEl = e.target.closest('.so-autocomplete-option');
    if (!optionEl || optionEl.classList.contains('so-autocomplete-option-disabled')) return;

    const index = parseInt(optionEl.dataset.index, 10);
    const option = this._filteredOptions[index];

    if (option) {
      this._selectOption(option, index);
    }
  }

  /**
   * Handle option hover
   * @private
   */
  _handleOptionHover(e) {
    const optionEl = e.target.closest('.so-autocomplete-option');
    if (!optionEl) return;

    const index = parseInt(optionEl.dataset.index, 10);
    this._focusOptionAt(index);
  }

  /**
   * Handle outside click
   * @private
   */
  _handleOutsideClick(e) {
    if (this._isOpen && !this.element.contains(e.target)) {
      this.close();
    }
  }

  /**
   * Handle paste event (for free solo + multiple)
   * @private
   */
  _handlePaste(e) {
    e.preventDefault();

    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
    const delimiter = this.options.tokenDelimiters[0] || ',';
    const values = pastedText.split(new RegExp(`[${this.options.tokenDelimiters.join('')}]`))
      .map(v => v.trim())
      .filter(v => v);

    values.forEach(value => {
      this._createToken(value);
    });
  }

  // ============================================
  // DROPDOWN CONTROL
  // ============================================

  /**
   * Open the dropdown
   * @returns {SOAutocomplete} this
   */
  open() {
    if (this._disabled || this._isOpen) return this;

    // Emit cancelable event
    const event = this.emit(SOAutocomplete.EVENTS.OPEN, null, true, true);
    if (event.defaultPrevented) return this;

    this._isOpen = true;
    this.element.classList.add('so-autocomplete-open');
    this._input.setAttribute('aria-expanded', 'true');

    // Load data on open if configured
    if (this.options.loadOnOpen && this.options.async && this._allOptions.length === 0) {
      this.loadOptions('');
    } else if (!this.options.async) {
      // Filter with current input value
      this._performSearch(this._input.value);
    }

    // Emit opened event
    this.emit(SOAutocomplete.EVENTS.OPENED);

    return this;
  }

  /**
   * Close the dropdown
   * @returns {SOAutocomplete} this
   */
  close() {
    if (!this._isOpen) return this;

    // Emit cancelable event
    const event = this.emit(SOAutocomplete.EVENTS.CLOSE, null, true, true);
    if (event.defaultPrevented) return this;

    this._isOpen = false;
    this.element.classList.remove('so-autocomplete-open');
    this._input.setAttribute('aria-expanded', 'false');
    this._focusedIndex = -1;

    // Emit closed event
    this.emit(SOAutocomplete.EVENTS.CLOSED);

    return this;
  }

  /**
   * Toggle the dropdown
   * @returns {SOAutocomplete} this
   */
  toggle() {
    return this._isOpen ? this.close() : this.open();
  }

  /**
   * Check if dropdown is open
   * @returns {boolean}
   */
  isOpen() {
    return this._isOpen;
  }

  // ============================================
  // VALUE MANAGEMENT
  // ============================================

  /**
   * Get single selected value
   * @returns {string|null}
   */
  getValue() {
    return this._selectedValues[0] || null;
  }

  /**
   * Get array of selected values
   * @returns {Array<string>}
   */
  getValues() {
    return [...this._selectedValues];
  }

  /**
   * Get single selected text
   * @returns {string|null}
   */
  getText() {
    return this._selectedTexts[0] || null;
  }

  /**
   * Get array of selected texts
   * @returns {Array<string>}
   */
  getTexts() {
    return [...this._selectedTexts];
  }

  /**
   * Set single value
   * @param {string} value - Value to set
   * @returns {SOAutocomplete} this
   */
  setValue(value) {
    const option = this._allOptions.find(opt => opt.value === value);
    if (option) {
      this._selectOption(option);
    }
    return this;
  }

  /**
   * Set multiple values
   * @param {Array<string>} values - Values to set
   * @returns {SOAutocomplete} this
   */
  setValues(values) {
    if (!this.options.multiple) {
      console.warn('setValues() requires multiple mode');
      return this;
    }

    this.clear();
    values.forEach(value => this.addValue(value));
    return this;
  }

  /**
   * Add a value (multiple mode)
   * @param {string} value - Value to add
   * @returns {SOAutocomplete} this
   */
  addValue(value) {
    if (!this.options.multiple) {
      return this.setValue(value);
    }

    const option = this._allOptions.find(opt => opt.value === value);
    if (option) {
      this._selectOption(option);
    } else if (this.options.freeSolo) {
      this._createToken(value);
    }
    return this;
  }

  /**
   * Remove a value
   * @param {string} value - Value to remove
   * @returns {SOAutocomplete} this
   */
  removeValue(value) {
    const index = this._selectedValues.indexOf(value);
    if (index >= 0) {
      if (this.options.multiple) {
        this.removeToken(index);
      } else {
        this.clear();
      }
    }
    return this;
  }

  /**
   * Clear all selections
   * @returns {SOAutocomplete} this
   */
  clear() {
    const hadValues = this._selectedValues.length > 0;

    this._selectedValues = [];
    this._selectedTexts = [];
    this._tokens = [];
    this._input.value = '';

    if (this.options.multiple) {
      this._renderTokens();
      this._updatePlaceholder();
    }

    this._updateClearButton();

    // Refresh dropdown if open to show all items as unselected
    if (this._isOpen) {
      this._performSearch(''); // Re-filter to show all options
    }

    if (hadValues) {
      this.emit(SOAutocomplete.EVENTS.CLEAR);
      this._emitChange();
    }

    return this;
  }

  // ============================================
  // TOKEN MANAGEMENT (Multiple Mode)
  // ============================================

  /**
   * Get array of token objects
   * @returns {Array<{value: string, text: string}>}
   */
  getTokens() {
    return [...this._tokens];
  }

  /**
   * Add a token
   * @param {string} value - Token value
   * @param {string} [text] - Token text (defaults to value)
   * @returns {SOAutocomplete} this
   */
  addToken(value, text = null) {
    if (!this.options.multiple) {
      console.warn('addToken() requires multiple mode');
      return this;
    }

    this._createToken(value, text);
    return this;
  }

  /**
   * Remove token by index
   * @param {number} index - Token index
   * @returns {SOAutocomplete} this
   */
  removeToken(index) {
    if (index < 0 || index >= this._tokens.length) return this;

    const token = this._tokens[index];
    this._tokens.splice(index, 1);

    const valueIndex = this._selectedValues.indexOf(token.value);
    if (valueIndex >= 0) {
      this._selectedValues.splice(valueIndex, 1);
      this._selectedTexts.splice(valueIndex, 1);
    }

    // Render tokens
    this._renderTokens();
    this._updatePlaceholder();
    this._updateClearButton();

    // Refresh dropdown if open to show the removed item as available again
    if (this._isOpen) {
      this._renderOptions();
    }

    // Emit events
    this.emit(SOAutocomplete.EVENTS.TOKEN_REMOVE, { token, tokens: this._tokens, index });
    this._emitChange();

    return this;
  }

  /**
   * Remove token by value
   * @param {string} value - Token value
   * @returns {SOAutocomplete} this
   */
  removeTokenByValue(value) {
    const index = this._tokens.findIndex(t => t.value === value);
    if (index >= 0) {
      this.removeToken(index);
    }
    return this;
  }

  /**
   * Clear all tokens
   * @returns {SOAutocomplete} this
   */
  clearTokens() {
    return this.clear();
  }

  // ============================================
  // INPUT CONTROL
  // ============================================

  /**
   * Get current input text
   * @returns {string}
   */
  getInputValue() {
    return this._input.value;
  }

  /**
   * Set input text
   * @param {string} text - Text to set
   * @returns {SOAutocomplete} this
   */
  setInputValue(text) {
    this._input.value = text;
    this._updateClearButton();
    return this;
  }

  /**
   * Clear input text
   * @returns {SOAutocomplete} this
   */
  clearInput() {
    return this.setInputValue('');
  }

  /**
   * Focus the input
   * @returns {SOAutocomplete} this
   */
  focus() {
    this._input.focus();
    return this;
  }

  /**
   * Blur the input
   * @returns {SOAutocomplete} this
   */
  blur() {
    this._input.blur();
    return this;
  }

  // ============================================
  // OPTIONS MANAGEMENT
  // ============================================

  /**
   * Set all options
   * @param {Array<Object>} options - Options array
   * @returns {SOAutocomplete} this
   */
  setOptions(options) {
    this._allOptions = options.map((opt, idx) => {
      if (typeof opt === 'string') {
        return { value: opt, text: opt };
      }
      return { ...opt, _index: idx };
    });

    // Filter options with current search
    this._performSearch(this._input.value);

    return this;
  }

  /**
   * Get current options
   * @returns {Array<Object>}
   */
  getOptions() {
    return [...this._allOptions];
  }

  /**
   * Add single option
   * @param {Object|string} option - Option to add
   * @returns {SOAutocomplete} this
   */
  addOption(option) {
    const opt = typeof option === 'string' ? { value: option, text: option } : option;
    opt._index = this._allOptions.length;
    this._allOptions.push(opt);
    this._performSearch(this._input.value);
    return this;
  }

  /**
   * Add multiple options
   * @param {Array<Object>} options - Options to add
   * @returns {SOAutocomplete} this
   */
  addOptions(options) {
    options.forEach(opt => this.addOption(opt));
    return this;
  }

  /**
   * Remove option by value
   * @param {string} value - Option value
   * @returns {SOAutocomplete} this
   */
  removeOption(value) {
    this._allOptions = this._allOptions.filter(opt => opt.value !== value);
    this._performSearch(this._input.value);
    return this;
  }

  /**
   * Clear all options
   * @returns {SOAutocomplete} this
   */
  clearOptions() {
    this._allOptions = [];
    this._filteredOptions = [];
    this._renderOptions();
    return this;
  }

  /**
   * Filter options manually
   * @param {string} query - Search query
   * @returns {SOAutocomplete} this
   */
  filterOptions(query) {
    this._performSearch(query);
    return this;
  }

  /**
   * Load options from remote URL
   * @param {string} query - Search query
   * @returns {Promise<void>}
   */
  async loadOptions(query) {
    if (!this.options.async || !this.options.asyncUrl) {
      console.warn('loadOptions() requires async mode and asyncUrl');
      return;
    }

    // Cancel previous request
    if (this._abortController) {
      this._abortController.abort();
    }

    this._abortController = new AbortController();

    try {
      this.setLoading(true);
      this.emit(SOAutocomplete.EVENTS.LOAD_START, { query });

      // Build URL with query parameter
      const url = new URL(this.options.asyncUrl, window.location.origin);
      url.searchParams.set(this.options.asyncParam, query);

      const response = await fetch(url, {
        method: this.options.asyncMethod,
        signal: this._abortController.signal,
      });

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      const data = await response.json();

      // Assume data is array of options or { results: [...] }
      const options = Array.isArray(data) ? data : (data.results || data.data || []);

      this.setOptions(options);

      this.emit(SOAutocomplete.EVENTS.LOAD_END, { data: options, query, count: options.length });
    } catch (error) {
      if (error.name !== 'AbortError') {
        console.error('SOAutocomplete: Load error', error);
        this.emit(SOAutocomplete.EVENTS.LOAD_ERROR, { error, query });
      }
    } finally {
      this.setLoading(false);
      this._abortController = null;
    }
  }

  // ============================================
  // STATE CONTROL
  // ============================================

  /**
   * Enable component
   * @returns {SOAutocomplete} this
   */
  enable() {
    this._disabled = false;
    this.element.classList.remove('so-autocomplete-disabled');
    this._input.disabled = false;
    return this;
  }

  /**
   * Disable component
   * @returns {SOAutocomplete} this
   */
  disable() {
    this._disabled = true;
    this.element.classList.add('so-autocomplete-disabled');
    this._input.disabled = true;
    this.close();
    return this;
  }

  /**
   * Check if disabled
   * @returns {boolean}
   */
  isDisabled() {
    return this._disabled;
  }

  /**
   * Set loading state
   * @param {boolean} loading - Loading state
   * @returns {SOAutocomplete} this
   */
  setLoading(loading) {
    this._isLoading = loading;
    this._loadingEl.style.display = loading ? 'flex' : 'none';

    if (loading) {
      this.element.classList.add('so-autocomplete-loading');
    } else {
      this.element.classList.remove('so-autocomplete-loading');
    }

    return this;
  }

  /**
   * Check if loading
   * @returns {boolean}
   */
  isLoading() {
    return this._isLoading;
  }

  /**
   * Set option disabled state
   * @param {string} value - Option value
   * @param {boolean} disabled - Disabled state
   * @returns {SOAutocomplete} this
   */
  setOptionDisabled(value, disabled) {
    const option = this._allOptions.find(opt => opt.value === value);
    if (option) {
      option.disabled = disabled;
      this._performSearch(this._input.value);
    }
    return this;
  }

  /**
   * Check if option is disabled
   * @param {string} value - Option value
   * @returns {boolean}
   */
  isOptionDisabled(value) {
    const option = this._allOptions.find(opt => opt.value === value);
    return option ? (option.disabled || false) : false;
  }

  // ============================================
  // PRIVATE METHODS - Search & Filter
  // ============================================

  /**
   * Debounce search
   * @private
   */
  _debounceSearch(query) {
    if (this._debounceTimer) {
      clearTimeout(this._debounceTimer);
    }

    this._debounceTimer = setTimeout(() => {
      this._performSearch(query);
    }, this.options.debounceTime);
  }

  /**
   * Perform search/filter
   * @private
   */
  _performSearch(query) {
    const trimmedQuery = query.trim();

    // Check minimum search length
    if (this.options.async && trimmedQuery.length < this.options.minSearchLength) {
      this._filteredOptions = [];
      this._renderOptions();
      return;
    }

    // Async mode
    if (this.options.async) {
      this.loadOptions(trimmedQuery);
      return;
    }

    // Local filtering
    if (!trimmedQuery) {
      this._filteredOptions = [...this._allOptions];
    } else {
      this._filteredOptions = this._allOptions.filter(option => {
        if (this.options.filterFunction) {
          return this.options.filterFunction(option, trimmedQuery);
        }

        // Default filter
        const text = option.text || option.value;
        const searchText = this.options.caseSensitive ? text : text.toLowerCase();
        const searchQuery = this.options.caseSensitive ? trimmedQuery : trimmedQuery.toLowerCase();

        return searchText.includes(searchQuery);
      });
    }

    // Open dropdown if has results
    if (this._filteredOptions.length > 0 && trimmedQuery) {
      if (!this._isOpen) {
        this.open();
      }
    }

    // Emit search event
    this.emit(SOAutocomplete.EVENTS.SEARCH, { query: trimmedQuery, count: this._filteredOptions.length });

    // Render options
    this._renderOptions();
  }

  /**
   * Render options in dropdown
   * @private
   */
  _renderOptions() {
    // Clear existing options
    this._optionsContainer.innerHTML = '';

    // No options
    if (this._filteredOptions.length === 0) {
      this._noResultsEl.style.display = 'block';
      return;
    }

    this._noResultsEl.style.display = 'none';

    // Group options if needed
    if (this.options.grouped && this.options.groupBy) {
      this._renderGroupedOptions();
    } else {
      this._renderFlatOptions();
    }
  }

  /**
   * Render flat (ungrouped) options
   * @private
   */
  _renderFlatOptions() {
    this._filteredOptions.forEach((option, index) => {
      const optionEl = this._createOptionElement(option, index);
      this._optionsContainer.appendChild(optionEl);
    });
  }

  /**
   * Render grouped options
   * @private
   */
  _renderGroupedOptions() {
    // Group options
    const groups = {};
    this._filteredOptions.forEach((option, index) => {
      const groupName = this.options.groupBy(option) || 'Other';
      if (!groups[groupName]) {
        groups[groupName] = [];
      }
      groups[groupName].push({ option, index });
    });

    // Render each group
    Object.entries(groups).forEach(([groupName, items]) => {
      // Group header
      const groupEl = document.createElement('div');
      groupEl.className = 'so-autocomplete-group-header';
      groupEl.textContent = groupName;
      this._optionsContainer.appendChild(groupEl);

      // Group options
      items.forEach(({ option, index }) => {
        const optionEl = this._createOptionElement(option, index);
        this._optionsContainer.appendChild(optionEl);
      });
    });
  }

  /**
   * Create option element
   * @private
   */
  _createOptionElement(option, index) {
    const optionEl = document.createElement('div');
    optionEl.className = 'so-autocomplete-option';
    optionEl.dataset.index = index;
    optionEl.dataset.value = option.value;
    optionEl.setAttribute('role', 'option');

    // Disabled state
    if (option.disabled) {
      optionEl.classList.add('so-autocomplete-option-disabled');
      optionEl.setAttribute('aria-disabled', 'true');
    }

    // Selected state
    if (this._selectedValues.includes(option.value)) {
      optionEl.classList.add('so-selected');
      optionEl.setAttribute('aria-selected', 'true');
    } else {
      optionEl.setAttribute('aria-selected', 'false');
    }

    // Custom template
    if (this.options.optionTemplate) {
      optionEl.innerHTML = this.options.optionTemplate(option);
    } else {
      // Default template
      const text = option.text || option.value;
      const highlightedText = this.options.highlightMatches
        ? this._highlightMatch(text, this._input.value)
        : text;

      optionEl.innerHTML = `
        <span class="so-autocomplete-option-text">${highlightedText}</span>
        <span class="so-autocomplete-option-check">
          <span class="material-icons">check</span>
        </span>
      `;
    }

    return optionEl;
  }

  /**
   * Highlight matching text
   * @private
   */
  _highlightMatch(text, query) {
    if (!query) return text;

    const searchText = this.options.caseSensitive ? text : text.toLowerCase();
    const searchQuery = this.options.caseSensitive ? query : query.toLowerCase();
    const index = searchText.indexOf(searchQuery);

    if (index === -1) return text;

    const before = text.substring(0, index);
    const match = text.substring(index, index + query.length);
    const after = text.substring(index + query.length);

    return `${before}<mark>${match}</mark>${after}`;
  }

  // ============================================
  // PRIVATE METHODS - Selection
  // ============================================

  /**
   * Select an option
   * @private
   */
  _selectOption(option, index = -1) {
    if (option.disabled) return;

    // Check if already selected (for deselection in multiple mode)
    const isSelected = this._selectedValues.includes(option.value);

    if (this.options.multiple) {
      if (isSelected) {
        // Deselect
        this.removeTokenByValue(option.value);
        this.emit(SOAutocomplete.EVENTS.DESELECT, {
          value: option.value,
          text: option.text,
          item: option,
          index
        });
      } else {
        // Check max selections
        if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
          return;
        }

        // Select (add token)
        this._createToken(option.value, option.text);
        this.emit(SOAutocomplete.EVENTS.SELECT, {
          value: option.value,
          text: option.text,
          item: option,
          index
        });
      }

      // Clear input after selection
      this._input.value = '';
      this._input.focus();

      // Re-render to update selected state
      this._renderOptions();
    } else {
      // Single selection
      this._selectedValues = [option.value];
      this._selectedTexts = [option.text || option.value];
      this._input.value = option.text || option.value;

      this.emit(SOAutocomplete.EVENTS.SELECT, {
        value: option.value,
        text: option.text,
        item: option,
        index
      });

      if (this.options.closeOnSelect) {
        this.close();
      }
    }

    this._updateClearButton();
    this._emitChange();
  }

  /**
   * Select focused option
   * @private
   */
  _selectFocusedOption() {
    if (this._focusedIndex >= 0 && this._focusedIndex < this._filteredOptions.length) {
      const option = this._filteredOptions[this._focusedIndex];
      this._selectOption(option, this._focusedIndex);
    }
  }

  /**
   * Create a token (free solo or from option)
   * @private
   */
  _createToken(value, text = null) {
    if (!this.options.multiple) return;

    const tokenText = text || value;
    const tokenValue = value;

    // Validate token
    if (this.options.tokenValidation && !this.options.tokenValidation(tokenValue)) {
      return;
    }

    // Check for duplicates
    if (!this.options.allowDuplicates && this._selectedValues.includes(tokenValue)) {
      return;
    }

    // Check max selections
    if (this.options.maxSelections && this._tokens.length >= this.options.maxSelections) {
      return;
    }

    // Add token
    const token = { value: tokenValue, text: tokenText };
    this._tokens.push(token);
    this._selectedValues.push(tokenValue);
    this._selectedTexts.push(tokenText);

    // Render tokens
    this._renderTokens();
    this._updatePlaceholder();
    this._updateClearButton();

    // Emit events
    this.emit(SOAutocomplete.EVENTS.TOKEN_ADD, { token, tokens: this._tokens });

    // Emit create event if free solo
    if (this.options.freeSolo && !this._allOptions.find(opt => opt.value === tokenValue)) {
      this.emit(SOAutocomplete.EVENTS.CREATE, { value: tokenValue, text: tokenText });
    }
  }

  /**
   * Render tokens
   * @private
   */
  _renderTokens() {
    if (!this.options.multiple || !this._tokensContainer) return;

    // Remove existing tokens and text display (keep input)
    const tokenEls = this._tokensContainer.querySelectorAll('.so-autocomplete-token, .so-autocomplete-selected-text');
    tokenEls.forEach(el => el.remove());

    // Display mode: chips or chips-overflow
    if (this.options.displayMode === 'chips' || this.options.displayMode === 'chips-overflow') {
      const tokensToShow = this.options.displayMode === 'chips-overflow'
        ? this._tokens.slice(0, this.options.maxVisibleTokens)
        : this._tokens;

      tokensToShow.forEach((token, index) => {
        const tokenEl = this._createTokenElement(token, index);
        this._tokensContainer.insertBefore(tokenEl, this._input);
      });

      // Show overflow indicator
      if (this.options.displayMode === 'chips-overflow' && this._tokens.length > this.options.maxVisibleTokens) {
        const overflowCount = this._tokens.length - this.options.maxVisibleTokens;
        const overflowEl = document.createElement('span');
        overflowEl.className = 'so-autocomplete-token so-autocomplete-token-overflow';
        overflowEl.textContent = this.options.overflowText.replace('{count}', overflowCount);
        this._tokensContainer.insertBefore(overflowEl, this._input);
      }
    } else if (this.options.displayMode === 'text') {
      // Text display mode
      const textEl = document.createElement('span');
      textEl.className = 'so-autocomplete-selected-text';
      textEl.textContent = this.options.multipleSelectedText.replace('{count}', this._tokens.length);
      this._tokensContainer.insertBefore(textEl, this._input);
    }
  }

  /**
   * Get the current color variant from element classes
   * @private
   * @returns {string} The variant name (primary, success, danger, etc.)
   */
  _getColorVariant() {
    const variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark', 'light'];
    for (const variant of variants) {
      if (this.element.classList.contains(`so-autocomplete-${variant}`)) {
        return variant;
      }
    }
    return 'primary'; // Default
  }

  /**
   * Create token element
   * @private
   */
  _createTokenElement(token, index) {
    const tokenEl = document.createElement('span');
    const variant = this._getColorVariant();
    tokenEl.className = `so-autocomplete-token so-chip so-chip-sm so-chip-soft-${variant}`;
    tokenEl.dataset.index = index;
    tokenEl.dataset.value = token.value;

    // Size variant (override default sm if specified)
    if (this.options.tokenSize) {
      tokenEl.classList.remove('so-chip-sm');
      tokenEl.classList.add(`so-chip-${this.options.tokenSize}`);
    }

    // Custom template
    if (this.options.tokenTemplate) {
      tokenEl.innerHTML = this.options.tokenTemplate(token);
    } else {
      // Default template
      tokenEl.innerHTML = `
        <span class="so-autocomplete-token-text">${token.text}</span>
        <button type="button" class="so-autocomplete-token-remove so-chip-close" data-index="${index}">
          <span class="material-icons">close</span>
        </button>
      `;

      // Bind remove button
      const removeBtn = tokenEl.querySelector('.so-autocomplete-token-remove');
      this.on('click', (e) => {
        e.stopPropagation();
        this.removeToken(index);
      }, removeBtn);
    }

    return tokenEl;
  }

  /**
   * Update placeholder based on tokens
   * @private
   */
  _updatePlaceholder() {
    if (!this.options.multiple) return;

    if (this._tokens.length > 0) {
      this._input.placeholder = '';
    } else {
      this._input.placeholder = this.options.placeholder;
    }
  }

  /**
   * Update clear button visibility
   * @private
   */
  _updateClearButton() {
    if (!this.options.clearable) {
      this._clearBtn.style.display = 'none';
      return;
    }

    const hasValue = this.options.multiple
      ? this._tokens.length > 0
      : this._input.value.length > 0 || this._selectedValues.length > 0;

    this._clearBtn.style.display = hasValue ? 'flex' : 'none';
  }

  /**
   * Emit change event
   * @private
   */
  _emitChange() {
    this.emit(SOAutocomplete.EVENTS.CHANGE, {
      value: this.getValue(),
      values: this.getValues(),
      text: this.getText(),
      texts: this.getTexts(),
    });
  }

  // ============================================
  // PRIVATE METHODS - Keyboard Navigation
  // ============================================

  /**
   * Focus next option
   * @private
   */
  _focusNextOption() {
    if (this._filteredOptions.length === 0) return;

    this._focusedIndex++;
    if (this._focusedIndex >= this._filteredOptions.length) {
      this._focusedIndex = 0;
    }

    this._updateFocusedOption();
  }

  /**
   * Focus previous option
   * @private
   */
  _focusPreviousOption() {
    if (this._filteredOptions.length === 0) return;

    this._focusedIndex--;
    if (this._focusedIndex < 0) {
      this._focusedIndex = this._filteredOptions.length - 1;
    }

    this._updateFocusedOption();
  }

  /**
   * Focus option at index
   * @private
   */
  _focusOptionAt(index) {
    if (index < 0 || index >= this._filteredOptions.length) return;

    this._focusedIndex = index;
    this._updateFocusedOption();
  }

  /**
   * Update focused option visual state
   * @private
   */
  _updateFocusedOption() {
    // Remove previous focus
    const prevFocused = this._optionsContainer.querySelector('.so-autocomplete-option-focused');
    if (prevFocused) {
      prevFocused.classList.remove('so-autocomplete-option-focused');
    }

    // Add new focus
    if (this._focusedIndex >= 0) {
      const optionEl = this._optionsContainer.querySelector(`[data-index="${this._focusedIndex}"]`);
      if (optionEl) {
        optionEl.classList.add('so-autocomplete-option-focused');
        optionEl.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      }
    }
  }

  // ============================================
  // DESTROY
  // ============================================

  /**
   * Destroy the component
   */
  destroy() {
    // Close dropdown
    this.close();

    // Clear timers
    if (this._debounceTimer) {
      clearTimeout(this._debounceTimer);
    }

    // Abort any pending requests
    if (this._abortController) {
      this._abortController.abort();
    }

    // Call parent destroy
    super.destroy();
  }
}

// ============================================
// STATIC METHODS
// ============================================

/**
 * Initialize all autocomplete components
 * @param {string} selector - CSS selector
 * @param {Object} options - Options
 * @returns {Array<SOAutocomplete>} Instances
 */
SOAutocomplete.initAll = function (selector = '[data-so-autocomplete]', options = {}) {
  const elements = document.querySelectorAll(selector);
  return Array.from(elements).map(el => SOAutocomplete.getInstance(el, options));
};

// ============================================
// REGISTRATION
// ============================================

// Register component with SixOrbit
SOAutocomplete.register();

// Export
export default SOAutocomplete;
export { SOAutocomplete };
