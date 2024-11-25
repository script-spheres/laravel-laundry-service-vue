<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PaginatedData, Service } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    services: {
        type: Object as PropType<PaginatedData<Service>>,
        required: true,
    },
    storesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

// Initialize reactive filters with default values or passed props
const filter = reactive<Filters>({
    active_status: props.filters?.active_status ?? '',
    type: props.filters?.type ?? '',
    title: props.filters?.title ?? '',
    store_id: props.filters?.store_id ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { active_status, type, title, store_id } = newFilters;

    const filterParams: Record<string, string> = {
        ...(active_status && { 'filter[active_status]': active_status }),
        ...(type && { 'filter[type]': type }),
        ...(title && { 'filter[title]': title }),
        ...(store_id && { 'filter[store_id]': store_id }),
    };

    router.get(route('admin.services.index'), filterParams, {
        preserveScroll: true,
    });
});

// Delete a service
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this service?'))
        return;

    router.delete(route('admin.services.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Toggle service active status
const handleActiveStatusChange = (service: Service, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...service, active_status: newStatus };
    router.put(route('admin.services.update', service.id), data, {
        onSuccess: () => toast.success('Service status updated successfully.'),
    });
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Service Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your services with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.services.create')">
                Add Service
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <SelectInput
                    label="Store"
                    v-model="filter.store_id"
                    :options="storesOptions"
                    placeholder="Filter by Store"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <SelectInput
                    label="Status"
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
                <TableHeadCell>Service Name</TableHeadCell>
                <TableHeadCell>Description</TableHeadCell>
                <TableHeadCell>Store</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="service in services.data" :key="service.id">
                    <TableCell>{{ service.service_name }}</TableCell>
                    <TableCell>{{ service.description }}</TableCell>
                    <TableCell>{{ service.store_name }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="service.active_status === 'active'"
                            @change="handleActiveStatusChange(service, $event)"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.services.edit', service.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(service.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="services.meta" />
    </div>
</template>
