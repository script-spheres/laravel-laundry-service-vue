<script setup lang="ts">
defineProps({
    label: {
        type: [Boolean, String],
        required: false,
    },
    extraClasses: {
        type: [Array, String],
        required: false,
    },
});
</script>
<template>
    <span
        class="inline-flex min-h-6 items-center whitespace-nowrap rounded-full px-2 text-xs font-bold uppercase"
        :class="extraClasses"
    >
        <slot name="icon" />
        <slot>
            {{ label }}
        </slot>
    </span>
</template>
