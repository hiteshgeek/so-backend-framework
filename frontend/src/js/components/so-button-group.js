// ============================================
// SIXORBIT UI - BUTTON GROUP COMPONENT
// Toggle buttons with radio/checkbox behavior
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOButtonGroup - Toggle button group component
 * Supports radio (single selection) and checkbox (multi-selection) modes
 */
class SOButtonGroup extends SOComponent {
  static NAME = 'buttonGroup';

  static DEFAULTS = {
    type: 'checkbox',          // 'radio' or 'checkbox'
    enforceSelection: false,   // Prevent deselecting last item
    keyboard: true,            // Enable keyboard navigation
  };

  static EVENTS = {
    CHANGE: 'toggle:change',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  /**
   * Initialize the button group component
   * @private
   */
  _init() {
    // Get toggle type from data attribute or options
    this.options.type = this.element.dataset.toggleType || this.options.type;
    this.options.enforceSelection = this.element.dataset.enforceSelection === 'true' || this.options.enforceSelection;

    // Cache input elements
    this._inputs = this.$$('.so-btn-check');
    this._buttons = this._inputs.map(input => input.nextElementSibling);

    // Bind events
    this._bindEvents();

    // Set up ARIA attributes
    this._setupAria();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Change handler for inputs
    this._inputs.forEach(input => {
      this.on('change', this._handleChange, input);
    });

    // Click handler for enforced selection (radio)
    if (this.options.enforceSelection && this.options.type === 'radio') {
      this._inputs.forEach(input => {
        this.on('click', this._handleRadioClick, input);
      });
    }

    // Keyboard navigation
    if (this.options.keyboard) {
      this.on('keydown', this._handleKeydown);
    }
  }

  /**
   * Set up ARIA attributes
   * @private
   */
  _setupAria() {
    // Set role on container
    if (this.options.type === 'radio') {
      this.element.setAttribute('role', 'group');
    } else {
      this.element.setAttribute('role', 'group');
    }

    // Check for vertical orientation
    if (this.element.classList.contains('so-btn-group-vertical')) {
      this.element.setAttribute('aria-orientation', 'vertical');
    }

    // Set up each button
    this._inputs.forEach((input, index) => {
      const button = this._buttons[index];
      if (button) {
        // Button should not have role when it's a label
        if (button.tagName === 'LABEL') {
          // Label is sufficient for accessibility
        }
      }
    });
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  /**
   * Handle input change
   * @param {Event} e - Change event
   * @private
   */
  _handleChange(e) {
    const input = e.target;
    const value = input.value;
    const checked = input.checked;

    // Enforce selection for checkbox mode
    if (this.options.enforceSelection && this.options.type === 'checkbox' && !checked) {
      const checkedInputs = this._inputs.filter(i => i.checked);
      if (checkedInputs.length === 0) {
        // Prevent unchecking the last item
        input.checked = true;
        return;
      }
    }

    // Emit change event
    this.emit(SOButtonGroup.EVENTS.CHANGE, {
      value: this.getValue(),
      changed: value,
      checked: checked,
      input: input
    });
  }

  /**
   * Handle radio click for enforced selection
   * @param {Event} e - Click event
   * @private
   */
  _handleRadioClick(e) {
    const input = e.target;

    // Store the previous state before the click changes it
    if (input._wasChecked && this.options.enforceSelection) {
      // Radio was already checked, prevent native behavior from unchecking
      // (Note: native radio inputs don't uncheck on click, but this is for safety)
      e.preventDefault();
      input.checked = true;
    }

    // Mark current state for next click
    this._inputs.forEach(i => {
      i._wasChecked = i.checked;
    });
  }

  /**
   * Handle keyboard navigation
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    const isVertical = this.element.classList.contains('so-btn-group-vertical');
    const enabledInputs = this._inputs.filter(input => !input.disabled);

    if (enabledInputs.length === 0) return;

    // Find the currently focused button/label
    const focusedElement = document.activeElement;
    const currentInput = enabledInputs.find(input => {
      const label = input.nextElementSibling;
      return label === focusedElement || input === focusedElement;
    });

    if (!currentInput) return;

    const currentIndex = enabledInputs.indexOf(currentInput);
    let newIndex = currentIndex;

    switch (e.key) {
      case 'ArrowLeft':
        if (!isVertical) {
          e.preventDefault();
          newIndex = currentIndex - 1;
          if (newIndex < 0) newIndex = enabledInputs.length - 1;
        }
        break;

      case 'ArrowRight':
        if (!isVertical) {
          e.preventDefault();
          newIndex = currentIndex + 1;
          if (newIndex >= enabledInputs.length) newIndex = 0;
        }
        break;

      case 'ArrowUp':
        if (isVertical) {
          e.preventDefault();
          newIndex = currentIndex - 1;
          if (newIndex < 0) newIndex = enabledInputs.length - 1;
        }
        break;

      case 'ArrowDown':
        if (isVertical) {
          e.preventDefault();
          newIndex = currentIndex + 1;
          if (newIndex >= enabledInputs.length) newIndex = 0;
        }
        break;

      case 'Home':
        e.preventDefault();
        newIndex = 0;
        break;

      case 'End':
        e.preventDefault();
        newIndex = enabledInputs.length - 1;
        break;

      case ' ':
      case 'Enter':
        e.preventDefault();
        if (this.options.type === 'checkbox') {
          enabledInputs[currentIndex].checked = !enabledInputs[currentIndex].checked;
          enabledInputs[currentIndex].dispatchEvent(new Event('change', { bubbles: true }));
        } else {
          enabledInputs[currentIndex].checked = true;
          enabledInputs[currentIndex].dispatchEvent(new Event('change', { bubbles: true }));
        }
        return;

      default:
        return;
    }

    // Focus the new button's label
    if (newIndex !== currentIndex && newIndex >= 0) {
      const newLabel = enabledInputs[newIndex].nextElementSibling;
      if (newLabel) {
        newLabel.focus();
      }
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Get current selected value(s)
   * @returns {string|string[]|null} Selected value (radio) or array of values (checkbox)
   */
  getValue() {
    if (this.options.type === 'radio') {
      const checked = this._inputs.find(input => input.checked);
      return checked ? checked.value : null;
    } else {
      return this._inputs
        .filter(input => input.checked)
        .map(input => input.value);
    }
  }

  /**
   * Set selected value(s)
   * @param {string|string[]} value - Value or array of values to select
   * @returns {this} For chaining
   */
  setValue(value) {
    if (this.options.type === 'radio') {
      const valueStr = String(value);
      this._inputs.forEach(input => {
        input.checked = input.value === valueStr;
      });
    } else {
      const values = Array.isArray(value) ? value : [value];
      this._inputs.forEach(input => {
        input.checked = values.includes(input.value);
      });
    }

    // Emit change event
    this.emit(SOButtonGroup.EVENTS.CHANGE, {
      value: this.getValue(),
      changed: null,
      checked: null,
      programmatic: true
    });

    return this;
  }

  /**
   * Toggle a specific button by value
   * @param {string} value - Value of button to toggle
   * @returns {this} For chaining
   */
  toggle(value) {
    const input = this._inputs.find(i => i.value === value);
    if (!input || input.disabled) return this;

    if (this.options.type === 'radio') {
      // Radio: just select this one
      input.checked = true;
    } else {
      // Checkbox: toggle
      if (this.options.enforceSelection && input.checked) {
        const checkedCount = this._inputs.filter(i => i.checked).length;
        if (checkedCount <= 1) {
          return this; // Don't uncheck the last one
        }
      }
      input.checked = !input.checked;
    }

    input.dispatchEvent(new Event('change', { bubbles: true }));
    return this;
  }

  /**
   * Toggle button by index
   * @param {number} index - Index of button to toggle (0-based)
   * @returns {this} For chaining
   */
  toggleIndex(index) {
    const input = this._inputs[index];
    if (!input) return this;
    return this.toggle(input.value);
  }

  /**
   * Select all buttons (checkbox mode only)
   * @returns {this} For chaining
   */
  selectAll() {
    if (this.options.type !== 'checkbox') return this;

    this._inputs.forEach(input => {
      if (!input.disabled) {
        input.checked = true;
      }
    });

    this.emit(SOButtonGroup.EVENTS.CHANGE, {
      value: this.getValue(),
      changed: null,
      checked: true,
      programmatic: true
    });

    return this;
  }

  /**
   * Deselect all buttons
   * @returns {this} For chaining
   */
  deselectAll() {
    if (this.options.enforceSelection) return this;

    this._inputs.forEach(input => {
      input.checked = false;
    });

    this.emit(SOButtonGroup.EVENTS.CHANGE, {
      value: this.getValue(),
      changed: null,
      checked: false,
      programmatic: true
    });

    return this;
  }

  /**
   * Enable all buttons
   * @returns {this} For chaining
   */
  enable() {
    this._inputs.forEach(input => {
      input.disabled = false;
    });
    return super.enable();
  }

  /**
   * Disable all buttons
   * @returns {this} For chaining
   */
  disable() {
    this._inputs.forEach(input => {
      input.disabled = true;
    });
    return super.disable();
  }

  /**
   * Enable a specific button by value
   * @param {string} value - Value of button to enable
   * @returns {this} For chaining
   */
  enableButton(value) {
    const input = this._inputs.find(i => i.value === value);
    if (input) {
      input.disabled = false;
    }
    return this;
  }

  /**
   * Disable a specific button by value
   * @param {string} value - Value of button to disable
   * @returns {this} For chaining
   */
  disableButton(value) {
    const input = this._inputs.find(i => i.value === value);
    if (input) {
      input.disabled = true;
    }
    return this;
  }

  /**
   * Get all button values
   * @returns {string[]} Array of all button values
   */
  getValues() {
    return this._inputs.map(input => input.value);
  }

  /**
   * Check if a specific value is selected
   * @param {string} value - Value to check
   * @returns {boolean} Whether the value is selected
   */
  isSelected(value) {
    const input = this._inputs.find(i => i.value === value);
    return input ? input.checked : false;
  }

  /**
   * Get the number of selected buttons
   * @returns {number} Count of selected buttons
   */
  getSelectedCount() {
    return this._inputs.filter(input => input.checked).length;
  }

  /**
   * Refresh the component (re-scan for inputs)
   * @returns {this} For chaining
   */
  refresh() {
    this._inputs = this.$$('.so-btn-check');
    this._buttons = this._inputs.map(input => input.nextElementSibling);
    this._setupAria();
    return this;
  }
}

// Register component
SOButtonGroup.register();

// Auto-initialize button groups with data attribute
document.addEventListener('DOMContentLoaded', () => {
  SOButtonGroup.initAll('[data-so-toggle="buttons"]');
});

// Expose to global scope
window.SOButtonGroup = SOButtonGroup;

// Export for ES modules
export default SOButtonGroup;
export { SOButtonGroup };
