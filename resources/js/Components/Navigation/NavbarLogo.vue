<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link
        :href="route('welcome')"
        class="flex items-center space-x-3 rtl:space-x-reverse"
    >
        <img
            src="https://flowbite.com/docs/images/logo.svg"
            alt="Flowbite Logo"
            class="h-8"
        />
        <span class="text-2xl font-semibold dark:text-white">Flowbite</span>
    </Link>
</template>
