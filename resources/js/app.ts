import 'vue3-carousel/dist/carousel.css';
import 'vue3-toastify/dist/index.css';
import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { createApp, DefineComponent, h } from 'vue';
import VueApexCharts from 'vue3-apexcharts';
import Vue3Toastify from 'vue3-toastify';
import { ZiggyVue } from 'ziggy-js';

const pinia = createPinia().use(piniaPluginPersistedstate);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const cleanApp = (): void => {
    const appElement = document.getElementById('app');
    if (appElement) {
        appElement.removeAttribute('data-page');
    }
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .use(Vue3Toastify)
            .use(VueApexCharts)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(cleanApp);
