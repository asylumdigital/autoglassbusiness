import { defineConfig } from 'vite'
import { cpSync, existsSync } from 'node:fs'
import tailwindcss from '@tailwindcss/postcss'
import postcssNested from 'postcss-nested';

// Rollup only emits the IIFE format for a single-input build, so each JS entry
// gets its own pass. build.mjs drives them and names the current one in
// VITE_ENTRY; stylesheets have no such restriction and stay in one pass.
const jsEntries = {
    main: './app/Resources/assets/js/public/main.js',
    adminJs: './app/Resources/assets/js/admin/admin.js',
    tinymceListStyles: './app/Resources/assets/js/admin/tinymce-list-styles.js',
    blockListStyles: './app/Resources/assets/js/admin/block-list-styles.js',
}

const cssEntries = {
    app: './app/Resources/assets/css/app.css',
    editor: './app/Resources/assets/css/editor.css',
    carousel: './app/Resources/assets/css/components/carousel.css',
    marquee: './app/Resources/assets/css/components/marquee.css',
    adminCss: './app/Resources/assets/scss/admin/admin.scss',
}

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

export default defineConfig(({ command, mode, isSsrBuild }) => {
    const entry = process.env.VITE_ENTRY
    const isJs = Boolean(entry)

    if (isJs && !(entry in jsEntries)) {
        throw new Error(`VITE_ENTRY "${entry}" is not a JS entry: ${Object.keys(jsEntries).join(', ')}`)
    }

    return {
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
        // Static assets are copied once, on the stylesheet pass.
        plugins: isJs ? [] : [
            copyStaticAssets([
                { from: 'app/Resources/assets/img', to: 'img' },
                { from: 'app/Resources/assets/fonts', to: 'fonts' },
            ]),
        ],
        build: {
            outDir: 'dist',
            // build.mjs clears dist up front; a pass must not wipe its siblings.
            emptyOutDir: false,
            minify: mode == 'prod',
            cssMinify: mode == 'prod',
            manifest: false,
            rollupOptions: {
                input: isJs ? { [entry]: jsEntries[entry] } : cssEntries,
                output: {
                    // Wraps each entry so its top-level declarations stay off window.
                    format: isJs ? 'iife' : 'es',
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
    }
})
