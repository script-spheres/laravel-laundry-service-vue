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
import { City, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    cities: {
        type: Object as PropType<PaginatedData<City>>,
        required: true,
    },
});
</script>

<template>
    <PageHeader>
        <template #title> City Management </template>
        <template #subtitle>
            Manage your cities with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('cities.create')"> Add City </LinkButton>
        </template>
    </PageHeader>

    <DataTable>
        <TableHead>
            <TableHeadCell>Name</TableHeadCell>
            <TableHeadCell>Description</TableHeadCell>
            <TableHeadCell>Status</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="city in cities.data" :key="city.id">
                <TableCell>{{ city.name }}</TableCell>
                <TableCell>{{ city.description }}</TableCell>
                <TableCell>
                    <StatusToggleInput
                        :action="route('cities.update', city.id)"
                        :data="city"
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('cities.edit', city.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('cities.destroy', city.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="cities.meta" />
</template>
