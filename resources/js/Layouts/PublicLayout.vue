<script setup lang="ts">
import DarkModeButton from '@/Components/Buttons/DarkModeButton.vue';
import FooterCopyright from '@/Components/Footer/FooterCopyright.vue';
import FooterLinkGroup from '@/Components/Footer/FooterLinkGroup.vue';
import NavbarLink from '@/Components/Navigation/NavbarLink.vue';
import { useMenu } from '@/Composables/useMenu';
import { Link } from '@inertiajs/vue3';
import { FaBars } from '@kalimahapps/vue-icons';

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
                    <li>
                        <NavbarLink :href="route('welcome')" label="Home" />
                    </li>
                    <li><NavbarLink :href="route('about')" label="About" /></li>
                    <li>
                        <NavbarLink
                            :href="route('services')"
                            label="Services"
                        />
                    </li>
                    <li>
                        <NavbarLink :href="route('contact')" label="Contact" />
                    </li>
                </ul>
            </div>

            <!-- Right: Dark Mode, Cart, Profile Dropdown -->
            <div class="flex items-center space-x-3">
                <DarkModeButton class="h-10 w-10" />
            </div>
        </div>

        <!-- Mobile Menu -->
        <Transition name="fade">
            <div
                v-if="isMenuOpen"
                class="border-t p-4 dark:bg-gray-900 md:hidden"
            >
                <ul class="space-y-4">
                    <li>
                        <NavbarLink :href="route('welcome')" label="Home" />
                    </li>
                    <li><NavbarLink :href="route('about')" label="About" /></li>
                    <li>
                        <NavbarLink
                            :href="route('services')"
                            label="Services"
                        />
                    </li>
                    <li>
                        <NavbarLink :href="route('contact')" label="Contact" />
                    </li>
                </ul>
            </div>
        </Transition>
    </nav>
    <div class="min-h-screen">
        <slot />
    </div>

    <footer class="bg-gray-900">
        <div class="container mx-auto w-full p-4 py-6 lg:py-8">
            <FooterLinkGroup />
            <hr
                class="my-6 border-gray-200 dark:border-gray-700 sm:mx-auto lg:my-8"
            />
            <FooterCopyright />
        </div>
    </footer>
</template>
