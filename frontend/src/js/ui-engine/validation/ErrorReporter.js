// ============================================
// SIXORBIT UI ENGINE - ERROR REPORTER
// Centralized error display UI
// ============================================

import SOComponent from "../../core/so-component.js";
import SixOrbit from "../../core/so-config.js";

/**
 * ErrorReporter - Centralized error display component
 * Supports multiple positions and styles
 */
class ErrorReporter extends SOComponent {
  static NAME = "error-reporter";

  /**
   * Supported positions (4 corners only)
   */
  static POSITIONS = {
    TOP_RIGHT: "top-right",
    TOP_LEFT: "top-left",
    BOTTOM_RIGHT: "bottom-right",
    BOTTOM_LEFT: "bottom-left",
  };

  static DEFAULTS = {
    position: "top-right",
    size: "normal", // 'normal' | 'sm' | 'xs'
    autoHide: false,
    autoHideDelay: 5000,
    animation: "fade",
    maxErrors: 10,
    groupByField: true,
    showFieldLinks: true,
    dismissible: true,
    theme: "default",
  };

  /**
   * Singleton instance
   * @type {ErrorReporter|null}
   */
  static _instance = null;

  /**
   * Global click handler attached once - persists across instance recreations
   * @type {boolean}
   */
  static _globalHandlerAttached = false;

  /**
   * Get singleton instance
   * @param {Object} options
   * @returns {ErrorReporter}
   */
  static getInstance(options = {}) {
    if (!this._instance) {
      this._instance = new ErrorReporter(null, options);
    }
    return this._instance;
  }

  /**
   * Attach global click handler (called once)
   * @private
   */
  static _attachGlobalHandler() {
    if (this._globalHandlerAttached) {
      return;
    }

    document.body.addEventListener(
      "click",
      (e) => {
        // Only process if we have an active instance
        if (!this._instance || !this._instance.element) {
          return;
        }

        // Check if click is within error reporter
        const contained = this._instance.element.contains(e.target);

        if (!contained) {
          return;
        }

        // Check if clicking inside a dropdown (ignore those clicks)
        const dropdownClick = e.target.closest(SixOrbit.sel("dropdown"));
        if (dropdownClick) {
          return;
        }

        // Check if clicking mobile button
        const mobileBtn = e.target.closest(SixOrbit.sel("error-reporter-mobile-btn"));
        if (mobileBtn && this._instance._isMobile) {
          this._instance._openModal();
          return;
        }

        // Check if clicking on collapse/expand toggle
        const toggleBtn = e.target.closest(
          SixOrbit.sel("error-reporter-toggle"),
        );
        if (toggleBtn) {
          this._instance.toggle();
          return;
        }

        // Check if clicking on error item
        const errorItem = e.target.closest(SixOrbit.sel("error-reporter-item"));
        if (errorItem && this._instance._opts.showFieldLinks) {
          const field = errorItem.dataset.field;

          if (field) {
            this._instance._focusField(field);
            // Close modal if open
            if (this._instance._modal) {
              this._instance._modal.hide();
            }
          }
          return;
        }

        // Check if clicking on dismiss button
        const dismissBtn = e.target.closest(SixOrbit.sel("error-item-close"));
        if (dismissBtn && this._instance._opts.dismissible) {
          const item = dismissBtn.closest(SixOrbit.sel("error-reporter-item"));
          if (item) {
            const field = item.dataset.field;
            if (field) {
              this._instance.clearField(field);
            }
          }
          return;
        }
      },
      true,
    ); // Capture phase

    this._globalHandlerAttached = true;
  }

  /**
   * Create a new ErrorReporter
   * @param {Element|null} element
   * @param {Object} options
   */
  constructor(element, options = {}) {
    // Create container if not provided
    if (!element) {
      element = document.createElement("div");
      element.className = SixOrbit.cls("error-reporter");
      document.body.appendChild(element);
    }

    super(element, options);

    this._errors = {};
    this._autoHideTimer = null;
    this._isCollapsed = false;
    this._lastRenderedErrors = null; // Track last rendered state to avoid unnecessary re-renders
    this._isMobile = false;
    this._modal = null;
    this._positionDropdown = null;
    this._activeField = null; // Track currently focused field
    this._checkResponsive();
    this._attachFocusTracking();
  }

