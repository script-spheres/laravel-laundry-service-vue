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
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FlashMessage, PaginatedData, Supplier } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

defineProps({
    suppliers: {
        type: Object as PropType<PaginatedData<Supplier>>,
        required: true,
    },
    filters: Object as PropType<Filters>,
    flash: Object as PropType<FlashMessage>,
});

const filters = reactive({
    name: '',
    contact: '',
    status: '',
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this supplier?'))
        return;

    router.delete(route('admin.suppliers.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

watch(filters, (newFilters) => {
    const { name, contact, status } = newFilters;

    const filterParams = {
        ...(name && { 'filter[name]': name }),
        ...(contact && { 'filter[contact]': contact }),
        ...(status && { 'filter[status]': status }),
    };

    router.get(route('admin.suppliers.index'), filterParams, {
        preserveState: true,
        preserveScroll: true,
        only: ['suppliers'],
    });
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Supplier Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your suppliers with filters and actions.
            </p>
        </div>
        <div>
            <LinkButton
                :to="{ name: 'supplier.create' }"
                class="btn btn-primary"
            >
                Add Supplier
            </LinkButton>
        </div>
    </div>

    <Card class="mb-6">
        <div class="flex items-center gap-x-3">
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="filter.name"
                    placeholder="Search by name"
                    type="text"
                />
            </div>
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="contact" value="Contact" />
                <TextInput
                    id="contact"
                    v-model="filter.contact"
                    placeholder="Search by contact"
                    type="text"
                />
            </div>
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="status" value="Status" />
                <SelectInput
                    id="status"
                    v-model="filter.status"
                    :options="['Active', 'Inactive']"
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
                <TableHeadCell>Contact</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="supplier in suppliers.data" :key="supplier.id">
                    <TableCell>{{ supplier.name }}</TableCell>
                    <TableCell>{{ supplier.contact }}</TableCell>
                    <TableCell>{{ supplier.status }}</TableCell>
                    <TableCell class="text-right">
                        <LinkButton
                            :to="{
                                name: 'supplier.edit',
                                params: { id: supplier.id },
                            }"
                            color="green"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton
                            color="red"
                            size="small"
                            @click="deleteData(supplier.id)"
                        >
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="suppliers.meta" />
    </div>
</template>
