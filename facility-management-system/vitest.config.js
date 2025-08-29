/// <reference types="vitest" />
import { defineConfig } from 'vite';

export default defineConfig({
    test: {
        environment: 'jsdom',
        setupFiles: ['./tests/setup.js'],
        globals: true,
        coverage: {
            provider: 'c8',
            reporter: ['text', 'json', 'html'],
            exclude: [
                'node_modules/',
                'tests/',
                'vendor/',
                'bootstrap/',
                'public/build/',
                '**/*.config.js'
            ]
        }
    }
});