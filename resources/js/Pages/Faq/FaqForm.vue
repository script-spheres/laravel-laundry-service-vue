<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Faq } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    faq: {
        type: Object as PropType<Faq>,
        required: false,
    },
});

const method = props.faq ? 'put' : 'post';
const url = props.faq
    ? route('faqs.update', props.faq.id)
    : route('faqs.store');

const form = useForm(method, url, {
    question: props.faq?.question ?? '',
    answer: props.faq?.answer ?? '',
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
        <template #title> {{ faq ? 'Edit' : 'Create New' }} FAQ</template>
        <template #subtitle>
            Fill in the details for your {{ faq ? 'existing' : 'new' }} FAQ.
        </template>
        <template #actions>
            <LinkButton :href="route('faqs.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4 sm:p-6">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="1">
                <FieldCol>
                    <InputText
                        label="Question"
                        v-model="form.question"
                        :error="form.errors.question"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow :cols="1">
                <FieldCol>
                    <InputTextarea
                        label="Answer"
                        v-model="form.answer"
                        :error="form.errors.answer"
                    />
                </FieldCol>
            </FieldRow>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col gap-2 md:flex-row">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ faq ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('faqs.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