  /**
   * Initialize the component
   * @private
   */
  _init() {
    // SOComponent stores options as this.options, but ErrorReporter uses this._opts
    // Filter undefined from options BEFORE merging to prevent overwriting DEFAULTS
    const filteredOptions = this._filterUndefined(this.options || {});
    this._opts = { ...ErrorReporter.DEFAULTS, ...filteredOptions };

    this._updatePosition();
    this._updateSize();

    // Attach global handler (only happens once)
    ErrorReporter._attachGlobalHandler();
  }

  /**
   * Filter undefined values from an object
   * @private
   */
  _filterUndefined(obj) {
    const filtered = {};
    if (obj) {
      Object.keys(obj).forEach(key => {
        if (obj[key] !== undefined) {
          filtered[key] = obj[key];
        }
      });
    }
    return filtered;
  }

  /**
   * Update size class
   * @private
   */
  _updateSize() {
    if (!this._opts) {
      this._opts = { ...ErrorReporter.DEFAULTS };
    }
    const size = this._opts.size;

    // Remove existing size classes
    this.element.classList.remove(
      SixOrbit.cls("error-reporter-sm"),
      SixOrbit.cls("error-reporter-xs")
    );

    // Add size class if not normal
    if (size === "sm") {
      this.element.classList.add(SixOrbit.cls("error-reporter-sm"));
    } else if (size === "xs") {
      this.element.classList.add(SixOrbit.cls("error-reporter-xs"));
    }
  }

  /**
   * Check if mobile/tablet view
   * @private
   */
  _checkResponsive() {
    this._isMobile = window.matchMedia('(max-width: 767px)').matches;

    // Listen for resize
    window.matchMedia('(max-width: 767px)').addEventListener('change', (e) => {
      this._isMobile = e.matches;
      if (this.hasErrors()) {
        this._render();
      }
    });
  }

  /**
   * Attach focus tracking to form fields
   * @private
   */
  _attachFocusTracking() {
    // Listen for focus on all form fields
    document.addEventListener('focusin', (e) => {
      const field = e.target;

      // Check if it's a form field
      if (field.name && ['INPUT', 'SELECT', 'TEXTAREA'].includes(field.tagName)) {
        this._activeField = field.name;
        this._updateActiveError();
      }
    });

    // Listen for blur to clear active state
    document.addEventListener('focusout', (e) => {
      const field = e.target;

      if (field.name && ['INPUT', 'SELECT', 'TEXTAREA'].includes(field.tagName)) {
        this._activeField = null;
        this._updateActiveError();
      }
    });
  }

  /**
   * Update active error highlighting
   * @private
   */
  _updateActiveError() {
    if (!this.element) return;

    // Find all error items
    const errorItems = this.element.querySelectorAll(SixOrbit.sel('error-reporter-item'));

    errorItems.forEach(item => {
      const fieldName = item.dataset.field;

      if (fieldName === this._activeField) {
        item.classList.add(SixOrbit.cls('active'));
      } else {
        item.classList.remove(SixOrbit.cls('active'));
      }
    });

    // Also update in modal if open
    if (this._modal && this._modal.element) {
      const modalItems = this._modal.element.querySelectorAll(SixOrbit.sel('error-reporter-item'));

      modalItems.forEach(item => {
        const fieldName = item.dataset.field;

        if (fieldName === this._activeField) {
          item.classList.add(SixOrbit.cls('active'));
        } else {
          item.classList.remove(SixOrbit.cls('active'));
        }
      });
    }
  }

  /**
   * Update container position
   * @private
   */
  _updatePosition() {
    if (!this._opts) {
      this._opts = { ...ErrorReporter.DEFAULTS };
    }
    const position = this._opts.position;

    // Remove existing position classes
    Object.values(ErrorReporter.POSITIONS).forEach((pos) => {
      this.element.classList.remove(SixOrbit.cls("error-reporter", pos));
    });

    // Add new position class
    this.element.classList.add(SixOrbit.cls("error-reporter", position));
  }

  // ==================
  // Configuration
  // ==================

