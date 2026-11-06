import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // perpus.css = CSS lama proyek perpustakaan, app.css = Tailwind milik Breeze
            input: ['resources/css/app.css', 'resources/css/perpus.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
