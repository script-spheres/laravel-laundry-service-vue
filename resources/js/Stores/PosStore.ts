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

        // Setter functions to set state values directly
        const setItems = (newItems: CartItem[]) => {
            items.value = newItems;
            totalItems.value = newItems.reduce((acc, item) => acc + item.quantity, 0);
            subTotalCost.value = newItems.reduce((acc, item) => acc + item.total, 0);
        };

        const setTotalItems = (newTotalItems: number) => {
            totalItems.value = newTotalItems;
        };

        const setSubTotalCost = (newSubTotalCost: number) => {
            subTotalCost.value = newSubTotalCost;
        };

        const setTaxPercentage = (newTaxPercentage: number) => {
            taxPercentage.value = newTaxPercentage;
        };

        const setDiscountRate = (newDiscountRate: number) => {
            discountRate.value = newDiscountRate;
        };

        const setCoupon = (newCoupon: string | null) => {
            coupon.value = newCoupon;
        };

        // Existing methods
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

        const addItem = (item: CartItem) => {
            const existingItem = items.value.find(
                (cartItem) =>
                    cartItem.id === item.id &&
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
                    total: parseFloat(item.price.toFixed(2)),
                });
            }

            totalItems.value += 1;
            subTotalCost.value = parseFloat(
                (subTotalCost.value + item.price).toFixed(2),
            );
        };

        const updateItem = (
            id: number,
            serviceableType: 'service' | 'addon-service',
            serviceableId: string | number,
            newQuantity: number,
        ) => {
            const existingItem = items.value.find(
                (item) =>
                    item.id === id &&
                    item.serviceable_type === serviceableType &&
                    item.serviceable_id === serviceableId,
            );

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
            discountRate.value = discount;
            console.log(
                `Coupon applied: ${couponCode} with discount ${discountRate.value * 100}%`,
            );
        };

        const removeCoupon = () => {
            coupon.value = null;
            discountRate.value = 0.1;
            console.log('Coupon removed');
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

        const clearItemCart = () => {
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

        return {
            items,
            totalItems,
            subTotalCost,
            totalCost,
            taxPercentage,
            taxAmount,
            change,
            coupon,
            setItems,
            setTotalItems,
            setSubTotalCost,
            setTaxPercentage,
            setDiscountRate,
            setCoupon,
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
