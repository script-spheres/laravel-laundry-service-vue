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
import { PaginatedData, ServiceDetail } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    serviceDetails: {
        type: Object as PropType<PaginatedData<ServiceDetail>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('service-details.index', {
    status: props.filters?.status ?? '',
    name: props.filters?.name ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title>Service Fare Management</template>
        <template #subtitle>
            Manage your service details with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('service-details.create')">
                Add Service Detail
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputText
                    label="Name"
                    v-model="filter.name"
                    placeholder="Filter by Name"
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
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <DataTable class="mx-auto mt-6">
        <TableHead>
            <TableHeadCell>Service Name</TableHeadCell>
            <TableHeadCell>Category</TableHeadCell>
            <TableHeadCell>Unit</TableHeadCell>
            <TableHeadCell>Service Item</TableHeadCell>
            <TableHeadCell>Price</TableHeadCell>
            <TableHeadCell>Quantity</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow
                v-for="serviceDetail in serviceDetails.data"
                :key="serviceDetail.id"
            >
                <TableCell>{{ serviceDetail.service.name }}</TableCell>
                <TableCell>{{ serviceDetail?.category?.name }}</TableCell>
                <TableCell>{{ serviceDetail?.unit?.actual_name }}</TableCell>
                <TableCell>{{ serviceDetail?.service_item?.name }}</TableCell>
                <TableCell>{{ serviceDetail.price }}</TableCell>
                <TableCell>{{ serviceDetail.quantity }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton
                        :href="route('service-details.edit', serviceDetail.id)"
                    >
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="
                            route('service-details.destroy', serviceDetail.id)
                        "
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="serviceDetails.meta" />
</template>
