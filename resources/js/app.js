import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import App from './App.vue';

// Local dev safeguard: remove stale service workers/caches from other localhost apps.
if (typeof window !== 'undefined' && /^localhost$|^127\.0\.0\.1$/.test(window.location.hostname)) {
    window.addEventListener('load', async () => {
        if ('serviceWorker' in navigator) {
            try {
                const registrations = await navigator.serviceWorker.getRegistrations();
                await Promise.all(registrations.map((registration) => registration.unregister()));
            } catch (error) {
                console.warn('Service worker cleanup failed:', error);
            }
        }

        if ('caches' in window) {
            try {
                const cacheKeys = await caches.keys();
                await Promise.all(cacheKeys.map((cacheKey) => caches.delete(cacheKey)));
            } catch (error) {
                console.warn('Cache cleanup failed:', error);
            }
        }
    });
}

const app = createApp(App);
app.use(router);
app.mount('#app');
