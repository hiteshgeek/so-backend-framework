# Form Class - Feature Specification

**Date:** 2026-02-06
**Status:** Planning - Not Implemented

## Overview

A comprehensive JavaScript Form class that manages form elements using internal IDs (not displayed in DOM). Provides robust data handling, validation, state management, and integration with existing UI components.

---

## Internal ID System (4-Level Fallback)

For both **form** and **field** identification:

1. **User-specified identifier** - When creating via UiEngine PHP/JS or config
2. **`id` attribute** - If present in DOM
3. **`name` attribute** - If present in DOM
4. **Auto-generated ID** - Element-based (e.g., `input-{unique-number}`, `form-{unique-number}`)

**Key:** These are INTERNAL IDs for the Form class, NOT shown in DOM.

---

## Feature Categories

### 1. **Element Registry & Access**
- Register all form fields with internal IDs (using 4-level fallback)
- Access element by: internal ID, index, name attribute, or selector
- Iterator support: `form.forEach()`, `form.fields`, `form.inputs`, `form.selects`
- Group access: `form.getByType('input')`, `form.getByGroup('billing')`
- Check existence: `form.has('fieldId')`

### 2. **Data Management**
- **Get data**: `form.getData()` → `{field1: value1, field2: value2}`
- **Get single value**: `form.getValue('email')`
- **Set values**: `form.setData({...})`, `form.setValue('email', 'test@example.com')`
- **Reset**: `form.reset()` (to initial), `form.resetTo({...})` (to specific values)
- **Dirty tracking**: `form.isDirty()`, `form.getDirtyFields()`, `form.getChanges()`
- **Initial state**: Snapshot values when form loads, compare current vs initial

### 3. **Validation Integration**
- **Register rules**: `form.setRules({email: 'required|email'})`
- **Validate**: `form.validate()` (all), `form.validateField('email')` (single)
- **Get errors**: `form.getErrors()`, `form.getError('email')`
- **Clear errors**: `form.clearErrors()`, `form.clearError('email')`
- **Validation state**: `form.isValid()`, `form.getInvalidFields()`

### 4. **State Management**
- **Form states**: pristine, dirty, valid, invalid, submitting, submitted
- **Field states**: enabled, disabled, visible, hidden, readonly
- **Bulk operations**: `form.disable()`, `form.enable(['email', 'phone'])`
- **Required toggle**: `form.setRequired('email', true)`
- **State queries**: `form.getState()`, `form.getFieldState('email')`

### 5. **Error Reporting Integration**
- Auto-integrate with ErrorReporter using internal IDs
- `form.showErrors(errors)` → displays in ErrorReporter + inline
- `form.showError('email', 'Invalid email')`
- `form.clearAllErrors()`
- Focus first error field automatically

### 6. **Event System**
- **Form events**: `submit`, `reset`, `change`, `valid`, `invalid`
- **Field events**: Track changes per field
- **Hooks**: `onBeforeSubmit()`, `onAfterSubmit()`, `onValidationFail()`
- **Event delegation**: Works with dynamically added fields
- **Custom events**: `form.on('customEvent', handler)`

### 7. **Dynamic Field Management**
- **Add**: `form.addField(config)` → returns internal ID
- **Remove**: `form.removeField('fieldId')`
- **Clone**: `form.cloneField('fieldId', newId)`
- **Reorder**: `form.moveField('fieldId', newIndex)`
- **Replace**: `form.replaceField('oldId', newConfig)`

### 8. **Serialization**
- **To JSON**: `form.toJSON()`
- **To FormData**: `form.toFormData()` (for file uploads)
- **To query string**: `form.toQueryString()`
- **From object**: `form.fromObject({...})`
- **Include/exclude**: `form.toJSON({exclude: ['password']})`

### 9. **AJAX Submission**
- **Submit**: `form.submit('/api/endpoint', {method: 'POST'})`
- **Auto-handle**: Success/error responses, loading states, error display
- **Retry**: Built-in retry logic with exponential backoff
- **Upload progress**: Track for file uploads
- **Response handling**: `form.onSuccess(callback)`, `form.onError(callback)`

### 10. **Field Dependencies**
- **Conditional visibility**: Show field B when field A = value
- **Conditional enable**: Enable field based on another field
- **Calculated values**: Field C = Field A + Field B
- **Chained dropdowns**: Options in B depend on selection in A

### 11. **Auto-save**
- **LocalStorage**: `form.enableAutoSave({key: 'myForm', interval: 5000})`
- **Restore**: Automatically restore on page load
- **Clear**: `form.clearSaved()`
- **Debounced**: Save after user stops typing

### 12. **Multi-step / Wizard**
- **Step management**: `form.addStep('billing')`, `form.addStep('shipping')`
- **Navigation**: `form.nextStep()`, `form.prevStep()`, `form.goToStep(2)`
- **Validation**: Validate current step before allowing next
- **Progress**: `form.getProgress()` → `{current: 2, total: 4, percent: 50}`

### 13. **Field Collections / Repeaters**
- **Dynamic rows**: Add/remove repeating field groups
- **Example**: Multiple addresses, multiple phone numbers
- **Access**: `form.getCollection('addresses')` → array of field groups
- **Operations**: `form.addRow('addresses')`, `form.removeRow('addresses', index)`

### 14. **Accessibility & UX**
- **Focus management**: `form.focusFirst()`, `form.focusNextError()`
- **Keyboard navigation**: Tab order, Enter to submit
- **ARIA attributes**: Auto-manage `aria-invalid`, `aria-describedby`
- **Loading states**: Show spinner, disable during submission

### 15. **File Upload Management**
- **Track files**: `form.getFiles('avatar')`
- **Preview**: Generate preview URLs
- **Validation**: File size, type validation
- **Progress**: Upload progress tracking
- **Multiple**: Handle multiple file inputs

### 16. **Form Comparison**
- **Compare**: `form.diff(otherFormData)` → show differences
- **Merge**: `form.merge(otherFormData, strategy)`
- **Conflicts**: Detect and handle conflicting changes

### 17. **Undo/Redo**
- **History**: Track value changes
- **Undo**: `form.undo()` → revert last change
- **Redo**: `form.redo()`
- **History limit**: Configurable history depth

### 18. **Debug & Development**
- **Inspect**: `form.inspect()` → detailed form state
- **Logging**: `form.enableDebug()` → log all operations
- **Validation debug**: Show which rules passed/failed
- **Performance**: Track render time, validation time

---

## Implementation Priority

### Phase 1 (MVP)
- Element Registry & Access (1)
- Data Management (2)
- Validation Integration (3)
- Error Reporting Integration (5)

### Phase 2
- State Management (4)
- Event System (6)
- Serialization (8)
- AJAX Submission (9)

### Phase 3
- Dynamic Fields (7)
- Field Dependencies (10)
- Auto-save (11)

### Phase 4 (Advanced)
- Multi-step (12)
- Field Collections (13)
- File Upload (15)
- Undo/Redo (17)

---

## Architecture Notes

- **Form Class**: Pure JavaScript class (no PHP dependency for runtime)
- **Integration**: Works with existing component classes (Input, Select, Textarea, etc.)
- **Internal IDs**: Managed internally, not exposed in DOM
- **Form ID**: Same 4-level fallback pattern as field IDs
- **Purpose**: Data fetching, manipulation, property/state handling through Form class

---

## Next Steps

1. Review and prioritize features
2. Design Form class API
3. Create implementation plan
4. Develop Phase 1 features
5. Test and iterate

---

**Note:** This is a planning document. Features are subject to change based on implementation findings and user feedback.
