<script setup lang="ts">
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Order, PaginatedData } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed, PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    todayDelivery: {
        type: Object as PropType<PaginatedData<Order>>,
        required: true,
    },
    filters: {
        type: Object as PropType<Filters>,
        default: () => ({}),
    },
    orderStatusCounts: {
        type: Array as PropType<Array<{ label: string; value: number }>>,
        required: true,
    },
});

// Extract the labels and values from the orderStatusCounts array
const chartLabels = computed(() =>
    props.orderStatusCounts.map((item) => item.label),
);
const chartSeries = computed(() =>
    props.orderStatusCounts.map((item) => item.value),
);

// Today’s Delivery Count
const todayDeliveryCount = computed(() => {
    return props.todayDelivery.data ? props.todayDelivery.data.length : 0;
});

const chartOptions = {
    chart: { type: 'pie', toolbar: { show: true }, height: 600 },
    labels: chartLabels.value,
    colors: ['#8392ab', '#faae42', '#2dce89', '#0083ff'],
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: { height: 400 },
                legend: { position: 'bottom' },
            },
        },
        {
            breakpoint: 480,
            options: {
                chart: { height: 300 },
                legend: { position: 'bottom' },
            },
        },
    ],
};
</script>

<template>
    <Head title="Dashboard" />

    <!-- Order Summary Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div
            v-for="(status, index) in chartLabels"
            :key="status"
            class="rounded bg-gray-100 p-4 text-center shadow"
        >
            <p class="text-gray-500">{{ status }} Orders</p>
            <h6 class="text-2xl font-bold">{{ chartSeries[index] }}</h6>
        </div>
    </div>

    <!-- Filter and Card Grid -->
    <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
        <Card class="p-4 lg:col-span-2">
            <div class="flex flex-col gap-4 md:flex-row md:justify-between">
                <h6 class="text-lg font-bold">
                    Today's Delivery: {{ todayDeliveryCount }}
                </h6>
            </div>

            <div
                class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3"
            >
                <div
                    v-for="order in props.todayDelivery.data"
                    :key="order.order_uuid"
                    class="rounded bg-gray-50 p-4 shadow"
                >
                    <p class="font-bold">{{ order.order_display_id }}</p>
                    <p class="text-gray-500">
                        <span class="font-bold">Customer: </span>
                        {{ order?.customer?.name }}
                    </p>
                    <p class="text-gray-500">
                        <span class="font-bold">Order Date:</span>
                        {{ order.created_at }}
                    </p>
                </div>
            </div>
        </Card>

        <Card class="p-4">
            <div>
                <h6 class="mb-4 text-lg font-bold">Today Order Overview:</h6>
                <apexchart :options="chartOptions" :series="chartSeries" />
            </div>
        </Card>
    </div>
</template>
