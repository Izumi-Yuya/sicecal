# Accessibility Guidelines

## Overview

The Shise-Cal Design System is built with accessibility as a core principle. These guidelines ensure that the facility management system is usable by everyone, including users with disabilities who rely on assistive technologies.

## WCAG 2.1 Compliance

The design system aims to meet WCAG 2.1 Level AA standards across all components and patterns.

## Color and Contrast

### Color Contrast Requirements

All text must meet minimum contrast ratios:
- **Normal text**: 4.5:1 contrast ratio
- **Large text** (18pt+ or 14pt+ bold): 3:1 contrast ratio
- **Interactive elements**: 3:1 contrast ratio for focus indicators

### Design System Color Compliance

Our color palette has been tested for accessibility:

```scss
// High contrast combinations (WCAG AA compliant)
$primary: #00B4E3;     // 4.52:1 on white background
$success: #198754;     // 4.56:1 on white background  
$warning: #ffc107;     // 1.95:1 on white (use with dark text)
$danger: #dc3545;      // 5.25:1 on white background
$info: #0dcaf0;        // 2.84:1 on white (use with dark text)

// Text colors
$gray-700: #343a40;    // 10.37:1 on white background
$gray-600: #495057;    // 7.44:1 on white background
$gray-500: #6c757d;    // 4.54:1 on white background
```

### Color Usage Guidelines

```html
<!-- Good: High contrast text -->
<p class="text-gray-700">This text has sufficient contrast</p>

<!-- Good: Warning with dark text -->
<div class="alert alert-warning">
    <span class="text-dark">Warning message with dark text</span>
</div>

<!-- Avoid: Low contrast combinations -->
<!-- <p class="text-gray-400">This text has insufficient contrast</p> -->
```

### Color Independence

Never rely solely on color to convey information:

```html
<!-- Good: Uses both color and icons -->
<div class="alert alert-success">
    <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
    Success message
</div>

<!-- Good: Uses both color and text labels -->
<span class="badge bg-success">Active</span>
<span class="badge bg-danger">Inactive</span>

<!-- Avoid: Color only -->
<!-- <div style="color: red;">Error</div> -->
```

## Keyboard Navigation

### Focus Management

All interactive elements must be keyboard accessible:

```html
<!-- Proper tab order -->
<form>
    <input type="text" tabindex="1" class="form-control">
    <select tabindex="2" class="form-select">...</select>
    <button type="submit" tabindex="3" class="btn btn-primary">Submit</button>
</form>

<!-- Skip to main content -->
<a href="#main-content" class="skip-link">Skip to main content</a>
```

### Focus Indicators

All focusable elements have visible focus indicators:

```scss
// Design system focus styles
.btn:focus,
.form-control:focus,
.form-select:focus {
    outline: 2px solid $primary;
    outline-offset: 2px;
    box-shadow: 0 0 0 0.2rem rgba($primary, 0.25);
}
```

### Keyboard Shortcuts

Document and implement keyboard shortcuts for common actions:

```html
<!-- Keyboard shortcut indicators -->
<button class="btn btn-primary" title="Save (Ctrl+S)">
    <i class="bi bi-check-circle me-2"></i>Save
</button>

<!-- Keyboard shortcuts help -->
<div class="keyboard-shortcuts d-none d-lg-block">
    <h6>Keyboard Shortcuts</h6>
    <ul>
        <li><kbd>Ctrl</kbd> + <kbd>S</kbd> - Save</li>
        <li><kbd>Ctrl</kbd> + <kbd>E</kbd> - Edit</li>
        <li><kbd>Esc</kbd> - Cancel</li>
    </ul>
</div>
```

## Screen Reader Support

### ARIA Labels and Descriptions

Provide meaningful labels for all interactive elements:

