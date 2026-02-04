// ============================================
// SIXORBIT UI - AUTHENTICATION PAGE JS
// Login, password reset, and auth carousel
// Page-specific script (not part of framework)
// ============================================

/**
 * SOFeatureCarousel - Feature carousel for auth pages
 * Standalone implementation for auth pages
 */
class SOFeatureCarousel {
  constructor(element, options = {}) {
    this.element = typeof element === 'string' ? document.querySelector(element) : element;
    if (!this.element) return;

    this.options = {
      interval: 5000,
      pauseOnHover: true,
      features: [],
      ...options,
    };

    this._init();
  }

  _init() {
    this._slidesContainer = this.element.querySelector('#featureSlides, .so-feature-slides');
    this._dotsContainer = this.element.querySelector('#featureDots, .so-feature-dots');

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

  _cacheElements() {
    this._slides = Array.from(this.element.querySelectorAll('.so-feature-slide'));
    this._dots = Array.from(this.element.querySelectorAll('.so-feature-dot'));
  }

  _render() {
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

    if (this._dotsContainer) {
      this._dotsContainer.innerHTML = this.options.features.map((_, index) => `
        <button class="so-feature-dot" data-index="${index}" aria-label="Go to slide ${index + 1}"></button>
      `).join('');
    }

    this._cacheElements();
  }

  _bindEvents() {
    // Dot clicks
    this._dots.forEach(dot => {
      dot.addEventListener('click', () => {
        const index = parseInt(dot.dataset.index, 10);
        this._showSlide(index);
        this._resetAutoRotate();
      });
    });

    // Pause on hover
    if (this.options.pauseOnHover) {
      this.element.addEventListener('mouseenter', () => {
        this._isPaused = true;
        this._stopAutoRotate();
      });

      this.element.addEventListener('mouseleave', () => {
        this._isPaused = false;
        this._startAutoRotate();
      });
    }
  }

  _showSlide(index) {
    this._currentIndex = index;

    // Update slides
    this._slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });

