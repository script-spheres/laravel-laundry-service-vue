<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    label: {
        type: [Boolean, String],
        required: false,
    },
    color: {
        type: String,
        default: 'gray', // Default color
    },
});

// Map colors to predefined classes
const colorClasses = computed(() => {
    const colors = {
        gray: 'bg-gray-200 text-gray-800',
        red: 'bg-red-200 text-red-800',
        green: 'bg-green-200 text-green-800',
        blue: 'bg-blue-200 text-blue-800',
        yellow: 'bg-yellow-200 text-yellow-800',
        purple: 'bg-purple-200 text-purple-800',
        pink: 'bg-pink-200 text-pink-800',
    };
    return colors[props.color] || colors['gray'];
});
</script>

<template>
    <span
        class="inline-flex min-h-6 items-center whitespace-nowrap rounded-full px-2 text-xs font-bold uppercase"
        :class="colorClasses"
    >
        <slot name="icon" />
        <slot>
            {{ label }}
        </slot>
    </span>
</template>
