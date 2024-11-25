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
import { Expense } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';
import NumberInput from "@/Components/Form/NumberInput.vue";

defineOptions({ layout: AdminLayout });

const props = defineProps({
    expense: {
        type: Object as PropType<Expense>,
        required: false,
    },
    storesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const { expense } = props;

const method = expense ? 'put' : 'post';
const url = expense
    ? route('admin.expenses.update', expense.id)
    : route('admin.expenses.store');

const form = useForm(method, url, {
    category: expense?.category || '',
    amount: expense?.amount || '',
    store_id: expense?.store_id || '',
    receipt: expense?.receipt || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                {{ expense ? 'Edit Expense' : 'Create New Expense' }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ expense ? 'existing' : 'new' }} expense.
            </p>
        </div>
        <LinkButton :href="route('admin.expenses.index')">Back</LinkButton>
    </div>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <TextInput label="Category" v-model="form.category" />
                    <InputError :message="form.errors.category" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <TextareaInput
                        label="Receipt (optional)"
                        v-model="form.receipt"
                        placeholder="Expense Receipt (optional)"
                    />
                    <InputError :message="form.errors.receipt" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <NumberInput
                        label="Amount"
                        v-model="form.amount"
                        type="number"
                        step="0.01"
                        placeholder="Expense Amount"
                    />
                    <InputError :message="form.errors.amount" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <SelectInput
                        v-model="form.store_id"
                        :options="storesOptions"
                        label="Select Store"
                    />
                    <InputError :message="form.errors.store_id" />
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ expense ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.expenses.index')" color="red">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
