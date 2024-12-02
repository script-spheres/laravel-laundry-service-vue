import { CartAddonItem, CartItem } from '@/types';
import { defineStore } from 'pinia';
import { computed, reactive, ref } from 'vue';

export const usePosStore = defineStore(
    'pos-cart',
    () => {
        const items = reactive<CartItem[]>([]);
        const addonItems = reactive<CartAddonItem[]>([]);
        const totalItems = ref(0); // Total main cart items
        const totalAddonItems = ref(0); // Total addon items
        const subTotalCost = ref(0);
        const taxRate = ref(0.05);
        const discountRate = ref(0.1); // Default discount rate
        const coupon = ref<string | null>(null); // Currently applied coupon

        const totalCost = computed(() =>
            parseFloat(
                (
                    subTotalCost.value *
                    (1 + taxRate.value) *
                    (1 - discountRate.value)
                ).toFixed(2),
            ),
        );

        const change = computed(
            () => parseFloat((0 - totalCost.value).toFixed(2)), // Removed cash handling
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

            console.log(items); // Log cart items
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

            console.log(items); // Log cart items
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

            console.log(items); // Log cart items
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

            totalAddonItems.value += 1;
            subTotalCost.value = parseFloat(
                (subTotalCost.value + addon.price).toFixed(2),
            );

            console.log(items); // Log cart items
        };

        const removeAddonItem = (id: number) => {
            const index = addonItems.findIndex(
                (addonItem) => addonItem.id === id,
            );

            if (index !== -1) {
                const addon = addonItems[index];
                totalAddonItems.value -= addon.quantity;
                subTotalCost.value = parseFloat(
                    (subTotalCost.value - addon.total).toFixed(2),
                );

                addonItems.splice(index, 1);
            }

            console.log(items); // Log cart items
        };

        const applyCoupon = (couponCode: string, discount: number) => {
            coupon.value = couponCode;
            discountRate.value = discount;
            console.log(
                `Coupon applied: ${couponCode} with discount ${discountRate.value * 100}%`,
            );
        };

        const removeCoupon = () => {
            coupon.value = null;
            discountRate.value = 0.1; // Reset to default discount rate
            console.log('Coupon removed');
        };

        const clearItemCart = () => {
            items.splice(0, items.length);
            totalItems.value = 0;
            subTotalCost.value = addonItems.reduce(
                (acc, addon) => acc + addon.total,
                0,
            ); // Keep subtotal for addon items
            console.log(items); // Log cart items
        };

        const clearAddonCart = () => {
            addonItems.splice(0, addonItems.length);
            totalAddonItems.value = 0;
            subTotalCost.value = items.reduce(
                (acc, item) => acc + item.total,
                0,
            ); // Keep subtotal for main items
            console.log(items); // Log cart items
        };

        return {
            items,
            addonItems,
            totalItems,
            totalAddonItems,
            subTotalCost,
            totalCost,
            change,
            coupon,
            addItem,
            removeItem,
            updateItem,
            addAddonItem,
            removeAddonItem,
            applyCoupon,
            removeCoupon,
            clearItemCart,
            clearAddonCart,
        };
    },
    {
        persist: true,
    },
);
