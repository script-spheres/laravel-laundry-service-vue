<script setup lang="ts">
import { PrimaryButton } from '@/Components/Buttons';
import { InputError, InputLabel, InputSelect } from '@/Components/Form';
import { Modal } from '@/Components/Modal';
import { useLocationStore } from '@/Stores/LocationStore';
import { reactive, ref } from 'vue';

const props = defineProps({
    outlets: Array,
    show: Boolean,
});

const form = reactive({
    outlet: '',
});

const { setOutlet, setOrderType } = useLocationStore();
const errors = reactive({
    outlet: '',
});

const processing = ref(false);

const submitOrder = async () => {
    try {
        // Perform manual validation
        if (!validateForm()) {
            return;
        }

        // Set outlet and order type in the store
        setOutlet(form.outlet);
        setOrderType('pickup');

        // Close the modal
        closePickupOrderModal();

        // Use Inertia to navigate to the product page
        await Inertia.visit('/product');
    } catch (err) {
        console.error('Order submission failed:', err);
    } finally {
        processing.value = false;
    }
};
</script>

<template>
    <Modal :show="props.show" @close="closePickupOrderModal">
        <form class="w-full p-4" @submit.prevent="submitOrder">
            <p class="mb-2 text-2xl">Let's get ordering</p>
            <p class="text-md mb-4">Set your pickup location to get started.</p>

            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="outlet" value="Select Outlet" />
                    <InputSelect
                        v-model="form.outlet"
                        :options="props.outlets"
                        placeholder="Select an outlet"
                    />
                    <InputError :message="errors.outlet" class="mt-2" />
                </div>
            </div>

            <PrimaryButton :disabled="processing" class="w-full" type="submit">
                Confirm and Order Now
            </PrimaryButton>
        </form>
    </Modal>
</template>
