<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/InputFilepond.vue';
import InputNumber from '@/Components/Form/InputNumber.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { ServiceItem } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const { serviceItem, serviceTypeOptions } = defineProps({
    serviceItem: {
        type: Object as PropType<ServiceItem>,
        required: false,
    },
    serviceTypeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const method = serviceItem ? 'put' : 'post';
const url = serviceItem
    ? route('service-items.update', serviceItem.id)
    : route('service-items.store');

const form = useForm(method, url, {
    name: serviceItem?.name || '',
    description: serviceItem?.description || '',
    image: serviceItem?.image || {},
    new_image: null as string | null,
    service_prices: serviceItem?.service_prices || [
        { service_type_id: '', price: '' },
    ],
    status: serviceItem?.status || '',
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

const addRow = () => {
    form.service_prices.push({ service_type_id: '', price: '' });
};

const removeRow = (index: number) => {
    form.service_prices.splice(index, 1);
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
            <LinkButton :href="route('service-items.index')">
                Back
            </LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
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
                    <InputTextarea
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

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">
                    Service Price
                </label>
                <div class="space-y-2">
                    <div
                        v-for="(info, index) in form.service_prices"
                        :key="index"
                        class="flex items-center space-x-2"
                    >
                        <InputSelect
                            v-model="info.service_type_id"
                            :options="serviceTypeOptions"
                            placeholder="Select Service Type"
                        />
                        <InputNumber
                            v-model="info.price"
                            placeholder="Enter price"
                        />
                        <PrimaryButton
                            v-if="form.service_prices.length > 1"
                            @click.prevent="removeRow(index)"
                            type="button"
                        >
                            Remove
                        </PrimaryButton>
                    </div>
                    <PrimaryButton @click.prevent="addRow" type="button">
                        Add Service Price
                    </PrimaryButton>
                </div>
            </div>

            <FieldRow class="gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ serviceItem ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('service-items.index')">
                    Cancel
                </LinkButton>
            </FieldRow>
        </form>
    </Card>
</template>
