<script setup lang="ts">
import { useTableClasses } from '@/Components/DataTable/useTableClasses';

const { tableHeadCellClasses } = useTableClasses();
</script>

<template>
    <th :class="tableHeadCellClasses" scope="col">
        <slot></slot>
    </th>
</template>
