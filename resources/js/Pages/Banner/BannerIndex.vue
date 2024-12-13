<script setup lang="ts">
import DeleteButton from '@/Shared/DeleteButton.vue';
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
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import StatusToggleInput from '@/Shared/StatusToggleInput.vue';
import { Banner, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const { filters } = defineProps({
    banners: {
        type: Object as PropType<PaginatedData<Banner>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter, handleClearFilter } = useFilters('banners.index', {
    title: filters?.title ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Banner Management </template>
        <template #subtitle>
            Manage your banners with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('banners.create')">
                Add Banner
            </LinkButton>
        </template>
    </PageHeader>
    <Card class="mb-6 p-6">
        <FieldRow class="flex md:grid-cols-4">
            <FieldCol>
                <InputText
                    label="Banner Title"
                    v-model="filter.title"
                    placeholder="Filter by Title"
                />
            </FieldCol>
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
    </Card>
    <DataTable class="mt-4">
        <TableHead>
            <TableHeadCell>Image</TableHeadCell>
            <TableHeadCell>Title</TableHeadCell>
            <TableHeadCell class="text-right">Status</TableHeadCell>
            <TableHeadCell class="text-right">Actions</TableHeadCell>
        </TableHead>
        <TableBody>
            <TableRow v-for="banner in banners.data" :key="banner.id">
                <TableCell>
                    <ImagePreview :src="banner.image.url" class="h-10 w-10" />
                </TableCell>
                <TableCell>{{ banner.title }}</TableCell>
                <TableCell class="text-right">
                    <StatusToggleInput
                        :action="route('banners.update', banner.id)"
                        :data="banner"
                    />
                </TableCell>
                <TableCell class="flex justify-end gap-2">
                    <LinkButton :href="route('banners.edit', banner.id)">
                        Edit
                    </LinkButton>
                    <DeleteButton :action="route('banners.destroy', banner.id)">
                        Delete
                    </DeleteButton>
                </TableCell>
            </TableRow>
        </TableBody>
    </DataTable>
    <Pagination :links="banners.meta" />
</template>
