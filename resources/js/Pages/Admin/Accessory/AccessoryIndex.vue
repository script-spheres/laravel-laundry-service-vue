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
import { Accessory, FlashMessage, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    accessories: {
        type: Object as PropType<PaginatedData<Accessory>>,
        required: true,
    },
    unitsOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const filter = reactive<Filters>({
    name: props.filters?.name ?? '',
    unit_id: props.filters?.unit_id ?? '',
    active_status: props.filters?.active_status ?? '',
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this accessory?'))
        return;

    router.delete(route('admin.accessories.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

const handleActiveStatusChange = async (accessory: Accessory, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...accessory, active_status: newStatus };
    router.put(route('admin.accessories.update', accessory.id), data, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

watch(filter, (newFilters) => {
    const { name, unit_id, active_status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(unit_id && { 'filter[unit_id]': unit_id }),
        ...(active_status && { 'filter[active_status]': active_status }),
    };

    router.get(route('admin.accessories.index'), filterParams, {
        preserveScroll: true,
    });
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Accessory Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your accessories with filters and actions.
            </p>
        </div>
        <div>
            <LinkButton :href="route('admin.accessories.create')">
                Add Accessory
            </LinkButton>
        </div>
    </div>

    <Card class="mb-6 p-4">
        <div class="flex items-center gap-x-3">
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="name" value="Name" />
                <TextInput
                    v-model="filter.name"
                    placeholder="Search by name"
                    type="text"
                />
            </div>
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="unit_id" value="Unit" />
                <SelectInput
                    v-model="filter.unit_id"
                    :options="unitsOptions"
                    placeholder="Select type"
                />
            </div>
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="active_status" value="Status" />
                <SelectInput
                    v-model="filter.active_status"
                    :options="statusOptions"
                    placeholder="Select status"
                />
            </div>
            <div class="mb-6 flex-none gap-2 self-end">
                <PrimaryButton color="gray" @click="handleClearFilter">
                    Clear Filter
                </PrimaryButton>
            </div>
        </div>
    </Card>

    <div class="mx-auto mt-6">
        <DataTable>
            <TableHead>
                <TableHeadCell>Name</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="accessory in accessories.data"
                    :key="accessory.id"
                >
                    <TableCell>{{ accessory.name }}</TableCell>
                    <TableCell>
                        <ToggleInput
                            :modelValue="accessory.active_status === 'active'"
                            @change="
                                handleActiveStatusChange(accessory, $event)
                            "
                        />
                    </TableCell>
                    <TableCell class="space-x-2 text-right">
                        <LinkButton
                            :href="
                                route('admin.accessories.edit', accessory.id)
                            "
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(accessory.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="accessories.meta" />
    </div>
</template>
