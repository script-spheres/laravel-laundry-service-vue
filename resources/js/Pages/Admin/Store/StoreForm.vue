<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import NumberInput from '@/Components/Form/NumberInput.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Store } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    store: {
        type: Object as PropType<Store>,
        required: false,
    },
});

const { store } = props;

const method = store ? 'put' : 'post';
const url = store
    ? route('admin.stores.update', store.id)
    : route('admin.stores.store');

const form = useForm(method, url, {
    name: store?.name || '',
    address: store?.address || '',
    address_lat: store?.address_lat || '',
    address_long: store?.address_long || '',
    email: store?.email || '',
    phone_number: store?.phone_number || '',
    manager_name: store?.manager_name || '',
    manager_email: store?.manager_email || '',
    manager_phone_number: store?.manager_phone_number || '',
    additional_info: store?.additional_info || '',
    store_code: store?.store_code || '',
    status: store?.status || 'active',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{ store ? 'Edit' : 'Create New' }} Store
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ store ? 'existing' : 'new' }} store.
                </p>
            </div>
            <LinkButton :href="route('admin.stores.index')">Back</LinkButton>
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput label="Store Name" v-model="form.name" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Store Code"
                            v-model="form.store_code"
                        />
                        <InputError :message="form.errors.store_code" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <TextareaInput label="Address" v-model="form.address" />
                        <InputError :message="form.errors.address" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            label="Address Latitude"
                            v-model="form.address_lat"
                            type="number"
                            step="0.0000001"
                        />
                        <InputError :message="form.errors.address_lat" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            label="Address Longitude"
                            v-model="form.address_long"
                            type="number"
                            step="0.0000001"
                        />
                        <InputError :message="form.errors.address_long" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Email"
                            v-model="form.email"
                            type="email"
                        />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Phone Number"
                            v-model="form.phone_number"
                        />
                        <InputError :message="form.errors.phone_number" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Manager Name"
                            v-model="form.manager_name"
                        />
                        <InputError :message="form.errors.manager_name" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Manager Email"
                            v-model="form.manager_email"
                            type="email"
                        />
                        <InputError :message="form.errors.manager_email" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Manager Phone Number"
                            v-model="form.manager_phone_number"
                        />
                        <InputError
                            :message="form.errors.manager_phone_number"
                        />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <SelectInput
                            label="Status"
                            v-model="form.status"
                            :options="statusOptions"
                        />
                        <InputError :message="form.errors.status" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="md:w-1/1 mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            label="Additional Info"
                            v-model="form.additional_info"
                        />
                        <InputError :message="form.errors.additional_info" />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        {{ store ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton :href="route('admin.stores.index')">
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
