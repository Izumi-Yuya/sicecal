# UI Design System Design Document

## Overview

This design document outlines the implementation of a comprehensive UI design system for the Shise-Cal facility management application. The design system will establish visual consistency, improve user experience, and provide reusable components that maintain the application's professional appearance while ensuring accessibility and responsive behavior across all devices.

The design system is built on top of Bootstrap 5.3.x and uses a custom SCSS architecture to maintain consistency with the existing gradient-based header design, card layouts, and Japanese typography requirements.

## Architecture

### Design Token System

The design system will be built around a centralized token system that defines:

- **Color Palette**: Primary (#00B4E3), Secondary (#F27CA6), and semantic colors
- **Typography Scale**: Consistent font sizes, weights, and line heights for Japanese text
- **Spacing System**: Standardized margins, padding, and gap values
- **Border Radius**: Consistent corner radius values (6px, 8px, 12px)
- **Shadow System**: Elevation levels for cards and interactive elements
- **Animation Timing**: Consistent transition durations and easing functions

### Component Architecture

The design system follows a hierarchical component structure:

1. **Tokens** - Design variables (colors, spacing, typography)
2. **Base Elements** - HTML element styling (buttons, inputs, links)
3. **Components** - Reusable UI components (cards, forms, navigation)
4. **Patterns** - Complex UI patterns (dashboard layouts, facility forms)
5. **Templates** - Page-level layouts and structures

### SCSS Architecture

```
resources/sass/
├── tokens/
│   ├── _colors.scss          # Color palette and semantic colors
│   ├── _typography.scss      # Font scales and Japanese typography
│   ├── _spacing.scss         # Margin, padding, and gap values
│   └── _shadows.scss         # Box shadow definitions
├── base/
│   ├── _reset.scss           # CSS reset and normalization
│   ├── _typography.scss      # Base typography styles
│   └── _forms.scss           # Base form element styles
├── components/
│   ├── _buttons.scss         # Button component styles
│   ├── _cards.scss           # Card component styles
│   ├── _forms.scss           # Form component styles
│   ├── _navigation.scss      # Navigation component styles
│   └── _alerts.scss          # Alert and notification styles
├── patterns/
│   ├── _dashboard.scss       # Dashboard layout patterns
│   ├── _facility-forms.scss  # Facility form patterns
│   └── _data-tables.scss     # Data table patterns
└── app.scss                  # Main entry point
```

## Components and Interfaces

### 1. Design Tokens

#### Color System
```scss
// Primary Colors
$primary: #00B4E3;           // Cyan - main brand color
$secondary: #F27CA6;         // Pink - accent color
$gradient-start: rgba(0, 180, 227, 0.3);
$gradient-end: rgba(242, 124, 166, 0.3);

// Semantic Colors
$success: #198754;
$warning: #ffc107;
$danger: #dc3545;
$info: #0dcaf0;

// Neutral Colors
$gray-50: #f8f9fa;
$gray-100: #e9ecef;
$gray-200: #dee2e6;
$gray-300: #ced4da;
$gray-400: #adb5bd;
$gray-500: #6c757d;
$gray-600: #495057;
$gray-700: #343a40;
$gray-800: #212529;
$gray-900: #000000;
```

#### Typography Scale
```scss
// Font Families
$font-family-base: 'Noto Sans JP', 'Hiragino Kaku Gothic ProN', sans-serif;
$font-family-heading: 'Roboto', 'Noto Sans JP', sans-serif;

// Font Sizes
$font-size-xs: 0.75rem;      // 12px
$font-size-sm: 0.875rem;     // 14px
$font-size-base: 1rem;       // 16px
$font-size-lg: 1.125rem;     // 18px
$font-size-xl: 1.25rem;      // 20px
$font-size-2xl: 1.5rem;      // 24px
$font-size-3xl: 1.875rem;    // 30px

// Font Weights
$font-weight-normal: 400;
$font-weight-medium: 500;
$font-weight-semibold: 600;
$font-weight-bold: 700;
```

#### Spacing System
```scss
// Spacing Scale (based on 0.25rem = 4px)
$spacer: 1rem;
$spacers: (
  0: 0,
  1: $spacer * 0.25,    // 4px
  2: $spacer * 0.5,     // 8px
  3: $spacer * 0.75,    // 12px
  4: $spacer,           // 16px
  5: $spacer * 1.25,    // 20px
  6: $spacer * 1.5,     // 24px
  8: $spacer * 2,       // 32px
  10: $spacer * 2.5,    // 40px
  12: $spacer * 3,      // 48px
  16: $spacer * 4,      // 64px
);
```

### 2. Base Components

#### Button System
```scss
.btn {
  // Base button styles
  border-radius: 6px;
  font-weight: $font-weight-medium;
  transition: all 0.2s ease;
  
  // Size variants
  &.btn-sm { padding: 0.375rem 0.75rem; font-size: $font-size-sm; }
  &.btn-lg { padding: 0.75rem 1.5rem; font-size: $font-size-lg; }
  
  // Interactive states
  &:hover { transform: translateY(-1px); }
  &:active { transform: translateY(0); }
  &:disabled { opacity: 0.6; cursor: not-allowed; }
}
```

#### Form Components
```scss
.form-control, .form-select {
  border-radius: 6px;
  border: 1px solid $gray-300;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  
  &:focus {
    border-color: rgba($primary, 0.5);
    box-shadow: 0 0 0 0.2rem rgba($primary, 0.25);
  }
  
  &.is-invalid {
    border-color: $danger;
    box-shadow: 0 0 0 0.2rem rgba($danger, 0.25);
  }
}

.form-label {
  font-weight: $font-weight-medium;
  color: $gray-700;
  margin-bottom: 0.5rem;
}
```

#### Card System
```scss
.card {
  border: 1px solid $gray-200;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  
  &:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }
  
  .card-header {
    background-color: $gray-50;
    border-bottom: 1px solid $gray-200;
    font-weight: $font-weight-semibold;
    border-radius: 12px 12px 0 0;
  }
}
```

### 3. Layout Components

#### Header Component
The header maintains the existing gradient design while ensuring consistent styling:

```scss
.shise-header {
  background: linear-gradient(90deg, $gradient-start 20%, $gradient-end 80%);
  height: 64px;
  position: fixed;
  width: 100%;
  z-index: 1030;
  
  .shise-logo {
    .logo-image { width: 156px; height: 55px; }
    .logo-fallback { 
      .logo-text { 
        font-family: $font-family-heading;
        font-weight: $font-weight-semibold;
      }
    }
  }
  
  .approver-section .approver-btn {
    background-color: rgba(255, 255, 255, 0.9);
    border: 1px solid $gray-800;
    font-weight: $font-weight-semibold;
  }
}
```

#### Sidebar Navigation
```scss
.shise-sidebar {
  width: 240px;
  background: white;
  border-right: 1px solid $gray-300;
  
  .nav-link {
    border-radius: 8px;
    transition: all 0.2s ease;
    font-weight: $font-weight-medium;
    
    &:hover {
      background-color: $gray-50;
      color: $primary;
    }
    
    &.active {
      background-color: rgba($primary, 0.1);
      color: $primary;
      border-right: 3px solid $primary;
    }
  }
}
```

### 4. Form Patterns

#### Facility Form Pattern
The facility forms use a tabbed interface with consistent styling:

```scss
.facility-tabs {
  .nav-tabs {
    border-bottom: 2px solid $gray-200;
    
    .nav-link {
      border: none;
      border-radius: 8px 8px 0 0;
      font-weight: $font-weight-medium;
      
      &.active {
        color: $primary;
        border-bottom: 2px solid $primary;
        font-weight: $font-weight-semibold;
      }
    }
  }
}

.form-display {
  min-height: 1.5rem;
  padding: 0.375rem 0;
  color: $gray-700;
  font-weight: $font-weight-medium;
  
  &:empty::before {
    content: "未設定";
    color: $gray-500;
    font-style: italic;
  }
}
```

#### Edit/Display Toggle Pattern
```scss
.edit-mode {
  .form-display { display: none !important; }
  .form-edit { display: block !important; }
}

.view-mode {
  .form-display { display: block !important; }
  .form-edit { display: none !important; }
}
```

### 5. Dashboard Components

#### Statistics Cards
```scss
.dashboard-card {
  border: none;
  border-radius: 12px;
  box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
  transition: all 0.3s ease;
  
  &:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);
  }
  
  &.border-left-primary { border-left: 4px solid $primary !important; }
  &.border-left-success { border-left: 4px solid $success !important; }
  &.border-left-warning { border-left: 4px solid $warning !important; }
  &.border-left-info { border-left: 4px solid $info !important; }
}
```

#### Welcome Section
```scss
.dashboard-welcome {
  background: linear-gradient(135deg, rgba($primary, 0.1) 0%, rgba($secondary, 0.1) 100%);
  border: none;
  border-radius: 12px;
}
```

## Data Models

### Component State Management

The design system includes JavaScript utilities for managing component states:

```javascript
// Form edit/display toggle
class FormToggle {
  constructor(container) {
    this.container = container;
    this.isEditMode = false;
  }
  
  toggleMode() {
    this.isEditMode = !this.isEditMode;
    this.container.classList.toggle('edit-mode', this.isEditMode);
    this.container.classList.toggle('view-mode', !this.isEditMode);
  }
}

// Auto-calculation utilities
class AutoCalculator {
  static calculateOperatingYears(openingDate) {
    if (!openingDate) return null;
    const now = new Date();
    const opening = new Date(openingDate);
    const years = Math.floor((now - opening) / (365.25 * 24 * 60 * 60 * 1000));
    return years;
  }
}
```

### Theme Configuration

```javascript
const themeConfig = {
  colors: {
    primary: '#00B4E3',
    secondary: '#F27CA6',
    success: '#198754',
    warning: '#ffc107',
    danger: '#dc3545',
    info: '#0dcaf0'
  },
  spacing: {
    xs: '0.25rem',
    sm: '0.5rem',
    md: '1rem',
    lg: '1.5rem',
    xl: '2rem'
  },
  borderRadius: {
    sm: '6px',
    md: '8px',
    lg: '12px'
  }
};
```

## Error Handling

### Form Validation Patterns

```scss
.is-invalid {
  border-color: $danger;
  
  &:focus {
    border-color: $danger;
    box-shadow: 0 0 0 0.2rem rgba($danger, 0.25);
  }
}

.invalid-feedback {
  display: block;
  color: $danger;
  font-size: $font-size-sm;
  margin-top: 0.25rem;
}

.valid-feedback {
  display: block;
  color: $success;
  font-size: $font-size-sm;
  margin-top: 0.25rem;
}
```

### Alert System

```scss
.alert {
  border: none;
  border-left: 4px solid;
  border-radius: 8px;
  padding: 1rem 1.25rem;
  
  &.alert-primary { border-left-color: $primary; }
  &.alert-success { border-left-color: $success; }
  &.alert-warning { border-left-color: $warning; }
  &.alert-danger { border-left-color: $danger; }
  &.alert-info { border-left-color: $info; }
}
```

## Testing Strategy

### Visual Regression Testing

1. **Component Screenshots**: Automated screenshots of all components in different states
2. **Cross-browser Testing**: Ensure consistency across Chrome, Firefox, Safari, and Edge
3. **Responsive Testing**: Verify layouts at mobile (375px), tablet (768px), and desktop (1200px) breakpoints

### Accessibility Testing

1. **Color Contrast**: Ensure all text meets WCAG 2.1 AA standards (4.5:1 ratio)
2. **Keyboard Navigation**: All interactive elements must be keyboard accessible
3. **Screen Reader Testing**: Test with NVDA and VoiceOver
4. **Focus Management**: Visible focus indicators on all interactive elements

### Performance Testing

1. **CSS Bundle Size**: Monitor compiled CSS size and optimize for performance
2. **Animation Performance**: Ensure smooth 60fps animations
3. **Load Time Impact**: Measure impact on page load times

### Component Testing

```javascript
// Example component test
describe('Button Component', () => {
  test('applies correct styles for primary variant', () => {
    const button = render('<button class="btn btn-primary">Test</button>');
    expect(button).toHaveClass('btn-primary');
    expect(button).toHaveStyle('background-color: #00B4E3');
  });
  
  test('shows hover state on interaction', () => {
    const button = render('<button class="btn btn-primary">Test</button>');
    fireEvent.mouseEnter(button);
    expect(button).toHaveStyle('transform: translateY(-1px)');
  });
});
```

### Integration Testing

1. **Form Interactions**: Test edit/display toggle functionality
2. **Navigation States**: Verify active states and transitions
3. **Responsive Behavior**: Test layout changes at different breakpoints
4. **Theme Consistency**: Ensure all components use design tokens correctly

## Responsive Design Strategy

### Desktop-First Approach

The design system prioritizes desktop/PC usage as the primary interface, with mobile support as secondary:

#### Desktop Optimization (1200px+)
- **Primary Target**: 1920x1080 and 1366x768 resolutions
- **Sidebar**: Fixed 240px width with full navigation visible
- **Content Area**: Utilizes remaining screen width effectively
- **Form Layouts**: Multi-column layouts for efficient data entry
- **Data Tables**: Full-width tables with horizontal scrolling when needed
- **Dashboard**: 4-column statistics cards layout

#### Tablet Adaptation (768px - 1199px)
- **Sidebar**: Collapsible sidebar that overlays content
- **Content Area**: Full width with adjusted padding
- **Form Layouts**: 2-column layouts where appropriate
- **Data Tables**: Responsive table behavior with column prioritization

#### Mobile Support (< 768px)
- **Sidebar**: Off-canvas navigation menu
- **Content Area**: Single column layout with touch-friendly spacing
- **Form Layouts**: Single column with larger touch targets
- **Data Tables**: Card-based layout for complex data

```scss
// Desktop-first responsive breakpoints
$desktop-xl: 1400px;    // Large desktop
$desktop: 1200px;       // Standard desktop
$tablet: 992px;         // Tablet landscape
$mobile-lg: 768px;      // Tablet portrait
$mobile: 576px;         // Mobile landscape
$mobile-sm: 480px;      // Mobile portrait

// Desktop-optimized layout
.shise-content {
  // Desktop default (no media query needed)
  width: calc(100% - 240px);
  margin-left: 240px;
  padding: 2rem;
  
  // Tablet adaptation
  @media (max-width: $tablet) {
    width: 100%;
    margin-left: 0;
    padding: 1.5rem;
  }
  
  // Mobile adaptation
  @media (max-width: $mobile-lg) {
    padding: 1rem;
  }
}

// Form layouts optimized for desktop
.facility-form {
  .row {
    // Desktop: 2-3 columns for efficient data entry
    .col-md-6 { flex: 0 0 50%; }
    .col-md-4 { flex: 0 0 33.333333%; }
    
    // Tablet: 2 columns
    @media (max-width: $tablet) {
      .col-md-4 { flex: 0 0 50%; }
    }
    
    // Mobile: single column
    @media (max-width: $mobile-lg) {
      .col-md-6,
      .col-md-4 { flex: 0 0 100%; }
    }
  }
}

// Dashboard statistics optimized for desktop
.statistics-cards {
  // Desktop: 4 columns
  .col-xl-3 { flex: 0 0 25%; }
  
  // Large tablet: 2 columns
  @media (max-width: $desktop) {
    .col-xl-3 { flex: 0 0 50%; }
  }
  
  // Mobile: single column
  @media (max-width: $mobile-lg) {
    .col-xl-3 { flex: 0 0 100%; }
  }
}
```

### Desktop-Specific Optimizations

#### Enhanced Data Tables
```scss
.data-table {
  // Desktop: full table with all columns visible
  width: 100%;
  
  th, td {
    padding: 0.75rem 1rem;
    white-space: nowrap;
  }
  
  // Horizontal scroll for very wide tables
  &.table-responsive {
    overflow-x: auto;
    min-width: 1000px;
  }
  
  // Tablet: hide less important columns
  @media (max-width: $tablet) {
    .d-none-tablet { display: none !important; }
  }
  
  // Mobile: card layout
  @media (max-width: $mobile-lg) {
    display: block;
    
    thead { display: none; }
    
    tbody tr {
      display: block;
      border: 1px solid $gray-200;
      margin-bottom: 1rem;
      border-radius: 8px;
    }
    
    td {
      display: block;
      text-align: right;
      border: none;
      padding: 0.5rem 1rem;
      
      &:before {
        content: attr(data-label) ": ";
        float: left;
        font-weight: bold;
      }
    }
  }
}
```

#### Desktop Form Enhancements
```scss
.desktop-form-enhancements {
  // Keyboard shortcuts display
  .keyboard-shortcuts {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    
    @media (max-width: $tablet) {
      display: none;
    }
  }
  
  // Enhanced tooltips for desktop
  .form-tooltip {
    position: relative;
    
    &:hover::after {
      content: attr(data-tooltip);
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.9);
      color: white;
      padding: 0.5rem;
      border-radius: 4px;
      font-size: 0.75rem;
      white-space: nowrap;
      z-index: 1000;
    }
  }
}
```

### User Acceptance Testing

1. **Desktop Usability Testing**: Conduct user testing sessions with facility managers using desktop computers
2. **Accessibility Testing**: Test with users who rely on assistive technologies on desktop environments
3. **Performance Testing**: Gather feedback on perceived performance and responsiveness on desktop browsers
4. **Visual Design Testing**: Validate that the design meets user expectations and brand requirements for desktop usage