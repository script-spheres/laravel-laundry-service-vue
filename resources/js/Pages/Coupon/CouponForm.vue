<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import { discountTypeOptions, statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Coupon } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { computed, PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    coupon: {
        type: Object as PropType<Coupon>,
        required: false,
    },
});

const { coupon } = props;

const method = coupon ? 'put' : 'post';
const url = coupon
    ? route('coupons.update', coupon.id)
    : route('coupons.store');

const form = useForm(method, url, {
    title: coupon?.title || '',
    description: coupon?.description || '',
    code: coupon?.code || '',
    discount_type: coupon?.discount_type || 'flat',
    max_discount_amount: coupon?.max_discount_amount || '',
    discount_percentage: coupon?.discount_percentage || '',
    min_order_amount: coupon?.min_order_amount || '',
    status: coupon?.status || '',
});

// Watch for changes in discount type and handle the dynamic fields
const isDiscountAmountVisible = computed(() => form.discount_type === 'flat');
const isDiscountPercentageVisible = computed(
    () => form.discount_type === 'percentage',
);

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
            <LinkButton :href="route('coupons.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="Title"
                        v-model="form.title"
                        :error="form.errors.title"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Coupon Code"
                        v-model="form.code"
                        :error="form.errors.code"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Description"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputSelect
                        label="Discount Type"
                        v-model="form.discount_type"
                        :options="discountTypeOptions"
                        :error="form.errors.discount_type"
                    />
                </FieldCol>
                <FieldCol v-if="isDiscountAmountVisible">
                    <InputText
                        label="Discount Amount"
                        v-model="form.max_discount_amount"
                        type="number"
                        step="0.01"
                        :error="form.errors.max_discount_amount"
                    />
                </FieldCol>
                <FieldCol v-if="isDiscountPercentageVisible">
                    <InputText
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
                    <InputText
                        label="Minimum Order Amount"
                        v-model="form.min_order_amount"
                        type="number"
                        step="0.01"
                        :error="form.errors.min_order_amount"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Active Status"
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
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
                <LinkButton :href="route('coupons.index')" color="red">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
