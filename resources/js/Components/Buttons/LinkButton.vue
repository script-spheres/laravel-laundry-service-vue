<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import classNames from 'classnames';
import { useId } from 'vue';

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
        'bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:bg-gray-500 dark:active:bg-gray-700 focus:ring-gray-500',
    secondary:
        'bg-indigo-500 text-white hover:bg-indigo-400 focus:bg-indigo-400 active:bg-indigo-600 dark:bg-indigo-400 dark:hover:bg-indigo-300 dark:focus:bg-indigo-300 dark:active:bg-indigo-500 focus:ring-indigo-500',
    danger: 'bg-red-600 text-white hover:bg-red-500 focus:bg-red-500 active:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400 dark:focus:bg-red-400 dark:active:bg-red-600 focus:ring-red-500',
    success:
        'bg-green-600 text-white hover:bg-green-500 focus:bg-green-500 active:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400 dark:focus:bg-green-400 dark:active:bg-green-600 focus:ring-green-500',
};

const id = useId();
</script>

<template>
    <Link
        :href="href"
        :data-test-id="`link-${id}`"
        :class="
            classNames(
                'items-center rounded-md border border-transparent px-4 py-2 font-semibold tracking-widest text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
                colorClasses[color],
                sizeClasses[size],
            )
        "
    >
        <slot />
    </Link>
</template>
