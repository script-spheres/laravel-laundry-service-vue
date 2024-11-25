<script setup lang="ts">
import { useTableClasses } from '@/Composables/useTableClasses';

const { tableRowClasses } = useTableClasses();
</script>

<template>
    <tr :class="tableRowClasses">
        <slot></slot>
    </tr>
</template>
