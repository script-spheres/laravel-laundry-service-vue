<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import {
    kitchenStatusOptions,
    paymentStatusOptions,
} from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Order, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

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

// Watch for filter changes and trigger API call
watch(filter, (newFilters) => {
    const { outlet_id, table_id, kitchen_status, payment_status, order_uuid } =
        newFilters;

    const filterParams = {
        ...(outlet_id && { 'filter[outlet_id]': outlet_id }),
        ...(table_id && { 'filter[table_id]': table_id }),
        ...(kitchen_status && { 'filter[kitchen_status]': kitchen_status }),
        ...(payment_status && { 'filter[payment_status]': payment_status }),
        ...(order_uuid && { 'filter[order_uuid]': order_uuid }),
    };

    router.get(route('admin.orders.index'), filterParams, {
        preserveState: true,
        preserveScroll: true,
        only: ['orders'],
    });
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this order?')) return;

    router.delete(route('admin.orders.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

const clearFilters = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

const handlePaymentStatusChange = (order: Order, event: Event) => {
    const target = event.target as HTMLSelectElement;
    const newPaymentStatus = target.value;

    router.put(route('admin.orders.update', { id: order.id }), {
        payment_status: newPaymentStatus,
    });
};
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
        <DataTable>
            <TableHead>
                <TableHeadCell>Order No.</TableHeadCell>
                <TableHeadCell>Outlet</TableHeadCell>
                <TableHeadCell>Table</TableHeadCell>
                <TableHeadCell>Total Amount</TableHeadCell>
                <TableHeadCell>Payment Status</TableHeadCell>
                <TableHeadCell>Kitchen Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="order in orders.data" :key="order.id">
                    <TableCell>{{ order.order_uuid }}</TableCell>
                    <TableCell>{{ order.outlet?.name }}</TableCell>
                    <TableCell>{{ order.table?.table_no }}</TableCell>
                    <TableCell>{{ order.total_amount }}</TableCell>
                    <TableCell>
                        <SelectInput
                            v-model="order.payment_status"
                            :options="paymentStatusOptions"
                            @change="handlePaymentStatusChange(order, $event)"
                        />
                    </TableCell>
                    <TableCell>{{ order.kitchen_status }}</TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.orders.show', order.id)"
                        >
                            View
                        </LinkButton>
                        <LinkButton
                            :href="route('admin.orders.edit', order.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(order.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="orders.meta" />
    </div>
</template>
