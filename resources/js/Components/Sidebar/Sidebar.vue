<script setup lang="ts">
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import SidebarLogo from '@/Components/Sidebar/SidebarLogo.vue';
import { useSidebar } from '@/Composables/useSidebar';

const { sidebarVisible, toggleSidebar, isMobileDevice } = useSidebar();

// Ensure the sidebar starts open on desktop
if (!isMobileDevice.value) {
    sidebarVisible.value = true;
}
</script>

<template>
    <!-- Sidebar Overlay for Mobile -->
    <div
        v-if="isMobileDevice && sidebarVisible"
        class="fixed inset-0 z-[99998] bg-black bg-opacity-50 transition-opacity"
        @click="toggleSidebar"
    />
    <!-- Sidebar -->
    <aside
        class="scrollbar-none fixed top-0 z-[99999] h-screen overflow-y-auto bg-white duration-300 dark:bg-gray-900 lg:border-r lg:border-gray-700"
        :class="{
            'left-0': sidebarVisible || !isMobileDevice,
            '-left-full': !sidebarVisible && isMobileDevice,
            'lg:left-0 lg:w-[250px]': !isMobileDevice,
        }"
    >
        <SidebarLogo @close-sidebar="toggleSidebar" />
        <div class="overflow-y-auto px-2 py-3">
            <ul class="flex flex-col">
                <SidebarItem
                    v-for="(item, index) in $page.props.navigations"
                    :key="index"
                    :item="item"
                />
            </ul>
        </div>
    </aside>
</template>
