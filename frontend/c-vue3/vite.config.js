import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
  plugins: [vue()],
  base: '/c/',
  server: {
    port: 5173,
    proxy: {
      '/view': 'http://127.0.0.1:9501',
      '/api': 'http://127.0.0.1:9501',
      '/common': 'http://127.0.0.1:9501'
    }
  },
  build: { outDir: '../dist-c-view', emptyOutDir: true }
});
