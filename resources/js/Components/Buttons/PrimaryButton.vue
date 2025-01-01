<script setup lang="ts">
import classNames from 'classnames';
import { PropType } from 'vue';

defineProps({
    size: {
        type: String as PropType<'sm' | 'md' | 'lg'>,
        default: 'md',
    },
    color: {
        type: String as PropType<
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
            | 'rose'
        >,
        default: 'gray',
    },
    href: String,
});

// Size class mappings
const sizeClasses = {
    sm: 'px-1 py-1 text-xs',
    md: 'px-2 py-2 text-sm',
    lg: 'px-5 py-4 text-base',
};

// Dynamically generate color class mapping based on the base color name
// const colorClasses = (color: string) => {
//     return {
//         bg: `bg-${color}-600`,
//         hover: `hover:bg-${color}-500`,
//         focus: `focus:bg-${color}-500`,
//         active: `active:bg-${color}-700`,
//         darkBg: `dark:bg-${color}-500`,
//         darkHover: `dark:hover:bg-${color}-400`,
//         darkFocus: `dark:focus:bg-${color}-400`,
//         darkActive: `dark:active:bg-${color}-600`,
//     };
// };

// const colorClasses = {
//     slate: 'bg-slate-600 hover:bg-slate-500 focus:bg-slate-500 active:bg-slate-700 dark:bg-slate-500 dark:hover:bg-slate-400 dark:focus:bg-slate-400 dark:active:bg-slate-600',
//     gray: 'bg-gray-600 hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-400 dark:focus:bg-gray-400 dark:active:bg-gray-600',
//     zinc: 'bg-zinc-600 hover:bg-zinc-500 focus:bg-zinc-500 active:bg-zinc-700 dark:bg-zinc-500 dark:hover:bg-zinc-400 dark:focus:bg-zinc-400 dark:active:bg-zinc-600',
//     neutral: 'bg-neutral-600 hover:bg-neutral-500 focus:bg-neutral-500 active:bg-neutral-700 dark:bg-neutral-500 dark:hover:bg-neutral-400 dark:focus:bg-neutral-400 dark:active:bg-neutral-600',
//     stone: 'bg-stone-600 hover:bg-stone-500 focus:bg-stone-500 active:bg-stone-700 dark:bg-stone-500 dark:hover:bg-stone-400 dark:focus:bg-stone-400 dark:active:bg-stone-600',
//     red: 'bg-red-600 hover:bg-red-500 focus:bg-red-500 active:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400 dark:focus:bg-red-400 dark:active:bg-red-600',
//     orange: 'bg-orange-600 hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-400 dark:focus:bg-orange-400 dark:active:bg-orange-600',
//     amber: 'bg-amber-600 hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 dark:bg-amber-500 dark:hover:bg-amber-400 dark:focus:bg-amber-400 dark:active:bg-amber-600',
//     yellow: 'bg-yellow-600 hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-700 dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:bg-yellow-400 dark:active:bg-yellow-600',
//     lime: 'bg-lime-600 hover:bg-lime-500 focus:bg-lime-500 active:bg-lime-700 dark:bg-lime-500 dark:hover:bg-lime-400 dark:focus:bg-lime-400 dark:active:bg-lime-600',
//     green: 'bg-green-600 hover:bg-green-500 focus:bg-green-500 active:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400 dark:focus:bg-green-400 dark:active:bg-green-600',
//     emerald: 'bg-emerald-600 hover:bg-emerald-500 focus:bg-emerald-500 active:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus:bg-emerald-400 dark:active:bg-emerald-600',
//     teal: 'bg-teal-600 hover:bg-teal-500 focus:bg-teal-500 active:bg-teal-700 dark:bg-teal-500 dark:hover:bg-teal-400 dark:focus:bg-teal-400 dark:active:bg-teal-600',
//     cyan: 'bg-cyan-600 hover:bg-cyan-500 focus:bg-cyan-500 active:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:focus:bg-cyan-400 dark:active:bg-cyan-600',
//     sky: 'bg-sky-600 hover:bg-sky-500 focus:bg-sky-500 active:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus:bg-sky-400 dark:active:bg-sky-600',
//     blue: 'bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:bg-blue-400 dark:active:bg-blue-600',
//     indigo: 'bg-indigo-600 hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus:bg-indigo-400 dark:active:bg-indigo-600',
//     violet: 'bg-violet-600 hover:bg-violet-500 focus:bg-violet-500 active:bg-violet-700 dark:bg-violet-500 dark:hover:bg-violet-400 dark:focus:bg-violet-400 dark:active:bg-violet-600',
//     purple: 'bg-purple-600 hover:bg-purple-500 focus:bg-purple-500 active:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-400 dark:focus:bg-purple-400 dark:active:bg-purple-600',
//     fuchsia: 'bg-fuchsia-600 hover:bg-fuchsia-500 focus:bg-fuchsia-500 active:bg-fuchsia-700 dark:bg-fuchsia-500 dark:hover:bg-fuchsia-400 dark:focus:bg-fuchsia-400 dark:active:bg-fuchsia-600',
//     pink: 'bg-pink-600 hover:bg-pink-500 focus:bg-pink-500 active:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-400 dark:focus:bg-pink-400 dark:active:bg-pink-600',
//     rose: 'bg-rose-600 hover:bg-rose-500 focus:bg-rose-500 active:bg-rose-700 dark:bg-rose-500 dark:hover:bg-rose-400 dark:focus:bg-rose-400 dark:active:bg-rose-600',
// };

const colorClasses = (color: string) => {
    return `bg-${color}-600 dark:bg-${color}-500 hover:bg-${color}-500 dark:hover:bg-${color}-400 focus:bg-${color}-500 dark:focus:bg-${color}-400 active:bg-${color}-700 dark:active:bg-${color}-600`;
};
</script>

<template>
    <button
        v-bind="{ ...$attrs }"
        :class="
            classNames(
                'items-center rounded-md border border-transparent font-semibold tracking-widest text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
                colorClasses(color),
                sizeClasses[size],
            )
        "
    >
        <slot />
    </button>
</template>
