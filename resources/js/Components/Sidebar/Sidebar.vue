<script setup lang="ts">
import SidebarDropdownItem from '@/Components/Sidebar/SidebarDropdownItem.vue';
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import { NavigationItem } from '@/types';
import { ref, watch } from 'vue';

defineProps<{ navigations: NavigationItem[] }>();

const emits = defineEmits(['update:collapsed']);

const collapsed = ref(false);
const collapsedItem = ref<string | null>(null);

// Toggle collapse for the item and emit update
const toggleCollapse = (index: number) => {
    collapsedItem.value =
        collapsedItem.value === String(index) ? null : String(index);
    emits('update:collapsed', collapsed.value);
};

watch(collapsed, (newCollapsed) => emits('update:collapsed', newCollapsed));
</script>

<template>
    <ul class="space-y-1">
        <!-- Loop through the navigation items -->
        <li v-for="(item, index) in navigations" :key="index">
            <!-- If the item has children, display SidebarDropdownItem -->
            <SidebarDropdownItem
                v-if="item.children && item.children.length > 0"
                :item="item"
                :is-collapsed="collapsedItem !== String(index)"
                @toggle-collapse="toggleCollapse(index)"
            />

            <!-- If the item does not have children, display a Link -->
            <SidebarItem v-else :item="item" />
        </li>
    </ul>
</template>
