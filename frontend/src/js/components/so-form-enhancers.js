// ============================================
// SIXORBIT UI - FORM ENHANCERS
// Input masking, password strength, char counter, clear button
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

// ============================================
// INPUT MASK COMPONENT
// ============================================

/**
 * SOInputMask - Input masking for formatted data entry
 * Supports: phone, card, date, time, currency, custom patterns
 */
class SOInputMask extends SOComponent {
  static NAME = 'input-mask';

  static DEFAULTS = {
    // Mask type: phone, card, date, time, currency, percentage, ssn, zip, custom
    mask: 'phone',
    // Custom pattern (for mask='custom')
    // # = digit, A = letter, * = alphanumeric
    pattern: null,
    // Placeholder character
    placeholder: '_',
    // Show mask while typing
    showMask: true,
    // Allow incomplete values
    allowIncomplete: true,
    // Prefix text
    prefix: '',
    // Suffix text
    suffix: '',
    // Thousands separator for currency
    thousandsSeparator: ',',
    // Decimal separator for currency
    decimalSeparator: '.',
    // Decimal places for currency
    decimalPlaces: 2,
    // Currency symbol
    currencySymbol: '$',
    // Phone format
    phoneFormat: '(###) ###-####',
    // Date format
    dateFormat: 'MM/DD/YYYY',
    // Time format
    timeFormat: 'HH:MM',
  };

  static EVENTS = {
    CHANGE: 'input-mask:change',
    COMPLETE: 'input-mask:complete',
    INCOMPLETE: 'input-mask:incomplete',
  };

  // Predefined masks
  static MASKS = {
    phone: '(###) ###-####',
    phoneIntl: '+# (###) ###-####',
    card: '#### #### #### ####',
    cardAmex: '#### ###### #####',
    date: '##/##/####',
    dateIso: '####-##-##',
    time: '##:##',
    time24: '##:##',
    time12: '##:## AA',
    ssn: '###-##-####',
    zip: '#####',
    zipExt: '#####-####',
    ein: '##-#######',
  };

  _init() {
    this._rawValue = '';
    this._cursorPosition = 0;

    // Add mask class
    this.element.classList.add(SixOrbit.cls('input-mask'));

    // Determine the mask pattern
    this._pattern = this._getPattern();

    // Set placeholder if showMask is true
    if (this.options.showMask && this._pattern) {
      this.element.placeholder = this._formatMaskPlaceholder();
    }

    this._bindEvents();

    // Initialize with existing value
    if (this.element.value) {
      this._handleInput();
    }
  }

  _getPattern() {
    if (this.options.pattern) {
      return this.options.pattern;
    }

    const mask = this.options.mask.toLowerCase();

    if (SOInputMask.MASKS[mask]) {
      return SOInputMask.MASKS[mask];
    }

    // Special cases
    switch (mask) {
      case 'phone':
        return this.options.phoneFormat;
      case 'date':
        return this._dateFormatToPattern(this.options.dateFormat);
      case 'time':
        return this._timeFormatToPattern(this.options.timeFormat);
      case 'currency':
      case 'percentage':
        return null; // Handled differently
      default:
        return this.options.pattern;
    }
  }

  _dateFormatToPattern(format) {
    return format
      .replace(/YYYY/g, '####')
      .replace(/YY/g, '##')
      .replace(/MM/g, '##')
      .replace(/DD/g, '##');
  }

  _timeFormatToPattern(format) {
    return format
      .replace(/HH/g, '##')
      .replace(/MM/g, '##')
      .replace(/SS/g, '##')
      .replace(/AA/g, 'AA');
  }

  _formatMaskPlaceholder() {
    return this._pattern.replace(/#/g, this.options.placeholder)
                        .replace(/A/g, this.options.placeholder)
                        .replace(/\*/g, this.options.placeholder);
  }

  _bindEvents() {
    this.on('input', this._handleInput);
    this.on('keydown', this._handleKeydown);
    this.on('focus', this._handleFocus);
    this.on('blur', this._handleBlur);
    this.on('paste', this._handlePaste);
  }

  _handleInput(e) {
    const mask = this.options.mask.toLowerCase();

    if (mask === 'currency') {
      this._formatCurrency();
    } else if (mask === 'percentage') {
      this._formatPercentage();
    } else if (this._pattern) {
      this._applyMask();
    }

    this._checkComplete();
  }

  _handleKeydown(e) {
    // Allow: backspace, delete, tab, escape, enter
    if ([8, 9, 27, 13, 46].includes(e.keyCode)) {
      return;
    }

    // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
    if ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88].includes(e.keyCode)) {
      return;
    }

