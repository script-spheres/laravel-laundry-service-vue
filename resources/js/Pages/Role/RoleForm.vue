<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Role } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    role: {
        type: Object as PropType<Role>,
        required: false,
    },
    permissionsOptions: {
        type: Array as PropType<Array<{ value: string; label: string }>>,
        required: false,
    },
});

const method = props.role ? 'put' : 'post';
const url = props.role
    ? route('roles.update', props.role.id)
    : route('roles.store');

const form = useForm(method, url, {
    name: props.role?.name ?? '',
    permissions: props.role?.permissions.map((p) => p.id) ?? [],
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
        <template #title> {{ role ? 'Edit' : 'Create New' }} Role </template>
        <template #subtitle>
            Fill in the details for your {{ role ? 'existing' : 'new' }} role.
        </template>
        <template #actions>
            <LinkButton :href="route('roles.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4 sm:p-6">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="1">
                <FieldCol>
                    <InputText
                        label="Role Name"
                        v-model="form.name"
                        :error="form.errors.name"
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
                    {{ role ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('roles.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
