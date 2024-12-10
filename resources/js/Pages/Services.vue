<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useCartStore } from '@/Stores/CartStore';
import { Banner, ServiceType } from '@/types';
import { Head,Link } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineOptions({ layout: PublicLayout });

defineProps({
    serviceItems: {
        type: Array as PropType<Banner[]>,
        required: true,
    },
    serviceTypes: {
        type: Array as PropType<ServiceType[]>,
        required: true,
    },
});

// Cart store
const cartStore = useCartStore();
const addToCart = (item: Banner) => {
    cartStore.addItem(item);
};
</script>

<template>
    <Head title="Laundry Services" />

    <section class="container mx-auto p-6">
        <!-- Title Section -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                Laundry Services
            </h1>
            <p class="mt-2 text-xl text-gray-600 dark:text-gray-300">
                Browse and choose your services
            </p>
        </div>

        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Sidebar: Service Categories (Visible on large screens) -->
            <div class="hidden md:block md:w-1/4">
                <h2
                    class="mb-6 text-3xl font-semibold text-blue-600 dark:text-blue-400"
                >
                    Our Services
                </h2>
                <div class="space-y-6">
                    <div
                        v-for="serviceType in serviceTypes"
                        :key="serviceType.id"
                        class="rounded-lg bg-gradient-to-r from-blue-100 to-blue-300 p-6 shadow-md dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-800"
                    >
                        <Link
                            :href="route('services', serviceTypes.id)"
                            class="text-2xl font-semibold text-blue-800 dark:text-white"
                            >{{ serviceType.name }}</Link
                        >
                    </div>
                </div>
            </div>

            <!-- Main Content: Service Items -->
            <div class="md:w-3/4">
                <h2
                    class="mb-6 text-3xl font-semibold text-blue-600 dark:text-blue-400"
                >
                    Available Services
                </h2>
                <div
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="serviceItem in serviceItems"
                        :key="serviceItem.id"
                        class="group relative overflow-hidden rounded-xl bg-white shadow-lg transition-all hover:scale-105 dark:bg-gray-800 dark:shadow-gray-600"
                    >
                        <!-- Service Image -->
                        <div class="h-48 bg-gray-200 dark:bg-gray-700">
                            <img
                                v-if="serviceItem.image"
                                :src="serviceItem.image"
                                alt="Service Image"
                                class="h-full w-full object-cover"
                            />
                        </div>

                        <!-- Service Details -->
                        <div class="space-y-4 p-6">
                            <h3
                                class="text-xl font-semibold text-gray-800 dark:text-white"
                            >
                                {{ serviceItem.title }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-300">
                                {{ serviceItem.description }}
                            </p>
                            <p
                                class="font-semibold text-blue-600 dark:text-blue-400"
                            >
                                ${{ serviceItem.price }}
                            </p>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <button
                                @click="addToCart(serviceItem)"
                                class="w-full rounded-full bg-blue-600 px-4 py-3 text-lg font-semibold text-white shadow-md transition-all hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-700"
                            >
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
