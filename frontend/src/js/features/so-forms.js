// ============================================
// SIXORBIT UI - FORMS FEATURE
// Form utilities, validation, and enhancements
// ============================================

import SixOrbit from '../core/so-config.js';
import { SODropdown } from '../components/so-dropdown.js';
import { SOOtpInput } from '../components/so-otp.js';
import { SOButtonGroup } from '../components/so-button-group.js';
import { SOProgressButton } from '../components/so-progress-button.js';

/**
 * SOForms - Form utilities and validation
 * Provides form field enhancements and validation helpers
 */
class SOForms {
  /**
   * Initialize all form components on the page
   */
  static initAll() {
    // Initialize standard dropdowns
    document.querySelectorAll('.so-dropdown').forEach(el => {
      SODropdown.getInstance(el);
    });

    // Initialize searchable dropdowns
    document.querySelectorAll('.so-searchable-dropdown').forEach(el => {
      SODropdown.getInstance(el);
    });

    // Initialize options dropdowns
    document.querySelectorAll('.so-options-dropdown').forEach(el => {
      SODropdown.getInstance(el);
    });

    // Initialize outlet dropdowns
    document.querySelectorAll('.so-outlet-dropdown').forEach(el => {
      SODropdown.getInstance(el);
    });

    // Initialize OTP inputs
    document.querySelectorAll('.so-otp-group').forEach(el => {
      SOOtpInput.getInstance(el);
    });

    // Initialize toggle button groups
    document.querySelectorAll('[data-so-toggle="buttons"]').forEach(el => {
      SOButtonGroup.getInstance(el);
    });

    // Initialize progress buttons with data attribute
    document.querySelectorAll('.so-btn-progress[data-so-progress]').forEach(el => {
      SOProgressButton.getInstance(el);
    });

    // Initialize checkboxes styling
    SOForms._initCheckboxes();

    // Initialize input enhancements
    SOForms._initInputEnhancements();
  }

  /**
   * Initialize custom checkbox styling
   * @private
   */
  static _initCheckboxes() {
    // Style native checkboxes that aren't already wrapped
    // Exclude checkboxes that are inside .so-checkbox, .so-toggle, .so-switch, or .so-btn-check
    document.querySelectorAll('input[type="checkbox"]:not(.so-checkbox input)').forEach(checkbox => {
      if (checkbox.closest('.so-checkbox, .so-toggle, .so-switch, .so-btn-check')) return;

      const wrapper = document.createElement('label');
      wrapper.className = 'so-checkbox';

      const box = document.createElement('span');
      box.className = 'so-checkbox-box';
      box.innerHTML = '<span class="material-icons">check</span>';

      checkbox.parentNode.insertBefore(wrapper, checkbox);
      wrapper.appendChild(checkbox);
      wrapper.appendChild(box);
    });
  }

