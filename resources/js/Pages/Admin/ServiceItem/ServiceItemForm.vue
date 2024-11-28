<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/FilepondInput.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import PageHeader from '@/Components/PageHeader.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ServicePrice from '@/Pages/Admin/ServiceItem/ServicePrice.vue';
import { Service } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const { serviceItem } = defineProps({
    serviceItem: {
        type: Object as PropType<Service>,
        required: false,
    },
    serviceTypeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const method = serviceItem ? 'put' : 'post';
const url = serviceItem
    ? route('admin.service-items.update', serviceItem.id)
    : route('admin.service-items.store');

const form = useForm(method, url, {
    name: serviceItem?.service_name || '',
    description: serviceItem?.description || '',
    image: serviceItem?.image || {},
    new_image: null as string | null,
    active_status: serviceItem?.active_status || '',
    service_price: serviceItem?.service_price || [{ item: '', value: '' }],
});

const handleFileProcess = (error: any, file: any) => {
    if (serviceItem) {
        form.new_image = file.serverId;
    } else {
        form.image = file.serverId;
    }
};

const handleFileRemoved = () => {
    if (serviceItem) {
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
            {{ serviceItem ? 'Edit ' : 'Create New' }} Service
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ serviceItem ? 'existing' : 'new' }} service.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.service-items.index')">
                Back
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <TextInput
                        label="Service Name"
                        v-model="form.name"
                        :error="form.errors.name"
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
                        placeholder="Service Description (optional)"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <FilepondInput
                        label="Image URL"
                        :files="serviceItem?.image"
                        @processfile="handleFileProcess"
                        @removefile="handleFileRemoved"
                        :error="form.errors.image"
                    />
                </FieldCol>
            </FieldRow>

            <ServicePrice
                v-model="form.service_price"
                :serviceTypeOptions="serviceTypeOptions"
            />

            <FieldRow class="gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ serviceItem ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.service-items.index')">
                    Cancel
                </LinkButton>
            </FieldRow>
        </form>
    </Card>
</template>
