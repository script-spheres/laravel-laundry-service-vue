<script setup lang="ts">
import { defineProps, reactive, ref } from 'vue';

// Define props with TypeScript
const props = defineProps<{
    src?: string;
    alt?: string;
}>();

// State to track loading errors
const isError = ref(false);

// Reactive lazy loading options
const lazyOptions = reactive({
    src:
        props.src ||
        'https://source.unsplash.com/1600x900/?hotel,booking.com?v=1',
    lifecycle: {
        loading: (el: HTMLElement) => {
            console.log('Image loading', el);
        },
        error: (el: HTMLElement) => {
            console.log('Image error', el);
            isError.value = true; // Set error state
        },
        loaded: (el: HTMLElement) => {
            console.log('Image loaded', el);
        },
    },
});
</script>

<template>
    <img v-lazy="lazyOptions" :alt="props.alt" />
</template>

<style scoped>
/* Additional styles can be added here */
</style>
