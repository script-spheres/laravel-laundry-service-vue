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
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { PaginatedData, ServiceType } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    serviceTypes: {
        type: Object as PropType<PaginatedData<ServiceType>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('service-types.index', {
    name: props.filters?.name ?? '',
    status: props.filters?.status ?? '',
    type: props.filters?.type ?? '',
    title: props.filters?.title ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Service Type Management </template>
        <template #subtitle>
            Manage your service types with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('service-types.create')">
                Add Service Type
            </LinkButton>
        </template>
    </PageHeader>
    <Card class="mb-6 p-6">
        <FieldRow class="flex grid-cols-4">
            <FieldCol>
                <InputText
                    label="Type Name"
                    v-model="filter.name"
                    placeholder="Filter by Type Name"
                />
            </FieldCol>
            <FieldCol>
                <InputSelect
                    label="Status"
                    v-model="filter.status"
                    :options="statusOptions"
                    placeholder="Filter by Active Status"
                />
            </FieldCol>
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton color="gray" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
    </Card>
    <DataTable>
        <TableHead>
            <TableHeadCell>Type Name</TableHeadCell>
            <TableHeadCell>Description</TableHeadCell>
            <TableHeadCell class="text-right">Status</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow
                v-for="serviceType in serviceTypes.data"
                :key="serviceType.id"
            >
                <TableCell>{{ serviceType.name }}</TableCell>
                <TableCell>{{ serviceType.description }}</TableCell>
                <TableCell class="text-right">
                    <StatusToggleInput
                        :data="serviceType"
                        :action="
                            route('service-types.update', serviceType.id)
                        "
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton
                        :href="
                            route('service-types.edit', serviceType.id)
                        "
                    >
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="
                            route('service-types.destroy', serviceType.id)
                        "
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="serviceTypes.meta" />
</template>
