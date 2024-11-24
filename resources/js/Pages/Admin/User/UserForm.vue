<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';

import FilepondInput from '@/Components/Form/FilepondInput.vue';
import { rolesOptions, statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { User } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    user: {
        type: Object as PropType<User>,
        required: true,
    },
    unitsOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const { user } = props;

const method = user ? 'put' : 'post';
const url = user
    ? route('admin.users.update', user.id)
    : route('admin.users.store');

const form = useForm(method, url, {
    role_id: user.role_id ?? '',
    name: user.name ?? '',
    email: user.email ?? '',
    image: user.image ?? '',
    mobile: user.mobile ?? '',
    active_status: user.active_status ?? '',
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
            <LinkButton :href="route('admin.users.index')"> Back </LinkButton>
        </div>
    </div>
    <Card class="mx-auto mt-6 p-6">
        <form class="w-full" @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="role_id" value="Role" />
                    <SelectInput
                        v-model="form.role_id"
                        :options="rolesOptions"
                    />
                    <InputError :message="form.errors.role_id" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="name" value="Name" />
                    <TextInput v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="image" value="Image" />
                    <FilepondInput
                        @input="form.image = $event.target.files[0]"
                    />
                    <InputError :message="form.errors.image" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel for="email" value="Email" />
                    <TextInput v-model="form.email" />
                    <InputError :message="form.errors.email" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel for="mobile" value="Mobile" />
                    <TextInput v-model="form.mobile" />
                    <InputError :message="form.errors.mobile" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel for="active_status" value="Status" />
                    <SelectInput
                        v-model="form.active_status"
                        :options="statusOptions"
                    />
                    <InputError :message="form.errors.active_status" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap gap-3 px-3 md:mb-0">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :href="route('admin.users.index')">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
