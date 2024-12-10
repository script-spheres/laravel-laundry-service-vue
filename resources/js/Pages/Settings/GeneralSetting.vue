<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

interface GeneralSettings {
    site_name: string;
}

defineOptions({ layout: AdminLayout });

const props = defineProps({
    settings: {
        type: Object as PropType<GeneralSettings>,
        required: false,
    },
});

const form = useForm('post', route('settings.submit'), {
    site_name: props.settings?.site_name || '',
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
        <template #title> Finance Settings </template>
        <template #subtitle>
            Fill in the details for your finance-related settings.
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
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
                    {{ settings ? 'Update' : 'Submit' }}
                </PrimaryButton>
            </FieldRow>
        </form>
    </Card>
</template>
