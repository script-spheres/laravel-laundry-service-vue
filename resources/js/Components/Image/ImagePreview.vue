<script setup lang="ts">
import { defineProps, ref } from 'vue';

// Define props with TypeScript
const props = defineProps<{
    src?: string; // Image source
    alt?: string; // Alternative text
}>();

// State to track loading errors
const isError = ref(false);

// Default fallback image URL
const fallbackImage =
    'https://source.unsplash.com/1600x900/?hotel,booking.com?v=1';

// Computed source to handle errors
const computedSrc = ref(props.src || fallbackImage);

// Event handlers for image lifecycle
const handleError = () => {
    isError.value = true;
    computedSrc.value = fallbackImage;
};

const handleLoad = () => {
    isError.value = false;
};
</script>

<template>
    <img
        :src="computedSrc"
        :alt="props.alt || 'Lazy loaded image'"
        loading="lazy"
        @error="handleError"
        @load="handleLoad"
        v-bind="{ ...$attrs }"
    />
</template>
