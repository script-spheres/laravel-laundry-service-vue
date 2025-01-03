<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import { BusinessSettings } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    settings: {
        type: Object as PropType<BusinessSettings>,
        required: false,
    },
});

const form = useForm('post', route('settings.store.business'), {
    name: props.settings?.name || '',
    address: props.settings?.address || '',
    city: props.settings?.city || '',
    state: props.settings?.state || '',
    country: props.settings?.country || '',
    zip_code: props.settings?.zip_code || '',
    email: props.settings?.email || '',
    tax_number: props.settings?.tax_number || '',
    country_code: props.settings?.country_code || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <form @submit.prevent="submitForm">
        <FieldRow :cols="2">
            <FieldCol>
                <InputText
                    label="Business Name"
                    v-model="form.name"
                    :error="form.errors.name"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="Address"
                    v-model="form.address"
                    :error="form.errors.address"
                />
            </FieldCol>
        </FieldRow>
        <FieldRow :cols="2">
            <FieldCol>
                <InputText
                    label="City"
                    v-model="form.city"
                    :error="form.errors.city"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="State"
                    v-model="form.state"
                    :error="form.errors.state"
                />
            </FieldCol>
        </FieldRow>
        <FieldRow :cols="2">
            <FieldCol>
                <InputText
                    label="Country"
                    v-model="form.country"
                    :error="form.errors.country"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="Zip Code"
                    v-model="form.zip_code"
                    :error="form.errors.zip_code"
                />
            </FieldCol>
        </FieldRow>
        <FieldRow :cols="2">
            <FieldCol>
                <InputText
                    label="Email"
                    v-model="form.email"
                    :error="form.errors.email"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="Tax Number"
                    v-model="form.tax_number"
                    :error="form.errors.tax_number"
                />
            </FieldCol>
        </FieldRow>
        <FieldRow :cols="2">
            <FieldCol>
                <InputText
                    label="Country Code"
                    v-model="form.country_code"
                    :error="form.errors.country_code"
                />
            </FieldCol>
        </FieldRow>
        <div>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                {{ props.settings ? 'Update' : 'Submit' }}
            </PrimaryButton>
        </div>
    </form>
</template>
