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
import PageHeader from '@/Components/PageHeader.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Customer, PaginatedData } from '@/types';
import { PropType } from 'vue';

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
});

const { customers, filters } = props;

// Initialize filters with provided or default values
const { filter, handleClearFilter } = useFilters('admin.customers.index', {
    name: filters?.name ?? '',
    email: filters?.email ?? '',
    mobile: filters?.mobile ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Customer Management </template>
        <template #subtitle>
            Overview of all customers and their details.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.customers.create')">
                Add Customer
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="name" value="Name" />
                <InputText v-model="filter.name" placeholder="Search by Name" />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="email" value="Email" />
                <InputText
                    v-model="filter.email"
                    placeholder="Search by Email"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="mobile" value="Mobile" />
                <InputText
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
                    <TableCell>{{ customer.phone_number }}</TableCell>
                    <TableCell class="space-x-2 text-right">
                        <LinkButton
                            :href="route('admin.customers.edit', customer.id)"
                        >
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="
                                route('admin.customers.destroy', customer.id)
                            "
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="customers.meta" />
    </div>
</template>
