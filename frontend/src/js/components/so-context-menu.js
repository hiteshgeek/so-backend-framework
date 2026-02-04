// ============================================
// SIXORBIT UI - CONTEXT MENU COMPONENT
// Right-click contextual menu with submenus
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOContextMenu - Context menu component
 * Supports headers, dividers, submenus (2 levels), and full JavaScript API
 */
class SOContextMenu extends SOComponent {
  static NAME = 'contextMenu';

  static DEFAULTS = {
    items: [],                    // Menu items configuration
    trigger: 'contextmenu',       // 'contextmenu' or 'click'
    disabled: false,              // Disable entire menu
    closeOnSelect: true,          // Close menu when item selected
    closeOnOutsideClick: true,    // Close on click outside
    submenuDelay: 200,            // Delay before opening submenu (ms)
    animated: false,              // Use animation keyframes
  };

  static EVENTS = {
    SHOW: 'contextmenu:show',
    SHOWN: 'contextmenu:shown',
    HIDE: 'contextmenu:hide',
    HIDDEN: 'contextmenu:hidden',
    SELECT: 'contextmenu:select',
    SUBMENU_SHOW: 'contextmenu:submenu:show',
    SUBMENU_HIDE: 'contextmenu:submenu:hide',
  };

  /**
   * Initialize the context menu
   * @private
   */
  _init() {
    // State
    this._isOpen = false;
    this._disabled = this.options.disabled;
    this._target = null;           // Element menu is attached to
    this._menuElement = null;      // The menu DOM element
    this._items = [];              // Internal items store
    this._groups = new Map();      // Group ID -> item IDs mapping
    this._focusedIndex = -1;
    this._activeSubmenu = null;
    this._submenuTimeout = null;

    // Check if element is the menu itself or a trigger
    if (this.element.classList.contains('so-context-menu')) {
      // Element is the menu - find trigger via data attribute
      this._menuElement = this.element;
      const triggerId = this.element.id;
      if (triggerId) {
        this._target = document.querySelector(`[data-so-context-menu="#${triggerId}"]`);
      }
    } else {
      // Element is a trigger - find or create menu
      this._target = this.element;
      const menuSelector = this.element.getAttribute('data-so-context-menu');
      if (menuSelector) {
        this._menuElement = document.querySelector(menuSelector);
      }
    }

    // Build items from options or parse from DOM
    if (this.options.items && this.options.items.length > 0) {
      this._buildFromConfig(this.options.items);
    } else if (this._menuElement) {
      this._parseFromDOM();
    }

    // Bind events
    this._bindEvents();
  }

  /**
   * Build menu from configuration array
   * @param {Array} items - Items configuration
   * @private
   */
  _buildFromConfig(items) {
    if (!this._menuElement) {
      // Create menu element
      this._menuElement = document.createElement('div');
      this._menuElement.className = 'so-context-menu';
      if (this.options.animated) {
        this._menuElement.classList.add('so-context-menu-animated');
      }
      document.body.appendChild(this._menuElement);
    }

    this._items = [];
    this._menuElement.innerHTML = '';
    this._renderItems(items, this._menuElement);
  }

  /**
   * Render items to container
   * @param {Array} items - Items to render
   * @param {Element} container - Container element
   * @param {number} [level=0] - Nesting level
   * @private
   */
  _renderItems(items, container, level = 0) {
    items.forEach((item, index) => {
      const itemEl = this._createItemElement(item, level);
      container.appendChild(itemEl);

      // Store item reference
      const itemData = {
        ...item,
        id: item.id || `item-${level}-${index}`,
        element: itemEl,
        level,
      };
      this._items.push(itemData);

      // Track groups
      if (item.groupId) {
        if (!this._groups.has(item.groupId)) {
          this._groups.set(item.groupId, []);
        }
        this._groups.get(item.groupId).push(itemData.id);
      }
    });
  }

