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
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import ToggleInput from '@/Components/Form/InputToggle.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PaginatedData, User } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    users: {
        type: Object as PropType<PaginatedData<any>>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const filter = reactive<Filters>({
    name: props.filters?.name ?? '',
    email: props.filters?.email ?? '',
    role: props.filters?.role ?? '',
    status: props.filters?.status ?? '',
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this user?')) return;

    router.delete(route('users.destroy', id), {
        preserveScroll: true,
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

const handleActiveStatusChange = async (user: User, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...user, status: newStatus };
    router.put(route('users.update', user.id), data, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};

watch(filter, (newFilters) => {
    const { name, email, role, status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(email && { 'filter[email]': email }),
        ...(role && { 'filter[role]': role }),
        ...(status && { 'filter[status]': status }),
    };

    router.get(route('users.index'), filterParams, {
        preserveScroll: true,
    });
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                User Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your users with filters and actions.
            </p>
        </div>
        <div>
            <LinkButton :href="route('users.create')"> Add User </LinkButton>
        </div>
    </div>

    <Card class="mb-6 p-4">
        <div class="flex items-center gap-x-3">
            <div class="mb-6 w-full md:w-1/3">
                <InputLabel for="name" value="Name" />
                <InputText v-model="filter.name" placeholder="Search by name" />
            </div>
            <div class="mb-6 w-full md:w-1/3">
                <InputLabel for="email" value="Email" />
                <InputText
                    v-model="filter.email"
                    placeholder="Search by email"
                />
            </div>
            <div class="mb-6 w-full md:w-1/3">
                <InputLabel for="role" value="Role" />
                <InputSelect
                    v-model="filter.role"
                    :options="['Admin', 'User']"
                    placeholder="Select role"
                />
            </div>
            <div class="mb-6 w-full md:w-1/2">
                <InputLabel for="status" value="Status" />
                <InputSelect
                    v-model="filter.status"
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
                <TableHeadCell>Email</TableHeadCell>
                <TableHeadCell>Role</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="user in users.data" :key="user.id">
                    <TableCell>{{ user.name }}</TableCell>
                    <TableCell>{{ user.email }}</TableCell>
                    <TableCell>{{ user.role }}</TableCell>
                    <TableCell>
                        <ToggleInput
                            :modelValue="user.status === 'active'"
                            @change="handleActiveStatusChange(user, $event)"
                        />
                    </TableCell>
                    <TableCell class="space-x-2 text-right">
                        <LinkButton :href="route('users.edit', user.id)">
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(user.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="users.meta" />
    </div>
</template>
