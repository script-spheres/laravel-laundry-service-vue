<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FinancialYear } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    financialYear: {
        type: Object as PropType<FinancialYear>,
        required: false,
    },
});

const { financialYear } = props;

const method = financialYear ? 'put' : 'post';
const url = financialYear
    ? route('admin.financial-years.update', financialYear.id)
    : route('admin.financial-years.store');

const form = useForm(method, url, {
    name: financialYear?.name || '',
    start_date: financialYear?.start_date || '',
    end_date: financialYear?.end_date || '',
    active_status: financialYear?.active_status || 'active',
    description: financialYear?.description || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{ financialYear ? 'Edit' : 'Create New' }} Financial Year
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ financialYear ? 'existing' : 'new' }} financial year.
                </p>
            </div>
            <LinkButton :href="route('admin.financial-years.index')"
                >Back</LinkButton
            >
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Financial Year Name"
                            v-model="form.name"
                        />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="Start Date"
                            v-model="form.start_date"
                            type="date"
                        />
                        <InputError :message="form.errors.start_date" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            label="End Date"
                            v-model="form.end_date"
                            type="date"
                        />
                        <InputError :message="form.errors.end_date" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <SelectInput
                            label="Status"
                            v-model="form.active_status"
                            :options="statusOptions"
                        />
                        <InputError :message="form.errors.active_status" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="md:w-1/1 mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            label="Description"
                            v-model="form.description"
                        />
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        {{ financialYear ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton :href="route('admin.financial-years.index')">
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
