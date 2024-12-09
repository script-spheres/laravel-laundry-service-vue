<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Banner, ServiceType } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { PropType } from 'vue';
import { Carousel, Navigation, Slide } from 'vue3-carousel';
import { GoogleMap, Marker } from 'vue3-google-map';

defineOptions({ layout: PublicLayout });

defineProps({
    banners: {
        type: Object as PropType<Banner[]>,
        required: true,
    },
    serviceTypes: {
        type: Object as PropType<ServiceType[]>,
        required: true,
    },
});

const categoryConfig = {
    itemsToShow: 6,
    itemsToScroll: 1,
    wrapAround: true,
    transition: 500,
};
const center = { lat: 40.689247, lng: -74.044502 };
const apiKey = import.meta.env.VITE_GOOGLE_MAP_API_KEY;

</script>

<template>
    <Head title="Welcome to SparkleClean Laundry" />

    <!-- Hero Section -->
    <section
        class="bg-gradient-to-br from-blue-100 to-gray-100 dark:from-gray-800 dark:to-gray-900"
    >
        <div class="container mx-auto flex flex-row gap-6 py-20">
            <!-- Services Carousel -->
            <div class="flex w-3/4 flex-col items-center px-6 text-center">
                <h1
                    class="animate-fadeIn text-4xl font-extrabold text-gray-800 dark:text-white md:text-6xl"
                >
                    SparkleClean Laundry Services
                </h1>
                <p
                    class="animate-slideUp mt-4 max-w-3xl text-lg text-gray-600 dark:text-gray-300 md:mt-6"
                >
                    Professional, fast, and reliable laundry services to make
                    your life easier. Your clothes deserve the best care!
                </p>
                <Carousel
                    v-bind="categoryConfig"
                    class="mt-8 w-full flex-none self-end"
                >
                    <Slide
                        v-for="serviceType in serviceTypes"
                        :key="serviceType.id"
                    >
                        <div
                            class="group relative h-64 rounded-lg bg-white shadow-md transition-transform hover:scale-105 hover:shadow-2xl dark:bg-gray-700"
                        >
                            <img
                                :alt="serviceType.image.basename"
                                :src="serviceType.image.url"
                                class="h-full w-full object-cover"
                            />
                            <Link
                                :href="route('services')"
                                class="absolute inset-0"
                            >
                                <div
                                    class="absolute bottom-0 w-full bg-gradient-to-t from-black via-gray-800/70 to-transparent p-4"
                                >
                                    <p class="text-2xl font-bold text-white">
                                        {{ serviceType.name }}
                                    </p>
                                </div>
                            </Link>
                        </div>
                    </Slide>
                    <template #addons>
                        <Navigation />
                    </template>
                </Carousel>
            </div>

            <!-- Banner Carousel -->
            <div class="w-1/4">
                <Carousel class="rounded-lg shadow-2xl">
                    <Slide v-for="banner in banners" :key="banner.image.url">
                        <div class="relative h-64 sm:h-80 md:h-[500px]">
                            <img
                                :alt="banner.image.filename"
                                :src="banner.image.url"
                                class="h-full w-full rounded-lg object-cover"
                            />
                        </div>
                    </Slide>
                </Carousel>
            </div>
        </div>
    </section>

    <!-- Google Map Section -->
<!--    <div class="">-->
<!--        <GoogleMap-->
<!--            :api-key="apiKey"-->
<!--            style="width: 100%; height: 500px"-->
<!--            :center="center"-->
<!--            :zoom="15"-->
<!--        >-->
<!--            <Marker :options="{ position: center }" />-->
<!--        </GoogleMap>-->
<!--    </div>-->
</template>
