// ============================================
// SIXORBIT UI - FULL JAVASCRIPT
// Complete framework with all features
// ============================================

// Core modules (SixOrbit global is exposed to window in so-config.js)
import SixOrbit from "./core/so-config.js";
import SOComponent from "./core/so-component.js";

// Core components
import SOTheme from "./components/so-theme.js";
import SODropdown from "./components/so-dropdown.js";
// Note: SOSidebar moved to src/pages/global/global.js
import { SONavbar } from "./components/so-layout.js";
import SOModal from "./components/so-modal.js";
import SODrawer from "./components/so-drawer.js";
import SORipple from "./components/so-ripple.js";
import SOOtpInput from "./components/so-otp.js";
import SOTabs from "./components/so-tabs.js";
import SOTooltip from "./components/so-tooltip.js";
import SOContextMenu from "./components/so-context-menu.js";
import SOProgressButton from "./components/so-progress-button.js";
import SOButtonGroup from "./components/so-button-group.js";
import SOAlert from "./components/so-alert.js";
import SOToast from "./components/so-toast.js";
import SOSelect from "./components/so-select.js";
import SOAutocomplete from "./components/so-autocomplete.js";
import SOTable from "./components/so-table.js";
import SOPagination from "./components/so-pagination.js";
import SOCopy from "./components/so-copy.js";
import SOGoToTop from "./components/so-go-to-top.js";
import {
  SOInputMask,
  SOPasswordStrength,
  SOCharCounter,
  SOInputClear,
  initAllFormEnhancers,
} from "./components/so-form-enhancers.js";

// Features
import SOForms from "./features/so-forms.js";
// Note: SOAuth moved to src/pages/auth/auth.js (page-specific)

// UI Engine
import {
  UiEngine,
  ValidationEngine,
  ErrorReporter,
  Element as UiElement,
  FormElement as UiFormElement,
  ContainerElement as UiContainerElement,
} from "./ui-engine/index.js";

// Expose components to global window for inline script usage
window.SOModal = SOModal;
window.SODrawer = SODrawer;
window.SOToast = SOToast;
window.SOAlert = SOAlert;
window.SODropdown = SODropdown;
window.SOTabs = SOTabs;
window.SOTooltip = SOTooltip;
window.SOSelect = SOSelect;
window.SOAutocomplete = SOAutocomplete;
window.SOTable = SOTable;
window.SOPagination = SOPagination;
window.SOTheme = SOTheme;
window.SONavbar = SONavbar;
window.SOContextMenu = SOContextMenu;
window.SOCopy = SOCopy;
window.SOGoToTop = SOGoToTop;
window.SOInputMask = SOInputMask;
window.SOPasswordStrength = SOPasswordStrength;
window.SOCharCounter = SOCharCounter;
window.SOInputClear = SOInputClear;

// UI Engine
window.UiEngine = UiEngine;
window.ValidationEngine = ValidationEngine;
window.ErrorReporter = ErrorReporter;

// Auto-initialize all components when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  // Note: Sidebar initialization moved to src/pages/global/global.js

  // Initialize navbar if present
  const navbar = document.querySelector(".so-navbar");
  if (navbar) {
    SONavbar.getInstance(navbar);
  }

  // Initialize theme controller if settings exist
  const themeSettings = document.querySelector(".so-navbar-theme");
  if (themeSettings) {
    SOTheme.getInstance(themeSettings);
  }

  // Initialize forms
  SOForms.initAll();

  // Initialize OTP inputs if present
  document.querySelectorAll(".so-otp-group").forEach((el) => {
    SOOtpInput.getInstance(el);
  });

  // Initialize tooltips
  SOTooltip.initAll();

  // Initialize dropdowns
  SODropdown.initAll();

  // Initialize tabs
  SOTabs.initAll();

  // Initialize button groups
  SOButtonGroup.initAll();

  // Initialize progress buttons
  SOProgressButton.initAll();

  // Initialize dismissible alerts
  SOAlert.initAll();

  // Initialize custom selects
  SOSelect.initAll();

  // Initialize autocomplete inputs
  SOAutocomplete.initAll();

  // Initialize tables
  SOTable.initAll();

  // Initialize pagination
  SOPagination.initAll();

  // Initialize drawers
  SODrawer.initAll();

  // Initialize copy buttons
  SOCopy.initAll();

  // Initialize go to top buttons
  SOGoToTop.initAll();

  // Initialize form enhancers (input mask, password strength, char counter, clear button)
  initAllFormEnhancers();

  // console.log('SixOrbit UI Full initialized');
});

// Export everything for ES modules
export {
  SixOrbit,
  SOComponent,
  SOTheme,
  SODropdown,
  SONavbar,
  SOModal,
  SODrawer,
  SORipple,
  SOOtpInput,
  SOTabs,
  SOTooltip,
  SOContextMenu,
  SOProgressButton,
  SOButtonGroup,
  SOAlert,
  SOToast,
  SOSelect,
  SOAutocomplete,
  SOTable,
  SOPagination,
  SOCopy,
  SOGoToTop,
  SOForms,
  SOInputMask,
  SOPasswordStrength,
  SOCharCounter,
  SOInputClear,
  // UI Engine
  UiEngine,
  ValidationEngine,
  ErrorReporter,
  UiElement,
  UiFormElement,
  UiContainerElement,
};

export default SixOrbit;
