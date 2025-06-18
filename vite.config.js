import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // untuk menerapkan css di android
    // server: {
    //     // Server Vite akan mendengarkan koneksi dari semua jaringan
    //     host: '0.0.0.0', 

    //     // INI BAGIAN PENTINGNYA
    //     // Beritahu browser untuk menyambung ke IP Address spesifik ini
    //     hmr: {
    //         host: '192.168.29.75', // <-- GANTI DENGAN IP ANDA
    //     },
    //             cors: true, // <-- TAMBAHKAN BARIS INI

    // },
});
