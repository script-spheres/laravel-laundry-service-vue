<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import {
    kitchenStatusOptions,
    paymentStatusOptions,
} from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Order, PaginatedData } from '@/types';
import { PropType, reactive } from 'vue';
import draggable from 'vuedraggable';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    orders: {
        type: Object as PropType<PaginatedData<Order>>,
        required: true,
    },
    outletOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    seatingTableOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const filter = reactive({
    outlet_id: props.filters?.outlet_id || '',
    table_id: props.filters?.table_id || '',
    kitchen_status: props.filters?.kitchen_status || '',
    payment_status: props.filters?.payment_status || '',
    order_uuid: props.filters?.order_uuid || '',
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Order Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage and view details of all orders.
            </p>
        </div>
    </div>
    <Card class="mb-6 p-4">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <!-- Order Number Input -->
            <div class="w-full md:w-1/6">
                <InputLabel for="order_uuid" value="Order No." />
                <TextInput
                    v-model="filter.order_uuid"
                    placeholder="Search by Order No."
                />
            </div>

            <!-- Outlet Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="outlet_id" value="Outlet" />
                <SelectInput
                    v-model="filter.outlet_id"
                    :options="outletOptions"
                    placeholder="Filter by Outlet"
                />
            </div>

            <!-- Table Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="table_id" value="Table" />
                <SelectInput
                    v-model="filter.table_id"
                    :options="seatingTableOptions"
                    placeholder="Filter by Table"
                />
            </div>

            <!-- Kitchen Status Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="kitchen_status" value="Kitchen Status" />
                <SelectInput
                    v-model="filter.kitchen_status"
                    id="kitchen_status"
                    :options="kitchenStatusOptions"
                    placeholder="Kitchen Status"
                />
            </div>

            <!-- Payment Status Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="payment_status" value="Payment Status" />
                <SelectInput
                    v-model="filter.payment_status"
                    id="payment_status"
                    :options="paymentStatusOptions"
                    placeholder="Payment Status"
                />
            </div>

            <!-- Clear Filters Button -->
            <div class="flex-none gap-2 self-end">
                <PrimaryButton @click="clearFilters">
                    Clear Filter
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <div class="mx-auto mt-6">
        <div class="kanban-board mx-auto max-w-7xl p-6">
            <h1 class="mb-6 text-center text-2xl font-bold">Kanban Board</h1>
            <div class="flex gap-6">
                <!-- Loop through columns -->
                <div
                    v-for="(column, columnIndex) in columns"
                    :key="columnIndex"
                    class="w-1/3 rounded-lg bg-gray-100 p-4 shadow-md"
                >
                    <h2 class="mb-4 text-lg font-semibold">
                        {{ column.name }}
                    </h2>
                    <!-- Draggable container for tasks -->
                    <draggable
                        v-model="column.tasks"
                        group="tasks"
                        class="space-y-3"
                        @end="onDragEnd"
                    >
                        <!-- Render tasks -->
                        <div
                            v-for="task in column.tasks"
                            :key="task.id"
                            class="cursor-grab rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:bg-gray-50"
                        >
                            {{ task.title }}
                        </div>
                    </draggable>
                </div>
            </div>
        </div>
    </div>
</template>
