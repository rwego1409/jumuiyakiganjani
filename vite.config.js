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
        }),

        
    ],

    // server: {
    //     // Your existing server config, if any
    //     allowedHosts: [
    //       'localhost',
    //     //   '20b2-196-249-93-234.ngrok-free.app',
    //       '.ngrok-free.app', // This will allow any ngrok-free.app subdomain
    //     ]
    //   },
});


