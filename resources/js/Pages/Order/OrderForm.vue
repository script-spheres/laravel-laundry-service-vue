<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddonCartItems from '@/Pages/Order/Partials/AddonCartItems.vue';
import AddonServicesModal from '@/Pages/Order/Partials/AddonServicesModal.vue';
import CartItems from '@/Pages/Order/Partials/CartItems.vue';
import CouponModal from '@/Pages/Order/Partials/CouponModal.vue';
import CustomerModal from '@/Pages/Order/Partials/CustomerModal.vue';
import ServiceTypeModal from '@/Pages/Order/Partials/ServiceTypeModal.vue';
import NoData from '@/Shared/NoData.vue';
import { usePosStore } from '@/Stores/PosStore';
import {
    AddonService,
    Category,
    Coupon,
    Order,
    Service,
    ServiceItem,
} from '@/types';
import { AkEdit, AkPlus, MdDiscount } from '@kalimahapps/vue-icons';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType, provide, ref } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const posStore = usePosStore();

const props = defineProps({
    services: {
        type: Object as PropType<Service[]>,
        required: true,
    },
    categories: {
        type: Object as PropType<Category[]>,
        required: true,
    },
    serviceItems: {
        type: Object as PropType<ServiceItem[]>,
        required: true,
    },
    addonServices: {
        type: Object as PropType<AddonService[]>,
        required: true,
    },
    coupons: {
        type: Object as PropType<Coupon[]>,
        required: true,
    },
    order: {
        type: Object as PropType<Order>,
        required: false,
    },
    customerOptions: {
        type: Object as PropType<Options>,
        required: false,
    },
    filters: Object as PropType<Filters>,
});

// Filters
const { filter, handleClearFilter } = useFilters('orders.create', {
    name: props.filters?.name ?? '',
    service_type_id: props.filters?.service_type_id ?? '',
});

// Modal State
const showServiceTypeModal = ref(false);
const selectedServiceItem = ref<ServiceItem>({});

// Methods
const handleItemClick = (item: ServiceItem) => {
    selectedServiceItem.value = item;
    showServiceTypeModal.value = true;
};

const handleIServiceTypeClick = (serviceTypeId: string) => {
    filter.service_type_id =
        filter.service_type_id === serviceTypeId ? '' : serviceTypeId;
};
const { order } = props;

const showDiscountModal = ref(false);
const showCouponModal = ref(false);
const showCustomerModal = ref(false);
const showNoteModal = ref(false);
const showAddonServiceModal = ref(false);

const method = order ? 'put' : 'post';
const url = order ? route('orders.update', order.id) : route('orders.store');

const form = useForm(method, url, {
    customer_id: '',
    delivery_date: '',
    details: posStore.items,
    sub_total: posStore.subTotalCost,
    tax_percentage: 0,
    tax_amount: 0,
    payment_status: 'paid',
    order_status: 'placed',
    total_amount: posStore.totalCost,
    payment_mode: 'offline',
    special_notes: '',
});

const posSubmit = async () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
const handleCategoryClick = (item) => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};

provide('showAddonServiceModal', showAddonServiceModal);
provide('showDiscountModal', showDiscountModal);
provide('showCouponModal', showCouponModal);
provide('showCustomerModal', showCustomerModal);
provide('showNoteModal', showNoteModal);
provide('showServiceTypeModal', showServiceTypeModal);
</script>