  /**
   * Create a single item element
   * @param {Object} item - Item configuration
   * @param {number} level - Nesting level
   * @returns {Element} Created element
   * @private
   */
  _createItemElement(item, level) {
    // Header
    if (item.type === 'header') {
      const header = document.createElement('div');
      header.className = 'so-context-menu-header';
      header.textContent = item.label || item.text || '';
      header.dataset.id = item.id || '';
      return header;
    }

    // Divider
    if (item.type === 'divider') {
      const divider = document.createElement('div');
      divider.className = 'so-context-menu-divider';
      return divider;
    }

    // Group wrapper
    if (item.type === 'group') {
      const group = document.createElement('div');
      group.className = 'so-context-menu-group';
      group.dataset.groupId = item.groupId || item.id || '';
      if (item.disabled) group.classList.add('so-disabled');

      // Render group items
      if (item.items && item.items.length > 0) {
        this._renderItems(item.items.map(i => ({ ...i, groupId: item.groupId || item.id })), group, level);
      }
      return group;
    }

    // Regular item
    const itemEl = document.createElement('div');
    itemEl.className = 'so-context-menu-item';
    if (item.id) itemEl.dataset.id = item.id;
    if (item.disabled) itemEl.classList.add('so-disabled');
    if (item.danger) itemEl.classList.add(SixOrbit.cls('danger'));
    if (item.checked) itemEl.classList.add(SixOrbit.cls('checked'));
    if (item.data) itemEl.dataset.data = JSON.stringify(item.data);

    // Has submenu?
    const hasSubmenu = item.items && item.items.length > 0 && level < 2;
    if (hasSubmenu) itemEl.classList.add('so-has-submenu');

    // Build inner HTML
    let html = '';

    // Checkmark for checkable items
    if (item.checkable) {
      html += `<span class="so-context-menu-item-check"><span class="material-icons">check</span></span>`;
    }

    // Icon
    if (item.icon) {
      html += `<span class="so-context-menu-item-icon"><span class="material-icons">${item.icon}</span></span>`;
    }

    // Text/Label with optional description
    if (item.description) {
      html += `<span class="so-context-menu-item-content">
        <span class="so-context-menu-item-text">${item.label || item.text || ''}</span>
        <span class="so-context-menu-item-description">${item.description}</span>
      </span>`;
    } else {
      html += `<span class="so-context-menu-item-text">${item.label || item.text || ''}</span>`;
    }

    // Keyboard shortcut
    if (item.shortcut) {
      html += `<span class="so-context-menu-item-shortcut">${item.shortcut}</span>`;
    }

    // Submenu arrow
    if (hasSubmenu) {
      html += `<span class="so-context-menu-item-arrow"><span class="material-icons">chevron_right</span></span>`;
    }

    itemEl.innerHTML = html;

    // Create submenu
    if (hasSubmenu) {
      const submenu = document.createElement('div');
      submenu.className = 'so-context-menu-submenu';
      this._renderItems(item.items, submenu, level + 1);
      itemEl.appendChild(submenu);
    }

    return itemEl;
  }

  /**
   * Parse items from existing DOM
   * @private
   */
  _parseFromDOM() {
    if (!this._menuElement) return;

    this._items = [];
    const children = this._menuElement.children;

    for (let i = 0; i < children.length; i++) {
      const el = children[i];
      const item = this._parseItemElement(el, 0, i);
      if (item) this._items.push(item);
    }
  }

  /**
   * Parse a single item element
   * @param {Element} el - Item element
   * @param {number} level - Nesting level
   * @param {number} index - Item index
   * @returns {Object|null} Parsed item data
   * @private
   */
  _parseItemElement(el, level, index) {
    if (el.classList.contains('so-context-menu-header')) {
      return {
        id: el.dataset.id || `header-${level}-${index}`,
        type: 'header',
        label: el.textContent.trim(),
        element: el,
        level,
      };
    }

    if (el.classList.contains('so-context-menu-divider')) {
      return {
        id: `divider-${level}-${index}`,
        type: 'divider',
        element: el,
        level,
      };
    }

    if (el.classList.contains('so-context-menu-group')) {
      const groupId = el.dataset.groupId || `group-${index}`;
      const groupItems = [];

      for (let i = 0; i < el.children.length; i++) {
        const childItem = this._parseItemElement(el.children[i], level, i);
        if (childItem) {
          childItem.groupId = groupId;
          groupItems.push(childItem);
          this._items.push(childItem);
        }
      }

      this._groups.set(groupId, groupItems.map(i => i.id));

      return null; // Group itself is not stored as item
    }

    if (el.classList.contains('so-context-menu-item')) {
      const textEl = el.querySelector('.so-context-menu-item-text');
      const iconEl = el.querySelector('.so-context-menu-item-icon .material-icons');
      const shortcutEl = el.querySelector('.so-context-menu-item-shortcut');
      const submenuEl = el.querySelector('.so-context-menu-submenu');

      const item = {
        id: el.dataset.id || `item-${level}-${index}`,
        type: 'item',
        label: textEl ? textEl.textContent.trim() : el.textContent.trim(),
        icon: iconEl ? iconEl.textContent.trim() : null,
        shortcut: shortcutEl ? shortcutEl.textContent.trim() : null,
        disabled: el.classList.contains('so-disabled'),
        danger: el.classList.contains(SixOrbit.cls('danger')),
        checked: el.classList.contains(SixOrbit.cls('checked')),
        data: el.dataset.data ? JSON.parse(el.dataset.data) : {},
        element: el,
        level,
        items: [],
      };

      // Parse submenu items
      if (submenuEl && level < 2) {
        for (let i = 0; i < submenuEl.children.length; i++) {
          const subItem = this._parseItemElement(submenuEl.children[i], level + 1, i);
          if (subItem) item.items.push(subItem);
        }
      }

      return item;
    }

    return null;
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Trigger event
    if (this._target) {
      const triggerEvent = this.options.trigger === 'click' ? 'click' : 'contextmenu';
      this.on(triggerEvent, this._handleTrigger, this._target);
    }

    // Menu item clicks
    if (this._menuElement) {
      this.on('click', this._handleItemClick, this._menuElement);
      this.on('mouseenter', this._handleItemHover, this._menuElement, { capture: true });
      this.on('mouseleave', this._handleItemLeave, this._menuElement, { capture: true });
    }

    // Close on outside click
    if (this.options.closeOnOutsideClick) {
      this.on('click', this._handleOutsideClick, document);
      this.on('contextmenu', this._handleOutsideContextMenu, document);
    }

    // Keyboard navigation
    this.on('keydown', this._handleKeydown, document);

    // Close on scroll
    this.on('scroll', () => {
      if (this._isOpen) this.close();
    }, window, { passive: true });

    // Close on resize
    this.on('resize', () => {
      if (this._isOpen) this.close();
    }, window, { passive: true });
  }

