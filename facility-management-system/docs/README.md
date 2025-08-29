# Shise-Cal Design System Documentation

Welcome to the comprehensive documentation for the Shise-Cal Design System. This documentation provides everything you need to understand, implement, and maintain the UI design system for the facility management application.

## 📚 Documentation Overview

### [Design System Guide](design-system.md)
The complete guide to the Shise-Cal Design System, including:
- Design tokens (colors, typography, spacing, shadows)
- Component architecture and usage
- Layout patterns and structures
- JavaScript integration and utilities
- File structure and organization

### [Component Reference](component-reference.md)
Detailed reference for all design system components:
- Buttons and form controls
- Cards and navigation elements
- Data tables and layouts
- Interactive components
- Utility classes and helpers

### [Accessibility Guidelines](accessibility-guidelines.md)
Comprehensive accessibility standards and implementation:
- WCAG 2.1 compliance guidelines
- Color contrast and visual design
- Keyboard navigation and focus management
- Screen reader support and ARIA implementation
- Testing strategies and checklists

### [Responsive Design Guide](responsive-design-guide.md)
Desktop-first responsive design approach:
- Breakpoint system and target devices
- Layout patterns for different screen sizes
- Component responsive behavior
- Touch interaction and performance optimization
- Testing strategies across devices

## 🚀 Quick Start

### For Developers

1. **Include the design system in your Blade templates:**
   ```php
   @extends('layouts.app')
   
   @section('content')
   <div class="card">
       <div class="card-header">
           <h5 class="card-title mb-0">Your Content</h5>
       </div>
       <div class="card-body">
           <!-- Your content here -->
       </div>
   </div>
   @endsection
   ```

2. **Use design system classes:**
   ```html
   <button class="btn btn-primary">
       <i class="bi bi-check-circle me-2"></i>Save
   </button>
   ```

3. **Implement form toggle functionality:**
   ```html
   <div class="form-toggle-container">
       <label class="form-label">Field Label</label>
       <div class="form-display">Display Value</div>
       <div class="form-edit">
           <input type="text" class="form-control" name="field_name">
       </div>
   </div>
   ```

### For Designers

1. **Use the design tokens** defined in the system
2. **Follow the component patterns** for consistency
3. **Consider accessibility** from the design phase
4. **Design desktop-first** with mobile adaptations

## 🎨 Design Tokens

### Colors
- **Primary**: #00B4E3 (Cyan)
- **Secondary**: #F27CA6 (Pink)
- **Success**: #198754 (Green)
- **Warning**: #ffc107 (Yellow)
- **Danger**: #dc3545 (Red)
- **Info**: #0dcaf0 (Light Blue)

### Typography
- **Base Font**: Noto Sans JP, Hiragino Kaku Gothic ProN, sans-serif
- **Heading Font**: Roboto, Noto Sans JP, sans-serif
- **Font Sizes**: 12px - 30px scale
- **Font Weights**: 400, 500, 600, 700

### Spacing
- **Base Unit**: 16px (1rem)
- **Scale**: 4px, 8px, 12px, 16px, 20px, 24px, 32px, 40px, 48px, 64px

## 🧩 Key Components

### Layout Components
- **Header**: Fixed header with logo and user controls
- **Sidebar**: Responsive navigation sidebar
- **Main Content**: Flexible content area
- **Cards**: Consistent card layouts

### Form Components
- **Form Controls**: Inputs, selects, textareas
- **Form Toggle**: Display/edit mode switching
- **Validation**: Error and success states
- **Auto-calculation**: Dynamic field calculations

### Navigation Components
- **Sidebar Navigation**: Role-based menu system
- **Tab Navigation**: Facility information tabs
- **Breadcrumbs**: Page hierarchy navigation

### Data Components
- **Data Tables**: Responsive table layouts
- **Statistics Cards**: Dashboard metrics display
- **Alerts**: System notifications and messages

## 📱 Responsive Approach

The design system uses a **desktop-first** approach:

### Breakpoints
- **Desktop XL**: 1400px+ (Large desktop)
- **Desktop**: 1200px+ (Standard desktop - primary target)
- **Tablet**: 992px+ (Tablet landscape)
- **Mobile Large**: 768px+ (Tablet portrait)
- **Mobile**: 576px+ (Mobile landscape)
- **Mobile Small**: 480px+ (Mobile portrait)

