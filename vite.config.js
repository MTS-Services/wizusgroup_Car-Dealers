import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/css/frontend.css',
                'resources/js/app.js',
                'resources/js/frontend/frontend.js',
            ],
            refresh: true,
        }),
    ],
});