  /**
   * Handle trigger event (contextmenu or click)
   * @param {Event} e - Event object
   * @private
   */
  _handleTrigger(e) {
    e.preventDefault();
    e.stopPropagation();

    if (this._disabled) return;

    const x = e.clientX || e.pageX;
    const y = e.clientY || e.pageY;

    this.open(x, y, e);
  }

  /**
   * Handle item click
   * @param {Event} e - Click event
   * @private
   */
  _handleItemClick(e) {
    const itemEl = e.target.closest('.so-context-menu-item');
    if (!itemEl) return;

    // Check if disabled
    if (itemEl.classList.contains('so-disabled')) {
      e.stopPropagation();
      return;
    }

    // Check if has submenu (don't select, let hover handle it)
    if (itemEl.classList.contains('so-has-submenu')) {
      e.stopPropagation();
      return;
    }

    e.stopPropagation();

    // Find item data
    const itemId = itemEl.dataset.id;
    const item = this._items.find(i => i.id === itemId) || {
      id: itemId,
      label: itemEl.querySelector('.so-context-menu-item-text')?.textContent.trim(),
      data: itemEl.dataset.data ? JSON.parse(itemEl.dataset.data) : {},
      element: itemEl,
    };

    // Handle checkable items
    if (itemEl.classList.contains(SixOrbit.cls('checked')) || item.checkable) {
      itemEl.classList.toggle(SixOrbit.cls('checked'));
      item.checked = itemEl.classList.contains(SixOrbit.cls('checked'));
    }

    // Emit select event
    this.emit(SOContextMenu.EVENTS.SELECT, {
      item,
      id: item.id,
      label: item.label,
      data: item.data,
      checked: item.checked,
    });

    // Close menu
    if (this.options.closeOnSelect) {
      this.close();
    }
  }

  /**
   * Handle item hover for submenus
   * @param {Event} e - Mouse event
   * @private
   */
  _handleItemHover(e) {
    const itemEl = e.target.closest('.so-context-menu-item');
    if (!itemEl) return;

    // Clear any pending submenu timeout
    if (this._submenuTimeout) {
      clearTimeout(this._submenuTimeout);
      this._submenuTimeout = null;
    }

    // Close other submenus at this level
    const parent = itemEl.parentElement;
    const siblings = parent.querySelectorAll(':scope > .so-context-menu-item.submenu-open');
    siblings.forEach(sib => {
      if (sib !== itemEl) {
        sib.classList.remove('submenu-open');
        const submenu = sib.querySelector('.so-context-menu-submenu');
        if (submenu) submenu.classList.remove('so-open');
      }
    });

    // Check if has submenu
    if (!itemEl.classList.contains('so-has-submenu')) return;

    // Open submenu with delay
    this._submenuTimeout = setTimeout(() => {
      this._openSubmenu(itemEl);
    }, this.options.submenuDelay);
  }

