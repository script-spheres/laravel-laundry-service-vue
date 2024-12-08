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
import PageHeader from '@/Components/PageHeader.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { daysOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PaginatedData, Timeslot } from '@/types';
import { PropType } from 'vue';

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
const { filter, handleClearFilter } = useFilters('admin.timeslots.index', {
    day: props.filters?.day ?? '',
});
</script>

<template>
    <PageHeader>
        <template #title> Timeslot Management </template>
        <template #subtitle>
            Manage your timeslots with filters and actions.
        </template>
        <template #actions> </template>
    </PageHeader>

    <Card class="mb-6 p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-4">
            <div class="w-full md:mb-0 md:w-1/4">
                <InputLabel for="day" value="Day" />
                <InputSelect
                    v-model="filter.day"
                    :options="daysOptions"
                    placeholder="Filter by Day"
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
                <TableHeadCell>Day</TableHeadCell>
                <TableHeadCell>Timeslots</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="timeslot in timeslots.data" :key="timeslot.id">
                    <TableCell>{{ timeslot.day }}</TableCell>
                    <TableCell>{{ timeslot.timeslots }}</TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <LinkButton
                            :href="route('admin.timeslots.edit', timeslot.id)"
                        >
                            Edit
                        </LinkButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="timeslots.meta" />
    </div>
</template>
