<script setup lang="ts">
import { useForm } from 'laravel-precognition-vue-inertia';

import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Accessory } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    ingredient: {
        type: Object as PropType<Accessory>,
        required: false,
    },
    unitsOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const { ingredient } = props;

const method = ingredient ? 'put' : 'post';
const url = ingredient
    ? route('admin.ingredients.update', ingredient.id)
    : route('admin.ingredients.store');

const form = useForm(method, url, {
    name: ingredient?.name || '',
    unit_id: ingredient?.unit_id || '',
    description: ingredient?.description || '',
    active_status: ingredient?.active_status || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{ ingredient ? 'Edit' : 'Create New' }} Ingredient
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ ingredient ? 'existing' : 'new' }} ingredient.
            </p>
        </div>
        <LinkButton :href="route('admin.ingredients.index')">Back</LinkButton>
    </div>
    <Card class="mx-auto mt-6 p-6">
        <form @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="name" value="Name" />
                    <TextInput v-model="form.name" type="text" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="unit_id" value="Unit" />
                    <SelectInput
                        v-model="form.unit_id"
                        :options="unitsOptions"
                    />
                    <InputError :message="form.errors.unit_id" class="mt-2" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="description" value="Description" />
                    <TextareaInput v-model="form.description" />
                    <InputError
                        :message="form.errors.description"
                        class="mt-2"
                    />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="md:w-1/1 mb-6 w-full px-3 md:mb-0">
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
            <div class="flex flex-wrap gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :href="route('admin.ingredients.index')">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
