<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import { GeneralSettings } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';
import InputFilepond from '@/Components/Form/InputFilepond.vue';

const props = defineProps({
    settings: {
        type: Object as PropType<GeneralSettings>,
        required: false,
    },
});

const form = useForm('post', route('settings.submit'), {
    site_name: props.settings?.site_name || '',
    slogan: props.settings?.slogan || '',
    logo: props.settings?.logo || '',
    favicon: props.settings?.favicon || '',
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
                    label="Site Name"
                    v-model="form.site_name"
                    :error="form.errors.site_name"
                />
            </FieldCol>
            <FieldCol>
                <InputText
                    label="Slogan"
                    v-model="form.slogan"
                    :error="form.errors.slogan"
                />
            </FieldCol>
        </FieldRow>
        <FieldRow :cols="2">
            <FieldCol>
                <InputFilepond
                    label="Logo"
                    v-model="form.logo"
                    :error="form.errors.logo"
                />
            </FieldCol>
            <FieldCol>
                <InputFilepond
                    label="Favicon"
                    v-model="form.favicon"
                    :error="form.errors.favicon"
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
</template>
