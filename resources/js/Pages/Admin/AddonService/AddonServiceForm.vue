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
import { AddonService } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';
import NumberInput from '@/Components/Form/NumberInput.vue';

defineOptions({ layout: AdminLayout });

const { addonService } = defineProps({
    addonService: {
        type: Object as PropType<AddonService>,
        required: false,
    },
});

const method = addonService ? 'put' : 'post';
const url = addonService
    ? route('admin.addon-services.update', addonService.id)
    : route('admin.addon-services.store');

const form = useForm(method, url, {
    name: addonService?.name || '',
    price: addonService?.price || '',
    description: addonService?.description || '',
    active_status: addonService?.active_status || '',
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
            {{ addonService ? 'Edit ' : 'Create New' }} Add-on Service
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ addonService ? 'existing' : 'new' }} add-on service.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.addon-services.index')">
                Back
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-3">
                <FieldCol>
                    <TextInput
                        label="Add-on Service Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <NumberInput
                        label="Add-on Service Price"
                        v-model="form.price"
                        :error="form.errors.price"
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
            <FieldRow>
                <FieldCol>
                    <TextareaInput
                        label="Description"
                        v-model="form.description"
                        placeholder="Add-on Service Description (optional)"
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
                    {{ addonService ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.addon-services.index')">
                    Cancel
                </LinkButton>
            </FieldRow>
        </form>
    </Card>
</template>
