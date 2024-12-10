<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { FaBars } from '@kalimahapps/vue-icons';
import { ref } from 'vue';
const isMenuOpen = ref(false);

// Function to toggle the menu
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>

<template>
    <!-- Mobile Menu Toggle Button -->
    <button
        @click="toggleMenu"
        class="p-2 text-gray-500 focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 md:hidden"
    >
        <FaBars />
    </button>
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
