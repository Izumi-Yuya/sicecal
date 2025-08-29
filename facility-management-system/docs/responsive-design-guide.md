# Responsive Design Guide

## Overview

The Shise-Cal Design System uses a **desktop-first** responsive approach, optimized for facility management professionals who primarily work on desktop computers while providing excellent mobile and tablet experiences.

## Breakpoint System

### Breakpoint Values

```scss
$desktop-xl: 1400px;    // Large desktop displays
$desktop: 1200px;       // Standard desktop (primary target)
$tablet: 992px;         // Tablet landscape
$mobile-lg: 768px;      // Tablet portrait / Large mobile
$mobile: 576px;         // Mobile landscape
$mobile-sm: 480px;      // Mobile portrait
```

### Target Resolutions

#### Primary Targets (Desktop-First)
- **1920×1080** - Full HD desktop (most common)
- **1366×768** - Standard laptop display
- **1440×900** - MacBook Air 13"

#### Secondary Targets
- **1024×768** - Tablet landscape
- **768×1024** - Tablet portrait
- **375×667** - Mobile (iPhone SE)
- **414×896** - Large mobile (iPhone 11)

## Layout Patterns

### Desktop Layout (1200px+)

The primary layout optimized for desktop usage:

```scss
// Desktop-first layout
.shise-content {
    width: calc(100% - 240px);  // Account for fixed sidebar
    margin-left: 240px;         // Sidebar width
    padding: 2rem;              // Generous padding for desktop
    
    // No media query needed - this is the default
}

.shise-sidebar {
    width: 240px;               // Fixed width sidebar
    position: fixed;            // Always visible on desktop
    height: 100vh;              // Full height
    overflow-y: auto;           // Scrollable if needed
}
```

### Tablet Layout (768px - 1199px)

Adapted for tablet usage with collapsible sidebar:

```scss
@media (max-width: $desktop - 1px) {
    .shise-content {
        width: 100%;            // Full width when sidebar is collapsed
        margin-left: 0;         // No margin offset
        padding: 1.5rem;        // Reduced padding
    }
    
    .shise-sidebar {
        transform: translateX(-100%);  // Hidden by default
        transition: transform 0.3s ease;
        
        &.show {
            transform: translateX(0);   // Slide in when active
        }
    }
}
```

### Mobile Layout (< 768px)

Optimized for touch interaction:

```scss
@media (max-width: $mobile-lg - 1px) {
    .shise-content {
        padding: 1rem;          // Minimal padding for mobile
    }
    
    .shise-header {
        height: 56px;           // Reduced header height
        
        .shise-logo img {
            max-height: 32px;    // Smaller logo
        }
    }
    
    // Mobile-specific navigation
    .mobile-nav-toggle {
        display: block;         // Show hamburger menu
    }
}
```

## Grid System

### Desktop-Optimized Grid

```html
<!-- Desktop: 4 columns, Tablet: 2 columns, Mobile: 1 column -->
<div class="row statistics-cards">
    <div class="col-xl-3 col-md-6 col-12 mb-4">
        <div class="card dashboard-card">...</div>
    </div>
    <div class="col-xl-3 col-md-6 col-12 mb-4">
        <div class="card dashboard-card">...</div>
    </div>
    <div class="col-xl-3 col-md-6 col-12 mb-4">
        <div class="card dashboard-card">...</div>
    </div>
    <div class="col-xl-3 col-md-6 col-12 mb-4">
        <div class="card dashboard-card">...</div>
    </div>
</div>
```

### Form Layout Patterns

```html
<!-- Desktop: 3 columns, Tablet: 2 columns, Mobile: 1 column -->
<div class="row">
    <div class="col-lg-4 col-md-6 col-12 mb-3">
        <label class="form-label">Field 1</label>
        <input type="text" class="form-control">
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-3">
        <label class="form-label">Field 2</label>
        <input type="text" class="form-control">
    </div>
    <div class="col-lg-4 col-12 mb-3">
        <label class="form-label">Field 3</label>
        <input type="text" class="form-control">
    </div>
</div>
```

