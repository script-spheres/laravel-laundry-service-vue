<script setup lang="ts">
const props = defineProps<{
    logo?: string;
}>();

// Default SVG logo as a string (you can place your own SVG code here)
const defaultLogo = `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
    <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="white" />
    <text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size="20" fill="black">Logo</text>
</svg>`;

// Use either the passed logo or the default SVG logo
const logoSrc = props.logo || defaultLogo;
</script>

<template>
    <!-- Use v-html to inject the SVG string if it's the default one -->
    <div v-if="logoSrc.startsWith('<svg')">
        <span v-html="logoSrc"></span>
    </div>
    <!-- Fallback for the provided logo or image URL -->
    <img v-else :src="logoSrc" alt="Logo" />
</template>
