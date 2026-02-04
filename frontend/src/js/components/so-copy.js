// ============================================
// SIXORBIT UI - COPY COMPONENT
// Click-to-copy utility for any element
// Uses existing button classes and SOTooltip
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';
import SOTooltip from './so-tooltip.js';

/**
 * SOCopy - Universal copy-to-clipboard utility
 * Can be applied to any element via data attributes
 * Uses existing so-btn classes for styling
 * Uses SOTooltip for feedback
 */
class SOCopy extends SOComponent {
  static NAME = 'copy';

  static DEFAULTS = {
    // What to copy - can be: selector, 'self', 'value', or direct text
    target: null,
    // Direct text to copy (overrides target)
    text: null,
    // Feedback duration in ms
    feedbackDuration: 2000,
    // Success icon (Material Icons name)
    successIcon: 'check',
    // Default icon (Material Icons name)
    defaultIcon: 'content_copy',
    // Show tooltip feedback
    showTooltip: true,
    // Success tooltip text
    successText: 'Copied!',
    // Error tooltip text
    errorText: 'Failed to copy',
    // Callback on success
    onSuccess: null,
    // Callback on error
    onError: null,
  };

  static EVENTS = {
    COPY: 'copy:copy',
    SUCCESS: 'copy:success',
    ERROR: 'copy:error',
  };

  /**
   * Initialize the copy component
   * @private
   */
  _init() {
    this._originalContent = null;
    this._icon = this.$('.material-icons');
    this._isProcessing = false;

    // Bind click event
    this._bindEvents();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    this.on('click', (e) => {
      e.preventDefault();
      this.copy();
    });
  }

  /**
   * Get the text to copy
   * @returns {string|null}
   * @private
   */
  _getTextToCopy() {
    // Priority 1: Direct text option
    if (this.options.text) {
      return this.options.text;
    }

    // Priority 2: data-so-copy-text attribute
    const dataText = this.element.getAttribute('data-so-copy-text');
    if (dataText) {
      return dataText;
    }

    // Priority 3: Target element
    const target = this.options.target || this.element.getAttribute('data-so-copy-target');

    if (target) {
      if (target === 'self') {
        // Copy element's own text content
        return this.element.textContent.trim();
      }

      if (target === 'parent') {
        // Copy parent's text (excluding the button itself)
        const parent = this.element.parentElement;
        if (parent) {
          const clone = parent.cloneNode(true);
          const button = clone.querySelector('[data-so-copy], .so-btn');
          if (button) button.remove();
          return clone.textContent.trim();
        }
      }

      if (target === 'previous' || target === 'prev') {
        // Copy previous sibling's content
        const prev = this.element.previousElementSibling;
        return prev ? (prev.value || prev.textContent.trim()) : null;
      }

      // Selector target
      const targetEl = document.querySelector(target);
      if (targetEl) {
        // Handle input/textarea
        if (targetEl.tagName === 'INPUT' || targetEl.tagName === 'TEXTAREA') {
          return targetEl.value;
        }
        // Handle select
        if (targetEl.tagName === 'SELECT') {
          return targetEl.options[targetEl.selectedIndex]?.text || targetEl.value;
        }
        // Handle contenteditable
        if (targetEl.isContentEditable) {
          return targetEl.textContent.trim();
        }
        // Default: text content
        return targetEl.textContent.trim();
      }
    }

    // Fallback: Try to find adjacent copyable content
    const wrapper = this.element.closest('.so-copy-wrapper, .so-input-group, .so-code-block');
    if (wrapper) {
      const input = wrapper.querySelector('input, textarea');
      if (input) return input.value;

      const code = wrapper.querySelector('code, pre, .so-copy-content');
      if (code) return code.textContent.trim();
    }

    return null;
  }

  /**
   * Copy text to clipboard
   * @param {string} [text] - Optional text to copy (overrides configured target)
   * @returns {Promise<boolean>}
   */
  async copy(text = null) {
    if (this._isProcessing) return false;

    const textToCopy = text || this._getTextToCopy();

    if (!textToCopy) {
      console.warn('SOCopy: No text to copy');
      this._showError();
      return false;
    }

    this._isProcessing = true;
    this.emit(SOCopy.EVENTS.COPY, { text: textToCopy });

    try {
      await navigator.clipboard.writeText(textToCopy);
      this._showSuccess();
      this.emit(SOCopy.EVENTS.SUCCESS, { text: textToCopy });

      if (typeof this.options.onSuccess === 'function') {
        this.options.onSuccess(textToCopy, this);
      }

      return true;
    } catch (err) {
      // Fallback for older browsers or restricted contexts
      const success = this._fallbackCopy(textToCopy);

      if (success) {
        this._showSuccess();
        this.emit(SOCopy.EVENTS.SUCCESS, { text: textToCopy });

        if (typeof this.options.onSuccess === 'function') {
          this.options.onSuccess(textToCopy, this);
        }

        return true;
      } else {
        this._showError();
        this.emit(SOCopy.EVENTS.ERROR, { error: err });

        if (typeof this.options.onError === 'function') {
          this.options.onError(err, this);
        }

        return false;
      }
    }
  }

  /**
   * Fallback copy method for older browsers
   * @param {string} text
   * @returns {boolean}
   * @private
   */
  _fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.cssText = 'position:fixed;left:-9999px;top:-9999px;';
    document.body.appendChild(textarea);
    textarea.select();

