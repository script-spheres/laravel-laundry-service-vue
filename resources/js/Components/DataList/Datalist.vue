<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({});
</script>

<template>
    <div class="rounded border border-gray-200 bg-white shadow">
        <slot name="content" />
    </div>
</template>
