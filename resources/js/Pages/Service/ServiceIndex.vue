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
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { PaginatedData, Service } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    services: {
        type: Object as PropType<PaginatedData<Service>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('services.index', {
    name: props.filters?.name ?? '',
    status: props.filters?.status ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Service Management</template>
        <template #subtitle>
            Manage your services with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('services.create')">
                Add Service
            </LinkButton>
        </template>
    </PageHeader>
    <Card class="mb-6 p-6">
        <FieldRow :cols="{ sm: 2, md: 4, lg: 6 }">
            <FieldCol>
                <InputText
                    label="Service Name"
                    v-model="filter.name"
                    placeholder="Filter by Service Name"
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
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
    </Card>
    <DataTable>
        <TableHead>
            <TableHeadCell>Service Name</TableHeadCell>
            <TableHeadCell>Description</TableHeadCell>
            <TableHeadCell class="text-right">Status</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="service in services.data" :key="service.id">
                <TableCell>{{ service.name }}</TableCell>
                <TableCell>{{ service.description }}</TableCell>
                <TableCell class="text-right">
                    <StatusToggleInput
                        :data="service"
                        :action="route('services.update', service.id)"
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('services.edit', service.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="route('services.destroy', service.id)"
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="services.meta" />
</template>