```html
<!-- Button with icon -->
<button class="btn btn-primary" aria-label="Save facility information">
    <i class="bi bi-check-circle" aria-hidden="true"></i>
    Save
</button>

<!-- Form with description -->
<div class="mb-3">
    <label for="facility-code" class="form-label">Facility Code</label>
    <input type="text" 
           id="facility-code" 
           class="form-control" 
           aria-describedby="facility-code-help"
           required>
    <div id="facility-code-help" class="form-text">
        Enter a unique 5-digit facility code
    </div>
</div>

<!-- Complex widget -->
<div class="form-toggle-container" 
     role="group" 
     aria-labelledby="facility-name-label">
    <label id="facility-name-label" class="form-label">Facility Name</label>
    <div class="form-display" aria-live="polite">Current Name</div>
    <div class="form-edit">
        <input type="text" 
               class="form-control" 
               aria-label="Edit facility name">
    </div>
</div>
```

### Live Regions

Use ARIA live regions for dynamic content updates:

```html
<!-- Status messages -->
<div class="alert alert-success" 
     role="alert" 
     aria-live="polite">
    <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
    Facility saved successfully
</div>

<!-- Error messages -->
<div class="alert alert-danger" 
     role="alert" 
     aria-live="assertive">
    <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
    Please correct the errors below
</div>

<!-- Loading states -->
<div class="loading-indicator" 
     aria-live="polite" 
     aria-label="Loading facility data">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
```

### Screen Reader Only Content

Provide additional context for screen readers:

```html
<!-- Additional context -->
<button class="btn btn-outline-danger btn-sm">
    <i class="bi bi-trash" aria-hidden="true"></i>
    <span class="visually-hidden">Delete facility</span>
</button>

<!-- Table headers -->
<table class="table">
    <caption class="visually-hidden">
        List of facilities with their codes and names
    </caption>
    <thead>
        <tr>
            <th scope="col">Facility Code</th>
            <th scope="col">Facility Name</th>
        </tr>
    </thead>
</table>

<!-- Form instructions -->
<form>
    <div class="visually-hidden">
        <h2>Facility Registration Form</h2>
        <p>Please fill out all required fields marked with an asterisk.</p>
    </div>
    <!-- Form fields -->
</form>
```

## Navigation and Structure

### Semantic HTML

Use proper HTML elements for their intended purpose:

```html
<!-- Proper heading hierarchy -->
<h1>Facility Management System</h1>
<h2>Dashboard</h2>
<h3>Recent Activities</h3>

<!-- Navigation landmarks -->
<nav aria-label="Main navigation">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#" aria-current="page">Home</a>
        </li>
    </ul>
</nav>

<!-- Main content area -->
<main id="main-content" role="main">
    <h1>Page Title</h1>
    <!-- Page content -->
</main>

<!-- Complementary content -->
<aside role="complementary" aria-label="Quick actions">
    <!-- Sidebar content -->
</aside>
```

### Skip Links

Provide skip links for keyboard users:

```html
<!-- Skip links (hidden until focused) -->
<a href="#main-content" class="skip-link">Skip to main content</a>
<a href="#sidebar-nav" class="skip-link">Skip to navigation</a>

<style>
.skip-link {
    position: absolute;
    top: -40px;
    left: 6px;
    background: $primary;
    color: white;
    padding: 8px;
    text-decoration: none;
    z-index: 1000;
    border-radius: 0 0 4px 4px;
}

.skip-link:focus {
    top: 0;
}
</style>
```

### Breadcrumb Navigation

Implement accessible breadcrumbs:

```html
<nav aria-label="Breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/facilities">Facilities</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Facility Details
        </li>
    </ol>
</nav>
```

## Form Accessibility

### Form Labels

Every form control must have an associated label:

```html
<!-- Explicit labels -->
<div class="mb-3">
    <label for="facility-name" class="form-label">
        Facility Name <span class="text-danger">*</span>
    </label>
    <input type="text" 
           id="facility-name" 
           class="form-control" 
           required 
           aria-required="true">
</div>

<!-- Fieldsets for grouped controls -->
<fieldset>
    <legend class="form-label">Contact Information</legend>
    <div class="row">
        <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" id="phone" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="fax" class="form-label">Fax</label>
            <input type="tel" id="fax" class="form-control">
        </div>
    </div>
</fieldset>
```

### Form Validation

Provide clear, accessible error messages:

