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
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Customer, FlashMessage, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    customers: {
        type: Object as PropType<PaginatedData<Customer>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        default: () => ({}),
    },
    flash: {
        type: Object as PropType<FlashMessage>,
        required: false,
    },
});

const { customers, filters } = props;

// Initialize filters with provided or default values
const filter = reactive<Filters>({
    name: filters?.name ?? '',
    email: filters?.email ?? '',
    mobile: filters?.mobile ?? '',
});

// Watch for filter changes and refresh data
watch(filter, (newFilters) => {
    const { name, email, mobile } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(email && { 'filter[email]': email }),
        ...(mobile && { 'filter[mobile]': mobile }),
    };

    router.get(route('admin.customers.index'), filterParams, {
        preserveScroll: true,
        only: ['customers'],
    });
});

// Delete customer
const handleDelete = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this customer?'))
        return;

    router.delete(route('admin.customers.destroy', id), {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Customer Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Overview of all customers and their details.
            </p>
        </div>

        <div>
            <LinkButton :href="route('admin.customers.create')">
                Add Customer
            </LinkButton>
        </div>
    </div>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="name" value="Name" />
                <TextInput v-model="filter.name" placeholder="Search by Name" />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    v-model="filter.email"
                    placeholder="Search by Email"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="mobile" value="Mobile" />
                <TextInput
                    v-model="filter.mobile"
                    placeholder="Search by Mobile"
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
                <TableHeadCell>Email</TableHeadCell>
                <TableHeadCell>Mobile</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="customer in customers.data" :key="customer.id">
                    <TableCell>{{ customer.name }}</TableCell>
                    <TableCell>{{ customer.email }}</TableCell>
                    <TableCell>{{ customer.mobile }}</TableCell>
                    <TableCell class="space-x-2 text-right">
                        <LinkButton
                            :href="route('admin.customers.edit', customer.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="handleDelete(customer.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="customers.meta" />
    </div>
</template>
