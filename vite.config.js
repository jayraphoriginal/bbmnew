import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';
// import vue from '@vitejs/plugin-vue';
import postcss from './postcss.config.js'
export default defineConfig({
    css: {
        postcss,
      },
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
        
        // react(),
        // vue({
        //     template: {
        //         transformAssetUrls: {
        //             base: null,
        //             includeAbsolute: false,
        //         },
        //     },
        // }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    }
    
});