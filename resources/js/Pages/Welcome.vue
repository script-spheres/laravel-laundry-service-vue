<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { About, Banner, Faq, HeroSection, Review, Service } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import 'swiper/swiper-bundle.css';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { PropType } from 'vue';

defineOptions({ layout: PublicLayout });

defineProps({
    banners: {
        type: Array as PropType<Banner[]>,
        required: true,
    },
    services: {
        type: Array as PropType<Service[]>,
        required: true,
    },
    faqItems: {
        type: Array as PropType<Faq[]>,
        required: true,
    },
    testimonials: {
        type: Array as PropType<Review[]>,
        required: true,
    },
    heroSection: {
        type: Object as PropType<HeroSection>,
        required: true,
    },
    about: {
        type: Object as PropType<About>,
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
    <Head title="Welcome" />

    <div
        class="bg-gradient-to-br from-blue-50 to-gray-50 dark:from-gray-800 dark:to-gray-900"
    >
        <!-- Banner Section -->
        <section>
            <div
                class="container mx-auto flex flex-col items-center gap-12 px-6 md:flex-row"
            >
                <div class="mb-8 md:order-2 md:mb-0 md:w-1/3">
                    <Swiper
                        :space-between="50"
                        :loop="true"
                        :autoplay="{ delay: 3000, disableOnInteraction: false }"
                        class="overflow-hidden rounded-xl shadow-lg"
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
                                    class="h-full w-full rounded-xl object-cover"
                                />
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </div>

                <div class="flex flex-col items-center text-center md:w-2/3">
                    <h1
                        class="animate-fadeIn text-4xl font-bold text-gray-800 dark:text-white md:text-5xl lg:text-6xl"
                    >
                        {{ heroSection.title }}
                    </h1>
                    <p
                        class="animate-slideUp mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-300 md:mt-6 md:text-xl"
                    >
                        {{ heroSection.description }}
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

        <!-- Hero Section -->
        <section class="bg-blue-600 py-20 text-white">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-5xl font-extrabold">{{ heroSection.title }}</h1>
                <p class="mt-6 text-xl">{{ heroSection.description }}</p>
                <Link
                    :href="route('services')"
                    class="mt-10 inline-block rounded-lg bg-white px-8 py-4 font-semibold text-blue-600 hover:bg-gray-200"
                    >View Services</Link
                >
            </div>
        </section>

        <!-- About Us Section -->
        <section class="bg-gray-100 py-20">
            <div
                class="container mx-auto flex flex-col items-center px-4 md:flex-row"
            >
                <div class="md:w-1/2">
                    <h2 class="text-4xl font-bold text-gray-800">
                        {{ about.title }}
                    </h2>
                    <p class="mt-6 text-gray-600">{{ about.description }}</p>
                    <ul class="mt-6 space-y-4">
                        <li
                            v-for="(feature, index) in about.features"
                            :key="index"
                            class="flex items-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mr-3 h-6 w-6 text-blue-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.293-6.293a1 1 0 011.414 0L13 12.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-2-2-1.293 1.293a1 1 0 01-1.414-1.414l2-2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            {{ feature }}
                        </li>
                    </ul>
                </div>
                <div class="mt-10 md:mt-0 md:w-1/2">
                    <img
                        src="https://via.placeholder.com/400x300"
                        alt="Laundry Service"
                        class="rounded-lg shadow-lg"
                    />
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="bg-gray-50 py-20">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold text-gray-800">Our Services</h2>
                <p class="mt-4 text-gray-600">
                    We offer a variety of services tailored to your laundry
                    needs.
                </p>
                <div class="mt-12 grid grid-cols-1 gap-12 md:grid-cols-3">
                    <div
                        v-for="service in services"
                        :key="service.id"
                        class="rounded-lg bg-white p-8 shadow-lg"
                    >
                        <h3 class="text-2xl font-semibold text-blue-600">
                            {{ service.name }}
                        </h3>
                        <p class="mt-4 text-gray-600">
                            {{ service.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="bg-white py-20" v-if="testimonials.length > 0">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold text-gray-800">
                    What Our Customers Say
                </h2>
                <p class="mt-4 text-gray-600">
                    Don't just take our word for it. Here's what our customers
                    think!
                </p>
                <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="testimonial in testimonials"
                        :key="testimonial.id"
                        class="rounded-lg bg-gray-100 p-6 shadow-lg"
                    >
                        <div class="mb-4 flex items-center">
                            <img
                                :src="testimonial.customer.image.url"
                                alt="Avatar"
                                class="h-16 w-16 rounded-full"
                            />
                            <div class="ml-4 text-left">
                                <p class="text-lg font-bold text-gray-800">
                                    {{ testimonial.title }}
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ testimonial.review }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-gray-50 py-20" v-if="faqItems.length > 0">
            <div class="container mx-auto px-4">
                <h2 class="text-center text-4xl font-bold text-gray-800">
                    Frequently Asked Questions
                </h2>
                <p class="mt-4 text-center text-gray-600">
                    Have questions? We've got answers.
                </p>
                <div class="mx-auto mt-12 max-w-3xl space-y-8">
                    <div
                        v-for="(item, index) in faqItems"
                        :key="index"
                        class="rounded-lg bg-white p-4 shadow-md"
                    >
                        <h3 class="text-xl font-bold text-blue-600">
                            {{ item.question }}
                        </h3>
                        <p class="mt-2 text-gray-600">{{ item.answer }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
