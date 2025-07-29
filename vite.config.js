import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/homepage.css',
                'resources/css/home.css',
                'resources/css/login_register.css',
                'resources/js/pages/calculator.js',
                'resources/js/pages/calculatorBukanPegawai.js',
                'resources/js/pages/calculatorPegawaiTidakTetap.js'],
            refresh: true,
        }),
    ],
});