  /**
   * Initialize input enhancements
   * @private
   */
  static _initInputEnhancements() {
    // Password toggle
    document.querySelectorAll('.so-password-toggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const wrapper = btn.closest('.so-form-input-wrapper, .so-auth-input-wrapper');
        const input = wrapper?.querySelector('input');
        if (!input) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.querySelector('.material-icons').textContent = isPassword ? 'visibility_off' : 'visibility';
      });
    });

    // Input clear buttons
    document.querySelectorAll('.so-input-clear').forEach(btn => {
      const wrapper = btn.closest('.so-input-wrapper, .so-form-input-wrapper');
      const input = wrapper?.querySelector('input');

      // Click handler for clear button
      btn.addEventListener('click', () => {
        if (input) {
          input.value = '';
          input.focus();
          input.dispatchEvent(new Event('input', { bubbles: true }));
        }
      });

      // Escape key handler on the input
      if (input) {
        input.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && input.value.trim() !== '') {
            e.preventDefault();
            e.stopPropagation();
            input.value = '';
            input.dispatchEvent(new Event('input', { bubbles: true }));
          }
        });
      }
    });

    // Floating labels
    document.querySelectorAll('.so-form-floating input, .so-form-floating textarea').forEach(input => {
      const updateState = () => {
        const hasValue = input.value.trim() !== '';
        input.classList.toggle('has-value', hasValue);
      };

      input.addEventListener('input', updateState);
      input.addEventListener('change', updateState);
      updateState();
    });

    // Initialize autosize textareas (including size variants)
    document.querySelectorAll('.so-form-control-autosize, .so-form-control-autosize-sm, .so-form-control-autosize-lg').forEach(textarea => {
      // Determine default min/max based on size variant
      let defaultMinHeight = 80;
      let defaultMaxHeight = 400;

      if (textarea.classList.contains('so-form-control-autosize-sm')) {
        defaultMinHeight = 60;
        defaultMaxHeight = 200;
      } else if (textarea.classList.contains('so-form-control-autosize-lg')) {
        defaultMinHeight = 120;
        defaultMaxHeight = 600;
      }

      const options = {
        minHeight: parseInt(textarea.dataset.minHeight) || defaultMinHeight,
        maxHeight: parseInt(textarea.dataset.maxHeight) || defaultMaxHeight
      };
      SOTextareaAutosize.getInstance(textarea, options);
    });
  }

  // ============================================
  // VALIDATION
  // ============================================

  /**
   * Validate an email address
   * @param {string} email - Email to validate
   * @returns {boolean} Whether email is valid
   */
  static validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }

  /**
   * Validate a phone number (10 digits)
   * @param {string} phone - Phone number to validate
   * @returns {boolean} Whether phone is valid
   */
  static validatePhone(phone) {
    const cleaned = phone.replace(/[\s\-\(\)]/g, '');
    return /^[0-9]{10}$/.test(cleaned);
  }

  /**
   * Validate a required field
   * @param {string} value - Value to validate
   * @returns {boolean} Whether value is not empty
   */
  static validateRequired(value) {
    return value !== null && value !== undefined && value.toString().trim() !== '';
  }

  /**
   * Validate minimum length
   * @param {string} value - Value to validate
   * @param {number} minLength - Minimum length
   * @returns {boolean} Whether value meets minimum length
   */
  static validateMinLength(value, minLength) {
    return value.length >= minLength;
  }

  /**
   * Validate maximum length
   * @param {string} value - Value to validate
   * @param {number} maxLength - Maximum length
   * @returns {boolean} Whether value is within maximum length
   */
  static validateMaxLength(value, maxLength) {
    return value.length <= maxLength;
  }

  /**
   * Validate password strength
   * @param {string} password - Password to validate
   * @param {Object} options - Validation options
   * @returns {Object} Validation result with individual checks
   */
  static validatePassword(password, options = {}) {
    const {
      minLength = 8,
      requireUppercase = true,
      requireLowercase = true,
      requireNumber = true,
      requireSpecial = false,
    } = options;

    const result = {
      valid: true,
      length: password.length >= minLength,
      uppercase: !requireUppercase || /[A-Z]/.test(password),
      lowercase: !requireLowercase || /[a-z]/.test(password),
      number: !requireNumber || /[0-9]/.test(password),
      special: !requireSpecial || /[!@#$%^&*(),.?":{}|<>]/.test(password),
    };

    result.valid = result.length && result.uppercase && result.lowercase && result.number && result.special;

    return result;
  }

  /**
   * Validate that two values match
   * @param {string} value1 - First value
   * @param {string} value2 - Second value
   * @returns {boolean} Whether values match
   */
  static validateMatch(value1, value2) {
    return value1 === value2;
  }

  // ============================================
  // FORM STATE
  // ============================================

  /**
   * Show error state on a form group
   * @param {string} fieldId - Field ID (without 'Group' suffix)
   * @param {string} message - Error message
   */
  static showError(fieldId, message) {
    const group = document.getElementById(`${fieldId}Group`);
    const errorEl = document.getElementById(`${fieldId}Error`);

    if (group) {
      group.classList.remove('has-success', 'has-warning', 'has-info');
      group.classList.add('has-error');
    }
    if (errorEl && message) {
      errorEl.textContent = message;
    }
  }

  /**
   * Show success state on a form group
   * @param {string} fieldId - Field ID (without 'Group' suffix)
   * @param {string} message - Success message (optional)
   */
  static showSuccess(fieldId, message = '') {
    const group = document.getElementById(`${fieldId}Group`);
    const successEl = document.getElementById(`${fieldId}Success`);

    if (group) {
      group.classList.remove('has-error', 'has-warning', 'has-info');
      group.classList.add('has-success');
    }
    if (successEl && message) {
      successEl.textContent = message;
    }
  }

  /**
   * Show warning state on a form group
   * @param {string} fieldId - Field ID (without 'Group' suffix)
   * @param {string} message - Warning message
   */
  static showWarning(fieldId, message) {
    const group = document.getElementById(`${fieldId}Group`);
    const warningEl = document.getElementById(`${fieldId}Warning`);

    if (group) {
      group.classList.remove('has-error', 'has-success', 'has-info');
      group.classList.add('has-warning');
    }
    if (warningEl && message) {
      warningEl.textContent = message;
    }
  }

  /**
   * Show info state on a form group
   * @param {string} fieldId - Field ID (without 'Group' suffix)
   * @param {string} message - Info message
   */
  static showInfo(fieldId, message) {
    const group = document.getElementById(`${fieldId}Group`);
    const infoEl = document.getElementById(`${fieldId}Info`);

    if (group) {
      group.classList.remove('has-error', 'has-success', 'has-warning');
      group.classList.add('has-info');
    }
    if (infoEl && message) {
      infoEl.textContent = message;
    }
  }

  /**
   * Clear error state on a form group
   * @param {string} fieldId - Field ID (without 'Group' suffix)
   */
  static clearError(fieldId) {
    const group = document.getElementById(`${fieldId}Group`);
    if (group) {
      group.classList.remove('has-error');
    }
  }

  /**
   * Clear all validation states on a form group
   * @param {string} fieldId - Field ID (without 'Group' suffix)
   */
  static clearValidation(fieldId) {
    const group = document.getElementById(`${fieldId}Group`);
    if (group) {
      group.classList.remove('has-error', 'has-success', 'has-warning', 'has-info');
    }
  }

  /**
   * Clear all errors in a form
   * @param {HTMLFormElement|string} form - Form element or selector
   */
  static clearAllErrors(form) {
    const formEl = typeof form === 'string' ? document.querySelector(form) : form;
    if (!formEl) return;

    formEl.querySelectorAll('.has-error').forEach(el => {
      el.classList.remove('has-error');
    });
  }

  /**
   * Set loading state on a button
   * @param {HTMLButtonElement|string} button - Button element or selector
   * @param {boolean} isLoading - Whether to show loading state
   */
  static setButtonLoading(button, isLoading) {
    const btn = typeof button === 'string' ? document.querySelector(button) : button;
    if (!btn) return;

    if (isLoading) {
      btn.classList.add('so-loading');
      btn.disabled = true;
    } else {
      btn.classList.remove('so-loading');
      btn.disabled = false;
    }
  }

  /**
   * Get form data as an object
   * @param {HTMLFormElement|string} form - Form element or selector
   * @returns {Object} Form data object
   */
  static getFormData(form) {
    const formEl = typeof form === 'string' ? document.querySelector(form) : form;
    if (!formEl) return {};

    const formData = new FormData(formEl);
    const data = {};

    for (const [key, value] of formData.entries()) {
      // Handle multiple values (like checkboxes)
      if (data[key]) {
        if (!Array.isArray(data[key])) {
          data[key] = [data[key]];
        }
        data[key].push(value);
      } else {
        data[key] = value;
      }
    }

    return data;
  }

  /**
   * Set form data from an object
   * @param {HTMLFormElement|string} form - Form element or selector
   * @param {Object} data - Data object
   */
  static setFormData(form, data) {
    const formEl = typeof form === 'string' ? document.querySelector(form) : form;
    if (!formEl) return;

    Object.entries(data).forEach(([name, value]) => {
      const field = formEl.elements[name];
      if (!field) return;

      if (field.type === 'checkbox') {
        field.checked = !!value;
      } else if (field.type === 'radio') {
        const radio = formEl.querySelector(`input[name="${name}"][value="${value}"]`);
        if (radio) radio.checked = true;
      } else {
        field.value = value;
      }
    });
  }

  /**
   * Reset form to initial state
   * @param {HTMLFormElement|string} form - Form element or selector
   */
  static resetForm(form) {
    const formEl = typeof form === 'string' ? document.querySelector(form) : form;
    if (!formEl) return;

    formEl.reset();
    SOForms.clearAllErrors(formEl);
  }

  // ============================================
  // MASKING
  // ============================================

  /**
   * Mask an email address
   * @param {string} email - Email to mask
   * @returns {string} Masked email
   */
  static maskEmail(email) {
    const [local, domain] = email.split('@');
    if (!domain) return email;

    const maskedLocal = local.charAt(0) +
      '*'.repeat(Math.min(local.length - 2, 4)) +
      local.charAt(local.length - 1);

    return `${maskedLocal}@${domain}`;
  }

  /**
   * Mask a phone number
   * @param {string} phone - Phone number to mask
   * @returns {string} Masked phone
   */
  static maskPhone(phone) {
    const cleaned = phone.replace(/[\s\-\(\)]/g, '');
    if (cleaned.length < 4) return phone;

    return cleaned.slice(0, 2) + '*'.repeat(cleaned.length - 4) + cleaned.slice(-2);
  }
}

