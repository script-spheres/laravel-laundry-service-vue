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
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
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
</script>

<template>
    <PageHeader>
        <template #title> Order Management</template>
        <template #subtitle> Manage and view details of all orders.</template>
        <template #actions>
            <LinkButton :href="route('orders.create')"> Add Order</LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <FieldRow :cols="{ sm: 2, md: 4, lg: 6 }">
            <FieldCol>
                <InputText
                    label="Order No."
                    v-model="filter.order_uuid"
                    placeholder="Search by Order No."
                />
            </FieldCol>

            <FieldCol>
                <InputText
                    label="Customer"
                    v-model="filter.customer_name"
                    placeholder="Filter by Customer"
                />
            </FieldCol>

            <FieldCol>
                <InputSelect
                    label="Order Status"
                    v-model="filter.order_status"
                    :options="orderStatusOptions"
                    placeholder="Order Status"
                />
            </FieldCol>

            <FieldCol>
                <InputSelect
                    label="Payment Status"
                    v-model="filter.payment_status"
                    :options="paymentStatusOptions"
                    placeholder="Payment Status"
                />
            </FieldCol>

            <!-- Clear Filters Button -->
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton @click="handleClearFilter" color="danger">
                    Clear Filter
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
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
                    <Badge>
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
                <TableCell class="flex h-20 items-center justify-end gap-2">
                    <LinkButton
                        :href="route('orders.show', order.id)"
                        color="secondary"
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
