<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import FilepondInput from '@/Components/Form/InputFilepond.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { User } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const { user } = defineProps({
    user: {
        type: Object as PropType<User>,
        required: false,
    },
    roleOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const method = user ? 'put' : 'post';
const url = user ? route('users.update', user.id) : route('users.store');

// Initialize form data, exclude password if user exists (for editing)
const form = useForm(method, url, {
    name: user?.name ?? '',
    email: user?.email ?? '',
    image: user?.image || {},
    new_image: null as string | null,
    role: user?.roles[0] ?? '',
    ...(user ? {} : { password: '' }),
});

const handleFileProcess = (error: any, file: any) => {
    if (user) {
        form.new_image = file.serverId;
    } else {
        form.image = file.serverId;
    }
};

const handleFileRemoved = () => {
    if (user) {
        form.new_image = null;
    } else {
        form.image = {};
    }
};

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <PageHeader>
        <template #title> {{ user ? 'Edit' : 'Create New' }} User</template>
        <template #subtitle>
            Fill in the details for your {{ user ? 'existing' : 'new' }} user.
        </template>
        <template #actions>
            <LinkButton :href="route('users.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4 sm:p-6">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="2">
                <FieldCol>
                    <InputText
                        label="Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Email"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        :disabled="!!user"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow :cols="2">
                <FieldCol>
                    <InputSelect
                        label="Role"
                        v-model="form.role"
                        :options="roleOptions"
                        :error="form.errors.role"
                    />
                </FieldCol>
                <FieldCol v-if="!user">
                    <InputText
                        label="Password"
                        v-model="form.password"
                        :error="form.errors.password"
                    />
                </FieldCol>
            </FieldRow>

            <FieldRow :cols="1">
                <FieldCol>
                    <FilepondInput
                        label="Image"
                        :files="user?.image"
                        @processfile="handleFileProcess"
                        @removefile="handleFileRemoved"
                        :error="form.errors.image"
                    />
                </FieldCol>
            </FieldRow>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ user ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('users.index')" color="red">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
