// ============================================
// SIXORBIT UI ENGINE - VALIDATION RULES
// Built-in validation rules matching PHP Validator
// ============================================

/**
 * Check if value is empty
 * @param {*} value
 * @returns {boolean}
 */
const isEmpty = (value) => {
    if (value === null || value === undefined) return true;
    if (typeof value === 'string') return value.trim() === '';
    if (Array.isArray(value)) return value.length === 0;
    if (typeof value === 'object') return Object.keys(value).length === 0;
    return false;
};

/**
 * Built-in validation rules
 */
export const rules = {
    // ==================
    // Required Rules
    // ==================

    required: {
        validator: (value) => !isEmpty(value),
        message: 'This field is required.'
    },

    accepted: {
        validator: (value) => ['yes', 'on', '1', 1, true, 'true'].includes(value),
        message: 'This field must be accepted.'
    },

    // ==================
    // Type Rules
    // ==================

    email: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        },
        message: 'Please enter a valid email address.'
    },

    url: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            try {
                new URL(value);
                return true;
            } catch {
                return /^https?:\/\/.+/.test(value);
            }
        },
        message: 'Please enter a valid URL.'
    },

    numeric: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            return /^-?\d*\.?\d+$/.test(String(value));
        },
        message: 'Please enter a number.'
    },

    integer: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            return /^-?\d+$/.test(String(value));
        },
        message: 'Please enter a whole number.'
    },

    alpha: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            return /^[a-zA-Z]+$/.test(value);
        },
        message: 'Only letters are allowed.'
    },

    alpha_num: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            return /^[a-zA-Z0-9]+$/.test(value);
        },
        message: 'Only letters and numbers are allowed.'
    },

    alpha_dash: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            return /^[a-zA-Z0-9_-]+$/.test(value);
        },
        message: 'Only letters, numbers, dashes and underscores are allowed.'
    },

    // ==================
    // Size Rules
    // ==================

    min: {
        validator: (value, min) => {
            if (isEmpty(value)) return true;
            const minVal = parseInt(min, 10);

            // For numeric values, compare as numbers
            if (!isNaN(Number(value))) {
                return Number(value) >= minVal;
            }

            // For strings, compare length
            return String(value).length >= minVal;
        },
        message: 'Must be at least :min characters.'
    },

    max: {
        validator: (value, max) => {
            if (isEmpty(value)) return true;
            const maxVal = parseInt(max, 10);

            // For numeric values, compare as numbers
            if (!isNaN(Number(value))) {
                return Number(value) <= maxVal;
            }

            // For strings, compare length
            return String(value).length <= maxVal;
        },
        message: 'Must not exceed :max characters.'
    },

    between: {
        validator: (value, params) => {
            if (isEmpty(value)) return true;
            const [min, max] = Array.isArray(params) ? params : [params, params];
            const minVal = parseInt(min, 10);
            const maxVal = parseInt(max, 10);

            // For numeric values
            if (!isNaN(Number(value))) {
                const numVal = Number(value);
                return numVal >= minVal && numVal <= maxVal;
            }

            // For strings, compare length
            const len = String(value).length;
            return len >= minVal && len <= maxVal;
        },
        message: 'Must be between :min and :max.'
    },

    size: {
        validator: (value, size) => {
            if (isEmpty(value)) return true;
            const sizeVal = parseInt(size, 10);

            if (!isNaN(Number(value))) {
                return Number(value) === sizeVal;
            }

            return String(value).length === sizeVal;
        },
        message: 'Must be exactly :value characters.'
    },

    digits: {
        validator: (value, length) => {
            if (isEmpty(value)) return true;
            const len = parseInt(length, 10);
            return /^\d+$/.test(value) && String(value).length === len;
        },
        message: 'Must be exactly :value digits.'
    },

    digits_between: {
        validator: (value, params) => {
            if (isEmpty(value)) return true;
            const [min, max] = Array.isArray(params) ? params : [params, params];
            if (!/^\d+$/.test(value)) return false;
            const len = String(value).length;
            return len >= parseInt(min, 10) && len <= parseInt(max, 10);
        },
        message: 'Must be between :min and :max digits.'
    },

    // ==================
    // Pattern Rules
    // ==================

    regex: {
        validator: (value, pattern) => {
            if (isEmpty(value)) return true;
            const regex = pattern instanceof RegExp ? pattern : new RegExp(pattern);
            return regex.test(value);
        },
        message: 'The format is invalid.'
    },

    // ==================
    // Comparison Rules
    // ==================

    in: {
        validator: (value, allowedValues) => {
            if (isEmpty(value)) return true;
            const values = Array.isArray(allowedValues)
                ? allowedValues
                : String(allowedValues).split(',');
            return values.map(v => String(v).trim()).includes(String(value));
        },
        message: 'Please select a valid option.'
    },

    not_in: {
        validator: (value, disallowedValues) => {
            if (isEmpty(value)) return true;
            const values = Array.isArray(disallowedValues)
                ? disallowedValues
                : String(disallowedValues).split(',');
            return !values.map(v => String(v).trim()).includes(String(value));
        },
        message: 'The selected value is not allowed.'
    },

    confirmed: {
        validator: (value, fieldName, element) => {
            if (isEmpty(value)) return true;

            // Find confirmation field
            const name = element.name || (element.getName ? element.getName() : '');
            const confirmationName = `${name}_confirmation`;

            // Try to find in DOM
            let confirmField = document.querySelector(`[name="${confirmationName}"]`);

            // Or find in parent form
            if (!confirmField && element.form) {
                confirmField = element.form.elements[confirmationName];
            }

            if (!confirmField) return true;

            return value === confirmField.value;
        },
        message: 'The confirmation does not match.'
    },

    same: {
        validator: (value, otherField, element) => {
            if (isEmpty(value)) return true;

            let otherValue;
            if (element.form) {
                const other = element.form.elements[otherField];
                otherValue = other ? other.value : null;
            } else {
                const other = document.querySelector(`[name="${otherField}"]`);
                otherValue = other ? other.value : null;
            }

            return value === otherValue;
        },
        message: 'This field must match :other.'
    },

    different: {
        validator: (value, otherField, element) => {
            if (isEmpty(value)) return true;

            let otherValue;
            if (element.form) {
                const other = element.form.elements[otherField];
                otherValue = other ? other.value : null;
            } else {
                const other = document.querySelector(`[name="${otherField}"]`);
                otherValue = other ? other.value : null;
            }

            return value !== otherValue;
        },
        message: 'This field must be different from :other.'
    },

    // ==================
    // Date Rules
    // ==================

    date: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            const date = new Date(value);
            return !isNaN(date.getTime());
        },
        message: 'Please enter a valid date.'
    },

    before: {
        validator: (value, beforeDate) => {
            if (isEmpty(value)) return true;
            const date = new Date(value);
            const before = new Date(beforeDate);
            return date < before;
        },
        message: 'Must be a date before :value.'
    },

    after: {
        validator: (value, afterDate) => {
            if (isEmpty(value)) return true;
            const date = new Date(value);
            const after = new Date(afterDate);
            return date > after;
        },
        message: 'Must be a date after :value.'
    },

    // ==================
    // Custom Validators
    // ==================

    phone: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            // Basic phone validation - allows various formats
            return /^[\d\s\-\+\(\)]{7,20}$/.test(value);
        },
        message: 'Please enter a valid phone number.'
    },

    credit_card: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            // Luhn algorithm
            const digits = String(value).replace(/\D/g, '');
            if (digits.length < 13 || digits.length > 19) return false;

            let sum = 0;
            let isEven = false;

            for (let i = digits.length - 1; i >= 0; i--) {
                let digit = parseInt(digits[i], 10);
                if (isEven) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                }
                sum += digit;
                isEven = !isEven;
            }

            return sum % 10 === 0;
        },
        message: 'Please enter a valid credit card number.'
    },

    json: {
        validator: (value) => {
            if (isEmpty(value)) return true;
            try {
                JSON.parse(value);
                return true;
            } catch {
                return false;
            }
        },
        message: 'Must be valid JSON.'
    }
};

export default rules;
