<script setup lang="ts">
const props = defineProps<{
    cols?: number | Record<string, number>;
}>();

const colsClasses = () => {
    if (typeof props.cols === 'number') {
        return `grid-cols-${props.cols}`;
    } else if (typeof props.cols === 'object') {
        return Object.entries(props.cols)
            .map(([breakpoint, value]) => `${breakpoint}:grid-cols-${value}`)
            .join(' ');
    }
    return 'grid-cols-1';
};
</script>

<template>
    <div class="grid w-full gap-4" :class="colsClasses()" v-bind="$attrs">
        <slot />
    </div>
</template>