    try {
      const success = document.execCommand('copy');
      document.body.removeChild(textarea);
      return success;
    } catch (err) {
      document.body.removeChild(textarea);
      return false;
    }
  }

  /**
   * Show success feedback
   * @private
   */
  _showSuccess() {
    this.element.classList.add('so-copy-success');

    // Update icon if present
    if (this._icon) {
      this._originalContent = this._icon.textContent;
      this._icon.textContent = this.options.successIcon;
    }

    // Show tooltip using SOTooltip
    if (this.options.showTooltip) {
      SOTooltip.showTemporary(this.element, {
        content: this.options.successText,
        color: 'success',
        autoHide: this.options.feedbackDuration,
      });
    }

    // Reset after duration
    setTimeout(() => {
      this._resetState();
    }, this.options.feedbackDuration);
  }

  /**
   * Show error feedback
   * @private
   */
  _showError() {
    this.element.classList.add('so-copy-error');

    // Show tooltip using SOTooltip
    if (this.options.showTooltip) {
      SOTooltip.showTemporary(this.element, {
        content: this.options.errorText,
        color: 'danger',
        autoHide: this.options.feedbackDuration,
      });
    }

    // Reset after duration
    setTimeout(() => {
      this._resetState();
    }, this.options.feedbackDuration);
  }

  /**
   * Reset to original state
   * @private
   */
  _resetState() {
    this._isProcessing = false;
    this.element.classList.remove('so-copy-success', 'so-copy-error');

    // Restore original icon
    if (this._icon && this._originalContent) {
      this._icon.textContent = this._originalContent;
      this._originalContent = null;
    }
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Copy text directly (without a component instance)
   * @param {string} text - Text to copy
   * @param {Object} [options] - Optional callbacks
   * @returns {Promise<boolean>}
   */
  static async copyText(text, options = {}) {
    try {
      await navigator.clipboard.writeText(text);
      if (options.onSuccess) options.onSuccess(text);
      return true;
    } catch (err) {
      // Fallback
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.style.cssText = 'position:fixed;left:-9999px;top:-9999px;';
      document.body.appendChild(textarea);
      textarea.select();

      try {
        const success = document.execCommand('copy');
        document.body.removeChild(textarea);
        if (success && options.onSuccess) options.onSuccess(text);
        if (!success && options.onError) options.onError(new Error('Copy failed'));
        return success;
      } catch (e) {
        document.body.removeChild(textarea);
        if (options.onError) options.onError(e);
        return false;
      }
    }
  }

  /**
   * Copy from an element
   * @param {string|HTMLElement} target - Selector or element
   * @param {Object} [options] - Optional callbacks
   * @returns {Promise<boolean>}
   */
  static async copyFrom(target, options = {}) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) {
      if (options.onError) options.onError(new Error('Element not found'));
      return false;
    }

    let text;
    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
      text = el.value;
    } else if (el.tagName === 'SELECT') {
      text = el.options[el.selectedIndex]?.text || el.value;
    } else {
      text = el.textContent.trim();
    }

    return SOCopy.copyText(text, options);
  }

  /**
   * Create a copy button dynamically
   * Uses existing button classes: so-btn, so-btn-icon, so-btn-ghost
   * @param {Object} options - Configuration options
   * @returns {HTMLElement}
   */
  static createButton(options = {}) {
    const {
      target = null,
      text = null,
      icon = 'content_copy',
      label = '',
      className = '',
      size = 'sm', // xs, sm, (default), lg
      variant = 'ghost', // ghost, outline, primary, etc.
    } = options;

    const button = document.createElement('button');
    button.type = 'button';

    // Build class list using existing button classes
    const classes = ['so-btn'];
    if (!label) classes.push('so-btn-icon');
    if (variant) classes.push(`so-btn-${variant}`);
    if (size) classes.push(`so-btn-${size}`);
    if (className) classes.push(className);

    button.className = classes.join(' ');

    if (target) {
      button.setAttribute('data-so-copy-target', target);
    }
    if (text) {
      button.setAttribute('data-so-copy-text', text);
    }
    button.setAttribute('data-so-copy', '');

    button.innerHTML = `<span class="material-icons">${icon}</span>${label ? `<span>${label}</span>` : ''}`;

    // Auto-initialize
    new SOCopy(button, options);

    return button;
  }

  /**
   * Initialize all copy buttons on the page
   */
  static initAll() {
    // Initialize elements with data-so-copy attribute
    document.querySelectorAll('[data-so-copy]').forEach(el => {
      if (!el._soCopyInstance) {
        el._soCopyInstance = new SOCopy(el);
      }
    });
  }
}

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => SOCopy.initAll());
} else {
  SOCopy.initAll();
}

// Also initialize on dynamic content (mutation observer)
const copyObserver = new MutationObserver((mutations) => {
  mutations.forEach(mutation => {
    mutation.addedNodes.forEach(node => {
      if (node.nodeType === Node.ELEMENT_NODE) {
        if (node.matches('[data-so-copy]')) {
          if (!node._soCopyInstance) {
            node._soCopyInstance = new SOCopy(node);
          }
        }
        node.querySelectorAll('[data-so-copy]').forEach(el => {
          if (!el._soCopyInstance) {
            el._soCopyInstance = new SOCopy(el);
          }
        });
      }
    });
  });
});

copyObserver.observe(document.body, { childList: true, subtree: true });

// Register with SixOrbit
SixOrbit.registerComponent(SOCopy);

export default SOCopy;
