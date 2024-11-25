<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PaginatedData, Unit } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    units: {
        type: Object as PropType<PaginatedData<Unit>>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const filter = reactive({
    name: props?.filters?.name ?? '',
    active_status: props?.filters?.active_status ?? '',
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this unit?')) return;

    router.delete(route('admin.units.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

watch(filter, (newFilters) => {
    const { name, active_status } = newFilters;

    const filterParams = {
        ...(name && { 'filter[name]': name }),
        ...(active_status && { 'filter[active_status]': active_status }),
    };

    router.get(route('admin.units.index'), filterParams, {
        preserveScroll: true,
    });
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Unit Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your units with filters and actions.
            </p>
        </div>

        <div class="flex items-center gap-x-3">
            <TextInput v-model="filter.name" placeholder="Filter by Name" />
            <SelectInput
                v-model="filter.active_status"
                :options="{ active: 'Active', inactive: 'Inactive' }"
                placeholder="Filter by Active Status"
            />
            <div class="flex-none space-x-2">
                <PrimaryButton @click="handleClearFilter">
                    Clear Filter
                </PrimaryButton>
                <LinkButton :href="route('admin.units.create')">
                    Add Unit
                </LinkButton>
            </div>
        </div>
    </div>

    <div class="mx-auto mt-6">
        <DataTable>
            <TableHead>
                <TableHeadCell>Actual Name</TableHeadCell>
                <TableHeadCell>Short Name</TableHeadCell>
                <TableHeadCell>Allow Decimal</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="unit in units.data" :key="unit.id">
                    <TableCell>{{ unit.actual_name }}</TableCell>
                    <TableCell>{{ unit.short_name }}</TableCell>
                    <TableCell>{{ unit.allow_decimal }}</TableCell>
                    <TableCell>{{ unit.active_status }}</TableCell>
                    <TableCell class="space-x-2 text-right">
                        <LinkButton :href="route('admin.units.edit', unit.id)">
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(unit.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="units.meta" />
    </div>
</template>
