<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import EmailInput from '@/Components/Form/InputEmail.vue';
import PhoneInput from '@/Components/Form/InputPhone.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import PageHeader from '@/Components/PageHeader.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    settings: {
        type: Object as PropType<GeneralSettings>,
        required: false,
    },
});

const form = useForm('post', route('admin.settings.submit'), {
    name: props.settings?.name || '',
    address: props.settings?.address || '',
    email: props.settings?.email || '',
    phone_number: props.settings?.phone_number || '',
    communication_pref: props.settings?.communication_pref || '',
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
            {{ settings ? 'Edit ' : 'Create New' }} settings
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ settings ? 'existing' : 'new' }} settings.
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="settings Name"
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
            </FieldRow>
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <PhoneInput
                        label="Phone Number"
                        v-model="form.phone_number"
                        :error="form.errors.phone_number"
                    />
                </FieldCol>
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
                        placeholder="settings Address (optional)"
                        :error="form.errors.address"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ settings ? 'Update' : 'Submit' }}
                </PrimaryButton>
            </FieldRow>
        </form>
    </Card>
</template>
