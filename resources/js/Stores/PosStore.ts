import { CartAddonItem, CartItem } from '@/types';
import { defineStore } from 'pinia';
import { computed, reactive, ref } from 'vue';

export const usePosStore = defineStore(
    'pos-cart',
    () => {
        const items = reactive<CartItem[]>([]);
        const addonItems = reactive<CartAddonItem[]>([]);
        const totalItems = ref(0);
        const subTotalCost = ref(0);
        const taxRate = ref(0.05);
        const discountRate = ref(0.1);
        const cash = ref(0);

        const totalCost = computed(() =>
            parseFloat(
                (
                    subTotalCost.value *
                    (1 + taxRate.value) *
                    (1 - discountRate.value)
                ).toFixed(2),
            ),
        );

        const change = computed(() =>
            parseFloat((cash.value - totalCost.value).toFixed(2)),
        );

        const addItem = (item: Omit<CartItem, 'quantity' | 'total'>) => {
            const existingItem = items.find(
                (cartItem) => cartItem.id === item.id,
            );

            if (existingItem) {
                existingItem.quantity += 1;
                existingItem.total = parseFloat(
                    (existingItem.quantity * existingItem.price).toFixed(2),
                );
            } else {
                items.push({
                    ...item,
                    quantity: 1,
                    total: parseFloat(item.price.toFixed(2)),
                });
            }

            totalItems.value += 1;
            subTotalCost.value = parseFloat(
                (subTotalCost.value + item.price).toFixed(2),
            );
        };

        const removeItem = (id: number) => {
            const index = items.findIndex((cartItem) => cartItem.id === id);

            if (index !== -1) {
                const item = items[index];
                totalItems.value -= item.quantity;
                subTotalCost.value = parseFloat(
                    (subTotalCost.value - item.total).toFixed(2),
                );

                items.splice(index, 1);
            }
        };

        const updateItem = (id: number, newQuantity: number) => {
            const existingItem = items.find((item) => item.id === id);

            if (existingItem && newQuantity > 0) {
                const quantityDifference = newQuantity - existingItem.quantity;
                existingItem.quantity = newQuantity;
                existingItem.total = parseFloat(
                    (existingItem.quantity * existingItem.price).toFixed(2),
                );
                totalItems.value += quantityDifference;
                subTotalCost.value = parseFloat(
                    (
                        subTotalCost.value +
                        existingItem.price * quantityDifference
                    ).toFixed(2),
                );
            }
        };

        const addAddonItem = (
            addon: Omit<CartAddonItem, 'quantity' | 'total'>,
        ) => {
            const existingAddon = addonItems.find(
                (addonItem) => addonItem.id === addon.id,
            );

            if (existingAddon) {
                existingAddon.quantity += 1;
                existingAddon.total = parseFloat(
                    (existingAddon.quantity * existingAddon.price).toFixed(2),
                );
            } else {
                addonItems.push({
                    ...addon,
                    quantity: 1,
                    total: parseFloat(addon.price.toFixed(2)),
                });
            }

            totalItems.value += 1;
            subTotalCost.value = parseFloat(
                (subTotalCost.value + addon.price).toFixed(2),
            );
        };

        const removeAddonItem = (id: number) => {
            const index = addonItems.findIndex(
                (addonItem) => addonItem.id === id,
            );

            if (index !== -1) {
                const addon = addonItems[index];
                totalItems.value -= addon.quantity;
                subTotalCost.value = parseFloat(
                    (subTotalCost.value - addon.total).toFixed(2),
                );

                addonItems.splice(index, 1);
            }
        };

        const updateAddonItem = (id: number, newQuantity: number) => {
            const existingAddon = addonItems.find((addon) => addon.id === id);

            if (existingAddon && newQuantity > 0) {
                const quantityDifference = newQuantity - existingAddon.quantity;
                existingAddon.quantity = newQuantity;
                existingAddon.total = parseFloat(
                    (existingAddon.quantity * existingAddon.price).toFixed(2),
                );
                totalItems.value += quantityDifference;
                subTotalCost.value = parseFloat(
                    (
                        subTotalCost.value +
                        existingAddon.price * quantityDifference
                    ).toFixed(2),
                );
            }
        };

        const clearCart = () => {
            items.splice(0, items.length);
            addonItems.splice(0, addonItems.length);
            totalItems.value = 0;
            subTotalCost.value = 0;
            cash.value = 0;
        };

        const addCash = (amount: number) => {
            cash.value += amount;
        };

        return {
            items,
            addonItems,
            totalItems,
            subTotalCost,
            totalCost,
            cash,
            change,
            addItem,
            removeItem,
            updateItem,
            addAddonItem,
            removeAddonItem,
            updateAddonItem,
            clearCart,
            addCash,
        };
    },
    {
        persist: true,
    },
);
