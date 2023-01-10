import {defineConfig} from 'vite';
import manifestSRI from 'vite-plugin-manifest-sri';
import path from 'node:path';
import glob from 'glob';
import viteCompression from 'vite-plugin-compression';
import ViteRestart from 'vite-plugin-restart';
import { fileURLToPath } from 'node:url';

const pagesScripts = Object.fromEntries(
  glob.sync('src/js/pages/**/*.ts').map(file => [
    path.relative('src', file.slice(0, file.length - path.extname(file).length)),
    fileURLToPath(new URL(file, import.meta.url))
  ])
);

// https://vitejs.dev/config/
export default defineConfig(({command}) => ({
  base: command === 'serve' ? '' : '/dist/',
  build: {
    commonjsOptions: {
      transformMixedEsModules: true,
    },
    manifest: true,
    outDir: 'web/dist/',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        app: 'src/js/app.ts',
        ...pagesScripts
      },
      output: {
        sourcemap: true
      },
    },
  },
  plugins: [
/*    manifestSRI(),
    viteCompression({
      filter: /\.(js|mjs|json|css|map)$/i
    }),*/
    ViteRestart({
      reload: [
        './templates/**/*',
      ],
    }),
  ],
  // publicDir: path.resolve(__dirname, 'src/public'),
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
      '@css': path.resolve(__dirname, 'src/css'),
      '@js': path.resolve(__dirname, 'src/js'),
    },
  },
  server: {
    host: '0.0.0.0',
    port: 3000,
    strictPort: true,
  },
}));