  /**
   * Configure the reporter
   * @param {Object} options
   * @param {boolean} force - Force configuration even if errors are displayed
   * @returns {this}
   */
  configure(options, force = false) {
    // If errors are already displayed and not forcing, ignore position changes
    // This prevents forms from changing position while errors are visible
    const hasErrors = Object.keys(this._errors).length > 0;

    if (hasErrors && !force && options && options.position) {
      // Skip position change, but allow other options
      const { position, ...otherOptions } = options;
      options = otherOptions;
    }

    // Store old position to check if it changed
    const oldPosition = this._opts ? this._opts.position : null;

    // Filter undefined from both _opts and new options BEFORE merging
    const filteredOpts = this._filterUndefined(this._opts || {});
    const filteredOptions = this._filterUndefined(options || {});
    this._opts = { ...ErrorReporter.DEFAULTS, ...filteredOpts, ...filteredOptions };

    if (options && options.position) {
      this._updatePosition();

      // Check if position changed at all
      if (oldPosition !== this._opts.position) {
        // Position changed - invalidate cache to force re-render with new position
        this._lastRenderedErrors = null;

        // Check if position side changed (left ↔ right) which requires DOM structure change
        const oldIsLeft = oldPosition && oldPosition.includes('left');
        const newIsLeft = this._opts.position.includes('left');

        if (oldIsLeft !== newIsLeft) {
          // Position side changed - DOM structure will be rebuilt in next render
          // (cache already invalidated above)
        }
      }
    }

    if (options && options.size) {
      this._updateSize();
    }

    return this;
  }

  /**
   * Set position (with force - used by settings dropdown)
   * @param {string} position
   * @returns {this}
   */
  setPosition(position) {
    // Use configure with force=true to allow position change even with errors displayed
    return this.configure({ position }, true);
  }

  // ==================
  // Collapse/Expand
  // ==================

  /**
   * Toggle collapse/expand state
   * @returns {this}
   */
  toggle() {
    if (this._isCollapsed) {
      this.expand();
    } else {
      this.collapse();
    }
    return this;
  }

  /**
   * Collapse the error reporter
   * @returns {this}
   */
  collapse() {
    this._isCollapsed = true;
    this.element.classList.add(SixOrbit.cls("collapsed"));
    this.emit("collapsed");
    return this;
  }

  /**
   * Expand the error reporter
   * @returns {this}
   */
  expand() {
    this._isCollapsed = false;
    this.element.classList.remove(SixOrbit.cls("collapsed"));
    this.emit("expanded");
    return this;
  }

  /**
   * Update toggle button icon based on collapsed state
   * Icon rotation is handled by CSS, no need to change icon text
   * @private
   */
  _updateToggleIcon() {
    // Icon rotation is now handled entirely by CSS via the collapsed class
    // No need to update icon text anymore
  }

  // ==================
  // Error Management
  // ==================

  /**
   * Show all errors at once
   * @param {Object} errors - Field => messages map
   * @returns {this}
   */
  showAll(errors) {
    this._errors = { ...errors };
    this._render();
    this._startAutoHide();
    this._focusFirstErrorField();
    return this;
  }

  /**
   * Focus the first field with an error
   * @private
   */
  _focusFirstErrorField() {
    // Get the first field name from errors
    const firstFieldName = Object.keys(this._errors)[0];
    if (!firstFieldName) return;

    // Try to find and focus the field in the document
    // Look for input, textarea, or select with matching name
    const field = document.querySelector(
      `input[name="${firstFieldName}"], ` +
      `textarea[name="${firstFieldName}"], ` +
      `select[name="${firstFieldName}"]`
    );

    if (field && typeof field.focus === 'function') {
      // Small delay to ensure DOM is updated and field is visible
      setTimeout(() => {
        field.focus();
        // Scroll field into view if needed
        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }, 100);
    }
  }

