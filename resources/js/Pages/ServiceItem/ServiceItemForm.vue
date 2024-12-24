<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/InputFilepond.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { ServiceItem } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    serviceItem: {
        type: Object as PropType<ServiceItem>,
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

const method = props.serviceItem ? 'put' : 'post';
const url = props.serviceItem
    ? route('service-items.update', props.serviceItem.id)
    : route('service-items.store');

const form = useForm(method, url, {
    name: props.serviceItem?.name || '',
    description: props.serviceItem?.description || '',
    image: props.serviceItem?.image || {},
    new_image: null as string | null,
    service_details: props.serviceItem?.service_details || [],
    status: props.serviceItem?.status || '',
});

const handleFileProcess = (error: any, file: any) => {
    if (props.serviceItem) {
        form.new_image = file.serverId;
    } else {
        form.image = file.serverId;
    }
};

const handleFileRemoved = () => {
    if (props.serviceItem) {
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
            {{ serviceItem ? 'Edit ' : 'Create New' }} Service Item
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ serviceItem ? 'existing' : 'new' }} service item.
        </template>
        <template #actions>
            <LinkButton :href="route('service-items.index')"> Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="Service Item Name"
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

            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ serviceItem ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('service-items.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
