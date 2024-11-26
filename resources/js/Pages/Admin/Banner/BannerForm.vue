<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FilepondInput from '@/Components/Form/FilepondInput.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Banner } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    banner: {
        type: Object as PropType<Banner>,
        required: false,
    },
});

const { banner } = props;

const method = banner ? 'put' : 'post';
const url = banner
    ? route('admin.banners.update', banner.id)
    : route('admin.banners.store');

const form = useForm(method, url, {
    title: banner?.title || '',
    description: banner?.description || '',
    image: banner?.image || {},
    new_image: null as string | null,
    active_status: banner?.active_status || '',
});

const handleFileProcess = (error: any, file: any) => {
    if (!error && file?.serverId) {
        if (banner) {
            form.new_image = file.serverId;
        } else {
            form.image = file.serverId;
        }
    } else {
        toast.error('Failed to process the file. Please try again.');
    }
};

const handleFileRemoved = () => {
    if (banner) {
        form.new_image = null;
    } else {
        form.image = {};
    }
};

// Submit the form
const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                {{ banner ? 'Edit Banner' : 'Create New Banner' }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ banner ? 'existing' : 'new' }} banner.
            </p>
        </div>
        <LinkButton :href="route('admin.banners.index')">Back</LinkButton>
    </div>
    <Card class="mx-auto mt-6 p-4" variant="default">
        <form @submit.prevent="submitForm">
            <div class="mb-6 flex flex-wrap">
                <div class="w-full px-3 md:w-1/2">
                    <InputLabel for="name" value="Title" />
                    <TextInput v-model="form.title" />
                    <InputError :message="form.errors.title" />
                </div>
                <div class="w-full px-3 md:w-1/2">
                    <InputLabel for="active_status" value="Status" />
                    <SelectInput
                        v-model="form.active_status"
                        :options="statusOptions"
                    />
                    <InputError :message="form.errors.active_status" />
                </div>
            </div>
            <div class="mb-6 flex flex-wrap">
                <div class="w-full px-3">
                    <InputLabel for="description" value="Description" />
                    <TextareaInput v-model="form.description" />
                    <InputError :message="form.errors.description" />
                </div>
            </div>
            <div class="mb-6 flex flex-wrap">
                <div class="md:w-1/1 w-full px-3">
                    <InputLabel for="image" value="Image" />
                    <FilepondInput
                        :files="banner?.image"
                        @processfile="handleFileProcess"
                        @removefile="handleFileRemoved"
                    />
                    <InputError :message="form.errors.image" />
                </div>
            </div>
            <div class="flex gap-3 px-3">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ banner ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.banners.index')">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
