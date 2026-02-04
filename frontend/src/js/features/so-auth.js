// ============================================
// SIXORBIT UI - AUTHENTICATION FEATURE
// Login, password reset, and auth carousel
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';
import { SOForms } from './so-forms.js';
import { SOOtpInput } from '../components/so-otp.js';

/**
 * SOFeatureCarousel - Feature carousel for auth pages
 */
class SOFeatureCarousel extends SOComponent {
  static NAME = 'feature-carousel';

  static DEFAULTS = {
    interval: 5000,
    pauseOnHover: true,
    features: [],
  };

  static EVENTS = {
    CHANGE: 'carousel:change',
  };

  /**
   * Initialize the carousel
   * @private
   */
  _init() {
    this._slidesContainer = this.$('#featureSlides, .so-feature-slides');
    this._dotsContainer = this.$('#featureDots, .so-feature-dots');

    if (!this._slidesContainer) return;

    this._currentIndex = 0;
    this._timer = null;
    this._isPaused = false;
    this._slides = [];
    this._dots = [];

    // Render if features provided
    if (this.options.features.length > 0) {
      this._render();
    } else {
      this._cacheElements();
    }

    this._bindEvents();
    this._showSlide(0);
    this._startAutoRotate();
  }

  /**
   * Cache existing DOM elements
   * @private
   */
  _cacheElements() {
    this._slides = this.$$('.so-feature-slide');
    this._dots = this.$$('.so-feature-dot');
  }

  /**
   * Render slides and dots from features data
   * @private
   */
  _render() {
    // Render slides
    this._slidesContainer.innerHTML = this.options.features.map((feature, index) => `
      <div class="so-feature-slide" data-index="${index}">
        <div class="so-feature-slide-content">
          <div class="so-feature-icon">
            <span class="material-icons">${feature.icon}</span>
          </div>
          <div class="so-feature-title">${feature.title}</div>
          <div class="so-feature-description">${feature.description}</div>
        </div>
      </div>
    `).join('');

    // Render dots
    if (this._dotsContainer) {
      this._dotsContainer.innerHTML = this.options.features.map((_, index) => `
        <button class="so-feature-dot" data-index="${index}" aria-label="Go to slide ${index + 1}"></button>
      `).join('');
    }

    this._cacheElements();
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Dot clicks
    this._dots.forEach(dot => {
      this.on('click', () => {
        const index = parseInt(dot.dataset.index, 10);
        this._showSlide(index);
        this._resetAutoRotate();
      }, dot);
    });

    // Pause on hover
    if (this.options.pauseOnHover) {
      this.on('mouseenter', () => {
        this._isPaused = true;
        this._stopAutoRotate();
      });

      this.on('mouseleave', () => {
        this._isPaused = false;
        this._startAutoRotate();
      });
    }
  }

