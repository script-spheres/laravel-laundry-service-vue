<script setup lang="ts">
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import { useFilters } from '@/Composables/useFilters';
import { orderStatusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Order } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ArcElement, Chart as ChartJS, Legend, Tooltip } from 'chart.js';
import { onUnmounted, PropType, ref } from 'vue';

// Props Definition
const props = defineProps({
    orders: {
        type: Array as PropType<Order[]>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

// Filters Reactive State
const { filter } = useFilters('admin.orders.index', {
    search_query: props.filters?.search_query || '',
    order_filter: props.filters?.order_filter || '',
});

// Register Chart.js components
ChartJS.register(ArcElement, Tooltip, Legend);

// Define data for the chart
const chartData = ref([513, 223, 486, 159, 19]);

// Chart.js configuration
const chartConfig = ref<Chart.ChartConfiguration>({
    type: 'doughnut',
    data: {
        labels: [
            'Pending',
            'Processing',
            'Ready To Deliver',
            'Delivered',
            'Returned',
        ],
        datasets: [
            {
                label: 'Orders',
                data: chartData.value,
                backgroundColor: [
                    '#8392ab', // Pending
                    '#faae42', // Processing
                    '#2dce89', // Ready To Deliver
                    '#0083ff', // Delivered
                    '#f5365c', // Returned
                ],
                borderColor: '#fff',
                borderWidth: 1,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
        },
    },
});

// Reference to the chart instance
let chartInstance: ChartJS | null = null;

// Initialize the Chart.js instance
const initChart = (canvas: HTMLCanvasElement) => {
    if (chartInstance) chartInstance.destroy(); // Destroy previous instance if it exists
    chartInstance = new ChartJS(canvas, chartConfig.value);
};

// Hook to destroy chart on unmount
onUnmounted(() => {
    if (chartInstance) chartInstance.destroy();
});
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Dashboard" />

    <div class="grid gap-4 lg:grid-cols-2 2xl:grid-cols-4">
        <div class="rounded bg-gray-100 p-4 shadow">
            <p class="text-gray-500">Pending Orders</p>
            <h6 class="text-xl font-bold">513</h6>
        </div>
        <div class="rounded bg-gray-100 p-4 shadow">
            <p class="text-gray-500">Processing Orders</p>
            <h6 class="text-xl font-bold">223</h6>
        </div>
        <div class="rounded bg-gray-100 p-4 shadow">
            <p class="text-gray-500">Ready To Deliver</p>
            <h6 class="text-xl font-bold">486</h6>
        </div>
        <div class="rounded bg-gray-100 p-4 shadow">
            <p class="text-gray-500">Delivered Orders</p>
            <h6 class="text-xl font-bold">159</h6>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-4 gap-4">
        <Card class="col-span-3 p-4">
            <div class="flex justify-between">
                <h6 class="text-lg font-bold">Today's Delivery</h6>
                <div class="flex gap-4">
                    <InputText
                        placeholder="Search Here"
                        v-model="filter.search_query"
                    />
                    <InputSelect
                        v-model="filter.order_filter"
                        :options="orderStatusOptions"
                    />
                </div>
            </div>
            <div
                class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3"
            >
                <div
                    v-for="order in orders"
                    :key="order.order_uuid"
                    class="rounded bg-gray-50 p-4 shadow"
                >
                    <p class="font-bold">{{ order.order_uuid }}</p>
                    <p class="text-gray-500">Customer: Walk In Customer</p>
                    <p class="text-gray-500">
                        <span>02/12/2024</span>
                    </p>
                </div>
            </div>
        </Card>
        <Card class="p-4">
            <div>
                <h6 class="text-lg font-bold">Overview</h6>
                <canvas
                    id="overviewChart"
                    ref="chartCanvas"
                    class="h-64 w-full"
                ></canvas>
                <ul class="mt-4 space-y-2">
                    <li>
                        <span
                            class="inline-block h-4 w-4 rounded bg-[#8392ab]"
                        ></span>
                        <span>Pending</span>
                    </li>
                    <li>
                        <span
                            class="inline-block h-4 w-4 rounded bg-[#faae42]"
                        ></span>
                        <span>Processing</span>
                    </li>
                    <li>
                        <span
                            class="inline-block h-4 w-4 rounded bg-[#2dce89]"
                        ></span>
                        <span>Ready To Deliver</span>
                    </li>
                    <li>
                        <span
                            class="inline-block h-4 w-4 rounded bg-[#0083ff]"
                        ></span>
                        <span>Delivered</span>
                    </li>
                    <li>
                        <span
                            class="inline-block h-4 w-4 rounded bg-[#f5365c]"
                        ></span>
                        <span>Returned</span>
                    </li>
                </ul>
            </div>
        </Card>
    </div>
</template>
