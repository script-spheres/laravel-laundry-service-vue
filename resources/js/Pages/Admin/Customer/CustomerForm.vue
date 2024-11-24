<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import EmailInput from '@/Components/Form/EmailInput.vue';
import PhoneInput from '@/Components/Form/PhoneInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Customer } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    customer: {
        type: Object as PropType<Customer>,
        required: false,
    },
});

const { customer } = props;

const method = customer ? 'put' : 'post';
const url = customer
    ? route('admin.customers.update', customer.id)
    : route('admin.customers.store');

const form = useForm(method, url, {
    name: customer?.name || '',
    address: customer?.address || '',
    email: customer?.email || '',
    phone_number: customer?.phone_number || '',
    communication_pref: customer?.communication_pref || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{ customer ? 'Edit Customer' : 'Create New Customer' }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ customer ? 'existing' : 'new' }} customer.
                </p>
            </div>
            <LinkButton :href="route('admin.customers.index')">Back</LinkButton>
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput value="Customer Name" v-model="form.name" />
                        <InputError :message="form.errors.name" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            value="Address"
                            v-model="form.address"
                            placeholder="Customer Address (optional)"
                        />
                        <InputError :message="form.errors.address" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <EmailInput value="Email" v-model="form.email" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <PhoneInput
                            value="Phone Number"
                            v-model="form.phone_number"
                        />
                        <InputError :message="form.errors.phone_number" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextareaInput
                            value="Communication Preferences"
                            v-model="form.communication_pref"
                            placeholder="Communication Preferences (optional)"
                        />
                        <InputError :message="form.errors.communication_pref" />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        {{ customer ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton
                        :href="route('admin.customers.index')"
                        color="red"
                    >
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
