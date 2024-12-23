<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Banner, Service } from '@/types';
import 'swiper/swiper-bundle.css';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { PropType } from 'vue';

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
</script>

<template>
    <Head title="Welcome to SparkleClean Laundry" />

    <div class="bg-gradient-to-br from-blue-50 to-gray-50 dark:from-gray-800 dark:to-gray-900">
        <section>
            <div class="container mx-auto flex flex-col gap-12 px-6 md:flex-row items-center">
                <!-- Carousel Section -->
                <div class="mb-8 md:order-2 md:mb-0 md:w-1/3">
                    <!-- Swiper for Banners -->
                    <Swiper
                        :space-between="50"
                        :loop="true"
                        :autoplay="{ delay: 3000, disableOnInteraction: false }"
                        class="rounded-xl shadow-lg overflow-hidden"
                    >
                        <SwiperSlide
                            v-for="banner in banners"
                            :key="banner.image.url"
                        >
                            <div class="relative h-64 sm:h-80 md:h-[500px] lg:h-[600px]">
                                <img
                                    :alt="banner.image.filename"
                                    :src="banner.image.url"
                                    class="h-full w-full rounded-xl object-cover"
                                />
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </div>

                <!-- Text and Service Types Section -->
                <div class="flex flex-col items-center text-center md:w-2/3">
                    <h1 class="animate-fadeIn text-4xl font-bold text-gray-800 dark:text-white md:text-5xl lg:text-6xl">
                        SparkleClean Laundry Services
                    </h1>
                    <p class="animate-slideUp mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-300 md:mt-6 md:text-xl">
                        Professional, fast, and reliable laundry services to make your life easier. Your clothes deserve the best care!
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
                                    <div class="absolute bottom-0 w-full bg-gradient-to-t from-black via-gray-800/70 to-transparent p-4">
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

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-extrabold">Professional Laundry Services</h1>
            <p class="mt-6 text-xl">Clean clothes, hassle-free service. Experience the best laundry care today!</p>
            <a href="#services" class="mt-10 inline-block bg-white text-blue-600 font-semibold py-4 px-8 rounded-lg hover:bg-gray-200">View Services</a>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-gray-800">Our Services</h2>
            <p class="text-gray-600 mt-4">We offer a variety of services tailored to your laundry needs.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-12">
                <div class="bg-white p-8 shadow-lg rounded-lg">
                    <h3 class="text-2xl font-semibold text-blue-600">Wash & Fold</h3>
                    <p class="text-gray-600 mt-4">Convenient and efficient service for everyday laundry needs.</p>
                </div>

                <div class="bg-white p-8 shadow-lg rounded-lg">
                    <h3 class="text-2xl font-semibold text-blue-600">Dry Cleaning</h3>
                    <p class="text-gray-600 mt-4">Professional care for your delicate garments.</p>
                </div>

                <div class="bg-white p-8 shadow-lg rounded-lg">
                    <h3 class="text-2xl font-semibold text-blue-600">Pickup & Delivery</h3>
                    <p class="text-gray-600 mt-4">Laundry care at your doorstep for maximum convenience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
                <h2 class="text-4xl font-bold text-gray-800">Why Choose Us?</h2>
                <p class="text-gray-600 mt-6">With years of experience, our team provides the best laundry services with a focus on quality and customer satisfaction. Your clothes are in safe hands!</p>
                <ul class="mt-6 space-y-4">
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.293-6.293a1 1 0 011.414 0L13 12.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-2-2-1.293 1.293a1 1 0 01-1.414-1.414l2-2z" clip-rule="evenodd" />
                        </svg>
                        Affordable Pricing
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.293-6.293a1 1 0 011.414 0L13 12.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-2-2-1.293 1.293a1 1 0 01-1.414-1.414l2-2z" clip-rule="evenodd" />
                        </svg>
                        Reliable Service
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.293-6.293a1 1 0 011.414 0L13 12.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-2-2-1.293 1.293a1 1 0 01-1.414-1.414l2-2z" clip-rule="evenodd" />
                        </svg>
                        Eco-Friendly Practices
                    </li>
                </ul>
            </div>

            <div class="md:w-1/2 mt-10 md:mt-0">
                <img src="https://via.placeholder.com/400x300" alt="Laundry Service" class="rounded-lg shadow-lg">
            </div>
        </div>
    </section>
</template>
