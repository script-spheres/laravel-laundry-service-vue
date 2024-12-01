<script setup lang="ts">
import classNames from 'classnames';

const { size = 'md' } = defineProps<{
    size?: 'sm' | 'md';
}>();
</script>
<template>
    <button
        v-bind="{ ...$attrs }"
        :class="
            classNames(
                'items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300',
                {
                    'h-9 px-4 text-sm': size === 'md',
                    'h-7 px-3 text-xs': size === 'sm',
                },
            )
        "
    >
        <slot />
    </button>
</template>
