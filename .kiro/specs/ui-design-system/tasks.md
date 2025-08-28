# Implementation Plan

- [x] 1. Set up design token system and SCSS architecture
  - Create centralized SCSS token files for colors, typography, spacing, and shadows
  - Establish SCSS file structure with tokens, base, components, and patterns directories
  - Configure Vite build system to compile the new SCSS architecture
  - _Requirements: 6.1, 6.2, 6.3, 6.4_

- [x] 2. Implement base design tokens
- [x] 2.1 Create color system tokens
  - Write SCSS variables for primary, secondary, semantic, and neutral color palettes
  - Define gradient variables for header and background usage
  - Create color utility classes for consistent color application
  - _Requirements: 1.1, 1.2, 1.3, 1.4_

- [x] 2.2 Implement typography system
  - Define font family variables for Japanese text support (Noto Sans JP, Hiragino Kaku Gothic ProN)
  - Create font size scale variables from xs (12px) to 3xl (30px)
  - Implement font weight variables and utility classes
  - _Requirements: 2.1, 2.2, 2.3_

- [x] 2.3 Create spacing and layout tokens
  - Define spacing scale variables based on 4px grid system
  - Create margin and padding utility classes
  - Implement border radius variables for consistent corner styling
  - _Requirements: 1.1, 1.2, 1.3, 1.4_

- [x] 2.4 Implement shadow system
  - Create box shadow variables for different elevation levels
  - Define shadow utility classes for cards and interactive elements
  - Implement hover state shadow transitions
  - _Requirements: 1.1, 1.2, 1.3, 1.4_

- [ ] 3. Create base component styles
- [ ] 3.1 Implement button component system
  - Write base button styles with consistent border radius and transitions
  - Create button size variants (sm, base, lg) with proper padding and font sizes
  - Implement button state styles (hover, active, disabled) with transform effects
  - Add button color variants using design token colors
  - _Requirements: 3.1, 3.2, 3.3, 4.1, 4.2_

- [ ] 3.2 Create form component styles
  - Implement form control base styles with consistent border and focus states
  - Create form label styles with proper typography and spacing
  - Add form validation styles (is-invalid, valid-feedback, invalid-feedback)
  - Implement form group spacing and layout patterns
  - _Requirements: 3.1, 3.2, 3.3, 3.4_

- [ ] 3.3 Implement card component system
  - Create base card styles with border, border radius, and shadow
  - Implement card hover effects with transform and shadow transitions
  - Add card header and body styling with consistent padding
  - Create card variant classes for different use cases
  - _Requirements: 2.1, 2.2, 2.3, 4.1, 4.2_

- [ ] 3.4 Create alert and notification system
  - Implement alert base styles with left border accent design
  - Create alert color variants (primary, success, warning, danger, info)
  - Add alert dismissible functionality styling
  - Implement notification positioning and animation styles
  - _Requirements: 4.1, 4.2, 4.3, 4.4_

- [ ] 4. Implement layout components
- [ ] 4.1 Update header component styling
  - Refactor existing header gradient background using design tokens
  - Implement consistent logo styling with fallback support
  - Update approver section button styling using new button system
  - Add responsive header behavior for desktop-first approach
  - _Requirements: 1.1, 1.2, 4.1, 4.2, 5.1, 5.2_

- [ ] 4.2 Enhance sidebar navigation component
  - Update sidebar styling using design tokens for colors and spacing
  - Implement navigation link hover and active states with consistent styling
  - Add smooth transitions for navigation state changes
  - Create responsive sidebar behavior (fixed desktop, collapsible tablet/mobile)
  - _Requirements: 1.1, 1.2, 4.1, 4.2, 5.1, 5.2_

- [ ] 4.3 Implement main content area layout
  - Create desktop-optimized content area with proper width calculations
  - Implement responsive content padding and margins
  - Add content area transitions for sidebar state changes
  - Create scroll behavior optimization for desktop usage
  - _Requirements: 5.1, 5.2, 5.3, 5.4_

- [ ] 5. Create facility form patterns
- [ ] 5.1 Implement tabbed interface styling
  - Create facility tab navigation styles with active state indicators
  - Implement tab content area styling with consistent padding
  - Add tab transition animations and fade effects
  - Create responsive tab behavior for different screen sizes
  - _Requirements: 2.1, 2.2, 2.3, 4.1, 4.2, 5.1, 5.2_

- [ ] 5.2 Create form display/edit toggle system
  - Implement form-display and form-edit CSS classes
  - Create JavaScript utility class for toggling between display and edit modes
  - Add smooth transitions between display and edit states
  - Implement "未設定" placeholder styling for empty fields
  - _Requirements: 3.1, 3.2, 3.3, 6.1, 6.2_

