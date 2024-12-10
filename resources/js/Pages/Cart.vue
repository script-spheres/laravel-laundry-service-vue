<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Banner, ServiceType } from '@/types';
import { Head } from '@inertiajs/vue3';
import 'swiper/swiper-bundle.css';
import { PropType } from 'vue';

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
</script>

<template>
    <Head title="Welcome to SparkleClean Laundry" />
    <div class="container mx-auto">kk</div>
</template>
