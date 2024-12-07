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
import { useFilters } from '@/Composables/useFilters';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { DeliveryScale, PaginatedData } from '@/types';
import { PropType } from 'vue';

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
});

// Initialize reactive filters with default values or passed props
const { filter, handleClearFilter } = useFilters(
    'admin.delivery-scales.index',
    {
        radius: props.filters?.radius ?? '',
        end_date: props.filters?.end_date ?? '',
        min_amount: props.filters?.min_amount ?? '',
        max_amount: props.filters?.max_amount ?? '',
        type: props.filters?.type ?? '',
        title: props.filters?.title ?? '',
    },
);
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
                            :modelValue="deliveryScale.status === 'active'"
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
