<script setup lang="ts">
import SidebarDropdownItem from '@/Components/Sidebar/SidebarDropdownItem.vue';
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';
import { Link } from '@inertiajs/vue3';

defineProps<{ item: NavigationItem }>();
</script>
<template>
    <li class="">
        <SidebarDropdownItem v-if="item.children.length > 0" :item="item" />
        <Link
            v-else
            preserve-scroll
            :href="item.url"
            :class="[
                'flex items-center gap-2 rounded-md px-2 py-2 text-sm font-medium dark:text-white',
                {
                    'bg-gray-900 text-white': item.active,
                },
            ]"
        >
            <component :is="getIcon(item.attributes.icon)" class="text-lg" />
            {{ item.title }}
        </Link>
    </li>
</template>
