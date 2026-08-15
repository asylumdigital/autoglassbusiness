import { defineConfig } from 'vite'
import { cpSync, existsSync } from 'node:fs'
import tailwindcss from '@tailwindcss/postcss'
import postcssNested from 'postcss-nested';

// Copy static asset folders (unreferenced images/fonts) into dist/ on build.
function copyStaticAssets(dirs) {
    return {
        name: 'copy-static-assets',
        apply: 'build',
        writeBundle(options) {
            const outDir = options.dir || 'dist'
            for (const { from, to } of dirs) {
                if (existsSync(from)) {
                    cpSync(from, `${outDir}/${to}`, { recursive: true })
                }
            }
        },
    }
}

export default defineConfig(({ command, mode, isSsrBuild }) => ({
    // Relative, so CSS url() refs resolve against the stylesheet rather than the domain root.
    base: './',
    css: {
        postcss: {
            plugins: [
                postcssNested,  // flatten Sass-style BEM nesting first (&__x -> .block__x)
                tailwindcss(),  // then Tailwind processes @import/@apply/@utility
            ],
        },
    },
    plugins: [
        copyStaticAssets([
            { from: 'app/Resources/assets/img', to: 'img' },
            { from: 'app/Resources/assets/fonts', to: 'fonts' },
        ]),
    ],
    build: {
        outDir: 'dist',
        minify: mode == 'prod',
        cssMinify: mode == 'prod',
        manifest: false,
        rollupOptions: {
            input: {
                app: './app/Resources/assets/css/app.css',
                carousel: './app/Resources/assets/css/components/carousel.css',
                marquee: './app/Resources/assets/css/components/marquee.css',
                main: './app/Resources/assets/js/public/main.js',
                adminCss: './app/Resources/assets/scss/admin/admin.scss',
                adminJs: './app/Resources/assets/js/admin/admin.js',
                tinymceListStyles: './app/Resources/assets/js/admin/tinymce-list-styles.js',
                blockListStyles: './app/Resources/assets/js/admin/block-list-styles.js',
            },
            output: {
                assetFileNames: (assetInfo) => {

                    const { originalFileName } = assetInfo;

                    const ext = assetInfo.name.split('.').pop()
                    let name = assetInfo.name.split('.').slice(0, -1).join('.')
                    name = name.replace(/(Css|Js)$/, '')

                    if (/png|jpe?g|gif|svg|webp/.test(ext)) {
                        // Keep the source subfolder so the emit lands on the copied file, not beside it
                        const rel = originalFileName?.replace(/^app\/Resources\/assets\/img\//, '')
                        return rel ? `img/${rel}` : `img/${name}.${ext}`
                    } else if (/woff|woff2|eot|ttf|otf/.test(ext)) {
                        return `fonts/${name}.${ext}`
                    } else if (ext === 'css') {
                        return `css/${name}.css`
                    }
                    return `${name}.${ext}`
                },
                entryFileNames: (chunkInfo) => {
                    let basename = chunkInfo.facadeModuleId || ''
                    basename = basename.split('/').pop()?.replace(/\.[^.]+$/, '') || chunkInfo.name
                    basename = basename.replace(/(Css|Js)$/, '')

                    // Route CSS entries to css/ instead of js/
                    const isCss = chunkInfo.facadeModuleId?.includes('.scss') || chunkInfo.facadeModuleId?.includes('.css')
                    if (isCss) {
                        return `css/${basename}.css`
                    }
                    return `js/${basename}.js`
                },
            },
        },
    },
}))

