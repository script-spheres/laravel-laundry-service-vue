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
import InputLabel from '@/Components/Form/InputLabel.vue';
import InputText from '@/Components/Form/InputText.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { useFilters } from '@/Composables/useFilters';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FinancialYear, PaginatedData } from '@/types';
import { PropType } from 'vue';

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
const { filter, handleClearFilter } = useFilters(
    'admin.financial-years.index',
    {
        name: props.filters?.name ?? '',
        start_date: props.filters?.start_date ?? '',
        end_date: props.filters?.end_date ?? '',
        status: props.filters?.status ?? '',
    },
);
</script>

<template>
    <PageHeader>
        <template #title>Financial Year Management</template>
        <template #subtitle>
            Manage your financial years with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.financial-years.create')">
                Add Financial Year
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:w-1/4">
                <InputLabel for="name" value="Name" />
                <InputText v-model="filter.name" placeholder="Search by Name" />
            </div>
            <div class="w-full md:w-1/4">
                <InputLabel for="start_date" value="Start Date" />
                <InputText
                    v-model="filter.start_date"
                    placeholder="Search by Start Date"
                />
            </div>
            <div class="w-full md:w-1/4">
                <InputLabel for="end_date" value="End Date" />
                <InputText
                    v-model="filter.end_date"
                    placeholder="Search by End Date"
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
                        <StatusToggleInput
                            :action="
                                route(
                                    'admin.financial-years.update',
                                    financialYear.id,
                                )
                            "
                            :data="financialYear"
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
                        <DeleteButton
                            :action="
                                route(
                                    'admin.financial-years.destroy',
                                    financialYear.id,
                                )
                            "
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="financialYears.meta" />
    </div>
</template>
