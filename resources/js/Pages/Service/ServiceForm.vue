<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/InputFilepond.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Service } from '@/types';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const { service } = defineProps({
    service: {
        type: Object as PropType<Service>,
        required: false,
    },
});

const method = service ? 'put' : 'post';
const url = service
    ? route('services.update', service.id)
    : route('services.store');

const form = useForm(method, url, {
    name: service?.name || '',
    image: service?.image || {},
    new_image: null as string | null,
    description: service?.description || '',
    status: service?.status || '',
});

const handleFileProcess = (error: any, file: any) => {
    if (service) {
        form.new_image = file.serverId;
    } else {
        form.image = file.serverId;
    }
};

const handleFileRemoved = () => {
    if (service) {
        form.new_image = null;
    } else {
        form.image = {};
    }
};

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
            {{ service ? 'Edit ' : 'Create New' }} Service
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ service ? 'existing' : 'new' }} service.
        </template>
        <template #actions>
            <LinkButton :href="route('services.index')"> Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="2">
                <FieldCol>
                    <InputText
                        label="Service Name"
                        v-model="form.name"
                        :error="form.errors.name"
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
            <FieldRow>
                <FieldCol>
                    <FilepondInput
                        label="Image"
                        :files="service?.image"
                        @processfile="handleFileProcess"
                        @removefile="handleFileRemoved"
                        :error="form.errors.image"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Description"
                        v-model="form.description"
                        placeholder="Service Description (optional)"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ service ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('services.index')" color="red">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