## Component Responsive Behavior

### Navigation Components

#### Desktop Sidebar
```scss
.shise-sidebar {
    // Desktop: Fixed sidebar always visible
    @media (min-width: $desktop) {
        position: fixed;
        width: 240px;
        height: 100vh;
        transform: none;
    }
    
    // Tablet: Overlay sidebar
    @media (max-width: $desktop - 1px) and (min-width: $mobile-lg) {
        position: fixed;
        width: 280px;          // Slightly wider for touch
        height: 100vh;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        z-index: 1050;
        transform: translateX(-100%);
        
        &.show {
            transform: translateX(0);
        }
    }
    
    // Mobile: Full-screen overlay
    @media (max-width: $mobile-lg - 1px) {
        width: 100%;
        height: 100vh;
        background: white;
        z-index: 1060;
    }
}
```

#### Tab Navigation
```scss
.facility-tabs {
    .nav-tabs {
        // Desktop: Horizontal tabs
        @media (min-width: $tablet) {
            flex-direction: row;
            
            .nav-link {
                white-space: nowrap;
                padding: 0.75rem 1.5rem;
            }
        }
        
        // Mobile: Scrollable horizontal tabs
        @media (max-width: $tablet - 1px) {
            flex-wrap: nowrap;
            overflow-x: auto;
            
            .nav-link {
                flex-shrink: 0;
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }
    }
}
```

### Data Tables

#### Desktop Table
```scss
.data-table {
    // Desktop: Full table with all columns
    @media (min-width: $desktop) {
        width: 100%;
        
        th, td {
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }
        
        // Show all columns
        .d-none-desktop {
            display: none !important;
        }
    }
}
```

#### Tablet Table
```scss
@media (max-width: $desktop - 1px) and (min-width: $mobile-lg) {
    .data-table {
        // Hide less important columns
        .d-none-tablet {
            display: none !important;
        }
        
        th, td {
            padding: 0.5rem 0.75rem;
        }
    }
}
```

#### Mobile Table (Card Layout)
```scss
@media (max-width: $mobile-lg - 1px) {
    .data-table {
        // Convert to card layout
        thead {
            display: none;
        }
        
        tbody tr {
            display: block;
            border: 1px solid $gray-200;
            border-radius: 8px;
            margin-bottom: 1rem;
            padding: 1rem;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        td {
            display: block;
            text-align: left;
            border: none;
            padding: 0.25rem 0;
            
            &:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: $gray-700;
                display: inline-block;
                width: 120px;
            }
            
            &:first-child {
                font-size: 1.1rem;
                font-weight: 600;
                color: $primary;
                margin-bottom: 0.5rem;
                
                &:before {
                    display: none;
                }
            }
        }
    }
}
```

### Form Components

#### Responsive Form Layout
```scss
.facility-form {
    // Desktop: Multi-column layout
    @media (min-width: $desktop) {
        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }
        
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
    }
    
    // Tablet: Two-column layout
    @media (max-width: $desktop - 1px) and (min-width: $mobile-lg) {
        .form-row-3,
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
    }
    
    // Mobile: Single column
    @media (max-width: $mobile-lg - 1px) {
        .form-row-3,
        .form-row-2 {
            display: block;
            
            > * {
                margin-bottom: 1rem;
            }
        }
    }
}
```

