<script setup lang="ts">
import SidebarDropdownItem from '@/Components/Sidebar/SidebarDropdownItem.vue';
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';
import { Link } from '@inertiajs/vue3';

defineProps<{ item: NavigationItem }>();
</script>
<template>
    <li>
        <SidebarDropdownItem
            v-if="item.children.length > 0"
            :item="item"
            :active="item.active"
        />
        <Link
            v-else
            preserve-scroll
            :href="item.url"
            :class="[
                'w-full flex items-center text-left rounded-md px-4 py-2 text-sm font-normal text-white text-opacity-60 hover:text-opacity-100 hover:bg-white hover:bg-opacity-10 transform duration-200',
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
