<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SettingLayout from '@/Pages/Settings/SettingLayout.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

interface GeneralSettings {
    site_name: string;
}

// Props for settings data
const props = defineProps({
    settings: {
        type: Object as PropType<GeneralSettings>,
        required: false,
    },
});

// Initialize the form
const form = useForm('post', route('settings.submit'), {
    site_name: props.settings?.site_name || '',
});

// Submit handler
const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <SettingLayout
        title="General Settings"
        subtitle="Fill in the details for your finance-related settings."
    >
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="Site Name"
                        v-model="form.site_name"
                        :error="form.errors.site_name"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ props.settings ? 'Update' : 'Submit' }}
                </PrimaryButton>
            </FieldRow>
        </form>
    </SettingLayout>
</template>
