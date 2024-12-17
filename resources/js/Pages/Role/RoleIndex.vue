<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteButton from '@/Shared/DeleteButton.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { PaginatedData, Role } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    roles: {
        type: Object as PropType<PaginatedData<Role>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('roles.index', {
    name: props.filters?.name ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Role Management </template>
        <template #subtitle>
            Manage your roles with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('roles.create')"> Add Role </LinkButton>
        </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <FieldRow :cols="{ sm: 2, md: 4 }">
            <FieldCol>
                <InputText
                    label="Name"
                    v-model="filter.name"
                    placeholder="Filter by Role Name"
                />
            </FieldCol>
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
    </Card>

    <DataTable>
        <TableHead>
            <TableHeadCell>Name</TableHeadCell>
            <TableHeadCell>Permissions</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="role in roles.data" :key="role.id">
                <TableCell>{{ role.name }}</TableCell>
                <TableCell>{{ role.permissions.map(p => p.name).join(', ') }}</TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('roles.edit', role.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('roles.destroy', role.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>

    <Pagination :links="roles.meta" />
</template>
