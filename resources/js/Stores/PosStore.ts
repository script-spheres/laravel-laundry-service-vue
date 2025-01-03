import { CartItem } from '@/types';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const usePosStore = defineStore('pos-cart', () => {
    const items = ref<CartItem[]>([]);

    const addItem = (item: Omit<CartItem, 'total'>) => {
        const existingItem = items.value.find(
            (cartItem) =>
                cartItem.serviceable_type === item.serviceable_type &&
                cartItem.serviceable_id === item.serviceable_id,
        );

        if (existingItem) {
            existingItem.quantity += 1;
            existingItem.total = parseFloat(
                (existingItem.quantity * existingItem.price).toFixed(2),
            );
        } else {
            items.value.push({
                ...item,
                quantity: 1,
                total: parseFloat((item.quantity * item.price).toFixed(2)),
            });
        }
    };

    const updateItemQuantity = (id: number, newQuantity: number) => {
        const item = items.value.find((cartItem) => cartItem.id === id);

        if (item) {
            // Update the quantity
            item.quantity = newQuantity;

            // Recalculate the total for the item
            item.total = parseFloat((item.quantity * item.price).toFixed(2));
        }
    };

    const removeItem = (id: number) => {
        const index = items.value.findIndex((cartItem) => cartItem.id === id);

        if (index !== -1) {
            items.value[index];
            items.value.splice(index, 1);
        }
    };

    const clearItemCartByType = (type: 'service' | 'addon-service') => {
        items.value = items.value.filter(
            (item) => item.serviceable_type !== type,
        );
    };

    const clear = () => {
        items.value.splice(0, items.value.length);
    };

    const totalItemsByType = (type: 'service' | 'addon-service') => {
        return items.value
            .filter((item) => item.serviceable_type === type)
            .reduce((acc, item) => acc + item.quantity, 0);
    };

    const totalCostByType = (type: 'service' | 'addon-service') => {
        return items.value
            .filter((item) => item.serviceable_type === type)
            .reduce((acc, item) => acc + item.total, 0);
    };

    const getItemsByType = (type: 'service' | 'addon-service') => {
        return items.value.filter((item) => item.serviceable_type === type);
    };

    const itemIsCartByType = (
        id: number,
        type: 'service' | 'addon-service',
    ): boolean => {
        return items.value.some(
            (item) =>
                item.serviceable_id === id && item.serviceable_type === type,
        );
    };

    return {
        items,
        addItem,
        updateItemQuantity,
        removeItem,
        clear,
        clearItemCartByType,
        totalItemsByType,
        totalCostByType,
        getItemsByType,
        itemIsCartByType,
    };
});
