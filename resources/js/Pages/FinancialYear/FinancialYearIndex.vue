<script setup lang="ts">
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
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
import { FinancialYear, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
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
</script>

<template>
    <PageHeader>
        <template #title>Financial Year Management</template>
        <template #subtitle>
            Manage your financial years with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('financial-years.create')">
                Add Financial Year
            </LinkButton>
        </template>
    </PageHeader>

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
                    <StatusToggleInput
                        :action="
                            route('financial-years.update', financialYear.id)
                        "
                        :data="financialYear"
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton
                        :href="route('financial-years.edit', financialYear.id)"
                    >
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="
                            route('financial-years.destroy', financialYear.id)
                        "
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="financialYears.meta" />
</template>
