import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    define: {
        'process.env.APP_URL': JSON.stringify(process.env.APP_URL || 'http://localhost'),  // เพิ่มการตั้งค่าที่นี่
    }
});
