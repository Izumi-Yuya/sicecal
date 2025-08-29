# Shise-Cal Design System Documentation

## Overview

The Shise-Cal Design System is a comprehensive UI framework built for the facility management system. It provides consistent visual design patterns, reusable components, and standardized interactions across the entire application.

## Table of Contents

1. [Design Tokens](#design-tokens)
2. [Components](#components)
3. [Layout Patterns](#layout-patterns)
4. [Responsive Design](#responsive-design)
5. [Accessibility Guidelines](#accessibility-guidelines)
6. [Usage Examples](#usage-examples)

## Design Tokens

Design tokens are the foundation of the design system, providing consistent values for colors, typography, spacing, and other visual properties.

### Colors

#### Primary Colors
```scss
$primary: #00B4E3;           // Cyan - main brand color
$secondary: #F27CA6;         // Pink - accent color
```

#### Semantic Colors
```scss
$success: #198754;           // Green for success states
$warning: #ffc107;           // Yellow for warnings
$danger: #dc3545;            // Red for errors
$info: #0dcaf0;              // Light blue for information
```

#### Neutral Colors
```scss
$gray-50: #f8f9fa;          // Lightest gray
$gray-100: #e9ecef;         // Very light gray
$gray-200: #dee2e6;         // Light gray
$gray-300: #ced4da;         // Medium light gray
$gray-400: #adb5bd;         // Medium gray
$gray-500: #6c757d;         // Base gray
$gray-600: #495057;         // Medium dark gray
$gray-700: #343a40;         // Dark gray
$gray-800: #212529;         // Very dark gray
$gray-900: #000000;         // Black
```

#### Gradient Colors
```scss
$gradient-start: rgba(0, 180, 227, 0.3);    // Primary gradient start
$gradient-end: rgba(242, 124, 166, 0.3);    // Primary gradient end
```

### Typography

#### Font Families
```scss
$font-family-base: 'Noto Sans JP', 'Hiragino Kaku Gothic ProN', sans-serif;
$font-family-heading: 'Roboto', 'Noto Sans JP', sans-serif;
```

#### Font Sizes
```scss
$font-size-xs: 0.75rem;      // 12px
$font-size-sm: 0.875rem;     // 14px
$font-size-base: 1rem;       // 16px
$font-size-lg: 1.125rem;     // 18px
$font-size-xl: 1.25rem;      // 20px
$font-size-2xl: 1.5rem;      // 24px
$font-size-3xl: 1.875rem;    // 30px
```

#### Font Weights
```scss
$font-weight-normal: 400;
$font-weight-medium: 500;
$font-weight-semibold: 600;
$font-weight-bold: 700;
```

### Spacing

The spacing system is based on a 4px grid system:

```scss
$spacer: 1rem;               // 16px base unit
$spacers: (
  0: 0,                      // 0px
  1: $spacer * 0.25,         // 4px
  2: $spacer * 0.5,          // 8px
  3: $spacer * 0.75,         // 12px
  4: $spacer,                // 16px
  5: $spacer * 1.25,         // 20px
  6: $spacer * 1.5,          // 24px
  8: $spacer * 2,            // 32px
  10: $spacer * 2.5,         // 40px
  12: $spacer * 3,           // 48px
  16: $spacer * 4,           // 64px
);
```

### Border Radius

```scss
$border-radius-sm: 6px;      // Small radius for buttons and inputs
$border-radius-md: 8px;      // Medium radius for navigation
$border-radius-lg: 12px;     // Large radius for cards
```

### Shadows

```scss
$shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);           // Small shadow
$shadow-md: 0 4px 8px rgba(0, 0, 0, 0.15);          // Medium shadow
$shadow-lg: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);  // Large shadow
$shadow-xl: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);      // Extra large shadow
```

## Components

### Buttons

The button system provides consistent styling across all interactive elements.

#### Basic Button
```html
<button class="btn btn-primary">Primary Button</button>
<button class="btn btn-secondary">Secondary Button</button>
<button class="btn btn-outline-primary">Outline Button</button>
```

#### Button Sizes
```html
<button class="btn btn-primary btn-sm">Small Button</button>
<button class="btn btn-primary">Default Button</button>
<button class="btn btn-primary btn-lg">Large Button</button>
```

#### Button States
```html
<button class="btn btn-primary">Normal</button>
<button class="btn btn-primary" disabled>Disabled</button>
```

### Forms

#### Form Controls
```html
<div class="mb-3">
    <label for="example" class="form-label">Label</label>
    <input type="text" class="form-control" id="example" placeholder="Placeholder text">
</div>
```

#### Form Validation
```html
<div class="mb-3">
    <label for="invalid-example" class="form-label">Invalid Input</label>
    <input type="text" class="form-control is-invalid" id="invalid-example">
    <div class="invalid-feedback">Please provide a valid input.</div>
</div>
```

#### Form Toggle System
The design system includes a special form toggle system for switching between display and edit modes:

```html
<div class="form-toggle-container">
    <label class="form-label">Field Label</label>
    <div class="form-display">Display Value</div>
    <div class="form-edit">
        <input type="text" class="form-control" name="field_name" value="Edit Value">
    </div>
</div>
```

### Cards

#### Basic Card
```html
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Card Title</h5>
    </div>
    <div class="card-body">
        <p class="card-text">Card content goes here.</p>
    </div>
</div>
```

#### Dashboard Cards
```html
<div class="card dashboard-card border-left-primary shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Statistics Label
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
            </div>
            <div class="col-auto">
                <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
            </div>
        </div>
    </div>
</div>
```

### Alerts

#### Basic Alerts
```html
<div class="alert alert-primary">Primary alert message</div>
<div class="alert alert-success">Success alert message</div>
<div class="alert alert-warning">Warning alert message</div>
<div class="alert alert-danger">Danger alert message</div>
<div class="alert alert-info">Info alert message</div>
```

#### Dismissible Alerts
```html
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>Success message
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
```

### Navigation

#### Sidebar Navigation
```html
<nav class="shise-sidebar">
    <div class="shise-nav">
        <div class="nav-header">Menu Section</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-house-door"></i>Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-building"></i>Facilities
                </a>
            </li>
        </ul>
    </div>
</nav>
```

#### Tab Navigation
```html
<ul class="nav nav-tabs facility-tabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1">
            <i class="bi bi-info-circle me-2"></i>Tab 1
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2">
            <i class="bi bi-geo-alt me-2"></i>Tab 2
        </button>
    </li>
</ul>
```

### Data Tables

#### Responsive Data Table
```html
<div class="table-responsive">
    <table class="table data-table table-hover">
        <thead class="table-light">
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <th class="d-none-tablet">Column 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Column 1">Data 1</td>
                <td data-label="Column 2">Data 2</td>
                <td data-label="Column 3" class="d-none-tablet">Data 3</td>
            </tr>
        </tbody>
    </table>
</div>
```

## Layout Patterns

### Header Layout
```html
<header class="shise-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="shise-logo">
                <a href="/">
                    <img src="logo.png" alt="Logo" class="logo-image">
                    <div class="logo-fallback">
                        <span class="logo-text">Shise-Cal</span>
                    </div>
                </a>
            </div>
            <div class="approver-section">
                <button class="btn approver-btn">User Name</button>
            </div>
        </div>
    </div>
</header>
```

### Main Layout Structure
```html
<div class="shise-cal-layout">
    <header class="shise-header">...</header>
    <div class="shise-main-container">
        <nav class="shise-sidebar">...</nav>
        <main class="shise-content">...</main>
    </div>
</div>
```

### Dashboard Layout
```html
<div class="row statistics-cards">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-primary">...</div>
    </div>
    <!-- Repeat for other statistics -->
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Recent Activities</div>
            <div class="card-body recent-activities">...</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body quick-actions">...</div>
        </div>
    </div>
</div>
```

## Responsive Design

The design system uses a desktop-first approach with the following breakpoints:

### Breakpoints
```scss
$desktop-xl: 1400px;    // Large desktop
$desktop: 1200px;       // Standard desktop
$tablet: 992px;         // Tablet landscape
$mobile-lg: 768px;      // Tablet portrait
$mobile: 576px;         // Mobile landscape
$mobile-sm: 480px;      // Mobile portrait
```

### Responsive Utilities

#### Desktop-First Media Queries
```scss
// Desktop default (no media query needed)
.desktop-feature {
    display: block;
}

// Tablet adaptation
@media (max-width: $tablet) {
    .desktop-feature {
        display: none;
    }
}

// Mobile adaptation
@media (max-width: $mobile-lg) {
    .mobile-only {
        display: block;
    }
}
```

#### Responsive Grid
```html
<!-- Desktop: 4 columns, Tablet: 2 columns, Mobile: 1 column -->
<div class="row statistics-cards">
    <div class="col-xl-3 col-md-6 mb-4">...</div>
    <div class="col-xl-3 col-md-6 mb-4">...</div>
    <div class="col-xl-3 col-md-6 mb-4">...</div>
    <div class="col-xl-3 col-md-6 mb-4">...</div>
</div>
```

#### Responsive Tables
```html
<div class="table-responsive">
    <table class="table data-table">
        <thead>
            <tr>
                <th>Always Visible</th>
                <th class="d-none-tablet">Hidden on Tablet</th>
                <th class="d-none-mobile">Hidden on Mobile</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Always Visible">Data</td>
                <td data-label="Hidden on Tablet" class="d-none-tablet">Data</td>
                <td data-label="Hidden on Mobile" class="d-none-mobile">Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

## Accessibility Guidelines

### Focus Management
- All interactive elements must have visible focus indicators
- Focus should be trapped within modals and dropdowns
- Skip links should be provided for keyboard navigation

### ARIA Labels
```html
<!-- Proper ARIA labeling -->
<button class="btn btn-primary" aria-label="Save facility information">
    <i class="bi bi-check-circle" aria-hidden="true"></i>Save
</button>

<!-- Form labels -->
<label for="facility-name" class="form-label">Facility Name</label>
<input type="text" id="facility-name" class="form-control" required>
```

### Color Contrast
- All text must meet WCAG 2.1 AA standards (4.5:1 contrast ratio)
- Interactive elements must have sufficient contrast in all states

### Screen Reader Support
```html
<!-- Screen reader friendly text -->
<span class="sr-only">Additional context for screen readers</span>

<!-- Live regions for dynamic content -->
<div class="alert alert-success" role="alert" aria-live="polite">
    Success message
</div>
```

## Usage Examples

### Complete Form Example
```html
<form data-enhanced-validation>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-toggle-container">
                <label class="form-label">Facility Name</label>
                <div class="form-display">Current Facility Name</div>
                <div class="form-edit">
                    <input type="text" class="form-control" name="facility_name" value="Current Facility Name">
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Department</label>
            <select class="form-select">
                <option value="">Select Department</option>
                <option value="dept1">Department 1</option>
            </select>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
```

### Dashboard Statistics Example
```html
<div class="row statistics-cards">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Facilities
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Facility Tabs Example
```html
<div class="facility-tabs">
    <ul class="nav nav-tabs facility-tabs mb-4">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic">
                <i class="bi bi-info-circle me-2"></i>Basic Info
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#land">
                <i class="bi bi-geo-alt me-2"></i>Land
            </button>
        </li>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane fade show active" id="basic">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <!-- Form content -->
                </div>
            </div>
        </div>
    </div>
</div>
```

## JavaScript Integration

### Form Toggle Functionality
```javascript
// Initialize form toggle
const formToggle = new FormToggle(document.querySelector('.form-toggle-container'));

// Toggle between display and edit modes
formToggle.toggleMode();
```

### Auto-calculation Fields
```javascript
// Initialize auto-calculator
const calculator = new AutoCalculator();

// Calculate operating years from opening date
const operatingYears = calculator.calculateOperatingYears('2020-01-01');
```

### Component State Management
```javascript
// Initialize component state
const stateManager = new ComponentStateManager({
    theme: 'default',
    animations: true,
    accessibility: true
});
```

## Best Practices

1. **Always use design tokens** instead of hardcoded values
2. **Follow the responsive design patterns** for consistent behavior across devices
3. **Include proper ARIA labels** for accessibility
4. **Use semantic HTML** elements when possible
5. **Test with keyboard navigation** to ensure accessibility
6. **Validate color contrast** for all text elements
7. **Use the form toggle system** for edit/display functionality
8. **Apply consistent spacing** using the spacing scale
9. **Follow the component hierarchy** (tokens → base → components → patterns)
10. **Document any custom modifications** to maintain consistency

## File Structure

```
resources/sass/
├── tokens/              # Design tokens
│   ├── _colors.scss
│   ├── _typography.scss
│   ├── _spacing.scss
│   ├── _shadows.scss
│   ├── _borders.scss
│   └── _breakpoints.scss
├── base/               # Base element styles
│   ├── _reset.scss
│   ├── _typography.scss
│   └── _forms.scss
├── components/         # Component styles
│   ├── _buttons.scss
│   ├── _forms.scss
│   ├── _cards.scss
│   ├── _alerts.scss
│   └── _navigation.scss
├── patterns/          # Layout patterns
│   ├── _layout.scss
│   ├── _dashboard.scss
│   ├── _facility-forms.scss
│   └── _data-tables.scss
├── utilities/         # Utility classes
│   ├── _spacing.scss
│   ├── _colors.scss
│   ├── _typography.scss
│   └── _accessibility.scss
└── app.scss          # Main entry point
```

This design system provides a solid foundation for building consistent, accessible, and maintainable user interfaces in the Shise-Cal facility management system.