  /**
   * Handle item leave
   * @param {Event} e - Mouse event
   * @private
   */
  _handleItemLeave(e) {
    // Clear submenu timeout
    if (this._submenuTimeout) {
      clearTimeout(this._submenuTimeout);
      this._submenuTimeout = null;
    }
  }

  /**
   * Open a submenu
   * @param {Element} parentItem - Parent item element
   * @private
   */
  _openSubmenu(parentItem) {
    const submenu = parentItem.querySelector('.so-context-menu-submenu');
    if (!submenu) return;

    // Mark parent as open
    parentItem.classList.add('submenu-open');

    // Position submenu
    this._positionSubmenu(parentItem, submenu);

    // Show submenu
    submenu.classList.add('so-open');

    // Emit event
    const itemId = parentItem.dataset.id;
    const item = this._items.find(i => i.id === itemId);
    this.emit(SOContextMenu.EVENTS.SUBMENU_SHOW, {
      parentItem: item,
      items: item?.items || [],
    });

    this._activeSubmenu = submenu;
  }

  /**
   * Position submenu relative to parent
   * @param {Element} parentItem - Parent item element
   * @param {Element} submenu - Submenu element
   * @private
   */
  _positionSubmenu(parentItem, submenu) {
    // Reset position classes
    submenu.classList.remove('so-flip-x');

    const parentRect = parentItem.getBoundingClientRect();
    const submenuWidth = submenu.offsetWidth || 160;
    const viewportWidth = window.innerWidth;

    // Check if submenu would overflow right edge
    if (parentRect.right + submenuWidth > viewportWidth - 10) {
      submenu.classList.add('so-flip-x');
    }

    // Vertical position - align top with parent
    const submenuHeight = submenu.offsetHeight || 100;
    const viewportHeight = window.innerHeight;

    if (parentRect.top + submenuHeight > viewportHeight - 10) {
      // Shift up
      const offset = Math.min(
        parentRect.top + submenuHeight - viewportHeight + 10,
        parentRect.top - 10
      );
      submenu.style.top = `-${offset}px`;
    } else {
      submenu.style.top = '0';
    }
  }

  /**
   * Handle outside click
   * @param {Event} e - Click event
   * @private
   */
  _handleOutsideClick(e) {
    if (!this._isOpen) return;

    // Check if click is inside menu
    if (this._menuElement && this._menuElement.contains(e.target)) return;

    this.close();
  }

  /**
   * Handle outside context menu
   * @param {Event} e - Context menu event
   * @private
   */
  _handleOutsideContextMenu(e) {
    if (!this._isOpen) return;

    // If it's on our target, let _handleTrigger handle it
    if (this._target && this._target.contains(e.target)) return;

    // If it's inside the menu, don't close
    if (this._menuElement && this._menuElement.contains(e.target)) {
      e.preventDefault();
      return;
    }

    this.close();
  }

  /**
   * Handle keyboard navigation
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    if (!this._isOpen) return;

    switch (e.key) {
      case 'Escape':
        e.preventDefault();
        this.close();
        break;

      case 'ArrowDown':
        e.preventDefault();
        this._focusNextItem(1);
        break;

      case 'ArrowUp':
        e.preventDefault();
        this._focusNextItem(-1);
        break;

      case 'ArrowRight':
        e.preventDefault();
        this._openFocusedSubmenu();
        break;

      case 'ArrowLeft':
        e.preventDefault();
        this._closeActiveSubmenu();
        break;

      case 'Enter':
      case ' ':
        e.preventDefault();
        this._selectFocusedItem();
        break;

      case 'Home':
        e.preventDefault();
        this._focusItem(0);
        break;

      case 'End':
        e.preventDefault();
        this._focusItem(this._getNavigableItems().length - 1);
        break;
    }
  }

  /**
   * Get navigable items (excluding headers, dividers, disabled)
   * @param {Element} [container] - Container to search in
   * @returns {Element[]} Array of navigable items
   * @private
   */
  _getNavigableItems(container) {
    const cont = container || this._menuElement;
    return Array.from(cont.querySelectorAll(':scope > .so-context-menu-item:not(.disabled)'));
  }

  /**
   * Focus next/previous item
   * @param {number} direction - 1 for next, -1 for previous
   * @private
   */
  _focusNextItem(direction) {
    const items = this._getNavigableItems();
    if (items.length === 0) return;

    let newIndex = this._focusedIndex + direction;

    // Wrap around
    if (newIndex < 0) newIndex = items.length - 1;
    if (newIndex >= items.length) newIndex = 0;

    this._focusItem(newIndex);
  }

