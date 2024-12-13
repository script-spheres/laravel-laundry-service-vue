<script setup lang="ts"></script>

<template>
    <div
        class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
    >
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                <slot name="title" />
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                <slot name="subtitle" />
            </p>
        </div>
        <div class="flex items-center space-x-2 sm:justify-end sm:space-x-4">
            <slot name="actions" />
        </div>
    </div>
</template>
