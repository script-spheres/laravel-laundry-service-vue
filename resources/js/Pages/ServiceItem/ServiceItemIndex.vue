<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { PaginatedData, Service } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    serviceItems: {
        type: Object as PropType<PaginatedData<Service>>,
        required: true,
    },
    storesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('service-items.index', {
    status: props.filters?.status ?? '',
    type: props.filters?.type ?? '',
    title: props.filters?.title ?? '',
    store_id: props.filters?.store_id ?? '',
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Service Item Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your service items with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('service-items.create')">
                Add Service Item
            </LinkButton>
        </div>
    </div>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputSelect
                    label="Store"
                    v-model="filter.store_id"
                    :options="storesOptions"
                    placeholder="Filter by Store"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputSelect
                    label="Status"
                    v-model="filter.status"
                    :options="statusOptions"
                    placeholder="Filter by Active Status"
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
                <TableHeadCell>Service Item Name</TableHeadCell>
                <TableHeadCell>Description</TableHeadCell>
                <TableHeadCell>Store</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="serviceItem in serviceItems.data"
                    :key="serviceItem.id"
                >
                    <TableCell>{{ serviceItem.name }}</TableCell>
                    <TableCell>{{ serviceItem.description }}</TableCell>
                    <TableCell>{{ serviceItem.store_name }}</TableCell>
                    <TableCell class="text-right">
                        <StatusToggleInput
                            :action="
                                route('service-items.update', serviceItem.id)
                            "
                            :data="serviceItem"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('service-items.edit', serviceItem.id)"
                        >
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="
                                route('service-items.destroy', serviceItem.id)
                            "
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="serviceItems.meta" />
    </div>
</template>
