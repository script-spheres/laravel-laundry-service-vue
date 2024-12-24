<script setup lang="ts">
defineProps<{
    value?: string;
}>();
</script>

<template>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        <template v-if="value">{{ value }}</template>
        <template v-else>
            <slot />
        </template>
    </label>
</template>
