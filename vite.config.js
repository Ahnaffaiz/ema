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
                'app/**/*.php',
                'routes/**/*.php',
                'public/assets/scss/**/*.scss'
            ],
            detectTls: false,
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
        {
            name: 'laravel-hot-reload',
            handleHotUpdate({ file, server }) {
                if (file.includes('.blade.php') || file.includes('.scss') || file.includes('.css')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*'
                    });
                }
            }
        },
        {
            name: 'suppress-asset-warnings',
            configureServer(server) {
                const originalWarn = console.warn;
                console.warn = (...args) => {
                    const message = args.join(' ');
                    if (message.includes('/assets/fonts/') ||
                        message.includes('/assets/images/') ||
                        message.includes("didn't resolve at build time")) {
                        return; // Suppress these warnings
                    }
                    originalWarn.apply(console, args);
                };
            },
            buildStart() {
                const originalWarn = this.warn;
                this.warn = (warning) => {
                    if (typeof warning === 'string') {
                        if (warning.includes('/assets/fonts/') ||
                            warning.includes('/assets/images/') ||
                            warning.includes("didn't resolve at build time")) {
                            return;
                        }
                    } else if (warning.message) {
                        if (warning.message.includes('/assets/fonts/') ||
                            warning.message.includes('/assets/images/') ||
                            warning.message.includes("didn't resolve at build time")) {
                            return;
                        }
                    }
                    originalWarn.call(this, warning);
                };
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
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['import', 'global-builtin', 'color-4-api', 'legacy-js-api'],
                quietDeps: true
            }
        }
    },
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
            },
            onwarn: (warning, warn) => {
                // Suppress warnings about unresolved assets that exist at runtime
                if (warning.code === 'UNRESOLVED_IMPORT' &&
                    (warning.message.includes('/assets/fonts/') ||
                     warning.message.includes('/assets/images/'))) {
                    return;
                }
                warn(warning);
            }
        }
    },
    server: {
        hmr: {
            host: 'localhost',
            port: 5173,
        },
        host: true,
        port: 5173,
        watch: {
            usePolling: true,
            interval: 100,
        }
    },
    resolve: {
        alias: {
            '@': '/resources',
        }
    }
});
