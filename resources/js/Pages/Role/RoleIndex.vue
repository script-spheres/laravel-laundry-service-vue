<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { PaginatedData, Role } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    roles: {
        type: Object as PropType<PaginatedData<Role>>,
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
        <template #title> Role Management</template>
        <template #subtitle>
            Manage your roles with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('roles.create')"> Add Role</LinkButton>
        </template>
    </PageHeader>

    <DataTable>
        <TableHead>
            <TableHeadCell>Name</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="role in roles.data" :key="role.id">
                <TableCell>{{ role.name }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('roles.edit', role.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('roles.destroy', role.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="roles.meta" />
</template>
