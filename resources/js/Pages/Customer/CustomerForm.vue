<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import EmailInput from '@/Components/Form/InputEmail.vue';
import PhoneInput from '@/Components/Form/InputPhone.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Customer } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    customer: {
        type: Object as PropType<Customer>,
        required: false,
    },
});

const { customer } = props;

const method = customer ? 'put' : 'post';
const url = customer
    ? route('customers.update', customer.id)
    : route('customers.store');

const form = useForm(method, url, {
    name: customer?.name || '',
    address: customer?.address || '',
    email: customer?.email || '',
    phone_number: customer?.phone_number || '',
    communication_pref: customer?.communication_pref || '',
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
            {{ customer ? 'Edit ' : 'Create New' }} Customer
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ customer ? 'existing' : 'new' }} customer.
        </template>
        <template #actions>
            <LinkButton :href="route('customers.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="3">
                <FieldCol>
                    <InputText
                        label="Customer Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <EmailInput
                        label="Email"
                        v-model="form.email"
                        :error="form.errors.email"
                    />
                </FieldCol>
                <FieldCol>
                    <PhoneInput
                        label="Phone Number"
                        v-model="form.phone_number"
                        :error="form.errors.phone_number"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Communication Preferences"
                        v-model="form.communication_pref"
                        placeholder="Communication Preferences (optional)"
                        :error="form.errors.communication_pref"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Address"
                        v-model="form.address"
                        placeholder="Customer Address (optional)"
                        :error="form.errors.address"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ customer ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('customers.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
