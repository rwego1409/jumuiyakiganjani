import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            // This is important for ngrok
            publicPath: '/',
        }),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
        host: '0.0.0.0',
        cors: true,
        strictPort: true,
        port: 5173, // Default Vite port
    },
});