  /**
   * Focus item by index
   * @param {number} index - Item index
   * @private
   */
  _focusItem(index) {
    const items = this._getNavigableItems();

    // Remove focus from all
    items.forEach(item => item.classList.remove('so-focused'));

    this._focusedIndex = index;
    if (items[index]) {
      items[index].classList.add('so-focused');
      items[index].scrollIntoView({ block: 'nearest' });
    }
  }

  /**
   * Open submenu of focused item
   * @private
   */
  _openFocusedSubmenu() {
    const items = this._getNavigableItems();
    if (this._focusedIndex < 0 || !items[this._focusedIndex]) return;

    const item = items[this._focusedIndex];
    if (item.classList.contains('so-has-submenu')) {
      this._openSubmenu(item);
      // Focus first item in submenu
      const submenu = item.querySelector('.so-context-menu-submenu');
      if (submenu) {
        const subItems = this._getNavigableItems(submenu);
        if (subItems[0]) subItems[0].classList.add('so-focused');
      }
    }
  }

  /**
   * Close active submenu
   * @private
   */
  _closeActiveSubmenu() {
    if (!this._activeSubmenu) return;

    const parentItem = this._activeSubmenu.closest('.so-context-menu-item');
    if (parentItem) {
      parentItem.classList.remove('submenu-open');
      this._activeSubmenu.classList.remove('so-open');

      // Emit event
      const itemId = parentItem.dataset.id;
      const item = this._items.find(i => i.id === itemId);
      this.emit(SOContextMenu.EVENTS.SUBMENU_HIDE, { parentItem: item });
    }

    this._activeSubmenu = null;
  }

  /**
   * Select the focused item
   * @private
   */
  _selectFocusedItem() {
    const items = this._getNavigableItems();
    if (this._focusedIndex < 0 || !items[this._focusedIndex]) return;

    const item = items[this._focusedIndex];

    // If has submenu, open it
    if (item.classList.contains('so-has-submenu')) {
      this._openFocusedSubmenu();
      return;
    }

    // Trigger click
    item.click();
  }

  // ============================================
  // PUBLIC API - MENU CONTROL
  // ============================================

  /**
   * Open the context menu at coordinates
   * @param {number} x - X coordinate
   * @param {number} y - Y coordinate
   * @param {Event} [originalEvent] - Original event that triggered open
   * @returns {this} For chaining
   */
  open(x, y, originalEvent = null) {
    if (this._isOpen || this._disabled || !this._menuElement) return this;

    // Emit cancelable show event
    const showAllowed = this.emit(SOContextMenu.EVENTS.SHOW, {
      x,
      y,
      originalEvent,
    }, true, true);

    if (!showAllowed) return this;

    this._isOpen = true;

    // Position menu
    this._positionMenu(x, y);

    // Show menu
    this._menuElement.classList.add('so-open');

    // Reset focus
    this._focusedIndex = -1;

    // Emit shown event after transition
    setTimeout(() => {
      this.emit(SOContextMenu.EVENTS.SHOWN, { x, y });
    }, 150);

    return this;
  }

  /**
   * Position the menu at coordinates
   * @param {number} x - X coordinate
   * @param {number} y - Y coordinate
   * @private
   */
  _positionMenu(x, y) {
    const menu = this._menuElement;

    // Reset position classes
    menu.classList.remove('so-flip-x', 'so-flip-y');

    // Temporarily show to get dimensions
    menu.style.visibility = 'hidden';
    menu.style.display = 'block';
    menu.style.opacity = '0';

    const menuWidth = menu.offsetWidth;
    const menuHeight = menu.offsetHeight;

    menu.style.visibility = '';
    menu.style.display = '';
    menu.style.opacity = '';

    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    let finalX = x;
    let finalY = y;

    // Check right edge
    if (x + menuWidth > viewportWidth - 10) {
      finalX = x - menuWidth;
      menu.classList.add('so-flip-x');
    }

    // Check bottom edge
    if (y + menuHeight > viewportHeight - 10) {
      finalY = y - menuHeight;
      menu.classList.add('so-flip-y');
    }

    // Ensure minimum bounds
    finalX = Math.max(10, finalX);
    finalY = Math.max(10, finalY);

    menu.style.left = `${finalX}px`;
    menu.style.top = `${finalY}px`;
  }

