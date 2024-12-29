<script setup lang="ts">
import classNames from 'classnames';

const { size = 'md', color = 'gray' } = defineProps<{
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
}>();

// Size class mappings
const sizeClasses = {
    sm: 'px-1 py-1 text-xs',
    md: 'px-2 py-2 text-sm',
    lg: 'px-5 py-4 text-base',
};

// Dynamically generate color class mapping based on the base color name
const colorClasses = (color: string) => {
    return {
        bg: `bg-${color}-600`,
        hover: `hover:bg-${color}-500`,
        focus: `focus:bg-${color}-500`,
        active: `active:bg-${color}-700`,
        darkBg: `dark:bg-${color}-500`,
        darkHover: `dark:hover:bg-${color}-400`,
        darkFocus: `dark:focus:bg-${color}-400`,
        darkActive: `dark:active:bg-${color}-600`,
    };
};
</script>

<template>
    <button
        v-bind="{ ...$attrs }"
        :class="
            classNames(
                'items-center rounded-md border border-transparent font-semibold tracking-widest text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
                colorClasses(color).bg,
                colorClasses(color).hover,
                colorClasses(color).focus,
                colorClasses(color).active,
                colorClasses(color).darkBg,
                colorClasses(color).darkHover,
                colorClasses(color).darkFocus,
                colorClasses(color).darkActive,
                sizeClasses[size],
            )
        "
    >
        <slot />
    </button>
</template>