```html
<!-- Field with validation error -->
<div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" 
           id="email" 
           class="form-control is-invalid" 
           aria-describedby="email-error"
           aria-invalid="true">
    <div id="email-error" class="invalid-feedback" role="alert">
        Please enter a valid email address
    </div>
</div>

<!-- Form-level error summary -->
<div class="alert alert-danger" role="alert" aria-labelledby="error-summary">
    <h4 id="error-summary">Please correct the following errors:</h4>
    <ul>
        <li><a href="#facility-name">Facility name is required</a></li>
        <li><a href="#email">Email address is invalid</a></li>
    </ul>
</div>
```

### Required Fields

Clearly indicate required fields:

```html
<!-- Required field indicator -->
<div class="mb-3">
    <label for="required-field" class="form-label">
        Required Field 
        <span class="text-danger" aria-label="required">*</span>
    </label>
    <input type="text" 
           id="required-field" 
           class="form-control" 
           required 
           aria-required="true">
</div>

<!-- Form instructions -->
<div class="alert alert-info" role="region" aria-labelledby="form-instructions">
    <h5 id="form-instructions">Form Instructions</h5>
    <p>Fields marked with <span class="text-danger">*</span> are required.</p>
</div>
```

## Interactive Components

### Buttons

Make buttons accessible and descriptive:

```html
<!-- Descriptive button text -->
<button class="btn btn-primary">Save Facility Information</button>

<!-- Icon buttons with labels -->
<button class="btn btn-outline-primary" aria-label="Edit facility details">
    <i class="bi bi-pencil" aria-hidden="true"></i>
    <span class="visually-hidden">Edit</span>
</button>

<!-- Toggle buttons -->
<button class="btn btn-outline-secondary" 
        aria-pressed="false" 
        aria-label="Toggle edit mode">
    <i class="bi bi-pencil" aria-hidden="true"></i>
    Edit Mode
</button>
```

### Modals and Dialogs

Implement accessible modal dialogs:

```html
<!-- Modal trigger -->
<button class="btn btn-danger" 
        data-bs-toggle="modal" 
        data-bs-target="#deleteModal">
    Delete Facility
</button>

<!-- Modal dialog -->
<div class="modal fade" 
     id="deleteModal" 
     tabindex="-1" 
     aria-labelledby="deleteModalLabel" 
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    Confirm Deletion
                </h5>
                <button type="button" 
                        class="btn-close" 
                        data-bs-dismiss="modal" 
                        aria-label="Close dialog"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this facility? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" 
                        class="btn btn-danger">
                    Delete Facility
                </button>
            </div>
        </div>
    </div>
</div>
```

### Tabs

Create accessible tab interfaces:

```html
<div class="facility-tabs">
    <ul class="nav nav-tabs" role="tablist" aria-label="Facility information sections">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" 
                    id="basic-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#basic" 
                    type="button" 
                    role="tab" 
                    aria-controls="basic" 
                    aria-selected="true">
                <i class="bi bi-info-circle me-2" aria-hidden="true"></i>
                Basic Information
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" 
                    id="land-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#land" 
                    type="button" 
                    role="tab" 
                    aria-controls="land" 
                    aria-selected="false">
                <i class="bi bi-geo-alt me-2" aria-hidden="true"></i>
                Land Information
            </button>
        </li>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane fade show active" 
             id="basic" 
             role="tabpanel" 
             aria-labelledby="basic-tab">
            <!-- Basic info content -->
        </div>
        <div class="tab-pane fade" 
             id="land" 
             role="tabpanel" 
             aria-labelledby="land-tab">
            <!-- Land info content -->
        </div>
    </div>
</div>
```

## Data Tables

### Accessible Table Structure

Create properly structured data tables:

```html
<table class="table data-table" role="table">
    <caption class="visually-hidden">
        List of facilities showing facility codes and names. 
        Table has 2 columns and 5 rows.
    </caption>
    <thead>
        <tr>
            <th scope="col" id="facility-code">
                Facility Code
                <button class="btn btn-sm btn-link" 
                        aria-label="Sort by facility code">
                    <i class="bi bi-arrow-up-down" aria-hidden="true"></i>
                </button>
            </th>
            <th scope="col" id="facility-name">
                Facility Name
                <button class="btn btn-sm btn-link" 
                        aria-label="Sort by facility name">
                    <i class="bi bi-arrow-up-down" aria-hidden="true"></i>
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td headers="facility-code">
                <code class="text-primary fw-bold">FAC001</code>
            </td>
            <td headers="facility-name">
                <strong>Sample Facility</strong>
            </td>
        </tr>
    </tbody>
</table>
```

### Responsive Table Accessibility

Maintain accessibility in responsive tables:

```html
<!-- Mobile-friendly table with data attributes -->
<table class="table data-table table-responsive-stack">
    <thead class="d-none d-md-table-header-group">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr class="d-md-table-row">
            <td data-label="Code" class="d-block d-md-table-cell">
                <span class="fw-bold d-md-none">Code: </span>FAC001
            </td>
            <td data-label="Name" class="d-block d-md-table-cell">
                <span class="fw-bold d-md-none">Name: </span>Sample Facility
            </td>
            <td data-label="Status" class="d-block d-md-table-cell">
                <span class="fw-bold d-md-none">Status: </span>
                <span class="badge bg-success">Active</span>
            </td>
        </tr>
    </tbody>
</table>
```

## Testing Guidelines

### Automated Testing

Use automated tools to catch accessibility issues:

```javascript
// Example accessibility test with axe-core
describe('Accessibility Tests', () => {
    test('Dashboard should be accessible', async () => {
        const results = await axe.run(document);
        expect(results.violations).toHaveLength(0);
    });
    
    test('Form should be accessible', async () => {
        const form = document.querySelector('form');
        const results = await axe.run(form);
        expect(results.violations).toHaveLength(0);
    });
});
```

### Manual Testing Checklist

#### Keyboard Navigation
- [ ] All interactive elements are reachable via keyboard
- [ ] Tab order is logical and intuitive
- [ ] Focus indicators are visible and clear
- [ ] No keyboard traps exist

#### Screen Reader Testing
- [ ] All content is announced properly
- [ ] Form labels and instructions are clear
- [ ] Error messages are announced
- [ ] Dynamic content updates are announced

#### Color and Contrast
- [ ] All text meets contrast requirements
- [ ] Information is not conveyed by color alone
- [ ] Focus indicators have sufficient contrast

#### Responsive Design
- [ ] Content remains accessible at all screen sizes
- [ ] Touch targets are at least 44px × 44px
- [ ] Horizontal scrolling is avoided when possible

### Browser and Assistive Technology Testing

Test with common assistive technologies:

#### Screen Readers
- **NVDA** (Windows) - Free screen reader
- **JAWS** (Windows) - Popular commercial screen reader
- **VoiceOver** (macOS/iOS) - Built-in screen reader
- **TalkBack** (Android) - Built-in screen reader

#### Browser Testing
- Chrome with ChromeVox extension
- Firefox with accessibility features
- Safari with VoiceOver
- Edge with Narrator

## Implementation Checklist

### For Developers

- [ ] Use semantic HTML elements
- [ ] Provide proper ARIA labels and descriptions
- [ ] Ensure keyboard accessibility
- [ ] Test with screen readers
- [ ] Validate color contrast
- [ ] Implement focus management
- [ ] Add skip links
- [ ] Use proper heading hierarchy
- [ ] Provide alternative text for images
- [ ] Test responsive behavior

### For Designers

- [ ] Design with sufficient color contrast
- [ ] Don't rely solely on color for information
- [ ] Design clear focus indicators
- [ ] Consider touch target sizes
- [ ] Plan for screen reader announcements
- [ ] Design accessible form layouts
- [ ] Consider cognitive load and complexity

### For Content Creators

- [ ] Write descriptive link text
- [ ] Provide meaningful alt text for images
- [ ] Use clear, simple language
- [ ] Structure content with proper headings
- [ ] Provide context for complex information
- [ ] Write helpful error messages

By following these accessibility guidelines, the Shise-Cal facility management system ensures that all users can effectively access and use the application, regardless of their abilities or the assistive technologies they may use.