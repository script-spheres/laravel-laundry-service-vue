<script lang="ts" setup>
import { useTableClasses } from '@/Composables/useTableClasses';

const { tableCellClasses } = useTableClasses();
</script>

<template>
    <td :class="tableCellClasses">
        <slot></slot>
    </td>
</template>
