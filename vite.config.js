import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server:{
        hmr:{
            host:'ai.zufedfc.edu.cn',
            protocol: 'wss',
            port:443
        },

        host:'ai.zufedfc.edu.cn',
        https: true,
        port:5173,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // resolve:{
    //     alias:{
    //         '@modules/' : '/node_modules/'
    //     }
    // }
});
