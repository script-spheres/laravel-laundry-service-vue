<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { paymentStatusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Filters, Order } from '@/types';
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
    { name: 'Delivered', orders: props.deliveredOrders, order_status: 'delivered' },
]);

// Filters Reactive State
const { filter, handleClearFilter } = useFilters('admin.orders.index', {
    order_date: props.filters?.order_date || '',
    payment_status: props.filters?.payment_status || '',
    order_uuid: props.filters?.order_uuid || '',
});

// Dragging state
let drag = false;

// Handle Drag End Event
const onDragEnd = (evt: any) => {
    drag = false;

    const { item, to } = evt; // Extracting the dragged item and target column
    const draggedOrder = item; // The order object being dragged
    const targetColumn = columns.find((column) => column.orders === to); // Identify the target column
    console.log(draggedOrder);
    console.log(targetColumn);
    if (draggedOrder && targetColumn) {
        // Update order status using Inertia
        router.put(`/orders/${draggedOrder.id}/update-status`, {
            status: targetColumn.order_status,
        });
    }
};
const cloneDog = (evt: any) => {
    const { item, to } = evt; // Extracting the dragged item and target column
    const draggedOrder = item; // The order object being dragged
    const targetColumn = columns.find((column) => column.orders === to); // Identify the target column
    console.log(evt);
    if (draggedOrder && targetColumn) {
        // Update order status using Inertia
        router.put(`/orders/${draggedOrder.id}/update-status`, {
            status: targetColumn.order_status,
        });
    }
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
                <TextInput
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
                <SelectInput
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
            class="flex flex-col gap-4 rounded-lg bg-gray-100 p-4 shadow-md"
        >
            <h2
                class="mb-4 rounded-lg bg-gray-200 p-2 text-center text-lg font-semibold"
            >
                {{ column.name }}
            </h2>

            <!-- Draggable container for orders -->
            <draggable
                v-model="column.orders"
                group="tasks"
                @start="drag = true"
                @end="onDragEnd"
                :clone="cloneDog"
                item-key="id"
                class="space-y-4"
            >
                <template #item="{ element }">
                    <div
                        class="rounded-lg bg-white p-4 shadow-md transition hover:shadow-lg"
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
                                {{ element.customer_name }}
                            </p>
                        </div>
                    </div>
                </template>
            </draggable>
        </div>
    </div>
</template>
