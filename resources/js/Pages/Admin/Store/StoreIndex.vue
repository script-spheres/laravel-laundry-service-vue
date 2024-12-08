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
import InputText from '@/Components/Form/InputText.vue';
import ToggleInput from '@/Components/Form/InputToggle.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PaginatedData, Store } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    stores: {
        type: Object as PropType<PaginatedData<Store>>,
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
    name: props.filters?.name ?? '',
    address: props.filters?.address ?? '',
    email: props.filters?.email ?? '',
    phone_number: props.filters?.phone_number ?? '',
    status: props.filters?.status ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { name, address, email, phone_number, status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(address && { 'filter[address]': address }),
        ...(email && { 'filter[email]': email }),
        ...(phone_number && { 'filter[phone_number]': phone_number }),
        ...(status && { 'filter[status]': status }),
    };

    router.get(route('admin.stores.index'), filterParams, {
        preserveScroll: true,
    });
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this store?')) return;

    router.delete(route('admin.stores.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

const handleActiveStatusChange = (store: Store, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...store, status: newStatus };
    router.put(route('admin.stores.update', store.id), data, {
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
                    Store Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your stores with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.stores.create')">
                Add Store
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="name" value="Name" />
                <InputText v-model="filter.name" placeholder="Filter by Name" />
            </div>
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="address" value="Address" />
                <InputText
                    v-model="filter.address"
                    placeholder="Filter by Address"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="email" value="Email" />
                <InputText
                    v-model="filter.email"
                    placeholder="Filter by Email"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/6">
                <InputLabel for="phone_number" value="Phone Number" />
                <InputText
                    v-model="filter.phone_number"
                    placeholder="Filter by Phone Number"
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
                <TableHeadCell>Name</TableHeadCell>
                <TableHeadCell>Address</TableHeadCell>
                <TableHeadCell>Email</TableHeadCell>
                <TableHeadCell>Phone Number</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="store in stores.data" :key="store.id">
                    <TableCell>{{ store.name }}</TableCell>
                    <TableCell>{{ store.address }}</TableCell>
                    <TableCell>{{ store.email }}</TableCell>
                    <TableCell>{{ store.phone_number }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="store.status === 'active'"
                            @change="handleActiveStatusChange(store, $event)"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.stores.edit', store.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(store.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="stores.meta" />
    </div>
</template>
