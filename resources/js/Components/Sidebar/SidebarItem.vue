<script setup lang="ts">
import SidebarDropdownItem from '@/Components/Sidebar/SidebarDropdownItem.vue';
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{ item: NavigationItem }>();

// Track the currently open dropdown item (only one at a time)
const collapsedItem = ref<string | null>(null);

// Function to toggle the collapse state for a specific item
const toggleCollapse = (itemId: string) => {
    collapsedItem.value = collapsedItem.value === itemId ? null : itemId;
};
</script>

<template>
    <li>
        <SidebarDropdownItem
            v-if="item.children.length > 0"
            :item="item"
            :active="item.active"
            :is-collapsed="collapsedItem !== item.id"
            @toggle-collapse="toggleCollapse(item.id)"
        />
        <Link
            v-else
            preserve-scroll
            prefetch
            :href="item.url"
            :class="[
                'flex items-center gap-2 rounded-md px-2 py-2 text-sm font-medium',
                {
                    'bg-gray-900 text-white dark:bg-gray-600': item.active,
                    'text-gray-900 hover:bg-gray-300 dark:text-gray-200 dark:hover:bg-gray-600':
                        !item.active,
                },
            ]"
        >
            <component :is="getIcon(item.attributes.icon)" class="text-lg" />
            {{ item.title }}
        </Link>
    </li>
</template>
