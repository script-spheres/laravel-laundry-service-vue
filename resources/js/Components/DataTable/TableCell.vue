<script lang="ts" setup>
import { useTableClasses } from '@/Components/DataTable/useTableClasses';

const { tableCellClasses } = useTableClasses();
</script>

<template>
    <td :class="tableCellClasses">
        <slot></slot>
    </td>
</template>
