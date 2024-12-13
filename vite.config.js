import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import * as path from 'node:path';
import { defineConfig } from 'vite';
import vueDevTools from 'vite-plugin-vue-devtools';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vueDevTools({ appendTo: 'app.ts' }),
    ],
    resolve: {
        alias: {
            'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
        },
    },
    optimizeDeps: {
        include: ['vue3-apexcharts'],
    },
});