    // Allow: home, end, left, right, down, up
    if (e.keyCode >= 35 && e.keyCode <= 40) {
      return;
    }

    const mask = this.options.mask.toLowerCase();

    // For numeric masks, only allow numbers
    if (['phone', 'card', 'date', 'time', 'ssn', 'zip', 'currency', 'percentage'].includes(mask)) {
      if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
        // Allow decimal point for currency
        if (mask === 'currency' && (e.key === '.' || e.key === this.options.decimalSeparator)) {
          return;
        }
        e.preventDefault();
      }
    }
  }

  _handleFocus(e) {
    if (this.options.showMask && !this.element.value && this._pattern) {
      // Optionally show mask on focus
    }
  }

  _handleBlur(e) {
    this._checkComplete();

    // Emit appropriate event
    const isComplete = this._isComplete();
    this.emit(isComplete ? SOInputMask.EVENTS.COMPLETE : SOInputMask.EVENTS.INCOMPLETE, {
      value: this.element.value,
      rawValue: this._rawValue,
    });
  }

  _handlePaste(e) {
    e.preventDefault();
    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
    const cleanText = this._extractDigits(pastedText);
    this.element.value = cleanText;
    this._handleInput();
  }

  _applyMask() {
    const value = this.element.value;
    const cursorPos = this.element.selectionStart;
    const rawValue = this._extractRawValue(value);
    this._rawValue = rawValue;

    let formatted = '';
    let rawIndex = 0;

    for (let i = 0; i < this._pattern.length && rawIndex < rawValue.length; i++) {
      const maskChar = this._pattern[i];

      if (maskChar === '#') {
        // Digit
        if (/\d/.test(rawValue[rawIndex])) {
          formatted += rawValue[rawIndex];
          rawIndex++;
        }
      } else if (maskChar === 'A') {
        // Letter
        if (/[a-zA-Z]/.test(rawValue[rawIndex])) {
          formatted += rawValue[rawIndex].toUpperCase();
          rawIndex++;
        }
      } else if (maskChar === '*') {
        // Alphanumeric
        if (/[a-zA-Z0-9]/.test(rawValue[rawIndex])) {
          formatted += rawValue[rawIndex];
          rawIndex++;
        }
      } else {
        // Literal character
        formatted += maskChar;
        if (rawValue[rawIndex] === maskChar) {
          rawIndex++;
        }
      }
    }

    this.element.value = formatted;

    // Restore cursor position
    const newCursorPos = this._calculateCursorPosition(cursorPos, value, formatted);
    this.element.setSelectionRange(newCursorPos, newCursorPos);
  }

  _extractRawValue(value) {
    // Extract only the characters that matter based on mask type
    const mask = this.options.mask.toLowerCase();

    if (['phone', 'card', 'date', 'time', 'ssn', 'zip'].includes(mask)) {
      return value.replace(/\D/g, '');
    }

    return value.replace(/[^a-zA-Z0-9]/g, '');
  }

  _extractDigits(value) {
    return value.replace(/\D/g, '');
  }

  _calculateCursorPosition(oldPos, oldValue, newValue) {
    // Simple calculation - can be improved for better UX
    const diff = newValue.length - oldValue.length;
    return Math.max(0, Math.min(newValue.length, oldPos + diff));
  }

  _formatCurrency() {
    let value = this.element.value;

    // Remove all non-numeric except decimal
    value = value.replace(/[^\d.]/g, '');

    // Handle multiple decimals
    const parts = value.split('.');
    if (parts.length > 2) {
      value = parts[0] + '.' + parts.slice(1).join('');
    }

    // Parse and format
    if (value) {
      const numParts = value.split('.');
      let intPart = numParts[0];
      let decPart = numParts[1] || '';

      // Add thousands separators
      intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, this.options.thousandsSeparator);

      // Limit decimal places
      if (decPart.length > this.options.decimalPlaces) {
        decPart = decPart.substring(0, this.options.decimalPlaces);
      }

      value = intPart + (numParts.length > 1 ? this.options.decimalSeparator + decPart : '');
    }

    this.element.value = value;
    this._rawValue = value.replace(/[^\d.]/g, '');
  }

  _formatPercentage() {
    let value = this.element.value;

    // Remove all non-numeric except decimal
    value = value.replace(/[^\d.]/g, '');

    // Limit to 100 or configured max
    const num = parseFloat(value);
    if (!isNaN(num) && num > 100) {
      value = '100';
    }

    this.element.value = value;
    this._rawValue = value;
  }

  _isComplete() {
    if (!this._pattern) return true;

    const requiredLength = (this._pattern.match(/[#A*]/g) || []).length;
    return this._rawValue.length >= requiredLength;
  }

  _checkComplete() {
    const isComplete = this._isComplete();
    this.element.classList.toggle(SixOrbit.cls('mask-complete'), isComplete);
    this.element.classList.toggle(SixOrbit.cls('mask-incomplete'), !isComplete && this._rawValue.length > 0);
  }

  // Public methods
  getValue() {
    return this.element.value;
  }

  getRawValue() {
    return this._rawValue;
  }

  setValue(value) {
    this.element.value = value;
    this._handleInput();
  }

  clear() {
    this.element.value = '';
    this._rawValue = '';
    this._checkComplete();
  }

  static initAll() {
    document.querySelectorAll('[data-so-input-mask]').forEach(el => {
      if (!el._soInputMaskInstance) {
        el._soInputMaskInstance = new SOInputMask(el);
      }
    });
  }
}

// ============================================
// PASSWORD STRENGTH COMPONENT
// ============================================

/**
 * SOPasswordStrength - Password strength meter with requirements
 */
class SOPasswordStrength extends SOComponent {
  static NAME = 'password-strength';

  static DEFAULTS = {
    // Minimum password length
    minLength: 8,
    // Require uppercase
    requireUppercase: true,
    // Require lowercase
    requireLowercase: true,
    // Require numbers
    requireNumbers: true,
    // Require special characters
    requireSpecial: true,
    // Special characters regex
    specialChars: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/,
    // Show strength bar
    showBar: true,
    // Show requirements list
    showRequirements: false,
    // Show inline indicator
    showInline: false,
    // Strength labels
    labels: {
      weak: 'Weak',
      fair: 'Fair',
      good: 'Good',
      strong: 'Strong',
    },
    // Requirements labels
    requirementLabels: {
      length: 'At least {min} characters',
      uppercase: 'One uppercase letter',
      lowercase: 'One lowercase letter',
      number: 'One number',
      special: 'One special character',
    },
    // Score thresholds
    thresholds: {
      weak: 1,
      fair: 2,
      good: 3,
      strong: 4,
    },
  };

  static EVENTS = {
    CHANGE: 'password-strength:change',
    VALID: 'password-strength:valid',
    INVALID: 'password-strength:invalid',
  };

  _init() {
    this._score = 0;
    this._strength = 'none';
    this._requirements = {};

    this._createElements();
    this._bindEvents();

    // Check initial value
    if (this.element.value) {
      this._evaluate();
    }
  }

  _createElements() {
    // Check if already in an input-wrapper (with toggle button, etc.)
    const existingWrapper = this.element.parentElement;
    const isInInputWrapper = existingWrapper.classList.contains(SixOrbit.cls('input-wrapper'));

    if (isInInputWrapper) {
      // Use the existing input-wrapper and just add the password-wrapper class
      existingWrapper.classList.add(SixOrbit.cls('password-wrapper'));
      this._wrapper = existingWrapper;
    } else if (!existingWrapper.classList.contains(SixOrbit.cls('password-wrapper'))) {
      // Create a new wrapper only if not already wrapped
      const wrapper = document.createElement('div');
      wrapper.className = SixOrbit.cls('password-wrapper');
      this.element.parentNode.insertBefore(wrapper, this.element);
      wrapper.appendChild(this.element);
      this._wrapper = wrapper;
    } else {
      this._wrapper = existingWrapper;
    }

    // Create strength meter container
    if (this.options.showBar) {
      this._strengthContainer = document.createElement('div');
      this._strengthContainer.className = SixOrbit.cls('password-strength');
      this._strengthContainer.innerHTML = `
        <div class="${SixOrbit.cls('password-strength-bar')}">
          <div class="${SixOrbit.cls('password-strength-segment')}"></div>
          <div class="${SixOrbit.cls('password-strength-segment')}"></div>
          <div class="${SixOrbit.cls('password-strength-segment')}"></div>
          <div class="${SixOrbit.cls('password-strength-segment')}"></div>
        </div>
        <div class="${SixOrbit.cls('password-strength-text')}">
          <span class="${SixOrbit.cls('password-strength-label')}"></span>
          <span class="${SixOrbit.cls('password-strength-score')}"></span>
        </div>
      `;
      this._wrapper.insertAdjacentElement('afterend', this._strengthContainer);
      this._segments = this._strengthContainer.querySelectorAll(`.${SixOrbit.cls('password-strength-segment')}`);
      this._label = this._strengthContainer.querySelector(`.${SixOrbit.cls('password-strength-label')}`);
    }

    // Create inline indicator
    if (this.options.showInline) {
      this._inlineIndicator = document.createElement('div');
      this._inlineIndicator.className = SixOrbit.cls('password-strength-inline');
      this._inlineIndicator.innerHTML = `
        <span class="${SixOrbit.cls('strength-dot')}"></span>
        <span class="${SixOrbit.cls('strength-dot')}"></span>
        <span class="${SixOrbit.cls('strength-dot')}"></span>
        <span class="${SixOrbit.cls('strength-dot')}"></span>
      `;
      this._wrapper.appendChild(this._inlineIndicator);
      this._dots = this._inlineIndicator.querySelectorAll(`.${SixOrbit.cls('strength-dot')}`);
    }

    // Create requirements list
    if (this.options.showRequirements) {
      this._reqContainer = document.createElement('div');
      this._reqContainer.className = SixOrbit.cls('password-requirements');

      const requirements = [];
      if (this.options.minLength > 0) {
        requirements.push({ key: 'length', label: this.options.requirementLabels.length.replace('{min}', this.options.minLength) });
      }
      if (this.options.requireUppercase) {
        requirements.push({ key: 'uppercase', label: this.options.requirementLabels.uppercase });
      }
      if (this.options.requireLowercase) {
        requirements.push({ key: 'lowercase', label: this.options.requirementLabels.lowercase });
      }
      if (this.options.requireNumbers) {
        requirements.push({ key: 'number', label: this.options.requirementLabels.number });
      }
      if (this.options.requireSpecial) {
        requirements.push({ key: 'special', label: this.options.requirementLabels.special });
      }

      this._reqContainer.innerHTML = requirements.map(req => `
        <div class="${SixOrbit.cls('password-requirement')}" data-requirement="${req.key}">
          <span class="material-icons">radio_button_unchecked</span>
          <span>${req.label}</span>
        </div>
      `).join('');

      if (this._strengthContainer) {
        this._strengthContainer.insertAdjacentElement('afterend', this._reqContainer);
      } else {
        this._wrapper.insertAdjacentElement('afterend', this._reqContainer);
      }
    }
  }

  _bindEvents() {
    this.on('input', this._evaluate);
    this.on('focus', () => {
      if (this._strengthContainer) this._strengthContainer.style.display = '';
      if (this._reqContainer) this._reqContainer.style.display = '';
    });
  }

  _evaluate() {
    const password = this.element.value;
    this._score = 0;
    this._requirements = {};

    // Check length
    this._requirements.length = password.length >= this.options.minLength;
    if (this._requirements.length) this._score++;

    // Check uppercase
    this._requirements.uppercase = /[A-Z]/.test(password);
    if (this._requirements.uppercase && this.options.requireUppercase) this._score++;

    // Check lowercase
    this._requirements.lowercase = /[a-z]/.test(password);
    if (this._requirements.lowercase && this.options.requireLowercase) this._score++;

    // Check numbers
    this._requirements.number = /\d/.test(password);
    if (this._requirements.number && this.options.requireNumbers) this._score++;

    // Check special characters
    this._requirements.special = this.options.specialChars.test(password);
    if (this._requirements.special && this.options.requireSpecial) this._score++;

    // Determine strength level
    const { thresholds } = this.options;
    if (this._score <= thresholds.weak) {
      this._strength = 'weak';
    } else if (this._score <= thresholds.fair) {
      this._strength = 'fair';
    } else if (this._score <= thresholds.good) {
      this._strength = 'good';
    } else {
      this._strength = 'strong';
    }

    // Handle empty password
    if (password.length === 0) {
      this._strength = 'none';
      this._score = 0;
    }

    this._updateUI();
    this._emitEvents();
  }

  _updateUI() {
    const strengthClass = `${SixOrbit.cls('strength')}-${this._strength}`;

    // Update bar segments
    if (this._segments) {
      const activeCount = this._strength === 'none' ? 0 :
                         this._strength === 'weak' ? 1 :
                         this._strength === 'fair' ? 2 :
                         this._strength === 'good' ? 3 : 4;

      this._segments.forEach((segment, i) => {
        segment.classList.remove(
          SixOrbit.cls('active'),
          `${SixOrbit.cls('strength')}-weak`,
          `${SixOrbit.cls('strength')}-fair`,
          `${SixOrbit.cls('strength')}-good`,
          `${SixOrbit.cls('strength')}-strong`
        );

        if (i < activeCount) {
          segment.classList.add(SixOrbit.cls('active'), strengthClass);
        }
      });

      // Update label
      if (this._label) {
        this._label.textContent = this._strength === 'none' ? '' : this.options.labels[this._strength];
        this._label.className = `${SixOrbit.cls('password-strength-label')} ${strengthClass}`;
      }
    }

    // Update inline dots
    if (this._dots) {
      const activeCount = this._strength === 'none' ? 0 :
                         this._strength === 'weak' ? 1 :
                         this._strength === 'fair' ? 2 :
                         this._strength === 'good' ? 3 : 4;

      this._dots.forEach((dot, i) => {
        dot.classList.remove(
          SixOrbit.cls('active'),
          `${SixOrbit.cls('strength')}-weak`,
          `${SixOrbit.cls('strength')}-fair`,
          `${SixOrbit.cls('strength')}-good`,
          `${SixOrbit.cls('strength')}-strong`
        );

        if (i < activeCount) {
          dot.classList.add(SixOrbit.cls('active'), strengthClass);
        }
      });
    }

    // Update requirements
    if (this._reqContainer) {
      Object.keys(this._requirements).forEach(key => {
        const el = this._reqContainer.querySelector(`[data-requirement="${key}"]`);
        if (el) {
          const icon = el.querySelector('.material-icons');
          if (this._requirements[key]) {
            el.classList.add(SixOrbit.cls('met'));
            icon.textContent = 'check_circle';
          } else {
            el.classList.remove(SixOrbit.cls('met'));
            icon.textContent = 'radio_button_unchecked';
          }
        }
      });
    }
  }

  _emitEvents() {
    this.emit(SOPasswordStrength.EVENTS.CHANGE, {
      score: this._score,
      strength: this._strength,
      requirements: this._requirements,
    });

    const isValid = this._checkValidity();
    this.emit(isValid ? SOPasswordStrength.EVENTS.VALID : SOPasswordStrength.EVENTS.INVALID, {
      score: this._score,
      strength: this._strength,
      requirements: this._requirements,
    });
  }

  _checkValidity() {
    if (this.options.minLength > 0 && !this._requirements.length) return false;
    if (this.options.requireUppercase && !this._requirements.uppercase) return false;
    if (this.options.requireLowercase && !this._requirements.lowercase) return false;
    if (this.options.requireNumbers && !this._requirements.number) return false;
    if (this.options.requireSpecial && !this._requirements.special) return false;
    return true;
  }

  // Public methods
  getScore() {
    return this._score;
  }

  getStrength() {
    return this._strength;
  }

  getRequirements() {
    return { ...this._requirements };
  }

  isValid() {
    return this._checkValidity();
  }

  static initAll() {
    document.querySelectorAll('[data-so-password-strength]').forEach(el => {
      if (!el._soPasswordStrengthInstance) {
        el._soPasswordStrengthInstance = new SOPasswordStrength(el);
      }
    });
  }
}

// ============================================
// CHARACTER COUNTER COMPONENT
// ============================================

/**
 * SOCharCounter - Character/word counter for inputs and textareas
 */
class SOCharCounter extends SOComponent {
  static NAME = 'char-counter';

  static DEFAULTS = {
    // Max characters (0 = no limit, just count)
    maxLength: 0,
    // Min characters
    minLength: 0,
    // Count mode: 'characters', 'words', 'lines'
    mode: 'characters',
    // Warning threshold (percentage of max)
    warningThreshold: 80,
    // Show progress bar
    showBar: false,
    // Show inline (inside input)
    showInline: false,
    // Format template
    template: '{current} / {max}',
    // Template for no max
    templateNoMax: '{current} characters',
    // Word template
    wordTemplate: '{current} / {max} words',
    // Word template no max
    wordTemplateNoMax: '{current} words',
  };

  static EVENTS = {
    CHANGE: 'char-counter:change',
    WARNING: 'char-counter:warning',
    LIMIT: 'char-counter:limit',
    VALID: 'char-counter:valid',
  };

  _init() {
    this._count = 0;
    this._percentage = 0;

    this._createElements();
    this._bindEvents();

    // Initial count
    this._updateCount();
  }

  _createElements() {
    // Wrap if needed
    if (!this.element.parentElement.classList.contains(SixOrbit.cls('char-counter-wrapper'))) {
      const wrapper = document.createElement('div');
      wrapper.className = SixOrbit.cls('char-counter-wrapper');
      this.element.parentNode.insertBefore(wrapper, this.element);
      wrapper.appendChild(this.element);
    }

    this._wrapper = this.element.parentElement;

    if (this.options.showBar) {
      // Progress bar variant
      this._counterContainer = document.createElement('div');
      this._counterContainer.className = SixOrbit.cls('char-counter-bar');
      this._counterContainer.innerHTML = `
        <div class="${SixOrbit.cls('char-counter-progress')}">
          <div class="${SixOrbit.cls('char-counter-fill')}"></div>
        </div>
        <div class="${SixOrbit.cls('char-counter-text')}">
          <span class="${SixOrbit.cls('char-counter-hint')}"></span>
          <span class="${SixOrbit.cls('char-counter-value')}"></span>
        </div>
      `;
      this._wrapper.appendChild(this._counterContainer);
      this._fill = this._counterContainer.querySelector(`.${SixOrbit.cls('char-counter-fill')}`);
      this._valueEl = this._counterContainer.querySelector(`.${SixOrbit.cls('char-counter-value')}`);
    } else if (this.options.showInline) {
      // Inline variant (inside textarea)
      this._counterEl = document.createElement('span');
      this._counterEl.className = SixOrbit.cls('char-counter-inline');
      this._wrapper.appendChild(this._counterEl);
      this.element.classList.add(SixOrbit.cls('has-counter-inline'));
    } else {
      // Simple counter
      this._counterEl = document.createElement('div');
      this._counterEl.className = SixOrbit.cls('char-counter');
      this._wrapper.appendChild(this._counterEl);
    }
  }

  _bindEvents() {
    this.on('input', this._updateCount);
    this.on('paste', () => setTimeout(() => this._updateCount(), 0));
  }

  _updateCount() {
    const value = this.element.value;

    // Calculate count based on mode
    switch (this.options.mode) {
      case 'words':
        this._count = value.trim() ? value.trim().split(/\s+/).length : 0;
        break;
      case 'lines':
        this._count = value.split(/\r\n|\r|\n/).length;
        break;
      default:
        this._count = value.length;
    }

    // Calculate percentage
    if (this.options.maxLength > 0) {
      this._percentage = (this._count / this.options.maxLength) * 100;
    } else {
      this._percentage = 0;
    }

    this._updateUI();
    this._emitEvents();
  }

  _updateUI() {
    const { maxLength, warningThreshold, mode } = this.options;
    const isWarning = maxLength > 0 && this._percentage >= warningThreshold && this._percentage < 100;
    const isDanger = maxLength > 0 && this._percentage >= 100;
    const isSuccess = maxLength > 0 && this._count >= (this.options.minLength || 0) && this._percentage < warningThreshold;

    // Format text
    let text;
    if (maxLength > 0) {
      text = mode === 'words'
        ? this.options.wordTemplate.replace('{current}', this._count).replace('{max}', maxLength)
        : this.options.template.replace('{current}', this._count).replace('{max}', maxLength);
    } else {
      text = mode === 'words'
        ? this.options.wordTemplateNoMax.replace('{current}', this._count)
        : this.options.templateNoMax.replace('{current}', this._count);
    }

    // Update progress bar variant
    if (this._fill) {
      this._fill.style.width = `${Math.min(100, this._percentage)}%`;
      this._fill.classList.remove(SixOrbit.cls('warning'), SixOrbit.cls('danger'));
      if (isDanger) {
        this._fill.classList.add(SixOrbit.cls('danger'));
      } else if (isWarning) {
        this._fill.classList.add(SixOrbit.cls('warning'));
      }

      if (this._valueEl) {
        this._valueEl.textContent = text;
      }
    }

    // Update simple/inline counter
    if (this._counterEl) {
      this._counterEl.textContent = text;
      this._counterEl.classList.remove(
        SixOrbit.cls('warning'),
        SixOrbit.cls('danger'),
        SixOrbit.cls('success')
      );

      if (isDanger) {
        this._counterEl.classList.add(SixOrbit.cls('danger'));
      } else if (isWarning) {
        this._counterEl.classList.add(SixOrbit.cls('warning'));
      } else if (isSuccess) {
        this._counterEl.classList.add(SixOrbit.cls('success'));
      }
    }
  }

  _emitEvents() {
    const { maxLength, warningThreshold } = this.options;

    this.emit(SOCharCounter.EVENTS.CHANGE, {
      count: this._count,
      percentage: this._percentage,
      remaining: maxLength > 0 ? maxLength - this._count : null,
    });

    if (maxLength > 0) {
      if (this._percentage >= 100) {
        this.emit(SOCharCounter.EVENTS.LIMIT, {
          count: this._count,
          max: maxLength,
        });
      } else if (this._percentage >= warningThreshold) {
        this.emit(SOCharCounter.EVENTS.WARNING, {
          count: this._count,
          percentage: this._percentage,
        });
      } else {
        this.emit(SOCharCounter.EVENTS.VALID, {
          count: this._count,
          percentage: this._percentage,
        });
      }
    }
  }

  // Public methods
  getCount() {
    return this._count;
  }

  getPercentage() {
    return this._percentage;
  }

  getRemaining() {
    return this.options.maxLength > 0 ? this.options.maxLength - this._count : null;
  }

  setMaxLength(max) {
    this.options.maxLength = max;
    this._updateCount();
  }

  static initAll() {
    document.querySelectorAll('[data-so-char-counter]').forEach(el => {
      if (!el._soCharCounterInstance) {
        el._soCharCounterInstance = new SOCharCounter(el);
      }
    });
  }
}

// ============================================
// INPUT CLEAR BUTTON COMPONENT
// ============================================

/**
 * SOInputClear - Clear button (X) for inputs
 */
class SOInputClear extends SOComponent {
  static NAME = 'input-clear';

  static DEFAULTS = {
    // Icon to show
    icon: 'close',
    // Show only when input has value
    showOnValue: true,
    // Focus input after clear
    focusAfterClear: true,
    // Callback before clear (return false to prevent)
    onBeforeClear: null,
    // Callback after clear
    onClear: null,
  };

  static EVENTS = {
    CLEAR: 'input-clear:clear',
    BEFORE_CLEAR: 'input-clear:before-clear',
  };

  _init() {
    this._createButton();
    this._bindEvents();
    this._updateVisibility();
  }

  _createButton() {
    // Wrap input if needed
    if (!this.element.parentElement.classList.contains(SixOrbit.cls('input-clearable'))) {
      const wrapper = document.createElement('div');
      wrapper.className = SixOrbit.cls('input-clearable');

      // Check for existing icon
      const existingWrapper = this.element.closest(`.${SixOrbit.cls('input-wrapper')}`);
      if (existingWrapper && existingWrapper.querySelector(`.${SixOrbit.cls('input-icon')}`)) {
        wrapper.classList.add(SixOrbit.cls('has-icon'));
      }

      // Check for existing action
      if (existingWrapper && existingWrapper.querySelector(`.${SixOrbit.cls('input-action')}`)) {
        wrapper.classList.add(SixOrbit.cls('has-action'));
      }

      this.element.parentNode.insertBefore(wrapper, this.element);
      wrapper.appendChild(this.element);
    }

    this._wrapper = this.element.parentElement;

    // Create clear button
    this._button = document.createElement('button');
    this._button.type = 'button';
    this._button.className = SixOrbit.cls('input-clear-btn');
    this._button.setAttribute('tabindex', '-1');
    this._button.setAttribute('aria-label', 'Clear input');
    this._button.innerHTML = `<span class="material-icons">${this.options.icon}</span>`;

    this._wrapper.appendChild(this._button);
  }

  _bindEvents() {
    // Clear on button click
    this._button.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      this.clear();
    });

    // Update visibility on input
    this.on('input', this._updateVisibility);
    this.on('change', this._updateVisibility);

    // Handle escape key
    this.on('keydown', (e) => {
      if (e.key === 'Escape' && this.element.value) {
        e.preventDefault();
        this.clear();
      }
    });
  }

  _updateVisibility() {
    const hasValue = this.element.value.length > 0;
    this.element.setAttribute('data-has-value', hasValue);

    if (this.options.showOnValue) {
      this._button.style.display = hasValue ? 'flex' : 'none';
    }
  }

  clear() {
    // Before clear callback
    if (typeof this.options.onBeforeClear === 'function') {
      const result = this.options.onBeforeClear(this.element.value, this);
      if (result === false) return;
    }

    // Emit before clear event
    const beforeEvent = this.emit(SOInputClear.EVENTS.BEFORE_CLEAR, {
      value: this.element.value,
    });

    if (!beforeEvent) return;

    // Clear the input
    const oldValue = this.element.value;
    this.element.value = '';

    // Trigger input event for other listeners
    this.element.dispatchEvent(new Event('input', { bubbles: true }));
    this.element.dispatchEvent(new Event('change', { bubbles: true }));

    // Update visibility
    this._updateVisibility();

    // Focus input
    if (this.options.focusAfterClear) {
      this.element.focus();
    }

    // After clear callback
    if (typeof this.options.onClear === 'function') {
      this.options.onClear(oldValue, this);
    }

    // Emit clear event
    this.emit(SOInputClear.EVENTS.CLEAR, {
      previousValue: oldValue,
    });
  }

  // Public methods
  showButton() {
    this._button.style.display = 'flex';
  }

  hideButton() {
    this._button.style.display = 'none';
  }

  static initAll() {
    document.querySelectorAll('[data-so-input-clear]').forEach(el => {
      if (!el._soInputClearInstance) {
        el._soInputClearInstance = new SOInputClear(el);
      }
    });
  }
}

