<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: PublicLayout });
</script>

<template>
    <Head title="Terms & Conditions" />

    <section class="container mx-auto py-16 px-6">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-8">Terms & Conditions</h1>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Please read these Terms & Conditions carefully before using our services.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">1. Acceptance of Terms</h2>
        <p class="text-gray-600 dark:text-gray-300">
            By using our services, you agree to these Terms & Conditions.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">2. Services Provided</h2>
        <p class="text-gray-600 dark:text-gray-300">
            We offer professional laundry services subject to these terms.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">3. User Responsibilities</h2>
        <p class="text-gray-600 dark:text-gray-300">
            You agree to provide accurate information and comply with our service guidelines.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">4. Limitation of Liability</h2>
        <p class="text-gray-600 dark:text-gray-300">
            We are not liable for damages beyond the scope of our service commitments.
        </p>

        <p class="mt-8 text-gray-600 dark:text-gray-300">
            If you have any questions about these Terms & Conditions, please contact us.
        </p>
    </section>
</template>
