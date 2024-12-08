<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DateInput from '@/Components/Form/InputDate.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { paymentStatusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Order } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive } from 'vue';
import draggable from 'vuedraggable';

defineOptions({ layout: AdminLayout });

// Props Definition
const props = defineProps({
    pendingOrders: {
        type: Array as PropType<Order[]>,
        required: true,
    },
    inProgressOrders: {
        type: Array as PropType<Order[]>,
        required: true,
    },
    readyToDeliverOrders: {
        type: Array as PropType<Order[]>,
        required: true,
    },
    deliveredOrders: {
        type: Array as PropType<Order[]>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

// Reactive Columns for Kanban
const columns = reactive([
    { name: 'Pending', orders: props.pendingOrders, order_status: 'pending' },
    {
        name: 'In Progress',
        orders: props.inProgressOrders,
        order_status: 'in-progress',
    },
    {
        name: 'Ready To Deliver',
        orders: props.readyToDeliverOrders,
        order_status: 'ready-to-deliver',
    },
    {
        name: 'Delivered',
        orders: props.deliveredOrders,
        order_status: 'delivered',
    },
]);

// Filters Reactive State
const { filter, handleClearFilter } = useFilters('admin.orders-status.index', {
    order_date: props.filters?.order_date || '',
    payment_status: props.filters?.payment_status || '',
    order_uuid: props.filters?.order_uuid || '',
});

let targetColumn = '';
let selectedOrder: Order | null = null;

// When drag ends, update the status
const end = (evt: any) => {
    console.log('Drag ended');
    targetColumn = evt.to.dataset.column;

    console.log('selectedOrder', selectedOrder);
    if (selectedOrder) {
        const dataSet = { ...selectedOrder, order_status: targetColumn };
        router.put(
            route('admin.orders-status.update', selectedOrder.id),
            dataSet,
            {
                preserveScroll: true,
                preserveState: true,
            },
        );
    }
};

const cloneDog = (order: Order) => {
    selectedOrder = order;
    return order;
};
</script>
<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                Order Status Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Drag and drop orders between columns to update their status.
            </p>
        </div>
    </div>

    <!-- Filters Section -->
    <Card class="mb-6 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="w-full md:w-1/4">
                <InputLabel for="order_uuid" value="Order No." />
                <InputText
                    v-model="filter.order_uuid"
                    placeholder="Search by Order No."
                />
            </div>

            <div class="w-full md:w-1/4">
                <InputLabel for="order_date" value="Order Date" />
                <DateInput
                    v-model="filter.order_date"
                    placeholder="Select Order Date"
                />
            </div>

            <div class="w-full md:w-1/4">
                <InputLabel for="payment_status" value="Payment Status" />
                <InputSelect
                    v-model="filter.payment_status"
                    :options="paymentStatusOptions"
                    placeholder="Payment Status"
                />
            </div>

            <div class="flex-none">
                <PrimaryButton @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <div
            v-for="(column, columnIndex) in columns"
            :key="columnIndex"
            class="flex flex-col gap-4 rounded-lg bg-gray-100 p-4"
        >
            <h2
                class="mb-4 rounded-lg bg-gray-200 p-2 text-center text-lg font-semibold"
            >
                {{ column.name }}
            </h2>

            <!-- Draggable container for orders -->
            <draggable
                :list="column.orders"
                group="orders"
                :clone="cloneDog"
                @end="end"
                item-key="name"
                class="space-y-4"
                :data-column="column.order_status"
            >
                <template #item="{ element }">
                    <div
                        class="list-group-item rounded-lg bg-white p-4 shadow-md transition hover:shadow-lg"
                    >
                        <div class="flex flex-col space-y-2">
                            <h3 class="text-md font-bold text-gray-700">
                                {{ element.order_uuid }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                <strong>Delivery Date:</strong>
                                {{ element.delivery_date }}
                            </p>
                            <p class="text-sm text-gray-500">
                                <strong>Customer:</strong>
                                {{ element.customer?.name }}
                            </p>
                        </div>
                    </div>
                </template>
            </draggable>
        </div>
    </div>
</template>
