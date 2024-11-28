<script setup lang="ts">
defineProps({
    breadcrumbLinks: {
        type: Array,
        default: () => [],
    },
});
</script>
<template>
    <nav class="text-sm font-medium text-gray-600 dark:text-gray-300">
        <ol class="flex items-center space-x-2">
            <li
                v-if="breadcrumbLinks && breadcrumbLinks.length"
                class="flex items-center"
            >
                <span class="mx-2">/</span>
                <span>{{ breadcrumbLinks.join(' / ') }}</span>
            </li>
        </ol>
    </nav>
</template>
