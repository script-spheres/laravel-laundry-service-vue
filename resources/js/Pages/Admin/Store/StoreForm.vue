<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputNumber from '@/Components/Form/InputNumber.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Store } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    store: {
        type: Object as PropType<Store>,
        required: false,
    },
});

const { store } = props;

const method = store ? 'put' : 'post';
const url = store
    ? route('admin.stores.update', store.id)
    : route('admin.stores.store');

const form = useForm(method, url, {
    name: store?.name || '',
    store_code: store?.store_code || '',
    address: store?.address || '',
    address_lat: store?.address_lat || '',
    address_long: store?.address_long || '',
    email: store?.email || '',
    phone_number: store?.phone_number || '',
    manager_name: store?.manager_name || '',
    manager_email: store?.manager_email || '',
    manager_phone_number: store?.manager_phone_number || '',
    additional_info: store?.additional_info || '',
    status: store?.status || 'active',
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
        <template #title>{{ store ? 'Edit' : 'Create New' }} Store</template>
        <template #subtitle>
            Fill in the details for your {{ store ? 'existing' : 'new' }} store.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.stores.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="{ sm: 1, md: 2, lg: 2 }">
                <FieldCol>
                    <InputText
                        label="Store Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Store Code"
                        v-model="form.store_code"
                        :error="form.errors.store_code"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Address"
                        v-model="form.address"
                        :error="form.errors.address"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow :cols="{ sm: 1, md: 2, lg: 2 }">
                <FieldCol>
                    <InputNumber
                        label="Address Latitude"
                        v-model="form.address_lat"
                        type="number"
                        step="0.0000001"
                        :error="form.errors.address_lat"
                    />
                </FieldCol>
                <FieldCol>
                    <InputNumber
                        label="Address Longitude"
                        v-model="form.address_long"
                        type="number"
                        step="0.0000001"
                        :error="form.errors.address_long"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow :cols="{ sm: 1, md: 2, lg: 2 }">
                <FieldCol>
                    <InputText
                        label="Email"
                        v-model="form.email"
                        type="email"
                        :error="form.errors.email"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Phone Number"
                        v-model="form.phone_number"
                        :error="form.errors.phone_number"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow :cols="{ sm: 1, md: 2, lg: 2 }">
                <FieldCol>
                    <InputText
                        label="Manager Name"
                        v-model="form.manager_name"
                        :error="form.errors.manager_name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Manager Email"
                        v-model="form.manager_email"
                        type="email"
                        :error="form.errors.manager_email"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow :cols="{ sm: 1, md: 2, lg: 2 }">
                <FieldCol>
                    <InputText
                        label="Manager Phone Number"
                        v-model="form.manager_phone_number"
                        :error="form.errors.manager_phone_number"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Status"
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Additional Info"
                        v-model="form.additional_info"
                        :error="form.errors.additional_info"
                    />
                </FieldCol>
            </FieldRow>

            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ store ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('admin.stores.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
