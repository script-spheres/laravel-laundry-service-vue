<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import { useFilters } from '@/Composables/useFilters';
import AddonCartItems from '@/Pages/Admin/Order/Partials/AddonCartItems.vue';
import AddonServicesModal from '@/Pages/Admin/Order/Partials/AddonServicesModal.vue';
import CartItems from '@/Pages/Admin/Order/Partials/CartItems.vue';
import CouponModal from '@/Pages/Admin/Order/Partials/CouponModal.vue';
import CustomerModal from '@/Pages/Admin/Order/Partials/CustomerModal.vue';
import ServiceTypeModal from '@/Pages/Admin/Order/Partials/ServiceTypeModal.vue';
import { usePosStore } from '@/Stores/PosStore';
import { AddonService, Coupon, Order, ServiceItem, ServiceType } from '@/types';
import { AkEdit, AkPlus, MdDiscount } from '@kalimahapps/vue-icons';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType, provide, ref } from 'vue';
import { toast } from 'vue3-toastify';

const posStore = usePosStore();

const props = defineProps({
    serviceTypes: {
        type: Object as PropType<ServiceType[]>,
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
const { filter, handleClearFilter } = useFilters('admin.orders.create', {
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
const url = order
    ? route('admin.orders.update', order.id)
    : route('admin.orders.store');

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

console.log(posStore.items);
provide('showAddonServiceModal', showAddonServiceModal);
provide('showDiscountModal', showDiscountModal);
provide('showCouponModal', showCouponModal);
provide('showCustomerModal', showCustomerModal);
provide('showNoteModal', showNoteModal);
provide('showServiceTypeModal', showServiceTypeModal);
</script>

<template>
    <div class="grid h-screen grid-cols-3">
        <!-- Left Sidebar -->
        <div class="col-span-2 flex flex-col p-4">
            <!-- Search and Reset -->
            <div class="mb-4 flex items-center gap-2">
                <LinkButton :href="route('admin.orders.index')">
                    Back
                </LinkButton>
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
        <div class="col-span-1 border-l">
            <div
                class="flex h-screen flex-col rounded-xl shadow dark:bg-gray-800"
            >
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
                                <SelectInput
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
                <div class="rounded-lg bg-gray-50 p-4 text-sm shadow-md">
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