// ============================================
// AUTO-INITIALIZATION
// ============================================

function initAllFormEnhancers() {
  SOInputMask.initAll();
  SOPasswordStrength.initAll();
  SOCharCounter.initAll();
  SOInputClear.initAll();
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initAllFormEnhancers);
} else {
  initAllFormEnhancers();
}

// Mutation observer for dynamic content
const formEnhancersObserver = new MutationObserver((mutations) => {
  let shouldInit = false;

  mutations.forEach(mutation => {
    mutation.addedNodes.forEach(node => {
      if (node.nodeType === Node.ELEMENT_NODE) {
        if (node.matches('[data-so-input-mask], [data-so-password-strength], [data-so-char-counter], [data-so-input-clear]')) {
          shouldInit = true;
        }
        if (node.querySelector('[data-so-input-mask], [data-so-password-strength], [data-so-char-counter], [data-so-input-clear]')) {
          shouldInit = true;
        }
      }
    });
  });

  if (shouldInit) {
    initAllFormEnhancers();
  }
});

formEnhancersObserver.observe(document.body, { childList: true, subtree: true });

// Register components
SixOrbit.registerComponent(SOInputMask);
SixOrbit.registerComponent(SOPasswordStrength);
SixOrbit.registerComponent(SOCharCounter);
SixOrbit.registerComponent(SOInputClear);

// Export
export {
  SOInputMask,
  SOPasswordStrength,
  SOCharCounter,
  SOInputClear,
  initAllFormEnhancers,
};

export default {
  SOInputMask,
  SOPasswordStrength,
  SOCharCounter,
  SOInputClear,
  initAll: initAllFormEnhancers,
};
