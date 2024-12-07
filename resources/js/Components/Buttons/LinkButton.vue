<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import classNames from 'classnames';

const {
    size = 'md',
    color = 'primary',
    href,
} = defineProps<{
    size?: 'sm' | 'md' | 'lg';
    color?: 'primary' | 'secondary' | 'danger' | 'success';
    href: string;
}>();

// Size class mappings
const sizeClasses = {
    sm: 'h-7 px-3 text-xs',
    md: 'h-9 px-4 text-sm',
    lg: 'h-11 px-5 text-base',
};

// Color class mappings
const colorClasses = {
    primary:
        'bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900',
    secondary:
        'bg-gray-500 text-white hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-600',
    danger: 'bg-red-600 text-white hover:bg-red-500 focus:bg-red-500 active:bg-red-700',
    success:
        'bg-green-600 text-white hover:bg-green-500 focus:bg-green-500 active:bg-green-700',
};
</script>

<template>
    <Link
        :href="href"
        :class="
            classNames(
                'items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-600 dark:text-gray-800 dark:hover:bg-gray-400 dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300',
                colorClasses[color],
                sizeClasses[size],
            )
        "
    >
        <slot />
    </Link>
</template>
