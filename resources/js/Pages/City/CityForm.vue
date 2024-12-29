<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { City } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const { city } = defineProps({
    city: {
        type: Object as PropType<City>,
        required: false,
    },
});

const method = city ? 'put' : 'post';
const url = city ? route('cities.update', city.id) : route('cities.store');

const form = useForm(method, url, {
    name: city?.name || '',
    description: city?.description || '',
    status: city?.status || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <PageHeader>
        <template #title> {{ city ? 'Edit ' : 'Create New' }} City</template>
        <template #subtitle>
            Fill in the details for your
            {{ city ? 'existing' : 'new' }} city.
        </template>
        <template #actions>
            <LinkButton :href="route('cities.index')">Back</LinkButton>
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
                    <InputText
                        label="Description"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>

            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ city ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('cities.index')" color="red">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
