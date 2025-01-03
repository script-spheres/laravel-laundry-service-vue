<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputRadioBox from '@/Components/Form/InputRadioBox.vue';
import InputText from '@/Components/Form/InputText.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RightSidebar from '@/Pages/Order/Partials/RightSidebar.vue';
import ServiceItemsList from '@/Pages/Order/Partials/ServiceItemsList.vue';
import NoData from '@/Shared/NoData.vue';
import {
    AddonService,
    Category,
    Coupon,
    FinanceSettings,
    Order,
    OrderDetail,
    Service,
    ServiceDetail,
} from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    services: { type: Array as PropType<Service[]>, required: true },
    categories: { type: Array as PropType<Category[]>, required: true },
    serviceDetails: {
        type: Array as PropType<ServiceDetail[]>,
        required: true,
    },
    addonServices: { type: Array as PropType<AddonService[]>, required: true },
    coupons: { type: Array as PropType<Coupon[]>, required: true },
    order: { type: Object as PropType<Order>, required: false },
    orderDetails: { type: Object as PropType<OrderDetail[]>, required: false },
    storeOptions: { type: Object as PropType<Options>, required: true },
    customerOptions: { type: Object as PropType<Options>, required: true },
    financeSettings: {
        type: Object as PropType<FinanceSettings>,
        required: true,
    },
    filters: { type: Object as PropType<Filters> },
});

const { filter, handleClearFilter } = useFilters('orders.create', {
    name: props.filters?.name ?? '',
    service_id: props.filters?.service_id ?? '',
    category_id: props.filters?.category_id ?? '',
});
</script>

<template>
    <div class="grid h-[calc(100vh-65px)] grid-cols-8">
        <!-- Left Sidebar -->
        <div class="col-span-5">
            <div class="flex items-center gap-6 p-4">
                <InputText
                    v-model="filter.name"
                    placeholder="Search items ..."
                />
                <PrimaryButton color="red" @click="handleClearFilter">
                    Clear
                </PrimaryButton>
            </div>

            <div class="flex h-[calc(100vh-135px)] divide-x">
                <!-- Services List -->
                <div class="w-1/4 overflow-y-auto">
                    <p
                        class="sticky top-0 z-10 border-b bg-gray-100 py-3 text-center"
                    >
                        Services List :
                    </p>
                    <ul class="space-y-2 p-2">
                        <li v-for="service in services" :key="service.id">
                            <InputRadioBox
                                name="inline-service-group"
                                :label="service.name"
                                :value="service.id"
                                v-model="filter.service_id"
                            />
                        </li>
                    </ul>
                </div>

                <!-- Items List -->
                <div class="flex-1 overflow-y-auto">
                    <div class="sticky top-0 z-10 border-b bg-gray-100">
                        <ul class="flex space-x-2 p-1">
                            <li
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <InputRadioBox
                                    name="inline-category-group"
                                    :label="category.name"
                                    :value="category.id"
                                    v-model="filter.category_id"
                                />
                            </li>
                        </ul>
                    </div>

                    <!-- Service Items List -->
                    <div v-if="serviceDetails.length" class="w-full p-2">
                        <ServiceItemsList :serviceDetails="serviceDetails" />
                    </div>

                    <!-- No Items Available Message -->
                    <NoData v-else />
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->

        <div
            class="col-span-3 flex flex-col justify-between border-l dark:bg-gray-800"
        >
            <RightSidebar
                :storeOptions="storeOptions"
                :customerOptions="customerOptions"
                :financeSettings="financeSettings"
                :order="order"
                :addonServices="addonServices"
                :coupons="coupons"
                :orderDetails="orderDetails"
            />
        </div>
    </div>
</template>
