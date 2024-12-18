<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { User } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    user: {
        type: Object as PropType<User>,
        required: true,
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
    role_id: props.user.name ?? '',
    name: props.user.name ?? '',
    email: props.user.email ?? '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{ user ? 'Edit' : 'Create New' }} User
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ user ? 'existing' : 'new' }} user.
            </p>
        </div>
        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('users.index')"> Back </LinkButton>
        </div>
    </div>
    <Card class="mx-auto mt-6 p-6">
        <form class="w-full" @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="role_id" value="Role" />
                    <InputSelect
                        v-model="form.role_id"
                        :options="rolesOptions"
                    />
                    <InputError :error="form.errors.role_id" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="name" value="Name" />
                    <InputText v-model="form.name" />
                    <InputError :error="form.errors.name" />
                </div>
            </div>

            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel for="email" value="Email" />
                    <InputText v-model="form.email" />
                    <InputError :error="form.errors.email" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap gap-3 px-3 md:mb-0">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :href="route('users.index')"> Cancel </LinkButton>
            </div>
        </form>
    </Card>
</template>
