<script setup lang="ts">
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';

const props = defineProps<{
    item: NavigationItem;
    isCollapsed: boolean;
}>();

const emit = defineEmits<{
    (event: 'toggle-collapse'): void;
}>();

const toggleCollapse = () => {
    emit('toggle-collapse');
};
</script>

<template>
    <button
        @click="toggleCollapse"
        :class="[
            'flex w-full transform items-center gap-0 rounded-md px-2 py-2 text-left text-sm font-medium duration-200 hover:bg-gray-300 dark:text-gray-200 dark:hover:bg-gray-600',
            props.isCollapsed ? 'rounded-t-md' : '',
        ]"
    >
        <component
            :is="getIcon(props.item.attributes.icon)"
            class="mr-2 h-5 w-5"
        />
        <span>{{ props.item.title }}</span>
        <svg
            :class="[
                'ml-auto h-4 w-4 transition-transform duration-300',
                props.isCollapsed ? '-rotate-90' : 'rotate-0',
            ]"
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

    <Transition
        enter-active-class="transition-max-height ease-in-out duration-300"
        enter-from-class="max-h-0 opacity-0"
        enter-to-class="max-h-96 opacity-100"
        leave-active-class="transition-max-height ease-in-out duration-300"
        leave-from-class="max-h-96 opacity-100"
        leave-to-class="max-h-0 opacity-0"
    >
        <ul v-if="!props.isCollapsed" class="space-y-1 overflow-hidden">
            <li v-for="(childItem, index) in props.item.children" :key="index">
                <SidebarItem :item="childItem" />
            </li>
        </ul>
    </Transition>
</template>