- [ ] 5.3 Implement auto-calculation field styling
  - Create text-info styling for auto-calculated fields with visual indicators
  - Add JavaScript utility for calculating operating years from opening date
  - Implement real-time calculation updates with visual feedback
  - Create consistent styling for calculated vs manual input fields
  - _Requirements: 3.1, 3.2, 3.3, 6.1, 6.2_

- [ ] 5.4 Create accordion and dropdown patterns
  - Implement accordion component styling for utility sections
  - Create dropdown menu styling with consistent borders and shadows
  - Add accordion expand/collapse animations
  - Implement keyboard navigation support for accordion components
  - _Requirements: 2.1, 2.2, 2.3, 4.1, 4.2_

- [ ] 6. Implement dashboard components
- [ ] 6.1 Create statistics card components
  - Implement dashboard card base styles with hover effects
  - Create border-left color variants for different statistics types
  - Add statistics card responsive layout for desktop-first approach
  - Implement card content typography and icon positioning
  - _Requirements: 2.1, 2.2, 2.3, 4.1, 4.2, 5.1, 5.2_

- [ ] 6.2 Implement welcome section styling
  - Create dashboard welcome card with gradient background
  - Implement user information layout with proper typography hierarchy
  - Add role badge styling with consistent colors
  - Create responsive welcome section layout for different screen sizes
  - _Requirements: 1.1, 1.2, 2.1, 2.2, 5.1, 5.2_

- [ ] 6.3 Create activity and notification components
  - Implement recent activities list styling with proper spacing
  - Create pending items component with consistent typography
  - Add notification alert styling with appropriate color coding
  - Implement quick actions button group styling
  - _Requirements: 2.1, 2.2, 2.3, 4.1, 4.2_

- [ ] 7. Implement responsive desktop-first system
- [ ] 7.1 Create desktop-optimized layouts
  - Implement desktop-first responsive breakpoints and media queries
  - Create multi-column form layouts optimized for desktop data entry
  - Add desktop-specific enhancements like keyboard shortcuts display
  - Implement enhanced tooltips and hover states for desktop usage
  - _Requirements: 5.1, 5.2, 5.3, 5.4_

- [ ] 7.2 Implement data table responsive patterns
  - Create desktop-optimized data table styling with full column visibility
  - Implement horizontal scrolling for very wide tables on desktop
  - Add tablet column hiding patterns for less important data
  - Create mobile card-based layout for complex table data
  - _Requirements: 5.1, 5.2, 5.3, 5.4_

- [ ] 7.3 Add desktop interaction enhancements
  - Implement enhanced hover states and transitions for desktop users
  - Create keyboard navigation improvements for form interactions
  - Add desktop-specific loading states and progress indicators
  - Implement smooth scrolling and focus management for desktop usage
  - _Requirements: 4.1, 4.2, 4.3, 4.4, 5.1, 5.2_

- [ ] 8. Create JavaScript utilities and interactions
- [ ] 8.1 Implement form interaction utilities
  - Create FormToggle class for managing display/edit mode switching
  - Implement AutoCalculator utility for real-time field calculations
  - Add form validation enhancement utilities
  - Create smooth transition utilities for form state changes
  - _Requirements: 3.1, 3.2, 3.3, 6.1, 6.2_

- [ ] 8.2 Create component state management
  - Implement theme configuration object with design token values
  - Create component initialization utilities for consistent behavior
  - Add event handling utilities for interactive components
  - Implement accessibility enhancement utilities (focus management, ARIA attributes)
  - _Requirements: 4.1, 4.2, 4.3, 4.4, 6.1, 6.2_

- [ ] 9. Implement accessibility and testing utilities
- [ ] 9.1 Add accessibility enhancements
  - Implement proper focus indicators for all interactive elements
  - Add ARIA labels and descriptions for complex components
  - Create keyboard navigation support for custom components
  - Implement screen reader friendly text for visual indicators
  - _Requirements: 4.1, 4.2, 4.3, 4.4_

- [ ] 9.2 Create component testing framework
  - Write unit tests for JavaScript utility classes
  - Create visual regression test setup for component consistency
  - Implement accessibility testing utilities
  - Add performance testing for CSS bundle size and animation performance
  - _Requirements: 6.1, 6.2, 6.3, 6.4_

- [ ] 10. Integration and documentation
- [ ] 10.1 Integrate design system with existing views
  - Update existing Blade templates to use new design system classes
  - Replace custom CSS with design system components
  - Test integration with existing facility management functionality
  - Ensure backward compatibility with current features
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 2.1, 2.2, 2.3, 3.1, 3.2, 3.3, 3.4_

- [ ] 10.2 Create design system documentation
  - Write component usage documentation with code examples
  - Create design token reference guide
  - Document responsive behavior and breakpoint usage
  - Add accessibility guidelines and best practices documentation
  - _Requirements: 6.1, 6.2, 6.3, 6.4_