  /**
   * Show a specific slide
   * @param {number} index - Slide index
   * @private
   */
  _showSlide(index) {
    const prevIndex = this._currentIndex;
    this._currentIndex = index;

    // Update slides
    this._slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });

    // Update dots
    this._dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });

    this.emit(SOFeatureCarousel.EVENTS.CHANGE, {
      index,
      previousIndex: prevIndex,
    });
  }

  /**
   * Go to next slide
   * @private
   */
  _nextSlide() {
    const nextIndex = (this._currentIndex + 1) % this._slides.length;
    this._showSlide(nextIndex);
  }

  /**
   * Start auto-rotation
   * @private
   */
  _startAutoRotate() {
    if (this._isPaused || this._slides.length <= 1) return;

    this._stopAutoRotate();
    this._timer = setInterval(() => {
      this._nextSlide();
    }, this.options.interval);
  }

  /**
   * Stop auto-rotation
   * @private
   */
  _stopAutoRotate() {
    if (this._timer) {
      clearInterval(this._timer);
      this._timer = null;
    }
  }

  /**
   * Reset auto-rotation timer
   * @private
   */
  _resetAutoRotate() {
    this._stopAutoRotate();
    if (!this._isPaused) {
      this._startAutoRotate();
    }
  }

  // Public methods

  /**
   * Go to a specific slide
   * @param {number} index - Slide index
   * @returns {this} For chaining
   */
  goTo(index) {
    this._showSlide(index);
    this._resetAutoRotate();
    return this;
  }

  /**
   * Go to next slide
   * @returns {this} For chaining
   */
  next() {
    this._nextSlide();
    this._resetAutoRotate();
    return this;
  }

  /**
   * Go to previous slide
   * @returns {this} For chaining
   */
  prev() {
    const prevIndex = (this._currentIndex - 1 + this._slides.length) % this._slides.length;
    this._showSlide(prevIndex);
    this._resetAutoRotate();
    return this;
  }

  /**
   * Pause auto-rotation
   * @returns {this} For chaining
   */
  pause() {
    this._isPaused = true;
    this._stopAutoRotate();
    return this;
  }

  /**
   * Resume auto-rotation
   * @returns {this} For chaining
   */
  resume() {
    this._isPaused = false;
    this._startAutoRotate();
    return this;
  }

  destroy() {
    this._stopAutoRotate();
    super.destroy();
  }
}

/**
 * SOAuth - Authentication pages controller
 */
class SOAuth {
  constructor(config = {}) {
    this.config = {
      customerName: config.customerName || 'Customer',
      customerLogo: config.customerLogo || null,
      customerInitials: config.customerInitials || 'C',
      features: config.features || [],
      carouselInterval: config.carouselInterval || 5000,
      onLogin: config.onLogin || null,
      onForgotPassword: config.onForgotPassword || null,
      ...config,
    };

    this._init();
  }

  _init() {
    // Initialize feature carousel
    const carouselEl = document.getElementById('featureCarousel');
    if (carouselEl) {
      this.carousel = new SOFeatureCarousel(carouselEl, {
        features: this.config.features,
        interval: this.config.carouselInterval,
      });
    }

    // Setup customer branding
    this._setupBranding();

    // Initialize login form
    this._initLoginForm();

    // Initialize forgot password flow
    this._initForgotPassword();

    // Initialize OTP inputs
    this._initOtpInputs();
  }

  /**
   * Setup customer branding
   * @private
   */
  _setupBranding() {
    // Customer name
    const nameEl = document.getElementById('customerName');
    if (nameEl && this.config.customerName) {
      nameEl.textContent = this.config.customerName;
    }

    // Customer logo
    const logoImg = document.getElementById('customerLogoImg');
    const logoPlaceholder = document.getElementById('customerLogoPlaceholder');
    const initialsEl = document.getElementById('customerInitials');

    if (this.config.customerLogo && logoImg && logoPlaceholder) {
      logoImg.src = this.config.customerLogo;
      logoImg.style.display = 'block';
      logoPlaceholder.style.display = 'none';

      logoImg.onerror = () => {
        logoImg.style.display = 'none';
        logoPlaceholder.style.display = 'flex';
      };
    } else if (initialsEl && this.config.customerInitials) {
      initialsEl.textContent = this.config.customerInitials;
    }
  }

