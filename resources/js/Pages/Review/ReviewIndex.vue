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
import InputRating from '@/Components/Form/InputRating.vue';
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { PaginatedData, Review } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
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

const { filter, handleClearFilter } = useFilters('reviews.index', {
    order_display_id: props.filters?.order_display_id ?? '',
    customer_name: props.filters?.customer_name ?? '',
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

    <Card class="mb-6 p-6">
        <FieldRow :cols="{ sm: 2, md: 4, lg: 6 }">
            <FieldCol>
                <InputText
                    label="Order display id"
                    v-model="filter.order_display_id"
                    placeholder="Filter by order display id"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="Customer name"
                    v-model="filter.customer_name"
                    placeholder="Filter by customer_name"
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
            <TableHeadCell>Order</TableHeadCell>
            <TableHeadCell>Customer</TableHeadCell>
            <TableHeadCell>Title</TableHeadCell>
            <TableHeadCell>Rating</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="review in reviews.data" :key="review.id">
                <TableCell>{{ review.order?.order_display_id }}</TableCell>
                <TableCell>{{ review.customer?.name }}</TableCell>
                <TableCell>{{ review.title }}</TableCell>
                <TableCell>
                    <InputRating v-model="review.rating" editable="false" />
                </TableCell>
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
