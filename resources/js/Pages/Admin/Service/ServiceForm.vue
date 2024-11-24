<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import SelectInput from '@/Components/Form/SelectInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Service } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    service: {
        type: Object as PropType<Service>,
        required: false,
    },
    storesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const { service } = props;

const method = service ? 'put' : 'post';
const url = service
    ? route('admin.services.update', service.id)
    : route('admin.services.store');

const form = useForm(method, url, {
    service_name: service?.service_name || '',
    description: service?.description || '',
    store_id: service?.store_id || '',
    image: service?.image || '',
    active_status: service?.active_status || '',
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
                    {{ service ? 'Edit Service' : 'Create New Service' }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ service ? 'existing' : 'new' }} service.
                </p>
            </div>
            <LinkButton :href="route('admin.services.index')">Back</LinkButton>
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Service Name"
                            v-model="form.service_name"
                        />
                        <InputError :message="form.errors.service_name" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            value="Description"
                            v-model="form.description"
                            placeholder="Service Description (optional)"
                        />
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Image URL"
                            v-model="form.image"
                            placeholder="Service Image URL (optional)"
                        />
                        <InputError :message="form.errors.image" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <SelectInput
                            v-model="form.store_id"
                            :options="storesOptions"
                            placeholder="Select Store"
                        />
                        <InputError :message="form.errors.store_id" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Active Status"
                            v-model="form.active_status"
                            placeholder="Active or Inactive"
                        />
                        <InputError :message="form.errors.active_status" />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        {{ service ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton
                        :href="route('admin.services.index')"
                        color="red"
                    >
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