#### Form Toggle System
```scss
.form-toggle-container {
    // Desktop: Inline editing
    @media (min-width: $desktop) {
        .form-display {
            min-height: 2.5rem;
            padding: 0.375rem 0;
            border-bottom: 1px transparent solid;
            transition: border-color 0.2s ease;
            
            &:hover {
                border-bottom-color: $gray-300;
                cursor: pointer;
            }
        }
    }
    
    // Mobile: Full-width editing
    @media (max-width: $mobile-lg - 1px) {
        .form-display {
            padding: 0.75rem;
            background: $gray-50;
            border-radius: 6px;
            margin-bottom: 0.5rem;
        }
        
        .form-edit {
            .form-control,
            .form-select {
                font-size: 16px;  // Prevent zoom on iOS
            }
        }
    }
}
```

### Card Components

#### Dashboard Cards
```scss
.dashboard-card {
    // Desktop: Hover effects and detailed layout
    @media (min-width: $desktop) {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        
        &:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .card-body {
            padding: 1.5rem;
        }
    }
    
    // Mobile: Simplified layout, no hover effects
    @media (max-width: $mobile-lg - 1px) {
        .card-body {
            padding: 1rem;
        }
        
        .row.no-gutters {
            align-items: center;
            
            .col-auto {
                margin-left: 1rem;
                
                i {
                    font-size: 1.5rem !important;
                }
            }
        }
    }
}
```

## Touch and Interaction

### Touch Target Sizes

Ensure all interactive elements meet minimum touch target requirements:

```scss
// Minimum touch target size: 44px × 44px
.btn {
    min-height: 44px;
    min-width: 44px;
    
    @media (max-width: $mobile-lg - 1px) {
        padding: 0.75rem 1.5rem;  // Larger padding on mobile
    }
}

.form-control,
.form-select {
    @media (max-width: $mobile-lg - 1px) {
        min-height: 44px;
        font-size: 16px;          // Prevent zoom on iOS
    }
}

// Tab navigation touch targets
.nav-tabs .nav-link {
    @media (max-width: $mobile-lg - 1px) {
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
```

### Hover States

Disable hover effects on touch devices:

```scss
.btn,
.card,
.nav-link {
    // Only apply hover effects on devices that support hover
    @media (hover: hover) {
        &:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
    }
    
    // Focus states for keyboard navigation
    &:focus-visible {
        outline: 2px solid $primary;
        outline-offset: 2px;
    }
}
```

## Performance Optimization

### Image Optimization

```html
<!-- Responsive images -->
<img src="logo-small.png" 
     srcset="logo-small.png 1x, logo-small@2x.png 2x"
     alt="Shise-Cal Logo"
     class="logo-image">

<!-- Different images for different screen sizes -->
<picture>
    <source media="(max-width: 768px)" srcset="mobile-hero.jpg">
    <source media="(max-width: 1200px)" srcset="tablet-hero.jpg">
    <img src="desktop-hero.jpg" alt="Hero image">
</picture>
```

### CSS Loading Strategy

```scss
// Critical CSS for above-the-fold content
@media (min-width: $desktop) {
    .shise-header,
    .shise-sidebar,
    .shise-content {
        // Critical desktop styles
    }
}

// Non-critical styles loaded separately
@media (max-width: $mobile-lg - 1px) {
    // Mobile-specific styles
    // Can be loaded asynchronously
}
```

## Testing Strategy

### Responsive Testing Checklist

#### Desktop Testing (1200px+)
- [ ] Sidebar is fixed and always visible
- [ ] Multi-column forms work correctly
- [ ] Data tables show all columns
- [ ] Hover effects work properly
- [ ] Keyboard navigation is smooth

#### Tablet Testing (768px - 1199px)
- [ ] Sidebar collapses and can be toggled
- [ ] Forms adapt to 2-column layout
- [ ] Tables hide less important columns
- [ ] Touch targets are adequate
- [ ] Content remains readable

#### Mobile Testing (< 768px)
- [ ] Navigation becomes full-screen overlay
- [ ] Forms use single-column layout
- [ ] Tables convert to card layout
- [ ] Touch targets are 44px minimum
- [ ] Text remains legible
- [ ] No horizontal scrolling

### Device Testing

