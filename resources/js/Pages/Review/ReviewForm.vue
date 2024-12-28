<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputRating from '@/Components/Form/InputRating.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Review } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    review: {
        type: Object as PropType<Review>,
        required: false,
    },
    usersOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    ordersOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const method = props.review ? 'put' : 'post';
const url = props.review
    ? route('reviews.update', props.review.id)
    : route('reviews.store');

const form = useForm(method, url, {
    title: props.review?.title ?? '',
    review: props.review?.review ?? '',
    rating: props.review?.rating ?? null,
    in_testimonial: props.review?.in_testimonial ?? false,
    model_id: props.review?.model_id ?? '', // for order_id
    author_id: props.review?.author_id ?? '', // for user_id
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
        <template #title> {{ review ? 'Edit' : 'Create New' }} Review</template>
        <template #subtitle>
            Fill in the details for your
            {{ review ? 'existing' : 'new' }} review.
        </template>
        <template #actions>
            <LinkButton :href="route('reviews.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4 sm:p-6">
        <form @submit.prevent="submitForm">
            <!-- Order ID (model_id) and User ID (author_id) -->
            <FieldRow :cols="2">
                <FieldCol>
                    <InputSelect
                        label="Order ID"
                        v-model="form.model_id"
                        :error="form.errors.model_id"
                        :options="ordersOptions"
                    />
                </FieldCol>

                <FieldCol>
                    <InputSelect
                        label="User ID"
                        v-model="form.author_id"
                        :error="form.errors.author_id"
                        :options="usersOptions"
                    />
                </FieldCol>
            </FieldRow>
            <!-- Title Field -->
            <FieldRow :cols="1">
                <FieldCol>
                    <InputText
                        label="Review Title"
                        v-model="form.title"
                        :error="form.errors.title"
                    />
                </FieldCol>
            </FieldRow>

            <!-- Review Content Field -->
            <FieldRow :cols="1">
                <FieldCol>
                    <InputTextarea
                        label="Review Content"
                        v-model="form.review"
                        :error="form.errors.review"
                    />
                </FieldCol>
            </FieldRow>

            <!-- Rating Field -->
            <FieldRow :cols="2">
                <FieldCol>
                    <InputRating
                        label="Rating"
                        v-model="form.rating"
                        :error="form.errors.rating"
                    />
                </FieldCol>

                <FieldCol>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" v-model="form.in_testimonial" />
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Display in testimonial?
                        </span>
                    </label>
                </FieldCol>
            </FieldRow>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col gap-2 md:flex-row">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ review ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('reviews.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
