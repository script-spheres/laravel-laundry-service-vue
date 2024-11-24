<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import NumberInput from '@/Components/Form/NumberInput.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Coupon } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    coupon: {
        type: Object as PropType<Coupon>,
        required: false,
    },
});

const { coupon } = props;

const method = coupon ? 'put' : 'post';
const url = coupon
    ? route('admin.coupons.update', coupon.id)
    : route('admin.coupons.store');

const form = useForm(method, url, {
    title: coupon?.title || '',
    description: coupon?.description || '',
    code: coupon?.code || '',
    discount_type: coupon?.discount_type || '',
    discount_amount: coupon?.discount_amount || '',
    discount_percentage: coupon?.discount_percentage || '',
    min_amount: coupon?.min_amount || '',
    max_amount: coupon?.max_amount || '',
    valid_from: coupon?.valid_from || '',
    valid_to: coupon?.valid_to || '',
    usage_limit: coupon?.usage_limit || '',
    used_count: coupon?.used_count || 0,
    active_status: coupon?.active_status || '',
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
                    {{ coupon ? 'Edit' : 'Create New' }} Coupon
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Fill in the details for your
                    {{ coupon ? 'existing' : 'new' }} coupon.
                </p>
            </div>
            <LinkButton :href="route('admin.coupons.index')">Back</LinkButton>
        </div>

        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput value="Title" v-model="form.title" />
                        <InputError :message="form.errors.title" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput value="Coupon Code" v-model="form.code" />
                        <InputError :message="form.errors.code" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0">
                        <TextareaInput
                            value="Description"
                            v-model="form.description"
                        />
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <SelectInput
                            value="Discount Type"
                            v-model="form.discount_type"
                            :options="[
                                { value: 'flat', label: 'Flat' },
                                { value: 'percentage', label: 'Percentage' },
                            ]"
                        />
                        <InputError :message="form.errors.discount_type" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            value="Discount Amount"
                            v-model="form.discount_amount"
                            type="number"
                            step="0.01"
                        />
                        <InputError :message="form.errors.discount_amount" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            value="Minimum Amount"
                            v-model="form.min_amount"
                            type="number"
                            step="0.01"
                        />
                        <InputError :message="form.errors.min_amount" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            value="Maximum Amount"
                            v-model="form.max_amount"
                            type="number"
                            step="0.01"
                        />
                        <InputError :message="form.errors.max_amount" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Valid From"
                            v-model="form.valid_from"
                            type="date"
                        />
                        <InputError :message="form.errors.valid_from" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <TextInput
                            value="Valid To"
                            v-model="form.valid_to"
                            type="date"
                        />
                        <InputError :message="form.errors.valid_to" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            value="Usage Limit"
                            v-model="form.usage_limit"
                            type="number"
                        />
                        <InputError :message="form.errors.usage_limit" />
                    </div>
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <NumberInput
                            value="Used Count"
                            v-model="form.used_count"
                            type="number"
                        />
                        <InputError :message="form.errors.used_count" />
                    </div>
                </div>
                <div class="-mx-3 mb-6 flex flex-wrap">
                    <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                        <SelectInput
                            value="Status"
                            v-model="form.active_status"
                            :options="statusOptions"
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
                        {{ coupon ? 'Update' : 'Submit' }}
                    </PrimaryButton>
                    <LinkButton :href="route('admin.coupons.index')">
                        Cancel
                    </LinkButton>
                </div>
            </form>
        </Card>
    </div>
</template>
