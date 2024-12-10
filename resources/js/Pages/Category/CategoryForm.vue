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
import { Category } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    category: {
        type: Object as PropType<Category>,
        required: false,
    },
});

const { category } = props;

const method = category ? 'put' : 'post';
const url = category
    ? route('categories.update', category.id)
    : route('categories.store');

const form = useForm(method, url, {
    name: category?.name || '',
    description: category?.description || null,
    image: category?.image || null,
    new_image: null,
    active_status: category?.active_status || '',
});

const updateImage = (fileId: string | null) => {
    if (category) {
        form.new_image = fileId;
    } else {
        form.image = fileId;
    }
};

const handleFileProcess = (error: any, file: any) => {
    if (!error) {
        updateImage(file.serverId);
    }
};

const handleFileRemoved = () => {
    updateImage(null);
};

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
                {{ category ? 'Edit' : 'Create New' }} Category
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ category ? 'existing' : 'new' }} category.
            </p>
        </div>
        <LinkButton :href="route('categories.index')">Back</LinkButton>
    </div>
    <Card class="mx-auto mt-6 p-4" variant="default">
        <form @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:w-1/2">
                    <InputLabel for="name" value="Title" />
                    <TextInput v-model="form.name" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div class="mb-6 w-full px-3 md:w-1/2">
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
                <div class="mb-6 w-full px-3">
                    <InputLabel for="description" value="Description" />
                    <TextareaInput v-model="form.description" />
                    <InputError
                        :message="form.errors.description"
                        class="mt-2"
                    />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3">
                    <InputLabel for="image" value="Image" />
                    <FilepondInput
                        ref="filepondImageInput"
                        :allow-file-poster="!!category"
                        :files="category ? [{ serverId: form.image }] : []"
                        name="file"
                        @processfile="handleFileProcess"
                        @removefile="handleFileRemoved"
                    />
                    <InputError :message="form.errors.image" class="mt-2" />
                </div>
            </div>
            <div class="flex gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    color="gray"
                    type="submit"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :href="route('categories.index')" color="red">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
