import { CartItem } from '@/types';
import { defineStore } from 'pinia';
import { computed, ref, watch } from 'vue';

export const usePosStore = defineStore(
    'pos-cart',
    () => {
        const items = ref<CartItem[]>([]);

        const totalItems = ref(0);
        const subTotalCost = ref(0);
        const taxPercentage = ref(0);
        const discountAmount = ref(0);

        const coupon = ref<string | null>(null);

        const totalCost = computed(() =>
            parseFloat(
                (
                    subTotalCost.value *
                    (1 + taxPercentage.value) *
                    (1 - discountAmount.value)
                ).toFixed(2),
            ),
        );

        const taxAmount = computed(() =>
            parseFloat((0 - totalCost.value).toFixed(2)),
        );

        // Function to add an item to the cart
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

            totalItems.value += 1;
        };

        const updateItemQuantity = (id: number, newQuantity: number) => {
            const item = items.value.find((cartItem) => cartItem.id === id);

            if (item) {
                // Update the quantity
                totalItems.value -= item.quantity;
                item.quantity = newQuantity;

                // Recalculate the total for the item
                item.total = parseFloat(
                    (item.quantity * item.price).toFixed(2),
                );

                // Recalculate the total number of items in the cart and subtotal cost
                totalItems.value += item.quantity;
                subTotalCost.value = items.value.reduce(
                    (acc, item) => acc + item.total,
                    0,
                );
            }
        };

        const removeItem = (id: number) => {
            const index = items.value.findIndex(
                (cartItem) => cartItem.id === id,
            );

            if (index !== -1) {
                const item = items.value[index];
                totalItems.value -= item.quantity;
                subTotalCost.value = parseFloat(
                    (subTotalCost.value - item.total).toFixed(2),
                );

                items.value.splice(index, 1);
            }
        };

        const applyCoupon = (couponCode: string, discount: number) => {
            coupon.value = couponCode;
            discountAmount.value = discount;
        };

        const removeCoupon = () => {
            coupon.value = null;
            discountAmount.value = 0.1;
        };

        const clearItemCartByType = (type: 'service' | 'addon-service') => {
            items.value = items.value.filter(
                (item) => item.serviceable_type !== type,
            );

            totalItems.value = items.value.reduce(
                (acc, item) => acc + item.quantity,
                0,
            );

            subTotalCost.value = items.value.reduce(
                (acc, item) => acc + item.total,
                0,
            );
        };

        const clear = () => {
            items.value.splice(0, items.value.length);
            totalItems.value = 0;
            subTotalCost.value = 0;
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
                    item.serviceable_id === id &&
                    item.serviceable_type === type,
            );
        };

        watch(
            items,
            (newItems) => {
                totalItems.value = newItems.reduce(
                    (acc, item) => acc + item.quantity,
                    0,
                );
                subTotalCost.value = newItems.reduce(
                    (acc, item) => acc + item.total,
                    0,
                );
            },
            { immediate: true },
        );

        watch(
            [taxPercentage, discountAmount],
            () => {
                totalCost.value;
            },
            { immediate: true },
        );

        return {
            items,
            totalItems,
            subTotalCost,
            totalCost,
            taxAmount,
            discountAmount,
            coupon,
            addItem,
            updateItemQuantity,
            removeItem,
            applyCoupon,
            removeCoupon,
            clear,
            clearItemCartByType,
            totalItemsByType,
            totalCostByType,
            getItemsByType,
            itemIsCartByType,
        };
    },
    {
        persist: true,
    },
);
