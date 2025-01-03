<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import { FinanceSettings } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    settings: {
        type: Object as PropType<FinanceSettings>,
        required: false,
    },
});

const form = useForm('post', route('settings.store.finance'), {
    tax_rate: props.settings?.tax_rate || '',
    currency: props.settings?.currency || '',
    currency_symbol: props.settings?.currency_symbol || '',
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
                    type="number"
                    label="Tax Rate (%)"
                    v-model="form.tax_rate"
                    :error="form.errors.tax_rate"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="Currency"
                    v-model="form.currency"
                    :error="form.errors.currency"
                />
            </FieldCol>
        </FieldRow>
        <FieldRow :cols="2">
            <FieldCol>
                <InputText
                    label="Currency Symbol"
                    v-model="form.currency_symbol"
                    :error="form.errors.currency_symbol"
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
