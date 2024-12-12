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
import InputLabel from '@/Components/Form/InputLabel.vue';
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { DeliveryScale, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

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
const { filter, handleClearFilter } = useFilters('delivery-scales.index', {
    radius: props.filters?.radius ?? '',
    min_order_amount: props.filters?.min_order_amount ?? '',
    delivery_charges: props.filters?.delivery_charges ?? '',
    status: props.filters?.status ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title>Delivery Scale Management</template>
        <template #subtitle>
            Manage your delivery scales with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('delivery-scales.create')">
                Add Delivery Scale
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:w-1/4">
                <InputLabel for="radius" value="Radius" />
                <InputText
                    v-model="filter.radius"
                    placeholder="Search by Radius"
                />
            </div>
            <div class="w-full md:w-1/4">
                <InputLabel for="min_order_amount" value="Min Order Amount" />
                <InputText
                    v-model="filter.min_order_amount"
                    placeholder="Search by Min Order Amount"
                />
            </div>
            <div class="w-full md:w-1/4">
                <InputLabel for="delivery_charges" value="Delivery Charges" />
                <InputText
                    v-model="filter.delivery_charges"
                    placeholder="Search by Delivery Charges"
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
                <TableHeadCell>Radius</TableHeadCell>
                <TableHeadCell>Min Order Amount</TableHeadCell>
                <TableHeadCell>Delivery Charges</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="deliveryScale in deliveryScales.data"
                    :key="deliveryScale.id"
                >
                    <TableCell>{{
                        deliveryScale.radius + ' ' + deliveryScale.radius_unit
                    }}</TableCell>
                    <TableCell>{{ deliveryScale.min_order_amount }}</TableCell>
                    <TableCell>{{ deliveryScale.delivery_charges }}</TableCell>
                    <TableCell class="text-right">
                        <StatusToggleInput
                            :action="
                                route(
                                    'delivery-scales.update',
                                    deliveryScale.id,
                                )
                            "
                            :data="deliveryScale"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="
                                route('delivery-scales.edit', deliveryScale.id)
                            "
                        >
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="
                                route(
                                    'delivery-scales.destroy',
                                    deliveryScale.id,
                                )
                            "
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="deliveryScales.meta" />
    </div>
</template>
