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
import { PaginatedData, ServiceDetail } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    serviceDetails: {
        type: Object as PropType<PaginatedData<ServiceDetail>>,
        required: true,
    },
    categoryOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    serviceOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    serviceItemOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    unitOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('service-details.index', {
    price: props.filters?.price ?? '',
    category_id: props.filters?.category_id ?? '',
    service_id: props.filters?.service_id ?? '',
    service_item_id: props.filters?.service_item_id ?? '',
    unit_id: props.filters?.unit_id ?? '',
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
                Add Service Fare
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <FieldRow :cols="6">
            <!-- Price Filter -->
            <FieldCol>
                <InputText
                    label="Price"
                    v-model="filter.price"
                    placeholder="Filter by price"
                />
            </FieldCol>

            <!-- Category Filter -->
            <FieldCol>
                <InputSelect
                    label="Category"
                    v-model="filter.category_id"
                    :options="categoryOptions"
                    placeholder="Filter by Category"
                />
            </FieldCol>

            <!-- Service Filter -->
            <FieldCol>
                <InputSelect
                    label="Service"
                    v-model="filter.service_id"
                    :options="serviceOptions"
                    placeholder="Filter by Service"
                />
            </FieldCol>

            <!-- Service Item Filter -->
            <FieldCol>
                <InputSelect
                    label="Service Item"
                    v-model="filter.service_item_id"
                    :options="serviceItemOptions"
                    placeholder="Filter by Service Item"
                />
            </FieldCol>

            <!-- Unit Filter -->
            <FieldCol>
                <InputSelect
                    label="Unit"
                    v-model="filter.unit_id"
                    :options="unitOptions"
                    placeholder="Filter by Unit"
                />
            </FieldCol>

            <!-- Clear Filters Button -->
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton color="red" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
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
