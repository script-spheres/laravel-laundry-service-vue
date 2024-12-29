import { CartItem } from '@/types';
import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

export const usePosStore = defineStore(
    'pos-cart',
    () => {
        const items = ref<CartItem[]>([]);
        const totalItems = ref(0);
        const subTotalCost = ref(0);
        const taxPercentage = ref(0);
        const discountRate = ref(0);
        const coupon = ref<string | null>(null);

        const totalCost = computed(() =>
            parseFloat(
                (
                    subTotalCost.value *
                    (1 + taxPercentage.value) *
                    (1 - discountRate.value)
                ).toFixed(2),
            ),
        );

        const change = computed(() =>
            parseFloat((0 - totalCost.value).toFixed(2)),
        );

        const taxAmount = computed(() =>
            parseFloat((0 - totalCost.value).toFixed(2)),
        );

        // Add an item to the cart
        const addItem = (item: CartItem) => {
            const existingItem = items.value.find(
                (cartItem) => cartItem.id === item.id,
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
                    total: parseFloat(item.price.toFixed(2)),
                });
            }

            totalItems.value += 1;
            subTotalCost.value = parseFloat(
                (subTotalCost.value + item.price).toFixed(2),
            );
        };

        // Remove an item from the cart
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

        // Update an item in the cart
        const updateItem = (id: number, newQuantity: number) => {
            const existingItem = items.value.find((item) => item.id === id);

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

        // Apply a coupon
        const applyCoupon = (couponCode: string, discount: number) => {
            coupon.value = couponCode;
            discountRate.value = discount;
            console.log(
                `Coupon applied: ${couponCode} with discount ${discountRate.value * 100}%`,
            );
        };

        // Remove the coupon
        const removeCoupon = () => {
            coupon.value = null;
            discountRate.value = 0.1;
            console.log('Coupon removed');
        };

        // Clear the cart based on serviceable_type (service or addon-service)
        const clearItemCartByType = (type: 'service' | 'addon-service') => {
            items.value = items.value.filter(
                (item) => item.serviceable_type !== type,
            );

            // Recalculate total items and subtotal cost
            totalItems.value = items.value.reduce(
                (acc, item) => acc + item.quantity,
                0,
            );
            subTotalCost.value = items.value.reduce(
                (acc, item) => acc + item.total,
                0,
            );
        };

        // Clear all items from the cart
        const clearItemCart = () => {
            items.value.splice(0, items.value.length);
            totalItems.value = 0;
            subTotalCost.value = 0;
        };

        // Total items for a specific serviceable_type
        const totalItemsByType = (type: 'service' | 'addon-service') => {
            return items.value
                .filter((item) => item.serviceable_type === type)
                .reduce((acc, item) => acc + item.quantity, 0);
        };

        // Total cost for a specific serviceable_type
        const totalCostByType = (type: 'service' | 'addon-service') => {
            return items.value
                .filter((item) => item.serviceable_type === type)
                .reduce((acc, item) => acc + item.total, 0);
        };

        // Get items by serviceable_type
        const getItemsByType = (type: 'service' | 'addon-service') => {
            return items.value.filter((item) => item.serviceable_type === type);
        };

        return {
            items,
            totalItems,
            subTotalCost,
            totalCost,
            taxPercentage,
            taxAmount,
            change,
            coupon,
            addItem,
            removeItem,
            updateItem,
            applyCoupon,
            removeCoupon,
            clearItemCart,
            clearItemCartByType,
            totalItemsByType,
            totalCostByType,
            getItemsByType,
        };
    },
    {
        persist: true,
    },
);
