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
import { PaginatedData, Faq } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    faqs: {
        type: Object as PropType<PaginatedData<Faq>>,
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
        <template #title> FAQ Management</template>
        <template #subtitle>
            Manage your frequently asked questions with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('faqs.create')"> Add FAQ</LinkButton>
        </template>
    </PageHeader>

    <DataTable>
        <TableHead>
            <TableHeadCell>Question</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="faq in faqs.data" :key="faq.id">
                <TableCell>{{ faq.question }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('faqs.edit', faq.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('faqs.destroy', faq.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="faqs.meta" />
</template>
