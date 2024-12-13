<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SettingLayout from '@/Pages/Settings/SettingLayout.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

interface FinanceSettings {
    tax_rate: number;
    discount_rate: number;
    currency: string;
    invoice_prefix: string;
}

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    settings: {
        type: Object as PropType<FinanceSettings>,
        required: false,
    },
});

const form = useForm('post', route('settings.submit'), {
    tax_rate: props.settings?.tax_rate || 0,
    discount_rate: props.settings?.discount_rate || 0,
    currency: props.settings?.currency || '',
    invoice_prefix: props.settings?.invoice_prefix || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>
<template>
    <SettingLayout
        title="Finance Settings"
        subtitle="Fill in the details for your finance-related settings."
    >
        <Card class="mx-auto mt-6 p-4">
            <form @submit.prevent="submitForm">
                <FieldRow class="grid-cols-2">
                    <FieldCol>
                        <InputText
                            type="number"
                            label="Tax Rate (%)"
                            v-model="form.tax_rate"
                            :error="form.errors.tax_rate"
                            placeholder="Enter tax rate"
                        />
                    </FieldCol>
                    <FieldCol>
                        <InputText
                            type="number"
                            label="Discount Rate (%)"
                            v-model="form.discount_rate"
                            :error="form.errors.discount_rate"
                            placeholder="Enter discount rate"
                        />
                    </FieldCol>
                </FieldRow>
                <FieldRow class="grid-cols-2">
                    <FieldCol>
                        <InputText
                            label="Currency"
                            v-model="form.currency"
                            :error="form.errors.currency"
                            placeholder="e.g., USD, EUR"
                        />
                    </FieldCol>
                    <FieldCol>
                        <InputText
                            label="Invoice Prefix"
                            v-model="form.invoice_prefix"
                            :error="form.errors.invoice_prefix"
                            placeholder="e.g., INV-"
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
    </SettingLayout>
</template>