  /**
   * Close the context menu
   * @returns {this} For chaining
   */
  close() {
    if (!this._isOpen || !this._menuElement) return this;

    // Emit cancelable hide event
    const hideAllowed = this.emit(SOContextMenu.EVENTS.HIDE, {}, true, true);
    if (!hideAllowed) return this;

    this._isOpen = false;

    // Close all submenus
    this._closeAllSubmenus();

    // Clear focus
    const focused = this._menuElement.querySelector('.so-context-menu-item.so-focused');
    if (focused) focused.classList.remove('so-focused');
    this._focusedIndex = -1;

    // Hide menu
    if (this.options.animated) {
      this._menuElement.classList.add('so-closing');
      setTimeout(() => {
        this._menuElement.classList.remove('so-open', 'so-closing');
        this.emit(SOContextMenu.EVENTS.HIDDEN);
      }, 150);
    } else {
      this._menuElement.classList.remove('so-open');
      setTimeout(() => {
        this.emit(SOContextMenu.EVENTS.HIDDEN);
      }, 150);
    }

    return this;
  }

  /**
   * Close all submenus
   * @private
   */
  _closeAllSubmenus() {
    if (!this._menuElement) return;

    const openSubmenus = this._menuElement.querySelectorAll('.so-context-menu-submenu.so-open');
    openSubmenus.forEach(submenu => submenu.classList.remove('so-open'));

    const openParents = this._menuElement.querySelectorAll('.so-context-menu-item.submenu-open');
    openParents.forEach(parent => parent.classList.remove('submenu-open'));

    this._activeSubmenu = null;
  }

  /**
   * Toggle the context menu
   * @param {number} x - X coordinate
   * @param {number} y - Y coordinate
   * @returns {this} For chaining
   */
  toggle(x, y) {
    return this._isOpen ? this.close() : this.open(x, y);
  }

  /**
   * Check if menu is open
   * @returns {boolean} Open state
   */
  isOpen() {
    return this._isOpen;
  }

  /**
   * Enable the entire menu
   * @returns {this} For chaining
   */
  enable() {
    this._disabled = false;
    return this;
  }

  /**
   * Disable the entire menu
   * @returns {this} For chaining
   */
  disable() {
    this._disabled = true;
    if (this._isOpen) this.close();
    return this;
  }

  /**
   * Check if menu is disabled
   * @returns {boolean} Disabled state
   */
  isDisabled() {
    return this._disabled;
  }

  // ============================================
  // PUBLIC API - ITEM MANAGEMENT
  // ============================================

  /**
   * Add an item to the menu
   * @param {Object} item - Item configuration
   * @param {number|string|Object} [position='bottom'] - Position: index, 'top', 'bottom', {before:'id'}, {after:'id'}, {group:'id',position:'top'|'bottom'}
   * @returns {this} For chaining
   */
  add(item, position = 'bottom') {
    if (!this._menuElement) return this;

    const itemEl = this._createItemElement(item, 0);

    // Determine insert position
    let referenceNode = null;
    let insertBefore = true;

    if (typeof position === 'number') {
      // Insert at index
      const children = Array.from(this._menuElement.children);
      referenceNode = children[position] || null;
    } else if (position === 'top') {
      referenceNode = this._menuElement.firstChild;
    } else if (position === 'bottom') {
      referenceNode = null;
      insertBefore = false;
    } else if (typeof position === 'object') {
      if (position.before) {
        referenceNode = this._menuElement.querySelector(`[data-id="${position.before}"]`);
      } else if (position.after) {
        const afterEl = this._menuElement.querySelector(`[data-id="${position.after}"]`);
        referenceNode = afterEl?.nextSibling || null;
      } else if (position.group) {
        const groupEl = this._menuElement.querySelector(`[data-group-id="${position.group}"]`);
        if (groupEl) {
          if (position.position === 'top') {
            referenceNode = groupEl.firstChild;
            insertBefore = true;
          } else {
            referenceNode = null;
            insertBefore = false;
          }
          // Insert into group
          if (insertBefore && referenceNode) {
            groupEl.insertBefore(itemEl, referenceNode);
          } else {
            groupEl.appendChild(itemEl);
          }
          this._storeItem(item, itemEl, 0);
          return this;
        }
      }
    }

    // Insert into main menu
    if (insertBefore && referenceNode) {
      this._menuElement.insertBefore(itemEl, referenceNode);
    } else {
      this._menuElement.appendChild(itemEl);
    }

    this._storeItem(item, itemEl, 0);
    return this;
  }

