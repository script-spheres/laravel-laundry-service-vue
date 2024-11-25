<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Unit } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    unit: {
        type: Object as PropType<Unit>,
        required: false,
    },
});

const { unit } = props;

const method = unit ? 'put' : 'post';
const url = unit
    ? route('admin.units.update', unit.id)
    : route('admin.units.store');

const form = useForm(method, url, {
    actual_name: unit?.actual_name || '',
    short_name: unit?.short_name || '',
    allow_decimal: unit?.allow_decimal ?? false,
    active_status: unit?.active_status || '',
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
                {{ unit ? 'Edit Unit' : 'Create New Unit' }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ unit ? 'existing' : 'new' }} unit.
            </p>
        </div>
        <LinkButton :href="route('admin.units.index')">Back</LinkButton>
    </div>
    <Card class="mx-auto mt-6 p-6">
        <form @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:w-1/2">
                    <InputLabel for="actual_name" value="Actual Name" />
                    <TextInput v-model="form.actual_name" type="text" />
                    <InputError
                        :message="form.errors.actual_name"
                        class="mt-2"
                    />
                </div>
                <div class="mb-6 w-full px-3 md:w-1/2">
                    <InputLabel for="short_name" value="Short Name" />
                    <TextInput v-model="form.short_name" type="text" />
                    <InputError
                        :message="form.errors.short_name"
                        class="mt-2"
                    />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:w-1/2">
                    <InputLabel for="allow_decimal" value="Allow Decimal" />
                    <ToggleInput
                        v-model="form.allow_decimal"
                        true-value="yes"
                        false-value="no"
                    />
                    <InputError
                        :message="form.errors.allow_decimal"
                        class="mt-2"
                    />
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
            <div class="flex flex-wrap gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :href="route('admin.units.index')">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
