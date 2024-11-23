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
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PaginatedData, Timeslot } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    timeslots: {
        type: Object as PropType<PaginatedData<Timeslot>>,
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
    active_status: props.filters?.active_status ?? '',
    day: props.filters?.day ?? '',
    start_time: props.filters?.start_time ?? '',
    end_time: props.filters?.end_time ?? '',
});

// Watch for filter changes and trigger data refresh
watch(filter, (newFilters) => {
    const { active_status, day, start_time, end_time } = newFilters;

    const filterParams: Record<string, string> = {
        ...(active_status && { 'filter[active_status]': active_status }),
        ...(day && { 'filter[day]': day }),
        ...(start_time && { 'filter[start_time]': start_time }),
        ...(end_time && { 'filter[end_time]': end_time }),
    };

    router.get(route('admin.timeslots.index'), filterParams, {
        preserveScroll: true,
    });
});

// Delete a timeslot
const deleteData = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this timeslot?'))
        return;

    router.delete(route('admin.timeslots.destroy', id), {
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Clear all filters
const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

// Toggle timeslot active status
const handleActiveStatusChange = (timeslot: Timeslot, event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    const data = { ...timeslot, active_status: newStatus };
    router.put(route('admin.timeslots.update', timeslot.id), data, {
        onSuccess: () => toast.success('Timeslot status updated successfully.'),
    });
};
</script>

<template>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Timeslot Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Manage your timeslots with filters and actions.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.timeslots.create')">
                Add Timeslot
            </LinkButton>
        </div>
    </div>
    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="day" value="Day" />
                <SelectInput
                    v-model="filter.day"
                    :options="dayOptions"
                    placeholder="Filter by Day"
                />
            </div>
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="active_status" value="Status" />
                <SelectInput
                    v-model="filter.active_status"
                    :options="statusOptions"
                    placeholder="Filter by Active Status"
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
                <TableHeadCell>Start Time</TableHeadCell>
                <TableHeadCell>End Time</TableHeadCell>
                <TableHeadCell>Day</TableHeadCell>
                <TableHeadCell>Capacity</TableHeadCell>
                <TableHeadCell class="text-right">Status</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="timeslot in timeslots.data" :key="timeslot.id">
                    <TableCell>{{ timeslot.start_time }}</TableCell>
                    <TableCell>{{ timeslot.end_time }}</TableCell>
                    <TableCell>{{ timeslot.day }}</TableCell>
                    <TableCell>{{ timeslot.capacity }}</TableCell>
                    <TableCell class="text-right">
                        <ToggleInput
                            :modelValue="timeslot.active_status === 'active'"
                            @change="handleActiveStatusChange(timeslot, $event)"
                        />
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.timeslots.edit', timeslot.id)"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton @click="deleteData(timeslot.id)">
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="timeslots.meta" />
    </div>
</template>
