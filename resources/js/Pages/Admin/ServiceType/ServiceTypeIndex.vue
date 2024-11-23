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
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PaginatedData, ServiceType } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    serviceTypes: {
        type: Object as PropType<PaginatedData<ServiceType>>,
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
    type_name: props.filters?.type_name ?? '',
    active_status: props.filters?.active_status ?? '',
    type: props.filters?.type ?? '',
    title: props.filters?.title ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { type_name, active_status, type, title } = newFilters;

    const filterParams: Record<string, string> = {
        ...(type_name && { 'filter[type_name]': type_name }),
        ...(active_status && { 'filter[active_status]': active_status }),
        ...(type && { 'filter[discount_type]': type }),
        ...(title && { 'filter[title]': title }),
    };

    router.get(route('admin.service-types.index'), filterParams, {
        preserveScroll: true,
    });
});

// Delete a service type
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this service type?'))
        return;

    router.delete(route('admin.service-types.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Toggle service type active status
const handleActiveStatusChange = (serviceType: ServiceType, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...serviceType, active_status: newStatus };
    router.put(route('admin.service-types.update', serviceType.id), data, {
        onSuccess: () =>
            toast.success('Service type status updated successfully.'),
    });
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Service Type Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your service types with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.service-types.create')">
                Add Service Type
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="type_name" value="Type Name" />
                <TextInput
                    v-model="filter.type_name"
                    placeholder="Filter by Type Name"
                />
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
                <TableHeadCell>Type Name</TableHeadCell>
                <TableHeadCell>Description</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="serviceType in serviceTypes.data"
                    :key="serviceType.id"
                >
                    <TableCell>{{ serviceType.type_name }}</TableCell>
                    <TableCell>{{ serviceType.description }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="serviceType.active_status === 'active'"
                            @change="
                                handleActiveStatusChange(serviceType, $event)
                            "
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="
                                route(
                                    'admin.service-types.edit',
                                    serviceType.id,
                                )
                            "
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(serviceType.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="serviceTypes.meta" />
    </div>
</template>
