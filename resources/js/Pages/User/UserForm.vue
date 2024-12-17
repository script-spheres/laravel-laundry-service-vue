<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/InputFilepond.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { User } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    user: {
        type: Object as PropType<User>,
        required: false,
    },
    rolesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const method = props.user ? 'put' : 'post';
const url = props.user
    ? route('users.update', props.user.id)
    : route('users.store');

const form = useForm(method, url, {
    role_id: props.user?.role_id ?? '',
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    image: props.user?.image ?? '',
    mobile: props.user?.mobile ?? '',
    status: props.user?.status ?? '',
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
        <template #title> {{ user ? 'Edit' : 'Create New' }} User </template>
        <template #subtitle>
            Fill in the details for your {{ user ? 'existing' : 'new' }} user.
        </template>
        <template #actions>
            <LinkButton :href="route('users.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4 sm:p-6">
        <form @submit.prevent="submitForm">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-8">
                <!-- Image Upload for Medium and Larger Screens -->
                <div class="flex justify-center md:col-span-2">
                    <FilepondInput
                        stylePanelLayout="circle"
                        label="Image"
                        :error="form.errors.image"
                    />
                </div>

                <!-- Form Fields -->
                <div class="md:col-span-6">
                    <FieldRow :cols="1" class="md:grid-cols-2">
                        <FieldCol>
                            <InputSelect
                                label="Role"
                                v-model="form.role_id"
                                :options="rolesOptions"
                                :error="form.errors.role_id"
                            />
                        </FieldCol>
                        <FieldCol>
                            <InputText
                                label="Name"
                                v-model="form.name"
                                :error="form.errors.name"
                            />
                        </FieldCol>
                    </FieldRow>

                    <FieldRow :cols="1" class="md:grid-cols-3">
                        <FieldCol>
                            <InputText
                                label="Email"
                                v-model="form.email"
                                :error="form.errors.email"
                            />
                        </FieldCol>
                        <FieldCol>
                            <InputText
                                label="Mobile"
                                v-model="form.mobile"
                                :error="form.errors.mobile"
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

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-col gap-2 md:flex-row">
                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            {{ user ? 'Update' : 'Submit' }}
                        </PrimaryButton>
                        <LinkButton :href="route('users.index')" color="danger">
                            Cancel
                        </LinkButton>
                    </div>
                </div>
            </div>
        </form>
    </Card>
</template>