/**
 * SOTextareaAutosize - Auto-expanding textarea
 * Automatically adjusts height based on content
 */
class SOTextareaAutosize {
  /**
   * Create autosize textarea
   * @param {HTMLTextAreaElement} element - The textarea element
   * @param {Object} options - Configuration options
   */
  constructor(element, options = {}) {
    this.element = element;
    this.options = {
      minHeight: options.minHeight || 80,
      maxHeight: options.maxHeight || 400,
      ...options
    };

    this._init();
  }

  /**
   * Initialize the autosize functionality
   * @private
   */
  _init() {
    // Store original styles
    this._originalStyles = {
      height: this.element.style.height,
      overflow: this.element.style.overflow,
      resize: this.element.style.resize
    };

    // Apply autosize styles
    this.element.style.overflow = 'hidden';
    this.element.style.resize = 'none';
    this.element.style.minHeight = `${this.options.minHeight}px`;
    this.element.style.maxHeight = `${this.options.maxHeight}px`;

    // Bind events
    this._boundResize = this._resize.bind(this);
    this.element.addEventListener('input', this._boundResize);
    this.element.addEventListener('change', this._boundResize);

    // Initial resize
    this._resize();

    // Handle window resize
    this._boundWindowResize = this._resize.bind(this);
    window.addEventListener('resize', this._boundWindowResize);
  }

