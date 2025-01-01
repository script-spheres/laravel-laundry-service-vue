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
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { PaginatedData, Payment } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const { payments, filters } = defineProps({
    payments: {
        type: Object as PropType<PaginatedData<Payment>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        default: () => ({}),
    },
});

// Initialize filters with provided or default values
const { filter, handleClearFilter } = useFilters('payments.index', {
    name: filters?.name ?? '',
    email: filters?.email ?? '',
    mobile: filters?.mobile ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Payment Management</template>
        <template #subtitle>
            Overview of all payments and their details.
        </template>
        <template #actions>
            <LinkButton :href="route('payments.create')">
                Add Payment
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="name" value="Name" />
                <InputText v-model="filter.name" placeholder="Search by Name" />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="email" value="Email" />
                <InputText
                    v-model="filter.email"
                    placeholder="Search by Email"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="mobile" value="Mobile" />
                <InputText
                    v-model="filter.mobile"
                    placeholder="Search by Mobile"
                />
            </div>
            <div class="flex-none gap-2 self-end">
                <PrimaryButton color="red" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <div class="mx-auto mt-6">
        <DataTable>
            <TableHead>
                <TableHeadCell>Date</TableHeadCell>
                <TableHeadCell>Payment Mode</TableHeadCell>
                <TableHeadCell>Order Id</TableHeadCell>
                <TableHeadCell>Customer Name</TableHeadCell>
                <TableHeadCell>Payment Status</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="payment in payments.data" :key="payment.id">
                    <TableCell>{{ payment.payment_date }}</TableCell>
                    <TableCell>{{ payment.payment_method }}</TableCell>
                    <TableCell>{{ payment?.order?.order_display_id }}</TableCell>
                    <TableCell>{{ payment?.order?.customer?.name }}</TableCell>
                    <TableCell>{{ payment?.payment_status }}</TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="payments.meta" />
    </div>
</template>
