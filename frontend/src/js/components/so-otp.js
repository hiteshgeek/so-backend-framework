// ============================================
// SIXORBIT UI - OTP INPUT COMPONENT
// Auto-advancing OTP/PIN input fields
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOOtpInput - OTP/PIN input component
 * Handles auto-advance, paste, and backspace navigation
 */
class SOOtpInput extends SOComponent {
  static NAME = 'otp';

  static DEFAULTS = {
    length: 6,
    inputSelector: '.so-otp-input',
    autoFocus: true,
    numericOnly: true,
  };

  static EVENTS = {
    COMPLETE: 'otp:complete',
    CHANGE: 'otp:change',
  };

  /**
   * Initialize the OTP input
   * @private
   */
  _init() {
    // Get all input elements
    this._inputs = this.$$(this.options.inputSelector);

    if (this._inputs.length === 0) return;

    // Bind events
    this._bindEvents();

    // Auto-focus first input
    if (this.options.autoFocus) {
      this._inputs[0]?.focus();
    }
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    this._inputs.forEach((input, index) => {
      // Input event
      this.on('input', (e) => this._handleInput(e, index), input);

      // Keydown event (for backspace navigation)
      this.on('keydown', (e) => this._handleKeydown(e, index), input);

      // Paste event
      this.on('paste', (e) => this._handlePaste(e, index), input);

      // Focus event (select content)
      this.on('focus', () => input.select(), input);
    });
  }

  /**
   * Handle input event
   * @param {Event} e - Input event
   * @param {number} index - Input index
   * @private
   */
  _handleInput(e, index) {
    const input = e.target;
    let value = input.value;

    // Only allow digits if numeric only
    if (this.options.numericOnly) {
      value = value.replace(/[^0-9]/g, '');
    }

    // Only keep first character
    value = value.slice(0, 1);
    input.value = value;

    // Update filled state
    if (value) {
      input.classList.add('filled');

      // Move to next input
      if (index < this._inputs.length - 1) {
        this._inputs[index + 1].focus();
      }
    } else {
      input.classList.remove('filled');
    }

    // Emit change event
    this.emit(SOOtpInput.EVENTS.CHANGE, { value: this.getValue(), index });

    // Check if complete
    this._checkComplete();
  }

  /**
   * Handle keydown event
   * @param {KeyboardEvent} e - Keyboard event
   * @param {number} index - Input index
   * @private
   */
  _handleKeydown(e, index) {
    const input = e.target;

    // Handle backspace
    if (e.key === 'Backspace') {
      if (!input.value && index > 0) {
        // Move to previous input and clear it
        const prevInput = this._inputs[index - 1];
        prevInput.value = '';
        prevInput.classList.remove('filled');
        prevInput.focus();
      } else {
        input.classList.remove('filled');
      }
    }

    // Handle arrow keys
    if (e.key === 'ArrowLeft' && index > 0) {
      e.preventDefault();
      this._inputs[index - 1].focus();
    }

    if (e.key === 'ArrowRight' && index < this._inputs.length - 1) {
      e.preventDefault();
      this._inputs[index + 1].focus();
    }

    // Prevent non-numeric input if numeric only
    if (this.options.numericOnly &&
        e.key.length === 1 &&
        !/[0-9]/.test(e.key) &&
        !e.ctrlKey && !e.metaKey) {
      e.preventDefault();
    }
  }

  /**
   * Handle paste event
   * @param {ClipboardEvent} e - Paste event
   * @param {number} startIndex - Starting input index
   * @private
   */
  _handlePaste(e, startIndex) {
    e.preventDefault();

    const pastedData = (e.clipboardData || window.clipboardData).getData('text');
    let chars = this.options.numericOnly
      ? pastedData.replace(/[^0-9]/g, '').split('')
      : pastedData.split('');

    // Fill inputs starting from current position
    chars.forEach((char, i) => {
      const inputIndex = startIndex + i;
      if (this._inputs[inputIndex]) {
        this._inputs[inputIndex].value = char;
        this._inputs[inputIndex].classList.add('filled');
      }
    });

    // Focus next empty or last input
    const nextEmptyIndex = this._inputs.findIndex(input => !input.value);
    if (nextEmptyIndex !== -1) {
      this._inputs[nextEmptyIndex].focus();
    } else {
      this._inputs[this._inputs.length - 1].focus();
    }

    // Emit change and check complete
    this.emit(SOOtpInput.EVENTS.CHANGE, { value: this.getValue() });
    this._checkComplete();
  }

  /**
   * Check if all inputs are filled
   * @private
   */
  _checkComplete() {
    const value = this.getValue();
    if (value.length === this._inputs.length) {
      this.emit(SOOtpInput.EVENTS.COMPLETE, { value });
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Get the current OTP value
   * @returns {string} Combined OTP value
   */
  getValue() {
    return this._inputs.map(input => input.value).join('');
  }

  /**
   * Set the OTP value
   * @param {string} value - OTP value to set
   * @returns {this} For chaining
   */
  setValue(value) {
    const chars = value.toString().split('');

    this._inputs.forEach((input, i) => {
      const char = chars[i] || '';
      input.value = char;
      input.classList.toggle('filled', !!char);
    });

    this.emit(SOOtpInput.EVENTS.CHANGE, { value: this.getValue() });
    this._checkComplete();

    return this;
  }

  /**
   * Clear all inputs
   * @returns {this} For chaining
   */
  clear() {
    this._inputs.forEach(input => {
      input.value = '';
      input.classList.remove('filled', 'error');
    });

    if (this.options.autoFocus) {
      this._inputs[0]?.focus();
    }

    this.emit(SOOtpInput.EVENTS.CHANGE, { value: '' });

    return this;
  }

  /**
   * Focus the first empty input
   * @returns {this} For chaining
   */
  focus() {
    const emptyInput = this._inputs.find(input => !input.value);
    (emptyInput || this._inputs[0])?.focus();
    return this;
  }

  /**
   * Set error state on inputs
   * @param {boolean} [hasError=true] - Whether to show error state
   * @returns {this} For chaining
   */
  setError(hasError = true) {
    this._inputs.forEach(input => {
      input.classList.toggle('error', hasError);
    });
    return this;
  }

  /**
   * Check if OTP is complete
   * @returns {boolean} Whether all inputs are filled
   */
  isComplete() {
    return this.getValue().length === this._inputs.length;
  }

  /**
   * Validate the OTP against a value
   * @param {string} expected - Expected OTP value
   * @returns {boolean} Whether OTP matches
   */
  validate(expected) {
    const isValid = this.getValue() === expected.toString();
    this.setError(!isValid);
    return isValid;
  }
}

// Register component
SOOtpInput.register();

// Expose to global scope
window.SOOtpInput = SOOtpInput;

// Export for ES modules
export default SOOtpInput;
export { SOOtpInput };
