<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FinancialYear, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    financialYears: {
        type: Object as PropType<PaginatedData<FinancialYear>>,
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
    name: props.filters?.name ?? '',
    start_date: props.filters?.start_date ?? '',
    end_date: props.filters?.end_date ?? '',
    status: props.filters?.status ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { name, start_date, end_date, status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(start_date && { 'filter[start_date]': start_date }),
        ...(end_date && { 'filter[end_date]': end_date }),
        ...(status && { 'filter[status]': status }),
    };

    router.get(route('admin.financial-years.index'), filterParams, {
        preserveScroll: true,
    });
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this financial year?'))
        return;

    router.delete(route('admin.financial-years.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

const handleActiveStatusChange = (
    financialYear: FinancialYear,
    event: Event,
) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...financialYear, status: newStatus };
    router.put(route('admin.financial-years.update', financialYear.id), data, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Financial Year Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your financial years with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.financial-years.create')">
                Add Financial Year
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="name" value="Name" />
                <TextInput v-model="filter.name" placeholder="Filter by Name" />
            </div>
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="start_date" value="Start Date" />
                <DateInput
                    v-model="filter.start_date"
                    placeholder="Filter by Start Date"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="end_date" value="End Date" />
                <DateInput
                    v-model="filter.end_date"
                    placeholder="Filter by End Date"
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
                <TableHeadCell>Name</TableHeadCell>
                <TableHeadCell>Start Date</TableHeadCell>
                <TableHeadCell>End Date</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="financialYear in financialYears.data"
                    :key="financialYear.id"
                >
                    <TableCell>{{ financialYear.name }}</TableCell>
                    <TableCell>{{ financialYear.start_date }}</TableCell>
                    <TableCell>{{ financialYear.end_date }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="
                                financialYear.status === 'active'
                            "
                            @change="
                                handleActiveStatusChange(financialYear, $event)
                            "
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="
                                route(
                                    'admin.financial-years.edit',
                                    financialYear.id,
                                )
                            "
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(financialYear.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="financialYears.meta" />
    </div>
</template>
