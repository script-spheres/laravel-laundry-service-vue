<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { DeliveryScale, FlashMessage, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    deliveryScales: {
        type: Object as PropType<PaginatedData<DeliveryScale>>,
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
    radius: filters?.radius ?? '',
    end_date: filters?.end_date ?? '',
    min_amount: filters?.min_amount ?? '',
    max_amount: filters?.max_amount ?? '',
    type: filters?.type ?? '',
    title: filters?.title ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { radius, end_date, min_amount, max_amount, type, title } =
        newFilters;

    const filterParams: Record<string, string> = {
        ...(radius && { 'filter[radius]': radius }),
        ...(end_date && { 'filter[end_date]': end_date }),
        ...(min_amount && { 'filter[min_amount]': min_amount }),
        ...(max_amount && { 'filter[max_amount]': max_amount }),
        ...(type && { 'filter[discount_type]': type }),
        ...(title && { 'filter[title]': title }),
    };

    router.get(route('admin.deliveryScales.index'), filterParams, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
});

// Delete a delivery scale
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this delivery scale?'))
        return;

    router.delete(route('admin.deliveryScales.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Toggle delivery scale active status
const handleActiveStatusChange = (
    deliveryScale: DeliveryScale,
    event: Event,
) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...deliveryScale, active_status: newStatus };
    router.put(route('admin.deliveryScales.update', deliveryScale.id), data, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Delivery Scale Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your delivery scales with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton
                :to="{ name: 'deliveryScale.create' }"
                class="btn btn-primary"
            >
                Add Delivery Scale
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex items-center gap-x-3">
            <div class="mb-6 w-full md:mb-0 md:w-1/2">
                <InputLabel for="name" value="Name" />
                <TextInput
                    v-model="filter.radius"
                    placeholder="Search by Name"
                    type="text"
                />
            </div>
            <div class="mb-6 w-full md:mb-0 md:w-1/2">
                <InputLabel for="email" value="Email" />
                <TextInput
                    v-model="filter.email"
                    placeholder="Search by Email"
                    type="email"
                />
            </div>
            <div class="mb-6 w-full md:mb-0 md:w-1/2">
                <InputLabel for="mobile" value="Mobile" />
                <TextInput
                    v-model="filter.mobile"
                    placeholder="Search by Mobile"
                    type="tel"
                />
            </div>
            <div class="mb-6 flex-none gap-2 self-end md:mb-0">
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
                <TableRow
                    v-for="deliveryScale in deliveryScales.data"
                    :key="deliveryScale.id"
                >
                    <TableCell>{{ deliveryScale.radius }}</TableCell>
                    <TableCell>{{ deliveryScale.start_date }}</TableCell>
                    <TableCell>{{ deliveryScale.end_date }}</TableCell>
                    <TableCell>{{ deliveryScale.min_amount }}</TableCell>
                    <TableCell>{{ deliveryScale.max_amount }}</TableCell>
                    <TableCell>{{ deliveryScale.discount_type }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="
                                deliveryScale.active_status === 'active'
                            "
                            @change="
                                handleActiveStatusChange(deliveryScale, $event)
                            "
                        />
                    </TableCell>
                    <TableCell
                        class="flex items-center justify-end gap-2 px-4 py-1"
                    >
                        <LinkButton
                            :href="
                                route(
                                    'admin.delivery-scales.edit',
                                    deliveryScale.id,
                                )
                            "
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(deliveryScale.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="deliveryScales.meta" />
    </div>
</template>
