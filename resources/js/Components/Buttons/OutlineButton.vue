<script setup lang="ts"></script>
<template>
    <button
        v-bind="$attrs"
        type="button"
        class="border-primary-300 hover:border-primary-500 active:border-primary-400 text-primary-500 inline-flex h-9 items-center rounded border-2 bg-white px-3 font-bold focus:outline-none focus:ring dark:border-gray-500 dark:bg-transparent dark:text-gray-400 dark:hover:border-gray-400 dark:active:border-gray-300"
    >
        <slot />
    </button>
</template>