<template>
    <div class="grid h-[calc(100vh-65px)] grid-cols-3">
        <!-- Left Sidebar -->
        <div class="col-span-2">
            <div class="flex items-center gap-6 p-4">
                <InputText
                    v-model="filter.name"
                    placeholder="Search items ..."
                />
            </div>

            <div class="flex h-[calc(100vh-135px)] space-x-2">
                <div
                    class="w-1/4 overflow-y-auto scrollbar-thin dark:text-white"
                >
                    <p
                        class="sticky top-0 z-10 flex h-14 items-center justify-center border-b bg-gray-100 text-center dark:border-gray-600 dark:bg-gray-700"
                    >
                        Services List :
                    </p>
                    <ul class="space-y-2 p-2">
                        <li
                            v-for="service in services"
                            :key="service.id"
                            class="w-full"
                        >
                            <button
                                class="w-full rounded-lg border px-4 py-2 text-left font-medium transition-all duration-300"
                                :class="{
                                    'bg-blue-600 text-white hover:bg-blue-700':
                                        filter.service_type_id === service.id,
                                    'bg-gray-100 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-blue-600 dark:hover:text-white':
                                        filter.service_type_id !== service.id,
                                }"
                                @click="handleIServiceTypeClick(service.id)"
                            >
                                {{ service.name }}
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Items List -->
                <div class="flex-1 overflow-y-auto scrollbar-thin">
                    <!-- Categories List (Sticky Header) -->
                    <div
                        class="sticky top-0 z-10 border-b bg-gray-100 dark:border-gray-600 dark:bg-gray-700"
                    >
                        <ul class="flex space-x-2 p-2">
                            <li v-for="item in categories" :key="item.id">
                                <button
                                    class="transform rounded-full border bg-gray-200 p-2 font-semibold text-gray-800 transition-all duration-300 hover:bg-gray-400 hover:text-white dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:hover:text-white"
                                    @click="handleCategoryClick(item)"
                                >
                                    {{ item.name }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Service Items List -->
                    <div v-if="serviceItems.length" class="w-full">
                        <ul class="space-y-2">
                            <li
                                v-for="item in serviceItems"
                                :key="item.id"
                                class="flex items-center space-x-2 rounded-lg bg-white p-2 shadow transition-all duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                @click="handleItemClick(item)"
                            >
                                <img
                                    :alt="item?.image?.basename"
                                    :src="item?.image?.url"
                                    class="h-12 w-12 rounded-lg object-cover"
                                />
                                <div>
                                    <p
                                        class="text-sm font-semibold text-gray-800 dark:text-gray-200"
                                    >
                                        {{ item.name }}
                                    </p>
                                    <p
                                        class="text-xs text-gray-600 dark:text-gray-400"
                                    >
                                        {{ item.description }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- No Items Available Message -->
                    <NoData v-else />
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-span-1 border-l">
            <div class="flex flex-col rounded-xl dark:bg-gray-800">
                <div class="p-2">
                    <div class="grid gap-2 md:grid-cols-2">
                        <div class="mt-0">
                            <DateInput
                                v-model="form.delivery_date"
                                label="Delivery Date"
                                :error="form.errors.delivery_date"
                            />
                        </div>
                        <div class="mt-0 flex w-full justify-between gap-1">
                            <div class="flex-grow">
                                <InputSelect
                                    v-model="form.customer_id"
                                    :options="customerOptions"
                                    label="Customer"
                                />
                            </div>
                            <PrimaryButton
                                class="flex-none self-end px-3"
                                @click="showCustomerModal = true"
                            >
                                <AkPlus class="h-4 w-4" />
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
                <CartItems />
                <AddonCartItems />
                <div class="rounded-lg bg-gray-50 p-4 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Notes:</span>
                        <button
                            @click="showNoteModal = true"
                            class="rounded-md bg-green-500 p-1.5 text-white shadow hover:bg-green-600"
                        >
                            <AkEdit />
                        </button>
                    </div>
                    <div
                        class="flex items-center justify-between border-t border-dashed border-gray-300 pt-1"
                    >
                        <!-- Addon, Notes, and Discount Section -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Addon:</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-700"
                                        >RP 0.00</span
                                    >
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Discount:</span>
                                <div class="flex items-center gap-2">
                                    <button
                                        @click="showDiscountModal = true"
                                        class="rounded-md bg-orange-500 p-1.5 text-white shadow hover:bg-orange-600"
                                    >
                                        <MdDiscount />
                                    </button>
                                    <span class="font-bold text-gray-700"
                                        >RP 0.00</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Subtotal and Tax Section -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Sub Total:</span>
                                <span class="font-bold text-gray-700"
                                    >RP 0.00</span
                                >
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Tax (11%):</span>
                                <span class="font-bold text-gray-700"
                                    >RP 0.00</span
                                >
                            </div>
                            <div
                                class="mb-2 flex justify-between text-base font-bold text-gray-800"
                            >
                                <span>TOTAL:</span>
                                <span>{{ posStore.totalCost }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <PrimaryButton
                        @click="posSubmit"
                        :disabled="form.processing"
                        :class="[{ 'opacity-50': form.processing }, 'w-full']"
                    >
                        SUBMIT
                    </PrimaryButton>
                </div>
            </div>
            <!-- Modals -->
        </div>
    </div>

    <CustomerModal />
    <ServiceTypeModal :selectedServiceItem="selectedServiceItem" />
    <AddonServicesModal :addonServices="addonServices" />
    <CouponModal :coupons="coupons" />
</template>