  /**
   * Store item data
   * @param {Object} item - Item config
   * @param {Element} itemEl - Item element
   * @param {number} level - Nesting level
   * @private
   */
  _storeItem(item, itemEl, level) {
    const itemData = {
      ...item,
      id: item.id || `item-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`,
      element: itemEl,
      level,
    };
    itemEl.dataset.id = itemData.id;
    this._items.push(itemData);

    if (item.groupId) {
      if (!this._groups.has(item.groupId)) {
        this._groups.set(item.groupId, []);
      }
      this._groups.get(item.groupId).push(itemData.id);
    }
  }

  /**
   * Add a group of items
   * @param {string} groupId - Group identifier
   * @param {Array} items - Items to add
   * @param {string|number} [position='bottom'] - Position in menu
   * @returns {this} For chaining
   */
  addGroup(groupId, items, position = 'bottom') {
    const groupConfig = {
      type: 'group',
      id: groupId,
      groupId: groupId,
      items: items,
    };
    return this.add(groupConfig, position);
  }

  /**
   * Add a separator/divider
   * @param {number|string|Object} [position='bottom'] - Position
   * @returns {this} For chaining
   */
  addSeparator(position = 'bottom') {
    return this.add({ type: 'divider' }, position);
  }

  /**
   * Add a header
   * @param {string} text - Header text
   * @param {number|string|Object} [position='bottom'] - Position
   * @returns {this} For chaining
   */
  addHeader(text, position = 'bottom') {
    return this.add({ type: 'header', label: text }, position);
  }

  /**
   * Remove an item by id or index
   * @param {string|number} identifier - Item id or index
   * @returns {this} For chaining
   */
  remove(identifier) {
    let item;

    if (typeof identifier === 'number') {
      item = this._items[identifier];
    } else {
      item = this._items.find(i => i.id === identifier);
    }

    if (item && item.element) {
      item.element.remove();
      this._items = this._items.filter(i => i !== item);

      // Remove from group tracking
      if (item.groupId && this._groups.has(item.groupId)) {
        const groupItems = this._groups.get(item.groupId);
        this._groups.set(item.groupId, groupItems.filter(id => id !== item.id));
      }
    }

    return this;
  }

  /**
   * Remove all items
   * @returns {this} For chaining
   */
  removeAll() {
    if (this._menuElement) {
      this._menuElement.innerHTML = '';
    }
    this._items = [];
    this._groups.clear();
    return this;
  }

  /**
   * Get an item by id or index
   * @param {string|number} identifier - Item id or index
   * @returns {Object|null} Item data
   */
  getItem(identifier) {
    if (typeof identifier === 'number') {
      return this._items[identifier] || null;
    }
    return this._items.find(i => i.id === identifier) || null;
  }

  /**
   * Get all items
   * @returns {Array} All items
   */
  getItems() {
    return [...this._items];
  }

  /**
   * Update an item's properties
   * @param {string|number} identifier - Item id or index
   * @param {Object} updates - Properties to update
   * @returns {this} For chaining
   */
  updateItem(identifier, updates) {
    const item = this.getItem(identifier);
    if (!item || !item.element) return this;

    // Update data
    Object.assign(item, updates);

    // Update DOM
    const el = item.element;

    if (updates.label !== undefined) {
      const textEl = el.querySelector('.so-context-menu-item-text');
      if (textEl) textEl.textContent = updates.label;
    }

    if (updates.icon !== undefined) {
      let iconEl = el.querySelector('.so-context-menu-item-icon .material-icons');
      if (iconEl) {
        iconEl.textContent = updates.icon;
      } else if (updates.icon) {
        const iconWrapper = document.createElement('span');
        iconWrapper.className = 'so-context-menu-item-icon';
        iconWrapper.innerHTML = `<span class="material-icons">${updates.icon}</span>`;
        el.insertBefore(iconWrapper, el.firstChild);
      }
    }

    if (updates.disabled !== undefined) {
      el.classList.toggle('so-disabled', updates.disabled);
    }

    if (updates.danger !== undefined) {
      el.classList.toggle(SixOrbit.cls('danger'), updates.danger);
    }

    if (updates.checked !== undefined) {
      el.classList.toggle(SixOrbit.cls('checked'), updates.checked);
    }

    if (updates.shortcut !== undefined) {
      let shortcutEl = el.querySelector('.so-context-menu-item-shortcut');
      if (shortcutEl) {
        shortcutEl.textContent = updates.shortcut;
      } else if (updates.shortcut) {
        const arrow = el.querySelector('.so-context-menu-item-arrow');
        const shortcutSpan = document.createElement('span');
        shortcutSpan.className = 'so-context-menu-item-shortcut';
        shortcutSpan.textContent = updates.shortcut;
        if (arrow) {
          el.insertBefore(shortcutSpan, arrow);
        } else {
          el.appendChild(shortcutSpan);
        }
      }
    }

    return this;
  }

