<script setup lang="ts">
import FooterCopyright from '@/Components/Footer/FooterCopyright.vue';
import FooterLinkGroup from '@/Components/Footer/FooterLinkGroup.vue';
import Navbar from '@/Components/Navigation/Navbar.vue';
</script>

<template>
    <Navbar />
    <div class="min-h-screen">
        <slot />
    </div>

    <footer class="bg-gray-900">
        <div class="container mx-auto w-full p-4 py-6 lg:py-8">
            <FooterLinkGroup />
            <hr
                class="my-6 border-gray-200 dark:border-gray-700 sm:mx-auto lg:my-8"
            />
            <FooterCopyright />
        </div>
    </footer>
</template>
