<script setup lang="ts">
import DeleteButton from '@/Shared/DeleteButton.vue';
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { PaginatedData, Unit } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    units: {
        type: Object as PropType<PaginatedData<Unit>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});
</script>

<template>
    <PageHeader>
        <template #title> Unit Management </template>
        <template #subtitle>
            Manage your units with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('units.create')"> Add Unit </LinkButton>
        </template>
    </PageHeader>

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
                <TableCell>{{ unit.allow_decimal ? 'Yes' : 'No' }}</TableCell>
                <TableCell>
                    <StatusToggleInput
                        :action="route('units.update', unit.id)"
                        :data="unit"
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('units.edit', unit.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('units.destroy', unit.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="units.meta" />
</template>
