<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: PublicLayout });
</script>

<template>
    <Head title="Privacy Policy" />

    <section class="container mx-auto py-16 px-6">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-8">Privacy Policy</h1>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Your privacy is important to us. This Privacy Policy outlines how we handle your data.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">1. Information Collection</h2>
        <p class="text-gray-600 dark:text-gray-300">
            We collect personal information when you use our services, such as your name, email, and contact details.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">2. Use of Information</h2>
        <p class="text-gray-600 dark:text-gray-300">
            The information we collect is used to provide and improve our services.
        </p>

        <h2 class="text-2xl font-bold mt-6 mb-2">3. Data Security</h2>
        <p class="text-gray-600 dark:text-gray-300">
            We take appropriate measures to secure your data and protect it from unauthorized access.
        </p>

        <p class="mt-8 text-gray-600 dark:text-gray-300">
            If you have any questions about this Privacy Policy, please contact us.
        </p>
    </section>
</template>