  // ============================================
  // PUBLIC API - ITEM STATE
  // ============================================

  /**
   * Enable a specific item
   * @param {string|number} identifier - Item id or index
   * @returns {this} For chaining
   */
  enableItem(identifier) {
    return this.updateItem(identifier, { disabled: false });
  }

  /**
   * Disable a specific item
   * @param {string|number} identifier - Item id or index
   * @returns {this} For chaining
   */
  disableItem(identifier) {
    return this.updateItem(identifier, { disabled: true });
  }

  /**
   * Enable all items in a group
   * @param {string} groupId - Group identifier
   * @returns {this} For chaining
   */
  enableGroup(groupId) {
    // Enable via DOM class
    const groupEl = this._menuElement?.querySelector(`[data-group-id="${groupId}"]`);
    if (groupEl) {
      groupEl.classList.remove('so-disabled');
    }

    // Enable individual items
    const itemIds = this._groups.get(groupId) || [];
    itemIds.forEach(id => this.enableItem(id));

    return this;
  }

  /**
   * Disable all items in a group
   * @param {string} groupId - Group identifier
   * @returns {this} For chaining
   */
  disableGroup(groupId) {
    // Disable via DOM class
    const groupEl = this._menuElement?.querySelector(`[data-group-id="${groupId}"]`);
    if (groupEl) {
      groupEl.classList.add('so-disabled');
    }

    // Disable individual items
    const itemIds = this._groups.get(groupId) || [];
    itemIds.forEach(id => this.disableItem(id));

    return this;
  }

  // ============================================
  // PUBLIC API - ATTACHMENT
  // ============================================

  /**
   * Attach menu to a trigger element
   * @param {Element|string} element - Element or selector
   * @returns {this} For chaining
   */
  attach(element) {
    // Detach from current
    this.detach();

    // Resolve element
    const el = typeof element === 'string' ? document.querySelector(element) : element;
    if (!el) return this;

    this._target = el;

    // Bind trigger event
    const triggerEvent = this.options.trigger === 'click' ? 'click' : 'contextmenu';
    this.on(triggerEvent, this._handleTrigger, this._target);

    return this;
  }

  /**
   * Detach menu from current trigger element
   * @returns {this} For chaining
   */
  detach() {
    if (!this._target) return this;

    // Unbind trigger event
    const triggerEvent = this.options.trigger === 'click' ? 'click' : 'contextmenu';

    // Find and remove the handler
    this._boundHandlers.forEach((stored, handler) => {
      if (stored.target === this._target && stored.event === triggerEvent) {
        this._target.removeEventListener(triggerEvent, stored.boundHandler);
        this._boundHandlers.delete(handler);
      }
    });

    this._target = null;

    return this;
  }

  /**
   * Get current trigger element
   * @returns {Element|null} Trigger element
   */
  getTarget() {
    return this._target;
  }

  // ============================================
  // PUBLIC API - LIFECYCLE
  // ============================================

  /**
   * Destroy the context menu and cleanup
   */
  destroy() {
    // Close if open
    if (this._isOpen) this.close();

    // Clear timeouts
    if (this._submenuTimeout) {
      clearTimeout(this._submenuTimeout);
    }

    // Detach from target
    this.detach();

    // Remove menu element if we created it
    if (this._menuElement && !this._menuElement.id) {
      this._menuElement.remove();
    }

    // Clear state
    this._items = [];
    this._groups.clear();
    this._menuElement = null;

    // Call parent destroy
    super.destroy();
  }

  // ============================================
  // STATIC FACTORY METHODS
  // ============================================

  /**
   * Create a context menu programmatically
   * @param {Object} options - Menu configuration
   * @returns {SOContextMenu} Menu instance
   */
  static create(options = {}) {
    const {
      target,
      items = [],
      trigger = 'contextmenu',
      ...rest
    } = options;

    // Create a dummy element for the component
    const wrapper = document.createElement('div');
    wrapper.style.display = 'none';
    document.body.appendChild(wrapper);

    const menu = new SOContextMenu(wrapper, {
      items,
      trigger,
      ...rest,
    });

    // Attach to target if provided
    if (target) {
      menu.attach(target);
    }

    return menu;
  }
}

// Register component
SOContextMenu.register();

// Expose to global scope
window.SOContextMenu = SOContextMenu;

// Export for ES modules
export default SOContextMenu;
export { SOContextMenu };
