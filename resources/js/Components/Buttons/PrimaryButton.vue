<script setup lang="ts">
import classNames from 'classnames';

const { size = 'md', color = 'primary' } = defineProps<{
    size?: 'sm' | 'md' | 'lg';
    color?: 'primary' | 'secondary' | 'danger' | 'success';
}>();

// Size class mappings
const sizeClasses = {
    sm: 'h-7 px-3 text-xs',
    md: 'h-9 px-4 text-sm',
    lg: 'h-11 px-5 text-base',
};

// Color class mappings with improved dark mode
const colorClasses = {
    primary:
        'bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:bg-gray-500 dark:active:bg-gray-700 focus:ring-gray-500',
    secondary:
        'bg-gray-500 text-white hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-600 dark:bg-gray-400 dark:hover:bg-gray-300 dark:focus:bg-gray-300 dark:active:bg-gray-500 focus:ring-gray-500',
    danger: 'bg-red-600 text-white hover:bg-red-500 focus:bg-red-500 active:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400 dark:focus:bg-red-400 dark:active:bg-red-600 focus:ring-red-500',
    success:
        'bg-green-600 text-white hover:bg-green-500 focus:bg-green-500 active:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400 dark:focus:bg-green-400 dark:active:bg-green-600 focus:ring-green-500',
};
</script>

<template>
    <button
        v-bind="{ ...$attrs }"
        :class="
            classNames(
                'items-center rounded-md border border-transparent px-4 py-2 font-semibold tracking-widest text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
                colorClasses[color],
                sizeClasses[size],
            )
        "
    >
        <slot />
    </button>
</template>
