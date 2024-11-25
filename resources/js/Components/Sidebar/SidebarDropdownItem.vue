<script setup lang="ts">
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps<{ item: NavigationItem }>();

const isCollapsed = ref(false);

const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
};

const svgClasses = computed(() => [
    'w-4 h-4 ml-auto transition-transform',
    isCollapsed.value ? 'rotate-0' : '-rotate-90',
]);
</script>

<template>
    <div>
        <button
            @click="toggleCollapse"
            :class="[
                'flex w-full items-center px-2 py-3 text-sm font-medium dark:text-white',
                isCollapsed ? 'rounded-t-md bg-gray-800 text-white' : '',
            ]"
        >
            <component
                :is="getIcon(item.attributes.icon)"
                class="mr-2 h-5 w-5"
            />
            <span>{{ item.title }}</span>
            <svg
                :class="svgClasses"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                ></path>
            </svg>
        </button>
        <ul
            v-if="isCollapsed"
            class="mb-3 flex flex-col rounded-b bg-red-200 dark:bg-gray-700"
        >
            <li v-for="(childItem, index) in item.children" :key="index">
                <Link
                    preserve-scroll
                    :href="childItem.url"
                    :class="[
                        'flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 dark:text-gray-200 dark:hover:bg-gray-600',
                        {
                            'text-white': childItem.active,
                        },
                    ]"
                >
                    <component
                        :is="getIcon(childItem.attributes.icon)"
                        class="h-4 w-4"
                    />
                    {{ childItem.title }}
                </Link>
            </li>
        </ul>
    </div>
</template>
