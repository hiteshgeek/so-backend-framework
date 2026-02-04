(() => {
  var __defProp = Object.defineProperty;
  var __getOwnPropSymbols = Object.getOwnPropertySymbols;
  var __hasOwnProp = Object.prototype.hasOwnProperty;
  var __propIsEnum = Object.prototype.propertyIsEnumerable;
  var __defNormalProp = (obj, key, value) => key in obj ? __defProp(obj, key, { enumerable: true, configurable: true, writable: true, value }) : obj[key] = value;
  var __spreadValues = (a, b) => {
    for (var prop in b || (b = {}))
      if (__hasOwnProp.call(b, prop))
        __defNormalProp(a, prop, b[prop]);
    if (__getOwnPropSymbols)
      for (var prop of __getOwnPropSymbols(b)) {
        if (__propIsEnum.call(b, prop))
          __defNormalProp(a, prop, b[prop]);
      }
    return a;
  };

  // src/pages/auth/auth.js
  var SOFeatureCarousel = class {
    constructor(element, options = {}) {
      this.element = typeof element === "string" ? document.querySelector(element) : element;
      if (!this.element)
        return;
      this.options = __spreadValues({
        interval: 5e3,
        pauseOnHover: true,
        features: []
      }, options);
      this._init();
    }
    _init() {
      this._slidesContainer = this.element.querySelector("#featureSlides, .so-feature-slides");
      this._dotsContainer = this.element.querySelector("#featureDots, .so-feature-dots");
      if (!this._slidesContainer)
        return;
      this._currentIndex = 0;
      this._timer = null;
      this._isPaused = false;
      this._slides = [];
      this._dots = [];
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
      this._slides = Array.from(this.element.querySelectorAll(".so-feature-slide"));
      this._dots = Array.from(this.element.querySelectorAll(".so-feature-dot"));
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
    `).join("");
      if (this._dotsContainer) {
        this._dotsContainer.innerHTML = this.options.features.map((_, index) => `
        <button class="so-feature-dot" data-index="${index}" aria-label="Go to slide ${index + 1}"></button>
      `).join("");
      }
      this._cacheElements();
    }
    _bindEvents() {
      this._dots.forEach((dot) => {
        dot.addEventListener("click", () => {
          const index = parseInt(dot.dataset.index, 10);
          this._showSlide(index);
          this._resetAutoRotate();
        });
      });
      if (this.options.pauseOnHover) {
        this.element.addEventListener("mouseenter", () => {
          this._isPaused = true;
          this._stopAutoRotate();
        });
        this.element.addEventListener("mouseleave", () => {
          this._isPaused = false;
          this._startAutoRotate();
        });
      }
    }
    _showSlide(index) {
      this._currentIndex = index;
      this._slides.forEach((slide, i) => {
        slide.classList.toggle("active", i === index);
      });
      this._dots.forEach((dot, i) => {
        dot.classList.toggle("active", i === index);
      });
    }
    _nextSlide() {
      const nextIndex = (this._currentIndex + 1) % this._slides.length;
      this._showSlide(nextIndex);
    }
    _startAutoRotate() {
      if (this._isPaused || this._slides.length <= 1)
        return;
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
  };
  var SOAuth = class {
    constructor(config = {}) {
      this.config = __spreadValues({
        customerName: config.customerName || "Customer",
        customerLogo: config.customerLogo || null,
        customerInitials: config.customerInitials || "C",
        features: config.features || [],
        carouselInterval: config.carouselInterval || 5e3,
        onLogin: config.onLogin || null,
        onForgotPassword: config.onForgotPassword || null
      }, config);
      this._init();
    }
    _init() {
      const carouselEl = document.getElementById("featureCarousel");
      if (carouselEl) {
        this.carousel = new SOFeatureCarousel(carouselEl, {
          features: this.config.features,
          interval: this.config.carouselInterval
        });
      }
      this._setupBranding();
      this._initLoginForm();
      this._initForgotPassword();
      this._initOtpInputs();
    }
    _setupBranding() {
      const nameEl = document.getElementById("customerName");
      if (nameEl && this.config.customerName) {
        nameEl.textContent = this.config.customerName;
      }
      const logoImg = document.getElementById("customerLogoImg");
      const logoPlaceholder = document.getElementById("customerLogoPlaceholder");
      const initialsEl = document.getElementById("customerInitials");
      if (this.config.customerLogo && logoImg && logoPlaceholder) {
        logoImg.src = this.config.customerLogo;
        logoImg.style.display = "block";
        logoPlaceholder.style.display = "none";
        logoImg.onerror = () => {
          logoImg.style.display = "none";
          logoPlaceholder.style.display = "flex";
        };
      } else if (initialsEl && this.config.customerInitials) {
        initialsEl.textContent = this.config.customerInitials;
      }
    }
    _initLoginForm() {
      const form = document.getElementById("loginForm");
      if (!form)
        return;
      const loginIdInput = document.getElementById("loginId");
      const passwordInput = document.getElementById("password");
      const loginBtn = document.getElementById("loginBtn");
      const toggleBtns = document.querySelectorAll(".so-auth-type-btn");
      let loginType = "email";
      toggleBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
          toggleBtns.forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          loginType = btn.dataset.type;
          const group = document.getElementById("loginIdGroup");
          const iconWrapper = document.getElementById("loginIdIcon");
          const iconEl = iconWrapper == null ? void 0 : iconWrapper.querySelector(".material-icons");
          const label = group == null ? void 0 : group.querySelector(".so-form-label");
          if (loginType === "email") {
            if (label)
              label.textContent = "Email Address";
            loginIdInput.type = "email";
            loginIdInput.placeholder = "Enter your email address";
            if (iconEl)
              iconEl.textContent = "email";
          } else {
            if (label)
              label.textContent = "Mobile Number";
            loginIdInput.type = "tel";
            loginIdInput.placeholder = "Enter your mobile number";
            if (iconEl)
              iconEl.textContent = "phone";
          }
          this._clearError("loginId");
          loginIdInput.value = "";
          loginIdInput.focus();
        });
      });
      const togglePassword = document.getElementById("togglePassword");
      if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", () => {
          const isPassword = passwordInput.type === "password";
          passwordInput.type = isPassword ? "text" : "password";
          togglePassword.querySelector(".material-icons").textContent = isPassword ? "visibility_off" : "visibility";
        });
      }
      form.addEventListener("submit", (e) => {
        e.preventDefault();
        this._clearError("loginId");
        this._clearError("password");
        const loginId = loginIdInput.value.trim();
        const password = passwordInput.value;
        let isValid = true;
        if (!loginId) {
          this._showError("loginId", loginType === "email" ? "Email address is required" : "Mobile number is required");
          isValid = false;
        } else if (loginType === "email" && !this._validateEmail(loginId)) {
          this._showError("loginId", "Please enter a valid email address");
          isValid = false;
        } else if (loginType === "mobile" && !this._validatePhone(loginId)) {
          this._showError("loginId", "Please enter a valid 10-digit mobile number");
          isValid = false;
        }
        if (!password) {
          this._showError("password", "Password is required");
          isValid = false;
        } else if (password.length < 6) {
          this._showError("password", "Password must be at least 6 characters");
          isValid = false;
        }
        if (!isValid)
          return;
        if (this.config.onLogin) {
          this._setButtonLoading(loginBtn, true);
          this.config.onLogin({ loginId, password, loginType });
        }
      });
      this._loadRememberedCredentials(loginIdInput);
    }
    _loadRememberedCredentials(loginIdInput) {
      try {
        const saved = localStorage.getItem("so-auth-remember");
        if (saved) {
          const data = JSON.parse(saved);
          loginIdInput.value = data.loginId || "";
          const rememberMe = document.getElementById("rememberMe");
          if (rememberMe)
            rememberMe.checked = true;
          if (data.loginType === "mobile") {
            const mobileBtn = document.querySelector('.so-auth-type-btn[data-type="mobile"]');
            mobileBtn == null ? void 0 : mobileBtn.click();
          }
        }
      } catch (e) {
      }
    }
    _initForgotPassword() {
      const steps = document.querySelectorAll(".so-auth-step");
      if (!steps.length)
        return;
      let currentStep = 1;
      let recoveryType = "email";
      let recoveryValue = "";
      let resendTimer = null;
      const showStep = (stepNumber) => {
        var _a;
        steps.forEach((step) => {
          step.classList.toggle("active", parseInt(step.dataset.step, 10) === stepNumber);
        });
        document.querySelectorAll(".so-auth-step-dot").forEach((dot, index) => {
          dot.classList.remove("active", "completed");
          if (index + 1 < stepNumber) {
            dot.classList.add("completed");
          } else if (index + 1 === stepNumber) {
            dot.classList.add("active");
          }
        });
        currentStep = stepNumber;
        const targetStep = document.querySelector(`.so-auth-step[data-step="${stepNumber}"]`);
        (_a = targetStep == null ? void 0 : targetStep.querySelector("input")) == null ? void 0 : _a.focus();
      };
      document.querySelectorAll(".so-auth-back").forEach((btn) => {
        btn.addEventListener("click", (e) => {
          const targetStep = parseInt(btn.dataset.step, 10);
          if (targetStep) {
            e.preventDefault();
            showStep(targetStep);
          }
        });
      });
      document.querySelectorAll(".so-auth-type-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
          document.querySelectorAll(".so-auth-type-btn").forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          recoveryType = btn.dataset.type;
          const input = document.getElementById("recoveryId");
          const iconWrapper = document.getElementById("recoveryIdIcon");
          const iconEl = iconWrapper == null ? void 0 : iconWrapper.querySelector(".material-icons");
          const group = document.getElementById("recoveryIdGroup");
          const label = group == null ? void 0 : group.querySelector(".so-form-label");
          if (recoveryType === "email") {
            if (label)
              label.textContent = "Email Address";
            if (input) {
              input.type = "email";
              input.placeholder = "Enter your email address";
            }
            if (iconEl)
              iconEl.textContent = "email";
          } else {
            if (label)
              label.textContent = "Mobile Number";
            if (input) {
              input.type = "tel";
              input.placeholder = "Enter your mobile number";
            }
            if (iconEl)
              iconEl.textContent = "phone";
          }
        });
      });
      const sendOtpForm = document.getElementById("sendOtpForm");
      if (sendOtpForm) {
        sendOtpForm.addEventListener("submit", (e) => {
          e.preventDefault();
          const input = document.getElementById("recoveryId");
          recoveryValue = input == null ? void 0 : input.value.trim();
          if (!recoveryValue) {
            this._showError("recoveryId", recoveryType === "email" ? "Email is required" : "Mobile number is required");
            return;
          }
          if (recoveryType === "email" && !this._validateEmail(recoveryValue)) {
            this._showError("recoveryId", "Please enter a valid email address");
            return;
          }
          if (recoveryType === "mobile" && !this._validatePhone(recoveryValue)) {
            this._showError("recoveryId", "Please enter a valid 10-digit mobile number");
            return;
          }
          const otpSentText = document.getElementById("otpSentText");
          if (otpSentText) {
            otpSentText.textContent = recoveryType === "email" ? `We sent a verification code to ${this._maskEmail(recoveryValue)}` : `We sent a verification code to ${this._maskPhone(recoveryValue)}`;
          }
          if (this.config.onForgotPassword) {
            const btn = document.getElementById("sendOtpBtn");
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
        const btn = document.getElementById("resendOtpBtn");
        if (!btn)
          return;
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
            btn.textContent = "Resend Code";
          } else {
            update();
          }
        }, 1e3);
      };
    }
    _initOtpInputs() {
      if (typeof SOOtpInput !== "undefined") {
        const otpGroup = document.querySelector(".so-otp-group");
        if (otpGroup) {
          SOOtpInput.getInstance(otpGroup);
        }
      }
    }
    // Helper methods
    _showError(inputId, message) {
      var _a;
      const group = document.getElementById(inputId + "Group") || ((_a = document.getElementById(inputId)) == null ? void 0 : _a.closest(".so-form-group"));
      if (group) {
        group.classList.add("has-error");
        const errorEl = group.querySelector(".so-form-error");
        if (errorEl) {
          const textNode = Array.from(errorEl.childNodes).find((n) => n.nodeType === Node.TEXT_NODE);
          if (textNode) {
            textNode.textContent = message;
          } else {
            errorEl.innerHTML = `<span class="material-icons">error</span>${message}`;
          }
        }
      }
    }
    _clearError(inputId) {
      var _a;
      const group = document.getElementById(inputId + "Group") || ((_a = document.getElementById(inputId)) == null ? void 0 : _a.closest(".so-form-group"));
      if (group) {
        group.classList.remove("has-error");
      }
    }
    _setButtonLoading(btn, loading) {
      if (!btn)
        return;
      if (loading) {
        btn.classList.add("so-loading");
        btn.disabled = true;
      } else {
        btn.classList.remove("so-loading");
        btn.disabled = false;
      }
    }
    _validateEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    _validatePhone(phone) {
      return /^\d{10}$/.test(phone.replace(/\D/g, ""));
    }
    _maskEmail(email) {
      const [name, domain] = email.split("@");
      const maskedName = name.length > 2 ? name[0] + "*".repeat(name.length - 2) + name[name.length - 1] : name[0] + "*";
      return `${maskedName}@${domain}`;
    }
    _maskPhone(phone) {
      const digits = phone.replace(/\D/g, "");
      return digits.slice(0, 2) + "****" + digits.slice(-2);
    }
    // Public methods
    completeLogin(options = {}) {
      const { remember = false, loginId = "", loginType = "email", redirectUrl = "index.html" } = options;
      if (remember) {
        localStorage.setItem("so-auth-remember", JSON.stringify({ loginId, loginType }));
      } else {
        localStorage.removeItem("so-auth-remember");
      }
      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    }
    setLoginError(message) {
      const btn = document.getElementById("loginBtn");
      this._setButtonLoading(btn, false);
      this._showError("password", message);
    }
  };
  window.SOFeatureCarousel = SOFeatureCarousel;
  window.SOAuth = SOAuth;
})();
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsic3JjL3BhZ2VzL2F1dGgvYXV0aC5qcyJdLAogICJzb3VyY2VzQ29udGVudCI6IFsiLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIFNJWE9SQklUIFVJIC0gQVVUSEVOVElDQVRJT04gUEFHRSBKU1xuLy8gTG9naW4sIHBhc3N3b3JkIHJlc2V0LCBhbmQgYXV0aCBjYXJvdXNlbFxuLy8gUGFnZS1zcGVjaWZpYyBzY3JpcHQgKG5vdCBwYXJ0IG9mIGZyYW1ld29yaylcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbi8qKlxuICogU09GZWF0dXJlQ2Fyb3VzZWwgLSBGZWF0dXJlIGNhcm91c2VsIGZvciBhdXRoIHBhZ2VzXG4gKiBTdGFuZGFsb25lIGltcGxlbWVudGF0aW9uIGZvciBhdXRoIHBhZ2VzXG4gKi9cbmNsYXNzIFNPRmVhdHVyZUNhcm91c2VsIHtcbiAgY29uc3RydWN0b3IoZWxlbWVudCwgb3B0aW9ucyA9IHt9KSB7XG4gICAgdGhpcy5lbGVtZW50ID0gdHlwZW9mIGVsZW1lbnQgPT09ICdzdHJpbmcnID8gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihlbGVtZW50KSA6IGVsZW1lbnQ7XG4gICAgaWYgKCF0aGlzLmVsZW1lbnQpIHJldHVybjtcblxuICAgIHRoaXMub3B0aW9ucyA9IHtcbiAgICAgIGludGVydmFsOiA1MDAwLFxuICAgICAgcGF1c2VPbkhvdmVyOiB0cnVlLFxuICAgICAgZmVhdHVyZXM6IFtdLFxuICAgICAgLi4ub3B0aW9ucyxcbiAgICB9O1xuXG4gICAgdGhpcy5faW5pdCgpO1xuICB9XG5cbiAgX2luaXQoKSB7XG4gICAgdGhpcy5fc2xpZGVzQ29udGFpbmVyID0gdGhpcy5lbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJyNmZWF0dXJlU2xpZGVzLCAuc28tZmVhdHVyZS1zbGlkZXMnKTtcbiAgICB0aGlzLl9kb3RzQ29udGFpbmVyID0gdGhpcy5lbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJyNmZWF0dXJlRG90cywgLnNvLWZlYXR1cmUtZG90cycpO1xuXG4gICAgaWYgKCF0aGlzLl9zbGlkZXNDb250YWluZXIpIHJldHVybjtcblxuICAgIHRoaXMuX2N1cnJlbnRJbmRleCA9IDA7XG4gICAgdGhpcy5fdGltZXIgPSBudWxsO1xuICAgIHRoaXMuX2lzUGF1c2VkID0gZmFsc2U7XG4gICAgdGhpcy5fc2xpZGVzID0gW107XG4gICAgdGhpcy5fZG90cyA9IFtdO1xuXG4gICAgLy8gUmVuZGVyIGlmIGZlYXR1cmVzIHByb3ZpZGVkXG4gICAgaWYgKHRoaXMub3B0aW9ucy5mZWF0dXJlcy5sZW5ndGggPiAwKSB7XG4gICAgICB0aGlzLl9yZW5kZXIoKTtcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy5fY2FjaGVFbGVtZW50cygpO1xuICAgIH1cblxuICAgIHRoaXMuX2JpbmRFdmVudHMoKTtcbiAgICB0aGlzLl9zaG93U2xpZGUoMCk7XG4gICAgdGhpcy5fc3RhcnRBdXRvUm90YXRlKCk7XG4gIH1cblxuICBfY2FjaGVFbGVtZW50cygpIHtcbiAgICB0aGlzLl9zbGlkZXMgPSBBcnJheS5mcm9tKHRoaXMuZWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tZmVhdHVyZS1zbGlkZScpKTtcbiAgICB0aGlzLl9kb3RzID0gQXJyYXkuZnJvbSh0aGlzLmVsZW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLWZlYXR1cmUtZG90JykpO1xuICB9XG5cbiAgX3JlbmRlcigpIHtcbiAgICB0aGlzLl9zbGlkZXNDb250YWluZXIuaW5uZXJIVE1MID0gdGhpcy5vcHRpb25zLmZlYXR1cmVzLm1hcCgoZmVhdHVyZSwgaW5kZXgpID0+IGBcbiAgICAgIDxkaXYgY2xhc3M9XCJzby1mZWF0dXJlLXNsaWRlXCIgZGF0YS1pbmRleD1cIiR7aW5kZXh9XCI+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1mZWF0dXJlLXNsaWRlLWNvbnRlbnRcIj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tZmVhdHVyZS1pY29uXCI+XG4gICAgICAgICAgICA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+JHtmZWF0dXJlLmljb259PC9zcGFuPlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1mZWF0dXJlLXRpdGxlXCI+JHtmZWF0dXJlLnRpdGxlfTwvZGl2PlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1mZWF0dXJlLWRlc2NyaXB0aW9uXCI+JHtmZWF0dXJlLmRlc2NyaXB0aW9ufTwvZGl2PlxuICAgICAgICA8L2Rpdj5cbiAgICAgIDwvZGl2PlxuICAgIGApLmpvaW4oJycpO1xuXG4gICAgaWYgKHRoaXMuX2RvdHNDb250YWluZXIpIHtcbiAgICAgIHRoaXMuX2RvdHNDb250YWluZXIuaW5uZXJIVE1MID0gdGhpcy5vcHRpb25zLmZlYXR1cmVzLm1hcCgoXywgaW5kZXgpID0+IGBcbiAgICAgICAgPGJ1dHRvbiBjbGFzcz1cInNvLWZlYXR1cmUtZG90XCIgZGF0YS1pbmRleD1cIiR7aW5kZXh9XCIgYXJpYS1sYWJlbD1cIkdvIHRvIHNsaWRlICR7aW5kZXggKyAxfVwiPjwvYnV0dG9uPlxuICAgICAgYCkuam9pbignJyk7XG4gICAgfVxuXG4gICAgdGhpcy5fY2FjaGVFbGVtZW50cygpO1xuICB9XG5cbiAgX2JpbmRFdmVudHMoKSB7XG4gICAgLy8gRG90IGNsaWNrc1xuICAgIHRoaXMuX2RvdHMuZm9yRWFjaChkb3QgPT4ge1xuICAgICAgZG90LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4ge1xuICAgICAgICBjb25zdCBpbmRleCA9IHBhcnNlSW50KGRvdC5kYXRhc2V0LmluZGV4LCAxMCk7XG4gICAgICAgIHRoaXMuX3Nob3dTbGlkZShpbmRleCk7XG4gICAgICAgIHRoaXMuX3Jlc2V0QXV0b1JvdGF0ZSgpO1xuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICAvLyBQYXVzZSBvbiBob3ZlclxuICAgIGlmICh0aGlzLm9wdGlvbnMucGF1c2VPbkhvdmVyKSB7XG4gICAgICB0aGlzLmVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignbW91c2VlbnRlcicsICgpID0+IHtcbiAgICAgICAgdGhpcy5faXNQYXVzZWQgPSB0cnVlO1xuICAgICAgICB0aGlzLl9zdG9wQXV0b1JvdGF0ZSgpO1xuICAgICAgfSk7XG5cbiAgICAgIHRoaXMuZWxlbWVudC5hZGRFdmVudExpc3RlbmVyKCdtb3VzZWxlYXZlJywgKCkgPT4ge1xuICAgICAgICB0aGlzLl9pc1BhdXNlZCA9IGZhbHNlO1xuICAgICAgICB0aGlzLl9zdGFydEF1dG9Sb3RhdGUoKTtcbiAgICAgIH0pO1xuICAgIH1cbiAgfVxuXG4gIF9zaG93U2xpZGUoaW5kZXgpIHtcbiAgICB0aGlzLl9jdXJyZW50SW5kZXggPSBpbmRleDtcblxuICAgIC8vIFVwZGF0ZSBzbGlkZXNcbiAgICB0aGlzLl9zbGlkZXMuZm9yRWFjaCgoc2xpZGUsIGkpID0+IHtcbiAgICAgIHNsaWRlLmNsYXNzTGlzdC50b2dnbGUoJ2FjdGl2ZScsIGkgPT09IGluZGV4KTtcbiAgICB9KTtcblxuICAgIC8vIFVwZGF0ZSBkb3RzXG4gICAgdGhpcy5fZG90cy5mb3JFYWNoKChkb3QsIGkpID0+IHtcbiAgICAgIGRvdC5jbGFzc0xpc3QudG9nZ2xlKCdhY3RpdmUnLCBpID09PSBpbmRleCk7XG4gICAgfSk7XG4gIH1cblxuICBfbmV4dFNsaWRlKCkge1xuICAgIGNvbnN0IG5leHRJbmRleCA9ICh0aGlzLl9jdXJyZW50SW5kZXggKyAxKSAlIHRoaXMuX3NsaWRlcy5sZW5ndGg7XG4gICAgdGhpcy5fc2hvd1NsaWRlKG5leHRJbmRleCk7XG4gIH1cblxuICBfc3RhcnRBdXRvUm90YXRlKCkge1xuICAgIGlmICh0aGlzLl9pc1BhdXNlZCB8fCB0aGlzLl9zbGlkZXMubGVuZ3RoIDw9IDEpIHJldHVybjtcblxuICAgIHRoaXMuX3N0b3BBdXRvUm90YXRlKCk7XG4gICAgdGhpcy5fdGltZXIgPSBzZXRJbnRlcnZhbCgoKSA9PiB7XG4gICAgICB0aGlzLl9uZXh0U2xpZGUoKTtcbiAgICB9LCB0aGlzLm9wdGlvbnMuaW50ZXJ2YWwpO1xuICB9XG5cbiAgX3N0b3BBdXRvUm90YXRlKCkge1xuICAgIGlmICh0aGlzLl90aW1lcikge1xuICAgICAgY2xlYXJJbnRlcnZhbCh0aGlzLl90aW1lcik7XG4gICAgICB0aGlzLl90aW1lciA9IG51bGw7XG4gICAgfVxuICB9XG5cbiAgX3Jlc2V0QXV0b1JvdGF0ZSgpIHtcbiAgICB0aGlzLl9zdG9wQXV0b1JvdGF0ZSgpO1xuICAgIGlmICghdGhpcy5faXNQYXVzZWQpIHtcbiAgICAgIHRoaXMuX3N0YXJ0QXV0b1JvdGF0ZSgpO1xuICAgIH1cbiAgfVxuXG4gIC8vIFB1YmxpYyBtZXRob2RzXG4gIGdvVG8oaW5kZXgpIHtcbiAgICB0aGlzLl9zaG93U2xpZGUoaW5kZXgpO1xuICAgIHRoaXMuX3Jlc2V0QXV0b1JvdGF0ZSgpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgbmV4dCgpIHtcbiAgICB0aGlzLl9uZXh0U2xpZGUoKTtcbiAgICB0aGlzLl9yZXNldEF1dG9Sb3RhdGUoKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIHByZXYoKSB7XG4gICAgY29uc3QgcHJldkluZGV4ID0gKHRoaXMuX2N1cnJlbnRJbmRleCAtIDEgKyB0aGlzLl9zbGlkZXMubGVuZ3RoKSAlIHRoaXMuX3NsaWRlcy5sZW5ndGg7XG4gICAgdGhpcy5fc2hvd1NsaWRlKHByZXZJbmRleCk7XG4gICAgdGhpcy5fcmVzZXRBdXRvUm90YXRlKCk7XG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICBwYXVzZSgpIHtcbiAgICB0aGlzLl9pc1BhdXNlZCA9IHRydWU7XG4gICAgdGhpcy5fc3RvcEF1dG9Sb3RhdGUoKTtcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIHJlc3VtZSgpIHtcbiAgICB0aGlzLl9pc1BhdXNlZCA9IGZhbHNlO1xuICAgIHRoaXMuX3N0YXJ0QXV0b1JvdGF0ZSgpO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgZGVzdHJveSgpIHtcbiAgICB0aGlzLl9zdG9wQXV0b1JvdGF0ZSgpO1xuICB9XG59XG5cbi8qKlxuICogU09BdXRoIC0gQXV0aGVudGljYXRpb24gcGFnZXMgY29udHJvbGxlclxuICovXG5jbGFzcyBTT0F1dGgge1xuICBjb25zdHJ1Y3Rvcihjb25maWcgPSB7fSkge1xuICAgIHRoaXMuY29uZmlnID0ge1xuICAgICAgY3VzdG9tZXJOYW1lOiBjb25maWcuY3VzdG9tZXJOYW1lIHx8ICdDdXN0b21lcicsXG4gICAgICBjdXN0b21lckxvZ286IGNvbmZpZy5jdXN0b21lckxvZ28gfHwgbnVsbCxcbiAgICAgIGN1c3RvbWVySW5pdGlhbHM6IGNvbmZpZy5jdXN0b21lckluaXRpYWxzIHx8ICdDJyxcbiAgICAgIGZlYXR1cmVzOiBjb25maWcuZmVhdHVyZXMgfHwgW10sXG4gICAgICBjYXJvdXNlbEludGVydmFsOiBjb25maWcuY2Fyb3VzZWxJbnRlcnZhbCB8fCA1MDAwLFxuICAgICAgb25Mb2dpbjogY29uZmlnLm9uTG9naW4gfHwgbnVsbCxcbiAgICAgIG9uRm9yZ290UGFzc3dvcmQ6IGNvbmZpZy5vbkZvcmdvdFBhc3N3b3JkIHx8IG51bGwsXG4gICAgICAuLi5jb25maWcsXG4gICAgfTtcblxuICAgIHRoaXMuX2luaXQoKTtcbiAgfVxuXG4gIF9pbml0KCkge1xuICAgIC8vIEluaXRpYWxpemUgZmVhdHVyZSBjYXJvdXNlbFxuICAgIGNvbnN0IGNhcm91c2VsRWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZmVhdHVyZUNhcm91c2VsJyk7XG4gICAgaWYgKGNhcm91c2VsRWwpIHtcbiAgICAgIHRoaXMuY2Fyb3VzZWwgPSBuZXcgU09GZWF0dXJlQ2Fyb3VzZWwoY2Fyb3VzZWxFbCwge1xuICAgICAgICBmZWF0dXJlczogdGhpcy5jb25maWcuZmVhdHVyZXMsXG4gICAgICAgIGludGVydmFsOiB0aGlzLmNvbmZpZy5jYXJvdXNlbEludGVydmFsLFxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gU2V0dXAgY3VzdG9tZXIgYnJhbmRpbmdcbiAgICB0aGlzLl9zZXR1cEJyYW5kaW5nKCk7XG5cbiAgICAvLyBJbml0aWFsaXplIGxvZ2luIGZvcm1cbiAgICB0aGlzLl9pbml0TG9naW5Gb3JtKCk7XG5cbiAgICAvLyBJbml0aWFsaXplIGZvcmdvdCBwYXNzd29yZCBmbG93XG4gICAgdGhpcy5faW5pdEZvcmdvdFBhc3N3b3JkKCk7XG5cbiAgICAvLyBJbml0aWFsaXplIE9UUCBpbnB1dHMgaWYgU09PdHBJbnB1dCBleGlzdHNcbiAgICB0aGlzLl9pbml0T3RwSW5wdXRzKCk7XG4gIH1cblxuICBfc2V0dXBCcmFuZGluZygpIHtcbiAgICBjb25zdCBuYW1lRWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnY3VzdG9tZXJOYW1lJyk7XG4gICAgaWYgKG5hbWVFbCAmJiB0aGlzLmNvbmZpZy5jdXN0b21lck5hbWUpIHtcbiAgICAgIG5hbWVFbC50ZXh0Q29udGVudCA9IHRoaXMuY29uZmlnLmN1c3RvbWVyTmFtZTtcbiAgICB9XG5cbiAgICBjb25zdCBsb2dvSW1nID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2N1c3RvbWVyTG9nb0ltZycpO1xuICAgIGNvbnN0IGxvZ29QbGFjZWhvbGRlciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdjdXN0b21lckxvZ29QbGFjZWhvbGRlcicpO1xuICAgIGNvbnN0IGluaXRpYWxzRWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnY3VzdG9tZXJJbml0aWFscycpO1xuXG4gICAgaWYgKHRoaXMuY29uZmlnLmN1c3RvbWVyTG9nbyAmJiBsb2dvSW1nICYmIGxvZ29QbGFjZWhvbGRlcikge1xuICAgICAgbG9nb0ltZy5zcmMgPSB0aGlzLmNvbmZpZy5jdXN0b21lckxvZ287XG4gICAgICBsb2dvSW1nLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgICAgbG9nb1BsYWNlaG9sZGVyLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG5cbiAgICAgIGxvZ29JbWcub25lcnJvciA9ICgpID0+IHtcbiAgICAgICAgbG9nb0ltZy5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgICAgICBsb2dvUGxhY2Vob2xkZXIuc3R5bGUuZGlzcGxheSA9ICdmbGV4JztcbiAgICAgIH07XG4gICAgfSBlbHNlIGlmIChpbml0aWFsc0VsICYmIHRoaXMuY29uZmlnLmN1c3RvbWVySW5pdGlhbHMpIHtcbiAgICAgIGluaXRpYWxzRWwudGV4dENvbnRlbnQgPSB0aGlzLmNvbmZpZy5jdXN0b21lckluaXRpYWxzO1xuICAgIH1cbiAgfVxuXG4gIF9pbml0TG9naW5Gb3JtKCkge1xuICAgIGNvbnN0IGZvcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9naW5Gb3JtJyk7XG4gICAgaWYgKCFmb3JtKSByZXR1cm47XG5cbiAgICBjb25zdCBsb2dpbklkSW5wdXQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9naW5JZCcpO1xuICAgIGNvbnN0IHBhc3N3b3JkSW5wdXQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgncGFzc3dvcmQnKTtcbiAgICBjb25zdCBsb2dpbkJ0biA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsb2dpbkJ0bicpO1xuICAgIGNvbnN0IHRvZ2dsZUJ0bnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tYXV0aC10eXBlLWJ0bicpO1xuXG4gICAgbGV0IGxvZ2luVHlwZSA9ICdlbWFpbCc7XG5cbiAgICAvLyBMb2dpbiB0eXBlIHRvZ2dsZVxuICAgIHRvZ2dsZUJ0bnMuZm9yRWFjaChidG4gPT4ge1xuICAgICAgYnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4ge1xuICAgICAgICB0b2dnbGVCdG5zLmZvckVhY2goYiA9PiBiLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpKTtcbiAgICAgICAgYnRuLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xuICAgICAgICBsb2dpblR5cGUgPSBidG4uZGF0YXNldC50eXBlO1xuXG4gICAgICAgIGNvbnN0IGdyb3VwID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvZ2luSWRHcm91cCcpO1xuICAgICAgICBjb25zdCBpY29uV3JhcHBlciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsb2dpbklkSWNvbicpO1xuICAgICAgICBjb25zdCBpY29uRWwgPSBpY29uV3JhcHBlcj8ucXVlcnlTZWxlY3RvcignLm1hdGVyaWFsLWljb25zJyk7XG4gICAgICAgIGNvbnN0IGxhYmVsID0gZ3JvdXA/LnF1ZXJ5U2VsZWN0b3IoJy5zby1mb3JtLWxhYmVsJyk7XG5cbiAgICAgICAgaWYgKGxvZ2luVHlwZSA9PT0gJ2VtYWlsJykge1xuICAgICAgICAgIGlmIChsYWJlbCkgbGFiZWwudGV4dENvbnRlbnQgPSAnRW1haWwgQWRkcmVzcyc7XG4gICAgICAgICAgbG9naW5JZElucHV0LnR5cGUgPSAnZW1haWwnO1xuICAgICAgICAgIGxvZ2luSWRJbnB1dC5wbGFjZWhvbGRlciA9ICdFbnRlciB5b3VyIGVtYWlsIGFkZHJlc3MnO1xuICAgICAgICAgIGlmIChpY29uRWwpIGljb25FbC50ZXh0Q29udGVudCA9ICdlbWFpbCc7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgaWYgKGxhYmVsKSBsYWJlbC50ZXh0Q29udGVudCA9ICdNb2JpbGUgTnVtYmVyJztcbiAgICAgICAgICBsb2dpbklkSW5wdXQudHlwZSA9ICd0ZWwnO1xuICAgICAgICAgIGxvZ2luSWRJbnB1dC5wbGFjZWhvbGRlciA9ICdFbnRlciB5b3VyIG1vYmlsZSBudW1iZXInO1xuICAgICAgICAgIGlmIChpY29uRWwpIGljb25FbC50ZXh0Q29udGVudCA9ICdwaG9uZSc7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLl9jbGVhckVycm9yKCdsb2dpbklkJyk7XG4gICAgICAgIGxvZ2luSWRJbnB1dC52YWx1ZSA9ICcnO1xuICAgICAgICBsb2dpbklkSW5wdXQuZm9jdXMoKTtcbiAgICAgIH0pO1xuICAgIH0pO1xuXG4gICAgLy8gUGFzc3dvcmQgdG9nZ2xlXG4gICAgY29uc3QgdG9nZ2xlUGFzc3dvcmQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgndG9nZ2xlUGFzc3dvcmQnKTtcbiAgICBpZiAodG9nZ2xlUGFzc3dvcmQgJiYgcGFzc3dvcmRJbnB1dCkge1xuICAgICAgdG9nZ2xlUGFzc3dvcmQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgIGNvbnN0IGlzUGFzc3dvcmQgPSBwYXNzd29yZElucHV0LnR5cGUgPT09ICdwYXNzd29yZCc7XG4gICAgICAgIHBhc3N3b3JkSW5wdXQudHlwZSA9IGlzUGFzc3dvcmQgPyAndGV4dCcgOiAncGFzc3dvcmQnO1xuICAgICAgICB0b2dnbGVQYXNzd29yZC5xdWVyeVNlbGVjdG9yKCcubWF0ZXJpYWwtaWNvbnMnKS50ZXh0Q29udGVudCA9IGlzUGFzc3dvcmQgPyAndmlzaWJpbGl0eV9vZmYnIDogJ3Zpc2liaWxpdHknO1xuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gRm9ybSBzdWJtaXNzaW9uXG4gICAgZm9ybS5hZGRFdmVudExpc3RlbmVyKCdzdWJtaXQnLCAoZSkgPT4ge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICB0aGlzLl9jbGVhckVycm9yKCdsb2dpbklkJyk7XG4gICAgICB0aGlzLl9jbGVhckVycm9yKCdwYXNzd29yZCcpO1xuXG4gICAgICBjb25zdCBsb2dpbklkID0gbG9naW5JZElucHV0LnZhbHVlLnRyaW0oKTtcbiAgICAgIGNvbnN0IHBhc3N3b3JkID0gcGFzc3dvcmRJbnB1dC52YWx1ZTtcbiAgICAgIGxldCBpc1ZhbGlkID0gdHJ1ZTtcblxuICAgICAgLy8gVmFsaWRhdGVcbiAgICAgIGlmICghbG9naW5JZCkge1xuICAgICAgICB0aGlzLl9zaG93RXJyb3IoJ2xvZ2luSWQnLCBsb2dpblR5cGUgPT09ICdlbWFpbCcgPyAnRW1haWwgYWRkcmVzcyBpcyByZXF1aXJlZCcgOiAnTW9iaWxlIG51bWJlciBpcyByZXF1aXJlZCcpO1xuICAgICAgICBpc1ZhbGlkID0gZmFsc2U7XG4gICAgICB9IGVsc2UgaWYgKGxvZ2luVHlwZSA9PT0gJ2VtYWlsJyAmJiAhdGhpcy5fdmFsaWRhdGVFbWFpbChsb2dpbklkKSkge1xuICAgICAgICB0aGlzLl9zaG93RXJyb3IoJ2xvZ2luSWQnLCAnUGxlYXNlIGVudGVyIGEgdmFsaWQgZW1haWwgYWRkcmVzcycpO1xuICAgICAgICBpc1ZhbGlkID0gZmFsc2U7XG4gICAgICB9IGVsc2UgaWYgKGxvZ2luVHlwZSA9PT0gJ21vYmlsZScgJiYgIXRoaXMuX3ZhbGlkYXRlUGhvbmUobG9naW5JZCkpIHtcbiAgICAgICAgdGhpcy5fc2hvd0Vycm9yKCdsb2dpbklkJywgJ1BsZWFzZSBlbnRlciBhIHZhbGlkIDEwLWRpZ2l0IG1vYmlsZSBudW1iZXInKTtcbiAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xuICAgICAgfVxuXG4gICAgICBpZiAoIXBhc3N3b3JkKSB7XG4gICAgICAgIHRoaXMuX3Nob3dFcnJvcigncGFzc3dvcmQnLCAnUGFzc3dvcmQgaXMgcmVxdWlyZWQnKTtcbiAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xuICAgICAgfSBlbHNlIGlmIChwYXNzd29yZC5sZW5ndGggPCA2KSB7XG4gICAgICAgIHRoaXMuX3Nob3dFcnJvcigncGFzc3dvcmQnLCAnUGFzc3dvcmQgbXVzdCBiZSBhdCBsZWFzdCA2IGNoYXJhY3RlcnMnKTtcbiAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xuICAgICAgfVxuXG4gICAgICBpZiAoIWlzVmFsaWQpIHJldHVybjtcblxuICAgICAgLy8gQ2FsbCBsb2dpbiBoYW5kbGVyXG4gICAgICBpZiAodGhpcy5jb25maWcub25Mb2dpbikge1xuICAgICAgICB0aGlzLl9zZXRCdXR0b25Mb2FkaW5nKGxvZ2luQnRuLCB0cnVlKTtcbiAgICAgICAgdGhpcy5jb25maWcub25Mb2dpbih7IGxvZ2luSWQsIHBhc3N3b3JkLCBsb2dpblR5cGUgfSk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBMb2FkIHJlbWVtYmVyZWQgY3JlZGVudGlhbHNcbiAgICB0aGlzLl9sb2FkUmVtZW1iZXJlZENyZWRlbnRpYWxzKGxvZ2luSWRJbnB1dCk7XG4gIH1cblxuICBfbG9hZFJlbWVtYmVyZWRDcmVkZW50aWFscyhsb2dpbklkSW5wdXQpIHtcbiAgICB0cnkge1xuICAgICAgY29uc3Qgc2F2ZWQgPSBsb2NhbFN0b3JhZ2UuZ2V0SXRlbSgnc28tYXV0aC1yZW1lbWJlcicpO1xuICAgICAgaWYgKHNhdmVkKSB7XG4gICAgICAgIGNvbnN0IGRhdGEgPSBKU09OLnBhcnNlKHNhdmVkKTtcbiAgICAgICAgbG9naW5JZElucHV0LnZhbHVlID0gZGF0YS5sb2dpbklkIHx8ICcnO1xuICAgICAgICBjb25zdCByZW1lbWJlck1lID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3JlbWVtYmVyTWUnKTtcbiAgICAgICAgaWYgKHJlbWVtYmVyTWUpIHJlbWVtYmVyTWUuY2hlY2tlZCA9IHRydWU7XG5cbiAgICAgICAgaWYgKGRhdGEubG9naW5UeXBlID09PSAnbW9iaWxlJykge1xuICAgICAgICAgIGNvbnN0IG1vYmlsZUJ0biA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1hdXRoLXR5cGUtYnRuW2RhdGEtdHlwZT1cIm1vYmlsZVwiXScpO1xuICAgICAgICAgIG1vYmlsZUJ0bj8uY2xpY2soKTtcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIC8vIElnbm9yZVxuICAgIH1cbiAgfVxuXG4gIF9pbml0Rm9yZ290UGFzc3dvcmQoKSB7XG4gICAgY29uc3Qgc3RlcHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tYXV0aC1zdGVwJyk7XG4gICAgaWYgKCFzdGVwcy5sZW5ndGgpIHJldHVybjtcblxuICAgIGxldCBjdXJyZW50U3RlcCA9IDE7XG4gICAgbGV0IHJlY292ZXJ5VHlwZSA9ICdlbWFpbCc7XG4gICAgbGV0IHJlY292ZXJ5VmFsdWUgPSAnJztcbiAgICBsZXQgcmVzZW5kVGltZXIgPSBudWxsO1xuXG4gICAgY29uc3Qgc2hvd1N0ZXAgPSAoc3RlcE51bWJlcikgPT4ge1xuICAgICAgc3RlcHMuZm9yRWFjaChzdGVwID0+IHtcbiAgICAgICAgc3RlcC5jbGFzc0xpc3QudG9nZ2xlKCdhY3RpdmUnLCBwYXJzZUludChzdGVwLmRhdGFzZXQuc3RlcCwgMTApID09PSBzdGVwTnVtYmVyKTtcbiAgICAgIH0pO1xuXG4gICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tYXV0aC1zdGVwLWRvdCcpLmZvckVhY2goKGRvdCwgaW5kZXgpID0+IHtcbiAgICAgICAgZG90LmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScsICdjb21wbGV0ZWQnKTtcbiAgICAgICAgaWYgKGluZGV4ICsgMSA8IHN0ZXBOdW1iZXIpIHtcbiAgICAgICAgICBkb3QuY2xhc3NMaXN0LmFkZCgnY29tcGxldGVkJyk7XG4gICAgICAgIH0gZWxzZSBpZiAoaW5kZXggKyAxID09PSBzdGVwTnVtYmVyKSB7XG4gICAgICAgICAgZG90LmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xuICAgICAgICB9XG4gICAgICB9KTtcblxuICAgICAgY3VycmVudFN0ZXAgPSBzdGVwTnVtYmVyO1xuXG4gICAgICBjb25zdCB0YXJnZXRTdGVwID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihgLnNvLWF1dGgtc3RlcFtkYXRhLXN0ZXA9XCIke3N0ZXBOdW1iZXJ9XCJdYCk7XG4gICAgICB0YXJnZXRTdGVwPy5xdWVyeVNlbGVjdG9yKCdpbnB1dCcpPy5mb2N1cygpO1xuICAgIH07XG5cbiAgICAvLyBCYWNrIGJ1dHRvbnNcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tYXV0aC1iYWNrJykuZm9yRWFjaChidG4gPT4ge1xuICAgICAgYnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgY29uc3QgdGFyZ2V0U3RlcCA9IHBhcnNlSW50KGJ0bi5kYXRhc2V0LnN0ZXAsIDEwKTtcbiAgICAgICAgaWYgKHRhcmdldFN0ZXApIHtcbiAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgc2hvd1N0ZXAodGFyZ2V0U3RlcCk7XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH0pO1xuXG4gICAgLy8gUmVjb3ZlcnkgdHlwZSB0b2dnbGVcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tYXV0aC10eXBlLWJ0bicpLmZvckVhY2goYnRuID0+IHtcbiAgICAgIGJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLWF1dGgtdHlwZS1idG4nKS5mb3JFYWNoKGIgPT4gYi5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKSk7XG4gICAgICAgIGJ0bi5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcbiAgICAgICAgcmVjb3ZlcnlUeXBlID0gYnRuLmRhdGFzZXQudHlwZTtcblxuICAgICAgICBjb25zdCBpbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdyZWNvdmVyeUlkJyk7XG4gICAgICAgIGNvbnN0IGljb25XcmFwcGVyID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3JlY292ZXJ5SWRJY29uJyk7XG4gICAgICAgIGNvbnN0IGljb25FbCA9IGljb25XcmFwcGVyPy5xdWVyeVNlbGVjdG9yKCcubWF0ZXJpYWwtaWNvbnMnKTtcbiAgICAgICAgY29uc3QgZ3JvdXAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgncmVjb3ZlcnlJZEdyb3VwJyk7XG4gICAgICAgIGNvbnN0IGxhYmVsID0gZ3JvdXA/LnF1ZXJ5U2VsZWN0b3IoJy5zby1mb3JtLWxhYmVsJyk7XG5cbiAgICAgICAgaWYgKHJlY292ZXJ5VHlwZSA9PT0gJ2VtYWlsJykge1xuICAgICAgICAgIGlmIChsYWJlbCkgbGFiZWwudGV4dENvbnRlbnQgPSAnRW1haWwgQWRkcmVzcyc7XG4gICAgICAgICAgaWYgKGlucHV0KSB7XG4gICAgICAgICAgICBpbnB1dC50eXBlID0gJ2VtYWlsJztcbiAgICAgICAgICAgIGlucHV0LnBsYWNlaG9sZGVyID0gJ0VudGVyIHlvdXIgZW1haWwgYWRkcmVzcyc7XG4gICAgICAgICAgfVxuICAgICAgICAgIGlmIChpY29uRWwpIGljb25FbC50ZXh0Q29udGVudCA9ICdlbWFpbCc7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgaWYgKGxhYmVsKSBsYWJlbC50ZXh0Q29udGVudCA9ICdNb2JpbGUgTnVtYmVyJztcbiAgICAgICAgICBpZiAoaW5wdXQpIHtcbiAgICAgICAgICAgIGlucHV0LnR5cGUgPSAndGVsJztcbiAgICAgICAgICAgIGlucHV0LnBsYWNlaG9sZGVyID0gJ0VudGVyIHlvdXIgbW9iaWxlIG51bWJlcic7XG4gICAgICAgICAgfVxuICAgICAgICAgIGlmIChpY29uRWwpIGljb25FbC50ZXh0Q29udGVudCA9ICdwaG9uZSc7XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH0pO1xuXG4gICAgLy8gRm9ybSBoYW5kbGVyc1xuICAgIGNvbnN0IHNlbmRPdHBGb3JtID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3NlbmRPdHBGb3JtJyk7XG4gICAgaWYgKHNlbmRPdHBGb3JtKSB7XG4gICAgICBzZW5kT3RwRm9ybS5hZGRFdmVudExpc3RlbmVyKCdzdWJtaXQnLCAoZSkgPT4ge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGNvbnN0IGlucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3JlY292ZXJ5SWQnKTtcbiAgICAgICAgcmVjb3ZlcnlWYWx1ZSA9IGlucHV0Py52YWx1ZS50cmltKCk7XG5cbiAgICAgICAgaWYgKCFyZWNvdmVyeVZhbHVlKSB7XG4gICAgICAgICAgdGhpcy5fc2hvd0Vycm9yKCdyZWNvdmVyeUlkJywgcmVjb3ZlcnlUeXBlID09PSAnZW1haWwnID8gJ0VtYWlsIGlzIHJlcXVpcmVkJyA6ICdNb2JpbGUgbnVtYmVyIGlzIHJlcXVpcmVkJyk7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHJlY292ZXJ5VHlwZSA9PT0gJ2VtYWlsJyAmJiAhdGhpcy5fdmFsaWRhdGVFbWFpbChyZWNvdmVyeVZhbHVlKSkge1xuICAgICAgICAgIHRoaXMuX3Nob3dFcnJvcigncmVjb3ZlcnlJZCcsICdQbGVhc2UgZW50ZXIgYSB2YWxpZCBlbWFpbCBhZGRyZXNzJyk7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHJlY292ZXJ5VHlwZSA9PT0gJ21vYmlsZScgJiYgIXRoaXMuX3ZhbGlkYXRlUGhvbmUocmVjb3ZlcnlWYWx1ZSkpIHtcbiAgICAgICAgICB0aGlzLl9zaG93RXJyb3IoJ3JlY292ZXJ5SWQnLCAnUGxlYXNlIGVudGVyIGEgdmFsaWQgMTAtZGlnaXQgbW9iaWxlIG51bWJlcicpO1xuICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIGNvbnN0IG90cFNlbnRUZXh0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ290cFNlbnRUZXh0Jyk7XG4gICAgICAgIGlmIChvdHBTZW50VGV4dCkge1xuICAgICAgICAgIG90cFNlbnRUZXh0LnRleHRDb250ZW50ID0gcmVjb3ZlcnlUeXBlID09PSAnZW1haWwnXG4gICAgICAgICAgICA/IGBXZSBzZW50IGEgdmVyaWZpY2F0aW9uIGNvZGUgdG8gJHt0aGlzLl9tYXNrRW1haWwocmVjb3ZlcnlWYWx1ZSl9YFxuICAgICAgICAgICAgOiBgV2Ugc2VudCBhIHZlcmlmaWNhdGlvbiBjb2RlIHRvICR7dGhpcy5fbWFza1Bob25lKHJlY292ZXJ5VmFsdWUpfWA7XG4gICAgICAgIH1cblxuICAgICAgICBpZiAodGhpcy5jb25maWcub25Gb3Jnb3RQYXNzd29yZCkge1xuICAgICAgICAgIGNvbnN0IGJ0biA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdzZW5kT3RwQnRuJyk7XG4gICAgICAgICAgdGhpcy5fc2V0QnV0dG9uTG9hZGluZyhidG4sIHRydWUpO1xuICAgICAgICAgIHRoaXMuY29uZmlnLm9uRm9yZ290UGFzc3dvcmQoeyByZWNvdmVyeVZhbHVlLCByZWNvdmVyeVR5cGUsIHN0ZXA6IDEgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgc2hvd1N0ZXAoMik7XG4gICAgICAgICAgdGhpcy5fc3RhcnRSZXNlbmRUaW1lcigpO1xuICAgICAgICB9XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICB0aGlzLnNob3dTdGVwID0gc2hvd1N0ZXA7XG4gICAgdGhpcy5fc3RhcnRSZXNlbmRUaW1lciA9ICgpID0+IHtcbiAgICAgIGxldCBzZWNvbmRzID0gMzA7XG4gICAgICBjb25zdCBidG4gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgncmVzZW5kT3RwQnRuJyk7XG4gICAgICBpZiAoIWJ0bikgcmV0dXJuO1xuXG4gICAgICBidG4uZGlzYWJsZWQgPSB0cnVlO1xuXG4gICAgICBjb25zdCB1cGRhdGUgPSAoKSA9PiB7XG4gICAgICAgIGJ0bi50ZXh0Q29udGVudCA9IGBSZXNlbmQgaW4gJHtzZWNvbmRzfXNgO1xuICAgICAgfTtcbiAgICAgIHVwZGF0ZSgpO1xuXG4gICAgICByZXNlbmRUaW1lciA9IHNldEludGVydmFsKCgpID0+IHtcbiAgICAgICAgc2Vjb25kcy0tO1xuICAgICAgICBpZiAoc2Vjb25kcyA8PSAwKSB7XG4gICAgICAgICAgY2xlYXJJbnRlcnZhbChyZXNlbmRUaW1lcik7XG4gICAgICAgICAgYnRuLmRpc2FibGVkID0gZmFsc2U7XG4gICAgICAgICAgYnRuLnRleHRDb250ZW50ID0gJ1Jlc2VuZCBDb2RlJztcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICB1cGRhdGUoKTtcbiAgICAgICAgfVxuICAgICAgfSwgMTAwMCk7XG4gICAgfTtcbiAgfVxuXG4gIF9pbml0T3RwSW5wdXRzKCkge1xuICAgIC8vIFVzZSBmcmFtZXdvcmsncyBPVFAgaW5wdXQgaWYgYXZhaWxhYmxlXG4gICAgaWYgKHR5cGVvZiBTT090cElucHV0ICE9PSAndW5kZWZpbmVkJykge1xuICAgICAgY29uc3Qgb3RwR3JvdXAgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc28tb3RwLWdyb3VwJyk7XG4gICAgICBpZiAob3RwR3JvdXApIHtcbiAgICAgICAgU09PdHBJbnB1dC5nZXRJbnN0YW5jZShvdHBHcm91cCk7XG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgLy8gSGVscGVyIG1ldGhvZHNcbiAgX3Nob3dFcnJvcihpbnB1dElkLCBtZXNzYWdlKSB7XG4gICAgY29uc3QgZ3JvdXAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpbnB1dElkICsgJ0dyb3VwJykgfHwgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaW5wdXRJZCk/LmNsb3Nlc3QoJy5zby1mb3JtLWdyb3VwJyk7XG4gICAgaWYgKGdyb3VwKSB7XG4gICAgICBncm91cC5jbGFzc0xpc3QuYWRkKCdoYXMtZXJyb3InKTtcbiAgICAgIGNvbnN0IGVycm9yRWwgPSBncm91cC5xdWVyeVNlbGVjdG9yKCcuc28tZm9ybS1lcnJvcicpO1xuICAgICAgaWYgKGVycm9yRWwpIHtcbiAgICAgICAgY29uc3QgdGV4dE5vZGUgPSBBcnJheS5mcm9tKGVycm9yRWwuY2hpbGROb2RlcykuZmluZChuID0+IG4ubm9kZVR5cGUgPT09IE5vZGUuVEVYVF9OT0RFKTtcbiAgICAgICAgaWYgKHRleHROb2RlKSB7XG4gICAgICAgICAgdGV4dE5vZGUudGV4dENvbnRlbnQgPSBtZXNzYWdlO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIGVycm9yRWwuaW5uZXJIVE1MID0gYDxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj5lcnJvcjwvc3Bhbj4ke21lc3NhZ2V9YDtcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIF9jbGVhckVycm9yKGlucHV0SWQpIHtcbiAgICBjb25zdCBncm91cCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlucHV0SWQgKyAnR3JvdXAnKSB8fCBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpbnB1dElkKT8uY2xvc2VzdCgnLnNvLWZvcm0tZ3JvdXAnKTtcbiAgICBpZiAoZ3JvdXApIHtcbiAgICAgIGdyb3VwLmNsYXNzTGlzdC5yZW1vdmUoJ2hhcy1lcnJvcicpO1xuICAgIH1cbiAgfVxuXG4gIF9zZXRCdXR0b25Mb2FkaW5nKGJ0biwgbG9hZGluZykge1xuICAgIGlmICghYnRuKSByZXR1cm47XG4gICAgaWYgKGxvYWRpbmcpIHtcbiAgICAgIGJ0bi5jbGFzc0xpc3QuYWRkKCdzby1sb2FkaW5nJyk7XG4gICAgICBidG4uZGlzYWJsZWQgPSB0cnVlO1xuICAgIH0gZWxzZSB7XG4gICAgICBidG4uY2xhc3NMaXN0LnJlbW92ZSgnc28tbG9hZGluZycpO1xuICAgICAgYnRuLmRpc2FibGVkID0gZmFsc2U7XG4gICAgfVxuICB9XG5cbiAgX3ZhbGlkYXRlRW1haWwoZW1haWwpIHtcbiAgICByZXR1cm4gL15bXlxcc0BdK0BbXlxcc0BdK1xcLlteXFxzQF0rJC8udGVzdChlbWFpbCk7XG4gIH1cblxuICBfdmFsaWRhdGVQaG9uZShwaG9uZSkge1xuICAgIHJldHVybiAvXlxcZHsxMH0kLy50ZXN0KHBob25lLnJlcGxhY2UoL1xcRC9nLCAnJykpO1xuICB9XG5cbiAgX21hc2tFbWFpbChlbWFpbCkge1xuICAgIGNvbnN0IFtuYW1lLCBkb21haW5dID0gZW1haWwuc3BsaXQoJ0AnKTtcbiAgICBjb25zdCBtYXNrZWROYW1lID0gbmFtZS5sZW5ndGggPiAyXG4gICAgICA/IG5hbWVbMF0gKyAnKicucmVwZWF0KG5hbWUubGVuZ3RoIC0gMikgKyBuYW1lW25hbWUubGVuZ3RoIC0gMV1cbiAgICAgIDogbmFtZVswXSArICcqJztcbiAgICByZXR1cm4gYCR7bWFza2VkTmFtZX1AJHtkb21haW59YDtcbiAgfVxuXG4gIF9tYXNrUGhvbmUocGhvbmUpIHtcbiAgICBjb25zdCBkaWdpdHMgPSBwaG9uZS5yZXBsYWNlKC9cXEQvZywgJycpO1xuICAgIHJldHVybiBkaWdpdHMuc2xpY2UoMCwgMikgKyAnKioqKicgKyBkaWdpdHMuc2xpY2UoLTIpO1xuICB9XG5cbiAgLy8gUHVibGljIG1ldGhvZHNcbiAgY29tcGxldGVMb2dpbihvcHRpb25zID0ge30pIHtcbiAgICBjb25zdCB7IHJlbWVtYmVyID0gZmFsc2UsIGxvZ2luSWQgPSAnJywgbG9naW5UeXBlID0gJ2VtYWlsJywgcmVkaXJlY3RVcmwgPSAnaW5kZXguaHRtbCcgfSA9IG9wdGlvbnM7XG5cbiAgICBpZiAocmVtZW1iZXIpIHtcbiAgICAgIGxvY2FsU3RvcmFnZS5zZXRJdGVtKCdzby1hdXRoLXJlbWVtYmVyJywgSlNPTi5zdHJpbmdpZnkoeyBsb2dpbklkLCBsb2dpblR5cGUgfSkpO1xuICAgIH0gZWxzZSB7XG4gICAgICBsb2NhbFN0b3JhZ2UucmVtb3ZlSXRlbSgnc28tYXV0aC1yZW1lbWJlcicpO1xuICAgIH1cblxuICAgIGlmIChyZWRpcmVjdFVybCkge1xuICAgICAgd2luZG93LmxvY2F0aW9uLmhyZWYgPSByZWRpcmVjdFVybDtcbiAgICB9XG4gIH1cblxuICBzZXRMb2dpbkVycm9yKG1lc3NhZ2UpIHtcbiAgICBjb25zdCBidG4gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9naW5CdG4nKTtcbiAgICB0aGlzLl9zZXRCdXR0b25Mb2FkaW5nKGJ0biwgZmFsc2UpO1xuICAgIHRoaXMuX3Nob3dFcnJvcigncGFzc3dvcmQnLCBtZXNzYWdlKTtcbiAgfVxufVxuXG4vLyBFeHBvc2UgdG8gZ2xvYmFsIHNjb3BlXG53aW5kb3cuU09GZWF0dXJlQ2Fyb3VzZWwgPSBTT0ZlYXR1cmVDYXJvdXNlbDtcbndpbmRvdy5TT0F1dGggPSBTT0F1dGg7XG4iXSwKICAibWFwcGluZ3MiOiAiOzs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FB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
