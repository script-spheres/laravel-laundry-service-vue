<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: PublicLayout });
</script>

<template>
    <Head title="Privacy Policy" />

    <section class="container mx-auto px-6 py-16">
        <h1 class="mb-8 text-4xl font-extrabold text-gray-800 dark:text-white">
            Privacy Policy
        </h1>
        <p class="mb-4 text-gray-600 dark:text-gray-300">
            Your privacy is important to us. This Privacy Policy outlines how we
            handle your data.
        </p>

        <h2 class="mb-2 mt-6 text-2xl font-bold">1. Information Collection</h2>
        <p class="text-gray-600 dark:text-gray-300">
            We collect personal information when you use our services, such as
            your name, email, and contact details.
        </p>

        <h2 class="mb-2 mt-6 text-2xl font-bold">2. Use of Information</h2>
        <p class="text-gray-600 dark:text-gray-300">
            The information we collect is used to provide and improve our
            services.
        </p>

        <h2 class="mb-2 mt-6 text-2xl font-bold">3. Data Security</h2>
        <p class="text-gray-600 dark:text-gray-300">
            We take appropriate measures to secure your data and protect it from
            unauthorized access.
        </p>

        <p class="mt-8 text-gray-600 dark:text-gray-300">
            If you have any questions about this Privacy Policy, please contact
            us.
        </p>
    </section>
</template>
