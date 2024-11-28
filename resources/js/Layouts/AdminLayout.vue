<script setup lang="ts">
import Dropdown from '@/Components/Dropdown/Dropdown.vue';
import DropdownLink from '@/Components/Dropdown/DropdownLink.vue';
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import SidebarLogo from '@/Components/Sidebar/SidebarLogo.vue';
import { useDarkMode } from '@/Composables/useDarkMode';
import { useSidebar } from '@/Composables/useSidebar';

import {
    AkMoonFill,
    AkSunFill,
    FaAngleDown,
    FaBarsStaggered,
    FeMail,
    MdNotificationsNone,
} from '@kalimahapps/vue-icons';

const { isDark, toggleDark } = useDarkMode();
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
    ></div>

    <!-- Sidebar -->
    <aside
        ref="sidebarRef"
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

    <!-- Main Content -->
    <main
        class="pt-[4rem] transition-all duration-300"
        :class="{
            'lg:ml-[250px]': sidebarVisible && !isMobileDevice,
            'ml-0': !sidebarVisible || isMobileDevice,
        }"
    >
        <!-- Header -->
        <header
            class="fixed top-0 left-0 z-[10000] w-full flex justify-between items-center border-b bg-white px-3 py-4 text-black transition-all dark:border-b-gray-700 dark:bg-gray-900 dark:text-white lg:px-8"
        >
            <!-- Sidebar Toggle Button -->
            <button
                class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700"
                @click="toggleSidebar"
            >
                <FaBarsStaggered />
            </button>
            <ul class="flex items-center gap-4 lg:gap-6">
                <!-- Dark Mode Toggle -->
                <li>
                    <button
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700"
                        @click="toggleDark"
                    >
                        <AkSunFill v-if="isDark" />
                        <AkMoonFill v-else />
                    </button>
                </li>

                <!-- Mail Button -->
                <li>
                    <button
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700"
                    >
                        <FeMail class="text-lg text-[#0f172a]" />
                    </button>
                </li>

                <!-- Notifications Button -->
                <li>
                    <button
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700"
                    >
                        <MdNotificationsNone class="text-xl text-[#0f172a]" />
                    </button>
                </li>

                <!-- User Dropdown -->
                <li>
                    <Dropdown align="right" class="group cursor-pointer" width="48">
                        <template #trigger>
                            <div
                                class="flex items-center rounded-md border border-transparent bg-white px-3 text-black transition duration-150 ease-in-out hover:text-gray-700 dark:bg-gray-900 dark:text-white"
                            >
                                <img
                                    alt="User Avatar"
                                    class="h-8 w-8 rounded-full"
                                    src="https://i.pravatar.cc/300"
                                />
                                <p class="hidden text-sm font-medium lg:block">
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <FaAngleDown class="ms-2 h-4 w-4" />
                            </div>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profile
                            </DropdownLink>
                            <DropdownLink
                                :href="route('admin.logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </li>
            </ul>
        </header>

        <!-- Content Area -->
        <section
            class="relative min-h-screen w-full px-4 py-8 text-black dark:bg-gray-900 dark:text-white lg:px-10"
        >
            <slot />
        </section>
    </main>
</template>