  /**
   * Add errors (merge with existing)
   * @param {Object} errors
   * @returns {this}
   */
  addErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
      this._errors[field] = Array.isArray(messages) ? messages : [messages];
    });
    this._render();
    this._startAutoHide();
    return this;
  }

  /**
   * Add error for single field
   * @param {string} field
   * @param {string|string[]} messages
   * @returns {this}
   */
  addError(field, messages) {
    this._errors[field] = Array.isArray(messages) ? messages : [messages];
    this._render();
    this._startAutoHide();
    return this;
  }

  /**
   * Clear errors for a field
   * @param {string} field
   * @returns {this}
   */
  clearField(field) {
    delete this._errors[field];
    this._render();
    return this;
  }

  /**
   * Clear all errors
   * @returns {this}
   */
  clearAll() {
    this._errors = {};
    this._render();
    this._stopAutoHide();
    return this;
  }

  /**
   * Get all errors
   * @returns {Object}
   */
  getErrors() {
    return { ...this._errors };
  }

  /**
   * Check if has errors
   * @returns {boolean}
   */
  hasErrors() {
    return Object.keys(this._errors).length > 0;
  }

  /**
   * Get error count
   * @returns {number}
   */
  getErrorCount() {
    let count = 0;
    Object.values(this._errors).forEach((messages) => {
      count += Array.isArray(messages) ? messages.length : 1;
    });
    return count;
  }

  // ==================
  // Rendering
  // ==================

  /**
   * Render the error display
   * @private
   */
  _render() {
    // Check if errors have actually changed since last render
    const currentErrorsStr = JSON.stringify(this._errors);
    if (this._lastRenderedErrors === currentErrorsStr) {
      return this;
    }
    this._lastRenderedErrors = currentErrorsStr;

    const errorCount = Object.keys(this._errors).length;

    if (errorCount === 0) {
      this._clearDisplay();
      this.emit("cleared");
      return this;
    }

    const totalMessages = this.getErrorCount();

    if (this._isMobile) {
      this._renderMobile(totalMessages);
    } else {
      this._renderDesktop(totalMessages);
    }

    this.element.classList.add(SixOrbit.cls("show"));
    this.emit("shown", { errors: this._errors, count: totalMessages });
    return this;
  }

  /**
   * Clear display when no errors
   * @private
   */
  _clearDisplay() {
    this.element.innerHTML = "";
    this.element.classList.remove(SixOrbit.cls("show"));
    this.element.classList.remove(SixOrbit.cls("collapsed"));
    this.element.classList.remove(SixOrbit.cls("error-reporter-mobile"));
  }

  /**
   * Get button size class based on error reporter size
   * @returns {string}
   * @private
   */
  _getButtonSizeClass() {
    const size = this._opts.size;
    if (size === 'xs') return SixOrbit.cls('btn-xs');
    if (size === 'sm') return SixOrbit.cls('btn-xs');
    return SixOrbit.cls('btn-sm'); // normal size
  }

  /**
   * Get dropdown size class based on error reporter size
   * @returns {string}
   * @private
   */
  _getDropdownSizeClass() {
    const size = this._opts.size;
    if (size === 'xs' || size === 'sm') return SixOrbit.cls('dropdown-sm');
    return ''; // normal size - no extra class needed
  }

  /**
   * Render desktop view
   * @param {number} totalMessages
   * @private
   */
  _renderDesktop(totalMessages) {
    // Remove mobile class if present
    this.element.classList.remove(SixOrbit.cls("error-reporter-mobile"));

    // Ensure _opts is initialized
    if (!this._opts) {
      this._opts = { ...ErrorReporter.DEFAULTS };
    }

    const isLeftPosition = this._opts.position.includes('left');
    const btnSizeClass = this._getButtonSizeClass();

    // Always render full structure, CSS handles collapsed state
    if (isLeftPosition) {
      // Left positions: [Collapse] [Position] [Title] [Icon] - fully mirrored DOM
      this.element.innerHTML = `
        <div class="${SixOrbit.cls("error-reporter-content")}">
          <div class="${SixOrbit.cls("error-reporter-header")}">
            <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-icon")} ${SixOrbit.cls("btn-circle")} ${SixOrbit.cls("btn-danger")} ${btnSizeClass} ${SixOrbit.cls("error-reporter-toggle")}" aria-label="Toggle">
              <span class="material-icons">expand_less</span>
              <span class="${SixOrbit.cls("error-reporter-count")}">${totalMessages}</span>
            </button>
            ${this._createPositionDropdown()}
            <span class="${SixOrbit.cls("error-reporter-title")}">
              ${totalMessages} ${totalMessages === 1 ? "error" : "errors"} found
            </span>
            <span class="material-icons ${SixOrbit.cls("text-danger")} ${SixOrbit.cls("error-reporter-icon")}">error</span>
          </div>
          <ul class="${SixOrbit.cls("error-reporter-list")}">
            ${this._renderErrors()}
          </ul>
        </div>
      `;
    } else {
      // Right positions: [Icon] [Title] [Position] [Collapse]
      this.element.innerHTML = `
        <div class="${SixOrbit.cls("error-reporter-content")}">
          <div class="${SixOrbit.cls("error-reporter-header")}">
            <span class="material-icons ${SixOrbit.cls("text-danger")} ${SixOrbit.cls("error-reporter-icon")}">error</span>
            <span class="${SixOrbit.cls("error-reporter-title")}">
              ${totalMessages} ${totalMessages === 1 ? "error" : "errors"} found
            </span>
            ${this._createPositionDropdown()}
            <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-icon")} ${SixOrbit.cls("btn-circle")} ${SixOrbit.cls("btn-danger")} ${btnSizeClass} ${SixOrbit.cls("error-reporter-toggle")}" aria-label="Toggle">
              <span class="material-icons">expand_less</span>
              <span class="${SixOrbit.cls("error-reporter-count")}">${totalMessages}</span>
            </button>
          </div>
          <ul class="${SixOrbit.cls("error-reporter-list")}">
            ${this._renderErrors()}
          </ul>
        </div>
      `;
    }

    // Apply collapsed class if needed
    if (this._isCollapsed) {
      this.element.classList.add(SixOrbit.cls("collapsed"));
    } else {
      this.element.classList.remove(SixOrbit.cls("collapsed"));
    }

    // Initialize position dropdown
    this._initPositionDropdown();
  }

  /**
   * Render mobile badge view
   * @param {number} totalMessages
   * @private
   */
  _renderMobile(totalMessages) {
    this.element.innerHTML = `
      <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-icon")} ${SixOrbit.cls("btn-circle")} ${SixOrbit.cls("btn-danger")} ${SixOrbit.cls("error-reporter-mobile-btn")}" aria-label="Show errors">
        <span class="material-icons">error</span>
        <span class="${SixOrbit.cls("error-reporter-count")}">${totalMessages}</span>
      </button>
    `;
    this.element.classList.add(SixOrbit.cls("error-reporter-mobile"));
    this.element.classList.remove(SixOrbit.cls("collapsed"));
  }

  /**
   * Render error list items
   * @returns {string}
   * @private
   */
  _renderErrors() {
    const maxErrors = this._opts.maxErrors;
    let renderedFieldCount = 0;
    let html = "";

    for (const [field, messages] of Object.entries(this._errors)) {
      // Check if we've exceeded max errors (count by fields, not individual messages)
      if (renderedFieldCount >= maxErrors) {
        const remainingFields = Object.keys(this._errors).length - maxErrors;
        html += `
          <li class="${SixOrbit.cls("error-reporter-item")} ${SixOrbit.cls("error-reporter-more")}">
            <span class="${SixOrbit.cls("text-muted")}">... and ${remainingFields} more field(s) with errors</span>
          </li>
        `;
        return html;
      }

      const fieldMessages = Array.isArray(messages) ? messages : [messages];

      // Combine all messages for this field into a single list item
      let messageContent = "";
      if (fieldMessages.length === 1) {
        // Single message - just show it
        messageContent = this._escapeHtml(fieldMessages[0]);
      } else {
        // Multiple messages - show as bullet list
        messageContent = '<ul class="' + SixOrbit.cls("error-message-list") + '">';
        fieldMessages.forEach(msg => {
          messageContent += '<li>' + this._escapeHtml(msg) + '</li>';
        });
        messageContent += '</ul>';
      }

      html += `
        <li class="${SixOrbit.cls("error-reporter-item")}" data-field="${this._escapeHtml(field)}">
          ${
            this._opts.groupByField
              ? `<span class="${SixOrbit.cls("error-field")}">${this._formatFieldName(field)}</span>`
              : ""
          }
          <span class="${SixOrbit.cls("error-message")}">${messageContent}</span>
        </li>
      `;

      renderedFieldCount++;
    }

    return html;
  }

  /**
   * Format field name for display
   * @param {string} field
   * @returns {string}
   * @private
   */
  _formatFieldName(field) {
    return field
      .replace(/([a-z])([A-Z])/g, "$1 $2")
      .replace(/[_-]/g, " ")
      .replace(/\b\w/g, (l) => l.toUpperCase());
  }

  /**
   * Escape HTML
   * @param {string} str
   * @returns {string}
   * @private
   */
  _escapeHtml(str) {
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
  }

  /**
   * Create position dropdown HTML
   * @returns {string}
   * @private
   */
  _createPositionDropdown() {
    const currentPosition = this._opts.position;
    const currentSize = this._opts.size;
    const btnSizeClass = this._getButtonSizeClass();
    const dropdownSizeClass = this._getDropdownSizeClass();

    // Determine dropdown positioning classes based on error reporter position
    const dropdownClasses = [];

    // Add size class if needed
    if (dropdownSizeClass) {
      dropdownClasses.push(dropdownSizeClass);
    }

    // Vertical positioning (dropup vs dropdown)
    if (currentPosition.startsWith('bottom-')) {
      dropdownClasses.push(SixOrbit.cls('dropup'));
    }

    // Horizontal alignment
    if (currentPosition.includes('left')) {
      dropdownClasses.push(SixOrbit.cls('dropdown-left'));
    } else if (currentPosition.includes('right')) {
      dropdownClasses.push(SixOrbit.cls('dropdown-right'));
    }

    return `
      <div class="${SixOrbit.cls("dropdown")} ${SixOrbit.cls("error-reporter-position-dropdown")} ${dropdownClasses.join(' ')}">
        <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-icon")} ${SixOrbit.cls("btn-circle")} ${SixOrbit.cls("btn-danger")} ${btnSizeClass} ${SixOrbit.cls("dropdown-trigger")}" aria-label="Settings">
          <span class="material-icons">settings</span>
        </button>
        <div class="${SixOrbit.cls("dropdown-menu")}">
          <div class="${SixOrbit.cls("dropdown-item")} ${SixOrbit.cls("error-reporter-size-selector")}">
            <div class="${SixOrbit.cls("btn-group")} ${SixOrbit.cls("btn-group-sm")}">
              <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-sm")} ${currentSize === "xs" ? SixOrbit.cls("btn-primary") : SixOrbit.cls("btn-outline")}" data-size="xs" title="Extra Small">XS</button>
              <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-sm")} ${currentSize === "sm" ? SixOrbit.cls("btn-primary") : SixOrbit.cls("btn-outline")}" data-size="sm" title="Small">SM</button>
              <button type="button" class="${SixOrbit.cls("btn")} ${SixOrbit.cls("btn-sm")} ${currentSize === "normal" ? SixOrbit.cls("btn-primary") : SixOrbit.cls("btn-outline")}" data-size="normal" title="Medium">MD</button>
            </div>
          </div>
          <div class="${SixOrbit.cls("dropdown-divider")}"></div>
          <div class="${SixOrbit.cls("dropdown-item")} ${currentPosition === "top-right" ? SixOrbit.cls("selected") : ""}" data-position="top-right">
            <span>Top Right</span>
            ${currentPosition === "top-right" ? '<span class="material-icons ' + SixOrbit.cls("dropdown-check") + '">check</span>' : ""}
          </div>
          <div class="${SixOrbit.cls("dropdown-item")} ${currentPosition === "top-left" ? SixOrbit.cls("selected") : ""}" data-position="top-left">
            <span>Top Left</span>
            ${currentPosition === "top-left" ? '<span class="material-icons ' + SixOrbit.cls("dropdown-check") + '">check</span>' : ""}
          </div>
          <div class="${SixOrbit.cls("dropdown-divider")}"></div>
          <div class="${SixOrbit.cls("dropdown-item")} ${currentPosition === "bottom-right" ? SixOrbit.cls("selected") : ""}" data-position="bottom-right">
            <span>Bottom Right</span>
            ${currentPosition === "bottom-right" ? '<span class="material-icons ' + SixOrbit.cls("dropdown-check") + '">check</span>' : ""}
          </div>
          <div class="${SixOrbit.cls("dropdown-item")} ${currentPosition === "bottom-left" ? SixOrbit.cls("selected") : ""}" data-position="bottom-left">
            <span>Bottom Left</span>
            ${currentPosition === "bottom-left" ? '<span class="material-icons ' + SixOrbit.cls("dropdown-check") + '">check</span>' : ""}
          </div>
        </div>
      </div>
    `;
  }

  /**
   * Initialize position dropdown
   * @private
   */
  _initPositionDropdown() {
    const dropdownEl = this.element.querySelector(
      SixOrbit.sel("error-reporter-position-dropdown"),
    );
    if (!dropdownEl || !window.SODropdown) return;

    this._positionDropdown = window.SODropdown.getInstance(dropdownEl);

    // Listen for position item clicks
    dropdownEl.querySelectorAll(SixOrbit.sel("dropdown-item")).forEach((item) => {
      item.addEventListener("click", (e) => {
        // Handle position change
        const position = item.dataset.position;
        if (position) {
          e.stopPropagation(); // Prevent event bubbling
          this.setPosition(position);
          // Re-render to update dropdown selection
          this._lastRenderedErrors = null;
          this._render();
        }
      });
    });

    // Listen for size button clicks
    dropdownEl.querySelectorAll('button[data-size]').forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.stopPropagation(); // Prevent event bubbling and dropdown close
        const size = btn.dataset.size;
        if (size) {
          this._opts.size = size;
          this._updateSize();
          // Re-render to update dropdown selection
          this._lastRenderedErrors = null;
          this._render();
        }
      });
    });
  }

  /**
   * Open modal (mobile view)
   * @private
   */
  _openModal() {
    if (!window.SOModal) return;

    const totalMessages = this.getErrorCount();
    const self = this;

    const modal = window.SOModal.create({
      title: `
        <div class="${SixOrbit.cls("error-reporter-modal-title")}">
          <span class="${SixOrbit.cls("error-reporter-modal-title-text")}">Errors (${totalMessages})</span>
          ${this._createPositionDropdown()}
        </div>
      `,
      content: `
        <ul class="${SixOrbit.cls("error-reporter-list")}">
          ${this._renderErrors()}
        </ul>
      `,
      size: "default",
      closable: true,
      className: SixOrbit.cls("error-reporter-modal"),
    });

    // Initialize position dropdown in header
    modal.element.addEventListener(SixOrbit.evt("modal:shown"), () => {
      // Initialize position dropdown
      const dropdown = modal.element.querySelector(
        SixOrbit.sel("modal-header") + " " + SixOrbit.sel("error-reporter-position-dropdown"),
      );
      if (dropdown && window.SODropdown) {
        // Initialize dropdown component
        window.SODropdown.getInstance(dropdown);

        // Listen for position changes
        dropdown
          .querySelectorAll(SixOrbit.sel("dropdown-item"))
          .forEach((item) => {
            item.addEventListener("click", () => {
              const position = item.dataset.position;
              if (position) {
                self.setPosition(position);
                // Re-render main reporter to update position
                self._lastRenderedErrors = null;
                self._render();
              }
            });
          });

        // Listen for size button clicks
        dropdown.querySelectorAll('button[data-size]').forEach((btn) => {
          btn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent event bubbling and dropdown close
            const size = btn.dataset.size;
            if (size) {
              self._opts.size = size;
              self._updateSize();
              // Re-render main reporter to update size
              self._lastRenderedErrors = null;
              self._render();
            }
          });
        });
      }

      // Handle error item clicks
      modal.element.querySelectorAll(SixOrbit.sel("error-reporter-item")).forEach((item) => {
        item.addEventListener("click", () => {
          const field = item.dataset.field;
          if (field && self._opts.showFieldLinks) {
            self._focusField(field);
            modal.hide();
          }
        });
      });
    });

    this._modal = modal;
    modal.show();
  }


  // ==================
  // Auto-hide
  // ==================

  /**
   * Start auto-hide timer
   * @private
   */
  _startAutoHide() {
    if (!this._opts.autoHide) return;

    this._stopAutoHide();
    this._autoHideTimer = setTimeout(() => {
      this.clearAll();
    }, this._opts.autoHideDelay);
  }

  /**
   * Stop auto-hide timer
   * @private
   */
  _stopAutoHide() {
    if (this._autoHideTimer) {
      clearTimeout(this._autoHideTimer);
      this._autoHideTimer = null;
    }
  }

  // ==================
  // Field Focus
  // ==================

  /**
   * Focus a field by name
   * @param {string} fieldName
   * @private
   */
  _focusField(fieldName) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (field) {
      // Use setTimeout to defer focus, allowing any blur events to complete first
      // This prevents focus/blur race conditions when clicking repeatedly
      setTimeout(() => {
        field.focus();
        field.scrollIntoView({ behavior: "smooth", block: "center" });
      }, 0);
    }
  }

  // ==================
  // Lifecycle
  // ==================

  /**
   * Destroy the component
   */
  destroy() {
    this._stopAutoHide();

    // Note: Click handlers are managed globally via _attachGlobalHandler()
    // and persist across instance recreations, so we don't remove them here

    this.element.remove();
    ErrorReporter._instance = null;
    super.destroy();
  }
}

// Register with SixOrbit
ErrorReporter.register();

export default ErrorReporter;
export { ErrorReporter };
