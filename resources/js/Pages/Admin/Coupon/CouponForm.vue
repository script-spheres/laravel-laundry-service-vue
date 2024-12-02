<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import NumberInput from '@/Components/Form/NumberInput.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import PageHeader from '@/Components/PageHeader.vue';
import Card from '@/Components/Panel/Card.vue';
import { discountTypeOptions, statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Coupon } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { computed, PropType } from 'vue';
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
    discount_type: coupon?.discount_type || 'flat',
    discount_amount: coupon?.discount_amount || '',
    discount_percentage: coupon?.discount_percentage || '',
    min_amount: coupon?.min_amount || '',
    max_amount: coupon?.max_amount || '',
    active_status: coupon?.active_status || '',
});

// Watch for changes in discount type and handle the dynamic fields
const isDiscountAmountVisible = computed(() => form.discount_type === 'flat');
const isDiscountPercentageVisible = computed(() => form.discount_type === 'percentage');

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <PageHeader>
        <template #title>
            {{ coupon ? 'Edit ' : 'Create New' }} Coupon
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ coupon ? 'existing' : 'new' }} coupon.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.coupons.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <TextInput
                        label="Title"
                        v-model="form.title"
                        :error="form.errors.title"
                    />
                </FieldCol>
                <FieldCol>
                    <TextInput
                        label="Coupon Code"
                        v-model="form.code"
                        :error="form.errors.code"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <TextareaInput
                        label="Description"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <SelectInput
                        label="Discount Type"
                        v-model="form.discount_type"
                        :options="discountTypeOptions"
                        :error="form.errors.discount_type"
                    />
                </FieldCol>
                <FieldCol v-if="isDiscountAmountVisible">
                    <NumberInput
                        label="Discount Amount"
                        v-model="form.discount_amount"
                        type="number"
                        step="0.01"
                        :error="form.errors.discount_amount"
                    />
                </FieldCol>
                <FieldCol v-if="isDiscountPercentageVisible">
                    <NumberInput
                        label="Discount Percentage"
                        v-model="form.discount_percentage"
                        type="number"
                        step="0.01"
                        :error="form.errors.discount_percentage"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="grid-cols-3">
                <FieldCol>
                    <NumberInput
                        label="Minimum Amount"
                        v-model="form.min_amount"
                        type="number"
                        step="0.01"
                        :error="form.errors.min_amount"
                    />
                </FieldCol>
                <FieldCol>
                    <NumberInput
                        label="Maximum Amount"
                        v-model="form.max_amount"
                        type="number"
                        step="0.01"
                        :error="form.errors.max_amount"
                    />
                </FieldCol>
                <FieldCol>
                    <SelectInput
                        label="Active Status"
                        v-model="form.active_status"
                        :options="statusOptions"
                        :error="form.errors.active_status"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ coupon ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.coupons.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
