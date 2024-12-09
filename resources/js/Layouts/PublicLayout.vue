<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import Dropdown from '@/Components/Dropdown/Dropdown.vue';
import DropdownLink from '@/Components/Dropdown/DropdownLink.vue';
import FooterCopyright from '@/Components/Footer/FooterCopyright.vue';
import FooterLinkGroup from '@/Components/Footer/FooterLinkGroup.vue';
import NavbarLink from '@/Components/Navigation/NavbarLink.vue';
import NavbarLogo from '@/Components/Navigation/NavbarLogo.vue';
import { useDarkMode } from '@/Composables/useDarkMode';
import { useCartStore } from '@/Stores/CartStore';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Modal, ModalLink } from '@inertiaui/modal-vue'

import {
    AkMoonFill,
    AkSunFill,
    AnOutlinedShoppingCart,
    BsChevronDown,
} from '@kalimahapps/vue-icons';

const toggleMenu = () => {
    const menu = document.getElementById('navbar-sticky');
    if (menu) {
        menu.classList.toggle('hidden');
    }
};

// Dark mode handling
const { isDark, toggleDark } = useDarkMode();

const cartStore = useCartStore();
const cartItemCount = computed(() => cartStore.totalItems);
</script>

<template>
    <nav
        class="sticky top-0 z-20 w-full border-b border-gray-200 bg-white dark:border-gray-600 dark:bg-gray-900"
    >
        <div class="container mx-auto flex items-center justify-between p-4">
            <!-- Navbar Logo -->
            <NavbarLogo />

            <!-- Navigation Links -->
            <div class="hidden w-full items-center md:flex md:w-auto">
                <ul
                    class="flex space-x-8 border-t bg-gray-50 font-medium dark:border-gray-700 dark:bg-gray-800 md:border-0 md:bg-white"
                >
                    <NavbarLink :href="route('welcome')" label="Home" />
                    <NavbarLink :href="route('about')" label="About" />
                    <NavbarLink :href="route('services')" label="Services" />
                    <NavbarLink :href="route('contact')" label="Contact" />
                </ul>

                <div class="flex items-center space-x-4">

                    <div class="flex flex-1 justify-end">
                        <LinkButton
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                        >
                            Dashboard
                        </LinkButton>

                        <template v-else>
                            <ModalLink :href="route('login')"> Log in </ModalLink>

                            <ModalLink :href="route('register')">
                                Register
                            </ModalLink>
                        </template>
                    </div>
                    <div class="flex items-center space-x-3 md:order-2">
                        <!-- Mobile menu toggle button -->
                        <button
                            @click="toggleMenu"
                            class="rounded-lg p-2 text-gray-500 focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 md:hidden"
                        >
                            <span class="sr-only">Open main menu</span>
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 17 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 1h15M1 7h15M1 13h15"
                                />
                            </svg>
                        </button>
                    </div>
                    <button
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-800 text-lg text-gray-500 dark:bg-gray-700"
                        @click="toggleDark()"
                    >
                        <AkSunFill v-if="isDark" />
                        <AkMoonFill v-else />
                    </button>
                    <Link
                        :href="route('cart')"
                        class="relative flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-green-500 dark:bg-gray-700"
                    >
                        <span
                            class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white"
                        >
                            {{ cartItemCount }}
                        </span>
                        <span class="sr-only">View Cart</span>
                        <AnOutlinedShoppingCart class="h-6 w-6" />
                    </Link>

                    <!-- profile dropdown -->
                    <Dropdown
                        v-if="$page.props.auth.user"
                        align="right"
                        width="48"
                    >
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:hover:text-gray-300"
                                    type="button"
                                >
                                    <img
                                        alt=""
                                        class="h-8 w-8 rounded-full"
                                        src="https://i.pravatar.cc/300"
                                    />
                                    <BsChevronDown
                                        class="-me-0.5 ms-2 h-4 w-4"
                                    />
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink
                                :href="route('customer.profile.edit')"
                            >
                                Profile
                            </DropdownLink>
                            <DropdownLink :href="route('customer.order.index')">
                                Order
                            </DropdownLink>
                            <DropdownLink
                                :href="route('customer.reservation.index')"
                            >
                                Reservation
                            </DropdownLink>
                            <DropdownLink
                                :href="route('customer.logout')"
                                as="button"
                                method="post"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
    </nav>

    <slot />

    <footer class="bg-white dark:bg-gray-900">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
                <!-- Footer Logo and Info -->
                <div class="mb-6 md:mb-0">
                    <a href="https://flowbite.com/" class="flex items-center">
                        <img
                            src="https://flowbite.com/docs/images/logo.svg"
                            class="me-3 h-8"
                            alt="FlowBite Logo"
                        />
                        <span
                            class="self-center whitespace-nowrap text-2xl font-semibold dark:text-white"
                            >Flowbite</span
                        >
                    </a>
                </div>

                <!-- Footer Links Groups -->
                <FooterLinkGroup />
            </div>

            <hr
                class="my-6 border-gray-200 dark:border-gray-700 sm:mx-auto lg:my-8"
            />
            <FooterCopyright />
        </div>
    </footer>
</template>
