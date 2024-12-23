import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';
import { PageProps as AppPageProps } from './';

declare global {
    interface Window {
        axios: AxiosInstance;
        Echo: Echo;
        Pusher: typeof Pusher;
    }

    let route: typeof ziggyRoute;

    interface Filters {
        [key: string]: string;
    }

    interface Options {
        [key: string]: string;
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module 'vue3-lazyload';
declare module 'vue3-toastify';
declare module '@vueuse/core';
declare module 'pinia';
declare module 'pinia-plugin-persistedstate';
declare module 'v-lazy-image';
declare module '@inertiaui/modal-vue';

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
