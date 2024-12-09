import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { Modal, ModalLink, renderApp } from '@inertiaui/modal-vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { createApp, DefineComponent } from 'vue';
import 'vue3-carousel/dist/carousel.css';
import Vue3Toastify, { type ToastContainerOptions } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
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
        createApp({ render: renderApp(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .use(Vue3Toastify, {
                autoClose: 3000,
            } as ToastContainerOptions)

            .component('Modal', Modal)
            .component('ModalLink', ModalLink)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(cleanApp);
