<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

import { useCartStore } from '@/Stores/CartStore';

// Components
import Dropdown from '@/Components/Dropdown/Dropdown.vue';
import DropdownLink from '@/Components/Dropdown/DropdownLink.vue';
import NavbarLink from '@/Components/Navigation/NavbarLink.vue';

// Icons
import DarkModeButton from '@/Components/Buttons/DarkModeButton.vue';
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import useMenu from '@/Composables/useMenu';
import {
    AnOutlinedShoppingCart,
    BsChevronDown,
    FaBars,
} from '@kalimahapps/vue-icons';

// Cart store
const cartStore = useCartStore();
const cartItemCount = computed(() => cartStore.totalItems);

// Menu state
const { isMenuOpen, toggleMenu } = useMenu();
</script>

<template>
    <nav
        class="sticky top-0 z-20 w-full border-b bg-white shadow-md transition-colors duration-300 dark:border-gray-600 dark:bg-gray-900"
    >
        <div class="container mx-auto flex items-center justify-between p-3">
            <!-- Left: Logo & Mobile Menu Button -->
            <div class="flex items-center gap-2">
                <button
                    @click="toggleMenu"
                    class="p-2 text-gray-500 focus:ring-2 dark:text-gray-400 dark:hover:bg-gray-700 md:hidden"
                >
                    <FaBars />
                </button>
                <Link
                    :href="route('welcome')"
                    class="flex items-center space-x-3 rtl:space-x-reverse"
                >
                    <img :src="$page.props.app.image" alt="Logo" class="h-8" />
                    <span class="text-2xl font-semibold dark:text-white">
                        {{ $page.props.app.name }}
                    </span>
                </Link>

                <!-- Desktop Menu -->
                <ul class="hidden gap-4 md:flex">
                    <li><NavbarLink :href="route('welcome')" label="Home" /></li>
                    <li><NavbarLink :href="route('about')" label="About" /></li>
                    <li><NavbarLink :href="route('services')" label="Services" /></li>
                    <li><NavbarLink :href="route('contact')" label="Contact" /></li>
                </ul>
            </div>

            <!-- Right: Dark Mode, Cart, Profile Dropdown -->
            <div class="flex items-center space-x-3">
                <DarkModeButton class="h-10 w-10" />
                <Link
                    :href="route('cart')"
                    class="relative rounded-full bg-gray-200 p-2 text-gray-500 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600"
                >
                    <span
                        class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white"
                    >
                        {{ cartItemCount }}
                    </span>
                    <AnOutlinedShoppingCart class="h-5 w-5" />
                </Link>

                <!-- Profile Dropdown -->
                <Dropdown align="right" v-if="$page.props.auth.user">
                    <template #trigger>
                        <button
                            class="flex items-center space-x-2 rounded-full bg-gray-200 p-1 text-gray-500 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600"
                        >
                            <img
                                src="https://i.pravatar.cc/300"
                                alt="User Avatar"
                                class="h-8 w-8 rounded-full"
                            />
                            <BsChevronDown class="h-4 w-4" />
                        </button>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('profile.edit')">
                            Profile
                        </DropdownLink>
                        <DropdownLink
                            :href="route('logout')"
                            as="button"
                            method="post"
                        >
                            Log Out
                        </DropdownLink>
                    </template>
                </Dropdown>

                <!-- Authentication Links -->
                <div v-else class="flex items-center space-x-3">
                    <LinkButton :href="route('login')">Log in</LinkButton>
                    <LinkButton :href="route('register')">Register</LinkButton>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <Transition name="fade">
            <div
                v-if="isMenuOpen"
                class="border-t p-4 dark:bg-gray-900 md:hidden"
            >
                <ul class="space-y-4">
                    <li><NavbarLink :href="route('welcome')" label="Home" /></li>
                    <li><NavbarLink :href="route('about')" label="About" /></li>
                    <li><NavbarLink :href="route('services')" label="Services" /></li>
                    <li><NavbarLink :href="route('contact')" label="Contact" /></li>
                </ul>
            </div>
        </Transition>
    </nav>
</template>
