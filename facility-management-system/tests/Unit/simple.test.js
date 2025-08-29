import { describe, it, expect } from 'vitest';

describe('Simple Test', () => {
    it('should work', () => {
        expect(1 + 1).toBe(2);
    });

    it('should have DOM available', () => {
        document.body.innerHTML = '<div id="test">Hello World</div>';
        const element = document.getElementById('test');
        expect(element).toBeTruthy();
        expect(element.textContent).toBe('Hello World');
    });

    it('should support CSS classes', () => {
        document.body.innerHTML = '<button class="btn btn-primary">Test Button</button>';
        const button = document.querySelector('.btn');
        expect(button).toBeTruthy();
        expect(button.classList.contains('btn-primary')).toBe(true);
    });
});