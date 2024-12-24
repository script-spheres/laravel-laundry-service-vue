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
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { Category, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    categories: {
        type: Object as PropType<PaginatedData<Category>>,
        required: true,
    },
});
</script>

<template>
    <PageHeader>
        <template #title> Category Management</template>
        <template #subtitle>
            Manage your categories with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('categories.create')">
                Add Category
            </LinkButton>
        </template>
    </PageHeader>

    <DataTable class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <TableHead>
            <TableHeadCell>Title</TableHeadCell>
            <TableHeadCell class="text-right">Status</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="category in categories.data" :key="category.id">
                <TableCell>{{ category.name }}</TableCell>
                <TableCell class="text-right">
                    <StatusToggleInput
                        :action="route('categories.update', category.id)"
                        :data="category"
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('categories.edit', category.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton
                        :action="route('categories.destroy', category.id)"
                    >
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="categories.meta" />
</template>
