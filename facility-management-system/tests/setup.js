import '@testing-library/jest-dom';
import { beforeEach, afterEach } from 'vitest';

// Mock Bootstrap
global.bootstrap = {
    Tooltip: class {
        constructor() { }
        dispose() { }
    },
    Popover: class {
        constructor() { }
        dispose() { }
    },
    Dropdown: class {
        constructor() { }
        dispose() { }
    },
    Modal: class {
        constructor() { }
        show() { }
        hide() { }
        dispose() { }
    }
};

// Setup DOM before each test
beforeEach(() => {
    document.body.innerHTML = '';

    // Add basic HTML structure
    document.body.innerHTML = `
    <div id="app">
      <header class="shise-header"></header>
      <nav class="shise-sidebar" id="sidebar"></nav>
      <main class="shise-content" id="main-content"></main>
    </div>
  `;
});

// Cleanup after each test
afterEach(() => {
    document.body.innerHTML = '';

    // Clear any global state
    if (window.accessibilityManager) {
        delete window.accessibilityManager;
    }
    if (window.formAccessibility) {
        delete window.formAccessibility;
    }
    if (window.componentAccessibility) {
        delete window.componentAccessibility;
    }
});