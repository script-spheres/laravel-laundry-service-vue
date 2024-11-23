import { defineStore } from 'pinia';
import { ref } from 'vue';

interface Location {
    latitude: number | null;
    longitude: number | null;
}

type OrderType = 'delivery' | 'pickup' | null;

interface Outlet {
    id: number;
    name: string;
    address: string;
}

export const useLocationStore = defineStore(
    'location',
    () => {
        const location = ref<Location>({ latitude: null, longitude: null });
        const orderType = ref<OrderType>(null);
        const selectedOutlet = ref<Outlet | null>(null);

        const setLocation = (coords: Location): void => {
            location.value = coords;
        };

        const setOrderType = (type: OrderType): void => {
            orderType.value = type;
        };

        const setOutlet = (outlet: Outlet): void => {
            selectedOutlet.value = outlet;
        };

        return {
            selectedOutlet,
            location,
            orderType,
            setLocation,
            setOrderType,
            setOutlet,
        };
    },
    {
        persist: true,
    },
);
