<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: AuthenticatedLayout });

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Profile" />

    <PageHeader>
        <template #title>Profile</template>
        <template #subtitle>subtitle</template>
    </PageHeader>
    <div class="mx-auto space-y-6">
        <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />
        </div>

        <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
            <UpdatePasswordForm class="max-w-xl" />
        </div>
    </div>
</template>
