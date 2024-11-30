<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import { useFilters } from '@/Composables/useFilters';
import PosRightSidebar from '@/Pages/Admin/Order/Partials/PosRightSidebar.vue';
import ServiceTypeModal from '@/Pages/Admin/Order/Partials/ServiceTypeModal.vue';
import { ServiceItem, ServiceType } from '@/types';
import { PropType, provide, ref } from 'vue';

// Props
const props = defineProps({
    serviceTypes: {
        type: Array as PropType<ServiceType[]>,
        required: true,
    },
    serviceItems: {
        type: Array as PropType<ServiceItem[]>,
        required: true,
    },
    addonServices: {
        type: Array as PropType<ServiceItem[]>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

// Filters
const { filter, handleClearFilter } = useFilters('admin.orders.create', {
    name: props.filters?.name ?? '',
    service_type_id: props.filters?.service_type_id ?? '',
});

// Modal State
const showServiceTypeModal = ref(false);
const showAddonServiceModal = ref(false);
const showDiscountModal = ref(false);
const showCustomerModal = ref(false);
const selectedServiceItem = ref<ServiceItem | null>(null);

// Methods
const handleItemClick = (item: ServiceItem) => {
    selectedServiceItem.value = item;
    showServiceTypeModal.value = true;
};

const handleIServiceTypeClick = (serviceTypeId: string) => {
    filter.service_type_id =
        filter.service_type_id === serviceTypeId ? '' : serviceTypeId;
};

// Provide state to child components
provide('addonServices', props.addonServices);
provide('showServiceTypeModal', showServiceTypeModal);
provide('showAddonServiceModal', showAddonServiceModal);
provide('showDiscountModal', showDiscountModal);
provide('showCustomerModal', showCustomerModal);
provide('selectedServiceItem', selectedServiceItem);
</script>

<template>
    <div class="grid h-screen grid-cols-3">
        <!-- Left Sidebar -->
        <div class="col-span-2 flex flex-col p-4">
            <!-- Search and Reset -->
            <div class="mb-4 flex items-center gap-2">
                <TextInput
                    v-model="filter.name"
                    class="w-full rounded-md bg-white text-lg shadow transition-shadow focus:shadow-2xl focus:outline-none"
                    placeholder="Search items..."
                />
                <PrimaryButton @click="handleClearFilter">
                    Reset
                </PrimaryButton>
            </div>

            <!-- Categories and Items -->
            <div class="flex">
                <!-- Categories List -->
                <div class="w-1/6 overflow-y-auto border-r pr-2">
                    <ul class="space-y-2">
                        <li
                            v-for="serviceType in serviceTypes"
                            :key="serviceType.id"
                        >
                            <PrimaryButton
                                class="w-full px-3 py-2 text-left"
                                :class="{
                                    'bg-blue-600 text-white':
                                        filter.service_type_id ===
                                        serviceType.id,
                                    'bg-gray-200':
                                        filter.service_type_id !==
                                        serviceType.id,
                                }"
                                @click="handleIServiceTypeClick(serviceType.id)"
                            >
                                {{ serviceType.name }}
                            </PrimaryButton>
                        </li>
                    </ul>
                </div>

                <!-- Items Grid -->
                <div class="w-5/6 pl-2">
                    <div
                        v-if="serviceItems.length"
                        class="grid grid-cols-2 gap-4 pb-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6"
                    >
                        <div
                            v-for="item in serviceItems"
                            :key="item.id"
                            class="cursor-pointer select-none overflow-hidden rounded-xl bg-white shadow hover:shadow-lg dark:bg-gray-900 dark:text-gray-200"
                            @click="handleItemClick(item)"
                        >
                            <img
                                :alt="item?.image?.basename"
                                :src="item?.image?.url"
                                class="h-40 w-full object-cover"
                            />
                            <div class="p-3">
                                <p class="truncate text-sm font-medium">
                                    {{ item.name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="flex h-full items-center justify-center rounded-xl bg-gray-100"
                    >
                        <p class="text-lg font-medium text-gray-500">
                            No items available for the selected category or
                            search.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-span-1 border-l bg-gray-50">
            <PosRightSidebar />
        </div>
    </div>

    <!-- Service Type Modal -->
    <ServiceTypeModal />
</template>
