<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputFilepond from '@/Components/Form/InputFilepond.vue';
import { GeneralSettings } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

const { settings } = defineProps({
    settings: {
        type: Object as PropType<GeneralSettings>,
        required: false,
    },
});

// Initialize the form with existing data or empty fields
const form = useForm('post', route('settings.store.general'), {
    slogan: settings?.slogan || '',
    new_logo: null,
    new_favicon: null,
});

const handleFileProcess = (field: 'new_logo' | 'new_favicon', file: any) => {
    form[field] = file.serverId;
};

const handleFileRemoved = (field: 'new_logo' | 'new_favicon') => {
    form[field] = null;
};

// Submit the form
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
                <InputFilepond
                    label="Logo"
                    :files="settings?.logo"
                    @processfile="
                        (error, file) => handleFileProcess('new_logo', file)
                    "
                    @removefile="() => handleFileRemoved('new_logo')"
                    :error="form.errors.new_logo"
                />
            </FieldCol>
            <FieldCol>
                <InputFilepond
                    label="Favicon"
                    :files="settings?.favicon"
                    @processfile="
                        (error, file) => handleFileProcess('new_favicon', file)
                    "
                    @removefile="() => handleFileRemoved('new_favicon')"
                    :error="form.errors.new_favicon"
                />
            </FieldCol>
        </FieldRow>
        <div class="gap-2">
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                {{ settings ? 'Update' : 'Submit' }}
            </PrimaryButton>
        </div>
    </form>
</template>
