import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: '192.168.10.59', // Use your local IP here
    //     port: 5173,             // Optional: set a custom port if needed
    //     strictPort: true,       // Prevent fallback to a different port
    //     hmr: {
    //         host: '192.168.10.59', // Needed for hot module replacement
    //     },
    // },
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
