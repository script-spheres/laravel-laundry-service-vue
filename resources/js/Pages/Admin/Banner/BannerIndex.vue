<script setup lang="ts">
import Badge from '@/Components/Badges/Badge.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Datalist from '@/Components/DataList/Datalist.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import PageHeader from '@/Components/PageHeader.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Banner, PaginatedData } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AdminLayout });

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

const { filter, handleClearFilter } = useFilters('admin.banners.index', {
    title: filters?.title ?? '',
    active_status: filters?.active_status ?? '',
});
console.log(filter);
</script>

<template>
    <PageHeader>
        <template #title> Banner Management </template>
        <template #subtitle>
            Manage your banners with filters and actions.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.banners.create')">
                Add Banner
            </LinkButton>
        </template>
    </PageHeader>
    <Card class="mb-6 p-6">
        <FieldRow class="flex md:grid-cols-4">
            <FieldCol>
                <TextInput
                    label="Banner Title"
                    v-model="filter.title"
                    placeholder="Filter by Title"
                />
            </FieldCol>
            <FieldCol>
                <SelectInput
                    label="Status"
                    v-model="filter.active_status"
                    :options="{ active: 'Active', inactive: 'Inactive' }"
                    placeholder="Filter by Active Status"
                />
            </FieldCol>
            <FieldCol class="flex-none gap-2 self-end">
                <PrimaryButton color="gray" @click="handleClearFilter">
                    Clear Filters
                </PrimaryButton>
            </FieldCol>
        </FieldRow>
    </Card>
    <Datalist class="mb-2" v-for="banner in banners.data" :key="banner.id">
        <template #content>
            <div class="gap-2 md:flex">
                <ImagePreview
                    class="md:h-auto md:w-24"
                    :src="banner.image?.url"
                />
                <div class="">
                    <strong
                        >{{ banner.title }}
                        <Badge>{{ banner.active_status }}</Badge></strong
                    >
                    <p>{{ banner.description }}</p>
                    <div class="flex gap-2">
                        <LinkButton
                            :href="route('admin.banners.edit', banner.id)"
                        >
                            Edit
                        </LinkButton>
                        <DeleteButton
                            :action="route('admin.banners.destroy', banner.id)"
                        >
                            Delete
                        </DeleteButton>
                    </div>
                </div>
            </div>
        </template>
    </Datalist>
    <Pagination :links="banners.meta" />
</template>
