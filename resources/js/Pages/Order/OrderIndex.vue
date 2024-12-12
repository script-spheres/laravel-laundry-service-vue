<script setup lang="ts">
import Badge from '@/Components/Badges/Badge.vue';
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { orderStatusOptions, paymentStatusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Order, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    orders: {
        type: Object as PropType<PaginatedData<Order>>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const { filter, handleClearFilter } = useFilters('orders.index', {
    order_uuid: props.filters?.order_uuid || '',
    customer_name: props.filters?.customer_name || '',
    order_status: props.filters?.order_status || '',
    payment_status: props.filters?.payment_status || '',
});

// Function to determine badge color based on order_status
const getOrderStatusColor = (status: string) => {
    const statusColors: Record<string, string> = {
        pending: 'yellow',
        'in-progress': 'blue',
        'ready-to-deliver': 'purple',
        delivered: 'green',
    };

    return statusColors[status.toLowerCase()] || 'gray';
};

</script>

<template>
    <PageHeader>
        <template #title> Order Management </template>
        <template #subtitle> Manage and view details of all orders. </template>
        <template #actions>
            <LinkButton :href="route('orders.create')"> Add Order </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-4">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <!-- Order Number Input -->
            <div class="w-full md:w-1/6">
                <InputLabel for="order_uuid" value="Order No." />
                <InputText
                    v-model="filter.order_uuid"
                    placeholder="Search by Order No."
                />
            </div>

            <!-- Customer Name Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="customer_name" value="Customer" />
                <InputText
                    v-model="filter.customer_name"
                    placeholder="Filter by Customer"
                />
            </div>

            <!-- Order Status Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="order_status" value="Order Status" />
                <InputSelect
                    v-model="filter.order_status"
                    :options="orderStatusOptions"
                    placeholder="Order Status"
                />
            </div>

            <!-- Payment Status Filter -->
            <div class="w-full md:w-1/6">
                <InputLabel for="payment_status" value="Payment Status" />
                <InputSelect
                    v-model="filter.payment_status"
                    :options="paymentStatusOptions"
                    placeholder="Payment Status"
                />
            </div>

            <!-- Clear Filters Button -->
            <div class="flex-none gap-2 self-end">
                <PrimaryButton @click="handleClearFilter">
                    Clear Filter
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <DataTable>
        <TableHead>
            <TableHeadCell>Order Info</TableHeadCell>
            <TableHeadCell>Customer</TableHeadCell>
            <TableHeadCell>Order Status</TableHeadCell>
            <TableHeadCell>Payment Status</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="order in orders.data" :key="order.id">
                <TableCell class="p-2">
                    <p>
                        <strong>Order ID:</strong>
                        {{ order.order_uuid }}
                    </p>
                    <p>
                        <strong>Order Date:</strong>
                        {{ order.created_at }}
                    </p>
                    <p>
                        <strong>Delivery Date:</strong>
                        {{ order.delivery_date }}
                    </p>
                </TableCell>
                <TableCell class="p-2">
                    <p>
                        <strong>Name:</strong>
                        {{ order.customer?.name }}
                    </p>
                    <p>
                        <strong>Email:</strong>
                        {{ order.customer?.email }}
                    </p>
                    <p>
                        <strong>Mobile:</strong>
                        {{ order.customer?.phone_number }}
                    </p>
                </TableCell>
                <TableCell class="text-right">
                    <Badge :color="getOrderStatusColor(order.order_status)">
                        {{ order.order_status }}
                    </Badge>
                </TableCell>
                <TableCell class="p-2">
                    <p>
                        <strong>Total Amount:</strong>
                        {{ order.total_amount }}
                    </p>
                    <p>
                        <strong>Paid Amount:</strong>
                        {{ order.paid_amount }}
                    </p>
                </TableCell>
                <TableCell class="flex gap-2">
                    <LinkButton
                        :href="route('orders.show', order.id)"
                        color="secondary"
                        class="flex-none self-end"
                    >
                        View
                    </LinkButton>
                    <LinkButton
                        :href="route('orders.edit', order.id)"
                        color="primary"
                    >
                        Edit
                    </LinkButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="orders.meta" />
</template>
