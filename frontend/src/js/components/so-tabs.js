// ============================================
// SIXORBIT UI - TABS COMPONENT
// Navigation tabs with keyboard support
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOTabs - Tab navigation component
 * Supports multiple variants, keyboard navigation, and ARIA
 */
class SOTabs extends SOComponent {
  static NAME = 'tabs';

  static DEFAULTS = {
    autoActivate: false,  // Activate tab on focus (vs on click/enter)
    animation: true,      // Use fade animation for panes
    keyboard: true,       // Enable keyboard navigation
    closable: false,      // Enable closable tabs
    draggable: false,     // Enable draggable tab reordering
    overflow: 'none',     // Overflow handling: 'scroll', 'dropdown', 'wrap', 'none'
    scrollStep: 150,      // Pixels to scroll per click
    closeConfirm: null,   // Function to confirm close: (tab, pane) => boolean
    onAdd: null,          // Callback when add button clicked
  };

  static EVENTS = {
    SHOW: 'tab:show',
    SHOWN: 'tab:shown',
    HIDE: 'tab:hide',
    HIDDEN: 'tab:hidden',
    CLOSE: 'tab:close',
    CLOSED: 'tab:closed',
    REORDER: 'tab:reorder',
    ADD: 'tab:add',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  /**
   * Initialize the tabs component
   * @private
   */
  _init() {
    // Cache tab elements
    this._tabs = this.$$('.so-tab');
    this._activeTab = null;
    this._activePane = null;
    this._draggedTab = null;

    // Find initial active tab
    this._findActiveTab();

    // Set up ARIA attributes
    this._setupAria();

    // Set up closable tabs (adds close buttons)
    if (this.options.closable || this.element.classList.contains('so-tabs-closable')) {
      this._setupClosable();
    }

    // Set up draggable tabs (adds drag attributes)
    if (this.options.draggable || this.element.classList.contains('so-tabs-draggable')) {
      this._setupDraggable();
    }

    // Set up overflow handling (restructures DOM - must be after closable/draggable)
    if (this.options.overflow !== 'none' && this.options.overflow !== 'wrap') {
      this._setupOverflow();
    }

    // Bind events (after DOM is finalized)
    this._bindEvents();
  }

  /**
   * Find and set the initial active tab
   * @private
   */
  _findActiveTab() {
    // Look for explicitly active tab
    this._activeTab = this.$('.so-tab.so-active') || this.$('.so-tab[aria-selected="true"]');

    // Default to first tab if none active
    if (!this._activeTab && this._tabs.length > 0) {
      this._activeTab = this._tabs[0];
      this._activeTab.classList.add('so-active');
    }

    // Find associated pane
    if (this._activeTab) {
      const target = this._getTabTarget(this._activeTab);
      if (target) {
        this._activePane = document.querySelector(target);
        if (this._activePane) {
          this._activePane.classList.add('so-active');
          if (this.options.animation) {
            this._activePane.classList.add('so-show');
          }
        }
      }
    }
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Click handler for tabs
    this.delegate('click', '.so-tab', this._handleTabClick.bind(this));

    // Keyboard navigation
    if (this.options.keyboard) {
      this.on('keydown', this._handleKeydown.bind(this));
    }

    // Auto-activate on focus
    if (this.options.autoActivate) {
      this.delegate('focus', '.so-tab', this._handleTabFocus.bind(this));
    }

    // Close button handler - use direct listener on element for bubbling
    this.element.addEventListener('click', (e) => {
      const closeBtn = e.target.closest('.so-tab-close');
      if (closeBtn && this.element.contains(closeBtn)) {
        this._handleCloseClick(e, closeBtn);
      }
    });

    // Add button handler
    this.delegate('click', '.so-tab-add', this._handleAddClick.bind(this));
  }

  /**
   * Set up ARIA attributes
   * @private
   */
  _setupAria() {
    // Set role on container if not already set
    if (!this.element.getAttribute('role')) {
      this.element.setAttribute('role', 'tablist');
    }

    // Check for vertical orientation
    if (this.element.classList.contains('so-tabs-vertical')) {
      this.element.setAttribute('aria-orientation', 'vertical');
    }

    // Set up each tab
    this._tabs.forEach((tab, index) => {
      // Generate ID if needed
      if (!tab.id) {
        tab.id = SixOrbit.uniqueId('so-tab');
      }

      // Set role
      if (!tab.getAttribute('role')) {
        tab.setAttribute('role', 'tab');
      }

      // Set aria-selected
      const isActive = tab === this._activeTab;
      tab.setAttribute('aria-selected', isActive ? 'true' : 'false');

      // Set tabindex
      tab.setAttribute('tabindex', isActive ? '0' : '-1');

      // Link to pane
      const target = this._getTabTarget(tab);
      if (target) {
        const pane = document.querySelector(target);
        if (pane) {
          tab.setAttribute('aria-controls', pane.id || target.replace('#', ''));

          // Set up pane ARIA
          if (!pane.getAttribute('role')) {
            pane.setAttribute('role', 'tabpanel');
          }
          pane.setAttribute('aria-labelledby', tab.id);
          if (!pane.hasAttribute('tabindex')) {
            pane.setAttribute('tabindex', '0');
          }
        }
      }
    });
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  /**
   * Handle tab click
   * @param {Event} e - Click event
   * @param {Element} tab - Clicked tab element
   * @private
   */
  _handleTabClick(e, tab) {
    e.preventDefault();

    if (tab.classList.contains('so-disabled') || tab.hasAttribute('disabled')) {
      return;
    }

    this._activateTab(tab);
  }

  /**
   * Handle tab focus (for auto-activate mode)
   * @param {Event} e - Focus event
   * @param {Element} tab - Focused tab element
   * @private
   */
  _handleTabFocus(e, tab) {
    if (tab.classList.contains('so-disabled') || tab.hasAttribute('disabled')) {
      return;
    }

    this._activateTab(tab);
  }

  /**
   * Handle keyboard navigation
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    const isVertical = this.element.classList.contains('so-tabs-vertical');
    const enabledTabs = this._tabs.filter(
      tab => !tab.classList.contains('so-disabled') && !tab.hasAttribute('disabled')
    );

    if (enabledTabs.length === 0) return;

    const currentIndex = enabledTabs.indexOf(document.activeElement);
    let newIndex = currentIndex;

    switch (e.key) {
      case 'ArrowLeft':
        if (!isVertical) {
          e.preventDefault();
          newIndex = currentIndex - 1;
          if (newIndex < 0) newIndex = enabledTabs.length - 1;
        }
        break;

      case 'ArrowRight':
        if (!isVertical) {
          e.preventDefault();
          newIndex = currentIndex + 1;
          if (newIndex >= enabledTabs.length) newIndex = 0;
        }
        break;

      case 'ArrowUp':
        if (isVertical) {
          e.preventDefault();
          newIndex = currentIndex - 1;
          if (newIndex < 0) newIndex = enabledTabs.length - 1;
        }
        break;

      case 'ArrowDown':
        if (isVertical) {
          e.preventDefault();
          newIndex = currentIndex + 1;
          if (newIndex >= enabledTabs.length) newIndex = 0;
        }
        break;

      case 'Home':
        e.preventDefault();
        newIndex = 0;
        break;

      case 'End':
        e.preventDefault();
        newIndex = enabledTabs.length - 1;
        break;

      case 'Enter':
      case ' ':
        e.preventDefault();
        if (currentIndex >= 0) {
          this._activateTab(enabledTabs[currentIndex]);
        }
        return;

      default:
        return;
    }

    // Focus new tab
    if (newIndex !== currentIndex && newIndex >= 0) {
      enabledTabs[newIndex].focus();

      // Auto-activate on keyboard nav if option enabled
      if (this.options.autoActivate) {
        this._activateTab(enabledTabs[newIndex]);
      }
    }
  }

  // ============================================
  // CLOSABLE TABS
  // ============================================

  /**
   * Set up closable tabs
   * @private
   */
  _setupClosable() {
    this.element.classList.add('so-tabs-closable');

    // Add close buttons to tabs that don't have them
    this._tabs.forEach(tab => {
      if (!tab.querySelector('.so-tab-close') && !tab.classList.contains('so-tab-no-close')) {
        tab.classList.add('so-tab-closable');
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'so-tab-close';
        closeBtn.setAttribute('aria-label', 'Close tab');
        closeBtn.innerHTML = '<span class="material-icons">close</span>';
        tab.appendChild(closeBtn);
      }
    });
  }

  /**
   * Handle close button click
   * @param {Event} e - Click event
   * @param {Element} closeBtn - Close button element
   * @private
   */
  _handleCloseClick(e, closeBtn) {
    e.preventDefault();
    e.stopPropagation();

    const tab = closeBtn.closest('.so-tab');
    if (tab) {
      this.closeTab(tab);
    }
  }

  /**
   * Handle add button click
   * @param {Event} e - Click event
   * @param {Element} addBtn - Add button element
   * @private
   */
  _handleAddClick(e, addBtn) {
    e.preventDefault();

    // Emit add event
    const addEvent = this._emitTabEvent(SOTabs.EVENTS.ADD, this.element, {}, true);

    if (addEvent && typeof this.options.onAdd === 'function') {
      this.options.onAdd(this);
    }
  }

  // ============================================
  // DRAGGABLE TABS
  // ============================================

  /**
   * Set up draggable tabs
   * @private
   */
  _setupDraggable() {
    this.element.classList.add('so-tabs-draggable');

    this._tabs.forEach(tab => {
      tab.setAttribute('draggable', 'true');

      tab.addEventListener('dragstart', (e) => this._handleDragStart(e, tab));
      tab.addEventListener('dragend', (e) => this._handleDragEnd(e, tab));
      tab.addEventListener('dragover', (e) => this._handleDragOver(e, tab));
      tab.addEventListener('dragleave', (e) => this._handleDragLeave(e, tab));
      tab.addEventListener('drop', (e) => this._handleDrop(e, tab));
    });
  }

  /**
   * Handle drag start
   * @private
   */
  _handleDragStart(e, tab) {
    this._draggedTab = tab;
    tab.classList.add('so-dragging');

    // Set drag data
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', tab.id || '');

    // Set drag image
    if (e.dataTransfer.setDragImage) {
      const ghost = tab.cloneNode(true);
      ghost.classList.add('so-tab-drag-ghost');
      ghost.style.width = `${tab.offsetWidth}px`;
      document.body.appendChild(ghost);
      e.dataTransfer.setDragImage(ghost, 10, 10);
      setTimeout(() => ghost.remove(), 0);
    }
  }

  /**
   * Handle drag end
   * @private
   */
  _handleDragEnd(e, tab) {
    tab.classList.remove('so-dragging');
    this._tabs.forEach(t => t.classList.remove('so-drag-over'));
    this._draggedTab = null;
  }

  /**
   * Handle drag over
   * @private
   */
  _handleDragOver(e, tab) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';

    if (tab !== this._draggedTab) {
      tab.classList.add('so-drag-over');
    }
  }

  /**
   * Handle drag leave
   * @private
   */
  _handleDragLeave(e, tab) {
    tab.classList.remove('so-drag-over');
  }

  /**
   * Handle drop
   * @private
   */
  _handleDrop(e, tab) {
    e.preventDefault();
    tab.classList.remove('so-drag-over');

    if (this._draggedTab && tab !== this._draggedTab) {
      // Determine position
      const isVertical = this.element.classList.contains('so-tabs-vertical');
      const rect = tab.getBoundingClientRect();
      const midpoint = isVertical
        ? rect.top + rect.height / 2
        : rect.left + rect.width / 2;
      const position = isVertical
        ? e.clientY < midpoint ? 'before' : 'after'
        : e.clientX < midpoint ? 'before' : 'after';

      // Move the tab
      if (position === 'before') {
        tab.parentNode.insertBefore(this._draggedTab, tab);
      } else {
        tab.parentNode.insertBefore(this._draggedTab, tab.nextSibling);
      }

      // Update tabs array
      this._tabs = this.$$('.so-tab');

      // Emit reorder event
      this._emitTabEvent(SOTabs.EVENTS.REORDER, this._draggedTab, {
        oldIndex: this._tabs.indexOf(this._draggedTab),
        newIndex: this._tabs.indexOf(tab),
        tabs: this._tabs,
      }, false);
    }
  }

  // ============================================
  // OVERFLOW HANDLING
  // ============================================

  /**
   * Set up overflow handling
   * @private
   */
  _setupOverflow() {
    if (this.options.overflow === 'scroll') {
      this._setupScrollOverflow();
    } else if (this.options.overflow === 'dropdown') {
      this._setupDropdownOverflow();
    }
  }

  /**
   * Set up scroll-based overflow
   * @private
   */
  _setupScrollOverflow() {
    // Don't apply to vertical tabs or already processed
    if (this.element.classList.contains('so-tabs-vertical') ||
        this.element.classList.contains('so-tabs-overflow')) {
      return;
    }

    // Create container structure
    const container = document.createElement('div');
    container.className = 'so-tabs-overflow-container';

    const wrapper = document.createElement('div');
    wrapper.className = 'so-tabs-scroll-wrapper';

    const inner = document.createElement('div');
    inner.className = 'so-tabs-scroll-inner';

    // Create scroll buttons
    const prevBtn = document.createElement('button');
    prevBtn.type = 'button';
    prevBtn.className = 'so-tabs-scroll-btn so-tabs-scroll-prev';
    prevBtn.innerHTML = '<span class="material-icons">chevron_left</span>';
    prevBtn.setAttribute('aria-label', 'Scroll tabs left');

    const nextBtn = document.createElement('button');
    nextBtn.type = 'button';
    nextBtn.className = 'so-tabs-scroll-btn so-tabs-scroll-next';
    nextBtn.innerHTML = '<span class="material-icons">chevron_right</span>';
    nextBtn.setAttribute('aria-label', 'Scroll tabs right');

    // Move tabs to inner container
    Array.from(this.element.children).forEach(child => {
      inner.appendChild(child);
    });

    // Build structure
    wrapper.appendChild(inner);
    container.appendChild(prevBtn);
    container.appendChild(wrapper);
    container.appendChild(nextBtn);
    this.element.appendChild(container);

    // Add class
    this.element.classList.add('so-tabs-overflow');

    // Store references
    this._scrollInner = inner;
    this._scrollPrev = prevBtn;
    this._scrollNext = nextBtn;
    this._scrollContainer = container;

    // Bind scroll events
    prevBtn.addEventListener('click', () => this._scrollTabs(-this.options.scrollStep));
    nextBtn.addEventListener('click', () => this._scrollTabs(this.options.scrollStep));

    // Update scroll buttons on scroll
    inner.addEventListener('scroll', () => this._updateScrollButtons());

    // Initial check
    this._updateScrollButtons();

    // Watch for resize
    if (typeof ResizeObserver !== 'undefined') {
      this._resizeObserver = new ResizeObserver(() => this._updateScrollButtons());
      this._resizeObserver.observe(this.element);
    }
  }

  /**
   * Scroll tabs by amount
   * @param {number} amount - Pixels to scroll
   * @private
   */
  _scrollTabs(amount) {
    if (this._scrollInner) {
      this._scrollInner.scrollLeft += amount;
    }
  }

  /**
   * Update scroll button states
   * @private
   */
  _updateScrollButtons() {
    if (!this._scrollInner) return;

    const { scrollLeft, scrollWidth, clientWidth } = this._scrollInner;

    // Check if there's any overflow at all
    const hasOverflow = scrollWidth > clientWidth;
    this._scrollContainer.classList.toggle(SixOrbit.cls('has-overflow'), hasOverflow);

    // Only update button states if there's overflow
    if (hasOverflow) {
      const canScrollLeft = scrollLeft > 0;
      const canScrollRight = scrollLeft + clientWidth < scrollWidth - 1;

      this._scrollPrev.disabled = !canScrollLeft;
      this._scrollNext.disabled = !canScrollRight;

      this._scrollContainer.classList.toggle('so-can-scroll-left', canScrollLeft);
      this._scrollContainer.classList.toggle('so-can-scroll-right', canScrollRight);
    }
  }

  /**
   * Set up dropdown-based overflow
   * @private
   */
  _setupDropdownOverflow() {
    // Implementation for dropdown overflow
    // This would hide overflowing tabs and show them in a dropdown menu
    // More complex - can be implemented if needed
  }

  /**
   * Scroll active tab into view
   * @private
   */
  _scrollActiveIntoView() {
    if (this._scrollInner && this._activeTab) {
      const tabRect = this._activeTab.getBoundingClientRect();
      const innerRect = this._scrollInner.getBoundingClientRect();

      if (tabRect.left < innerRect.left) {
        this._scrollInner.scrollLeft -= (innerRect.left - tabRect.left + 20);
      } else if (tabRect.right > innerRect.right) {
        this._scrollInner.scrollLeft += (tabRect.right - innerRect.right + 20);
      }
    }
  }

  // ============================================
  // PRIVATE METHODS
  // ============================================

  /**
   * Get the target selector for a tab
   * @param {Element} tab - Tab element
   * @returns {string|null} Target selector
   * @private
   */
  _getTabTarget(tab) {
    // Check data attribute
    let target = tab.getAttribute('data-so-target') || tab.getAttribute('data-target');

    // Check href for anchor links
    if (!target && tab.tagName === 'A') {
      const href = tab.getAttribute('href');
      if (href && href.startsWith('#') && href.length > 1) {
        target = href;
      }
    }

    return target;
  }

  /**
   * Activate a tab
   * @param {Element} tab - Tab to activate
   * @private
   */
  _activateTab(tab) {
    // Don't do anything if already active
    if (tab === this._activeTab) return;

    const previousTab = this._activeTab;
    const previousPane = this._activePane;
    const target = this._getTabTarget(tab);
    const newPane = target ? document.querySelector(target) : null;

    // Emit hide event on previous tab (cancelable)
    if (previousTab) {
      const hideEvent = this._emitTabEvent(SOTabs.EVENTS.HIDE, previousTab, {
        relatedTarget: tab
      });

      if (!hideEvent) return; // Prevented
    }

    // Emit show event on new tab (cancelable)
    const showEvent = this._emitTabEvent(SOTabs.EVENTS.SHOW, tab, {
      relatedTarget: previousTab
    });

    if (!showEvent) return; // Prevented

    // Deactivate previous tab
    if (previousTab) {
      previousTab.classList.remove('so-active');
      previousTab.setAttribute('aria-selected', 'false');
      previousTab.setAttribute('tabindex', '-1');
    }

    // Deactivate previous pane
    if (previousPane) {
      previousPane.classList.remove('so-active');
      if (this.options.animation) {
        previousPane.classList.remove('so-show');
      }
    }

    // Activate new tab
    tab.classList.add('so-active');
    tab.setAttribute('aria-selected', 'true');
    tab.setAttribute('tabindex', '0');

    // Activate new pane
    if (newPane) {
      newPane.classList.add('so-active');

      if (this.options.animation) {
        // Use requestAnimationFrame for fade animation
        requestAnimationFrame(() => {
          newPane.classList.add('so-show');
        });
      }
    }

    // Update internal state
    this._activeTab = tab;
    this._activePane = newPane;

    // Emit hidden event on previous tab
    if (previousTab) {
      this._emitTabEvent(SOTabs.EVENTS.HIDDEN, previousTab, {
        relatedTarget: tab
      }, false);
    }

    // Emit shown event on new tab
    const emitShown = () => {
      this._emitTabEvent(SOTabs.EVENTS.SHOWN, tab, {
        relatedTarget: previousTab
      }, false);
    };

    if (this.options.animation && newPane) {
      // Wait for transition
      newPane.addEventListener('transitionend', emitShown, { once: true });
    } else {
      emitShown();
    }
  }

  /**
   * Emit a tab event
   * @param {string} eventName - Event name
   * @param {Element} target - Target element
   * @param {Object} detail - Event detail
   * @param {boolean} cancelable - Whether event is cancelable
   * @returns {boolean} Whether event was not prevented
   * @private
   */
  _emitTabEvent(eventName, target, detail = {}, cancelable = true) {
    const event = new CustomEvent(SixOrbit.evt(eventName), {
      detail: { ...detail, component: this },
      bubbles: true,
      cancelable
    });

    return target.dispatchEvent(event);
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Show tab by index
   * @param {number} index - Tab index (0-based)
   * @returns {this} For chaining
   */
  show(index) {
    const tab = this._tabs[index];
    if (tab && !tab.classList.contains('so-disabled') && !tab.hasAttribute('disabled')) {
      this._activateTab(tab);
    }
    return this;
  }

  /**
   * Show tab by target ID
   * @param {string} id - Target pane ID (with or without #)
   * @returns {this} For chaining
   */
  showById(id) {
    const targetId = id.startsWith('#') ? id : `#${id}`;
    const tab = this._tabs.find(t => this._getTabTarget(t) === targetId);
    if (tab && !tab.classList.contains('so-disabled') && !tab.hasAttribute('disabled')) {
      this._activateTab(tab);
    }
    return this;
  }

  /**
   * Move to next tab
   * @returns {this} For chaining
   */
  next() {
    const enabledTabs = this._tabs.filter(
      tab => !tab.classList.contains('so-disabled') && !tab.hasAttribute('disabled')
    );
    const currentIndex = enabledTabs.indexOf(this._activeTab);
    const nextIndex = (currentIndex + 1) % enabledTabs.length;
    this._activateTab(enabledTabs[nextIndex]);
    return this;
  }

  /**
   * Move to previous tab
   * @returns {this} For chaining
   */
  prev() {
    const enabledTabs = this._tabs.filter(
      tab => !tab.classList.contains('so-disabled') && !tab.hasAttribute('disabled')
    );
    const currentIndex = enabledTabs.indexOf(this._activeTab);
    const prevIndex = currentIndex - 1 < 0 ? enabledTabs.length - 1 : currentIndex - 1;
    this._activateTab(enabledTabs[prevIndex]);
    return this;
  }

  /**
   * Get current active tab element
   * @returns {Element|null} Active tab element
   */
  getActiveTab() {
    return this._activeTab;
  }

  /**
   * Get current active tab index
   * @returns {number} Active tab index (-1 if none)
   */
  getActiveIndex() {
    return this._tabs.indexOf(this._activeTab);
  }

  /**
   * Get all tab elements
   * @returns {Element[]} Array of tab elements
   */
  getTabs() {
    return [...this._tabs];
  }

  /**
   * Close a tab
   * @param {Element|number} tab - Tab element or index to close
   * @returns {this} For chaining
   */
  closeTab(tab) {
    // Get tab element from index if number provided
    if (typeof tab === 'number') {
      tab = this._tabs[tab];
    }

    if (!tab || !this._tabs.includes(tab)) {
      return this;
    }

    // Get pane before closing
    const target = this._getTabTarget(tab);
    const pane = target ? document.querySelector(target) : null;

    // Check for confirm callback
    if (typeof this.options.closeConfirm === 'function') {
      const confirmed = this.options.closeConfirm(tab, pane);
      if (confirmed === false) {
        return this;
      }
    }

    // Emit close event (cancelable)
    const closeEvent = this._emitTabEvent(SOTabs.EVENTS.CLOSE, tab, { pane }, true);
    if (!closeEvent) {
      return this;
    }

    const wasActive = tab === this._activeTab;
    const tabIndex = this._tabs.indexOf(tab);

    // Remove tab from DOM
    tab.remove();

    // Remove pane if exists
    if (pane) {
      pane.remove();
    }

    // Update tabs array
    this._tabs = this.$$('.so-tab');

    // If closed tab was active, activate adjacent tab
    if (wasActive && this._tabs.length > 0) {
      const newIndex = Math.min(tabIndex, this._tabs.length - 1);
      this._activateTab(this._tabs[newIndex]);
    } else if (this._tabs.length === 0) {
      this._activeTab = null;
      this._activePane = null;
    }

    // Emit closed event
    this._emitTabEvent(SOTabs.EVENTS.CLOSED, this.element, {
      closedTab: tab,
      closedPane: pane,
      remainingTabs: this._tabs.length
    }, false);

    // Update overflow buttons if needed
    if (this._scrollInner) {
      this._updateScrollButtons();
    }

    return this;
  }

  /**
   * Add a new tab dynamically
   * @param {Object} options - Tab options
   * @param {string} options.label - Tab label text
   * @param {string} options.content - Pane content HTML
   * @param {string} [options.icon] - Material icon name
   * @param {boolean} [options.closable=true] - Whether tab is closable
   * @param {boolean} [options.activate=true] - Whether to activate the new tab
   * @param {number|string} [options.position='end'] - Position: 'start', 'end', or index
   * @returns {Object} Created tab and pane elements
   */
  addTab(options = {}) {
    const {
      label = 'New Tab',
      content = '',
      icon = null,
      closable = this.options.closable,
      activate = true,
      position = 'end'
    } = options;

    // Create tab element
    const tab = document.createElement('button');
    tab.type = 'button';
    tab.className = SixOrbit.cls('tab');

    // Add icon if provided
    let tabHTML = '';
    if (icon) {
      tabHTML += `<span class="material-icons">${icon}</span>`;
    }
    tabHTML += `<span>${label}</span>`;

    // Add close button if closable
    if (closable) {
      tab.classList.add(SixOrbit.cls('tab-closable'));
      tabHTML += `<button type="button" class="${SixOrbit.cls('tab-close')}" aria-label="Close tab">
        <span class="material-icons">close</span>
      </button>`;
    }

    tab.innerHTML = tabHTML;

    // Generate IDs
    const tabId = SixOrbit.uniqueId('so-tab');
    const paneId = SixOrbit.uniqueId('so-pane');

    tab.id = tabId;
    tab.setAttribute('role', 'tab');
    tab.setAttribute('aria-selected', 'false');
    tab.setAttribute('tabindex', '-1');
    tab.setAttribute('data-so-target', `#${paneId}`);
    tab.setAttribute('aria-controls', paneId);

    // Create pane element
    const pane = document.createElement('div');
    pane.id = paneId;
    pane.className = SixOrbit.cls('tab-pane');
    if (this.options.animation) {
      pane.classList.add(SixOrbit.cls('fade'));
    }
    pane.setAttribute('role', 'tabpanel');
    pane.setAttribute('aria-labelledby', tabId);
    pane.setAttribute('tabindex', '0');
    pane.innerHTML = content;

    // Find insertion point for tab
    let insertBeforeTab = null;
    const tabContainer = this._scrollInner || this.element;

    // Find add button if exists (insert before it)
    const addBtn = tabContainer.querySelector(`.${SixOrbit.cls('tab-add')}`);

    if (position === 'start') {
      insertBeforeTab = this._tabs[0] || addBtn;
    } else if (position === 'end') {
      insertBeforeTab = addBtn;
    } else if (typeof position === 'number') {
      insertBeforeTab = this._tabs[position] || addBtn;
    }

    if (insertBeforeTab) {
      tabContainer.insertBefore(tab, insertBeforeTab);
    } else {
      tabContainer.appendChild(tab);
    }

    // Add pane to tab content container
    const tabContent = document.querySelector(`.${SixOrbit.cls('tab-content')}`) ||
                       this._activePane?.parentElement;
    if (tabContent) {
      tabContent.appendChild(pane);
    }

    // Update tabs array
    this._tabs = this.$$('.so-tab');

    // Set up draggable if enabled
    if (this.options.draggable || this.element.classList.contains(SixOrbit.cls('tabs-draggable'))) {
      tab.setAttribute('draggable', 'true');
      tab.addEventListener('dragstart', (e) => this._handleDragStart(e, tab));
      tab.addEventListener('dragend', (e) => this._handleDragEnd(e, tab));
      tab.addEventListener('dragover', (e) => this._handleDragOver(e, tab));
      tab.addEventListener('dragleave', (e) => this._handleDragLeave(e, tab));
      tab.addEventListener('drop', (e) => this._handleDrop(e, tab));
    }

    // Emit add event
    this._emitTabEvent(SOTabs.EVENTS.ADD, tab, { tab, pane }, false);

    // Activate new tab if requested
    if (activate) {
      this._activateTab(tab);
    }

    // Update overflow buttons if needed
    if (this._scrollInner) {
      this._updateScrollButtons();
      // Scroll new tab into view
      setTimeout(() => this._scrollActiveIntoView(), 50);
    }

    return { tab, pane };
  }

  /**
   * Refresh tabs (re-scan for tab elements)
   * @returns {this} For chaining
   */
  refresh() {
    this._tabs = this.$$('.so-tab');
    this._setupAria();

    // Re-setup closable if enabled
    if (this.options.closable || this.element.classList.contains(SixOrbit.cls('tabs-closable'))) {
      this._setupClosable();
    }

    // Re-setup draggable if enabled
    if (this.options.draggable || this.element.classList.contains(SixOrbit.cls('tabs-draggable'))) {
      this._setupDraggable();
    }

    // Update overflow buttons if present
    if (this._scrollInner) {
      this._updateScrollButtons();
    }

    return this;
  }

  /**
   * Destroy the component and clean up
   */
  destroy() {
    // Clean up resize observer
    if (this._resizeObserver) {
      this._resizeObserver.disconnect();
      this._resizeObserver = null;
    }

    // Call parent destroy
    super.destroy();
  }
}

// Register component
SOTabs.register();

// Auto-initialize tabs with data attribute
document.addEventListener('DOMContentLoaded', () => {
  SOTabs.initAll('[data-so-tabs]');
});

// Expose to global scope
window.SOTabs = SOTabs;

// Export for ES modules
export default SOTabs;
export { SOTabs };
