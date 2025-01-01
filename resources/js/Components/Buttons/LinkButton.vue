<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import classNames from 'classnames';
import { useId } from 'vue';

const {
    size = 'md',
    color = 'gray',
    href,
} = defineProps<{
    size?: 'sm' | 'md' | 'lg';
    color?:
        | 'slate'
        | 'gray'
        | 'zinc'
        | 'neutral'
        | 'stone'
        | 'red'
        | 'orange'
        | 'amber'
        | 'yellow'
        | 'lime'
        | 'green'
        | 'emerald'
        | 'teal'
        | 'cyan'
        | 'sky'
        | 'blue'
        | 'indigo'
        | 'violet'
        | 'purple'
        | 'fuchsia'
        | 'pink'
        | 'rose';
    href: string;
}>();

// Size class mappings
const sizeClasses = {
    sm: 'px-1 py-1 text-xs',
    md: 'px-2 py-1 text-sm',
    lg: 'px-5 py-1 text-base',
};

// Dynamic color class generation
const colorClasses = (color: string) => {
    return `bg-${color}-600 dark:bg-${color}-500 hover:bg-${color}-500 dark:hover:bg-${color}-400 focus:bg-${color}-500 dark:focus:bg-${color}-400 active:bg-${color}-700 dark:active:bg-${color}-600`;
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
                colorClasses(color),
                sizeClasses[size],
            )
        "
    >
        <slot />
    </Link>
</template>
