<script setup lang="ts">
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Expense, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const { filters } = defineProps({
    expenses: {
        type: Object as PropType<PaginatedData<Expense>>,
        required: true,
    },
    storeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('expenses.index', {
    date: filters?.date ?? '',
    store_id: filters?.store_id ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Expense Management</template>
        <template #subtitle>
            Manage your expenses with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('expenses.create')">
                Add Expense
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <FieldRow :cols="{ sm: 2, md: 4, lg: 6 }">
            <FieldCol>
                <InputText
                    type="date"
                    label="Date"
                    v-model="filter.date"
                    placeholder="Filter by Category"
                />
            </FieldCol>
            <FieldCol>
                <InputSelect
                    label="Store"
                    v-model="filter.store_id"
                    :options="storeOptions"
                    placeholder="Filter by Store"
                />
            </FieldCol>
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
    </Card>

    <DataTable>
        <TableHead>
            <TableHeadCell>Date</TableHeadCell>
            <TableHeadCell>Amount</TableHeadCell>
            <TableHeadCell>Store</TableHeadCell>
            <TableHeadCell>Expense Type</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="expense in expenses.data" :key="expense.id">
                <TableCell>{{ expense.date }}</TableCell>
                <TableCell>{{ expense.amount }}</TableCell>
                <TableCell>{{ expense.store?.name }}</TableCell>
                <TableCell>{{ expense.expense_type?.name }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('expenses.edit', expense.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="route('expenses.destroy', expense.id)"
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="expenses.meta" />
</template>
