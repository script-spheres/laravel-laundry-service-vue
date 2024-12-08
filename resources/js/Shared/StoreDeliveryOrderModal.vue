<script setup lang="ts">
import { useLocationStore } from '@/Stores/LocationStore';
import { reactive, ref } from 'vue';

const props = defineProps({ mode: String, outlets: Object });

const { setOutlet, setOrderType, setLocation } = useLocationStore();
const apiKey = import.meta.env.VITE_GOOGLE_MAP_API_KEY;

const form = reactive({ outlet: '', location: '' });
const currLocation = ref(null);
const errors = reactive({});
const processing = ref(false);

const validationSchema = Yup.object().shape({
    outlet: Yup.string().required('Outlet is required'),
    location: Yup.string().required('Location is required'),
});

const onPlaceChanged = (place) => {
    currLocation.value =
        place && place.geometry
            ? {
                  full_address: place.formatted_address,
                  latitude: place.geometry.location.lat(),
                  longitude: place.geometry.location.lng(),
              }
            : null;

    form.location = currLocation.value?.full_address || '';
};

const submitOrder = async () => {
    try {
        processing.value = true;
        await validationSchema.validate(form, { abortEarly: false });

        setOutlet(form.outlet);
        setOrderType(props.mode);
        setLocation(currLocation.value);
        closeDeliveryOrderModal();
        await router.push({ name: 'product' });
    } catch (err) {
        Object.keys(errors).forEach((key) => delete errors[key]);
        err.inner.forEach((e) => (errors[e.path] = e.message)); // Simplified error handling
    } finally {
        processing.value = false;
    }
};
</script>

<template>
    <Modal :show="showDeliveryOrderModal" @close="closeDeliveryOrderModal">
        <form class="w-full p-4" @submit.prevent="submitOrder">
            <p class="mb-2 text-2xl">Let's get ordering</p>
            <p class="text-md mb-4">
                Set outlet and your delivery location to get started.
            </p>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="outlet" value="Select Outlet" />
                    <InputSelect
                        v-model="form.outlet"
                        :options="outlets"
                        placeholder="Select an outlet"
                    />
                    <InputError :message="errors.outlet" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="location" value="Address" />
                    <GoogleAddressAutocomplete
                        :apiKey="apiKey"
                        class="w-full"
                        @callback="onPlaceChanged"
                    />
                    <InputError :message="errors.location" class="mt-2" />
                </div>
            </div>
            <Button :disabled="processing" class="w-full" type="submit">
                Confirm and Order Now
            </Button>
        </form>
    </Modal>
</template>
