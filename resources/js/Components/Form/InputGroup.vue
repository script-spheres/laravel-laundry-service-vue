<script setup lang="ts">
import { useId } from 'vue';

const id = useId();
</script>

<template>
    <label
        v-if="$attrs.label"
        :for="id"
        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
        :data-test-id="`label-${id}`"
    >
        {{ $attrs.label }} :
    </label>
    <div class="flex w-full items-center justify-center">
        <slot />
    </div>
    <p v-show="$attrs.error" class="text-sm text-red-600 dark:text-red-400">
        {{ $attrs.error }}
    </p>
</template>
