<script setup lang="ts">
import Badge from '@/Components/Badges/Badge.vue';
import Datalist from '@/Components/DataList/Datalist.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Banner, Category, Service } from '@/types';
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineOptions({ layout: PublicLayout });

const props = defineProps({
    citiesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    storesOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    serviceItems: {
        type: Array as PropType<Banner[]>,
        required: true,
    },
    categories: {
        type: Array as PropType<Category[]>,
        required: true,
    },
    services: {
        type: Array as PropType<Service[]>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        required: false,
        default: () => ({}),
    },
});

const { filter } = useFilters('services', {
    city_id: props.filters?.city_id ?? '',
    category_id: props.filters?.category_id ?? '',
    service_id: props.filters?.service_id ?? '',
    store_id: props.filters?.store_id ?? '',
});

const handleServiceClick = (serviceId: any) => {
    filter.service_id = filter.service_id === serviceId ? '' : serviceId;
};
</script>

<template>
    <Head title="Laundry Services" />

    <!-- Main Section -->
    <section class="container mx-auto px-4 py-6 md:px-0">
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                Laundry Services
            </h1>
            <p class="mt-2 text-xl text-gray-600 dark:text-gray-300">
                Browse and choose your services
            </p>
        </div>

        <!-- Filter Section -->
        <Card class="mb-6 rounded-xl bg-white p-6 shadow-lg">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <InputSelect
                        label="City"
                        v-model="filter.city_id"
                        :options="citiesOptions"
                        placeholder="Filter by City"
                        class="w-full rounded-md border p-2"
                    />
                </div>
                <div>
                    <InputSelect
                        label="Store"
                        v-model="filter.store_id"
                        :options="storesOptions"
                        placeholder="Filter by Store"
                        class="w-full rounded-md border p-2"
                    />
                </div>
            </div>
        </Card>

        <!-- Main Content Section with Grid Layout -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <!-- Sidebar: Service Categories (Visible on large screens) -->
            <div class="md:col-span-1 md:block">
                <div
                    class="sticky top-20 rounded-lg border bg-white p-4 shadow-md"
                >
                    <h2
                        class="mb-6 text-3xl font-semibold text-blue-600 dark:text-blue-400"
                    >
                        Our Services
                    </h2>
                    <ul class="divide-y">
                        <li
                            v-for="service in services"
                            :key="service.id"
                            class="flex items-center gap-x-4 rounded-lg py-4 hover:bg-gray-100"
                        >
                            <img
                                :src="service.image.url"
                                class="h-16 w-16 rounded-full object-cover"
                                alt="Service Image"
                            />
                            <button
                                @click="handleServiceClick(service.id)"
                                class="text-xl font-semibold text-gray-800 hover:text-blue-600 dark:text-white"
                            >
                                {{ service.name }}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content: Service Items -->
            <div class="md:col-span-3">
                <div class="mb-6 flex gap-4 overflow-x-auto py-4">
                    <!-- Category Header -->
                    <div
                        v-for="category in categories"
                        :key="category.id"
                        class="flex cursor-pointer items-center gap-2 rounded-lg p-4 shadow-md transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl"
                    >
                        <img
                            v-if="category.image"
                            :src="category.image.url"
                            alt="Category Image"
                            class="h-16 w-16 rounded-full border-4 border-white object-cover shadow-md transition-all duration-200 ease-in-out hover:scale-110"
                        />
                        <p
                            class="mt-2 text-center text-lg font-semibold text-gray-900 transition-all duration-200 ease-in-out hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                        >
                            {{ category.name }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <Datalist
                        v-for="serviceItem in serviceItems"
                        :key="serviceItem.id"
                    >
                        <template #content>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <ImagePreview
                                    class="md:h-32 md:w-32"
                                    :src="serviceItem.image?.url"
                                />
                                <div class="flex flex-col justify-between">
                                    <strong
                                        class="text-xl font-semibold text-gray-800 dark:text-white"
                                    >
                                        {{ serviceItem.title }}
                                        <Badge>{{ serviceItem.status }}</Badge>
                                    </strong>
                                    <p
                                        class="mt-2 text-gray-600 dark:text-gray-400"
                                    >
                                        {{ serviceItem.description }}
                                    </p>
                                </div>
                            </div>
                        </template>
                    </Datalist>
                </div>
            </div>
        </div>
    </section>
</template>
