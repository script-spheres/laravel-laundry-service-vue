<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Banner, ServiceType } from '@/types';
import { Head } from '@inertiajs/vue3';
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
    <Head title="Welcome" />
</template>
