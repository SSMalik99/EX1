import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // input: ['resources/css/app.css', 'resources/js/app.js'], // good for dev 
            input:['resources/js/app.js'], // for production import css from your js file
            refresh: true,
        }),
    ],
});
