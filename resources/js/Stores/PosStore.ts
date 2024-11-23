import { ActiveStatus, Category, Outlet } from '@/types';
import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

interface Item {
    id: number;
    name: string;
    quantity: number;
    sl_no?: number;
    item_total?: number;
    product_uuid: string;
    category_id: number;
    outlet_id: number;
    outlet: Outlet;
    category: Category;
    title: string;
    description: string;
    image: Array<any> | null;
    market_price: number;
    selling_price: number;
    offer_price: number;
    notes: string;
    cooking_time: string;
    nutritional_information: Array<any>;
    ingredients: Array<any>;
    food_type: string;
    dietary: string;
    service_type: string;
    menu_type: string;
    delivery_type: string;
    active_status: ActiveStatus;
}

interface PosCartState {
    items: Item[];
    table: number | null;
    totalItems: number;
    subTotalCost: number;
    taxRate: number;
    discountRate: number;
    cash: number;
    customerId: number | null;
    orderType: 'in-store' | 'takeaway' | 'delivery';
}

export const usePosStore = defineStore(
    'pos-cart',
    () => {
        const items = ref<Item[]>([]);
        const table = ref<number | null>(null);
        const totalItems = ref<number>(0);
        const subTotalCost = ref<number>(0);
        const taxRate = ref<number>(0.05);
        const discountRate = ref<number>(0.1);
        const cash = ref<number>(0);
        const customerId = ref<number | null>(null);
        const orderType = ref<'in-store' | 'takeaway' | 'delivery'>('in-store');

        // Computed properties
        const totalCost = computed(() =>
            (
                subTotalCost.value *
                (1 + taxRate.value) *
                (1 - discountRate.value)
            ).toFixed(2),
        );

        const grandTotal = computed(() => parseFloat(totalCost.value));
        const change = computed(() =>
            (cash.value - grandTotal.value).toFixed(2),
        );

        // Methods
        const adjustItem = (item: Item, quantity: number) => {
            const index = items.value.findIndex((i) => i.id === item.id);

            if (index === -1 && quantity > 0) {
                // Add new item
                items.value.push({
                    ...item,
                    quantity,
                    sl_no: items.value.length + 1,
                    item_total: parseFloat(
                        (item.offer_price * quantity).toFixed(2),
                    ),
                });
                totalItems.value += quantity;
                subTotalCost.value += item.offer_price * quantity;
            } else if (index !== -1) {
                // Update existing item
                const existingItem = items.value[index];
                const newQuantity = existingItem.quantity + quantity;

                if (newQuantity <= 0) {
                    // Remove item
                    totalItems.value -= existingItem.quantity;
                    subTotalCost.value -=
                        existingItem.offer_price * existingItem.quantity;
                    items.value.splice(index, 1);
                } else {
                    existingItem.quantity = newQuantity;
                    existingItem.item_total = parseFloat(
                        (existingItem.offer_price * newQuantity).toFixed(2),
                    );
                    totalItems.value += quantity;
                    subTotalCost.value += item.offer_price * quantity;
                }

                // Update serial numbers
                items.value.forEach((i, idx) => (i.sl_no = idx + 1));
            }
            subTotalCost.value = parseFloat(subTotalCost.value.toFixed(2));
        };

        const addItem = (item: Item) => adjustItem(item, 1);

        const updateItem = (id: number, newQuantity: number) => {
            const item = items.value.find((i) => i.id === id);
            if (item) {
                const quantityChange = newQuantity - item.quantity;
                adjustItem(item, quantityChange);
            }
        };

        const removeItem = (id: number) => {
            const item = items.value.find((i) => i.id === id);
            if (item) {
                adjustItem(item, -item.quantity);
            }
        };

        const clearCart = () => {
            items.value = [];
            table.value = null;
            totalItems.value = 0;
            subTotalCost.value = 0;
            cash.value = 0;
        };

        const addCash = (amount: number) => {
            cash.value += amount;
        };

        const setCustomer = (id: number | null) => {
            customerId.value = id;
        };

        const setOrderType = (type: 'in-store' | 'takeaway' | 'delivery') => {
            orderType.value = type;
        };

        const setTable = (tableNumber: number | null) => {
            table.value = tableNumber;
        };

        return {
            items,
            table,
            totalItems,
            subTotalCost,
            totalCost,
            grandTotal,
            cash,
            change,
            customerId,
            orderType,
            addItem,
            updateItem,
            removeItem,
            clearCart,
            addCash,
            setTable,
            setCustomer,
            setOrderType,
        };
    },
    {
        persist: true,
    },
);
