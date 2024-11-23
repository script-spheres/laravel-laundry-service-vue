<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Coupon, FlashMessage, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

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
    flash: {
        type: Object as PropType<FlashMessage>,
        required: false,
    },
});

// Initialize reactive filters with default values or passed props
const filter = reactive<Filters>({
    valid_form: props.filters?.valid_form ?? '',
    valid_to: props.filters?.valid_to ?? '',
    active_status: props.filters?.active_status ?? '',
    type: props.filters?.type ?? '',
    title: props.filters?.title ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { valid_form, valid_to, active_status, type, title } = newFilters;

    const filterParams: Record<string, string> = {
        ...(valid_form && { 'filter[valid_form]': valid_form }),
        ...(valid_to && { 'filter[valid_to]': valid_to }),
        ...(active_status && { 'filter[active_status]': active_status }),
        ...(type && { 'filter[discount_type]': type }),
        ...(title && { 'filter[title]': title }),
    };

    router.get(route('admin.coupons.index'), filterParams, {
        preserveScroll: true,
    });
});

// Delete a coupon
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this coupon?')) return;

    router.delete(route('admin.coupons.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Toggle coupon active status
const handleActiveStatusChange = (coupon: Coupon, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...coupon, active_status: newStatus };
    router.put(route('admin.coupons.update', coupon.id), data, {
        onSuccess: () => toast.success('Coupon status updated successfully.'),
    });
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Coupon Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your coupons with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.coupons.create')">
                Add Coupon
            </LinkButton>
        </div>
    </div>
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
                <InputLabel for="active_status" value="Status" />
                <SelectInput
                    v-model="filter.active_status"
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
                <TableHeadCell>Start Date</TableHeadCell>
                <TableHeadCell>End Date</TableHeadCell>
                <TableHeadCell>Min Amount</TableHeadCell>
                <TableHeadCell>Max Amount</TableHeadCell>
                <TableHeadCell>Discount Type</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="coupon in coupons.data" :key="coupon.id">
                    <TableCell>{{ coupon.title }}</TableCell>
                    <TableCell>{{ coupon.valid_from }}</TableCell>
                    <TableCell>{{ coupon.valid_to }}</TableCell>
                    <TableCell>{{ coupon.min_amount }}</TableCell>
                    <TableCell>{{ coupon.max_amount }}</TableCell>
                    <TableCell>{{ coupon.discount_type }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="coupon.active_status === 'active'"
                            @change="handleActiveStatusChange(coupon, $event)"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.coupons.edit', coupon.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(coupon.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="coupons.meta" />
    </div>
</template>
