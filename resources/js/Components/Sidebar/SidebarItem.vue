<script setup lang="ts">
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';
import { Link } from '@inertiajs/vue3';

defineProps<{ item: NavigationItem }>();
</script>

<template>
    <Link
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
</template>
