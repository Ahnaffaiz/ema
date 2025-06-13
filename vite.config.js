import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import copy from 'rollup-plugin-copy';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'public/assets/scss/icons.scss',
                'public/assets/scss/tailwind.scss'
            ],
            refresh: [
                'resources/**/*.php',
                'resources/**/*.blade.php',
                'resources/**/*.js',
                'resources/**/*.vue',
                'resources/**/*.css',
                'resources/**/*.scss',
                'app/Http/Livewire/**',
                'app/View/Components/**',
                'routes/**/*.php'
            ],
        }),
        {
            name: 'compile-scss-to-css',
            apply: 'build',
            generateBundle(outputOptions, bundle) {
                // This ensures output CSS files go to public/assets/css directory
                Object.keys(bundle).forEach(key => {
                    const asset = bundle[key];
                    if (asset.fileName.endsWith('.css')) {
                        if (asset.fileName.includes('icons')) {
                            asset.fileName = 'assets/css/icons.css';
                        } else if (asset.fileName.includes('tailwind')) {
                            asset.fileName = 'assets/css/tailwind.css';
                        }
                    }
                });
            }
        },
        copy({
            targets: [
                {
                    src: 'node_modules/swiper/swiper-bundle.css',
                    dest: 'public/assets/css'
                }
            ],
            hook: 'buildEnd'
        })
    ],
    build: {
        outDir: 'public',
        emptyOutDir: false,
        assetsDir: '',
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'assets/css/[name][extname]';
                    }
                    return 'assets/build/[name]-[hash][extname]';
                },
                entryFileNames: 'assets/build/[name]-[hash].js',
                chunkFileNames: 'assets/build/[name]-[hash].js',
            }
        }
    },
    server: {
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
            interval: 1000,
        }
    },
    resolve: {
        alias: {
            '@': '/resources',
        }
    }
});
