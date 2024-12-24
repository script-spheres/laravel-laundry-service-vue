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
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { PaginatedData, Store } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

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
const { filter, handleClearFilter } = useFilters('stores.index', {
    name: props.filters?.name ?? '',
    address: props.filters?.address ?? '',
    email: props.filters?.email ?? '',
    phone_number: props.filters?.phone_number ?? '',
    status: props.filters?.status ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Store Management</template>
        <template #subtitle>
            Manage your stores with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('stores.create')"> Add Store</LinkButton>
        </template>
    </PageHeader>
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
                <PrimaryButton color="danger" @click="handleClearFilter">
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
                        <StatusToggleInput
                            :data="store"
                            :action="route('stores.update', store.id)"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton :href="route('stores.edit', store.id)">
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="route('stores.destroy', store.id)"
                        >
                            Delete
                        </DeleteButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="stores.meta" />
    </div>
</template>
