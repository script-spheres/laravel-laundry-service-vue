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
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Banner, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    banners: {
        type: Object as PropType<PaginatedData<Banner>>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const filter = reactive<Filters>({
    title: props.filters?.title ?? '',
    active_status: props.filters?.active_status ?? '',
});

// Watch for changes in filter and trigger API updates
watch(filter, (newFilters) => {
    const { title, active_status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(title && { 'filter[title]': title }),
        ...(active_status && { 'filter[active_status]': active_status }),
    };

    router.get(route('admin.banners.index'), filterParams, {
        preserveScroll: true,
    });
});

// Handle deletion of a banner
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this banner?')) {
        return;
    }

    router.delete(route('admin.banners.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Handle active status changes for a banner
const handleActiveStatusChange = async (banner: Banner, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...banner, active_status: newStatus };
    router.put(route('admin.banners.update', banner.id), data, {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Banner Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Overview of all banners and their details.
            </p>
        </div>

        <div class="flex items-center gap-x-3">
            <TextInput v-model="filter.title" placeholder="Filter by Name" />
            <SelectInput
                v-model="filter.active_status"
                :options="{ active: 'Active', inactive: 'Inactive' }"
                placeholder="Filter by Active Status"
            />
            <div class="flex-none space-x-2">
                <PrimaryButton @click="handleClearFilter">
                    Clear Filter
                </PrimaryButton>
                <LinkButton :href="route('admin.banners.create')">
                    Add Banner
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
                <TableRow v-for="banner in banners.data" :key="banner.id">
                    <TableCell>{{ banner.title }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="banner.active_status === 'active'"
                            @change="handleActiveStatusChange(banner, $event)"
                        />
                    </TableCell>
                    <TableCell
                        class="flex items-center justify-end gap-2 px-4 py-1"
                    >
                        <LinkButton
                            :href="route('admin.banners.edit', banner.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(banner.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="banners.meta" />
    </div>
</template>