### Layout Behavior
- **Desktop**: Fixed sidebar, multi-column forms, full data tables
- **Tablet**: Collapsible sidebar, 2-column forms, responsive tables
- **Mobile**: Overlay navigation, single-column forms, card-based tables

## ♿ Accessibility Features

### Built-in Accessibility
- **WCAG 2.1 AA compliance** for color contrast
- **Keyboard navigation** support throughout
- **Screen reader** optimized markup
- **Focus management** for interactive elements
- **ARIA labels** and descriptions

### Testing Tools
- Automated testing with axe-core
- Manual testing checklists
- Screen reader compatibility
- Keyboard navigation validation

## 🛠 Development Workflow

### File Structure
```
resources/sass/
├── tokens/              # Design variables
├── base/               # Base element styles
├── components/         # Component styles
├── patterns/          # Layout patterns
├── utilities/         # Utility classes
└── app.scss          # Main entry point
```

### Build Process
1. SCSS compilation with Vite
2. Design token integration
3. Component style generation
4. Utility class creation

### JavaScript Integration
- Form toggle functionality
- Auto-calculation utilities
- Component state management
- Accessibility enhancements

## 📋 Implementation Checklist

### For New Components
- [ ] Use design tokens for colors, spacing, typography
- [ ] Follow responsive design patterns
- [ ] Include proper ARIA labels and roles
- [ ] Test keyboard navigation
- [ ] Validate color contrast
- [ ] Test with screen readers
- [ ] Document usage examples

### For New Pages
- [ ] Use semantic HTML structure
- [ ] Implement proper heading hierarchy
- [ ] Include skip links for accessibility
- [ ] Follow layout patterns
- [ ] Test responsive behavior
- [ ] Validate form accessibility

## 🧪 Testing Guidelines

### Automated Testing
```javascript
// Accessibility testing
describe('Component Accessibility', () => {
    test('should be accessible', async () => {
        const results = await axe.run(component);
        expect(results.violations).toHaveLength(0);
    });
});

// Responsive testing
describe('Responsive Behavior', () => {
    test('should adapt to mobile', async () => {
        await page.setViewport({ width: 375, height: 667 });
        // Test mobile layout
    });
});
```

### Manual Testing
- Cross-browser compatibility
- Device testing (desktop, tablet, mobile)
- Screen reader testing (NVDA, JAWS, VoiceOver)
- Keyboard navigation testing
- Color contrast validation

## 📖 Usage Examples

### Dashboard Statistics
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

### Facility Form with Toggle
```html
<form data-enhanced-validation>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-toggle-container">
                <label class="form-label">Facility Name</label>
                <div class="form-display">Current Facility Name</div>
                <div class="form-edit">
                    <input type="text" class="form-control" name="facility_name">
                </div>
            </div>
        </div>
    </div>
</form>
```

### Responsive Data Table
```html
<div class="table-responsive">
    <table class="table data-table table-hover">
        <thead class="table-light">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th class="d-none-tablet">Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Code">FAC001</td>
                <td data-label="Name">Facility Name</td>
                <td data-label="Details" class="d-none-tablet">Additional info</td>
            </tr>
        </tbody>
    </table>
</div>
```

## 🔧 Customization

### Extending the Design System

1. **Add new design tokens** in the tokens directory
2. **Create new components** following the established patterns
3. **Document new components** with usage examples
4. **Test thoroughly** for accessibility and responsiveness

### Theme Customization
```scss
// Override design tokens
$primary: #your-brand-color;
$font-family-base: 'Your-Font', sans-serif;

// Import the design system
@import 'design-system/app';
```

## 📞 Support and Contribution

### Getting Help
- Review the documentation thoroughly
- Check the component reference for usage examples
- Test with the provided accessibility guidelines
- Follow the responsive design patterns

### Contributing
- Follow the established patterns and conventions
- Include proper documentation for new components
- Test accessibility and responsive behavior
- Update relevant documentation files

## 📄 License and Credits

This design system is built for the Shise-Cal facility management system and incorporates:
- Bootstrap 5.3.x framework
- Bootstrap Icons
- Noto Sans JP and Roboto fonts
- Custom SCSS architecture and components

---

For detailed information on any aspect of the design system, please refer to the specific documentation files linked above. Each guide provides comprehensive coverage of its respective topic with practical examples and implementation details.