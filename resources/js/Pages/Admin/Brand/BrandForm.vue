<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FilepondInput from '@/Components/Form/FilepondInput.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Brand } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    brand: {
        type: Object as PropType<Brand>,
        required: false,
    },
});

const { brand } = props;

const method = brand ? 'put' : 'post';
const url = brand
    ? route('admin.brands.update', brand.id)
    : route('admin.brands.store');

const form = useForm(method, url, {
    name: brand?.name || '',
    image: brand?.image || '',
    description: brand?.description || '',
    active_status: brand?.active_status || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => toast.success(props?.flash?.message),
    });
};

// Handlers for Filepond (optional, if using file upload)
const handleFileProcess = (file: any) => {
    // Handle file processing logic here
};

const handleFileRemoved = () => {
    // Handle file removal logic here
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{ brand ? 'Edit Brand' : 'Create New Brand' }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ brand ? 'existing' : 'new' }} brand.
                </p>
            </div>
            <LinkButton :href="route('admin.brands.index')">Back</LinkButton>
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" v-model="form.name" type="text" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <InputLabel for="active_status" value="Status" />
                        <SelectInput
                            v-model="form.active_status"
                            :options="statusOptions"
                        />
                        <InputError
                            :message="form.errors.active_status"
                            class="mt-2"
                        />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <InputLabel for="description" value="Description" />
                        <TextareaInput
                            id="description"
                            v-model="form.description"
                        />
                        <InputError
                            :message="form.errors.description"
                            class="mt-2"
                        />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <InputLabel for="image" value="Image" />
                        <FilepondInput
                            ref="filepondImageInput"
                            :allow-file-poster="!!brand"
                            :files="brand?.image"
                            name="file"
                            @processfile="handleFileProcess"
                            @removefile="handleFileRemoved"
                        />
                        <InputError :message="form.errors.image" class="mt-2" />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        {{ brand ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton :href="route('admin.brands.index')" color="red">
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
