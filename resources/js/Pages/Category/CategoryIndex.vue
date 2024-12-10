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
import TextInput from '@/Components/Form/TextInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Category, FlashMessage, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    categories: {
        type: Object as PropType<PaginatedData<Category>>,
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

// Initialize reactive filter state
const filter = reactive<Filters>({
    name: props.filters?.name ?? '',
    active_status: props.filters?.active_status ?? '',
});

// Watch for filter changes and send updated requests
watch(filter, (newFilters) => {
    const { name, active_status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(active_status && { 'filter[active_status]': active_status }),
    };

    router.get(route('categories.index'), filterParams, {
        preserveScroll: true,
    });
});

// Delete category function
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this category?'))
        return;

    router.delete(route('categories.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Toggle active status
const handleActiveStatusChange = async (category: Category, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...category, active_status: newStatus };

    router.put(route('categories.update', category.id), data, {
        preserveScroll: true,
        onSuccess: () => toast.success('Status updated successfully.'),
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Category Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Overview of all categories and their details.
            </p>
        </div>

        <div class="flex items-center gap-x-3">
            <TextInput v-model="filter.name" placeholder="Filter by Name" />
            <SelectInput
                v-model="filter.active_status"
                :options="statusOptions"
                placeholder="Filter by Active Status"
            />
            <div class="flex-none space-x-2">
                <PrimaryButton @click="handleClearFilter">
                    Clear Filter
                </PrimaryButton>
                <LinkButton :href="route('categories.create')">
                    Add Category
                </LinkButton>
            </div>
        </div>
    </div>
    <div class="mx-auto mt-6">
        <DataTable
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
        >
            <TableHead>
                <TableHeadCell>Title</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="category in categories.data"
                    :key="category.id"
                >
                    <TableCell>{{ category.name }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="category.active_status === 'active'"
                            @change="handleActiveStatusChange(category, $event)"
                        />
                    </TableCell>
                    <TableCell
                        class="flex items-center justify-end gap-2 px-4 py-1"
                    >
                        <LinkButton
                            :href="route('categories.edit', category.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(category.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="categories.meta" />
    </div>
</template>
