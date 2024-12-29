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
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { PaginatedData, Service } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    serviceItems: {
        type: Object as PropType<PaginatedData<Service>>,
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
    name: props.filters?.name ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title>Service Item Management</template>
        <template #subtitle>
            Manage your service items with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('service-items.create')">
                Add Service Item
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputText
                    type="text"
                    label="Store"
                    v-model="filter.name"
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
                <PrimaryButton color="red" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <DataTable class="mx-auto mt-6">
        <TableHead>
            <TableHeadCell>Service Item Name</TableHeadCell>
            <TableHeadCell>Description</TableHeadCell>
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
                <TableCell class="text-right">
                    <StatusToggleInput
                        :action="route('service-items.update', serviceItem.id)"
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
                        :action="route('service-items.destroy', serviceItem.id)"
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="serviceItems.meta" />
</template>
