<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

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
    email: store?.email || '',
    phone_number: store?.phone_number || '',
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
                    {{ store ? 'Edit Store' : 'Create New Store' }}
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
                        <TextInput value="Store Name" v-model="form.name" />
                        <InputError :message="form.errors.name" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            value="Address"
                            v-model="form.address"
                            placeholder="Store Address (optional)"
                        />
                        <InputError :message="form.errors.address" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Email"
                            v-model="form.email"
                            type="email"
                        />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Phone Number"
                            v-model="form.phone_number"
                        />
                        <InputError :message="form.errors.phone_number" />
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
                    <LinkButton :href="route('admin.stores.index')" color="red">
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
