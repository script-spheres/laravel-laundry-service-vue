<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/InputFilepond.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Category } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const { category } = defineProps({
    category: {
        type: Object as PropType<Category>,
        required: false,
    },
});

const method = category ? 'put' : 'post';
const url = category
    ? route('categories.update', category.id)
    : route('categories.store');

const form = useForm(method, url, {
    name: category?.name || '',
    description: category?.description || '',
    image: category?.image || {},
    new_image: null as string | null,
    status: category?.status || '',
});

const handleFileProcess = (error: any, file: any) => {
    if (category) {
        form.new_image = file.serverId;
    } else {
        form.image = file.serverId;
    }
};

const handleFileRemoved = () => {
    if (category) {
        form.new_image = null;
    } else {
        form.image = {};
    }
};

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <PageHeader>
        <template #title>
            {{ category ? 'Edit ' : 'Create New' }} Category
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ category ? 'existing' : 'new' }} category.
        </template>
        <template #actions>
            <LinkButton :href="route('categories.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Status"
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Description"
                        v-model="form.description"
                        placeholder="Category Description (optional)"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <FilepondInput
                        label="Image"
                        :files="category?.image"
                        @processfile="handleFileProcess"
                        @removefile="handleFileRemoved"
                        :error="form.errors.image"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ category ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('categories.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
