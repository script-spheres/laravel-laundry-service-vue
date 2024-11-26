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
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Expense, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    expenses: {
        type: Object as PropType<PaginatedData<Expense>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

// Initialize reactive filters with default values or passed props
const filter = reactive<Filters>({
    category: props.filters?.category ?? '',
    store_id: props.filters?.store_id ?? '',
    amount: props.filters?.amount ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { category, store_id, amount } = newFilters;

    const filterParams: Record<string, string> = {
        ...(category && { 'filter[category]': category }),
        ...(store_id && { 'filter[store_id]': store_id }),
        ...(amount && { 'filter[amount]': amount }),
    };

    router.get(route('admin.expenses.index'), filterParams, {
        preserveScroll: true,
    });
});

// Delete an expense
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this expense?'))
        return;

    router.delete(route('admin.expenses.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Expense Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your expenses with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.expenses.create')">
                Add Expense
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="category" value="Category" />
                <SelectInput
                    v-model="filter.category"
                    :options="categoryOptions"
                    placeholder="Filter by Category"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="store_id" value="Store" />
                <SelectInput
                    v-model="filter.store_id"
                    :options="storeOptions"
                    placeholder="Filter by Store"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="amount" value="Amount" />
                <SelectInput
                    v-model="filter.amount"
                    :options="amountOptions"
                    placeholder="Filter by Amount"
                />
            </div>
            <div class="flex-none gap-2 self-end">
                <PrimaryButton color="gray" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <div class="mx-auto mt-6">
        <DataTable>
            <TableHead>
                <TableHeadCell>Category</TableHeadCell>
                <TableHeadCell>Amount</TableHeadCell>
                <TableHeadCell>Store</TableHeadCell>
                <TableHeadCell>Receipt</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="expense in expenses.data" :key="expense.id">
                    <TableCell>{{ expense.category }}</TableCell>
                    <TableCell>{{ expense.amount }}</TableCell>
                    <TableCell>{{ expense.store_name }}</TableCell>
                    <TableCell>{{ expense.receipt || 'No Receipt' }}</TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.expenses.edit', expense.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(expense.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="expenses.meta" />
    </div>
</template>