#### Physical Device Testing
- **Desktop**: 1920×1080, 1366×768 monitors
- **Tablet**: iPad (1024×768), iPad Pro (1366×1024)
- **Mobile**: iPhone SE (375×667), iPhone 11 (414×896), Android phones

#### Browser Testing
- Chrome DevTools responsive mode
- Firefox responsive design mode
- Safari responsive design mode
- Real device testing when possible

### Performance Testing

```javascript
// Test responsive performance
describe('Responsive Performance', () => {
    test('Mobile layout loads quickly', async () => {
        await page.setViewport({ width: 375, height: 667 });
        const startTime = Date.now();
        await page.goto('/dashboard');
        const loadTime = Date.now() - startTime;
        expect(loadTime).toBeLessThan(3000); // 3 second target
    });
    
    test('Desktop layout is interactive quickly', async () => {
        await page.setViewport({ width: 1920, height: 1080 });
        await page.goto('/dashboard');
        await page.waitForSelector('.shise-sidebar', { visible: true });
        // Test interactivity
    });
});
```

## Implementation Guidelines

### CSS Organization

```scss
// Base styles (mobile-first for base elements)
.component {
    // Mobile styles (base)
    property: mobile-value;
    
    // Tablet adaptations
    @media (min-width: $mobile-lg) {
        property: tablet-value;
    }
    
    // Desktop styles (primary target)
    @media (min-width: $desktop) {
        property: desktop-value;
    }
    
    // Large desktop enhancements
    @media (min-width: $desktop-xl) {
        property: large-desktop-value;
    }
}
```

### JavaScript Responsive Handling

```javascript
// Responsive behavior management
class ResponsiveManager {
    constructor() {
        this.breakpoints = {
            mobile: 768,
            tablet: 992,
            desktop: 1200,
            desktopXl: 1400
        };
        
        this.init();
    }
    
    init() {
        window.addEventListener('resize', this.handleResize.bind(this));
        this.handleResize(); // Initial check
    }
    
    handleResize() {
        const width = window.innerWidth;
        
        if (width >= this.breakpoints.desktop) {
            this.enableDesktopFeatures();
        } else if (width >= this.breakpoints.tablet) {
            this.enableTabletFeatures();
        } else {
            this.enableMobileFeatures();
        }
    }
    
    enableDesktopFeatures() {
        // Enable desktop-specific JavaScript features
        document.body.classList.add('desktop-mode');
        document.body.classList.remove('tablet-mode', 'mobile-mode');
    }
    
    enableTabletFeatures() {
        document.body.classList.add('tablet-mode');
        document.body.classList.remove('desktop-mode', 'mobile-mode');
    }
    
    enableMobileFeatures() {
        document.body.classList.add('mobile-mode');
        document.body.classList.remove('desktop-mode', 'tablet-mode');
    }
}

// Initialize responsive manager
new ResponsiveManager();
```

## Best Practices

### Desktop-First Approach

1. **Design for desktop first** - Start with the most complex layout
2. **Progressive simplification** - Remove complexity as screen size decreases
3. **Maintain functionality** - Ensure all features work on all devices
4. **Optimize for primary users** - Desktop users are the primary audience

### Performance Considerations

1. **Minimize layout shifts** - Use consistent spacing and sizing
2. **Optimize images** - Use appropriate sizes for each breakpoint
3. **Lazy load non-critical content** - Prioritize above-the-fold content
4. **Test on real devices** - Emulators don't always match real performance

### Accessibility in Responsive Design

1. **Maintain focus order** - Ensure logical tab order on all screen sizes
2. **Keep touch targets large** - Minimum 44px × 44px on mobile
3. **Ensure readability** - Text should be legible at all sizes
4. **Test with assistive technologies** - Screen readers, voice control, etc.

By following this responsive design guide, the Shise-Cal facility management system provides an optimal experience across all devices while prioritizing the desktop workflow that facility managers rely on daily.