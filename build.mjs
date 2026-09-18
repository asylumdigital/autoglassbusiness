// Runs the theme build as one stylesheet pass plus one pass per JS entry.
//
// Rollup rejects output.format 'iife' for a build with more than one input, so
// each JS entry needs a pass of its own to get the wrapper. vite.config.js
// reads VITE_ENTRY to decide which entry a pass is for; unset means the
// stylesheets. Arguments are handed straight to vite (--mode=prod, --watch).

import { readFileSync, rmSync } from 'node:fs'
import { spawn } from 'node:child_process'
import { createRequire } from 'node:module'
import { fileURLToPath } from 'node:url'
import { dirname, join } from 'node:path'

const require = createRequire(import.meta.url)
// vite doesn't export its bin, so go via the manifest it does export.
const manifest = require.resolve('vite/package.json')
const vite = join(dirname(manifest), JSON.parse(readFileSync(manifest, 'utf8')).bin.vite)
const root = dirname(fileURLToPath(import.meta.url))

// null is the stylesheet pass; it also copies the static asset folders.
const passes = [null, 'main', 'adminJs', 'tinymceListStyles', 'blockListStyles']

const args = process.argv.slice(2)
const watch = args.includes('--watch')

function start(entry) {
    const env = { ...process.env }
    if (entry) {
        env.VITE_ENTRY = entry
    } else {
        delete env.VITE_ENTRY
    }

    return spawn(process.execPath, [vite, 'build', ...args], {
        cwd: root,
        env,
        stdio: 'inherit',
    })
}

function run(entry) {
    return new Promise((resolve, reject) => {
        const child = start(entry)
        child.on('error', reject)
        child.on('exit', (code, signal) => {
            if (code === 0) {
                resolve()
            } else {
                reject(new Error(`vite build${entry ? ` (${entry})` : ''} exited with ${signal || code}`))
            }
        })
    })
}

// Every pass runs with emptyOutDir off so it can't wipe the others' output,
// which leaves clearing dist to this script.
rmSync(join(root, 'dist'), { recursive: true, force: true })

if (watch) {
    // Watchers stay in the foreground, so they have to run side by side.
    const children = passes.map(start)

    for (const signal of ['SIGINT', 'SIGTERM']) {
        process.on(signal, () => {
            for (const child of children) {
                child.kill(signal)
            }
        })
    }

    // One watcher falling over shouldn't leave the rest running silently.
    for (const child of children) {
        child.on('exit', (code, signal) => {
            if (code !== 0 && !signal) {
                process.exitCode = code ?? 1
                for (const other of children) {
                    other.kill('SIGTERM')
                }
            }
        })
    }
} else {
    for (const entry of passes) {
        await run(entry)
    }
}
