<script setup lang="ts">
const props = defineProps<{
    logo: string;
}>();
</script>

<template>
    <img :src="props.logo" alt="Logo" />
</template>
