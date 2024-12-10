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
import InputLabel from '@/Components/Form/InputLabel.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { Coupon, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AdminLayout });

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
    valid_form: props.filters?.valid_form ?? '',
    valid_to: props.filters?.valid_to ?? '',
    status: props.filters?.status ?? '',
    type: props.filters?.type ?? '',
    title: props.filters?.title ?? '',
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
                <InputLabel for="valid_form" value="Valid Form" />
                <DateInput v-model="filter.valid_form" />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="valid_to" value="Valid To" />
                <DateInput v-model="filter.valid_to" />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="status" value="Status" />
                <InputSelect
                    v-model="filter.status"
                    :options="statusOptions"
                    placeholder="Filter by Active Status"
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
                        <LinkButton
                            :href="route('coupons.edit', coupon.id)"
                        >
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
