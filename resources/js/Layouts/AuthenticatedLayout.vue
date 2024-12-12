<script setup lang="ts">
import DarkModeButton from '@/Components/Buttons/DarkModeButton.vue';
import Dropdown from '@/Components/Dropdown/Dropdown.vue';
import DropdownLink from '@/Components/Dropdown/DropdownLink.vue';
import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
import SidebarLogo from '@/Components/Sidebar/SidebarLogo.vue';
import { useMenu } from '@/Composables/useMenu';
import {
    FaAngleDown,
    FaBarsStaggered,
    MdNotificationsNone,
} from '@kalimahapps/vue-icons';

const { isMenuOpen, toggleMenu } = useMenu(true);
</script>

<template>
    <!-- Sidebar Overlay for Mobile -->
    <div
        class="fixed left-0 top-0 z-40 h-full w-full bg-teal-950 bg-opacity-60 transition-opacity duration-300 lg:hidden"
        v-show="isMenuOpen"
        @click="toggleMenu()"
    ></div>

    <!-- Sidebar -->
    <aside
        ref="sidebarRef"
        class="fixed z-50 h-screen w-72 flex-none border-r bg-white transition-transform duration-300 dark:border-r-gray-700 dark:bg-gray-900"
        :class="{
            '-translate-x-full': !isMenuOpen,
        }"
    >
        <div class="flex flex-col">
            <SidebarLogo @close-sidebar="toggleMenu()" />
        </div>
        <nav
            class="h-[calc(100vh-65px)] flex-auto overflow-y-auto p-4 scrollbar-thin"
        >
            <ul class="space-y-1">
                <SidebarItem
                    v-for="(item, index) in $page.props.navigations"
                    :key="index"
                    :item="item"
                />
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main
        class="flex min-h-screen grow flex-col transition-[margin-left] duration-300"
        :class="{
            'lg:ml-72': isMenuOpen,
            'lg:ml-0': !isMenuOpen,
        }"
    >
        <!-- Header -->
        <header
            class="sticky top-0 z-30 h-[65px] flex-none border-b border-gray-200 bg-white px-4 dark:border-gray-700 dark:bg-gray-900 dark:text-white xl:px-6"
        >
            <div class="flex h-16 items-center justify-between">
                <button
                    class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700"
                    @click="toggleMenu()"
                >
                    <FaBarsStaggered />
                </button>
                <ul class="flex items-center gap-4 lg:gap-6">
                    <!-- Dark Mode Toggle -->
                    <li>
                        <DarkModeButton class="h-8 w-8" />
                    </li>

                    <!-- Notifications Button -->
                    <li>
                        <button
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700"
                        >
                            <MdNotificationsNone
                                class="text-xl text-[#0f172a]"
                            />
                        </button>
                    </li>

                    <!-- User Dropdown -->
                    <li>
                        <Dropdown
                            align="right"
                            class="group cursor-pointer"
                            width="48"
                        >
                            <template #trigger>
                                <div
                                    class="flex items-center rounded-md border border-transparent bg-white px-3 text-black transition duration-150 ease-in-out hover:text-gray-700 dark:bg-gray-900 dark:text-white"
                                >
                                    <img
                                        alt="User Avatar"
                                        class="h-8 w-8 rounded-full"
                                        src="https://i.pravatar.cc/300"
                                    />
                                    <p
                                        class="hidden text-sm font-medium lg:block"
                                    >
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
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Content Area -->
        <section
            class="relative w-full px-4 py-8 text-black dark:bg-gray-900 dark:text-white lg:px-10"
        >
            <slot />
        </section>
    </main>
</template>
