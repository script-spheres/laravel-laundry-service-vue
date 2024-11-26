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
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FlashMessage, Ingredient, PaginatedData } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    ingredients: {
        type: Object as PropType<PaginatedData<Ingredient>>,
        required: true,
    },
    unitsOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
    },
    flash: {
        type: Object as PropType<FlashMessage>,
        required: false,
    },
});

const filter = reactive({
    name: props.filters?.name ?? '',
    unit_id: props.filters?.unit_id ?? '',
    active_status: props.filters?.active_status ?? '',
});

const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this ingredient?'))
        return;

    router.delete(route('admin.ingredients.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

const handleActiveStatusChange = async (
    ingredient: Ingredient,
    event: Event,
) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...ingredient, active_status: newStatus };
    router.put(route('admin.ingredients.update', ingredient.id), data, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};

watch(filter, (newFilters) => {
    const { name, unit_id, active_status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(unit_id && { 'filter[unit_id]': unit_id }),
        ...(active_status && { 'filter[active_status]': active_status }),
    };

    router.get(route('admin.ingredients.index'), filterParams, {
        preserveScroll: true,
        replace: true,
    });
});
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                Ingredient Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your ingredients with filters and actions.
            </p>
        </div>
        <div>
            <LinkButton :href="route('admin.ingredients.create')">
                Add Ingredient
            </LinkButton>
        </div>
    </div>

    <Card class="mb-6 p-6">
        <div class="flex items-center gap-x-3">
            <div class="w-full md:w-1/2">
                <InputLabel for="name" value="Name" />
                <TextInput v-model="filter.name" placeholder="Search by name" />
            </div>
            <div class="w-full md:w-1/2">
                <InputLabel for="unit_id" value="Unit" />
                <SelectInput
                    v-model="filter.unit_id"
                    :options="unitsOptions"
                    placeholder="Select unit"
                />
            </div>
            <div class="w-full md:w-1/2">
                <InputLabel for="active_status" value="Status" />
                <SelectInput
                    v-model="filter.active_status"
                    :options="statusOptions"
                    placeholder="Select status"
                />
            </div>
            <div class="flex-none gap-2 self-end">
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
                <TableHeadCell>Unit</TableHeadCell>
                <TableHeadCell>Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="ingredient in ingredients.data"
                    :key="ingredient.id"
                >
                    <TableCell>{{ ingredient.name }}</TableCell>
                    <TableCell>{{ ingredient.unit.actual_name }}</TableCell>
                    <TableCell>
                        <ToggleInput
                            :modelValue="ingredient.active_status === 'active'"
                            @change="
                                handleActiveStatusChange(ingredient, $event)
                            "
                        />
                    </TableCell>
                    <TableCell class="space-x-2 text-right">
                        <LinkButton
                            :href="
                                route('admin.ingredients.edit', ingredient.id)
                            "
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(ingredient.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="ingredients.meta" />
    </div>
</template>
