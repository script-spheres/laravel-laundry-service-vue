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
import DateInput from '@/Components/Form/InputDate.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { discountTypeOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { Coupon, PaginatedData } from '@/types';
import { PropType } from 'vue';
import InputText from '@/Components/Form/InputText.vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    coupons: {
        type: Object as PropType<PaginatedData<Coupon>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

// Initialize reactive filters with default values or passed props
const { filter, handleClearFilter } = useFilters('coupons.index', {
    title: props.filters?.title ?? '',
    discount_type: props.filters?.discount_type ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Coupon Management </template>
        <template #subtitle>
            Manage your coupons with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('coupons.create')">
                Add Coupon
            </LinkButton>
        </template>
    </PageHeader>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputText label="Title" v-model="filter.title" />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputSelect
                    label="Discount Type"
                    v-model="filter.discount_type"
                    :options="discountTypeOptions"
                />
            </div>
            <div class="flex-none gap-2 self-end">
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <div class="mx-auto mt-6">
        <DataTable>
            <TableHead>
                <TableHeadCell>Title</TableHeadCell>
                <TableHeadCell>Min Amount</TableHeadCell>
                <TableHeadCell>Max Amount</TableHeadCell>
                <TableHeadCell>Discount Type</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="coupon in coupons.data" :key="coupon.id">
                    <TableCell>{{ coupon.title }}</TableCell>
                    <TableCell>{{ coupon.min_amount }}</TableCell>
                    <TableCell>{{ coupon.max_amount }}</TableCell>
                    <TableCell>{{ coupon.discount_type }}</TableCell>
                    <TableCell class="text-right">
                        <StatusToggleInput
                            :action="route('coupons.update', coupon.id)"
                            :data="coupon"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton :href="route('coupons.edit', coupon.id)">
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="route('coupons.destroy', coupon.id)"
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="coupons.meta" />
    </div>
</template>