  /**
   * Initialize login form
   * @private
   */
  _initLoginForm() {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const loginIdInput = document.getElementById('loginId');
    const passwordInput = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const toggleBtns = document.querySelectorAll('.so-auth-type-btn');

    let loginType = 'email';

    // Login type toggle
    toggleBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        toggleBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        loginType = btn.dataset.type;

        const group = document.getElementById('loginIdGroup');
        const iconWrapper = document.getElementById('loginIdIcon');
        const iconEl = iconWrapper?.querySelector('.material-icons');
        const label = group?.querySelector('.so-form-label');

        if (loginType === 'email') {
          if (label) label.textContent = 'Email Address';
          loginIdInput.type = 'email';
          loginIdInput.placeholder = 'Enter your email address';
          if (iconEl) iconEl.textContent = 'email';
        } else {
          if (label) label.textContent = 'Mobile Number';
          loginIdInput.type = 'tel';
          loginIdInput.placeholder = 'Enter your mobile number';
          if (iconEl) iconEl.textContent = 'phone';
        }

        SOForms.clearError('loginId');
        loginIdInput.value = '';
        loginIdInput.focus();
      });
    });

    // Password toggle
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword && passwordInput) {
      togglePassword.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        togglePassword.querySelector('.material-icons').textContent = isPassword ? 'visibility_off' : 'visibility';
      });
    }

    // Form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      SOForms.clearError('loginId');
      SOForms.clearError('password');

      const loginId = loginIdInput.value.trim();
      const password = passwordInput.value;
      let isValid = true;

      // Validate
      if (!loginId) {
        SOForms.showError('loginId', loginType === 'email' ? 'Email address is required' : 'Mobile number is required');
        isValid = false;
      } else if (loginType === 'email' && !SOForms.validateEmail(loginId)) {
        SOForms.showError('loginId', 'Please enter a valid email address');
        isValid = false;
      } else if (loginType === 'mobile' && !SOForms.validatePhone(loginId)) {
        SOForms.showError('loginId', 'Please enter a valid 10-digit mobile number');
        isValid = false;
      }

      if (!password) {
        SOForms.showError('password', 'Password is required');
        isValid = false;
      } else if (password.length < 6) {
        SOForms.showError('password', 'Password must be at least 6 characters');
        isValid = false;
      }

      if (!isValid) return;

      // Call login handler
      if (this.config.onLogin) {
        SOForms.setButtonLoading(loginBtn, true);
        this.config.onLogin({ loginId, password, loginType });
      }
    });

    // Load remembered credentials
    this._loadRememberedCredentials(loginIdInput);
  }

  /**
   * Load remembered credentials
   * @param {HTMLInputElement} loginIdInput - Login input element
   * @private
   */
  _loadRememberedCredentials(loginIdInput) {
    try {
      const saved = SixOrbit.getStorage('auth-remember');
      if (saved) {
        loginIdInput.value = saved.loginId || '';
        const rememberMe = document.getElementById('rememberMe');
        if (rememberMe) rememberMe.checked = true;

        if (saved.loginType === 'mobile') {
          const mobileBtn = document.querySelector('.so-auth-type-btn[data-type="mobile"]');
          mobileBtn?.click();
        }
      }
    } catch (e) {
      // Ignore
    }
  }

  /**
   * Initialize forgot password flow
   * @private
   */
  _initForgotPassword() {
    const steps = document.querySelectorAll('.so-auth-step');
    if (!steps.length) return;

    let currentStep = 1;
    let recoveryType = 'email';
    let recoveryValue = '';
    let resendTimer = null;

    // Show specific step
    const showStep = (stepNumber) => {
      steps.forEach(step => {
        step.classList.toggle('so-active', parseInt(step.dataset.step, 10) === stepNumber);
      });

      // Update step dots
      document.querySelectorAll('.so-auth-step-dot').forEach((dot, index) => {
        dot.classList.remove('so-active', 'so-completed');
        if (index + 1 < stepNumber) {
          dot.classList.add('so-completed');
        } else if (index + 1 === stepNumber) {
          dot.classList.add('so-active');
        }
      });

      currentStep = stepNumber;

      // Focus first input
      const targetStep = document.querySelector(`.so-auth-step[data-step="${stepNumber}"]`);
      targetStep?.querySelector('input')?.focus();
    };

    // Back buttons
    document.querySelectorAll('.so-auth-back').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const targetStep = parseInt(btn.dataset.step, 10);
        if (targetStep) {
          e.preventDefault();
          showStep(targetStep);
        }
      });
    });

    // Recovery type toggle
    document.querySelectorAll('.so-auth-type-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.so-auth-type-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        recoveryType = btn.dataset.type;

        const input = document.getElementById('recoveryId');
        const iconWrapper = document.getElementById('recoveryIdIcon');
        const iconEl = iconWrapper?.querySelector('.material-icons');
        const group = document.getElementById('recoveryIdGroup');
        const label = group?.querySelector('.so-form-label');

        if (recoveryType === 'email') {
          if (label) label.textContent = 'Email Address';
          if (input) {
            input.type = 'email';
            input.placeholder = 'Enter your email address';
          }
          if (iconEl) iconEl.textContent = 'email';
        } else {
          if (label) label.textContent = 'Mobile Number';
          if (input) {
            input.type = 'tel';
            input.placeholder = 'Enter your mobile number';
          }
          if (iconEl) iconEl.textContent = 'phone';
        }
      });
    });

    // Form handlers
    const sendOtpForm = document.getElementById('sendOtpForm');
    if (sendOtpForm) {
      sendOtpForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const input = document.getElementById('recoveryId');
        recoveryValue = input?.value.trim();

        // Validation
        if (!recoveryValue) {
          SOForms.showError('recoveryId', recoveryType === 'email' ? 'Email is required' : 'Mobile number is required');
          return;
        }

        if (recoveryType === 'email' && !SOForms.validateEmail(recoveryValue)) {
          SOForms.showError('recoveryId', 'Please enter a valid email address');
          return;
        }

        if (recoveryType === 'mobile' && !SOForms.validatePhone(recoveryValue)) {
          SOForms.showError('recoveryId', 'Please enter a valid 10-digit mobile number');
          return;
        }

        // Update OTP sent text
        const otpSentText = document.getElementById('otpSentText');
        if (otpSentText) {
          otpSentText.textContent = recoveryType === 'email'
            ? `We sent a verification code to ${SOForms.maskEmail(recoveryValue)}`
            : `We sent a verification code to ${SOForms.maskPhone(recoveryValue)}`;
        }

        if (this.config.onForgotPassword) {
          const btn = document.getElementById('sendOtpBtn');
          SOForms.setButtonLoading(btn, true);
          this.config.onForgotPassword({ recoveryValue, recoveryType, step: 1 });
        } else {
          showStep(2);
          this._startResendTimer();
        }
      });
    }

    // Store methods for external access
    this.showStep = showStep;
    this._startResendTimer = () => {
      let seconds = 30;
      const btn = document.getElementById('resendOtpBtn');
      if (!btn) return;

      btn.disabled = true;

      const update = () => {
        btn.textContent = `Resend in ${seconds}s`;
      };
      update();

      resendTimer = setInterval(() => {
        seconds--;
        if (seconds <= 0) {
          clearInterval(resendTimer);
          btn.disabled = false;
          btn.textContent = 'Resend Code';
        } else {
          update();
        }
      }, 1000);
    };
  }

  /**
   * Initialize OTP inputs
   * @private
   */
  _initOtpInputs() {
    const otpGroup = document.querySelector('.so-otp-group');
    if (otpGroup) {
      SOOtpInput.getInstance(otpGroup);
    }
  }

  /**
   * Complete login (call after successful API response)
   * @param {Object} options - Options
   */
  completeLogin(options = {}) {
    const { remember = false, loginId = '', loginType = 'email', redirectUrl = 'index.html' } = options;

    // Save remembered credentials
    if (remember) {
      SixOrbit.setStorage('auth-remember', { loginId, loginType });
    } else {
      SixOrbit.removeStorage('auth-remember');
    }

    // Redirect
    if (redirectUrl) {
      window.location.href = redirectUrl;
    }
  }

  /**
   * Set login error
   * @param {string} message - Error message
   */
  setLoginError(message) {
    const btn = document.getElementById('loginBtn');
    SOForms.setButtonLoading(btn, false);
    SOForms.showError('password', message);
  }
}

// Register components
SOFeatureCarousel.register();

// Expose to global scope
window.SOFeatureCarousel = SOFeatureCarousel;
window.SOAuth = SOAuth;

// Export for ES modules
export { SOFeatureCarousel, SOAuth };
export default SOAuth;
