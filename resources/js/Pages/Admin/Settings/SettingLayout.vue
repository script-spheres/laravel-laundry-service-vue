<script setup lang="ts">
import { LinkButton, PrimaryButton } from '@/Components/Buttons';
import {
    InputError,
    InputLabel,
    SelectInput,
    TextInput,
} from '@/Components/Form';
import { Card } from '@/Components/Panel';
import useReservation from '@/services/reservation.ts';
import { onMounted, reactive } from 'vue';

import useTable from '@/services/DataTable.ts';
import useOutlet from '@/services/outlet.ts';

const bookingStatusOptions = reactive({
    approve: 'approve',
    decline: 'decline',
    pending: 'pending',
});
const outletOptions = reactive({});
const tableOptions = reactive({});

const {
    reservation,
    errors,
    processing,
    createReservation,
    getReservation,
    updateReservation,
} = useReservation();
const { tables, fetchTables } = useTable();
const { outlets, fetchOutlets } = useOutlet();

const form = reactive({
    outlet_id: '',
    customer_name: '',
    customer_phone: '',
    no_of_people: '',
    booking_date: '',
    start_time: '',
    end_time: '',
    customer_notes: '',
    table_id: '',
    booking_status: '',
});

onMounted(async () => {
    await fetchTables();
    await fetchOutlets();

    // Populate tableOptions from the fetched tables
    tables.value.data.forEach((table) => {
        tableOptions[table.id] = table.table_no;
    });

    // Populate outletOptions (assuming fetchOutlets returns a similar structure)
    outlets.value.data.forEach((outlet) => {
        outletOptions[outlet.id] = outlet.name;
    });

    if (route.params.id) {
        try {
            await getReservation(route.params.id);
            Object.assign(form, reservation.value.data);
        } catch (error) {
            toast.error('Error loading reservation.');
            console.error('Reservation loading error:', error);
        }
    }
});

const submitForm = async () => {
    try {
        if (route.params.id) {
            await updateReservation(route.params.id, { ...form });
            toast.success('Reservation updated successfully!');
        } else {
            await createReservation({ ...form });
            toast.success('Reservation created successfully!');
        }
        await router.push({ name: 'reservation.index' });
    } catch (error) {
        toast.error('Error saving reservation.');
        console.error('Reservation saving error:', error);
    }
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{
                        route.params.id
                            ? 'Edit Reservation'
                            : 'Create New Reservation'
                    }}
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ route.params.id ? 'existing' : 'new' }} reservation.
            </p>
        </div>
        <LinkButton :to="{ name: 'reservation.index' }">Back</LinkButton>
    </div>
    <Card class="mx-auto mt-6">
        <form @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="outlet_id" value="Outlet" />
                    <SelectInput
                        v-model="form.outlet_id"
                        :options="outletOptions"
                    />
                    <InputError :message="errors.outlet_id" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="table_id" value="Table No" />
                    <SelectInput
                        v-model="form.table_id"
                        :options="tableOptions"
                    />
                    <InputError :message="errors.table_id" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="customer_name" value="Customer Name" />
                    <TextInput v-model="form.customer_name" />
                    <InputError :message="errors.customer_name" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="customer_phone" value="Customer Phone" />
                    <TextInput v-model="form.customer_phone" />
                    <InputError :message="errors.customer_phone" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="no_of_people" value="Total Person" />
                    <TextInput
                        v-model="form.no_of_people"
                        placeholder="Enter total person"
                    />
                    <InputError :message="errors.no_of_people" />
                </div>
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="booking_date" value="Date" />
                    <TextInput v-model="form.booking_date" type="date" />
                    <InputError :message="errors.booking_date" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="start_time" value="Start Time" />
                    <TextInput v-model="form.start_time" type="time" />
                    <InputError :message="errors.start_time" />
                </div>
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="end_time" value="End Time" />
                    <TextInput v-model="form.end_time" type="time" />
                    <InputError :message="errors.end_time" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="booking_status" value="Booking Status" />
                    <SelectInput
                        v-model="form.booking_status"
                        :options="bookingStatusOptions"
                    />
                    <InputError :message="errors.booking_status" />
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    type="submit"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :to="{ name: 'reservation.index' }" color="red"
                    >Cancel</LinkButton
                >
            </div>
        </form>
    </Card>
</template>
