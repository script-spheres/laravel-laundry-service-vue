<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ServiceType } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const { serviceType } = defineProps({
    serviceType: {
        type: Object as PropType<ServiceType>,
        required: false,
    },
});

const method = serviceType ? 'put' : 'post';
const url = serviceType
    ? route('admin.service-types.update', serviceType.id)
    : route('admin.service-types.store');

const form = useForm(method, url, {
    name: serviceType?.name || '',
    description: serviceType?.description || '',
    status: serviceType?.status || '',
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
            {{ serviceType ? 'Edit ' : 'Create New' }} Service Type
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ serviceType ? 'existing' : 'new' }} service type.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.service-types.index')">
                Back
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow>
                <FieldCol>
                    <TextInput
                        label="Service Type Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <SelectInput
                        label="Active Status"
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <TextareaInput
                        label="Description"
                        v-model="form.description"
                        placeholder="Service Type Description (optional)"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ serviceType ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.service-types.index')">
                    Cancel
                </LinkButton>
            </FieldRow>
        </form>
    </Card>
</template>