  /**
   * Resize the textarea based on content
   * @private
   */
  _resize() {
    // Reset height to auto to get the correct scrollHeight
    this.element.style.height = 'auto';

    // Calculate new height
    const scrollHeight = this.element.scrollHeight;
    const newHeight = Math.min(
      Math.max(scrollHeight, this.options.minHeight),
      this.options.maxHeight
    );

    this.element.style.height = `${newHeight}px`;

    // Show scrollbar if content exceeds max height
    if (scrollHeight > this.options.maxHeight) {
      this.element.style.overflow = 'auto';
    } else {
      this.element.style.overflow = 'hidden';
    }

    // Dispatch custom event
    this.element.dispatchEvent(new CustomEvent('so:autosize', {
      detail: { height: newHeight, scrollHeight }
    }));
  }

  /**
   * Update the content and resize
   * @param {string} value - New value
   */
  update(value) {
    this.element.value = value;
    this._resize();
  }

  /**
   * Destroy the autosize instance
   */
  destroy() {
    // Remove event listeners
    this.element.removeEventListener('input', this._boundResize);
    this.element.removeEventListener('change', this._boundResize);
    window.removeEventListener('resize', this._boundWindowResize);

    // Restore original styles
    this.element.style.height = this._originalStyles.height;
    this.element.style.overflow = this._originalStyles.overflow;
    this.element.style.resize = this._originalStyles.resize;
    this.element.style.minHeight = '';
    this.element.style.maxHeight = '';

    // Remove instance reference
    delete this.element._soAutosize;
  }

  /**
   * Get or create instance for element
   * @param {HTMLTextAreaElement} element - The textarea element
   * @param {Object} options - Configuration options
   * @returns {SOTextareaAutosize}
   */
  static getInstance(element, options = {}) {
    if (!element._soAutosize) {
      element._soAutosize = new SOTextareaAutosize(element, options);
    }
    return element._soAutosize;
  }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  SOForms.initAll();
});

// Expose to global scope
window.SOForms = SOForms;
window.SOTextareaAutosize = SOTextareaAutosize;
window.SOButtonGroup = SOButtonGroup;
window.SOProgressButton = SOProgressButton;

// Export for ES modules
export default SOForms;
export { SOForms, SOTextareaAutosize, SOButtonGroup, SOProgressButton };
