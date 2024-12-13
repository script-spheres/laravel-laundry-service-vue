<script setup lang="ts">
import DeleteButton from '@/Shared/DeleteButton.vue';
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { ExpenseType, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    expenseTypes: {
        type: Object as PropType<PaginatedData<ExpenseType>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});
</script>
<template>
    <PageHeader>
        <template #title>Expense Type Management</template>
        <template #subtitle>
            Manage your expenses types with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('expense-types.create')">
                Add Expense Type
            </LinkButton>
        </template>
    </PageHeader>

    <DataTable>
        <TableHead>
            <TableHeadCell>Name</TableHeadCell>
            <TableHeadCell>Description</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow
                v-for="expenseType in expenseTypes.data"
                :key="expenseType.id"
            >
                <TableCell>{{ expenseType.name }}</TableCell>
                <TableCell>{{ expenseType.description }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton
                        :href="route('expense-types.edit', expenseType.id)"
                    >
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="route('expense-types.destroy', expenseType.id)"
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="expenseTypes.meta" />
</template>
