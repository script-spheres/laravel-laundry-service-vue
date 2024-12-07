<script setup lang="ts">
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ExpenseType, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
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

// Initialize reactive filters with default values or passed props
const { filter, handleClearFilter } = useFilters('admin.expense-types.index', {
    name: props.filters?.name ?? '',
});
</script>
<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Expense Type Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your expenses types with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.expense-types.create')">
                Add Expense Type
            </LinkButton>
        </div>
    </div>

    <!-- Filters Card -->
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <!-- Expense Type Filter -->
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="expense_type_id" value="Expense Type" />
                <TextInput
                    v-model="filter.name"
                    placeholder="Filter by Expense Type"
                />
            </div>

            <!-- Clear Filters Button -->
            <div class="flex-none gap-2 self-end">
                <PrimaryButton color="gray" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <!-- Expenses Table -->
    <div class="mx-auto mt-6">
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
                            :href="
                                route(
                                    'admin.expense-types.edit',
                                    expenseType.id,
                                )
                            "
                        >
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="
                                route(
                                    'admin.expense-types.destroy',
                                    expenseType.id,
                                )
                            "
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="expenseTypes.meta" />
    </div>
</template>
