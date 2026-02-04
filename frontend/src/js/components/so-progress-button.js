// ============================================
// SIXORBIT UI - PROGRESS BUTTON COMPONENT
// Buttons with progress indicator and state management
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOProgressButton - Progress button component
 * Provides programmatic control over button progress states
 */
class SOProgressButton extends SOComponent {
  static NAME = 'progressButton';

  static DEFAULTS = {
    autoDisable: true,          // Disable button during progress
    autoReset: false,           // Auto reset after complete (ms, 0 = disabled)
    simulateOnClick: false,     // Auto-simulate progress on click
    simulateSpeed: 150,         // Interval for simulated progress (ms)
    simulateIncrement: [5, 15], // Random increment range [min, max]
  };

  static EVENTS = {
    START: 'progress:start',
    PROGRESS: 'progress:update',
    COMPLETE: 'progress:complete',
    RESET: 'progress:reset',
  };

  static STATES = {
    IDLE: 'idle',
    PROGRESSING: 'progressing',
    COMPLETED: 'completed',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  /**
   * Initialize the progress button component
   * @private
   */
  _init() {
    // Current state
    this._state = SOProgressButton.STATES.IDLE;
    this._progress = 0;
    this._simulateInterval = null;

    // Cache elements
    this._progressBar = this.$('.so-btn-progress-bar');
    this._textEl = this.$('.so-btn-text');
    this._startEl = this.$('.so-btn-start');
    this._doneEl = this.$('.so-btn-done');

    // Parse options from data attributes
    this._parseDataOptions();

    // Bind events
    this._bindEvents();
  }

  /**
   * Parse additional data attributes
   * @private
   */
  _parseDataOptions() {
    const el = this.element;

    if (el.dataset.autoDisable !== undefined) {
      this.options.autoDisable = el.dataset.autoDisable !== 'false';
    }
    if (el.dataset.autoReset !== undefined) {
      this.options.autoReset = parseInt(el.dataset.autoReset, 10) || 0;
    }
    if (el.dataset.simulateOnClick !== undefined) {
      this.options.simulateOnClick = el.dataset.simulateOnClick === 'true';
    }
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Click handler for simulate mode
    if (this.options.simulateOnClick) {
      this.on('click', this._handleClick);
    }
  }

  /**
   * Handle click for simulate mode
   * @param {Event} e - Click event
   * @private
   */
  _handleClick(e) {
    if (this._state === SOProgressButton.STATES.COMPLETED) {
      this.reset();
    } else if (this._state === SOProgressButton.STATES.IDLE) {
      this.simulate();
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Start progress (enter progressing state)
   * @param {number} [initialProgress=0] - Initial progress value (0-100)
   * @returns {this} For chaining
   */
  start(initialProgress = 0) {
    if (this._state === SOProgressButton.STATES.PROGRESSING) {
      return this;
    }

    this._state = SOProgressButton.STATES.PROGRESSING;
    this._progress = Math.max(0, Math.min(100, initialProgress));

    // Update UI
    this.element.classList.add('so-progressing');
    this.element.classList.remove('so-completed');
    this._updateProgressBar();

    // Disable if configured
    if (this.options.autoDisable) {
      this.element.disabled = true;
    }

    // Emit event
    this.emit(SOProgressButton.EVENTS.START, {
      progress: this._progress,
      state: this._state,
    });

    return this;
  }

  /**
   * Set progress value
   * @param {number} value - Progress value (0-100)
   * @returns {this} For chaining
   */
  setProgress(value) {
    // Auto-start if not progressing
    if (this._state === SOProgressButton.STATES.IDLE) {
      this.start(value);
      return this;
    }

    if (this._state !== SOProgressButton.STATES.PROGRESSING) {
      return this;
    }

    const oldProgress = this._progress;
    this._progress = Math.max(0, Math.min(100, value));
    this._updateProgressBar();

    // Emit event
    this.emit(SOProgressButton.EVENTS.PROGRESS, {
      progress: this._progress,
      previousProgress: oldProgress,
      state: this._state,
    });

    // Auto-complete at 100%
    if (this._progress >= 100) {
      this._doComplete();
    }

    return this;
  }

  /**
   * Increment progress by a value
   * @param {number} amount - Amount to increment
   * @returns {this} For chaining
   */
  increment(amount) {
    return this.setProgress(this._progress + amount);
  }

  /**
   * Complete the progress (enter completed state)
   * @returns {this} For chaining
   */
  complete() {
    if (this._state === SOProgressButton.STATES.COMPLETED) {
      return this;
    }

    // Stop any simulation
    this._stopSimulation();

    // Set to 100% first
    this._progress = 100;
    this._updateProgressBar();

    // Small delay for visual feedback, then complete
    setTimeout(() => this._doComplete(), 200);

    return this;
  }

  /**
   * Internal complete handler
   * @private
   */
  _doComplete() {
    this._state = SOProgressButton.STATES.COMPLETED;

    // Update UI
    this.element.classList.remove('so-progressing');
    this.element.classList.add('so-completed');

    // Re-enable button
    if (this.options.autoDisable) {
      this.element.disabled = false;
    }

    // Emit event
    this.emit(SOProgressButton.EVENTS.COMPLETE, {
      progress: 100,
      state: this._state,
    });

    // Auto-reset if configured
    if (this.options.autoReset > 0) {
      setTimeout(() => this.reset(), this.options.autoReset);
    }
  }

  /**
   * Reset to initial state
   * @returns {this} For chaining
   */
  reset() {
    // Stop any simulation
    this._stopSimulation();

    this._state = SOProgressButton.STATES.IDLE;
    this._progress = 0;

    // Update UI
    this.element.classList.remove('so-progressing', 'so-completed');
    this._updateProgressBar();

    // Re-enable button
    this.element.disabled = false;

    // Emit event
    this.emit(SOProgressButton.EVENTS.RESET, {
      progress: 0,
      state: this._state,
    });

    return this;
  }

  /**
   * Simulate progress automatically
   * @param {Object} [options] - Simulation options
   * @param {number} [options.speed] - Interval in ms
   * @param {number[]} [options.increment] - [min, max] random increment
   * @returns {this} For chaining
   */
  simulate(options = {}) {
    const speed = options.speed || this.options.simulateSpeed;
    const [minInc, maxInc] = options.increment || this.options.simulateIncrement;

    // Start progress
    this.start(0);

    // Run simulation
    this._simulateInterval = setInterval(() => {
      const increment = Math.random() * (maxInc - minInc) + minInc;
      const newProgress = this._progress + increment;

      if (newProgress >= 100) {
        this._stopSimulation();
        this.setProgress(100);
      } else {
        this.setProgress(newProgress);
      }
    }, speed);

    return this;
  }

  /**
   * Stop simulation
   * @private
   */
  _stopSimulation() {
    if (this._simulateInterval) {
      clearInterval(this._simulateInterval);
      this._simulateInterval = null;
    }
  }

  /**
   * Update progress bar CSS
   * @private
   */
  _updateProgressBar() {
    this.element.style.setProperty('--progress', `${this._progress}%`);
  }

  // ============================================
  // GETTERS
  // ============================================

  /**
   * Get current progress value
   * @returns {number} Progress (0-100)
   */
  getProgress() {
    return this._progress;
  }

  /**
   * Get current state
   * @returns {string} Current state (idle, progressing, completed)
   */
  getState() {
    return this._state;
  }

  /**
   * Check if button is progressing
   * @returns {boolean}
   */
  isProgressing() {
    return this._state === SOProgressButton.STATES.PROGRESSING;
  }

  /**
   * Check if button is completed
   * @returns {boolean}
   */
  isCompleted() {
    return this._state === SOProgressButton.STATES.COMPLETED;
  }

  /**
   * Check if button is idle
   * @returns {boolean}
   */
  isIdle() {
    return this._state === SOProgressButton.STATES.IDLE;
  }

  // ============================================
  // CONTENT MANIPULATION
  // ============================================

  /**
   * Set the main text content
   * @param {string} html - HTML content
   * @returns {this} For chaining
   */
  setText(html) {
    if (this._textEl) {
      this._textEl.innerHTML = html;
    }
    return this;
  }

  /**
   * Set the start content (shown during progress)
   * @param {string} html - HTML content
   * @returns {this} For chaining
   */
  setStartContent(html) {
    if (this._startEl) {
      this._startEl.innerHTML = html;
    }
    return this;
  }

  /**
   * Set the done content (shown on complete)
   * @param {string} html - HTML content
   * @returns {this} For chaining
   */
  setDoneContent(html) {
    if (this._doneEl) {
      this._doneEl.innerHTML = html;
    }
    return this;
  }

  // ============================================
  // LIFECYCLE
  // ============================================

  /**
   * Destroy the component
   */
  destroy() {
    this._stopSimulation();
    this.reset();
    super.destroy();
  }
}

// Register component
SOProgressButton.register();

// Auto-initialize progress buttons with data attribute
document.addEventListener('DOMContentLoaded', () => {
  SOProgressButton.initAll('.so-btn-progress[data-so-progress]');
});

// Expose to global scope
window.SOProgressButton = SOProgressButton;

// Export for ES modules
export default SOProgressButton;
export { SOProgressButton };
