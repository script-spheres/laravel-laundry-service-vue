<script setup lang="ts">
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import { NavigationItem } from '@/types';
import getIcon from '@/Utility/icons';
import { computed, ref, watch } from 'vue';

const props = defineProps<{ item: NavigationItem }>();

// Check if any child is active
const hasActiveChild = computed(() =>
    props.item.children?.some((child) => child.active)
);

// Initialize isCollapsed with the value of hasActiveChild
const isCollapsed = ref(hasActiveChild.value);

// Watch for changes in hasActiveChild and update isCollapsed accordingly
watch(hasActiveChild, (newValue) => {
    if (newValue) {
        isCollapsed.value = true;
    }
});

const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
};

const svgClasses = computed(() => [
    'w-4 h-4 ml-auto transition-transform duration-300',
    isCollapsed.value ? 'rotate-0' : '-rotate-90',
]);
</script>

<template>
    <div>
        <button
            @click="toggleCollapse"
            :class="[
                'flex w-full transform items-center gap-0 rounded-md px-2 py-2 text-left text-sm font-medium duration-200 hover:bg-gray-300 dark:text-gray-200 dark:hover:bg-gray-600',
                isCollapsed ? 'rounded-t-md' : '',
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
        <Transition
            enter-active-class="transition-max-height ease-in-out duration-300"
            enter-from-class="max-h-0 opacity-0"
            enter-to-class="max-h-96 opacity-100"
            leave-active-class="transition-max-height ease-in-out duration-300"
            leave-from-class="max-h-96 opacity-100"
            leave-to-class="max-h-0 opacity-0"
        >
            <ul v-if="isCollapsed" class="space-y-1 overflow-hidden">
                <SidebarItem
                    v-for="(childItem, index) in item.children"
                    :key="index"
                    :item="childItem"
                />
            </ul>
        </Transition>
    </div>
</template>
