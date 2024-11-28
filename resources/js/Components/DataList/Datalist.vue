<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({});
</script>

<template>
    <section class="mx-auto rounded border border-gray-200 bg-white p-6 shadow">
        <slot name="content" />
    </section>
</template>
