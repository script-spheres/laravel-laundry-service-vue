<script lang="ts" setup>
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
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    accessory: {
        type: Object as PropType<Accessory>,
        required: true,
    },
    unitsOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const { accessory } = props;

const method = accessory ? 'put' : 'post';
const url = accessory
    ? route('admin.accessories.update', accessory.id)
    : route('admin.accessories.store');

const form = useForm(method, url, {
    name: accessory?.name || '',
    unit_id: accessory?.unit_id || '',
    description: accessory?.description || '',
    active_status: accessory?.active_status || '',
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
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                {{ accessory ? 'Edit' : 'Create New' }} Accessory
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ accessory ? 'existing' : 'new' }} accessory.
            </p>
        </div>
        <LinkButton :href="route('admin.accessories.index')">Back</LinkButton>
    </div>

    <Card class="mx-auto mt-6 p-6">
        <form @submit.prevent="submitForm">
            <div class="mb-6 flex flex-wrap gap-4">
                <div class="w-full md:w-1/2">
                    <InputLabel for="name" value="Name" />
                    <TextInput v-model="form.name" type="text" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div class="w-full md:w-1/2">
                    <InputLabel for="unit_id" value="Unit" />
                    <SelectInput
                        v-model="form.unit_id"
                        :options="unitsOptions"
                    />
                    <InputError :message="form.errors.unit_id" class="mt-2" />
                </div>
            </div>
            <div class="mb-6">
                <InputLabel for="description" value="Description" />
                <TextareaInput v-model="form.description" />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="mb-6">
                <InputLabel for="active_status" value="Status" />
                <SelectInput
                    v-model="form.active_status"
                    :options="statusOptions"
                />
                <InputError :message="form.errors.active_status" class="mt-2" />
            </div>
            <div class="flex gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :href="route('admin.accessories.index')">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
