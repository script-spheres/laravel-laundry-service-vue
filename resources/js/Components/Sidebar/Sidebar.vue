<script setup lang="ts">
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import { NavigationItem } from '@/types';
import { defineProps } from 'vue';

defineProps<{
    navigations: NavigationItem[];
}>();
</script>

<template>
    <ul class="space-y-1">
        <SidebarItem
            v-for="(item, index) in navigations"
            :key="index"
            :item="item"
        />
    </ul>
</template>