    // Update dots
    this._dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
  }

  _nextSlide() {
    const nextIndex = (this._currentIndex + 1) % this._slides.length;
    this._showSlide(nextIndex);
  }

  _startAutoRotate() {
    if (this._isPaused || this._slides.length <= 1) return;

    this._stopAutoRotate();
    this._timer = setInterval(() => {
      this._nextSlide();
    }, this.options.interval);
  }

  _stopAutoRotate() {
    if (this._timer) {
      clearInterval(this._timer);
      this._timer = null;
    }
  }

  _resetAutoRotate() {
    this._stopAutoRotate();
    if (!this._isPaused) {
      this._startAutoRotate();
    }
  }

  // Public methods
  goTo(index) {
    this._showSlide(index);
    this._resetAutoRotate();
    return this;
  }

  next() {
    this._nextSlide();
    this._resetAutoRotate();
    return this;
  }

  prev() {
    const prevIndex = (this._currentIndex - 1 + this._slides.length) % this._slides.length;
    this._showSlide(prevIndex);
    this._resetAutoRotate();
    return this;
  }

  pause() {
    this._isPaused = true;
    this._stopAutoRotate();
    return this;
  }

  resume() {
    this._isPaused = false;
    this._startAutoRotate();
    return this;
  }

  destroy() {
    this._stopAutoRotate();
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

    // Initialize OTP inputs if SOOtpInput exists
    this._initOtpInputs();
  }

  _setupBranding() {
    const nameEl = document.getElementById('customerName');
    if (nameEl && this.config.customerName) {
      nameEl.textContent = this.config.customerName;
    }

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

        this._clearError('loginId');
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

      this._clearError('loginId');
      this._clearError('password');

      const loginId = loginIdInput.value.trim();
      const password = passwordInput.value;
      let isValid = true;

      // Validate
      if (!loginId) {
        this._showError('loginId', loginType === 'email' ? 'Email address is required' : 'Mobile number is required');
        isValid = false;
      } else if (loginType === 'email' && !this._validateEmail(loginId)) {
        this._showError('loginId', 'Please enter a valid email address');
        isValid = false;
      } else if (loginType === 'mobile' && !this._validatePhone(loginId)) {
        this._showError('loginId', 'Please enter a valid 10-digit mobile number');
        isValid = false;
      }

      if (!password) {
        this._showError('password', 'Password is required');
        isValid = false;
      } else if (password.length < 6) {
        this._showError('password', 'Password must be at least 6 characters');
        isValid = false;
      }

      if (!isValid) return;

      // Call login handler
      if (this.config.onLogin) {
        this._setButtonLoading(loginBtn, true);
        this.config.onLogin({ loginId, password, loginType });
      }
    });

    // Load remembered credentials
    this._loadRememberedCredentials(loginIdInput);
  }

  _loadRememberedCredentials(loginIdInput) {
    try {
      const saved = localStorage.getItem('so-auth-remember');
      if (saved) {
        const data = JSON.parse(saved);
        loginIdInput.value = data.loginId || '';
        const rememberMe = document.getElementById('rememberMe');
        if (rememberMe) rememberMe.checked = true;

        if (data.loginType === 'mobile') {
          const mobileBtn = document.querySelector('.so-auth-type-btn[data-type="mobile"]');
          mobileBtn?.click();
        }
      }
    } catch (e) {
      // Ignore
    }
  }

  _initForgotPassword() {
    const steps = document.querySelectorAll('.so-auth-step');
    if (!steps.length) return;

    let currentStep = 1;
    let recoveryType = 'email';
    let recoveryValue = '';
    let resendTimer = null;

    const showStep = (stepNumber) => {
      steps.forEach(step => {
        step.classList.toggle('active', parseInt(step.dataset.step, 10) === stepNumber);
      });

      document.querySelectorAll('.so-auth-step-dot').forEach((dot, index) => {
        dot.classList.remove('active', 'completed');
        if (index + 1 < stepNumber) {
          dot.classList.add('completed');
        } else if (index + 1 === stepNumber) {
          dot.classList.add('active');
        }
      });

      currentStep = stepNumber;

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

        if (!recoveryValue) {
          this._showError('recoveryId', recoveryType === 'email' ? 'Email is required' : 'Mobile number is required');
          return;
        }

        if (recoveryType === 'email' && !this._validateEmail(recoveryValue)) {
          this._showError('recoveryId', 'Please enter a valid email address');
          return;
        }

        if (recoveryType === 'mobile' && !this._validatePhone(recoveryValue)) {
          this._showError('recoveryId', 'Please enter a valid 10-digit mobile number');
          return;
        }

        const otpSentText = document.getElementById('otpSentText');
        if (otpSentText) {
          otpSentText.textContent = recoveryType === 'email'
            ? `We sent a verification code to ${this._maskEmail(recoveryValue)}`
            : `We sent a verification code to ${this._maskPhone(recoveryValue)}`;
        }

        if (this.config.onForgotPassword) {
          const btn = document.getElementById('sendOtpBtn');
          this._setButtonLoading(btn, true);
          this.config.onForgotPassword({ recoveryValue, recoveryType, step: 1 });
        } else {
          showStep(2);
          this._startResendTimer();
        }
      });
    }

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

  _initOtpInputs() {
    // Use framework's OTP input if available
    if (typeof SOOtpInput !== 'undefined') {
      const otpGroup = document.querySelector('.so-otp-group');
      if (otpGroup) {
        SOOtpInput.getInstance(otpGroup);
      }
    }
  }

  // Helper methods
  _showError(inputId, message) {
    const group = document.getElementById(inputId + 'Group') || document.getElementById(inputId)?.closest('.so-form-group');
    if (group) {
      group.classList.add('has-error');
      const errorEl = group.querySelector('.so-form-error');
      if (errorEl) {
        const textNode = Array.from(errorEl.childNodes).find(n => n.nodeType === Node.TEXT_NODE);
        if (textNode) {
          textNode.textContent = message;
        } else {
          errorEl.innerHTML = `<span class="material-icons">error</span>${message}`;
        }
      }
    }
  }

  _clearError(inputId) {
    const group = document.getElementById(inputId + 'Group') || document.getElementById(inputId)?.closest('.so-form-group');
    if (group) {
      group.classList.remove('has-error');
    }
  }

  _setButtonLoading(btn, loading) {
    if (!btn) return;
    if (loading) {
      btn.classList.add('so-loading');
      btn.disabled = true;
    } else {
      btn.classList.remove('so-loading');
      btn.disabled = false;
    }
  }

  _validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  _validatePhone(phone) {
    return /^\d{10}$/.test(phone.replace(/\D/g, ''));
  }

  _maskEmail(email) {
    const [name, domain] = email.split('@');
    const maskedName = name.length > 2
      ? name[0] + '*'.repeat(name.length - 2) + name[name.length - 1]
      : name[0] + '*';
    return `${maskedName}@${domain}`;
  }

  _maskPhone(phone) {
    const digits = phone.replace(/\D/g, '');
    return digits.slice(0, 2) + '****' + digits.slice(-2);
  }

  // Public methods
  completeLogin(options = {}) {
    const { remember = false, loginId = '', loginType = 'email', redirectUrl = 'index.html' } = options;

    if (remember) {
      localStorage.setItem('so-auth-remember', JSON.stringify({ loginId, loginType }));
    } else {
      localStorage.removeItem('so-auth-remember');
    }

    if (redirectUrl) {
      window.location.href = redirectUrl;
    }
  }

  setLoginError(message) {
    const btn = document.getElementById('loginBtn');
    this._setButtonLoading(btn, false);
    this._showError('password', message);
  }
}

// Expose to global scope
window.SOFeatureCarousel = SOFeatureCarousel;
window.SOAuth = SOAuth;
