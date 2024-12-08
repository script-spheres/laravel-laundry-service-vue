<script setup lang="ts">
import { PrimaryButton } from '@/Components/Buttons';
import {
    InputError,
    InputLabel,
    InputSelect,
    InputText,
    InputTextarea,
} from '@/Components/Form';
import { Modal } from '@/Components/Modal';
import { reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    mode: String,
    outlets: Array | Object,
});

const initialForm = {
    outlet_id: '',
    customer_name: '',
    customer_phone: '',
    no_of_people: '',
    booking_date: '',
    start_time: '',
    end_time: '',
    customer_notes: '',
};

const form = reactive({ ...initialForm });

const onSubmit = async () => {
    try {
        await createReservation(form);
        Object.assign(form, initialForm);
        closeReservationOrderModal();
        toast.success(`Reservation created successfully!`);
    } catch {
        toast.error('Error loading brand.');
    }
};

// Watch for modal state change
watch(showReservationOrderModal, (newVal) => {
    if (!newVal) {
        errors.value = {};
    }
});
</script>

<template>
    <!-- Reservation modal -->
    <Modal
        :show="showReservationOrderModal"
        @close="closeReservationOrderModal"
    >
        <form class="w-full p-4" @submit.prevent="onSubmit">
            <p class="mb-2 text-2xl">Let's get ordering</p>
            <p class="text-md mb-4">Set your pickup location to get started.</p>
            <div class="mb-6">
                <InputLabel for="location" value="Outlet" />
                <InputSelect
                    id="pac-input"
                    v-model="form.outlet_id"
                    :options="outlets"
                />
                <InputError :message="errors.outlet_id" />
            </div>

            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="customer_name" value="Name" />
                    <InputText
                        v-model="form.customer_name"
                        placeholder="Enter your name"
                    />
                    <InputError :message="errors.customer_name" />
                </div>

                <div class="w-1/2 px-3">
                    <InputLabel for="customer_phone" value="Phone" />
                    <InputText
                        v-model="form.customer_phone"
                        placeholder="Enter your phone"
                    />
                    <InputError :message="errors.customer_phone" />
                </div>
            </div>

            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="no_of_people" value="Total Person" />
                    <InputText
                        v-model="form.no_of_people"
                        placeholder="Enter total person"
                        type="number"
                    />
                    <InputError :message="errors.no_of_people" class="mt-2" />
                </div>
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="booking_date" value="Date" />
                    <InputText v-model="form.booking_date" type="date" />
                    <InputError :message="errors.booking_date" class="mt-2" />
                </div>
            </div>

            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="start_time" value="Start Time" />
                    <InputText v-model="form.start_time" type="time" />
                    <InputError :message="errors.start_time" class="mt-2" />
                </div>
                <div class="mb-6 w-1/2 px-3 md:mb-0">
                    <InputLabel for="end_time" value="End Time" />
                    <InputText v-model="form.end_time" type="time" />
                    <InputError :message="errors.end_time" class="mt-2" />
                </div>
            </div>

            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="w-full px-3">
                    <InputLabel for="customer_notes" value="Notes" />
                    <InputTextarea
                        v-model="form.customer_notes"
                        placeholder="Enter any notes"
                    />
                    <InputError :message="errors.customer_notes" class="mt-2" />
                </div>
            </div>

            <PrimaryButton :disabled="processing" class="w-full" type="submit">
                Confirm Reservation
            </PrimaryButton>
        </form>
    </Modal>
</template>
