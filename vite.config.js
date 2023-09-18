import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from '@rollup/plugin-inject';

export default defineConfig({
    plugins: [
        inject({
            jQuery: 'jquery',
            $: 'jquery',
            include: [
                '**/trumbowyg/**/*',
            ],
        }),
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/styl/flatpickr.styl',
            ],
            refresh: true,
        }),
    ],
});
