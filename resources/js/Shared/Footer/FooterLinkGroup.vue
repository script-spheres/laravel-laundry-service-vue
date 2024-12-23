<script setup lang="ts">
import FooterLink from './FooterLink.vue';
</script>

<template>
    <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 sm:gap-6">
        <div>
            <h2
                class="mb-6 text-sm font-semibold uppercase text-gray-900 dark:text-white"
            >
                Resources
            </h2>
            <ul class="font-medium text-gray-500 dark:text-gray-400">
                <FooterLink href="https://flowbite.com/" label="Flowbite" />
                <FooterLink
                    href="https://tailwindcss.com/"
                    label="Tailwind CSS"
                />
            </ul>
        </div>
        <div>
            <h2
                class="mb-6 text-sm font-semibold uppercase text-gray-900 dark:text-white"
            >
                Follow us
            </h2>
            <ul class="font-medium text-gray-500 dark:text-gray-400">
                <FooterLink
                    href="https://github.com/themesberg/flowbite"
                    label="Github"
                />
                <FooterLink
                    href="https://discord.gg/4eeurUVvTy"
                    label="Discord"
                />
            </ul>
        </div>
        <div>
            <h2
                class="mb-6 text-sm font-semibold uppercase text-gray-900 dark:text-white"
            >
                Legal
            </h2>
            <ul class="font-medium text-gray-500 dark:text-gray-400">
                <FooterLink href="#" label="Privacy Policy" />
                <FooterLink href="#" label="Terms & Conditions" />
            </ul>
        </div>
    </div>
</template>

<style scoped></style>
