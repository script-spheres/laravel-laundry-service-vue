<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputGroup from '@/Components/Form/InputGroup.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import { radiusUnitOptions, statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { DeliveryScale } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    deliveryScale: {
        type: Object as PropType<DeliveryScale>,
        required: false,
    },
});

const { deliveryScale } = props;

const method = deliveryScale ? 'put' : 'post';
const url = deliveryScale
    ? route('delivery-scales.update', deliveryScale.id)
    : route('delivery-scales.store');

const form = useForm(method, url, {
    radius: deliveryScale?.radius || '',
    radius_unit: deliveryScale?.radius_unit || '',
    min_order_amount: deliveryScale?.min_order_amount || '',
    delivery_charges: deliveryScale?.delivery_charges || '',
    status: deliveryScale?.status || 'active',
});

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
            {{ deliveryScale ? 'Edit ' : 'Create New' }} Delivery Scale
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ deliveryScale ? 'existing' : 'new' }} delivery scale.
        </template>
        <template #actions>
            <LinkButton :href="route('delivery-scales.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputGroup
                        label="Radius"
                        :error="form.errors.radius || form.errors.radius_unit"
                    >
                        <InputText type="number" v-model="form.radius" />
                        <InputSelect
                            v-model="form.radius_unit"
                            :options="radiusUnitOptions"
                        />
                    </InputGroup>
                </FieldCol>
                <FieldCol>
                    <InputText
                        type="number"
                        label="Minimum Order Amount"
                        v-model="form.min_order_amount"
                        :error="form.errors.min_order_amount"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        type="number"
                        label="Delivery Charges"
                        v-model="form.delivery_charges"
                        :error="form.errors.delivery_charges"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Status"
                        v-model="form.status"
                        :error="form.errors.status"
                        :options="statusOptions"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ deliveryScale ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton
                    :href="route('delivery-scales.index')"
                    color="red"
                >
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
