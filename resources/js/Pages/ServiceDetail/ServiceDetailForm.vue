<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { ServiceDetail } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    serviceDetail: {
        type: Object as PropType<ServiceDetail>,
        required: false,
    },
    serviceOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    categoryOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    unitOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const method = props.serviceDetail ? 'put' : 'post';
const url = props.serviceDetail
    ? route('service-details.update', props.serviceDetail.id)
    : route('service-details.store');

const form = useForm(method, url, {
    service_id: props.serviceDetail?.service_id || '',
    category_id: props.serviceDetail?.category_id || '',
    unit_id: props.serviceDetail?.unit_id || '',
    price: props.serviceDetail?.price || '',
    quantity: props.serviceDetail?.quantity || '',
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
            {{ serviceDetail ? 'Edit ' : 'Create New' }} Service Detail
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ serviceDetail ? 'existing' : 'new' }} service detail.
        </template>
        <template #actions>
            <LinkButton :href="route('service-details.index')">
                Back
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputSelect
                        label="Service"
                        v-model="form.service_id"
                        :options="serviceOptions"
                        :error="form.errors.service_id"
                        placeholder="Select Service"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Category"
                        v-model="form.category_id"
                        :options="categoryOptions"
                        :error="form.errors.category_id"
                        placeholder="Select Category"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputText
                        label="Price"
                        type="number"
                        v-model="form.price"
                        :error="form.errors.price"
                        placeholder="Enter price"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Quantity"
                        type="number"
                        v-model="form.quantity"
                        :error="form.errors.quantity"
                        placeholder="Enter quantity"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputSelect
                        label="Unit"
                        v-model="form.unit_id"
                        :options="unitOptions"
                        :error="form.errors.unit_id"
                        placeholder="Select Unit"
                    />
                </FieldCol>
            </FieldRow>

            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ serviceDetail ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton
                    :href="route('service-details.index')"
                    color="danger"
                >
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
