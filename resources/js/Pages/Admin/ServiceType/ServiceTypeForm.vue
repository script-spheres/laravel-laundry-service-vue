<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ServiceType } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    serviceType: {
        type: Object as PropType<ServiceType>,
        required: false,
    },
});

const { serviceType } = props;

const method = serviceType ? 'put' : 'post';
const url = serviceType
    ? route('admin.service-types.update', serviceType.id)
    : route('admin.service-types.store');

const form = useForm(method, url, {
    type_name: serviceType?.type_name || '',
    description: serviceType?.description || '',
    active_status: serviceType?.active_status || '',
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
                    {{ serviceType ? 'Edit ' : 'Create New' }} Service Type
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ serviceType ? 'existing' : 'new' }} service type.
                </p>
            </div>
            <LinkButton :href="route('admin.service-types.index')"
                >Back</LinkButton
            >
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Service Type Name"
                            v-model="form.type_name"
                            type="text"
                        />
                        <InputError
                            :message="form.errors.type_name"
                            class="mt-2"
                        />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            value="Description"
                            v-model="form.description"
                            placeholder="Service Type Description (optional)"
                        />
                        <InputError
                            :message="form.errors.description"
                            class="mt-2"
                        />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Active Status"
                            v-model="form.active_status"
                            type="text"
                        />
                        <InputError
                            :message="form.errors.active_status"
                            class="mt-2"
                        />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        {{ serviceType ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton :href="route('admin.service-types.index')">
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
