import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Mungkin sudah ada
                'resources/js/app.js',   // Mungkin sudah ada
                'resources/css/filament.css'
            ],
            refresh: true,
        }),
    ],
});
