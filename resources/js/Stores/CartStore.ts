import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

// Define the structure of a cart item
interface CartItem {
    id: number;
    name: string;
    offer_price: number;
    quantity: number;
}

export const useCartStore = defineStore(
    'user-cart',
    () => {
        const items = ref<CartItem[]>([]);
        const totalItems = ref<number>(0);
        const subTotalCost = ref<number>(0);

        const totalCost = computed<number>(() => subTotalCost.value);

        const addItem = (item: CartItem): void => {
            const targetItem = items.value.find(
                (currItem) => currItem.id === item.id,
            );

            if (targetItem) {
                targetItem.quantity += 1;
            } else {
                items.value = [...items.value, { ...item, quantity: 1 }];
            }

            totalItems.value += 1;
            subTotalCost.value += item.offer_price;
        };

        const removeItem = (item: CartItem): void => {
            const targetItem = items.value.find(
                (currItem) => currItem.id === item.id,
            );

            if (targetItem) {
                if (targetItem.quantity === 1) {
                    items.value = items.value.filter(
                        (currItem) => currItem.id !== item.id,
                    );
                } else {
                    targetItem.quantity -= 1;
                }

                totalItems.value -= 1;
                subTotalCost.value -= item.offer_price;
            }
        };

        const deleteItem = (itemId: number): void => {
            const item = items.value.find((i) => i.id === itemId);
            if (item) {
                totalItems.value -= item.quantity;
                subTotalCost.value -= item.offer_price * item.quantity;
                items.value = items.value.filter((i) => i.id !== itemId);
            }
        };

        const clearItem = (): void => {
            items.value = [];
            totalItems.value = 0;
            subTotalCost.value = 0;
        };

        const getItem = (id: number): CartItem | undefined => {
            return items.value.find((product) => product.id === id);
        };

        const hasCart = (id: number): boolean => !!getItem(id);

        const update = (
            id: number,
            field: keyof CartItem,
            value: any,
        ): void => {
            items.value = items.value.map((product) =>
                product.id === id
                    ? {
                          ...product,
                          [field]: value,
                      }
                    : product,
            );
        };

        const subtotal = (product: CartItem): number => {
            return isCalcable(product)
                ? product.offer_price * product.quantity
                : 0;
        };

        const total = (
            cb?: (sum: number, product: CartItem) => number,
        ): number =>
            items.value.reduce(
                (sum, product) =>
                    cb ? cb(sum, product) : (sum += subtotal(product)),
                0,
            );

        const isCalcable = (product: CartItem): boolean =>
            !!product && !!product.offer_price && !!product.quantity;

        return {
            items,
            totalItems,
            subTotalCost,
            totalCost,
            addItem,
            removeItem,
            deleteItem,
            clearItem,
            getItem,
            hasCart,
            update,
            subtotal,
            total,
        };
    },
    {
        persist: true,
    },
);
