import { defineStore } from 'pinia';
import { computed, reactive, ref } from 'vue';

export const usePosStore = defineStore('pos-cart', () => {
    const items = reactive([]);
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

    const addItem = (item: {
        id: number;
        name: string;
        price: number;
        type: 'service' | 'addon';
    }) => {
        const existingItem = items.value.find(
            (cartItem) =>
                cartItem.id === item.id && cartItem.type === item.type,
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

    const removeItem = (id: number, type: 'service' | 'addon') => {
        const index = items.value.findIndex(
            (cartItem) => cartItem.id === id && cartItem.type === type,
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

    const clearCart = () => {
        items.value = [];
        totalItems.value = 0;
        subTotalCost.value = 0;
        cash.value = 0;
    };

    const addCash = (amount: number) => {
        cash.value += amount;
    };

    return {
        items,
        totalItems,
        subTotalCost,
        totalCost,
        change,
        addItem,
        removeItem,
        clearCart,
        addCash,
    };
});
