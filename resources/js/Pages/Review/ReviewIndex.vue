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
import { PaginatedData, Review } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    reviews: {
        type: Object as PropType<PaginatedData<Review>>,
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
        <template #title> Review Management</template>
        <template #subtitle>
            Manage your reviews with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('reviews.create')"> Add Review</LinkButton>
        </template>
    </PageHeader>

    <DataTable>
        <TableHead>
            <TableHeadCell>Title</TableHeadCell>
            <TableHeadCell>Rating</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="review in reviews.data" :key="review.id">
                <TableCell>{{ review.title }}</TableCell>
                <TableCell>{{ review.rating }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('reviews.edit', review.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('reviews.destroy', review.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="reviews.meta" />
</template>
