<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Banner, Service } from '@/types';
import 'swiper/swiper-bundle.css';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { PropType } from 'vue';
import { GoogleMap, Marker } from 'vue3-google-map';

defineOptions({ layout: PublicLayout });
defineProps({
    banners: {
        type: Object as PropType<Banner[]>,
        required: true,
    },
    services: {
        type: Object as PropType<Service[]>,
        required: true,
    },
});

const categoryConfig = {
    slidesPerView: 6,
    spaceBetween: 10,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
        },
        640: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        1024: {
            slidesPerView: 4,
        },
        1280: {
            slidesPerView: 6,
        },
    },
};
const center = { lat: 40.689247, lng: -74.044502 };
const apiKey = import.meta.env.VITE_GOOGLE_MAP_API_KEY;
</script>

<template>
    <Head title="Welcome to SparkleClean Laundry" />

    <div
        class="bg-gradient-to-br from-blue-100 to-gray-100 dark:from-gray-800 dark:to-gray-900"
    >
        <section>
            <div class="container mx-auto flex flex-col gap-6 px-6 md:flex-row">
                <!-- Carousel Section -->
                <div class="mb-8 md:order-2 md:mb-0 md:w-1/3">
                    <!-- Swiper for Banners -->
                    <Swiper
                        :space-between="50"
                        :loop="true"
                        :autoplay="{ delay: 3000, disableOnInteraction: false }"
                        class="rounded-lg shadow-2xl"
                    >
                        <SwiperSlide
                            v-for="banner in banners"
                            :key="banner.image.url"
                        >
                            <div
                                class="relative h-64 sm:h-80 md:h-[500px] lg:h-[600px]"
                            >
                                <img
                                    :alt="banner.image.filename"
                                    :src="banner.image.url"
                                    class="h-full w-full rounded-lg object-cover"
                                />
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </div>

                <!-- Text and Service Types Section -->
                <div class="flex flex-col items-center text-center md:w-2/3">
                    <h1
                        class="animate-fadeIn text-3xl font-extrabold text-gray-800 dark:text-white md:text-5xl lg:text-6xl"
                    >
                        SparkleClean Laundry Services
                    </h1>
                    <p
                        class="animate-slideUp mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-300 md:mt-6 md:text-xl"
                    >
                        Professional, fast, and reliable laundry services to
                        make your life easier. Your clothes deserve the best
                        care!
                    </p>

                    <!-- Service Types Carousel -->
                    <Swiper
                        :space-between="10"
                        :loop="true"
                        :autoplay="{ delay: 3000, disableOnInteraction: false }"
                        :slides-per-view="categoryConfig.slidesPerView"
                        :breakpoints="categoryConfig.breakpoints"
                        navigation
                        :pagination="{ clickable: true }"
                        class="mt-8 w-full flex-none self-end"
                    >
                        <SwiperSlide
                            v-for="service in services"
                            :key="service.id"
                        >
                            <div
                                class="group relative h-64 rounded-lg bg-white shadow-md transition-transform hover:scale-105 hover:shadow-2xl dark:bg-gray-700"
                            >
                                <img
                                    :alt="service.image.basename"
                                    :src="service.image.url"
                                    class="h-full w-full object-cover"
                                />
                                <Link
                                    :href="route('services')"
                                    class="absolute inset-0"
                                >
                                    <div
                                        class="absolute bottom-0 w-full bg-gradient-to-t from-black via-gray-800/70 to-transparent p-4"
                                    >
                                        <p class="text-xl font-bold text-white">
                                            {{ service.name }}
                                        </p>
                                    </div>
                                </Link>
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </div>
            </div>
        </section>
    </div>

    <!-- Google Map Section -->
    <div class="mt-16">
        <GoogleMap
            :api-key="apiKey"
            style="width: 100%; height: 500px"
            :center="center"
            :zoom="15"
        >
            <Marker :options="{ position: center }" />
        </GoogleMap>
    </div>
</template>
