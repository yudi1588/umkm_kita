import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/styleheader.css',
                'resources/css/stylefooter.css',
                'resources/css/stylehome.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
