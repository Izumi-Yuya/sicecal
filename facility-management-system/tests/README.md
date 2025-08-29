# UI Design System Testing Framework

This directory contains comprehensive tests for the UI design system, covering accessibility, visual regression, performance, and unit testing.

## Test Structure

```
tests/
├── setup.js                    # Test environment setup
├── unit/                       # Unit tests for JavaScript utilities
│   ├── accessibility-utils.test.js
│   └── form-utilities.test.js
├── accessibility/              # Accessibility compliance tests
│   └── accessibility.test.js
├── visual/                     # Visual regression tests
│   ├── visual-regression.test.js
│   ├── screenshots/           # Generated screenshots
│   └── baselines/            # Baseline images for comparison
├── performance/               # Performance and optimization tests
│   └── performance.test.js
└── README.md                  # This file
```

## Running Tests

### All Tests
```bash
npm test
```

### Specific Test Categories
```bash
# Unit tests only
npm run test:unit

# Accessibility tests only
npm run test:accessibility

# Visual regression tests only
npm run test:visual

# Performance tests only
npm run test:performance

# Watch mode for development
npm run test:watch

# Coverage report
npm run test:coverage

# Interactive UI
npm run test:ui
```

## Test Categories

### 1. Unit Tests (`tests/unit/`)

Tests individual JavaScript utility classes and functions:

- **AccessibilityManager**: ARIA live regions, keyboard navigation, screen reader support
- **FormAccessibility**: Form validation, required field indicators, field descriptions
- **ComponentAccessibility**: Card, button, tab, and table enhancements
- **FormToggle**: Edit/display mode switching functionality
- **AutoCalculator**: Date calculations and field auto-population

### 2. Accessibility Tests (`tests/accessibility/`)

Ensures WCAG 2.1 AA compliance:

- **ARIA Roles and Labels**: Proper semantic markup
- **Keyboard Navigation**: Tab order, skip links, keyboard shortcuts
- **Screen Reader Support**: Screen reader only text, live regions
- **Form Accessibility**: Labels, descriptions, validation messages
- **Color Contrast**: Non-color dependent information conveyance
- **Focus Management**: Visible focus indicators

### 3. Visual Regression Tests (`tests/visual/`)

Captures and compares component screenshots:

- **Component Variations**: Buttons, forms, cards, alerts in different states
- **Responsive Layouts**: Mobile, tablet, desktop viewports
- **Accessibility Visual**: Focus indicators, high contrast mode
- **Cross-browser Consistency**: Chrome, Firefox, Safari, Edge

### 4. Performance Tests (`tests/performance/`)

Measures and validates performance metrics:

- **CSS Bundle Size**: Compiled stylesheet size optimization
- **Animation Performance**: Smooth 60fps animations
- **JavaScript Performance**: DOM query efficiency, event handling
- **Memory Usage**: Memory leak detection, garbage collection
- **Load Time**: Initial page load, CSS parsing time
- **Responsive Performance**: Layout calculation at different viewports

## Test Configuration

### Vitest Configuration (`vitest.config.js`)

```javascript
export default defineConfig({
  test: {
    environment: 'jsdom',
    setupFiles: ['./tests/setup.js'],
    globals: true,
    coverage: {
      provider: 'c8',
      reporter: ['text', 'json', 'html']
    }
  }
});
```

### Test Environment Setup (`tests/setup.js`)

- Configures jsdom environment
- Mocks Bootstrap components
- Sets up DOM structure for tests
- Provides cleanup between tests

## Writing New Tests

### Unit Test Example

```javascript
import { describe, it, expect, beforeEach } from 'vitest';
import { AccessibilityManager } from '@/accessibility-utils';

describe('AccessibilityManager', () => {
  let manager;

  beforeEach(() => {
    manager = new AccessibilityManager();
  });

  it('should announce messages to screen readers', () => {
    manager.announce('Test message');
    
    const liveRegion = document.getElementById('aria-live-polite');
    expect(liveRegion.textContent).toBe('Test message');
  });
});
```

### Accessibility Test Example

```javascript
import { getByRole, getByLabelText } from '@testing-library/dom';

it('should have proper form labels', () => {
  document.body.innerHTML = `
    <label for="test-input">Test Label</label>
    <input id="test-input" type="text" required>
  `;

  const input = getByLabelText(document.body, 'Test Label');
  expect(input).toBeTruthy();
  expect(input.hasAttribute('required')).toBe(true);
});
```

### Visual Regression Test Example

```javascript
it('should capture button variations', async () => {
  await page.setContent(buttonHTML);
  const screenshotPath = await takeScreenshot('buttons');
  const isMatch = compareWithBaseline(screenshotPath, 'buttons');
  
  expect(isMatch).toBe(true);
});
```

### Performance Test Example

```javascript
it('should have fast DOM queries', async () => {
  const queryTime = await page.evaluate(() => {
    const startTime = performance.now();
    document.querySelectorAll('.test-element');
    return performance.now() - startTime;
  });

  expect(queryTime).toBeLessThan(10);
});
```

## Continuous Integration

### GitHub Actions Example

```yaml
name: UI Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: actions/setup-node@v3
        with:
          node-version: '18'
      - run: npm install
      - run: npm run test:unit
      - run: npm run test:accessibility
      - run: npm run test:performance
```

## Test Coverage Goals

- **Unit Tests**: 90%+ coverage of JavaScript utilities
- **Accessibility**: 100% WCAG 2.1 AA compliance
- **Visual Regression**: All component states captured
- **Performance**: All metrics within acceptable thresholds

## Performance Thresholds

- **CSS Bundle**: < 100KB compressed
- **Animation**: 60fps (16.67ms per frame)
- **DOM Queries**: < 10ms for 1000 elements
- **Page Load**: < 3 seconds initial load
- **Layout Calculation**: < 20ms responsive layout

## Accessibility Standards

- **WCAG 2.1 Level AA**: Full compliance required
- **Color Contrast**: 4.5:1 minimum ratio
- **Keyboard Navigation**: All interactive elements accessible
- **Screen Reader**: Complete information available
- **Focus Management**: Visible focus indicators

## Browser Support

### Primary Support (Full Testing)
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Secondary Support (Basic Testing)
- Chrome 80+
- Firefox 78+
- Safari 13+
- Edge 80+

## Troubleshooting

### Common Issues

1. **Puppeteer Installation**: Ensure Chrome/Chromium is available
2. **jsdom Limitations**: Some CSS features not fully supported
3. **Async Tests**: Use proper async/await patterns
4. **Memory Leaks**: Clean up event listeners in tests

### Debug Mode

```bash
# Run tests with debug output
DEBUG=1 npm test

# Run specific test file
npx vitest tests/unit/accessibility-utils.test.js

# Run tests in browser (for visual debugging)
npm run test:ui
```

## Contributing

1. Write tests for new components/utilities
2. Ensure accessibility compliance
3. Add visual regression tests for UI changes
4. Verify performance impact
5. Update documentation

## Resources

- [Vitest Documentation](https://vitest.dev/)
- [Testing Library](https://testing-library.com/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Puppeteer API](https://pptr.dev/)
- [Web Performance Metrics](https://web.dev/metrics/)