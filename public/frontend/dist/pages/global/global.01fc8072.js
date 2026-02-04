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
  var __publicField = (obj, key, value) => {
    __defNormalProp(obj, typeof key !== "symbol" ? key + "" : key, value);
    return value;
  };
  var __async = (__this, __arguments, generator) => {
    return new Promise((resolve, reject) => {
      var fulfilled = (value) => {
        try {
          step(generator.next(value));
        } catch (e) {
          reject(e);
        }
      };
      var rejected = (value) => {
        try {
          step(generator.throw(value));
        } catch (e) {
          reject(e);
        }
      };
      var step = (x) => x.done ? resolve(x.value) : Promise.resolve(x.value).then(fulfilled, rejected);
      step((generator = generator.apply(__this, __arguments)).next());
    });
  };

  // src/pages/global/js/_sidebar.js
  var _a;
  var PREFIX = typeof window !== "undefined" && ((_a = window.SixOrbit) == null ? void 0 : _a.PREFIX) || "so";
  var cls = (...parts) => `${PREFIX}-${parts.join("-")}`;
  var _SidebarController = class _SidebarController {
    constructor(element, options = {}) {
      this.element = element;
      this.options = __spreadValues(__spreadValues({}, _SidebarController.DEFAULTS), options);
      if (!this.element)
        return;
      this._mainContent = document.querySelector(this.options.mainContentSelector);
      this._overlay = document.querySelector(this.options.overlaySelector);
      this._toggle = this.element.querySelector(this.options.toggleSelector);
      this._isMobile = false;
      this._isCollapsed = true;
      this._isOpen = false;
      this._drawer = null;
      this._drawerElement = null;
      this.element.classList.add("no-transition");
      this._checkMobile();
      this._restoreState();
      this._initMobileDrawer();
      this._bindEvents();
      this._initSubmenuArrows();
      this._initSubmenuState();
      this._initFooterButtons();
      this._updateBodyClass();
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          this.element.classList.remove("no-transition");
          document.documentElement.classList.remove("sidebar-collapsed", "sidebar-pinned");
        });
      });
    }
    /**
     * Debounce helper
     */
    static debounce(fn, delay) {
      let timer = null;
      return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
      };
    }
    /**
     * Initialize mobile drawer from sidebar content
     * Creates a SODrawer that mirrors the sidebar for mobile/tablet
     */
    _initMobileDrawer() {
      if (typeof SODrawer === "undefined") {
        console.warn("SODrawer not available, falling back to overlay sidebar");
        return;
      }
      this._drawerElement = document.createElement("div");
      this._drawerElement.id = "mobileSidebarDrawer";
      this._drawerElement.className = "so-drawer so-drawer-left so-drawer-sidebar";
      this._drawerElement.tabIndex = -1;
      if (this.element.classList.contains("sidebar-dark")) {
        this._drawerElement.classList.add("drawer-sidebar-dark");
      }
      const sidebarHeader = this.element.querySelector(".so-sidebar-header");
      const sidebarScroll = this.element.querySelector(".so-sidebar-scroll");
      const sidebarFooter = this.element.querySelector(".so-sidebar-footer");
      this._drawerElement.innerHTML = `
      <div class="so-drawer-header">
        <div class="so-drawer-brand">
          ${sidebarHeader ? sidebarHeader.innerHTML : ""}
        </div>
        <button class="so-drawer-close" data-dismiss="drawer">
          <span class="material-icons">close</span>
        </button>
      </div>
      <div class="so-drawer-body so-drawer-sidebar-body">
        ${sidebarScroll ? sidebarScroll.innerHTML : ""}
      </div>
      ${sidebarFooter ? `<div class="so-drawer-footer">${sidebarFooter.innerHTML}</div>` : ""}
    `;
      document.body.appendChild(this._drawerElement);
      this._drawer = new SODrawer(this._drawerElement, {
        backdrop: true,
        keyboard: true,
        scroll: false,
        animation: true
      });
      this._bindDrawerEvents();
      this._initDrawerSubmenuState();
    }
    /**
     * Bind drawer-specific events
     */
    _bindDrawerEvents() {
      if (!this._drawerElement)
        return;
      this._drawerElement.addEventListener("drawer:hidden", () => {
        this._isOpen = false;
        document.body.classList.remove("so-sidebar-open");
      });
      this._drawerElement.addEventListener("click", (e) => {
        const link = e.target.closest(".so-sidebar-link");
        if (link) {
          const item = link.parentElement;
          const submenu = item.querySelector(".so-sidebar-submenu");
          if (submenu) {
            e.preventDefault();
            this._toggleDrawerSubmenu(item);
          } else {
            setTimeout(() => {
              if (this._drawer) {
                this._drawer.hide();
              }
            }, 150);
          }
        }
      });
      this._drawerElement.querySelectorAll(".so-sidebar-footer-item").forEach((btn) => {
        btn.addEventListener("click", () => {
          setTimeout(() => {
            if (this._drawer) {
              this._drawer.hide();
            }
          }, 150);
        });
      });
    }
    /**
     * Toggle submenu in drawer
     */
    _toggleDrawerSubmenu(item) {
      const isOpen = item.classList.contains(cls("open"));
      const parent = item.parentElement;
      parent.querySelectorAll(":scope > .so-sidebar-item.so-open").forEach((sibling) => {
        if (sibling !== item) {
          sibling.classList.remove(cls("open"));
        }
      });
      item.classList.toggle(cls("open"), !isOpen);
    }
    /**
     * Initialize submenu state in drawer based on current page
     */
    _initDrawerSubmenuState() {
      if (!this._drawerElement)
        return;
      const sidebarItems = this.element.querySelectorAll(".so-sidebar-item");
      const drawerItems = this._drawerElement.querySelectorAll(".so-sidebar-item");
      sidebarItems.forEach((sidebarItem, index) => {
        if (drawerItems[index]) {
          if (sidebarItem.classList.contains("current")) {
            drawerItems[index].classList.add("current");
          }
          if (sidebarItem.classList.contains("active")) {
            drawerItems[index].classList.add("active");
          }
          if (sidebarItem.classList.contains(cls("open"))) {
            drawerItems[index].classList.add(cls("open"));
          }
        }
      });
    }
    /**
     * Update drawer theme when sidebar theme changes
     * @param {boolean} isDark - Whether dark theme is active
     */
    setDrawerTheme(isDark) {
      if (this._drawerElement) {
        this._drawerElement.classList.toggle("drawer-sidebar-dark", isDark);
      }
    }
    /**
     * Bind event listeners
     */
    _bindEvents() {
      window.addEventListener("resize", _SidebarController.debounce(() => {
        const wasMobile = this._isMobile;
        this._checkMobile();
        if (wasMobile && !this._isMobile && this._drawer && this._drawer.isOpen()) {
          this._drawer.hide();
        }
        if (this._isMobile && !this._drawer) {
          this._closeMobile();
        }
        this._updateBodyClass();
      }, 150));
      if (this._toggle) {
        this._toggle.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          this.togglePinned();
        });
      }
      document.querySelectorAll('[data-toggle="sidebar"]').forEach((btn) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          if (this._isMobile) {
            this.toggleMobile();
          } else {
            this.togglePinned();
          }
        });
      });
      if (this._overlay) {
        this._overlay.addEventListener("click", () => this._closeMobile());
      }
      this.element.addEventListener("click", (e) => {
        const link = e.target.closest(".so-sidebar-link");
        if (link) {
          const item = link.parentElement;
          const submenu = item.querySelector(".so-sidebar-submenu");
          if (submenu) {
            e.preventDefault();
            this._toggleSubmenu(item);
          }
        }
      });
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && this._isMobile && this._isOpen) {
          this._closeMobile();
        }
      });
    }
    /**
     * Check if viewport is mobile
     */
    _checkMobile() {
      this._isMobile = window.innerWidth < this.options.breakpoint;
    }
    /**
     * Update body class based on sidebar state
     */
    _updateBodyClass() {
      if (this._isCollapsed && !this._isMobile) {
        document.body.classList.add("sidebar-collapsed");
      } else {
        document.body.classList.remove("sidebar-collapsed");
      }
    }
    /**
     * Toggle pinned state
     */
    togglePinned() {
      this._isCollapsed = !this._isCollapsed;
      requestAnimationFrame(() => {
        if (this._isCollapsed) {
          this.element.classList.add("so-collapsed");
          this.element.classList.remove("pinned");
          document.body.classList.add("sidebar-collapsed");
        } else {
          this.element.classList.remove("so-collapsed");
          this.element.classList.add("pinned");
          document.body.classList.remove("sidebar-collapsed");
        }
      });
      this._saveState(this._isCollapsed ? "collapsed" : "pinned");
      return this;
    }
    /**
     * Pin the sidebar (expand)
     */
    pin() {
      if (!this._isCollapsed)
        return this;
      return this.togglePinned();
    }
    /**
     * Unpin the sidebar (collapse)
     */
    unpin() {
      if (this._isCollapsed)
        return this;
      return this.togglePinned();
    }
    /**
     * Check if sidebar is pinned
     */
    isPinned() {
      return !this._isCollapsed;
    }
    /**
     * Toggle mobile sidebar
     */
    toggleMobile() {
      if (this._drawer) {
        return this._drawer.toggle();
      }
      return this._isOpen ? this._closeMobile() : this._openMobile();
    }
    /**
     * Open mobile sidebar
     */
    _openMobile() {
      var _a3;
      if (this._drawer) {
        this._isOpen = true;
        document.body.classList.add("so-sidebar-open");
        return this._drawer.show();
      }
      this._isOpen = true;
      this.element.classList.add(cls("open"));
      (_a3 = this._overlay) == null ? void 0 : _a3.classList.add(cls("active"));
      document.body.classList.add("so-sidebar-open");
      document.body.style.overflow = "hidden";
      return this;
    }
    /**
     * Close mobile sidebar
     */
    _closeMobile() {
      var _a3;
      if (this._drawer) {
        this._isOpen = false;
        document.body.classList.remove("so-sidebar-open");
        return this._drawer.hide();
      }
      this._isOpen = false;
      this.element.classList.remove(cls("open"));
      (_a3 = this._overlay) == null ? void 0 : _a3.classList.remove(cls("active"));
      document.body.classList.remove("so-sidebar-open");
      document.body.style.overflow = "";
      return this;
    }
    /**
     * Toggle submenu
     */
    _toggleSubmenu(item) {
      const isOpen = item.classList.contains(cls("open"));
      const parent = item.parentElement;
      parent.querySelectorAll(":scope > .so-sidebar-item.so-open").forEach((sibling) => {
        if (sibling !== item) {
          sibling.classList.remove(cls("open"));
        }
      });
      item.classList.toggle(cls("open"), !isOpen);
    }
    /**
     * Initialize arrows for nested submenu items
     */
    _initSubmenuArrows() {
      this.element.querySelectorAll(".so-sidebar-submenu .so-sidebar-item").forEach((item) => {
        const nestedSubmenu = item.querySelector(":scope > .so-sidebar-submenu");
        if (nestedSubmenu) {
          item.classList.add("has-children");
          const link = item.querySelector(":scope > .so-sidebar-link");
          if (link && !link.querySelector(".so-sidebar-arrow")) {
            const arrow = document.createElement("span");
            arrow.className = "so-sidebar-arrow";
            arrow.innerHTML = '<span class="material-icons">chevron_right</span>';
            link.appendChild(arrow);
          }
        }
      });
    }
    /**
     * Initialize submenu state based on active items
     */
    _initSubmenuState() {
      this.element.querySelectorAll(".so-sidebar-item.current, .so-sidebar-item.active").forEach((item) => {
        let parent = item.parentElement.closest(".so-sidebar-item");
        while (parent) {
          parent.classList.add(cls("open"));
          parent = parent.parentElement.closest(".so-sidebar-item");
        }
      });
    }
    /**
     * Initialize sidebar footer buttons
     */
    _initFooterButtons() {
      const footer = this.element.querySelector(".so-sidebar-footer");
      if (!footer)
        return;
      const infoBtn = footer.querySelector("#sidebarInfoBtn");
      const infoPopup = footer.querySelector("#sidebarInfoPopup");
      if (infoBtn && infoPopup) {
        infoBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          infoPopup.classList.toggle("so-active");
        });
        document.addEventListener("click", (e) => {
          if (!infoPopup.contains(e.target) && !infoBtn.contains(e.target)) {
            infoPopup.classList.remove("so-active");
          }
        });
      }
      const fullscreenBtn = footer.querySelector("#sidebarFullscreenBtn");
      if (fullscreenBtn) {
        fullscreenBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          this._toggleFullscreen();
        });
      }
      const navbarFullscreenBtn = document.getElementById("navbarFullscreenBtn");
      if (navbarFullscreenBtn) {
        navbarFullscreenBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          this._toggleFullscreen();
        });
      }
      document.addEventListener("fullscreenchange", () => this._updateFullscreenIcon());
      document.addEventListener("webkitfullscreenchange", () => this._updateFullscreenIcon());
      const sidebarLogoutBtn = footer.querySelector("#sidebarLogoutBtn");
      const navbarLogoutBtn = document.getElementById("navbarLogoutBtn");
      const handleLogout = () => {
        localStorage.removeItem("so-user-session");
        localStorage.removeItem("so-screen-locked");
        sessionStorage.clear();
        const currentPath = window.location.pathname;
        const demoIndex = currentPath.indexOf("/demo/");
        if (demoIndex !== -1) {
          const basePath = currentPath.substring(0, demoIndex + 6);
          window.location.href = basePath + "login.php";
        } else {
          window.location.href = "/demo/login.php";
        }
      };
      const showLogoutConfirmation = () => __async(this, null, function* () {
        if (typeof SOModal !== "undefined" && SOModal.confirm) {
          const confirmed = yield SOModal.confirm({
            title: "Confirm Logout",
            message: "Are you sure you want to logout? Any unsaved changes will be lost.",
            icon: { name: "logout", type: "danger" },
            confirm: [{ icon: "logout" }, "Logout"],
            cancel: "Cancel",
            danger: true
          });
          if (confirmed) {
            handleLogout();
          }
        } else {
          if (confirm("Are you sure you want to logout?")) {
            handleLogout();
          }
        }
      });
      if (sidebarLogoutBtn) {
        sidebarLogoutBtn.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          showLogoutConfirmation();
        });
      }
      if (navbarLogoutBtn) {
        navbarLogoutBtn.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          showLogoutConfirmation();
        });
      }
      const lockScreenBtn = document.getElementById("lockScreenBtn");
      const lockScreen = document.getElementById("lockScreen");
      const lockScreenForm = document.getElementById("lockScreenForm");
      const lockScreenPassword = document.getElementById("lockScreenPassword");
      const lockScreenTime = document.getElementById("lockScreenTime");
      const lockScreenDate = document.getElementById("lockScreenDate");
      const updateLockScreenTime = () => {
        const now = /* @__PURE__ */ new Date();
        const hours = now.getHours().toString().padStart(2, "0");
        const minutes = now.getMinutes().toString().padStart(2, "0");
        if (lockScreenTime)
          lockScreenTime.textContent = `${hours}:${minutes}`;
        if (lockScreenDate) {
          const options = { weekday: "long", month: "long", day: "numeric" };
          lockScreenDate.textContent = now.toLocaleDateString("en-US", options);
        }
      };
      const lockScreenAction = () => {
        if (lockScreen) {
          lockScreen.classList.add("active");
          document.body.classList.add("screen-locked");
          localStorage.setItem("so-screen-locked", "true");
          updateLockScreenTime();
          if (lockScreenPassword)
            lockScreenPassword.focus();
        }
      };
      const unlockScreenAction = () => {
        if (lockScreen) {
          lockScreen.classList.remove("active");
          document.body.classList.remove("screen-locked");
          localStorage.removeItem("so-screen-locked");
          if (lockScreenPassword)
            lockScreenPassword.value = "";
        }
      };
      if (lockScreenBtn) {
        lockScreenBtn.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          lockScreenAction();
        });
      }
      if (lockScreenForm) {
        lockScreenForm.addEventListener("submit", (e) => {
          e.preventDefault();
          unlockScreenAction();
        });
      }
      if (localStorage.getItem("so-screen-locked") === "true" && lockScreen) {
        lockScreen.classList.add("active");
        document.body.classList.add("screen-locked");
        updateLockScreenTime();
        if (lockScreenPassword)
          lockScreenPassword.focus();
      }
    }
    /**
     * Toggle fullscreen mode
     */
    _toggleFullscreen() {
      if (!document.fullscreenElement && !document.webkitFullscreenElement) {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
          elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
          elem.webkitRequestFullscreen();
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
      }
    }
    /**
     * Update fullscreen button icons
     */
    _updateFullscreenIcon() {
      const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement;
      const iconText = isFullscreen ? "fullscreen_exit" : "fullscreen";
      const sidebarBtn = this.element.querySelector("#sidebarFullscreenBtn .material-icons");
      if (sidebarBtn)
        sidebarBtn.textContent = iconText;
      const navbarBtn = document.querySelector("#navbarFullscreenBtn .material-icons");
      if (navbarBtn)
        navbarBtn.textContent = iconText;
    }
    /**
     * Save sidebar state to storage
     */
    _saveState(state) {
      try {
        localStorage.setItem(this.options.storageKey, state);
      } catch (e) {
      }
    }
    /**
     * Restore sidebar state from storage
     */
    _restoreState() {
      if (this._isMobile)
        return;
      try {
        const state = localStorage.getItem(this.options.storageKey);
        if (state === "pinned") {
          this._isCollapsed = false;
          this.element.classList.remove("so-collapsed");
          this.element.classList.add("pinned");
        } else {
          this._isCollapsed = true;
          this.element.classList.add("so-collapsed");
        }
      } catch (e) {
        this._isCollapsed = true;
        this.element.classList.add("so-collapsed");
      }
    }
  };
  __publicField(_SidebarController, "DEFAULTS", {
    mainContentSelector: ".so-main-content",
    overlaySelector: ".so-sidebar-overlay",
    toggleSelector: ".so-sidebar-toggle",
    storageKey: "so-sidebar-state",
    breakpoint: 1024
    // Changed from 768 to 1024 for tablet support
  });
  var SidebarController = _SidebarController;

  // src/pages/global/js/_navbar.js
  var NavbarController = class {
    constructor(element) {
      this.element = element;
      if (!this.element)
        return;
      this._init();
    }
    /**
     * Initialize the controller
     * @private
     */
    _init() {
      this._bindEvents();
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
    }
  };

  // src/pages/global/js/_search.js
  var _a2;
  var PREFIX2 = typeof window !== "undefined" && ((_a2 = window.SixOrbit) == null ? void 0 : _a2.PREFIX) || "so";
  var cls2 = (...parts) => `${PREFIX2}-${parts.join("-")}`;
  var _GlobalSearchController = class _GlobalSearchController {
    /**
     * Create a new GlobalSearchController
     * @param {Object} options - Configuration options
     */
    constructor(options = {}) {
      this.options = __spreadValues(__spreadValues({}, _GlobalSearchController.DEFAULTS), options);
      this.isOpen = false;
      this.isISVSearch = false;
      this.searchQuery = "";
      this.currentView = "grid";
      this.activeFilters = { stock: "all", status: "all" };
      this.activeCategory = "all";
      this.focusedIndex = -1;
      this.results = [];
      this._debounceTimer = null;
      this.onSearch = options.onSearch || null;
      this.onItemClick = options.onItemClick || null;
      this.onAccountClick = options.onAccountClick || null;
      this.onQuickActionClick = options.onQuickActionClick || null;
      this.searchUrl = options.searchUrl || null;
      this.isvSearchUrl = options.isvSearchUrl || null;
      this._init();
    }
    /**
     * Initialize the controller
     * @private
     */
    _init() {
      this._overlay = document.querySelector(this.options.overlaySelector);
      if (!this._overlay)
        return;
      this._input = this._overlay.querySelector(this.options.inputSelector);
      this._closeBtn = this._overlay.querySelector(this.options.closeSelector);
      this._backdrop = this._overlay.querySelector(this.options.backdropSelector);
      this._quickLinks = this._overlay.querySelector(this.options.quickLinksSelector);
      this._categoryTabs = this._overlay.querySelector(this.options.categoryTabsSelector);
      this._filterBar = this._overlay.querySelector(this.options.filterBarSelector);
      this._resultsContainer = this._overlay.querySelector(this.options.resultsContainerSelector);
      this._resultsGrid = this._overlay.querySelector(this.options.resultsGridSelector);
      this._resultsList = this._overlay.querySelector(this.options.resultsListSelector);
      this._empty = this._overlay.querySelector(this.options.emptySelector);
      this._loading = this._overlay.querySelector(this.options.loadingSelector);
      this._bindEvents();
      window.globalSearchController = this;
    }
    /**
     * Bind event listeners
     * @private
     */
    _bindEvents() {
      document.addEventListener("keydown", (e) => this._handleGlobalKeydown(e));
      if (this._closeBtn) {
        this._closeBtn.addEventListener("click", () => this.close());
      }
      if (this._backdrop) {
        this._backdrop.addEventListener("click", () => this.close());
      }
      if (this._input) {
        this._input.addEventListener("input", (e) => this._handleInput(e));
        this._input.addEventListener("keydown", (e) => this._handleInputKeydown(e));
      }
      this._overlay.querySelectorAll(".so-search-category-tab").forEach((tab) => {
        tab.addEventListener("click", (e) => this._handleCategoryClick(e));
      });
      this._overlay.querySelectorAll(".so-search-view-btn").forEach((btn) => {
        btn.addEventListener("click", (e) => this._handleViewToggle(e));
      });
      this._initFilters();
      this._overlay.querySelectorAll(".so-search-quick-link").forEach((link) => {
        link.addEventListener("click", (e) => this._handleQuickLinkClick(e));
      });
      if (this._resultsContainer) {
        this._resultsContainer.addEventListener("click", (e) => this._handleResultClick(e));
      }
      const navbarSearch = document.querySelector(".so-navbar-search-input");
      if (navbarSearch) {
        navbarSearch.addEventListener("focus", () => this.open());
        navbarSearch.addEventListener("click", () => this.open());
      }
    }
    /**
     * Handle global keyboard shortcuts
     * @param {KeyboardEvent} e
     * @private
     */
    _handleGlobalKeydown(e) {
      if ((e.ctrlKey || e.metaKey) && e.key === "k") {
        e.preventDefault();
        this.toggle();
      }
      if (e.key === "Escape" && this.isOpen) {
        this.close();
      }
    }
    /**
     * Handle search input
     * @param {Event} e
     * @private
     */
    _handleInput(e) {
      const query = e.target.value.trim();
      this.searchQuery = query;
      clearTimeout(this._debounceTimer);
      this.isISVSearch = query.toLowerCase().startsWith("isv:");
      this._updateSearchMode();
      this._debounceTimer = setTimeout(() => {
        if (query.length >= this.options.minSearchLength) {
          this._performSearch(query);
        } else {
          this._showDefaultState();
        }
      }, this.options.debounceMs);
    }
    /**
     * Handle input keydown for navigation
     * @param {KeyboardEvent} e
     * @private
     */
    _handleInputKeydown(e) {
      switch (e.key) {
        case "ArrowDown":
          e.preventDefault();
          this._focusNext();
          break;
        case "ArrowUp":
          e.preventDefault();
          this._focusPrev();
          break;
        case "Enter":
          e.preventDefault();
          this._selectFocused();
          break;
      }
    }
    /**
     * Initialize filter dropdowns
     * @private
     */
    _initFilters() {
      this._overlay.querySelectorAll(".so-search-filter-dropdown").forEach((dropdown) => {
        const btn = dropdown.querySelector(".so-search-filter-btn");
        const menu = dropdown.querySelector(".so-search-filter-menu");
        const filterType = dropdown.dataset.filter;
        if (btn && menu) {
          btn.addEventListener("click", (e) => {
            e.stopPropagation();
            menu.classList.toggle(cls2("open"));
          });
          menu.querySelectorAll(".so-search-filter-option").forEach((option) => {
            option.addEventListener("click", () => {
              this._selectFilter(filterType, option.dataset.value);
              menu.classList.remove(cls2("open"));
            });
          });
        }
      });
      document.addEventListener("click", () => {
        this._overlay.querySelectorAll(".so-search-filter-menu").forEach((menu) => {
          menu.classList.remove(cls2("open"));
        });
      });
    }
    /**
     * Select a filter option
     * @param {string} type - Filter type (stock, status)
     * @param {string} value - Filter value
     * @private
     */
    _selectFilter(type, value) {
      this.activeFilters[type] = value;
      const dropdown = this._overlay.querySelector(`.so-search-filter-dropdown[data-filter="${type}"]`);
      if (dropdown) {
        dropdown.querySelectorAll(".so-search-filter-option").forEach((opt) => {
          opt.classList.toggle(cls2("selected"), opt.dataset.value === value);
        });
        const label = dropdown.querySelector(".filter-label");
        const selected = dropdown.querySelector(`.so-search-filter-option[data-value="${value}"]`);
        if (label && selected) {
          label.textContent = selected.textContent.trim();
        }
      }
      if (this.searchQuery.length >= this.options.minSearchLength) {
        this._performSearch(this.searchQuery);
      }
    }
    /**
     * Handle category tab click
     * @param {Event} e
     * @private
     */
    _handleCategoryClick(e) {
      const tab = e.currentTarget;
      const category = tab.dataset.category;
      this._overlay.querySelectorAll(".so-search-category-tab").forEach((t) => {
        t.classList.toggle(cls2("active"), t === tab);
      });
      this.activeCategory = category;
      if (this.searchQuery.length >= this.options.minSearchLength) {
        this._performSearch(this.searchQuery);
      }
    }
    /**
     * Handle view toggle
     * @param {Event} e
     * @private
     */
    _handleViewToggle(e) {
      const btn = e.currentTarget;
      const view = btn.dataset.view;
      this._overlay.querySelectorAll(".so-search-view-btn").forEach((b) => {
        b.classList.toggle(cls2("active"), b === btn);
      });
      this.currentView = view;
      if (this._resultsGrid) {
        this._resultsGrid.classList.toggle(cls2("visible"), view === "grid");
      }
      if (this._resultsList) {
        this._resultsList.classList.toggle(cls2("visible"), view === "list");
      }
      this._renderResults(this.results);
    }
    /**
     * Handle quick link click
     * @param {Event} e
     * @private
     */
    _handleQuickLinkClick(e) {
      e.preventDefault();
      const link = e.currentTarget;
      const action = link.dataset.action;
      if (this.onQuickActionClick) {
        this.onQuickActionClick(action, link);
      }
      const url = link.getAttribute("href");
      if (url && url !== "#") {
        window.location.href = url;
      }
      this.close();
    }
    /**
     * Handle result item click
     * @param {Event} e
     * @private
     */
    _handleResultClick(e) {
      const item = e.target.closest(".so-search-item-card, .so-search-item-row, .so-search-account-card, .so-search-overlay-item");
      if (!item)
        return;
      const itemData = {
        id: item.dataset.itemId,
        type: item.dataset.itemType,
        element: item
      };
      if (item.classList.contains("so-search-account-card") && this.onAccountClick) {
        this.onAccountClick(itemData);
      } else if (this.onItemClick) {
        this.onItemClick(itemData);
      }
      this.close();
    }
    /**
     * Update UI based on search mode (normal vs ISV)
     * @private
     */
    _updateSearchMode() {
      if (this._filterBar) {
        this._filterBar.classList.toggle(cls2("visible"), this.isISVSearch);
      }
      if (this._categoryTabs) {
        this._categoryTabs.classList.toggle(cls2("visible"), !this.isISVSearch && this.searchQuery.length >= this.options.minSearchLength);
      }
    }
    /**
     * Perform search
     * @param {string} query
     * @private
     */
    _performSearch(query) {
      return __async(this, null, function* () {
        this._showLoading();
        try {
          let results;
          if (this.isISVSearch) {
            const isvQuery = query.replace(/^isv:/i, "").trim();
            results = yield this._fetchISVResults(isvQuery);
          } else {
            results = yield this._fetchSearchResults(query);
          }
          this.results = results;
          this._renderResults(results);
          if (this.onSearch) {
            this.onSearch(query, results);
          }
        } catch (error) {
          console.error("Search error:", error);
          this._showEmpty("error", "Search Error", "An error occurred while searching. Please try again.");
        }
      });
    }
    /**
     * Fetch normal search results
     * @param {string} query
     * @returns {Promise<Array>}
     * @private
     */
    _fetchSearchResults(query) {
      return __async(this, null, function* () {
        if (this.searchUrl) {
          try {
            const url = new URL(this.searchUrl, window.location.href);
            url.searchParams.append("query", query);
            url.searchParams.append("category", this.activeCategory);
            const response = yield fetch(url.toString());
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = yield response.json();
            return this._transformSearchData(data);
          } catch (error) {
            console.error("Search fetch error:", error);
            return [];
          }
        }
        console.warn("Search URL not configured");
        return [];
      });
    }
    /**
     * Transform JSON data structure to flat array for rendering
     * Server is expected to return already-filtered results based on query parameter
     * @param {Object} data - JSON data with menus, customers, vendors, ledgers arrays
     * @returns {Array}
     * @private
     */
    _transformSearchData(data) {
      const results = [];
      if (data.menus) {
        data.menus.forEach((item) => {
          results.push({
            id: item.id,
            type: "menu",
            name: item.title,
            icon: item.icon,
            iconColor: item.color,
            path: item.path,
            url: item.href
          });
        });
      }
      if (data.customers) {
        data.customers.forEach((item) => {
          results.push({
            id: item.id,
            type: "customer",
            name: item.title,
            icon: item.icon || "person",
            iconColor: item.color || "blue",
            category: "Customer",
            balance: item.walletBalance,
            details: [
              { label: "Phone", value: item.mobile },
              { label: "City", value: item.city }
            ]
          });
        });
      }
      if (data.vendors) {
        data.vendors.forEach((item) => {
          results.push({
            id: item.id,
            type: "vendor",
            name: item.title,
            icon: item.icon || "storefront",
            iconColor: item.color || "green",
            category: "Vendor",
            balance: item.walletBalance,
            details: [
              { label: "Phone", value: item.mobile },
              { label: "City", value: item.city }
            ]
          });
        });
      }
      if (data.ledgers) {
        data.ledgers.forEach((item) => {
          results.push({
            id: item.id,
            type: "ledger",
            name: item.title,
            icon: item.icon || "account_balance_wallet",
            iconColor: item.color || "orange",
            category: item.group,
            balance: item.walletBalance
          });
        });
      }
      return results;
    }
    /**
     * Fetch ISV search results
     * @param {string} query
     * @returns {Promise<Array>}
     * @private
     */
    _fetchISVResults(query) {
      return __async(this, null, function* () {
        if (this.isvSearchUrl) {
          try {
            const url = new URL(this.isvSearchUrl, window.location.href);
            url.searchParams.append("query", query);
            url.searchParams.append("stock", this.activeFilters.stock);
            url.searchParams.append("status", this.activeFilters.status);
            const response = yield fetch(url.toString());
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = yield response.json();
            return this._transformISVData(data);
          } catch (error) {
            console.error("ISV search fetch error:", error);
            return [];
          }
        }
        console.warn("ISV search URL not configured");
        return [];
      });
    }
    /**
     * Transform ISV JSON data and filter by query
     * Filters items by name/SKU matching query (for static JSON files)
     * @param {Object} data - JSON data with items array
     * @param {string} query - Search query for filtering
     * @returns {Array}
     * @private
     */
    _transformISVData(data) {
      return data.items || [];
    }
    /**
     * Render search results
     * @param {Array} results
     * @private
     */
    _renderResults(results) {
      this._hideLoading();
      if (this._quickLinks)
        this._quickLinks.style.display = "none";
      this._hideEmpty();
      if (!results || results.length === 0) {
        this._showEmpty("search_off", "No results found", `No matches for "${this.searchQuery}"`);
        return;
      }
      if (this.isISVSearch) {
        if (this._filterBar)
          this._filterBar.classList.add(cls2("visible"));
        if (this._categoryTabs)
          this._categoryTabs.classList.remove(cls2("visible"));
        this._renderISVResults(results);
      } else {
        if (this._categoryTabs)
          this._categoryTabs.classList.add(cls2("visible"));
        if (this._filterBar)
          this._filterBar.classList.remove(cls2("visible"));
        this._renderNormalResults(results);
      }
    }
    /**
     * Render normal search results (menus, accounts)
     * @param {Array} results
     * @private
     */
    _renderNormalResults(results) {
      const grouped = {
        menus: results.filter((r) => r.type === "menu"),
        customers: results.filter((r) => r.type === "customer"),
        vendors: results.filter((r) => r.type === "vendor"),
        ledgers: results.filter((r) => r.type === "ledger")
      };
      this._updateCategoryCounts(grouped);
      let filteredResults = results;
      if (this.activeCategory !== "all") {
        filteredResults = grouped[this.activeCategory] || [];
      }
      if (this._resultsContainer) {
        let html = "";
        const menus = this.activeCategory === "all" ? grouped.menus : this.activeCategory === "menus" ? filteredResults : [];
        if (menus.length > 0) {
          html += `
          <div class="${cls2("search-overlay-section")}">
            <div class="${cls2("search-overlay-section-title")}">Menu & Actions</div>
            <div class="${cls2("search-overlay-results")}">
              ${menus.slice(0, 10).map((item) => this._renderMenuItem(item)).join("")}
            </div>
          </div>
        `;
        }
        const allAccounts = [
          ...this.activeCategory === "all" || this.activeCategory === "customers" ? grouped.customers : [],
          ...this.activeCategory === "all" || this.activeCategory === "vendors" ? grouped.vendors : [],
          ...this.activeCategory === "all" || this.activeCategory === "ledgers" ? grouped.ledgers : []
        ];
        if (allAccounts.length > 0) {
          html += `
          <div class="${cls2("search-overlay-section")}">
            <div class="${cls2("search-overlay-section-title")}">Accounts</div>
            <div class="${cls2("search-account-cards")}">
              ${allAccounts.slice(0, 12).map((item) => this._renderAccountCard(item)).join("")}
            </div>
          </div>
        `;
        }
        this._resultsContainer.innerHTML = html;
        this._resultsContainer.style.display = "block";
      }
    }
    /**
     * Render ISV search results (items/products)
     * @param {Array} results
     * @private
     */
    _renderISVResults(results) {
      if (this._resultsContainer) {
        this._resultsContainer.style.display = "block";
        if (!this._resultsContainer.querySelector(this.options.resultsGridSelector)) {
          this._resultsContainer.innerHTML = `
          <div class="${cls2("search-results-grid")}"></div>
          <div class="${cls2("search-results-list")}"></div>
        `;
          this._resultsGrid = this._resultsContainer.querySelector(this.options.resultsGridSelector);
          this._resultsList = this._resultsContainer.querySelector(this.options.resultsListSelector);
        }
      }
      if (this.currentView === "grid") {
        if (this._resultsGrid) {
          this._resultsGrid.innerHTML = results.map((item) => this._renderItemCard(item)).join("");
          this._resultsGrid.classList.add(cls2("visible"));
        }
        if (this._resultsList) {
          this._resultsList.classList.remove(cls2("visible"));
        }
      } else {
        if (this._resultsList) {
          this._resultsList.innerHTML = `
          <div class="so-search-list-header">
            <span>Item</span>
            <span>Stock</span>
            <span>Price</span>
            <span>Cost</span>
            <span>Vendor</span>
          </div>
          ${results.map((item) => this._renderItemRow(item)).join("")}
        `;
          this._resultsList.classList.add(cls2("visible"));
        }
        if (this._resultsGrid) {
          this._resultsGrid.classList.remove(cls2("visible"));
        }
      }
    }
    /**
     * Render a menu item
     * @param {Object} item
     * @returns {string}
     * @private
     */
    _renderMenuItem(item) {
      return `
      <a href="${item.url || "#"}" class="so-search-overlay-item" data-item-id="${item.id}" data-item-type="menu">
        <div class="so-search-overlay-item-icon ${item.iconColor || "blue"}">
          <span class="material-icons">${item.icon || "article"}</span>
        </div>
        <div class="so-search-overlay-item-content">
          <div class="so-search-overlay-item-title">${this._highlightMatch(item.name, this.searchQuery)}</div>
          <div class="so-search-overlay-item-path">${item.path || ""}</div>
        </div>
        <span class="material-icons so-search-overlay-item-arrow">arrow_forward</span>
      </a>
    `;
    }
    /**
     * Render an account card
     * @param {Object} item
     * @returns {string}
     * @private
     */
    _renderAccountCard(item) {
      const balanceClass = item.balance > 0 ? "positive" : item.balance < 0 ? "negative" : "neutral";
      const balanceText = this._formatWalletBalance(item.balance);
      return `
      <div class="so-search-account-card" data-item-id="${item.id}" data-item-type="${item.type}">
        <div class="so-search-account-card-header">
          <div class="so-search-account-card-icon ${item.iconColor || "blue"}">
            <span class="material-icons">${item.icon || "account_circle"}</span>
          </div>
          <div class="so-search-account-card-info">
            <div class="so-search-account-card-name">${this._highlightMatch(item.name, this.searchQuery)}</div>
            <div class="so-search-account-card-category">${item.category || item.type}</div>
          </div>
          <div class="so-search-account-card-balance ${balanceClass}">${balanceText}</div>
        </div>
        ${item.details ? `
          <div class="so-search-account-card-details">
            ${item.details.map((d) => `
              <div class="so-search-account-card-detail">
                <div class="so-search-account-card-detail-label">${d.label}</div>
                <div class="so-search-account-card-detail-value">${d.value}</div>
              </div>
            `).join("")}
          </div>
        ` : ""}
      </div>
    `;
    }
    /**
     * Render an item card (grid view)
     * @param {Object} item
     * @returns {string}
     * @private
     */
    _renderItemCard(item) {
      const stockClass = this._getStockClass(item.stock);
      const statusClass = item.status === "active" ? cls2("active") : "liquidation";
      return `
      <div class="so-search-item-card" data-item-id="${item.id}" data-item-type="item">
        <div class="so-search-item-card-header">
          <div class="so-search-item-card-sku">${item.sku || ""}</div>
          <div class="so-search-item-card-status ${statusClass}">${item.status || "active"}</div>
        </div>
        <div class="so-search-item-card-title">${this._highlightMatch(item.name, this.searchQuery.replace(/^isv:/i, "").trim())}</div>
        <div class="so-search-item-card-details">
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Stock</div>
            <div class="so-search-item-card-detail-value ${stockClass}">${item.stock}</div>
          </div>
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Price</div>
            <div class="so-search-item-card-detail-value">${this._formatCurrency(item.price)}</div>
          </div>
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Cost</div>
            <div class="so-search-item-card-detail-value">${this._formatCurrency(item.cost)}</div>
          </div>
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Vendor Stock</div>
            <div class="so-search-item-card-detail-value">${item.vendorStock || 0}</div>
          </div>
        </div>
      </div>
    `;
    }
    /**
     * Render an item row (list view)
     * @param {Object} item
     * @returns {string}
     * @private
     */
    _renderItemRow(item) {
      const stockClass = this._getStockClass(item.stock);
      return `
      <div class="so-search-item-row" data-item-id="${item.id}" data-item-type="item">
        <div class="so-search-item-row-info">
          <div class="so-search-item-row-title">${this._highlightMatch(item.name, this.searchQuery.replace(/^isv:/i, "").trim())}</div>
          <div class="so-search-item-row-sku">${item.sku || ""}</div>
        </div>
        <div class="so-search-item-row-value ${stockClass}">${item.stock}</div>
        <div class="so-search-item-row-value">${this._formatCurrency(item.price)}</div>
        <div class="so-search-item-row-value">${this._formatCurrency(item.cost)}</div>
        <div class="so-search-item-row-value">${item.vendorStock || 0}</div>
      </div>
    `;
    }
    /**
     * Update category counts in tabs
     * @param {Object} grouped
     * @private
     */
    _updateCategoryCounts(grouped) {
      const total = Object.values(grouped).reduce((sum, arr) => sum + arr.length, 0);
      this._overlay.querySelectorAll(".so-search-category-tab").forEach((tab) => {
        var _a3;
        const category = tab.dataset.category;
        const count = tab.querySelector(".so-search-category-count");
        if (count) {
          const value = category === "all" ? total : ((_a3 = grouped[category]) == null ? void 0 : _a3.length) || 0;
          count.textContent = value;
        }
      });
    }
    // ============================================
    // KEYBOARD NAVIGATION
    // ============================================
    /**
     * Focus next result item
     * @private
     */
    _focusNext() {
      const items = this._overlay.querySelectorAll(".so-search-overlay-item, .so-search-account-card, .so-search-item-card, .so-search-item-row");
      if (items.length === 0)
        return;
      this.focusedIndex = Math.min(this.focusedIndex + 1, items.length - 1);
      this._updateFocus(items);
    }
    /**
     * Focus previous result item
     * @private
     */
    _focusPrev() {
      const items = this._overlay.querySelectorAll(".so-search-overlay-item, .so-search-account-card, .so-search-item-card, .so-search-item-row");
      if (items.length === 0)
        return;
      this.focusedIndex = Math.max(this.focusedIndex - 1, 0);
      this._updateFocus(items);
    }
    /**
     * Update focus state on items
     * @param {NodeList} items
     * @private
     */
    _updateFocus(items) {
      items.forEach((item, index) => {
        item.classList.toggle(cls2("focused"), index === this.focusedIndex);
      });
      if (items[this.focusedIndex]) {
        items[this.focusedIndex].scrollIntoView({ block: "nearest" });
      }
    }
    /**
     * Select the focused item
     * @private
     */
    _selectFocused() {
      const focused = this._overlay.querySelector(`.${cls2("focused")}`);
      if (focused) {
        focused.click();
      }
    }
    // ============================================
    // UI STATE METHODS
    // ============================================
    /**
     * Show loading state
     * @private
     */
    _showLoading() {
      if (this._loading)
        this._loading.classList.add(cls2("visible"));
      if (this._empty)
        this._empty.classList.remove(cls2("visible"));
      if (this._quickLinks)
        this._quickLinks.style.display = "none";
      if (this._resultsContainer)
        this._resultsContainer.style.display = "none";
      if (this._resultsGrid)
        this._resultsGrid.classList.remove(cls2("visible"));
      if (this._resultsList)
        this._resultsList.classList.remove(cls2("visible"));
    }
    /**
     * Hide loading state
     * @private
     */
    _hideLoading() {
      if (this._loading)
        this._loading.classList.remove(cls2("visible"));
    }
    /**
     * Show empty state
     * @param {string} icon
     * @param {string} title
     * @param {string} text
     * @private
     */
    _showEmpty(icon, title, text) {
      if (this._empty) {
        const iconEl = this._empty.querySelector(".so-search-empty-icon");
        const titleEl = this._empty.querySelector(".so-search-empty-title");
        const textEl = this._empty.querySelector(".so-search-empty-text");
        if (iconEl)
          iconEl.textContent = icon;
        if (titleEl)
          titleEl.textContent = title;
        if (textEl)
          textEl.textContent = text;
        this._empty.classList.add(cls2("visible"));
      }
      if (this._quickLinks)
        this._quickLinks.style.display = "none";
      if (this._resultsContainer)
        this._resultsContainer.style.display = "none";
      if (this._resultsGrid)
        this._resultsGrid.classList.remove(cls2("visible"));
      if (this._resultsList)
        this._resultsList.classList.remove(cls2("visible"));
    }
    /**
     * Hide empty state
     * @private
     */
    _hideEmpty() {
      if (this._empty)
        this._empty.classList.remove(cls2("visible"));
    }
    /**
     * Show default state (quick links + search prompt when empty)
     * @private
     */
    _showDefaultState() {
      this._hideLoading();
      if (this._quickLinks)
        this._quickLinks.style.display = "block";
      if (this._resultsContainer)
        this._resultsContainer.style.display = "none";
      if (this._resultsGrid)
        this._resultsGrid.classList.remove(cls2("visible"));
      if (this._resultsList)
        this._resultsList.classList.remove(cls2("visible"));
      if (this._categoryTabs)
        this._categoryTabs.classList.remove(cls2("visible"));
      if (this._filterBar)
        this._filterBar.classList.remove(cls2("visible"));
      this._showSearchPrompt();
    }
    /**
     * Show search prompt (without hiding other elements)
     * @private
     */
    _showSearchPrompt() {
      if (this._empty) {
        const iconEl = this._empty.querySelector(".so-search-empty-icon");
        const titleEl = this._empty.querySelector(".so-search-empty-title");
        const textEl = this._empty.querySelector(".so-search-empty-text");
        if (iconEl)
          iconEl.textContent = "search";
        if (titleEl)
          titleEl.textContent = "Start typing to search";
        if (textEl)
          textEl.textContent = 'Search for menus, customers, vendors, ledgers or type "isv:" for item search';
        this._empty.classList.add(cls2("visible"));
      }
    }
    // ============================================
    // UTILITY METHODS
    // ============================================
    /**
     * Highlight search match in text
     * @param {string} text
     * @param {string} query
     * @returns {string}
     * @private
     */
    _highlightMatch(text, query) {
      if (!query || !text)
        return text;
      const escaped = this._escapeHtml(query).replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
      const regex = new RegExp(`(${escaped})`, "gi");
      return this._escapeHtml(text).replace(regex, "<mark>$1</mark>");
    }
    /**
     * Escape HTML special characters
     * @param {string} text
     * @returns {string}
     * @private
     */
    _escapeHtml(text) {
      const div = document.createElement("div");
      div.textContent = text;
      return div.innerHTML;
    }
    /**
     * Format currency
     * @param {number} value
     * @returns {string}
     * @private
     */
    _formatCurrency(value) {
      if (value === null || value === void 0)
        return "-";
      return new Intl.NumberFormat("en-IN", {
        style: "currency",
        currency: "INR",
        minimumFractionDigits: 2
      }).format(value);
    }
    /**
     * Format wallet balance with Cr/Dr suffix
     * @param {number} value
     * @returns {string}
     * @private
     */
    _formatWalletBalance(value) {
      if (value === null || value === void 0 || value === 0)
        return "-";
      const formatted = this._formatCurrency(Math.abs(value));
      return value > 0 ? `${formatted} Cr` : `${formatted} Dr`;
    }
    /**
     * Get stock status class
     * @param {number} stock
     * @returns {string}
     * @private
     */
    _getStockClass(stock) {
      if (stock <= 0)
        return "out-of-stock";
      if (stock < 10)
        return "low-stock";
      return "in-stock";
    }
    // ============================================
    // PUBLIC API
    // ============================================
    /**
     * Configure the search controller
     * @param {Object} config
     */
    configure(config) {
      if (config.searchUrl)
        this.searchUrl = config.searchUrl;
      if (config.isvSearchUrl)
        this.isvSearchUrl = config.isvSearchUrl;
      if (config.onSearch)
        this.onSearch = config.onSearch;
      if (config.onItemClick)
        this.onItemClick = config.onItemClick;
      if (config.onAccountClick)
        this.onAccountClick = config.onAccountClick;
      if (config.onQuickActionClick)
        this.onQuickActionClick = config.onQuickActionClick;
    }
    /**
     * Open the search overlay
     */
    open() {
      if (this.isOpen)
        return;
      this.isOpen = true;
      this._overlay.classList.add(cls2("active"));
      document.body.style.overflow = "hidden";
      setTimeout(() => {
        if (this._input)
          this._input.focus();
      }, 100);
      this._showDefaultState();
    }
    /**
     * Close the search overlay
     */
    close() {
      if (!this.isOpen)
        return;
      this.isOpen = false;
      this._overlay.classList.remove(cls2("active"));
      document.body.style.overflow = "";
      if (this._input)
        this._input.value = "";
      this.searchQuery = "";
      this.isISVSearch = false;
      this.focusedIndex = -1;
      this.results = [];
    }
    /**
     * Toggle the search overlay
     */
    toggle() {
      if (this.isOpen) {
        this.close();
      } else {
        this.open();
      }
    }
    /**
     * Programmatically search
     * @param {string} query
     */
    search(query) {
      if (this._input) {
        this._input.value = query;
      }
      this.searchQuery = query;
      this.isISVSearch = query.toLowerCase().startsWith("isv:");
      this._updateSearchMode();
      this._performSearch(query);
    }
  };
  // Default configuration
  __publicField(_GlobalSearchController, "DEFAULTS", {
    overlaySelector: ".so-search-overlay",
    inputSelector: ".so-search-overlay-input",
    closeSelector: ".so-search-overlay-close",
    backdropSelector: ".so-search-overlay-backdrop",
    quickLinksSelector: ".so-search-quick-links",
    categoryTabsSelector: ".so-search-category-tabs",
    filterBarSelector: ".so-search-filter-bar",
    resultsContainerSelector: ".so-search-results-container",
    resultsGridSelector: ".so-search-results-grid",
    resultsListSelector: ".so-search-results-list",
    emptySelector: ".so-search-empty",
    loadingSelector: ".so-search-loading",
    debounceMs: 300,
    minSearchLength: 2
  });
  var GlobalSearchController = _GlobalSearchController;

  // src/pages/global/global.js
  document.addEventListener("DOMContentLoaded", () => {
    const sidebarEl = document.querySelector(".so-sidebar");
    if (sidebarEl) {
      window.soSidebar = new SidebarController(sidebarEl);
    }
    const navbarEl = document.querySelector(".so-navbar");
    if (navbarEl) {
      window.soNavbar = new NavbarController(navbarEl);
    }
    const searchOverlay = document.querySelector(".so-search-overlay");
    if (searchOverlay) {
      window.globalSearchController = new GlobalSearchController();
    }
  });
})();
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsic3JjL3BhZ2VzL2dsb2JhbC9qcy9fc2lkZWJhci5qcyIsICJzcmMvcGFnZXMvZ2xvYmFsL2pzL19uYXZiYXIuanMiLCAic3JjL3BhZ2VzL2dsb2JhbC9qcy9fc2VhcmNoLmpzIiwgInNyYy9wYWdlcy9nbG9iYWwvZ2xvYmFsLmpzIl0sCiAgInNvdXJjZXNDb250ZW50IjogWyIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU0lERUJBUiBDT05UUk9MTEVSXG4vLyBTdGFuZGFsb25lIHNpZGViYXIgY29tcG9uZW50XG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4vLyBVc2UgcHJlZml4IGZyb20gU2l4T3JiaXQgY29uZmlnIChmYWxsYmFjayB0byAnc28nIGlmIG5vdCBhdmFpbGFibGUpXG5jb25zdCBQUkVGSVggPSAodHlwZW9mIHdpbmRvdyAhPT0gJ3VuZGVmaW5lZCcgJiYgd2luZG93LlNpeE9yYml0Py5QUkVGSVgpIHx8ICdzbyc7XG5jb25zdCBjbHMgPSAoLi4ucGFydHMpID0+IGAke1BSRUZJWH0tJHtwYXJ0cy5qb2luKCctJyl9YDtcblxuLyoqXG4gKiBTaWRlYmFyQ29udHJvbGxlciAtIEhhbmRsZXMgc2lkZWJhciBjb2xsYXBzZS9leHBhbmQsIHBpbm5pbmcsIG1vYmlsZSBtZW51LCBhbmQgc3VibWVudSBuYXZpZ2F0aW9uXG4gKi9cbmNsYXNzIFNpZGViYXJDb250cm9sbGVyIHtcbiAgc3RhdGljIERFRkFVTFRTID0ge1xuICAgIG1haW5Db250ZW50U2VsZWN0b3I6ICcuc28tbWFpbi1jb250ZW50JyxcbiAgICBvdmVybGF5U2VsZWN0b3I6ICcuc28tc2lkZWJhci1vdmVybGF5JyxcbiAgICB0b2dnbGVTZWxlY3RvcjogJy5zby1zaWRlYmFyLXRvZ2dsZScsXG4gICAgc3RvcmFnZUtleTogJ3NvLXNpZGViYXItc3RhdGUnLFxuICAgIGJyZWFrcG9pbnQ6IDEwMjQsIC8vIENoYW5nZWQgZnJvbSA3NjggdG8gMTAyNCBmb3IgdGFibGV0IHN1cHBvcnRcbiAgfTtcblxuICBjb25zdHJ1Y3RvcihlbGVtZW50LCBvcHRpb25zID0ge30pIHtcbiAgICB0aGlzLmVsZW1lbnQgPSBlbGVtZW50O1xuICAgIHRoaXMub3B0aW9ucyA9IHsgLi4uU2lkZWJhckNvbnRyb2xsZXIuREVGQVVMVFMsIC4uLm9wdGlvbnMgfTtcblxuICAgIGlmICghdGhpcy5lbGVtZW50KSByZXR1cm47XG5cbiAgICAvLyBDYWNoZSBET00gZWxlbWVudHNcbiAgICB0aGlzLl9tYWluQ29udGVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IodGhpcy5vcHRpb25zLm1haW5Db250ZW50U2VsZWN0b3IpO1xuICAgIHRoaXMuX292ZXJsYXkgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5vdmVybGF5U2VsZWN0b3IpO1xuICAgIHRoaXMuX3RvZ2dsZSA9IHRoaXMuZWxlbWVudC5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy50b2dnbGVTZWxlY3Rvcik7XG5cbiAgICAvLyBTdGF0ZVxuICAgIHRoaXMuX2lzTW9iaWxlID0gZmFsc2U7XG4gICAgdGhpcy5faXNDb2xsYXBzZWQgPSB0cnVlO1xuICAgIHRoaXMuX2lzT3BlbiA9IGZhbHNlO1xuXG4gICAgLy8gRHJhd2VyIGZvciBtb2JpbGUvdGFibGV0XG4gICAgdGhpcy5fZHJhd2VyID0gbnVsbDtcbiAgICB0aGlzLl9kcmF3ZXJFbGVtZW50ID0gbnVsbDtcblxuICAgIC8vIERpc2FibGUgdHJhbnNpdGlvbnMgaW5pdGlhbGx5XG4gICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ25vLXRyYW5zaXRpb24nKTtcblxuICAgIC8vIENoZWNrIHZpZXdwb3J0IGFuZCByZXN0b3JlIHN0YXRlXG4gICAgdGhpcy5fY2hlY2tNb2JpbGUoKTtcbiAgICB0aGlzLl9yZXN0b3JlU3RhdGUoKTtcblxuICAgIC8vIEluaXRpYWxpemUgZHJhd2VyIGZvciBtb2JpbGUvdGFibGV0XG4gICAgdGhpcy5faW5pdE1vYmlsZURyYXdlcigpO1xuXG4gICAgLy8gQmluZCBldmVudHNcbiAgICB0aGlzLl9iaW5kRXZlbnRzKCk7XG5cbiAgICAvLyBJbml0aWFsaXplIHN1Ym1lbnUgc3RhdGVcbiAgICB0aGlzLl9pbml0U3VibWVudUFycm93cygpO1xuICAgIHRoaXMuX2luaXRTdWJtZW51U3RhdGUoKTtcblxuICAgIC8vIEluaXRpYWxpemUgZm9vdGVyIGJ1dHRvbnNcbiAgICB0aGlzLl9pbml0Rm9vdGVyQnV0dG9ucygpO1xuXG4gICAgLy8gVXBkYXRlIGJvZHkgY2xhc3NcbiAgICB0aGlzLl91cGRhdGVCb2R5Q2xhc3MoKTtcblxuICAgIC8vIFJlLWVuYWJsZSB0cmFuc2l0aW9ucyBhZnRlciBwYWludFxuICAgIHJlcXVlc3RBbmltYXRpb25GcmFtZSgoKSA9PiB7XG4gICAgICByZXF1ZXN0QW5pbWF0aW9uRnJhbWUoKCkgPT4ge1xuICAgICAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnbm8tdHJhbnNpdGlvbicpO1xuICAgICAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc2lkZWJhci1jb2xsYXBzZWQnLCAnc2lkZWJhci1waW5uZWQnKTtcbiAgICAgIH0pO1xuICAgIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIERlYm91bmNlIGhlbHBlclxuICAgKi9cbiAgc3RhdGljIGRlYm91bmNlKGZuLCBkZWxheSkge1xuICAgIGxldCB0aW1lciA9IG51bGw7XG4gICAgcmV0dXJuIGZ1bmN0aW9uICguLi5hcmdzKSB7XG4gICAgICBjbGVhclRpbWVvdXQodGltZXIpO1xuICAgICAgdGltZXIgPSBzZXRUaW1lb3V0KCgpID0+IGZuLmFwcGx5KHRoaXMsIGFyZ3MpLCBkZWxheSk7XG4gICAgfTtcbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIG1vYmlsZSBkcmF3ZXIgZnJvbSBzaWRlYmFyIGNvbnRlbnRcbiAgICogQ3JlYXRlcyBhIFNPRHJhd2VyIHRoYXQgbWlycm9ycyB0aGUgc2lkZWJhciBmb3IgbW9iaWxlL3RhYmxldFxuICAgKi9cbiAgX2luaXRNb2JpbGVEcmF3ZXIoKSB7XG4gICAgLy8gT25seSBjcmVhdGUgZHJhd2VyIGlmIFNPRHJhd2VyIGlzIGF2YWlsYWJsZVxuICAgIGlmICh0eXBlb2YgU09EcmF3ZXIgPT09ICd1bmRlZmluZWQnKSB7XG4gICAgICBjb25zb2xlLndhcm4oJ1NPRHJhd2VyIG5vdCBhdmFpbGFibGUsIGZhbGxpbmcgYmFjayB0byBvdmVybGF5IHNpZGViYXInKTtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICAvLyBDcmVhdGUgZHJhd2VyIGVsZW1lbnRcbiAgICB0aGlzLl9kcmF3ZXJFbGVtZW50ID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG4gICAgdGhpcy5fZHJhd2VyRWxlbWVudC5pZCA9ICdtb2JpbGVTaWRlYmFyRHJhd2VyJztcbiAgICB0aGlzLl9kcmF3ZXJFbGVtZW50LmNsYXNzTmFtZSA9ICdzby1kcmF3ZXIgc28tZHJhd2VyLWxlZnQgc28tZHJhd2VyLXNpZGViYXInO1xuICAgIHRoaXMuX2RyYXdlckVsZW1lbnQudGFiSW5kZXggPSAtMTtcblxuICAgIC8vIFRyYW5zZmVyIHNpZGViYXItZGFyayBjbGFzcyBpZiBwcmVzZW50XG4gICAgaWYgKHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ3NpZGViYXItZGFyaycpKSB7XG4gICAgICB0aGlzLl9kcmF3ZXJFbGVtZW50LmNsYXNzTGlzdC5hZGQoJ2RyYXdlci1zaWRlYmFyLWRhcmsnKTtcbiAgICB9XG5cbiAgICAvLyBHZXQgc2lkZWJhciBjb250ZW50XG4gICAgY29uc3Qgc2lkZWJhckhlYWRlciA9IHRoaXMuZWxlbWVudC5xdWVyeVNlbGVjdG9yKCcuc28tc2lkZWJhci1oZWFkZXInKTtcbiAgICBjb25zdCBzaWRlYmFyU2Nyb2xsID0gdGhpcy5lbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1zaWRlYmFyLXNjcm9sbCcpO1xuICAgIGNvbnN0IHNpZGViYXJGb290ZXIgPSB0aGlzLmVsZW1lbnQucXVlcnlTZWxlY3RvcignLnNvLXNpZGViYXItZm9vdGVyJyk7XG5cbiAgICAvLyBCdWlsZCBkcmF3ZXIgSFRNTFxuICAgIHRoaXMuX2RyYXdlckVsZW1lbnQuaW5uZXJIVE1MID0gYFxuICAgICAgPGRpdiBjbGFzcz1cInNvLWRyYXdlci1oZWFkZXJcIj5cbiAgICAgICAgPGRpdiBjbGFzcz1cInNvLWRyYXdlci1icmFuZFwiPlxuICAgICAgICAgICR7c2lkZWJhckhlYWRlciA/IHNpZGViYXJIZWFkZXIuaW5uZXJIVE1MIDogJyd9XG4gICAgICAgIDwvZGl2PlxuICAgICAgICA8YnV0dG9uIGNsYXNzPVwic28tZHJhd2VyLWNsb3NlXCIgZGF0YS1kaXNtaXNzPVwiZHJhd2VyXCI+XG4gICAgICAgICAgPHNwYW4gY2xhc3M9XCJtYXRlcmlhbC1pY29uc1wiPmNsb3NlPC9zcGFuPlxuICAgICAgICA8L2J1dHRvbj5cbiAgICAgIDwvZGl2PlxuICAgICAgPGRpdiBjbGFzcz1cInNvLWRyYXdlci1ib2R5IHNvLWRyYXdlci1zaWRlYmFyLWJvZHlcIj5cbiAgICAgICAgJHtzaWRlYmFyU2Nyb2xsID8gc2lkZWJhclNjcm9sbC5pbm5lckhUTUwgOiAnJ31cbiAgICAgIDwvZGl2PlxuICAgICAgJHtzaWRlYmFyRm9vdGVyID8gYDxkaXYgY2xhc3M9XCJzby1kcmF3ZXItZm9vdGVyXCI+JHtzaWRlYmFyRm9vdGVyLmlubmVySFRNTH08L2Rpdj5gIDogJyd9XG4gICAgYDtcblxuICAgIC8vIEFwcGVuZCB0byBib2R5XG4gICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCh0aGlzLl9kcmF3ZXJFbGVtZW50KTtcblxuICAgIC8vIEluaXRpYWxpemUgU09EcmF3ZXIgaW5zdGFuY2VcbiAgICB0aGlzLl9kcmF3ZXIgPSBuZXcgU09EcmF3ZXIodGhpcy5fZHJhd2VyRWxlbWVudCwge1xuICAgICAgYmFja2Ryb3A6IHRydWUsXG4gICAgICBrZXlib2FyZDogdHJ1ZSxcbiAgICAgIHNjcm9sbDogZmFsc2UsXG4gICAgICBhbmltYXRpb246IHRydWUsXG4gICAgfSk7XG5cbiAgICAvLyBCaW5kIGRyYXdlciBldmVudHNcbiAgICB0aGlzLl9iaW5kRHJhd2VyRXZlbnRzKCk7XG5cbiAgICAvLyBJbml0aWFsaXplIHN1Ym1lbnUgc3RhdGUgaW4gZHJhd2VyXG4gICAgdGhpcy5faW5pdERyYXdlclN1Ym1lbnVTdGF0ZSgpO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZHJhd2VyLXNwZWNpZmljIGV2ZW50c1xuICAgKi9cbiAgX2JpbmREcmF3ZXJFdmVudHMoKSB7XG4gICAgaWYgKCF0aGlzLl9kcmF3ZXJFbGVtZW50KSByZXR1cm47XG5cbiAgICAvLyBTeW5jIGRyYXdlciBjbG9zZSB3aXRoIHNpZGViYXIgc3RhdGVcbiAgICB0aGlzLl9kcmF3ZXJFbGVtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2RyYXdlcjpoaWRkZW4nLCAoKSA9PiB7XG4gICAgICB0aGlzLl9pc09wZW4gPSBmYWxzZTtcbiAgICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnc28tc2lkZWJhci1vcGVuJyk7XG4gICAgfSk7XG5cbiAgICAvLyBIYW5kbGUgbmF2aWdhdGlvbiBjbGlja3MgaW4gZHJhd2VyXG4gICAgdGhpcy5fZHJhd2VyRWxlbWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICBjb25zdCBsaW5rID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLXNpZGViYXItbGluaycpO1xuICAgICAgaWYgKGxpbmspIHtcbiAgICAgICAgY29uc3QgaXRlbSA9IGxpbmsucGFyZW50RWxlbWVudDtcbiAgICAgICAgY29uc3Qgc3VibWVudSA9IGl0ZW0ucXVlcnlTZWxlY3RvcignLnNvLXNpZGViYXItc3VibWVudScpO1xuICAgICAgICBpZiAoc3VibWVudSkge1xuICAgICAgICAgIC8vIFRvZ2dsZSBzdWJtZW51XG4gICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgIHRoaXMuX3RvZ2dsZURyYXdlclN1Ym1lbnUoaXRlbSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgLy8gUmVndWxhciBsaW5rIC0gY2xvc2UgZHJhd2VyIGFmdGVyIG5hdmlnYXRpb25cbiAgICAgICAgICAvLyBTbWFsbCBkZWxheSB0byBhbGxvdyByaXBwbGUgZWZmZWN0XG4gICAgICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgICAgICBpZiAodGhpcy5fZHJhd2VyKSB7XG4gICAgICAgICAgICAgIHRoaXMuX2RyYXdlci5oaWRlKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSwgMTUwKTtcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH0pO1xuXG4gICAgLy8gSGFuZGxlIGZvb3RlciBidXR0b24gY2xpY2tzXG4gICAgdGhpcy5fZHJhd2VyRWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2lkZWJhci1mb290ZXItaXRlbScpLmZvckVhY2goYnRuID0+IHtcbiAgICAgIGJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgICAgICAgLy8gQ2xvc2UgZHJhd2VyIGFmdGVyIGZvb3RlciBhY3Rpb25cbiAgICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgICAgaWYgKHRoaXMuX2RyYXdlcikge1xuICAgICAgICAgICAgdGhpcy5fZHJhd2VyLmhpZGUoKTtcbiAgICAgICAgICB9XG4gICAgICAgIH0sIDE1MCk7XG4gICAgICB9KTtcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBUb2dnbGUgc3VibWVudSBpbiBkcmF3ZXJcbiAgICovXG4gIF90b2dnbGVEcmF3ZXJTdWJtZW51KGl0ZW0pIHtcbiAgICBjb25zdCBpc09wZW4gPSBpdGVtLmNsYXNzTGlzdC5jb250YWlucyhjbHMoJ29wZW4nKSk7XG4gICAgY29uc3QgcGFyZW50ID0gaXRlbS5wYXJlbnRFbGVtZW50O1xuXG4gICAgLy8gQ2xvc2Ugc2libGluZ3NcbiAgICBwYXJlbnQucXVlcnlTZWxlY3RvckFsbCgnOnNjb3BlID4gLnNvLXNpZGViYXItaXRlbS5zby1vcGVuJykuZm9yRWFjaChzaWJsaW5nID0+IHtcbiAgICAgIGlmIChzaWJsaW5nICE9PSBpdGVtKSB7XG4gICAgICAgIHNpYmxpbmcuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ29wZW4nKSk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBUb2dnbGUgY3VycmVudFxuICAgIGl0ZW0uY2xhc3NMaXN0LnRvZ2dsZShjbHMoJ29wZW4nKSwgIWlzT3Blbik7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSBzdWJtZW51IHN0YXRlIGluIGRyYXdlciBiYXNlZCBvbiBjdXJyZW50IHBhZ2VcbiAgICovXG4gIF9pbml0RHJhd2VyU3VibWVudVN0YXRlKCkge1xuICAgIGlmICghdGhpcy5fZHJhd2VyRWxlbWVudCkgcmV0dXJuO1xuXG4gICAgLy8gQ29weSBhY3RpdmUvY3VycmVudCBjbGFzc2VzIGZyb20gc2lkZWJhciB0byBkcmF3ZXJcbiAgICBjb25zdCBzaWRlYmFySXRlbXMgPSB0aGlzLmVsZW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLXNpZGViYXItaXRlbScpO1xuICAgIGNvbnN0IGRyYXdlckl0ZW1zID0gdGhpcy5fZHJhd2VyRWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2lkZWJhci1pdGVtJyk7XG5cbiAgICBzaWRlYmFySXRlbXMuZm9yRWFjaCgoc2lkZWJhckl0ZW0sIGluZGV4KSA9PiB7XG4gICAgICBpZiAoZHJhd2VySXRlbXNbaW5kZXhdKSB7XG4gICAgICAgIGlmIChzaWRlYmFySXRlbS5jbGFzc0xpc3QuY29udGFpbnMoJ2N1cnJlbnQnKSkge1xuICAgICAgICAgIGRyYXdlckl0ZW1zW2luZGV4XS5jbGFzc0xpc3QuYWRkKCdjdXJyZW50Jyk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKHNpZGViYXJJdGVtLmNsYXNzTGlzdC5jb250YWlucygnYWN0aXZlJykpIHtcbiAgICAgICAgICBkcmF3ZXJJdGVtc1tpbmRleF0uY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKHNpZGViYXJJdGVtLmNsYXNzTGlzdC5jb250YWlucyhjbHMoJ29wZW4nKSkpIHtcbiAgICAgICAgICBkcmF3ZXJJdGVtc1tpbmRleF0uY2xhc3NMaXN0LmFkZChjbHMoJ29wZW4nKSk7XG4gICAgICAgIH1cbiAgICAgIH1cbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBVcGRhdGUgZHJhd2VyIHRoZW1lIHdoZW4gc2lkZWJhciB0aGVtZSBjaGFuZ2VzXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gaXNEYXJrIC0gV2hldGhlciBkYXJrIHRoZW1lIGlzIGFjdGl2ZVxuICAgKi9cbiAgc2V0RHJhd2VyVGhlbWUoaXNEYXJrKSB7XG4gICAgaWYgKHRoaXMuX2RyYXdlckVsZW1lbnQpIHtcbiAgICAgIHRoaXMuX2RyYXdlckVsZW1lbnQuY2xhc3NMaXN0LnRvZ2dsZSgnZHJhd2VyLXNpZGViYXItZGFyaycsIGlzRGFyayk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBXaW5kb3cgcmVzaXplXG4gICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Jlc2l6ZScsIFNpZGViYXJDb250cm9sbGVyLmRlYm91bmNlKCgpID0+IHtcbiAgICAgIGNvbnN0IHdhc01vYmlsZSA9IHRoaXMuX2lzTW9iaWxlO1xuICAgICAgdGhpcy5fY2hlY2tNb2JpbGUoKTtcblxuICAgICAgLy8gQ2xvc2UgZHJhd2VyIHdoZW4gc3dpdGNoaW5nIGZyb20gbW9iaWxlIHRvIGRlc2t0b3BcbiAgICAgIGlmICh3YXNNb2JpbGUgJiYgIXRoaXMuX2lzTW9iaWxlICYmIHRoaXMuX2RyYXdlciAmJiB0aGlzLl9kcmF3ZXIuaXNPcGVuKCkpIHtcbiAgICAgICAgdGhpcy5fZHJhd2VyLmhpZGUoKTtcbiAgICAgIH1cblxuICAgICAgLy8gQ2xvc2UgbW9iaWxlIG92ZXJsYXkgaWYgdXNpbmcgZmFsbGJhY2tcbiAgICAgIGlmICh0aGlzLl9pc01vYmlsZSAmJiAhdGhpcy5fZHJhd2VyKSB7XG4gICAgICAgIHRoaXMuX2Nsb3NlTW9iaWxlKCk7XG4gICAgICB9XG5cbiAgICAgIHRoaXMuX3VwZGF0ZUJvZHlDbGFzcygpO1xuICAgIH0sIDE1MCkpO1xuXG4gICAgLy8gVG9nZ2xlIGJ1dHRvbiAocGluL3VucGluKVxuICAgIGlmICh0aGlzLl90b2dnbGUpIHtcbiAgICAgIHRoaXMuX3RvZ2dsZS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgdGhpcy50b2dnbGVQaW5uZWQoKTtcbiAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIE1vYmlsZSB0b2dnbGUgYnV0dG9uc1xuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ1tkYXRhLXRvZ2dsZT1cInNpZGViYXJcIl0nKS5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGlmICh0aGlzLl9pc01vYmlsZSkge1xuICAgICAgICAgIHRoaXMudG9nZ2xlTW9iaWxlKCk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgdGhpcy50b2dnbGVQaW5uZWQoKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICAvLyBPdmVybGF5IGNsaWNrXG4gICAgaWYgKHRoaXMuX292ZXJsYXkpIHtcbiAgICAgIHRoaXMuX292ZXJsYXkuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB0aGlzLl9jbG9zZU1vYmlsZSgpKTtcbiAgICB9XG5cbiAgICAvLyBTdWJtZW51IHRvZ2dsZVxuICAgIHRoaXMuZWxlbWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICBjb25zdCBsaW5rID0gZS50YXJnZXQuY2xvc2VzdCgnLnNvLXNpZGViYXItbGluaycpO1xuICAgICAgaWYgKGxpbmspIHtcbiAgICAgICAgY29uc3QgaXRlbSA9IGxpbmsucGFyZW50RWxlbWVudDtcbiAgICAgICAgY29uc3Qgc3VibWVudSA9IGl0ZW0ucXVlcnlTZWxlY3RvcignLnNvLXNpZGViYXItc3VibWVudScpO1xuICAgICAgICBpZiAoc3VibWVudSkge1xuICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICB0aGlzLl90b2dnbGVTdWJtZW51KGl0ZW0pO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBFc2NhcGUga2V5XG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcigna2V5ZG93bicsIChlKSA9PiB7XG4gICAgICBpZiAoZS5rZXkgPT09ICdFc2NhcGUnICYmIHRoaXMuX2lzTW9iaWxlICYmIHRoaXMuX2lzT3Blbikge1xuICAgICAgICB0aGlzLl9jbG9zZU1vYmlsZSgpO1xuICAgICAgfVxuICAgIH0pO1xuICB9XG5cbiAgLyoqXG4gICAqIENoZWNrIGlmIHZpZXdwb3J0IGlzIG1vYmlsZVxuICAgKi9cbiAgX2NoZWNrTW9iaWxlKCkge1xuICAgIC8vIFVzZSA8IHRvIG1hdGNoIENTUyBtZWRpYSBxdWVyeTogQGluY2x1ZGUgbWVkaWEtZG93bignbGcnKSA9IG1heC13aWR0aDogMTAyM3B4XG4gICAgdGhpcy5faXNNb2JpbGUgPSB3aW5kb3cuaW5uZXJXaWR0aCA8IHRoaXMub3B0aW9ucy5icmVha3BvaW50O1xuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBib2R5IGNsYXNzIGJhc2VkIG9uIHNpZGViYXIgc3RhdGVcbiAgICovXG4gIF91cGRhdGVCb2R5Q2xhc3MoKSB7XG4gICAgaWYgKHRoaXMuX2lzQ29sbGFwc2VkICYmICF0aGlzLl9pc01vYmlsZSkge1xuICAgICAgZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuYWRkKCdzaWRlYmFyLWNvbGxhcHNlZCcpO1xuICAgIH0gZWxzZSB7XG4gICAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5yZW1vdmUoJ3NpZGViYXItY29sbGFwc2VkJyk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBwaW5uZWQgc3RhdGVcbiAgICovXG4gIHRvZ2dsZVBpbm5lZCgpIHtcbiAgICB0aGlzLl9pc0NvbGxhcHNlZCA9ICF0aGlzLl9pc0NvbGxhcHNlZDtcblxuICAgIC8vIEJhdGNoIGFsbCBjbGFzcyBjaGFuZ2VzIGluIGEgc2luZ2xlIGZyYW1lIGZvciBzeW5jaHJvbml6ZWQgYW5pbWF0aW9uXG4gICAgcmVxdWVzdEFuaW1hdGlvbkZyYW1lKCgpID0+IHtcbiAgICAgIGlmICh0aGlzLl9pc0NvbGxhcHNlZCkge1xuICAgICAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnc28tY29sbGFwc2VkJyk7XG4gICAgICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdwaW5uZWQnKTtcbiAgICAgICAgZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuYWRkKCdzaWRlYmFyLWNvbGxhcHNlZCcpO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLWNvbGxhcHNlZCcpO1xuICAgICAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZCgncGlubmVkJyk7XG4gICAgICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnc2lkZWJhci1jb2xsYXBzZWQnKTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgIHRoaXMuX3NhdmVTdGF0ZSh0aGlzLl9pc0NvbGxhcHNlZCA/ICdjb2xsYXBzZWQnIDogJ3Bpbm5lZCcpO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH1cblxuICAvKipcbiAgICogUGluIHRoZSBzaWRlYmFyIChleHBhbmQpXG4gICAqL1xuICBwaW4oKSB7XG4gICAgaWYgKCF0aGlzLl9pc0NvbGxhcHNlZCkgcmV0dXJuIHRoaXM7XG4gICAgcmV0dXJuIHRoaXMudG9nZ2xlUGlubmVkKCk7XG4gIH1cblxuICAvKipcbiAgICogVW5waW4gdGhlIHNpZGViYXIgKGNvbGxhcHNlKVxuICAgKi9cbiAgdW5waW4oKSB7XG4gICAgaWYgKHRoaXMuX2lzQ29sbGFwc2VkKSByZXR1cm4gdGhpcztcbiAgICByZXR1cm4gdGhpcy50b2dnbGVQaW5uZWQoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBDaGVjayBpZiBzaWRlYmFyIGlzIHBpbm5lZFxuICAgKi9cbiAgaXNQaW5uZWQoKSB7XG4gICAgcmV0dXJuICF0aGlzLl9pc0NvbGxhcHNlZDtcbiAgfVxuXG4gIC8qKlxuICAgKiBUb2dnbGUgbW9iaWxlIHNpZGViYXJcbiAgICovXG4gIHRvZ2dsZU1vYmlsZSgpIHtcbiAgICAvLyBVc2UgZHJhd2VyIGlmIGF2YWlsYWJsZVxuICAgIGlmICh0aGlzLl9kcmF3ZXIpIHtcbiAgICAgIHJldHVybiB0aGlzLl9kcmF3ZXIudG9nZ2xlKCk7XG4gICAgfVxuICAgIC8vIEZhbGxiYWNrIHRvIG92ZXJsYXkgcGF0dGVyblxuICAgIHJldHVybiB0aGlzLl9pc09wZW4gPyB0aGlzLl9jbG9zZU1vYmlsZSgpIDogdGhpcy5fb3Blbk1vYmlsZSgpO1xuICB9XG5cbiAgLyoqXG4gICAqIE9wZW4gbW9iaWxlIHNpZGViYXJcbiAgICovXG4gIF9vcGVuTW9iaWxlKCkge1xuICAgIC8vIFVzZSBkcmF3ZXIgaWYgYXZhaWxhYmxlXG4gICAgaWYgKHRoaXMuX2RyYXdlcikge1xuICAgICAgdGhpcy5faXNPcGVuID0gdHJ1ZTtcbiAgICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmFkZCgnc28tc2lkZWJhci1vcGVuJyk7XG4gICAgICByZXR1cm4gdGhpcy5fZHJhd2VyLnNob3coKTtcbiAgICB9XG4gICAgLy8gRmFsbGJhY2sgdG8gb3ZlcmxheSBwYXR0ZXJuXG4gICAgdGhpcy5faXNPcGVuID0gdHJ1ZTtcbiAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LmFkZChjbHMoJ29wZW4nKSk7XG4gICAgdGhpcy5fb3ZlcmxheT8uY2xhc3NMaXN0LmFkZChjbHMoJ2FjdGl2ZScpKTtcbiAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoJ3NvLXNpZGViYXItb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnaGlkZGVuJztcbiAgICByZXR1cm4gdGhpcztcbiAgfVxuXG4gIC8qKlxuICAgKiBDbG9zZSBtb2JpbGUgc2lkZWJhclxuICAgKi9cbiAgX2Nsb3NlTW9iaWxlKCkge1xuICAgIC8vIFVzZSBkcmF3ZXIgaWYgYXZhaWxhYmxlXG4gICAgaWYgKHRoaXMuX2RyYXdlcikge1xuICAgICAgdGhpcy5faXNPcGVuID0gZmFsc2U7XG4gICAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5yZW1vdmUoJ3NvLXNpZGViYXItb3BlbicpO1xuICAgICAgcmV0dXJuIHRoaXMuX2RyYXdlci5oaWRlKCk7XG4gICAgfVxuICAgIC8vIEZhbGxiYWNrIHRvIG92ZXJsYXkgcGF0dGVyblxuICAgIHRoaXMuX2lzT3BlbiA9IGZhbHNlO1xuICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKGNscygnb3BlbicpKTtcbiAgICB0aGlzLl9vdmVybGF5Py5jbGFzc0xpc3QucmVtb3ZlKGNscygnYWN0aXZlJykpO1xuICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnc28tc2lkZWJhci1vcGVuJyk7XG4gICAgZG9jdW1lbnQuYm9keS5zdHlsZS5vdmVyZmxvdyA9ICcnO1xuICAgIHJldHVybiB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIFRvZ2dsZSBzdWJtZW51XG4gICAqL1xuICBfdG9nZ2xlU3VibWVudShpdGVtKSB7XG4gICAgY29uc3QgaXNPcGVuID0gaXRlbS5jbGFzc0xpc3QuY29udGFpbnMoY2xzKCdvcGVuJykpO1xuICAgIGNvbnN0IHBhcmVudCA9IGl0ZW0ucGFyZW50RWxlbWVudDtcblxuICAgIC8vIENsb3NlIHNpYmxpbmdzXG4gICAgcGFyZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJzpzY29wZSA+IC5zby1zaWRlYmFyLWl0ZW0uc28tb3BlbicpLmZvckVhY2goc2libGluZyA9PiB7XG4gICAgICBpZiAoc2libGluZyAhPT0gaXRlbSkge1xuICAgICAgICBzaWJsaW5nLmNsYXNzTGlzdC5yZW1vdmUoY2xzKCdvcGVuJykpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgLy8gVG9nZ2xlIGN1cnJlbnRcbiAgICBpdGVtLmNsYXNzTGlzdC50b2dnbGUoY2xzKCdvcGVuJyksICFpc09wZW4pO1xuICB9XG5cbiAgLyoqXG4gICAqIEluaXRpYWxpemUgYXJyb3dzIGZvciBuZXN0ZWQgc3VibWVudSBpdGVtc1xuICAgKi9cbiAgX2luaXRTdWJtZW51QXJyb3dzKCkge1xuICAgIHRoaXMuZWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2lkZWJhci1zdWJtZW51IC5zby1zaWRlYmFyLWl0ZW0nKS5mb3JFYWNoKGl0ZW0gPT4ge1xuICAgICAgY29uc3QgbmVzdGVkU3VibWVudSA9IGl0ZW0ucXVlcnlTZWxlY3RvcignOnNjb3BlID4gLnNvLXNpZGViYXItc3VibWVudScpO1xuICAgICAgaWYgKG5lc3RlZFN1Ym1lbnUpIHtcbiAgICAgICAgaXRlbS5jbGFzc0xpc3QuYWRkKCdoYXMtY2hpbGRyZW4nKTtcblxuICAgICAgICBjb25zdCBsaW5rID0gaXRlbS5xdWVyeVNlbGVjdG9yKCc6c2NvcGUgPiAuc28tc2lkZWJhci1saW5rJyk7XG4gICAgICAgIGlmIChsaW5rICYmICFsaW5rLnF1ZXJ5U2VsZWN0b3IoJy5zby1zaWRlYmFyLWFycm93JykpIHtcbiAgICAgICAgICBjb25zdCBhcnJvdyA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3NwYW4nKTtcbiAgICAgICAgICBhcnJvdy5jbGFzc05hbWUgPSAnc28tc2lkZWJhci1hcnJvdyc7XG4gICAgICAgICAgYXJyb3cuaW5uZXJIVE1MID0gJzxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj5jaGV2cm9uX3JpZ2h0PC9zcGFuPic7XG4gICAgICAgICAgbGluay5hcHBlbmRDaGlsZChhcnJvdyk7XG4gICAgICAgIH1cbiAgICAgIH1cbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHN1Ym1lbnUgc3RhdGUgYmFzZWQgb24gYWN0aXZlIGl0ZW1zXG4gICAqL1xuICBfaW5pdFN1Ym1lbnVTdGF0ZSgpIHtcbiAgICB0aGlzLmVsZW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnNvLXNpZGViYXItaXRlbS5jdXJyZW50LCAuc28tc2lkZWJhci1pdGVtLmFjdGl2ZScpLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICBsZXQgcGFyZW50ID0gaXRlbS5wYXJlbnRFbGVtZW50LmNsb3Nlc3QoJy5zby1zaWRlYmFyLWl0ZW0nKTtcbiAgICAgIHdoaWxlIChwYXJlbnQpIHtcbiAgICAgICAgcGFyZW50LmNsYXNzTGlzdC5hZGQoY2xzKCdvcGVuJykpO1xuICAgICAgICBwYXJlbnQgPSBwYXJlbnQucGFyZW50RWxlbWVudC5jbG9zZXN0KCcuc28tc2lkZWJhci1pdGVtJyk7XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSBzaWRlYmFyIGZvb3RlciBidXR0b25zXG4gICAqL1xuICBfaW5pdEZvb3RlckJ1dHRvbnMoKSB7XG4gICAgY29uc3QgZm9vdGVyID0gdGhpcy5lbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1zaWRlYmFyLWZvb3RlcicpO1xuICAgIGlmICghZm9vdGVyKSByZXR1cm47XG5cbiAgICAvLyBJbmZvIGJ1dHRvbiAtIHRvZ2dsZSBwb3B1cFxuICAgIGNvbnN0IGluZm9CdG4gPSBmb290ZXIucXVlcnlTZWxlY3RvcignI3NpZGViYXJJbmZvQnRuJyk7XG4gICAgY29uc3QgaW5mb1BvcHVwID0gZm9vdGVyLnF1ZXJ5U2VsZWN0b3IoJyNzaWRlYmFySW5mb1BvcHVwJyk7XG4gICAgaWYgKGluZm9CdG4gJiYgaW5mb1BvcHVwKSB7XG4gICAgICBpbmZvQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgaW5mb1BvcHVwLmNsYXNzTGlzdC50b2dnbGUoJ3NvLWFjdGl2ZScpO1xuICAgICAgfSk7XG5cbiAgICAgIC8vIENsb3NlIHBvcHVwIG9uIG91dHNpZGUgY2xpY2tcbiAgICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgaWYgKCFpbmZvUG9wdXAuY29udGFpbnMoZS50YXJnZXQpICYmICFpbmZvQnRuLmNvbnRhaW5zKGUudGFyZ2V0KSkge1xuICAgICAgICAgIGluZm9Qb3B1cC5jbGFzc0xpc3QucmVtb3ZlKCdzby1hY3RpdmUnKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gRnVsbHNjcmVlbiBidXR0b25cbiAgICBjb25zdCBmdWxsc2NyZWVuQnRuID0gZm9vdGVyLnF1ZXJ5U2VsZWN0b3IoJyNzaWRlYmFyRnVsbHNjcmVlbkJ0bicpO1xuICAgIGlmIChmdWxsc2NyZWVuQnRuKSB7XG4gICAgICBmdWxsc2NyZWVuQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgdGhpcy5fdG9nZ2xlRnVsbHNjcmVlbigpO1xuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gTmF2YmFyIGZ1bGxzY3JlZW4gYnV0dG9uIChpbiB1c2VyIGRyb3Bkb3duKVxuICAgIGNvbnN0IG5hdmJhckZ1bGxzY3JlZW5CdG4gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbmF2YmFyRnVsbHNjcmVlbkJ0bicpO1xuICAgIGlmIChuYXZiYXJGdWxsc2NyZWVuQnRuKSB7XG4gICAgICBuYXZiYXJGdWxsc2NyZWVuQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgdGhpcy5fdG9nZ2xlRnVsbHNjcmVlbigpO1xuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gTGlzdGVuIGZvciBmdWxsc2NyZWVuIGNoYW5nZSB0byB1cGRhdGUgaWNvbnNcbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdmdWxsc2NyZWVuY2hhbmdlJywgKCkgPT4gdGhpcy5fdXBkYXRlRnVsbHNjcmVlbkljb24oKSk7XG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignd2Via2l0ZnVsbHNjcmVlbmNoYW5nZScsICgpID0+IHRoaXMuX3VwZGF0ZUZ1bGxzY3JlZW5JY29uKCkpO1xuXG4gICAgLy8gTG9nb3V0IGJ1dHRvbnMgLSB1c2UgZnJhbWV3b3JrJ3MgU09Nb2RhbC5jb25maXJtKClcbiAgICBjb25zdCBzaWRlYmFyTG9nb3V0QnRuID0gZm9vdGVyLnF1ZXJ5U2VsZWN0b3IoJyNzaWRlYmFyTG9nb3V0QnRuJyk7XG4gICAgY29uc3QgbmF2YmFyTG9nb3V0QnRuID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ25hdmJhckxvZ291dEJ0bicpO1xuXG4gICAgY29uc3QgaGFuZGxlTG9nb3V0ID0gKCkgPT4ge1xuICAgICAgbG9jYWxTdG9yYWdlLnJlbW92ZUl0ZW0oJ3NvLXVzZXItc2Vzc2lvbicpO1xuICAgICAgbG9jYWxTdG9yYWdlLnJlbW92ZUl0ZW0oJ3NvLXNjcmVlbi1sb2NrZWQnKTtcbiAgICAgIHNlc3Npb25TdG9yYWdlLmNsZWFyKCk7XG4gICAgICAvLyBOYXZpZ2F0ZSB0byBsb2dpbiBwYWdlIHJlbGF0aXZlIHRvIGRlbW8gcm9vdFxuICAgICAgY29uc3QgY3VycmVudFBhdGggPSB3aW5kb3cubG9jYXRpb24ucGF0aG5hbWU7XG4gICAgICBjb25zdCBkZW1vSW5kZXggPSBjdXJyZW50UGF0aC5pbmRleE9mKCcvZGVtby8nKTtcbiAgICAgIGlmIChkZW1vSW5kZXggIT09IC0xKSB7XG4gICAgICAgIGNvbnN0IGJhc2VQYXRoID0gY3VycmVudFBhdGguc3Vic3RyaW5nKDAsIGRlbW9JbmRleCArIDYpOyAvLyBpbmNsdWRlcyAnL2RlbW8vJ1xuICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IGJhc2VQYXRoICsgJ2xvZ2luLnBocCc7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9ICcvZGVtby9sb2dpbi5waHAnO1xuICAgICAgfVxuICAgIH07XG5cbiAgICBjb25zdCBzaG93TG9nb3V0Q29uZmlybWF0aW9uID0gYXN5bmMgKCkgPT4ge1xuICAgICAgLy8gVXNlIGZyYW1ld29yaydzIFNPTW9kYWwuY29uZmlybSgpXG4gICAgICBpZiAodHlwZW9mIFNPTW9kYWwgIT09ICd1bmRlZmluZWQnICYmIFNPTW9kYWwuY29uZmlybSkge1xuICAgICAgICBjb25zdCBjb25maXJtZWQgPSBhd2FpdCBTT01vZGFsLmNvbmZpcm0oe1xuICAgICAgICAgIHRpdGxlOiAnQ29uZmlybSBMb2dvdXQnLFxuICAgICAgICAgIG1lc3NhZ2U6ICdBcmUgeW91IHN1cmUgeW91IHdhbnQgdG8gbG9nb3V0PyBBbnkgdW5zYXZlZCBjaGFuZ2VzIHdpbGwgYmUgbG9zdC4nLFxuICAgICAgICAgIGljb246IHsgbmFtZTogJ2xvZ291dCcsIHR5cGU6ICdkYW5nZXInIH0sXG4gICAgICAgICAgY29uZmlybTogW3sgaWNvbjogJ2xvZ291dCcgfSwgJ0xvZ291dCddLFxuICAgICAgICAgIGNhbmNlbDogJ0NhbmNlbCcsXG4gICAgICAgICAgZGFuZ2VyOiB0cnVlXG4gICAgICAgIH0pO1xuICAgICAgICBpZiAoY29uZmlybWVkKSB7XG4gICAgICAgICAgaGFuZGxlTG9nb3V0KCk7XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIC8vIEZhbGxiYWNrIGlmIFNPTW9kYWwgbm90IGF2YWlsYWJsZVxuICAgICAgICBpZiAoY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGxvZ291dD8nKSkge1xuICAgICAgICAgIGhhbmRsZUxvZ291dCgpO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfTtcblxuICAgIGlmIChzaWRlYmFyTG9nb3V0QnRuKSB7XG4gICAgICBzaWRlYmFyTG9nb3V0QnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICBzaG93TG9nb3V0Q29uZmlybWF0aW9uKCk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICBpZiAobmF2YmFyTG9nb3V0QnRuKSB7XG4gICAgICBuYXZiYXJMb2dvdXRCdG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgIHNob3dMb2dvdXRDb25maXJtYXRpb24oKTtcbiAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIExvY2sgU2NyZWVuIGJ1dHRvblxuICAgIGNvbnN0IGxvY2tTY3JlZW5CdG4gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9ja1NjcmVlbkJ0bicpO1xuICAgIGNvbnN0IGxvY2tTY3JlZW4gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9ja1NjcmVlbicpO1xuICAgIGNvbnN0IGxvY2tTY3JlZW5Gb3JtID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvY2tTY3JlZW5Gb3JtJyk7XG4gICAgY29uc3QgbG9ja1NjcmVlblBhc3N3b3JkID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvY2tTY3JlZW5QYXNzd29yZCcpO1xuICAgIGNvbnN0IGxvY2tTY3JlZW5UaW1lID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvY2tTY3JlZW5UaW1lJyk7XG4gICAgY29uc3QgbG9ja1NjcmVlbkRhdGUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9ja1NjcmVlbkRhdGUnKTtcblxuICAgIGNvbnN0IHVwZGF0ZUxvY2tTY3JlZW5UaW1lID0gKCkgPT4ge1xuICAgICAgY29uc3Qgbm93ID0gbmV3IERhdGUoKTtcbiAgICAgIGNvbnN0IGhvdXJzID0gbm93LmdldEhvdXJzKCkudG9TdHJpbmcoKS5wYWRTdGFydCgyLCAnMCcpO1xuICAgICAgY29uc3QgbWludXRlcyA9IG5vdy5nZXRNaW51dGVzKCkudG9TdHJpbmcoKS5wYWRTdGFydCgyLCAnMCcpO1xuICAgICAgaWYgKGxvY2tTY3JlZW5UaW1lKSBsb2NrU2NyZWVuVGltZS50ZXh0Q29udGVudCA9IGAke2hvdXJzfToke21pbnV0ZXN9YDtcbiAgICAgIGlmIChsb2NrU2NyZWVuRGF0ZSkge1xuICAgICAgICBjb25zdCBvcHRpb25zID0geyB3ZWVrZGF5OiAnbG9uZycsIG1vbnRoOiAnbG9uZycsIGRheTogJ251bWVyaWMnIH07XG4gICAgICAgIGxvY2tTY3JlZW5EYXRlLnRleHRDb250ZW50ID0gbm93LnRvTG9jYWxlRGF0ZVN0cmluZygnZW4tVVMnLCBvcHRpb25zKTtcbiAgICAgIH1cbiAgICB9O1xuXG4gICAgY29uc3QgbG9ja1NjcmVlbkFjdGlvbiA9ICgpID0+IHtcbiAgICAgIGlmIChsb2NrU2NyZWVuKSB7XG4gICAgICAgIGxvY2tTY3JlZW4uY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG4gICAgICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmFkZCgnc2NyZWVuLWxvY2tlZCcpO1xuICAgICAgICBsb2NhbFN0b3JhZ2Uuc2V0SXRlbSgnc28tc2NyZWVuLWxvY2tlZCcsICd0cnVlJyk7XG4gICAgICAgIHVwZGF0ZUxvY2tTY3JlZW5UaW1lKCk7XG4gICAgICAgIGlmIChsb2NrU2NyZWVuUGFzc3dvcmQpIGxvY2tTY3JlZW5QYXNzd29yZC5mb2N1cygpO1xuICAgICAgfVxuICAgIH07XG5cbiAgICBjb25zdCB1bmxvY2tTY3JlZW5BY3Rpb24gPSAoKSA9PiB7XG4gICAgICBpZiAobG9ja1NjcmVlbikge1xuICAgICAgICBsb2NrU2NyZWVuLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xuICAgICAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5yZW1vdmUoJ3NjcmVlbi1sb2NrZWQnKTtcbiAgICAgICAgbG9jYWxTdG9yYWdlLnJlbW92ZUl0ZW0oJ3NvLXNjcmVlbi1sb2NrZWQnKTtcbiAgICAgICAgaWYgKGxvY2tTY3JlZW5QYXNzd29yZCkgbG9ja1NjcmVlblBhc3N3b3JkLnZhbHVlID0gJyc7XG4gICAgICB9XG4gICAgfTtcblxuICAgIGlmIChsb2NrU2NyZWVuQnRuKSB7XG4gICAgICBsb2NrU2NyZWVuQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICBsb2NrU2NyZWVuQWN0aW9uKCk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICBpZiAobG9ja1NjcmVlbkZvcm0pIHtcbiAgICAgIGxvY2tTY3JlZW5Gb3JtLmFkZEV2ZW50TGlzdGVuZXIoJ3N1Ym1pdCcsIChlKSA9PiB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdW5sb2NrU2NyZWVuQWN0aW9uKCk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICAvLyBDaGVjayBpZiBzY3JlZW4gd2FzIGxvY2tlZCBvbiBwYWdlIGxvYWRcbiAgICBpZiAobG9jYWxTdG9yYWdlLmdldEl0ZW0oJ3NvLXNjcmVlbi1sb2NrZWQnKSA9PT0gJ3RydWUnICYmIGxvY2tTY3JlZW4pIHtcbiAgICAgIGxvY2tTY3JlZW4uY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG4gICAgICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoJ3NjcmVlbi1sb2NrZWQnKTtcbiAgICAgIHVwZGF0ZUxvY2tTY3JlZW5UaW1lKCk7XG4gICAgICBpZiAobG9ja1NjcmVlblBhc3N3b3JkKSBsb2NrU2NyZWVuUGFzc3dvcmQuZm9jdXMoKTtcbiAgICB9XG5cbiAgfVxuXG4gIC8qKlxuICAgKiBUb2dnbGUgZnVsbHNjcmVlbiBtb2RlXG4gICAqL1xuICBfdG9nZ2xlRnVsbHNjcmVlbigpIHtcbiAgICBpZiAoIWRvY3VtZW50LmZ1bGxzY3JlZW5FbGVtZW50ICYmICFkb2N1bWVudC53ZWJraXRGdWxsc2NyZWVuRWxlbWVudCkge1xuICAgICAgLy8gRW50ZXIgZnVsbHNjcmVlblxuICAgICAgY29uc3QgZWxlbSA9IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudDtcbiAgICAgIGlmIChlbGVtLnJlcXVlc3RGdWxsc2NyZWVuKSB7XG4gICAgICAgIGVsZW0ucmVxdWVzdEZ1bGxzY3JlZW4oKTtcbiAgICAgIH0gZWxzZSBpZiAoZWxlbS53ZWJraXRSZXF1ZXN0RnVsbHNjcmVlbikge1xuICAgICAgICBlbGVtLndlYmtpdFJlcXVlc3RGdWxsc2NyZWVuKCk7XG4gICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgIC8vIEV4aXQgZnVsbHNjcmVlblxuICAgICAgaWYgKGRvY3VtZW50LmV4aXRGdWxsc2NyZWVuKSB7XG4gICAgICAgIGRvY3VtZW50LmV4aXRGdWxsc2NyZWVuKCk7XG4gICAgICB9IGVsc2UgaWYgKGRvY3VtZW50LndlYmtpdEV4aXRGdWxsc2NyZWVuKSB7XG4gICAgICAgIGRvY3VtZW50LndlYmtpdEV4aXRGdWxsc2NyZWVuKCk7XG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBmdWxsc2NyZWVuIGJ1dHRvbiBpY29uc1xuICAgKi9cbiAgX3VwZGF0ZUZ1bGxzY3JlZW5JY29uKCkge1xuICAgIGNvbnN0IGlzRnVsbHNjcmVlbiA9IGRvY3VtZW50LmZ1bGxzY3JlZW5FbGVtZW50IHx8IGRvY3VtZW50LndlYmtpdEZ1bGxzY3JlZW5FbGVtZW50O1xuICAgIGNvbnN0IGljb25UZXh0ID0gaXNGdWxsc2NyZWVuID8gJ2Z1bGxzY3JlZW5fZXhpdCcgOiAnZnVsbHNjcmVlbic7XG5cbiAgICAvLyBVcGRhdGUgc2lkZWJhciBidXR0b25cbiAgICBjb25zdCBzaWRlYmFyQnRuID0gdGhpcy5lbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJyNzaWRlYmFyRnVsbHNjcmVlbkJ0biAubWF0ZXJpYWwtaWNvbnMnKTtcbiAgICBpZiAoc2lkZWJhckJ0bikgc2lkZWJhckJ0bi50ZXh0Q29udGVudCA9IGljb25UZXh0O1xuXG4gICAgLy8gVXBkYXRlIG5hdmJhciBidXR0b25cbiAgICBjb25zdCBuYXZiYXJCdG4gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjbmF2YmFyRnVsbHNjcmVlbkJ0biAubWF0ZXJpYWwtaWNvbnMnKTtcbiAgICBpZiAobmF2YmFyQnRuKSBuYXZiYXJCdG4udGV4dENvbnRlbnQgPSBpY29uVGV4dDtcbiAgfVxuXG4gIC8qKlxuICAgKiBTYXZlIHNpZGViYXIgc3RhdGUgdG8gc3RvcmFnZVxuICAgKi9cbiAgX3NhdmVTdGF0ZShzdGF0ZSkge1xuICAgIHRyeSB7XG4gICAgICBsb2NhbFN0b3JhZ2Uuc2V0SXRlbSh0aGlzLm9wdGlvbnMuc3RvcmFnZUtleSwgc3RhdGUpO1xuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIC8vIFN0b3JhZ2Ugbm90IGF2YWlsYWJsZVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBSZXN0b3JlIHNpZGViYXIgc3RhdGUgZnJvbSBzdG9yYWdlXG4gICAqL1xuICBfcmVzdG9yZVN0YXRlKCkge1xuICAgIGlmICh0aGlzLl9pc01vYmlsZSkgcmV0dXJuO1xuXG4gICAgdHJ5IHtcbiAgICAgIGNvbnN0IHN0YXRlID0gbG9jYWxTdG9yYWdlLmdldEl0ZW0odGhpcy5vcHRpb25zLnN0b3JhZ2VLZXkpO1xuICAgICAgaWYgKHN0YXRlID09PSAncGlubmVkJykge1xuICAgICAgICB0aGlzLl9pc0NvbGxhcHNlZCA9IGZhbHNlO1xuICAgICAgICB0aGlzLmVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnc28tY29sbGFwc2VkJyk7XG4gICAgICAgIHRoaXMuZWxlbWVudC5jbGFzc0xpc3QuYWRkKCdwaW5uZWQnKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRoaXMuX2lzQ29sbGFwc2VkID0gdHJ1ZTtcbiAgICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ3NvLWNvbGxhcHNlZCcpO1xuICAgICAgfVxuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIC8vIFN0b3JhZ2Ugbm90IGF2YWlsYWJsZVxuICAgICAgdGhpcy5faXNDb2xsYXBzZWQgPSB0cnVlO1xuICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ3NvLWNvbGxhcHNlZCcpO1xuICAgIH1cbiAgfVxufVxuXG4vLyBFeHBvcnRcbmV4cG9ydCB7IFNpZGViYXJDb250cm9sbGVyIH07XG5leHBvcnQgZGVmYXVsdCBTaWRlYmFyQ29udHJvbGxlcjtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gTkFWQkFSIENPTlRST0xMRVJcbi8vIE5hdmJhciBpbnRlcmFjdGl2ZSBmdW5jdGlvbmFsaXR5XG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4vKipcbiAqIE5hdmJhckNvbnRyb2xsZXIgLSBIYW5kbGVzIG5hdmJhciBpbnRlcmFjdGlvbnNcbiAqIEN1cnJlbnRseSBtaW5pbWFsIGFzIG5hdmJhciBpcyBtb3N0bHkgQ1NTLWJhc2VkXG4gKiBGdXR1cmU6IGRyb3Bkb3duIGhhbmRsaW5nLCBtb2JpbGUgcmVzcG9uc2l2ZW5lc3MsIGV0Yy5cbiAqL1xuY2xhc3MgTmF2YmFyQ29udHJvbGxlciB7XG4gIGNvbnN0cnVjdG9yKGVsZW1lbnQpIHtcbiAgICB0aGlzLmVsZW1lbnQgPSBlbGVtZW50O1xuICAgIGlmICghdGhpcy5lbGVtZW50KSByZXR1cm47XG5cbiAgICB0aGlzLl9pbml0KCk7XG4gIH1cblxuICAvKipcbiAgICogSW5pdGlhbGl6ZSB0aGUgY29udHJvbGxlclxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2luaXQoKSB7XG4gICAgLy8gQmluZCBldmVudHNcbiAgICB0aGlzLl9iaW5kRXZlbnRzKCk7XG4gIH1cblxuICAvKipcbiAgICogQmluZCBldmVudCBsaXN0ZW5lcnNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9iaW5kRXZlbnRzKCkge1xuICAgIC8vIEZ1dHVyZTogQWRkIG5hdmJhci1zcGVjaWZpYyBldmVudCBoYW5kbGVyc1xuICAgIC8vIC0gRHJvcGRvd24gbWVudXNcbiAgICAvLyAtIFVzZXIgbWVudVxuICAgIC8vIC0gTm90aWZpY2F0aW9ucyBkcm9wZG93blxuICAgIC8vIC0gTW9iaWxlIHJlc3BvbnNpdmVuZXNzXG4gIH1cbn1cblxuLy8gRXhwb3J0XG5leHBvcnQgeyBOYXZiYXJDb250cm9sbGVyIH07XG5leHBvcnQgZGVmYXVsdCBOYXZiYXJDb250cm9sbGVyO1xuIiwgIi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4vLyBHTE9CQUwgU0VBUkNIIENPTlRST0xMRVJcbi8vIFN0YW5kYWxvbmUgc2VhcmNoIG92ZXJsYXkgZnVuY3Rpb25hbGl0eVxuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuLy8gVXNlIHByZWZpeCBmcm9tIFNpeE9yYml0IGNvbmZpZyAoZmFsbGJhY2sgdG8gJ3NvJyBpZiBub3QgYXZhaWxhYmxlKVxuY29uc3QgUFJFRklYID0gKHR5cGVvZiB3aW5kb3cgIT09ICd1bmRlZmluZWQnICYmIHdpbmRvdy5TaXhPcmJpdD8uUFJFRklYKSB8fCAnc28nO1xuY29uc3QgY2xzID0gKC4uLnBhcnRzKSA9PiBgJHtQUkVGSVh9LSR7cGFydHMuam9pbignLScpfWA7XG5cbi8qKlxuICogR2xvYmFsU2VhcmNoQ29udHJvbGxlciAtIFN0YW5kYWxvbmUgc2VhcmNoIG92ZXJsYXkgY29udHJvbGxlclxuICogVGhpcyBpcyBpbmRlcGVuZGVudCBvZiB0aGUgU08gRnJhbWV3b3JrIGFuZCBjYW4gYmUgY29uZmlndXJlZFxuICogd2l0aCBjdXN0b20gQVBJIGVuZHBvaW50cyBhbmQgY2FsbGJhY2tzXG4gKi9cbmNsYXNzIEdsb2JhbFNlYXJjaENvbnRyb2xsZXIge1xuICAvLyBEZWZhdWx0IGNvbmZpZ3VyYXRpb25cbiAgc3RhdGljIERFRkFVTFRTID0ge1xuICAgIG92ZXJsYXlTZWxlY3RvcjogJy5zby1zZWFyY2gtb3ZlcmxheScsXG4gICAgaW5wdXRTZWxlY3RvcjogJy5zby1zZWFyY2gtb3ZlcmxheS1pbnB1dCcsXG4gICAgY2xvc2VTZWxlY3RvcjogJy5zby1zZWFyY2gtb3ZlcmxheS1jbG9zZScsXG4gICAgYmFja2Ryb3BTZWxlY3RvcjogJy5zby1zZWFyY2gtb3ZlcmxheS1iYWNrZHJvcCcsXG4gICAgcXVpY2tMaW5rc1NlbGVjdG9yOiAnLnNvLXNlYXJjaC1xdWljay1saW5rcycsXG4gICAgY2F0ZWdvcnlUYWJzU2VsZWN0b3I6ICcuc28tc2VhcmNoLWNhdGVnb3J5LXRhYnMnLFxuICAgIGZpbHRlckJhclNlbGVjdG9yOiAnLnNvLXNlYXJjaC1maWx0ZXItYmFyJyxcbiAgICByZXN1bHRzQ29udGFpbmVyU2VsZWN0b3I6ICcuc28tc2VhcmNoLXJlc3VsdHMtY29udGFpbmVyJyxcbiAgICByZXN1bHRzR3JpZFNlbGVjdG9yOiAnLnNvLXNlYXJjaC1yZXN1bHRzLWdyaWQnLFxuICAgIHJlc3VsdHNMaXN0U2VsZWN0b3I6ICcuc28tc2VhcmNoLXJlc3VsdHMtbGlzdCcsXG4gICAgZW1wdHlTZWxlY3RvcjogJy5zby1zZWFyY2gtZW1wdHknLFxuICAgIGxvYWRpbmdTZWxlY3RvcjogJy5zby1zZWFyY2gtbG9hZGluZycsXG4gICAgZGVib3VuY2VNczogMzAwLFxuICAgIG1pblNlYXJjaExlbmd0aDogMixcbiAgfTtcblxuICAvKipcbiAgICogQ3JlYXRlIGEgbmV3IEdsb2JhbFNlYXJjaENvbnRyb2xsZXJcbiAgICogQHBhcmFtIHtPYmplY3R9IG9wdGlvbnMgLSBDb25maWd1cmF0aW9uIG9wdGlvbnNcbiAgICovXG4gIGNvbnN0cnVjdG9yKG9wdGlvbnMgPSB7fSkge1xuICAgIHRoaXMub3B0aW9ucyA9IHsgLi4uR2xvYmFsU2VhcmNoQ29udHJvbGxlci5ERUZBVUxUUywgLi4ub3B0aW9ucyB9O1xuXG4gICAgLy8gU3RhdGVcbiAgICB0aGlzLmlzT3BlbiA9IGZhbHNlO1xuICAgIHRoaXMuaXNJU1ZTZWFyY2ggPSBmYWxzZTtcbiAgICB0aGlzLnNlYXJjaFF1ZXJ5ID0gJyc7XG4gICAgdGhpcy5jdXJyZW50VmlldyA9ICdncmlkJztcbiAgICB0aGlzLmFjdGl2ZUZpbHRlcnMgPSB7IHN0b2NrOiAnYWxsJywgc3RhdHVzOiAnYWxsJyB9O1xuICAgIHRoaXMuYWN0aXZlQ2F0ZWdvcnkgPSAnYWxsJztcbiAgICB0aGlzLmZvY3VzZWRJbmRleCA9IC0xO1xuICAgIHRoaXMucmVzdWx0cyA9IFtdO1xuICAgIHRoaXMuX2RlYm91bmNlVGltZXIgPSBudWxsO1xuXG4gICAgLy8gQ2FsbGJhY2tzXG4gICAgdGhpcy5vblNlYXJjaCA9IG9wdGlvbnMub25TZWFyY2ggfHwgbnVsbDtcbiAgICB0aGlzLm9uSXRlbUNsaWNrID0gb3B0aW9ucy5vbkl0ZW1DbGljayB8fCBudWxsO1xuICAgIHRoaXMub25BY2NvdW50Q2xpY2sgPSBvcHRpb25zLm9uQWNjb3VudENsaWNrIHx8IG51bGw7XG4gICAgdGhpcy5vblF1aWNrQWN0aW9uQ2xpY2sgPSBvcHRpb25zLm9uUXVpY2tBY3Rpb25DbGljayB8fCBudWxsO1xuXG4gICAgLy8gQVBJIFVSTHNcbiAgICB0aGlzLnNlYXJjaFVybCA9IG9wdGlvbnMuc2VhcmNoVXJsIHx8IG51bGw7XG4gICAgdGhpcy5pc3ZTZWFyY2hVcmwgPSBvcHRpb25zLmlzdlNlYXJjaFVybCB8fCBudWxsO1xuXG4gICAgLy8gSW5pdGlhbGl6ZVxuICAgIHRoaXMuX2luaXQoKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIHRoZSBjb250cm9sbGVyXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaW5pdCgpIHtcbiAgICAvLyBDYWNoZSBET00gZWxlbWVudHNcbiAgICB0aGlzLl9vdmVybGF5ID0gZG9jdW1lbnQucXVlcnlTZWxlY3Rvcih0aGlzLm9wdGlvbnMub3ZlcmxheVNlbGVjdG9yKTtcbiAgICBpZiAoIXRoaXMuX292ZXJsYXkpIHJldHVybjtcblxuICAgIHRoaXMuX2lucHV0ID0gdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5pbnB1dFNlbGVjdG9yKTtcbiAgICB0aGlzLl9jbG9zZUJ0biA9IHRoaXMuX292ZXJsYXkucXVlcnlTZWxlY3Rvcih0aGlzLm9wdGlvbnMuY2xvc2VTZWxlY3Rvcik7XG4gICAgdGhpcy5fYmFja2Ryb3AgPSB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3IodGhpcy5vcHRpb25zLmJhY2tkcm9wU2VsZWN0b3IpO1xuICAgIHRoaXMuX3F1aWNrTGlua3MgPSB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3IodGhpcy5vcHRpb25zLnF1aWNrTGlua3NTZWxlY3Rvcik7XG4gICAgdGhpcy5fY2F0ZWdvcnlUYWJzID0gdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5jYXRlZ29yeVRhYnNTZWxlY3Rvcik7XG4gICAgdGhpcy5fZmlsdGVyQmFyID0gdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5maWx0ZXJCYXJTZWxlY3Rvcik7XG4gICAgdGhpcy5fcmVzdWx0c0NvbnRhaW5lciA9IHRoaXMuX292ZXJsYXkucXVlcnlTZWxlY3Rvcih0aGlzLm9wdGlvbnMucmVzdWx0c0NvbnRhaW5lclNlbGVjdG9yKTtcbiAgICB0aGlzLl9yZXN1bHRzR3JpZCA9IHRoaXMuX292ZXJsYXkucXVlcnlTZWxlY3Rvcih0aGlzLm9wdGlvbnMucmVzdWx0c0dyaWRTZWxlY3Rvcik7XG4gICAgdGhpcy5fcmVzdWx0c0xpc3QgPSB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3IodGhpcy5vcHRpb25zLnJlc3VsdHNMaXN0U2VsZWN0b3IpO1xuICAgIHRoaXMuX2VtcHR5ID0gdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5lbXB0eVNlbGVjdG9yKTtcbiAgICB0aGlzLl9sb2FkaW5nID0gdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5sb2FkaW5nU2VsZWN0b3IpO1xuXG4gICAgLy8gQmluZCBldmVudHNcbiAgICB0aGlzLl9iaW5kRXZlbnRzKCk7XG5cbiAgICAvLyBTdG9yZSBnbG9iYWwgcmVmZXJlbmNlXG4gICAgd2luZG93Lmdsb2JhbFNlYXJjaENvbnRyb2xsZXIgPSB0aGlzO1xuICB9XG5cbiAgLyoqXG4gICAqIEJpbmQgZXZlbnQgbGlzdGVuZXJzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfYmluZEV2ZW50cygpIHtcbiAgICAvLyBHbG9iYWwga2V5Ym9hcmQgc2hvcnRjdXQgKEN0cmwvQ21kICsgSylcbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdrZXlkb3duJywgKGUpID0+IHRoaXMuX2hhbmRsZUdsb2JhbEtleWRvd24oZSkpO1xuXG4gICAgLy8gQ2xvc2UgYnV0dG9uXG4gICAgaWYgKHRoaXMuX2Nsb3NlQnRuKSB7XG4gICAgICB0aGlzLl9jbG9zZUJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHRoaXMuY2xvc2UoKSk7XG4gICAgfVxuXG4gICAgLy8gQmFja2Ryb3AgY2xpY2tcbiAgICBpZiAodGhpcy5fYmFja2Ryb3ApIHtcbiAgICAgIHRoaXMuX2JhY2tkcm9wLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4gdGhpcy5jbG9zZSgpKTtcbiAgICB9XG5cbiAgICAvLyBTZWFyY2ggaW5wdXRcbiAgICBpZiAodGhpcy5faW5wdXQpIHtcbiAgICAgIHRoaXMuX2lucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2lucHV0JywgKGUpID0+IHRoaXMuX2hhbmRsZUlucHV0KGUpKTtcbiAgICAgIHRoaXMuX2lucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2tleWRvd24nLCAoZSkgPT4gdGhpcy5faGFuZGxlSW5wdXRLZXlkb3duKGUpKTtcbiAgICB9XG5cbiAgICAvLyBDYXRlZ29yeSB0YWJzXG4gICAgdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2VhcmNoLWNhdGVnb3J5LXRhYicpLmZvckVhY2godGFiID0+IHtcbiAgICAgIHRhYi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB0aGlzLl9oYW5kbGVDYXRlZ29yeUNsaWNrKGUpKTtcbiAgICB9KTtcblxuICAgIC8vIFZpZXcgdG9nZ2xlIGJ1dHRvbnNcbiAgICB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1zZWFyY2gtdmlldy1idG4nKS5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4gdGhpcy5faGFuZGxlVmlld1RvZ2dsZShlKSk7XG4gICAgfSk7XG5cbiAgICAvLyBGaWx0ZXIgZHJvcGRvd25zXG4gICAgdGhpcy5faW5pdEZpbHRlcnMoKTtcblxuICAgIC8vIFF1aWNrIGxpbmtzXG4gICAgdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2VhcmNoLXF1aWNrLWxpbmsnKS5mb3JFYWNoKGxpbmsgPT4ge1xuICAgICAgbGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB0aGlzLl9oYW5kbGVRdWlja0xpbmtDbGljayhlKSk7XG4gICAgfSk7XG5cbiAgICAvLyBSZXN1bHQgY2xpY2tzICh1c2luZyBldmVudCBkZWxlZ2F0aW9uKVxuICAgIGlmICh0aGlzLl9yZXN1bHRzQ29udGFpbmVyKSB7XG4gICAgICB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHRoaXMuX2hhbmRsZVJlc3VsdENsaWNrKGUpKTtcbiAgICB9XG5cbiAgICAvLyBDbGljayB0cmlnZ2VyIGZyb20gbmF2YmFyIHNlYXJjaFxuICAgIGNvbnN0IG5hdmJhclNlYXJjaCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1uYXZiYXItc2VhcmNoLWlucHV0Jyk7XG4gICAgaWYgKG5hdmJhclNlYXJjaCkge1xuICAgICAgbmF2YmFyU2VhcmNoLmFkZEV2ZW50TGlzdGVuZXIoJ2ZvY3VzJywgKCkgPT4gdGhpcy5vcGVuKCkpO1xuICAgICAgbmF2YmFyU2VhcmNoLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4gdGhpcy5vcGVuKCkpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgZ2xvYmFsIGtleWJvYXJkIHNob3J0Y3V0c1xuICAgKiBAcGFyYW0ge0tleWJvYXJkRXZlbnR9IGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVHbG9iYWxLZXlkb3duKGUpIHtcbiAgICAvLyBPcGVuIHdpdGggQ3RybC9DbWQgKyBLXG4gICAgaWYgKChlLmN0cmxLZXkgfHwgZS5tZXRhS2V5KSAmJiBlLmtleSA9PT0gJ2snKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICB0aGlzLnRvZ2dsZSgpO1xuICAgIH1cblxuICAgIC8vIENsb3NlIHdpdGggRXNjYXBlXG4gICAgaWYgKGUua2V5ID09PSAnRXNjYXBlJyAmJiB0aGlzLmlzT3Blbikge1xuICAgICAgdGhpcy5jbG9zZSgpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgc2VhcmNoIGlucHV0XG4gICAqIEBwYXJhbSB7RXZlbnR9IGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVJbnB1dChlKSB7XG4gICAgY29uc3QgcXVlcnkgPSBlLnRhcmdldC52YWx1ZS50cmltKCk7XG4gICAgdGhpcy5zZWFyY2hRdWVyeSA9IHF1ZXJ5O1xuXG4gICAgLy8gQ2xlYXIgcHJldmlvdXMgZGVib3VuY2VcbiAgICBjbGVhclRpbWVvdXQodGhpcy5fZGVib3VuY2VUaW1lcik7XG5cbiAgICAvLyBDaGVjayBmb3IgSVNWIG1vZGVcbiAgICB0aGlzLmlzSVNWU2VhcmNoID0gcXVlcnkudG9Mb3dlckNhc2UoKS5zdGFydHNXaXRoKCdpc3Y6Jyk7XG5cbiAgICAvLyBVcGRhdGUgVUkgYmFzZWQgb24gbW9kZVxuICAgIHRoaXMuX3VwZGF0ZVNlYXJjaE1vZGUoKTtcblxuICAgIC8vIERlYm91bmNlIHNlYXJjaFxuICAgIHRoaXMuX2RlYm91bmNlVGltZXIgPSBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgIGlmIChxdWVyeS5sZW5ndGggPj0gdGhpcy5vcHRpb25zLm1pblNlYXJjaExlbmd0aCkge1xuICAgICAgICB0aGlzLl9wZXJmb3JtU2VhcmNoKHF1ZXJ5KTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRoaXMuX3Nob3dEZWZhdWx0U3RhdGUoKTtcbiAgICAgIH1cbiAgICB9LCB0aGlzLm9wdGlvbnMuZGVib3VuY2VNcyk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIGlucHV0IGtleWRvd24gZm9yIG5hdmlnYXRpb25cbiAgICogQHBhcmFtIHtLZXlib2FyZEV2ZW50fSBlXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGFuZGxlSW5wdXRLZXlkb3duKGUpIHtcbiAgICBzd2l0Y2ggKGUua2V5KSB7XG4gICAgICBjYXNlICdBcnJvd0Rvd24nOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzTmV4dCgpO1xuICAgICAgICBicmVhaztcbiAgICAgIGNhc2UgJ0Fycm93VXAnOlxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHRoaXMuX2ZvY3VzUHJldigpO1xuICAgICAgICBicmVhaztcbiAgICAgIGNhc2UgJ0VudGVyJzpcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB0aGlzLl9zZWxlY3RGb2N1c2VkKCk7XG4gICAgICAgIGJyZWFrO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBJbml0aWFsaXplIGZpbHRlciBkcm9wZG93bnNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9pbml0RmlsdGVycygpIHtcbiAgICB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1zZWFyY2gtZmlsdGVyLWRyb3Bkb3duJykuZm9yRWFjaChkcm9wZG93biA9PiB7XG4gICAgICBjb25zdCBidG4gPSBkcm9wZG93bi5xdWVyeVNlbGVjdG9yKCcuc28tc2VhcmNoLWZpbHRlci1idG4nKTtcbiAgICAgIGNvbnN0IG1lbnUgPSBkcm9wZG93bi5xdWVyeVNlbGVjdG9yKCcuc28tc2VhcmNoLWZpbHRlci1tZW51Jyk7XG4gICAgICBjb25zdCBmaWx0ZXJUeXBlID0gZHJvcGRvd24uZGF0YXNldC5maWx0ZXI7XG5cbiAgICAgIGlmIChidG4gJiYgbWVudSkge1xuICAgICAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgbWVudS5jbGFzc0xpc3QudG9nZ2xlKGNscygnb3BlbicpKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgbWVudS5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2VhcmNoLWZpbHRlci1vcHRpb24nKS5mb3JFYWNoKG9wdGlvbiA9PiB7XG4gICAgICAgICAgb3B0aW9uLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4ge1xuICAgICAgICAgICAgdGhpcy5fc2VsZWN0RmlsdGVyKGZpbHRlclR5cGUsIG9wdGlvbi5kYXRhc2V0LnZhbHVlKTtcbiAgICAgICAgICAgIG1lbnUuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ29wZW4nKSk7XG4gICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgLy8gQ2xvc2UgZHJvcGRvd25zIG9uIG91dHNpZGUgY2xpY2tcbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgICAgIHRoaXMuX292ZXJsYXkucXVlcnlTZWxlY3RvckFsbCgnLnNvLXNlYXJjaC1maWx0ZXItbWVudScpLmZvckVhY2gobWVudSA9PiB7XG4gICAgICAgIG1lbnUuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ29wZW4nKSk7XG4gICAgICB9KTtcbiAgICB9KTtcbiAgfVxuXG4gIC8qKlxuICAgKiBTZWxlY3QgYSBmaWx0ZXIgb3B0aW9uXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0eXBlIC0gRmlsdGVyIHR5cGUgKHN0b2NrLCBzdGF0dXMpXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB2YWx1ZSAtIEZpbHRlciB2YWx1ZVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3NlbGVjdEZpbHRlcih0eXBlLCB2YWx1ZSkge1xuICAgIHRoaXMuYWN0aXZlRmlsdGVyc1t0eXBlXSA9IHZhbHVlO1xuXG4gICAgLy8gVXBkYXRlIFVJXG4gICAgY29uc3QgZHJvcGRvd24gPSB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3IoYC5zby1zZWFyY2gtZmlsdGVyLWRyb3Bkb3duW2RhdGEtZmlsdGVyPVwiJHt0eXBlfVwiXWApO1xuICAgIGlmIChkcm9wZG93bikge1xuICAgICAgZHJvcGRvd24ucXVlcnlTZWxlY3RvckFsbCgnLnNvLXNlYXJjaC1maWx0ZXItb3B0aW9uJykuZm9yRWFjaChvcHQgPT4ge1xuICAgICAgICBvcHQuY2xhc3NMaXN0LnRvZ2dsZShjbHMoJ3NlbGVjdGVkJyksIG9wdC5kYXRhc2V0LnZhbHVlID09PSB2YWx1ZSk7XG4gICAgICB9KTtcblxuICAgICAgY29uc3QgbGFiZWwgPSBkcm9wZG93bi5xdWVyeVNlbGVjdG9yKCcuZmlsdGVyLWxhYmVsJyk7XG4gICAgICBjb25zdCBzZWxlY3RlZCA9IGRyb3Bkb3duLnF1ZXJ5U2VsZWN0b3IoYC5zby1zZWFyY2gtZmlsdGVyLW9wdGlvbltkYXRhLXZhbHVlPVwiJHt2YWx1ZX1cIl1gKTtcbiAgICAgIGlmIChsYWJlbCAmJiBzZWxlY3RlZCkge1xuICAgICAgICBsYWJlbC50ZXh0Q29udGVudCA9IHNlbGVjdGVkLnRleHRDb250ZW50LnRyaW0oKTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICAvLyBSZS1zZWFyY2ggd2l0aCBuZXcgZmlsdGVyc1xuICAgIGlmICh0aGlzLnNlYXJjaFF1ZXJ5Lmxlbmd0aCA+PSB0aGlzLm9wdGlvbnMubWluU2VhcmNoTGVuZ3RoKSB7XG4gICAgICB0aGlzLl9wZXJmb3JtU2VhcmNoKHRoaXMuc2VhcmNoUXVlcnkpO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBIYW5kbGUgY2F0ZWdvcnkgdGFiIGNsaWNrXG4gICAqIEBwYXJhbSB7RXZlbnR9IGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVDYXRlZ29yeUNsaWNrKGUpIHtcbiAgICBjb25zdCB0YWIgPSBlLmN1cnJlbnRUYXJnZXQ7XG4gICAgY29uc3QgY2F0ZWdvcnkgPSB0YWIuZGF0YXNldC5jYXRlZ29yeTtcblxuICAgIC8vIFVwZGF0ZSBhY3RpdmUgc3RhdGVcbiAgICB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1zZWFyY2gtY2F0ZWdvcnktdGFiJykuZm9yRWFjaCh0ID0+IHtcbiAgICAgIHQuY2xhc3NMaXN0LnRvZ2dsZShjbHMoJ2FjdGl2ZScpLCB0ID09PSB0YWIpO1xuICAgIH0pO1xuXG4gICAgdGhpcy5hY3RpdmVDYXRlZ29yeSA9IGNhdGVnb3J5O1xuXG4gICAgLy8gUmUtZmlsdGVyIHJlc3VsdHNcbiAgICBpZiAodGhpcy5zZWFyY2hRdWVyeS5sZW5ndGggPj0gdGhpcy5vcHRpb25zLm1pblNlYXJjaExlbmd0aCkge1xuICAgICAgdGhpcy5fcGVyZm9ybVNlYXJjaCh0aGlzLnNlYXJjaFF1ZXJ5KTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIHZpZXcgdG9nZ2xlXG4gICAqIEBwYXJhbSB7RXZlbnR9IGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVWaWV3VG9nZ2xlKGUpIHtcbiAgICBjb25zdCBidG4gPSBlLmN1cnJlbnRUYXJnZXQ7XG4gICAgY29uc3QgdmlldyA9IGJ0bi5kYXRhc2V0LnZpZXc7XG5cbiAgICAvLyBVcGRhdGUgYnV0dG9uIHN0YXRlc1xuICAgIHRoaXMuX292ZXJsYXkucXVlcnlTZWxlY3RvckFsbCgnLnNvLXNlYXJjaC12aWV3LWJ0bicpLmZvckVhY2goYiA9PiB7XG4gICAgICBiLmNsYXNzTGlzdC50b2dnbGUoY2xzKCdhY3RpdmUnKSwgYiA9PT0gYnRuKTtcbiAgICB9KTtcblxuICAgIHRoaXMuY3VycmVudFZpZXcgPSB2aWV3O1xuXG4gICAgLy8gVXBkYXRlIHJlc3VsdHMgZGlzcGxheVxuICAgIGlmICh0aGlzLl9yZXN1bHRzR3JpZCkge1xuICAgICAgdGhpcy5fcmVzdWx0c0dyaWQuY2xhc3NMaXN0LnRvZ2dsZShjbHMoJ3Zpc2libGUnKSwgdmlldyA9PT0gJ2dyaWQnKTtcbiAgICB9XG4gICAgaWYgKHRoaXMuX3Jlc3VsdHNMaXN0KSB7XG4gICAgICB0aGlzLl9yZXN1bHRzTGlzdC5jbGFzc0xpc3QudG9nZ2xlKGNscygndmlzaWJsZScpLCB2aWV3ID09PSAnbGlzdCcpO1xuICAgIH1cblxuICAgIC8vIFJlLXJlbmRlciByZXN1bHRzIGluIG5ldyB2aWV3XG4gICAgdGhpcy5fcmVuZGVyUmVzdWx0cyh0aGlzLnJlc3VsdHMpO1xuICB9XG5cbiAgLyoqXG4gICAqIEhhbmRsZSBxdWljayBsaW5rIGNsaWNrXG4gICAqIEBwYXJhbSB7RXZlbnR9IGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVRdWlja0xpbmtDbGljayhlKSB7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgIGNvbnN0IGxpbmsgPSBlLmN1cnJlbnRUYXJnZXQ7XG4gICAgY29uc3QgYWN0aW9uID0gbGluay5kYXRhc2V0LmFjdGlvbjtcblxuICAgIGlmICh0aGlzLm9uUXVpY2tBY3Rpb25DbGljaykge1xuICAgICAgdGhpcy5vblF1aWNrQWN0aW9uQ2xpY2soYWN0aW9uLCBsaW5rKTtcbiAgICB9XG5cbiAgICAvLyBJZiB0aGUgcXVpY2sgbGluayBoYXMgYSBVUkwsIG5hdmlnYXRlXG4gICAgY29uc3QgdXJsID0gbGluay5nZXRBdHRyaWJ1dGUoJ2hyZWYnKTtcbiAgICBpZiAodXJsICYmIHVybCAhPT0gJyMnKSB7XG4gICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IHVybDtcbiAgICB9XG5cbiAgICB0aGlzLmNsb3NlKCk7XG4gIH1cblxuICAvKipcbiAgICogSGFuZGxlIHJlc3VsdCBpdGVtIGNsaWNrXG4gICAqIEBwYXJhbSB7RXZlbnR9IGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oYW5kbGVSZXN1bHRDbGljayhlKSB7XG4gICAgY29uc3QgaXRlbSA9IGUudGFyZ2V0LmNsb3Nlc3QoJy5zby1zZWFyY2gtaXRlbS1jYXJkLCAuc28tc2VhcmNoLWl0ZW0tcm93LCAuc28tc2VhcmNoLWFjY291bnQtY2FyZCwgLnNvLXNlYXJjaC1vdmVybGF5LWl0ZW0nKTtcbiAgICBpZiAoIWl0ZW0pIHJldHVybjtcblxuICAgIGNvbnN0IGl0ZW1EYXRhID0ge1xuICAgICAgaWQ6IGl0ZW0uZGF0YXNldC5pdGVtSWQsXG4gICAgICB0eXBlOiBpdGVtLmRhdGFzZXQuaXRlbVR5cGUsXG4gICAgICBlbGVtZW50OiBpdGVtLFxuICAgIH07XG5cbiAgICAvLyBDYWxsIGFwcHJvcHJpYXRlIGNhbGxiYWNrXG4gICAgaWYgKGl0ZW0uY2xhc3NMaXN0LmNvbnRhaW5zKCdzby1zZWFyY2gtYWNjb3VudC1jYXJkJykgJiYgdGhpcy5vbkFjY291bnRDbGljaykge1xuICAgICAgdGhpcy5vbkFjY291bnRDbGljayhpdGVtRGF0YSk7XG4gICAgfSBlbHNlIGlmICh0aGlzLm9uSXRlbUNsaWNrKSB7XG4gICAgICB0aGlzLm9uSXRlbUNsaWNrKGl0ZW1EYXRhKTtcbiAgICB9XG5cbiAgICB0aGlzLmNsb3NlKCk7XG4gIH1cblxuICAvKipcbiAgICogVXBkYXRlIFVJIGJhc2VkIG9uIHNlYXJjaCBtb2RlIChub3JtYWwgdnMgSVNWKVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3VwZGF0ZVNlYXJjaE1vZGUoKSB7XG4gICAgaWYgKHRoaXMuX2ZpbHRlckJhcikge1xuICAgICAgdGhpcy5fZmlsdGVyQmFyLmNsYXNzTGlzdC50b2dnbGUoY2xzKCd2aXNpYmxlJyksIHRoaXMuaXNJU1ZTZWFyY2gpO1xuICAgIH1cbiAgICBpZiAodGhpcy5fY2F0ZWdvcnlUYWJzKSB7XG4gICAgICB0aGlzLl9jYXRlZ29yeVRhYnMuY2xhc3NMaXN0LnRvZ2dsZShjbHMoJ3Zpc2libGUnKSwgIXRoaXMuaXNJU1ZTZWFyY2ggJiYgdGhpcy5zZWFyY2hRdWVyeS5sZW5ndGggPj0gdGhpcy5vcHRpb25zLm1pblNlYXJjaExlbmd0aCk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFBlcmZvcm0gc2VhcmNoXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBxdWVyeVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgYXN5bmMgX3BlcmZvcm1TZWFyY2gocXVlcnkpIHtcbiAgICB0aGlzLl9zaG93TG9hZGluZygpO1xuXG4gICAgdHJ5IHtcbiAgICAgIGxldCByZXN1bHRzO1xuXG4gICAgICBpZiAodGhpcy5pc0lTVlNlYXJjaCkge1xuICAgICAgICAvLyBJU1Ygc2VhcmNoXG4gICAgICAgIGNvbnN0IGlzdlF1ZXJ5ID0gcXVlcnkucmVwbGFjZSgvXmlzdjovaSwgJycpLnRyaW0oKTtcbiAgICAgICAgcmVzdWx0cyA9IGF3YWl0IHRoaXMuX2ZldGNoSVNWUmVzdWx0cyhpc3ZRdWVyeSk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICAvLyBOb3JtYWwgc2VhcmNoXG4gICAgICAgIHJlc3VsdHMgPSBhd2FpdCB0aGlzLl9mZXRjaFNlYXJjaFJlc3VsdHMocXVlcnkpO1xuICAgICAgfVxuXG4gICAgICB0aGlzLnJlc3VsdHMgPSByZXN1bHRzO1xuICAgICAgdGhpcy5fcmVuZGVyUmVzdWx0cyhyZXN1bHRzKTtcblxuICAgICAgLy8gVHJpZ2dlciBjYWxsYmFja1xuICAgICAgaWYgKHRoaXMub25TZWFyY2gpIHtcbiAgICAgICAgdGhpcy5vblNlYXJjaChxdWVyeSwgcmVzdWx0cyk7XG4gICAgICB9XG4gICAgfSBjYXRjaCAoZXJyb3IpIHtcbiAgICAgIGNvbnNvbGUuZXJyb3IoJ1NlYXJjaCBlcnJvcjonLCBlcnJvcik7XG4gICAgICB0aGlzLl9zaG93RW1wdHkoJ2Vycm9yJywgJ1NlYXJjaCBFcnJvcicsICdBbiBlcnJvciBvY2N1cnJlZCB3aGlsZSBzZWFyY2hpbmcuIFBsZWFzZSB0cnkgYWdhaW4uJyk7XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEZldGNoIG5vcm1hbCBzZWFyY2ggcmVzdWx0c1xuICAgKiBAcGFyYW0ge3N0cmluZ30gcXVlcnlcbiAgICogQHJldHVybnMge1Byb21pc2U8QXJyYXk+fVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgYXN5bmMgX2ZldGNoU2VhcmNoUmVzdWx0cyhxdWVyeSkge1xuICAgIGlmICh0aGlzLnNlYXJjaFVybCkge1xuICAgICAgdHJ5IHtcbiAgICAgICAgLy8gQnVpbGQgVVJMIHByb3Blcmx5IC0gdXNlIHdpbmRvdy5sb2NhdGlvbi5ocmVmIGFzIGJhc2UgZm9yIHJlbGF0aXZlIHBhdGhzXG4gICAgICAgIGNvbnN0IHVybCA9IG5ldyBVUkwodGhpcy5zZWFyY2hVcmwsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcbiAgICAgICAgdXJsLnNlYXJjaFBhcmFtcy5hcHBlbmQoJ3F1ZXJ5JywgcXVlcnkpO1xuICAgICAgICB1cmwuc2VhcmNoUGFyYW1zLmFwcGVuZCgnY2F0ZWdvcnknLCB0aGlzLmFjdGl2ZUNhdGVnb3J5KTtcblxuICAgICAgICBjb25zdCByZXNwb25zZSA9IGF3YWl0IGZldGNoKHVybC50b1N0cmluZygpKTtcbiAgICAgICAgaWYgKCFyZXNwb25zZS5vaykge1xuICAgICAgICAgIHRocm93IG5ldyBFcnJvcihgSFRUUCBlcnJvciEgc3RhdHVzOiAke3Jlc3BvbnNlLnN0YXR1c31gKTtcbiAgICAgICAgfVxuICAgICAgICBjb25zdCBkYXRhID0gYXdhaXQgcmVzcG9uc2UuanNvbigpO1xuXG4gICAgICAgIC8vIFRyYW5zZm9ybSBKU09OIHN0cnVjdHVyZSB0byBmbGF0IGFycmF5IGZvciByZW5kZXJpbmdcbiAgICAgICAgcmV0dXJuIHRoaXMuX3RyYW5zZm9ybVNlYXJjaERhdGEoZGF0YSk7XG4gICAgICB9IGNhdGNoIChlcnJvcikge1xuICAgICAgICBjb25zb2xlLmVycm9yKCdTZWFyY2ggZmV0Y2ggZXJyb3I6JywgZXJyb3IpO1xuICAgICAgICByZXR1cm4gW107IC8vIFJldHVybiBlbXB0eSBvbiBlcnJvciwgbm8gZmFsbGJhY2tcbiAgICAgIH1cbiAgICB9XG5cbiAgICAvLyBObyBVUkwgY29uZmlndXJlZCAtIHJldHVybiBlbXB0eSAoQUpBWCBvbmx5IG1vZGUpXG4gICAgY29uc29sZS53YXJuKCdTZWFyY2ggVVJMIG5vdCBjb25maWd1cmVkJyk7XG4gICAgcmV0dXJuIFtdO1xuICB9XG5cbiAgLyoqXG4gICAqIFRyYW5zZm9ybSBKU09OIGRhdGEgc3RydWN0dXJlIHRvIGZsYXQgYXJyYXkgZm9yIHJlbmRlcmluZ1xuICAgKiBTZXJ2ZXIgaXMgZXhwZWN0ZWQgdG8gcmV0dXJuIGFscmVhZHktZmlsdGVyZWQgcmVzdWx0cyBiYXNlZCBvbiBxdWVyeSBwYXJhbWV0ZXJcbiAgICogQHBhcmFtIHtPYmplY3R9IGRhdGEgLSBKU09OIGRhdGEgd2l0aCBtZW51cywgY3VzdG9tZXJzLCB2ZW5kb3JzLCBsZWRnZXJzIGFycmF5c1xuICAgKiBAcmV0dXJucyB7QXJyYXl9XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfdHJhbnNmb3JtU2VhcmNoRGF0YShkYXRhKSB7XG4gICAgY29uc3QgcmVzdWx0cyA9IFtdO1xuXG4gICAgLy8gVHJhbnNmb3JtIG1lbnVzIChubyBjbGllbnQtc2lkZSBmaWx0ZXJpbmcgLSBzZXJ2ZXIgc2hvdWxkIGZpbHRlcilcbiAgICBpZiAoZGF0YS5tZW51cykge1xuICAgICAgZGF0YS5tZW51cy5mb3JFYWNoKGl0ZW0gPT4ge1xuICAgICAgICByZXN1bHRzLnB1c2goe1xuICAgICAgICAgIGlkOiBpdGVtLmlkLFxuICAgICAgICAgIHR5cGU6ICdtZW51JyxcbiAgICAgICAgICBuYW1lOiBpdGVtLnRpdGxlLFxuICAgICAgICAgIGljb246IGl0ZW0uaWNvbixcbiAgICAgICAgICBpY29uQ29sb3I6IGl0ZW0uY29sb3IsXG4gICAgICAgICAgcGF0aDogaXRlbS5wYXRoLFxuICAgICAgICAgIHVybDogaXRlbS5ocmVmLFxuICAgICAgICB9KTtcbiAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIFRyYW5zZm9ybSBjdXN0b21lcnNcbiAgICBpZiAoZGF0YS5jdXN0b21lcnMpIHtcbiAgICAgIGRhdGEuY3VzdG9tZXJzLmZvckVhY2goaXRlbSA9PiB7XG4gICAgICAgIHJlc3VsdHMucHVzaCh7XG4gICAgICAgICAgaWQ6IGl0ZW0uaWQsXG4gICAgICAgICAgdHlwZTogJ2N1c3RvbWVyJyxcbiAgICAgICAgICBuYW1lOiBpdGVtLnRpdGxlLFxuICAgICAgICAgIGljb246IGl0ZW0uaWNvbiB8fCAncGVyc29uJyxcbiAgICAgICAgICBpY29uQ29sb3I6IGl0ZW0uY29sb3IgfHwgJ2JsdWUnLFxuICAgICAgICAgIGNhdGVnb3J5OiAnQ3VzdG9tZXInLFxuICAgICAgICAgIGJhbGFuY2U6IGl0ZW0ud2FsbGV0QmFsYW5jZSxcbiAgICAgICAgICBkZXRhaWxzOiBbXG4gICAgICAgICAgICB7IGxhYmVsOiAnUGhvbmUnLCB2YWx1ZTogaXRlbS5tb2JpbGUgfSxcbiAgICAgICAgICAgIHsgbGFiZWw6ICdDaXR5JywgdmFsdWU6IGl0ZW0uY2l0eSB9LFxuICAgICAgICAgIF0sXG4gICAgICAgIH0pO1xuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gVHJhbnNmb3JtIHZlbmRvcnNcbiAgICBpZiAoZGF0YS52ZW5kb3JzKSB7XG4gICAgICBkYXRhLnZlbmRvcnMuZm9yRWFjaChpdGVtID0+IHtcbiAgICAgICAgcmVzdWx0cy5wdXNoKHtcbiAgICAgICAgICBpZDogaXRlbS5pZCxcbiAgICAgICAgICB0eXBlOiAndmVuZG9yJyxcbiAgICAgICAgICBuYW1lOiBpdGVtLnRpdGxlLFxuICAgICAgICAgIGljb246IGl0ZW0uaWNvbiB8fCAnc3RvcmVmcm9udCcsXG4gICAgICAgICAgaWNvbkNvbG9yOiBpdGVtLmNvbG9yIHx8ICdncmVlbicsXG4gICAgICAgICAgY2F0ZWdvcnk6ICdWZW5kb3InLFxuICAgICAgICAgIGJhbGFuY2U6IGl0ZW0ud2FsbGV0QmFsYW5jZSxcbiAgICAgICAgICBkZXRhaWxzOiBbXG4gICAgICAgICAgICB7IGxhYmVsOiAnUGhvbmUnLCB2YWx1ZTogaXRlbS5tb2JpbGUgfSxcbiAgICAgICAgICAgIHsgbGFiZWw6ICdDaXR5JywgdmFsdWU6IGl0ZW0uY2l0eSB9LFxuICAgICAgICAgIF0sXG4gICAgICAgIH0pO1xuICAgICAgfSk7XG4gICAgfVxuXG4gICAgLy8gVHJhbnNmb3JtIGxlZGdlcnNcbiAgICBpZiAoZGF0YS5sZWRnZXJzKSB7XG4gICAgICBkYXRhLmxlZGdlcnMuZm9yRWFjaChpdGVtID0+IHtcbiAgICAgICAgcmVzdWx0cy5wdXNoKHtcbiAgICAgICAgICBpZDogaXRlbS5pZCxcbiAgICAgICAgICB0eXBlOiAnbGVkZ2VyJyxcbiAgICAgICAgICBuYW1lOiBpdGVtLnRpdGxlLFxuICAgICAgICAgIGljb246IGl0ZW0uaWNvbiB8fCAnYWNjb3VudF9iYWxhbmNlX3dhbGxldCcsXG4gICAgICAgICAgaWNvbkNvbG9yOiBpdGVtLmNvbG9yIHx8ICdvcmFuZ2UnLFxuICAgICAgICAgIGNhdGVnb3J5OiBpdGVtLmdyb3VwLFxuICAgICAgICAgIGJhbGFuY2U6IGl0ZW0ud2FsbGV0QmFsYW5jZSxcbiAgICAgICAgfSk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICByZXR1cm4gcmVzdWx0cztcbiAgfVxuXG4gIC8qKlxuICAgKiBGZXRjaCBJU1Ygc2VhcmNoIHJlc3VsdHNcbiAgICogQHBhcmFtIHtzdHJpbmd9IHF1ZXJ5XG4gICAqIEByZXR1cm5zIHtQcm9taXNlPEFycmF5Pn1cbiAgICogQHByaXZhdGVcbiAgICovXG4gIGFzeW5jIF9mZXRjaElTVlJlc3VsdHMocXVlcnkpIHtcbiAgICBpZiAodGhpcy5pc3ZTZWFyY2hVcmwpIHtcbiAgICAgIHRyeSB7XG4gICAgICAgIC8vIEJ1aWxkIFVSTCBwcm9wZXJseSAtIHVzZSB3aW5kb3cubG9jYXRpb24uaHJlZiBhcyBiYXNlIGZvciByZWxhdGl2ZSBwYXRoc1xuICAgICAgICBjb25zdCB1cmwgPSBuZXcgVVJMKHRoaXMuaXN2U2VhcmNoVXJsLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XG4gICAgICAgIHVybC5zZWFyY2hQYXJhbXMuYXBwZW5kKCdxdWVyeScsIHF1ZXJ5KTtcbiAgICAgICAgdXJsLnNlYXJjaFBhcmFtcy5hcHBlbmQoJ3N0b2NrJywgdGhpcy5hY3RpdmVGaWx0ZXJzLnN0b2NrKTtcbiAgICAgICAgdXJsLnNlYXJjaFBhcmFtcy5hcHBlbmQoJ3N0YXR1cycsIHRoaXMuYWN0aXZlRmlsdGVycy5zdGF0dXMpO1xuXG4gICAgICAgIGNvbnN0IHJlc3BvbnNlID0gYXdhaXQgZmV0Y2godXJsLnRvU3RyaW5nKCkpO1xuICAgICAgICBpZiAoIXJlc3BvbnNlLm9rKSB7XG4gICAgICAgICAgdGhyb3cgbmV3IEVycm9yKGBIVFRQIGVycm9yISBzdGF0dXM6ICR7cmVzcG9uc2Uuc3RhdHVzfWApO1xuICAgICAgICB9XG4gICAgICAgIGNvbnN0IGRhdGEgPSBhd2FpdCByZXNwb25zZS5qc29uKCk7XG5cbiAgICAgICAgLy8gVHJhbnNmb3JtIGFuZCBmaWx0ZXIgSVNWIGRhdGEgYnkgcXVlcnlcbiAgICAgICAgcmV0dXJuIHRoaXMuX3RyYW5zZm9ybUlTVkRhdGEoZGF0YSk7XG4gICAgICB9IGNhdGNoIChlcnJvcikge1xuICAgICAgICBjb25zb2xlLmVycm9yKCdJU1Ygc2VhcmNoIGZldGNoIGVycm9yOicsIGVycm9yKTtcbiAgICAgICAgcmV0dXJuIFtdOyAvLyBSZXR1cm4gZW1wdHkgb24gZXJyb3IsIG5vIGZhbGxiYWNrXG4gICAgICB9XG4gICAgfVxuXG4gICAgLy8gTm8gVVJMIGNvbmZpZ3VyZWQgLSByZXR1cm4gZW1wdHkgKEFKQVggb25seSBtb2RlKVxuICAgIGNvbnNvbGUud2FybignSVNWIHNlYXJjaCBVUkwgbm90IGNvbmZpZ3VyZWQnKTtcbiAgICByZXR1cm4gW107XG4gIH1cblxuICAvKipcbiAgICogVHJhbnNmb3JtIElTViBKU09OIGRhdGEgYW5kIGZpbHRlciBieSBxdWVyeVxuICAgKiBGaWx0ZXJzIGl0ZW1zIGJ5IG5hbWUvU0tVIG1hdGNoaW5nIHF1ZXJ5IChmb3Igc3RhdGljIEpTT04gZmlsZXMpXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBkYXRhIC0gSlNPTiBkYXRhIHdpdGggaXRlbXMgYXJyYXlcbiAgICogQHBhcmFtIHtzdHJpbmd9IHF1ZXJ5IC0gU2VhcmNoIHF1ZXJ5IGZvciBmaWx0ZXJpbmdcbiAgICogQHJldHVybnMge0FycmF5fVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3RyYW5zZm9ybUlTVkRhdGEoZGF0YSkge1xuICAgIC8vIFJldHVybiBhbGwgaXRlbXMgLSBzZXJ2ZXIgaXMgZXhwZWN0ZWQgdG8gcmV0dXJuIGZpbHRlcmVkIHJlc3VsdHNcbiAgICByZXR1cm4gZGF0YS5pdGVtcyB8fCBbXTtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZW5kZXIgc2VhcmNoIHJlc3VsdHNcbiAgICogQHBhcmFtIHtBcnJheX0gcmVzdWx0c1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3JlbmRlclJlc3VsdHMocmVzdWx0cykge1xuICAgIHRoaXMuX2hpZGVMb2FkaW5nKCk7XG5cbiAgICAvLyBIaWRlIHF1aWNrIGxpbmtzIHdoZW4gc2hvd2luZyByZXN1bHRzXG4gICAgaWYgKHRoaXMuX3F1aWNrTGlua3MpIHRoaXMuX3F1aWNrTGlua3Muc3R5bGUuZGlzcGxheSA9ICdub25lJztcblxuICAgIC8vIEhpZGUgc2VhcmNoIHByb21wdFxuICAgIHRoaXMuX2hpZGVFbXB0eSgpO1xuXG4gICAgaWYgKCFyZXN1bHRzIHx8IHJlc3VsdHMubGVuZ3RoID09PSAwKSB7XG4gICAgICB0aGlzLl9zaG93RW1wdHkoJ3NlYXJjaF9vZmYnLCAnTm8gcmVzdWx0cyBmb3VuZCcsIGBObyBtYXRjaGVzIGZvciBcIiR7dGhpcy5zZWFyY2hRdWVyeX1cImApO1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGlmICh0aGlzLmlzSVNWU2VhcmNoKSB7XG4gICAgICAvLyBTaG93IGZpbHRlciBiYXIgZm9yIElTViBzZWFyY2hcbiAgICAgIGlmICh0aGlzLl9maWx0ZXJCYXIpIHRoaXMuX2ZpbHRlckJhci5jbGFzc0xpc3QuYWRkKGNscygndmlzaWJsZScpKTtcbiAgICAgIGlmICh0aGlzLl9jYXRlZ29yeVRhYnMpIHRoaXMuX2NhdGVnb3J5VGFicy5jbGFzc0xpc3QucmVtb3ZlKGNscygndmlzaWJsZScpKTtcbiAgICAgIHRoaXMuX3JlbmRlcklTVlJlc3VsdHMocmVzdWx0cyk7XG4gICAgfSBlbHNlIHtcbiAgICAgIC8vIFNob3cgY2F0ZWdvcnkgdGFicyBmb3Igbm9ybWFsIHNlYXJjaFxuICAgICAgaWYgKHRoaXMuX2NhdGVnb3J5VGFicykgdGhpcy5fY2F0ZWdvcnlUYWJzLmNsYXNzTGlzdC5hZGQoY2xzKCd2aXNpYmxlJykpO1xuICAgICAgaWYgKHRoaXMuX2ZpbHRlckJhcikgdGhpcy5fZmlsdGVyQmFyLmNsYXNzTGlzdC5yZW1vdmUoY2xzKCd2aXNpYmxlJykpO1xuICAgICAgdGhpcy5fcmVuZGVyTm9ybWFsUmVzdWx0cyhyZXN1bHRzKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogUmVuZGVyIG5vcm1hbCBzZWFyY2ggcmVzdWx0cyAobWVudXMsIGFjY291bnRzKVxuICAgKiBAcGFyYW0ge0FycmF5fSByZXN1bHRzXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfcmVuZGVyTm9ybWFsUmVzdWx0cyhyZXN1bHRzKSB7XG4gICAgLy8gR3JvdXAgcmVzdWx0cyBieSB0eXBlXG4gICAgY29uc3QgZ3JvdXBlZCA9IHtcbiAgICAgIG1lbnVzOiByZXN1bHRzLmZpbHRlcihyID0+IHIudHlwZSA9PT0gJ21lbnUnKSxcbiAgICAgIGN1c3RvbWVyczogcmVzdWx0cy5maWx0ZXIociA9PiByLnR5cGUgPT09ICdjdXN0b21lcicpLFxuICAgICAgdmVuZG9yczogcmVzdWx0cy5maWx0ZXIociA9PiByLnR5cGUgPT09ICd2ZW5kb3InKSxcbiAgICAgIGxlZGdlcnM6IHJlc3VsdHMuZmlsdGVyKHIgPT4gci50eXBlID09PSAnbGVkZ2VyJyksXG4gICAgfTtcblxuICAgIC8vIFVwZGF0ZSBjYXRlZ29yeSBjb3VudHNcbiAgICB0aGlzLl91cGRhdGVDYXRlZ29yeUNvdW50cyhncm91cGVkKTtcblxuICAgIC8vIEZpbHRlciBieSBhY3RpdmUgY2F0ZWdvcnlcbiAgICBsZXQgZmlsdGVyZWRSZXN1bHRzID0gcmVzdWx0cztcbiAgICBpZiAodGhpcy5hY3RpdmVDYXRlZ29yeSAhPT0gJ2FsbCcpIHtcbiAgICAgIGZpbHRlcmVkUmVzdWx0cyA9IGdyb3VwZWRbdGhpcy5hY3RpdmVDYXRlZ29yeV0gfHwgW107XG4gICAgfVxuXG4gICAgLy8gUmVuZGVyIHRvIGNvbnRhaW5lclxuICAgIGlmICh0aGlzLl9yZXN1bHRzQ29udGFpbmVyKSB7XG4gICAgICBsZXQgaHRtbCA9ICcnO1xuXG4gICAgICAvLyBNZW51cyBzZWN0aW9uIChsaW1pdCB0byAxMCBpdGVtcyBsaWtlIHBsdWdpbnMgcHJvamVjdClcbiAgICAgIGNvbnN0IG1lbnVzID0gdGhpcy5hY3RpdmVDYXRlZ29yeSA9PT0gJ2FsbCcgPyBncm91cGVkLm1lbnVzIDogKHRoaXMuYWN0aXZlQ2F0ZWdvcnkgPT09ICdtZW51cycgPyBmaWx0ZXJlZFJlc3VsdHMgOiBbXSk7XG4gICAgICBpZiAobWVudXMubGVuZ3RoID4gMCkge1xuICAgICAgICBodG1sICs9IGBcbiAgICAgICAgICA8ZGl2IGNsYXNzPVwiJHtjbHMoJ3NlYXJjaC1vdmVybGF5LXNlY3Rpb24nKX1cIj5cbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCIke2Nscygnc2VhcmNoLW92ZXJsYXktc2VjdGlvbi10aXRsZScpfVwiPk1lbnUgJiBBY3Rpb25zPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwiJHtjbHMoJ3NlYXJjaC1vdmVybGF5LXJlc3VsdHMnKX1cIj5cbiAgICAgICAgICAgICAgJHttZW51cy5zbGljZSgwLCAxMCkubWFwKGl0ZW0gPT4gdGhpcy5fcmVuZGVyTWVudUl0ZW0oaXRlbSkpLmpvaW4oJycpfVxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgPC9kaXY+XG4gICAgICAgIGA7XG4gICAgICB9XG5cbiAgICAgIC8vIEFjY291bnRzIHNlY3Rpb24gLSBjb21iaW5lIGFsbCBhY2NvdW50IHR5cGVzIChsaW1pdCB0byAxMiBpdGVtcyBsaWtlIHBsdWdpbnMgcHJvamVjdClcbiAgICAgIGNvbnN0IGFsbEFjY291bnRzID0gW1xuICAgICAgICAuLi4odGhpcy5hY3RpdmVDYXRlZ29yeSA9PT0gJ2FsbCcgfHwgdGhpcy5hY3RpdmVDYXRlZ29yeSA9PT0gJ2N1c3RvbWVycycgPyBncm91cGVkLmN1c3RvbWVycyA6IFtdKSxcbiAgICAgICAgLi4uKHRoaXMuYWN0aXZlQ2F0ZWdvcnkgPT09ICdhbGwnIHx8IHRoaXMuYWN0aXZlQ2F0ZWdvcnkgPT09ICd2ZW5kb3JzJyA/IGdyb3VwZWQudmVuZG9ycyA6IFtdKSxcbiAgICAgICAgLi4uKHRoaXMuYWN0aXZlQ2F0ZWdvcnkgPT09ICdhbGwnIHx8IHRoaXMuYWN0aXZlQ2F0ZWdvcnkgPT09ICdsZWRnZXJzJyA/IGdyb3VwZWQubGVkZ2VycyA6IFtdKSxcbiAgICAgIF07XG4gICAgICBpZiAoYWxsQWNjb3VudHMubGVuZ3RoID4gMCkge1xuICAgICAgICBodG1sICs9IGBcbiAgICAgICAgICA8ZGl2IGNsYXNzPVwiJHtjbHMoJ3NlYXJjaC1vdmVybGF5LXNlY3Rpb24nKX1cIj5cbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCIke2Nscygnc2VhcmNoLW92ZXJsYXktc2VjdGlvbi10aXRsZScpfVwiPkFjY291bnRzPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwiJHtjbHMoJ3NlYXJjaC1hY2NvdW50LWNhcmRzJyl9XCI+XG4gICAgICAgICAgICAgICR7YWxsQWNjb3VudHMuc2xpY2UoMCwgMTIpLm1hcChpdGVtID0+IHRoaXMuX3JlbmRlckFjY291bnRDYXJkKGl0ZW0pKS5qb2luKCcnKX1cbiAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICBgO1xuICAgICAgfVxuXG4gICAgICB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLmlubmVySFRNTCA9IGh0bWw7XG4gICAgICB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBSZW5kZXIgSVNWIHNlYXJjaCByZXN1bHRzIChpdGVtcy9wcm9kdWN0cylcbiAgICogQHBhcmFtIHtBcnJheX0gcmVzdWx0c1xuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3JlbmRlcklTVlJlc3VsdHMocmVzdWx0cykge1xuICAgIC8vIFNob3cgdGhlIHJlc3VsdHMgY29udGFpbmVyIGZvciBJU1YgcmVzdWx0c1xuICAgIGlmICh0aGlzLl9yZXN1bHRzQ29udGFpbmVyKSB7XG4gICAgICB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuXG4gICAgICAvLyBSZXN0b3JlIGdyaWQvbGlzdCBzdHJ1Y3R1cmUgaWYgZGVzdHJveWVkIGJ5IG5vcm1hbCBzZWFyY2hcbiAgICAgIGlmICghdGhpcy5fcmVzdWx0c0NvbnRhaW5lci5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5yZXN1bHRzR3JpZFNlbGVjdG9yKSkge1xuICAgICAgICB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLmlubmVySFRNTCA9IGBcbiAgICAgICAgICA8ZGl2IGNsYXNzPVwiJHtjbHMoJ3NlYXJjaC1yZXN1bHRzLWdyaWQnKX1cIj48L2Rpdj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwiJHtjbHMoJ3NlYXJjaC1yZXN1bHRzLWxpc3QnKX1cIj48L2Rpdj5cbiAgICAgICAgYDtcbiAgICAgICAgLy8gUmUtY2FjaGUgdGhlIGVsZW1lbnRzXG4gICAgICAgIHRoaXMuX3Jlc3VsdHNHcmlkID0gdGhpcy5fcmVzdWx0c0NvbnRhaW5lci5xdWVyeVNlbGVjdG9yKHRoaXMub3B0aW9ucy5yZXN1bHRzR3JpZFNlbGVjdG9yKTtcbiAgICAgICAgdGhpcy5fcmVzdWx0c0xpc3QgPSB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLnF1ZXJ5U2VsZWN0b3IodGhpcy5vcHRpb25zLnJlc3VsdHNMaXN0U2VsZWN0b3IpO1xuICAgICAgfVxuICAgIH1cblxuICAgIGlmICh0aGlzLmN1cnJlbnRWaWV3ID09PSAnZ3JpZCcpIHtcbiAgICAgIGlmICh0aGlzLl9yZXN1bHRzR3JpZCkge1xuICAgICAgICB0aGlzLl9yZXN1bHRzR3JpZC5pbm5lckhUTUwgPSByZXN1bHRzLm1hcChpdGVtID0+IHRoaXMuX3JlbmRlckl0ZW1DYXJkKGl0ZW0pKS5qb2luKCcnKTtcbiAgICAgICAgdGhpcy5fcmVzdWx0c0dyaWQuY2xhc3NMaXN0LmFkZChjbHMoJ3Zpc2libGUnKSk7XG4gICAgICB9XG4gICAgICBpZiAodGhpcy5fcmVzdWx0c0xpc3QpIHtcbiAgICAgICAgdGhpcy5fcmVzdWx0c0xpc3QuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ3Zpc2libGUnKSk7XG4gICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgIGlmICh0aGlzLl9yZXN1bHRzTGlzdCkge1xuICAgICAgICB0aGlzLl9yZXN1bHRzTGlzdC5pbm5lckhUTUwgPSBgXG4gICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1saXN0LWhlYWRlclwiPlxuICAgICAgICAgICAgPHNwYW4+SXRlbTwvc3Bhbj5cbiAgICAgICAgICAgIDxzcGFuPlN0b2NrPC9zcGFuPlxuICAgICAgICAgICAgPHNwYW4+UHJpY2U8L3NwYW4+XG4gICAgICAgICAgICA8c3Bhbj5Db3N0PC9zcGFuPlxuICAgICAgICAgICAgPHNwYW4+VmVuZG9yPC9zcGFuPlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICR7cmVzdWx0cy5tYXAoaXRlbSA9PiB0aGlzLl9yZW5kZXJJdGVtUm93KGl0ZW0pKS5qb2luKCcnKX1cbiAgICAgICAgYDtcbiAgICAgICAgdGhpcy5fcmVzdWx0c0xpc3QuY2xhc3NMaXN0LmFkZChjbHMoJ3Zpc2libGUnKSk7XG4gICAgICB9XG4gICAgICBpZiAodGhpcy5fcmVzdWx0c0dyaWQpIHtcbiAgICAgICAgdGhpcy5fcmVzdWx0c0dyaWQuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ3Zpc2libGUnKSk7XG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIFJlbmRlciBhIG1lbnUgaXRlbVxuICAgKiBAcGFyYW0ge09iamVjdH0gaXRlbVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3JlbmRlck1lbnVJdGVtKGl0ZW0pIHtcbiAgICByZXR1cm4gYFxuICAgICAgPGEgaHJlZj1cIiR7aXRlbS51cmwgfHwgJyMnfVwiIGNsYXNzPVwic28tc2VhcmNoLW92ZXJsYXktaXRlbVwiIGRhdGEtaXRlbS1pZD1cIiR7aXRlbS5pZH1cIiBkYXRhLWl0ZW0tdHlwZT1cIm1lbnVcIj5cbiAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1vdmVybGF5LWl0ZW0taWNvbiAke2l0ZW0uaWNvbkNvbG9yIHx8ICdibHVlJ31cIj5cbiAgICAgICAgICA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zXCI+JHtpdGVtLmljb24gfHwgJ2FydGljbGUnfTwvc3Bhbj5cbiAgICAgICAgPC9kaXY+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtb3ZlcmxheS1pdGVtLWNvbnRlbnRcIj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLW92ZXJsYXktaXRlbS10aXRsZVwiPiR7dGhpcy5faGlnaGxpZ2h0TWF0Y2goaXRlbS5uYW1lLCB0aGlzLnNlYXJjaFF1ZXJ5KX08L2Rpdj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLW92ZXJsYXktaXRlbS1wYXRoXCI+JHtpdGVtLnBhdGggfHwgJyd9PC9kaXY+XG4gICAgICAgIDwvZGl2PlxuICAgICAgICA8c3BhbiBjbGFzcz1cIm1hdGVyaWFsLWljb25zIHNvLXNlYXJjaC1vdmVybGF5LWl0ZW0tYXJyb3dcIj5hcnJvd19mb3J3YXJkPC9zcGFuPlxuICAgICAgPC9hPlxuICAgIGA7XG4gIH1cblxuICAvKipcbiAgICogUmVuZGVyIGFuIGFjY291bnQgY2FyZFxuICAgKiBAcGFyYW0ge09iamVjdH0gaXRlbVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3JlbmRlckFjY291bnRDYXJkKGl0ZW0pIHtcbiAgICBjb25zdCBiYWxhbmNlQ2xhc3MgPSBpdGVtLmJhbGFuY2UgPiAwID8gJ3Bvc2l0aXZlJyA6IChpdGVtLmJhbGFuY2UgPCAwID8gJ25lZ2F0aXZlJyA6ICduZXV0cmFsJyk7XG4gICAgY29uc3QgYmFsYW5jZVRleHQgPSB0aGlzLl9mb3JtYXRXYWxsZXRCYWxhbmNlKGl0ZW0uYmFsYW5jZSk7XG5cbiAgICByZXR1cm4gYFxuICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1hY2NvdW50LWNhcmRcIiBkYXRhLWl0ZW0taWQ9XCIke2l0ZW0uaWR9XCIgZGF0YS1pdGVtLXR5cGU9XCIke2l0ZW0udHlwZX1cIj5cbiAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1hY2NvdW50LWNhcmQtaGVhZGVyXCI+XG4gICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1hY2NvdW50LWNhcmQtaWNvbiAke2l0ZW0uaWNvbkNvbG9yIHx8ICdibHVlJ31cIj5cbiAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwibWF0ZXJpYWwtaWNvbnNcIj4ke2l0ZW0uaWNvbiB8fCAnYWNjb3VudF9jaXJjbGUnfTwvc3Bhbj5cbiAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWFjY291bnQtY2FyZC1pbmZvXCI+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWFjY291bnQtY2FyZC1uYW1lXCI+JHt0aGlzLl9oaWdobGlnaHRNYXRjaChpdGVtLm5hbWUsIHRoaXMuc2VhcmNoUXVlcnkpfTwvZGl2PlxuICAgICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1hY2NvdW50LWNhcmQtY2F0ZWdvcnlcIj4ke2l0ZW0uY2F0ZWdvcnkgfHwgaXRlbS50eXBlfTwvZGl2PlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtYWNjb3VudC1jYXJkLWJhbGFuY2UgJHtiYWxhbmNlQ2xhc3N9XCI+JHtiYWxhbmNlVGV4dH08L2Rpdj5cbiAgICAgICAgPC9kaXY+XG4gICAgICAgICR7aXRlbS5kZXRhaWxzID8gYFxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtYWNjb3VudC1jYXJkLWRldGFpbHNcIj5cbiAgICAgICAgICAgICR7aXRlbS5kZXRhaWxzLm1hcChkID0+IGBcbiAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1hY2NvdW50LWNhcmQtZGV0YWlsXCI+XG4gICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1hY2NvdW50LWNhcmQtZGV0YWlsLWxhYmVsXCI+JHtkLmxhYmVsfTwvZGl2PlxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtYWNjb3VudC1jYXJkLWRldGFpbC12YWx1ZVwiPiR7ZC52YWx1ZX08L2Rpdj5cbiAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICBgKS5qb2luKCcnKX1cbiAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgYCA6ICcnfVxuICAgICAgPC9kaXY+XG4gICAgYDtcbiAgfVxuXG4gIC8qKlxuICAgKiBSZW5kZXIgYW4gaXRlbSBjYXJkIChncmlkIHZpZXcpXG4gICAqIEBwYXJhbSB7T2JqZWN0fSBpdGVtXG4gICAqIEByZXR1cm5zIHtzdHJpbmd9XG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfcmVuZGVySXRlbUNhcmQoaXRlbSkge1xuICAgIGNvbnN0IHN0b2NrQ2xhc3MgPSB0aGlzLl9nZXRTdG9ja0NsYXNzKGl0ZW0uc3RvY2spO1xuICAgIGNvbnN0IHN0YXR1c0NsYXNzID0gaXRlbS5zdGF0dXMgPT09ICdhY3RpdmUnID8gY2xzKCdhY3RpdmUnKSA6ICdsaXF1aWRhdGlvbic7XG5cbiAgICByZXR1cm4gYFxuICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1pdGVtLWNhcmRcIiBkYXRhLWl0ZW0taWQ9XCIke2l0ZW0uaWR9XCIgZGF0YS1pdGVtLXR5cGU9XCJpdGVtXCI+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLWhlYWRlclwiPlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLXNrdVwiPiR7aXRlbS5za3UgfHwgJyd9PC9kaXY+XG4gICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1pdGVtLWNhcmQtc3RhdHVzICR7c3RhdHVzQ2xhc3N9XCI+JHtpdGVtLnN0YXR1cyB8fCAnYWN0aXZlJ308L2Rpdj5cbiAgICAgICAgPC9kaXY+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLXRpdGxlXCI+JHt0aGlzLl9oaWdobGlnaHRNYXRjaChpdGVtLm5hbWUsIHRoaXMuc2VhcmNoUXVlcnkucmVwbGFjZSgvXmlzdjovaSwgJycpLnRyaW0oKSl9PC9kaXY+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLWRldGFpbHNcIj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tY2FyZC1kZXRhaWxcIj5cbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLWRldGFpbC1sYWJlbFwiPlN0b2NrPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tY2FyZC1kZXRhaWwtdmFsdWUgJHtzdG9ja0NsYXNzfVwiPiR7aXRlbS5zdG9ja308L2Rpdj5cbiAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tY2FyZC1kZXRhaWxcIj5cbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLWRldGFpbC1sYWJlbFwiPlByaWNlPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tY2FyZC1kZXRhaWwtdmFsdWVcIj4ke3RoaXMuX2Zvcm1hdEN1cnJlbmN5KGl0ZW0ucHJpY2UpfTwvZGl2PlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLWRldGFpbFwiPlxuICAgICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1pdGVtLWNhcmQtZGV0YWlsLWxhYmVsXCI+Q29zdDwvZGl2PlxuICAgICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1pdGVtLWNhcmQtZGV0YWlsLXZhbHVlXCI+JHt0aGlzLl9mb3JtYXRDdXJyZW5jeShpdGVtLmNvc3QpfTwvZGl2PlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1jYXJkLWRldGFpbFwiPlxuICAgICAgICAgICAgPGRpdiBjbGFzcz1cInNvLXNlYXJjaC1pdGVtLWNhcmQtZGV0YWlsLWxhYmVsXCI+VmVuZG9yIFN0b2NrPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tY2FyZC1kZXRhaWwtdmFsdWVcIj4ke2l0ZW0udmVuZG9yU3RvY2sgfHwgMH08L2Rpdj5cbiAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgPC9kaXY+XG4gICAgICA8L2Rpdj5cbiAgICBgO1xuICB9XG5cbiAgLyoqXG4gICAqIFJlbmRlciBhbiBpdGVtIHJvdyAobGlzdCB2aWV3KVxuICAgKiBAcGFyYW0ge09iamVjdH0gaXRlbVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3JlbmRlckl0ZW1Sb3coaXRlbSkge1xuICAgIGNvbnN0IHN0b2NrQ2xhc3MgPSB0aGlzLl9nZXRTdG9ja0NsYXNzKGl0ZW0uc3RvY2spO1xuXG4gICAgcmV0dXJuIGBcbiAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1yb3dcIiBkYXRhLWl0ZW0taWQ9XCIke2l0ZW0uaWR9XCIgZGF0YS1pdGVtLXR5cGU9XCJpdGVtXCI+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1yb3ctaW5mb1wiPlxuICAgICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1yb3ctdGl0bGVcIj4ke3RoaXMuX2hpZ2hsaWdodE1hdGNoKGl0ZW0ubmFtZSwgdGhpcy5zZWFyY2hRdWVyeS5yZXBsYWNlKC9eaXN2Oi9pLCAnJykudHJpbSgpKX08L2Rpdj5cbiAgICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tcm93LXNrdVwiPiR7aXRlbS5za3UgfHwgJyd9PC9kaXY+XG4gICAgICAgIDwvZGl2PlxuICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tcm93LXZhbHVlICR7c3RvY2tDbGFzc31cIj4ke2l0ZW0uc3RvY2t9PC9kaXY+XG4gICAgICAgIDxkaXYgY2xhc3M9XCJzby1zZWFyY2gtaXRlbS1yb3ctdmFsdWVcIj4ke3RoaXMuX2Zvcm1hdEN1cnJlbmN5KGl0ZW0ucHJpY2UpfTwvZGl2PlxuICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tcm93LXZhbHVlXCI+JHt0aGlzLl9mb3JtYXRDdXJyZW5jeShpdGVtLmNvc3QpfTwvZGl2PlxuICAgICAgICA8ZGl2IGNsYXNzPVwic28tc2VhcmNoLWl0ZW0tcm93LXZhbHVlXCI+JHtpdGVtLnZlbmRvclN0b2NrIHx8IDB9PC9kaXY+XG4gICAgICA8L2Rpdj5cbiAgICBgO1xuICB9XG5cbiAgLyoqXG4gICAqIFVwZGF0ZSBjYXRlZ29yeSBjb3VudHMgaW4gdGFic1xuICAgKiBAcGFyYW0ge09iamVjdH0gZ3JvdXBlZFxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX3VwZGF0ZUNhdGVnb3J5Q291bnRzKGdyb3VwZWQpIHtcbiAgICBjb25zdCB0b3RhbCA9IE9iamVjdC52YWx1ZXMoZ3JvdXBlZCkucmVkdWNlKChzdW0sIGFycikgPT4gc3VtICsgYXJyLmxlbmd0aCwgMCk7XG5cbiAgICB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1zZWFyY2gtY2F0ZWdvcnktdGFiJykuZm9yRWFjaCh0YWIgPT4ge1xuICAgICAgY29uc3QgY2F0ZWdvcnkgPSB0YWIuZGF0YXNldC5jYXRlZ29yeTtcbiAgICAgIGNvbnN0IGNvdW50ID0gdGFiLnF1ZXJ5U2VsZWN0b3IoJy5zby1zZWFyY2gtY2F0ZWdvcnktY291bnQnKTtcbiAgICAgIGlmIChjb3VudCkge1xuICAgICAgICBjb25zdCB2YWx1ZSA9IGNhdGVnb3J5ID09PSAnYWxsJyA/IHRvdGFsIDogKGdyb3VwZWRbY2F0ZWdvcnldPy5sZW5ndGggfHwgMCk7XG4gICAgICAgIGNvdW50LnRleHRDb250ZW50ID0gdmFsdWU7XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBLRVlCT0FSRCBOQVZJR0FUSU9OXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIEZvY3VzIG5leHQgcmVzdWx0IGl0ZW1cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9mb2N1c05leHQoKSB7XG4gICAgY29uc3QgaXRlbXMgPSB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zby1zZWFyY2gtb3ZlcmxheS1pdGVtLCAuc28tc2VhcmNoLWFjY291bnQtY2FyZCwgLnNvLXNlYXJjaC1pdGVtLWNhcmQsIC5zby1zZWFyY2gtaXRlbS1yb3cnKTtcbiAgICBpZiAoaXRlbXMubGVuZ3RoID09PSAwKSByZXR1cm47XG5cbiAgICB0aGlzLmZvY3VzZWRJbmRleCA9IE1hdGgubWluKHRoaXMuZm9jdXNlZEluZGV4ICsgMSwgaXRlbXMubGVuZ3RoIC0gMSk7XG4gICAgdGhpcy5fdXBkYXRlRm9jdXMoaXRlbXMpO1xuICB9XG5cbiAgLyoqXG4gICAqIEZvY3VzIHByZXZpb3VzIHJlc3VsdCBpdGVtXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfZm9jdXNQcmV2KCkge1xuICAgIGNvbnN0IGl0ZW1zID0gdGhpcy5fb3ZlcmxheS5xdWVyeVNlbGVjdG9yQWxsKCcuc28tc2VhcmNoLW92ZXJsYXktaXRlbSwgLnNvLXNlYXJjaC1hY2NvdW50LWNhcmQsIC5zby1zZWFyY2gtaXRlbS1jYXJkLCAuc28tc2VhcmNoLWl0ZW0tcm93Jyk7XG4gICAgaWYgKGl0ZW1zLmxlbmd0aCA9PT0gMCkgcmV0dXJuO1xuXG4gICAgdGhpcy5mb2N1c2VkSW5kZXggPSBNYXRoLm1heCh0aGlzLmZvY3VzZWRJbmRleCAtIDEsIDApO1xuICAgIHRoaXMuX3VwZGF0ZUZvY3VzKGl0ZW1zKTtcbiAgfVxuXG4gIC8qKlxuICAgKiBVcGRhdGUgZm9jdXMgc3RhdGUgb24gaXRlbXNcbiAgICogQHBhcmFtIHtOb2RlTGlzdH0gaXRlbXNcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF91cGRhdGVGb2N1cyhpdGVtcykge1xuICAgIGl0ZW1zLmZvckVhY2goKGl0ZW0sIGluZGV4KSA9PiB7XG4gICAgICBpdGVtLmNsYXNzTGlzdC50b2dnbGUoY2xzKCdmb2N1c2VkJyksIGluZGV4ID09PSB0aGlzLmZvY3VzZWRJbmRleCk7XG4gICAgfSk7XG5cbiAgICAvLyBTY3JvbGwgaW50byB2aWV3XG4gICAgaWYgKGl0ZW1zW3RoaXMuZm9jdXNlZEluZGV4XSkge1xuICAgICAgaXRlbXNbdGhpcy5mb2N1c2VkSW5kZXhdLnNjcm9sbEludG9WaWV3KHsgYmxvY2s6ICduZWFyZXN0JyB9KTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogU2VsZWN0IHRoZSBmb2N1c2VkIGl0ZW1cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zZWxlY3RGb2N1c2VkKCkge1xuICAgIGNvbnN0IGZvY3VzZWQgPSB0aGlzLl9vdmVybGF5LnF1ZXJ5U2VsZWN0b3IoYC4ke2NscygnZm9jdXNlZCcpfWApO1xuICAgIGlmIChmb2N1c2VkKSB7XG4gICAgICBmb2N1c2VkLmNsaWNrKCk7XG4gICAgfVxuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gVUkgU1RBVEUgTUVUSE9EU1xuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4gIC8qKlxuICAgKiBTaG93IGxvYWRpbmcgc3RhdGVcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zaG93TG9hZGluZygpIHtcbiAgICBpZiAodGhpcy5fbG9hZGluZykgdGhpcy5fbG9hZGluZy5jbGFzc0xpc3QuYWRkKGNscygndmlzaWJsZScpKTtcbiAgICBpZiAodGhpcy5fZW1wdHkpIHRoaXMuX2VtcHR5LmNsYXNzTGlzdC5yZW1vdmUoY2xzKCd2aXNpYmxlJykpO1xuICAgIGlmICh0aGlzLl9xdWlja0xpbmtzKSB0aGlzLl9xdWlja0xpbmtzLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgaWYgKHRoaXMuX3Jlc3VsdHNDb250YWluZXIpIHRoaXMuX3Jlc3VsdHNDb250YWluZXIuc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICBpZiAodGhpcy5fcmVzdWx0c0dyaWQpIHRoaXMuX3Jlc3VsdHNHcmlkLmNsYXNzTGlzdC5yZW1vdmUoY2xzKCd2aXNpYmxlJykpO1xuICAgIGlmICh0aGlzLl9yZXN1bHRzTGlzdCkgdGhpcy5fcmVzdWx0c0xpc3QuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ3Zpc2libGUnKSk7XG4gIH1cblxuICAvKipcbiAgICogSGlkZSBsb2FkaW5nIHN0YXRlXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfaGlkZUxvYWRpbmcoKSB7XG4gICAgaWYgKHRoaXMuX2xvYWRpbmcpIHRoaXMuX2xvYWRpbmcuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ3Zpc2libGUnKSk7XG4gIH1cblxuICAvKipcbiAgICogU2hvdyBlbXB0eSBzdGF0ZVxuICAgKiBAcGFyYW0ge3N0cmluZ30gaWNvblxuICAgKiBAcGFyYW0ge3N0cmluZ30gdGl0bGVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHRleHRcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zaG93RW1wdHkoaWNvbiwgdGl0bGUsIHRleHQpIHtcbiAgICBpZiAodGhpcy5fZW1wdHkpIHtcbiAgICAgIGNvbnN0IGljb25FbCA9IHRoaXMuX2VtcHR5LnF1ZXJ5U2VsZWN0b3IoJy5zby1zZWFyY2gtZW1wdHktaWNvbicpO1xuICAgICAgY29uc3QgdGl0bGVFbCA9IHRoaXMuX2VtcHR5LnF1ZXJ5U2VsZWN0b3IoJy5zby1zZWFyY2gtZW1wdHktdGl0bGUnKTtcbiAgICAgIGNvbnN0IHRleHRFbCA9IHRoaXMuX2VtcHR5LnF1ZXJ5U2VsZWN0b3IoJy5zby1zZWFyY2gtZW1wdHktdGV4dCcpO1xuXG4gICAgICBpZiAoaWNvbkVsKSBpY29uRWwudGV4dENvbnRlbnQgPSBpY29uO1xuICAgICAgaWYgKHRpdGxlRWwpIHRpdGxlRWwudGV4dENvbnRlbnQgPSB0aXRsZTtcbiAgICAgIGlmICh0ZXh0RWwpIHRleHRFbC50ZXh0Q29udGVudCA9IHRleHQ7XG5cbiAgICAgIHRoaXMuX2VtcHR5LmNsYXNzTGlzdC5hZGQoY2xzKCd2aXNpYmxlJykpO1xuICAgIH1cbiAgICAvLyBIaWRlIHF1aWNrIGxpbmtzIHdoZW4gc2hvd2luZyBlbXB0eSBzdGF0ZSAoZm9yIFwibm8gcmVzdWx0c1wiIHNjZW5hcmlvKVxuICAgIGlmICh0aGlzLl9xdWlja0xpbmtzKSB0aGlzLl9xdWlja0xpbmtzLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgaWYgKHRoaXMuX3Jlc3VsdHNDb250YWluZXIpIHRoaXMuX3Jlc3VsdHNDb250YWluZXIuc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICBpZiAodGhpcy5fcmVzdWx0c0dyaWQpIHRoaXMuX3Jlc3VsdHNHcmlkLmNsYXNzTGlzdC5yZW1vdmUoY2xzKCd2aXNpYmxlJykpO1xuICAgIGlmICh0aGlzLl9yZXN1bHRzTGlzdCkgdGhpcy5fcmVzdWx0c0xpc3QuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ3Zpc2libGUnKSk7XG4gIH1cblxuICAvKipcbiAgICogSGlkZSBlbXB0eSBzdGF0ZVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2hpZGVFbXB0eSgpIHtcbiAgICBpZiAodGhpcy5fZW1wdHkpIHRoaXMuX2VtcHR5LmNsYXNzTGlzdC5yZW1vdmUoY2xzKCd2aXNpYmxlJykpO1xuICB9XG5cbiAgLyoqXG4gICAqIFNob3cgZGVmYXVsdCBzdGF0ZSAocXVpY2sgbGlua3MgKyBzZWFyY2ggcHJvbXB0IHdoZW4gZW1wdHkpXG4gICAqIEBwcml2YXRlXG4gICAqL1xuICBfc2hvd0RlZmF1bHRTdGF0ZSgpIHtcbiAgICB0aGlzLl9oaWRlTG9hZGluZygpO1xuICAgIGlmICh0aGlzLl9xdWlja0xpbmtzKSB0aGlzLl9xdWlja0xpbmtzLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgIGlmICh0aGlzLl9yZXN1bHRzQ29udGFpbmVyKSB0aGlzLl9yZXN1bHRzQ29udGFpbmVyLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgaWYgKHRoaXMuX3Jlc3VsdHNHcmlkKSB0aGlzLl9yZXN1bHRzR3JpZC5jbGFzc0xpc3QucmVtb3ZlKGNscygndmlzaWJsZScpKTtcbiAgICBpZiAodGhpcy5fcmVzdWx0c0xpc3QpIHRoaXMuX3Jlc3VsdHNMaXN0LmNsYXNzTGlzdC5yZW1vdmUoY2xzKCd2aXNpYmxlJykpO1xuICAgIGlmICh0aGlzLl9jYXRlZ29yeVRhYnMpIHRoaXMuX2NhdGVnb3J5VGFicy5jbGFzc0xpc3QucmVtb3ZlKGNscygndmlzaWJsZScpKTtcbiAgICBpZiAodGhpcy5fZmlsdGVyQmFyKSB0aGlzLl9maWx0ZXJCYXIuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ3Zpc2libGUnKSk7XG5cbiAgICAvLyBTaG93IHNlYXJjaCBwcm9tcHQgYmVsb3cgcXVpY2sgbGlua3NcbiAgICB0aGlzLl9zaG93U2VhcmNoUHJvbXB0KCk7XG4gIH1cblxuICAvKipcbiAgICogU2hvdyBzZWFyY2ggcHJvbXB0ICh3aXRob3V0IGhpZGluZyBvdGhlciBlbGVtZW50cylcbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9zaG93U2VhcmNoUHJvbXB0KCkge1xuICAgIGlmICh0aGlzLl9lbXB0eSkge1xuICAgICAgY29uc3QgaWNvbkVsID0gdGhpcy5fZW1wdHkucXVlcnlTZWxlY3RvcignLnNvLXNlYXJjaC1lbXB0eS1pY29uJyk7XG4gICAgICBjb25zdCB0aXRsZUVsID0gdGhpcy5fZW1wdHkucXVlcnlTZWxlY3RvcignLnNvLXNlYXJjaC1lbXB0eS10aXRsZScpO1xuICAgICAgY29uc3QgdGV4dEVsID0gdGhpcy5fZW1wdHkucXVlcnlTZWxlY3RvcignLnNvLXNlYXJjaC1lbXB0eS10ZXh0Jyk7XG5cbiAgICAgIGlmIChpY29uRWwpIGljb25FbC50ZXh0Q29udGVudCA9ICdzZWFyY2gnO1xuICAgICAgaWYgKHRpdGxlRWwpIHRpdGxlRWwudGV4dENvbnRlbnQgPSAnU3RhcnQgdHlwaW5nIHRvIHNlYXJjaCc7XG4gICAgICBpZiAodGV4dEVsKSB0ZXh0RWwudGV4dENvbnRlbnQgPSAnU2VhcmNoIGZvciBtZW51cywgY3VzdG9tZXJzLCB2ZW5kb3JzLCBsZWRnZXJzIG9yIHR5cGUgXCJpc3Y6XCIgZm9yIGl0ZW0gc2VhcmNoJztcblxuICAgICAgdGhpcy5fZW1wdHkuY2xhc3NMaXN0LmFkZChjbHMoJ3Zpc2libGUnKSk7XG4gICAgfVxuICB9XG5cbiAgLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbiAgLy8gVVRJTElUWSBNRVRIT0RTXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIEhpZ2hsaWdodCBzZWFyY2ggbWF0Y2ggaW4gdGV4dFxuICAgKiBAcGFyYW0ge3N0cmluZ30gdGV4dFxuICAgKiBAcGFyYW0ge3N0cmluZ30gcXVlcnlcbiAgICogQHJldHVybnMge3N0cmluZ31cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9oaWdobGlnaHRNYXRjaCh0ZXh0LCBxdWVyeSkge1xuICAgIGlmICghcXVlcnkgfHwgIXRleHQpIHJldHVybiB0ZXh0O1xuICAgIGNvbnN0IGVzY2FwZWQgPSB0aGlzLl9lc2NhcGVIdG1sKHF1ZXJ5KS5yZXBsYWNlKC9bLiorP14ke30oKXxbXFxdXFxcXF0vZywgJ1xcXFwkJicpO1xuICAgIGNvbnN0IHJlZ2V4ID0gbmV3IFJlZ0V4cChgKCR7ZXNjYXBlZH0pYCwgJ2dpJyk7XG4gICAgcmV0dXJuIHRoaXMuX2VzY2FwZUh0bWwodGV4dCkucmVwbGFjZShyZWdleCwgJzxtYXJrPiQxPC9tYXJrPicpO1xuICB9XG5cbiAgLyoqXG4gICAqIEVzY2FwZSBIVE1MIHNwZWNpYWwgY2hhcmFjdGVyc1xuICAgKiBAcGFyYW0ge3N0cmluZ30gdGV4dFxuICAgKiBAcmV0dXJucyB7c3RyaW5nfVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2VzY2FwZUh0bWwodGV4dCkge1xuICAgIGNvbnN0IGRpdiA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xuICAgIGRpdi50ZXh0Q29udGVudCA9IHRleHQ7XG4gICAgcmV0dXJuIGRpdi5pbm5lckhUTUw7XG4gIH1cblxuICAvKipcbiAgICogRm9ybWF0IGN1cnJlbmN5XG4gICAqIEBwYXJhbSB7bnVtYmVyfSB2YWx1ZVxuICAgKiBAcmV0dXJucyB7c3RyaW5nfVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2Zvcm1hdEN1cnJlbmN5KHZhbHVlKSB7XG4gICAgaWYgKHZhbHVlID09PSBudWxsIHx8IHZhbHVlID09PSB1bmRlZmluZWQpIHJldHVybiAnLSc7XG4gICAgcmV0dXJuIG5ldyBJbnRsLk51bWJlckZvcm1hdCgnZW4tSU4nLCB7XG4gICAgICBzdHlsZTogJ2N1cnJlbmN5JyxcbiAgICAgIGN1cnJlbmN5OiAnSU5SJyxcbiAgICAgIG1pbmltdW1GcmFjdGlvbkRpZ2l0czogMixcbiAgICB9KS5mb3JtYXQodmFsdWUpO1xuICB9XG5cbiAgLyoqXG4gICAqIEZvcm1hdCB3YWxsZXQgYmFsYW5jZSB3aXRoIENyL0RyIHN1ZmZpeFxuICAgKiBAcGFyYW0ge251bWJlcn0gdmFsdWVcbiAgICogQHJldHVybnMge3N0cmluZ31cbiAgICogQHByaXZhdGVcbiAgICovXG4gIF9mb3JtYXRXYWxsZXRCYWxhbmNlKHZhbHVlKSB7XG4gICAgaWYgKHZhbHVlID09PSBudWxsIHx8IHZhbHVlID09PSB1bmRlZmluZWQgfHwgdmFsdWUgPT09IDApIHJldHVybiAnLSc7XG4gICAgY29uc3QgZm9ybWF0dGVkID0gdGhpcy5fZm9ybWF0Q3VycmVuY3koTWF0aC5hYnModmFsdWUpKTtcbiAgICByZXR1cm4gdmFsdWUgPiAwID8gYCR7Zm9ybWF0dGVkfSBDcmAgOiBgJHtmb3JtYXR0ZWR9IERyYDtcbiAgfVxuXG4gIC8qKlxuICAgKiBHZXQgc3RvY2sgc3RhdHVzIGNsYXNzXG4gICAqIEBwYXJhbSB7bnVtYmVyfSBzdG9ja1xuICAgKiBAcmV0dXJucyB7c3RyaW5nfVxuICAgKiBAcHJpdmF0ZVxuICAgKi9cbiAgX2dldFN0b2NrQ2xhc3Moc3RvY2spIHtcbiAgICBpZiAoc3RvY2sgPD0gMCkgcmV0dXJuICdvdXQtb2Ytc3RvY2snO1xuICAgIGlmIChzdG9jayA8IDEwKSByZXR1cm4gJ2xvdy1zdG9jayc7XG4gICAgcmV0dXJuICdpbi1zdG9jayc7XG4gIH1cblxuICAvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuICAvLyBQVUJMSUMgQVBJXG4gIC8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbiAgLyoqXG4gICAqIENvbmZpZ3VyZSB0aGUgc2VhcmNoIGNvbnRyb2xsZXJcbiAgICogQHBhcmFtIHtPYmplY3R9IGNvbmZpZ1xuICAgKi9cbiAgY29uZmlndXJlKGNvbmZpZykge1xuICAgIGlmIChjb25maWcuc2VhcmNoVXJsKSB0aGlzLnNlYXJjaFVybCA9IGNvbmZpZy5zZWFyY2hVcmw7XG4gICAgaWYgKGNvbmZpZy5pc3ZTZWFyY2hVcmwpIHRoaXMuaXN2U2VhcmNoVXJsID0gY29uZmlnLmlzdlNlYXJjaFVybDtcbiAgICBpZiAoY29uZmlnLm9uU2VhcmNoKSB0aGlzLm9uU2VhcmNoID0gY29uZmlnLm9uU2VhcmNoO1xuICAgIGlmIChjb25maWcub25JdGVtQ2xpY2spIHRoaXMub25JdGVtQ2xpY2sgPSBjb25maWcub25JdGVtQ2xpY2s7XG4gICAgaWYgKGNvbmZpZy5vbkFjY291bnRDbGljaykgdGhpcy5vbkFjY291bnRDbGljayA9IGNvbmZpZy5vbkFjY291bnRDbGljaztcbiAgICBpZiAoY29uZmlnLm9uUXVpY2tBY3Rpb25DbGljaykgdGhpcy5vblF1aWNrQWN0aW9uQ2xpY2sgPSBjb25maWcub25RdWlja0FjdGlvbkNsaWNrO1xuICB9XG5cbiAgLyoqXG4gICAqIE9wZW4gdGhlIHNlYXJjaCBvdmVybGF5XG4gICAqL1xuICBvcGVuKCkge1xuICAgIGlmICh0aGlzLmlzT3BlbikgcmV0dXJuO1xuXG4gICAgdGhpcy5pc09wZW4gPSB0cnVlO1xuICAgIHRoaXMuX292ZXJsYXkuY2xhc3NMaXN0LmFkZChjbHMoJ2FjdGl2ZScpKTtcbiAgICBkb2N1bWVudC5ib2R5LnN0eWxlLm92ZXJmbG93ID0gJ2hpZGRlbic7XG5cbiAgICAvLyBGb2N1cyBpbnB1dFxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgaWYgKHRoaXMuX2lucHV0KSB0aGlzLl9pbnB1dC5mb2N1cygpO1xuICAgIH0sIDEwMCk7XG5cbiAgICAvLyBTaG93IGRlZmF1bHQgc3RhdGVcbiAgICB0aGlzLl9zaG93RGVmYXVsdFN0YXRlKCk7XG4gIH1cblxuICAvKipcbiAgICogQ2xvc2UgdGhlIHNlYXJjaCBvdmVybGF5XG4gICAqL1xuICBjbG9zZSgpIHtcbiAgICBpZiAoIXRoaXMuaXNPcGVuKSByZXR1cm47XG5cbiAgICB0aGlzLmlzT3BlbiA9IGZhbHNlO1xuICAgIHRoaXMuX292ZXJsYXkuY2xhc3NMaXN0LnJlbW92ZShjbHMoJ2FjdGl2ZScpKTtcbiAgICBkb2N1bWVudC5ib2R5LnN0eWxlLm92ZXJmbG93ID0gJyc7XG5cbiAgICAvLyBSZXNldCBzdGF0ZVxuICAgIGlmICh0aGlzLl9pbnB1dCkgdGhpcy5faW5wdXQudmFsdWUgPSAnJztcbiAgICB0aGlzLnNlYXJjaFF1ZXJ5ID0gJyc7XG4gICAgdGhpcy5pc0lTVlNlYXJjaCA9IGZhbHNlO1xuICAgIHRoaXMuZm9jdXNlZEluZGV4ID0gLTE7XG4gICAgdGhpcy5yZXN1bHRzID0gW107XG4gIH1cblxuICAvKipcbiAgICogVG9nZ2xlIHRoZSBzZWFyY2ggb3ZlcmxheVxuICAgKi9cbiAgdG9nZ2xlKCkge1xuICAgIGlmICh0aGlzLmlzT3Blbikge1xuICAgICAgdGhpcy5jbG9zZSgpO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLm9wZW4oKTtcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogUHJvZ3JhbW1hdGljYWxseSBzZWFyY2hcbiAgICogQHBhcmFtIHtzdHJpbmd9IHF1ZXJ5XG4gICAqL1xuICBzZWFyY2gocXVlcnkpIHtcbiAgICBpZiAodGhpcy5faW5wdXQpIHtcbiAgICAgIHRoaXMuX2lucHV0LnZhbHVlID0gcXVlcnk7XG4gICAgfVxuICAgIHRoaXMuc2VhcmNoUXVlcnkgPSBxdWVyeTtcbiAgICB0aGlzLmlzSVNWU2VhcmNoID0gcXVlcnkudG9Mb3dlckNhc2UoKS5zdGFydHNXaXRoKCdpc3Y6Jyk7XG4gICAgdGhpcy5fdXBkYXRlU2VhcmNoTW9kZSgpO1xuICAgIHRoaXMuX3BlcmZvcm1TZWFyY2gocXVlcnkpO1xuICB9XG59XG5cbi8vIEV4cG9ydFxuZXhwb3J0IHsgR2xvYmFsU2VhcmNoQ29udHJvbGxlciB9O1xuZXhwb3J0IGRlZmF1bHQgR2xvYmFsU2VhcmNoQ29udHJvbGxlcjtcbiIsICIvLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gR0xPQkFMIFBBR0UgU0NSSVBUUyAtIEVOVFJZIFBPSU5UXG4vLyBJbXBvcnRzIGFsbCBwYWdlLWxldmVsIG1vZHVsZXNcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbi8vIEltcG9ydCBtb2R1bGVzXG5pbXBvcnQgeyBTaWRlYmFyQ29udHJvbGxlciB9IGZyb20gJy4vanMvX3NpZGViYXIuanMnO1xuaW1wb3J0IHsgTmF2YmFyQ29udHJvbGxlciB9IGZyb20gJy4vanMvX25hdmJhci5qcyc7XG5pbXBvcnQgeyBHbG9iYWxTZWFyY2hDb250cm9sbGVyIH0gZnJvbSAnLi9qcy9fc2VhcmNoLmpzJztcblxuLy8gSW5pdGlhbGl6ZSB3aGVuIERPTSBpcyByZWFkeVxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsICgpID0+IHtcbiAgLy8gSW5pdGlhbGl6ZSBzaWRlYmFyXG4gIGNvbnN0IHNpZGViYXJFbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1zaWRlYmFyJyk7XG4gIGlmIChzaWRlYmFyRWwpIHtcbiAgICB3aW5kb3cuc29TaWRlYmFyID0gbmV3IFNpZGViYXJDb250cm9sbGVyKHNpZGViYXJFbCk7XG4gIH1cblxuICAvLyBJbml0aWFsaXplIG5hdmJhciAoaWYgbmVlZGVkKVxuICBjb25zdCBuYXZiYXJFbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1uYXZiYXInKTtcbiAgaWYgKG5hdmJhckVsKSB7XG4gICAgd2luZG93LnNvTmF2YmFyID0gbmV3IE5hdmJhckNvbnRyb2xsZXIobmF2YmFyRWwpO1xuICB9XG5cbiAgLy8gSW5pdGlhbGl6ZSBzZWFyY2hcbiAgY29uc3Qgc2VhcmNoT3ZlcmxheSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zby1zZWFyY2gtb3ZlcmxheScpO1xuICBpZiAoc2VhcmNoT3ZlcmxheSkge1xuICAgIHdpbmRvdy5nbG9iYWxTZWFyY2hDb250cm9sbGVyID0gbmV3IEdsb2JhbFNlYXJjaENvbnRyb2xsZXIoKTtcbiAgfVxufSk7XG5cbi8vIEV4cG9ydCBmb3IgZXh0ZXJuYWwgdXNlXG5leHBvcnQgeyBTaWRlYmFyQ29udHJvbGxlciwgTmF2YmFyQ29udHJvbGxlciwgR2xvYmFsU2VhcmNoQ29udHJvbGxlciB9O1xuIl0sCiAgIm1hcHBpbmdzIjogIjs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQUFBO0FBTUEsTUFBTSxTQUFVLE9BQU8sV0FBVyxpQkFBZSxZQUFPLGFBQVAsbUJBQWlCLFdBQVc7QUFDN0UsTUFBTSxNQUFNLElBQUksVUFBVSxHQUFHLE1BQU0sSUFBSSxNQUFNLEtBQUssR0FBRyxDQUFDO0FBS3RELE1BQU0scUJBQU4sTUFBTSxtQkFB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
