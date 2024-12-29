<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputRadioBox from '@/Components/Form/InputRadioBox.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import { useFilters } from '@/Composables/useFilters';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddonCartItems from '@/Pages/Order/Partials/AddonCartItems.vue';
import AddonServicesModal from '@/Pages/Order/Partials/AddonServicesModal.vue';
import CartItems from '@/Pages/Order/Partials/CartItems.vue';
import CouponModal from '@/Pages/Order/Partials/CouponModal.vue';
import CustomerModal from '@/Pages/Order/Partials/CustomerModal.vue';
import NoteModal from '@/Pages/Order/Partials/NoteModal.vue';
import PaymentModal from '@/Pages/Order/Partials/PaymentModal.vue';
import ServiceItemsList from '@/Pages/Order/Partials/ServiceItemsList.vue';
import NoData from '@/Shared/NoData.vue';
import { usePosStore } from '@/Stores/PosStore';
import {
    AddonService,
    Category,
    Coupon,
    Order,
    Service,
    ServiceDetail,
} from '@/types';
import { AkEdit, AkPlus, BxPackage, MdDiscount,AkTrashCan } from '@kalimahapps/vue-icons';
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
    serviceDetails: {
        type: Object as PropType<ServiceDetail[]>,
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
    storeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    customerOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const showDiscountModal = ref(false);
const showCouponModal = ref(false);
const showCustomerModal = ref(false);
const showNoteModal = ref(false);
const showPaymentModal = ref(false);
const showAddonServiceModal = ref(false);

const method = props.order ? 'put' : 'post';
const url = props.order
    ? route('orders.update', props.order.id)
    : route('orders.store');

const form = useForm(method, url, {
    store_id: '',
    customer_id: '',
    delivery_date: '',
    details: posStore.items,
    sub_total: posStore.subTotalCost,
    tax_percentage: posStore.taxPercentage,
    tax_amount: posStore.taxAmount,
    payment_status: 'paid',
    order_status: 'placed',
    total_amount: posStore.totalCost,
    payment_mode: 'offline',
    special_notes: '',
});

const { filter, handleClearFilter } = useFilters('orders.create', {
    name: props.filters?.name ?? '',
    service_id: props.filters?.service_id ?? '',
    category_id: props.filters?.category_id ?? '',
});

const posSubmit = async () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
        onError: (page) => {
            if (page && typeof page === 'object') {
                Object.values(page).forEach((errorMessage) => {
                    toast.error(errorMessage);
                });
            } else {
                console.error('Expected an object of errors, but got:', page);
            }
        },
    });
};

provide('showAddonServiceModal', showAddonServiceModal);
provide('showDiscountModal', showDiscountModal);
provide('showCouponModal', showCouponModal);
provide('showCustomerModal', showCustomerModal);
provide('showNoteModal', showNoteModal);
provide('showPaymentModal', showPaymentModal);
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
                <PrimaryButton color="danger" @click="handleClearFilter">
                    Clear Filters
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
            <div class="p-4">
                <div class="mb-2 grid grid-cols-2 gap-4">
                    <div>
                        <InputSelect
                            v-model="form.store_id"
                            label="Store"
                            :options="storeOptions"
                        />
                    </div>
                    <div>
                        <InputText
                            type="date"
                            v-model="form.delivery_date"
                            label="Delivery Date"
                        />
                    </div>
                </div>

                <div class="mb-2 flex gap-1">
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

                <div class="space-y-2">
                    <CartItems />
                    <AddonCartItems />
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="bg-gray-200 p-4 text-sm">
                <div class="flex items-center justify-between">
                    <p>
                        <span class="font-medium"> Notes: </span>
                        {{ form.special_notes }}
                    </p>
                    <div class="flex gap-2">
                        <PrimaryButton color="success" size="sm"
                            @click="showNoteModal = true"
                        >
                            <AkEdit />
                        </PrimaryButton>
                        <PrimaryButton color="danger" size="sm"
                            @click="showNoteModal = true"
                        >
                            <AkTrashCan />
                        </PrimaryButton>
                    </div>
                </div>
                <div class="flex justify-between text-base font-bold">
                    <div class="space-y-2">
                        <!-- Addon and Discount Section -->
                        <div class="flex justify-between">
                            <span class="font-medium">Addon:</span>
                            <div class="flex items-center gap-2">
                                <button
                                    @click="showAddonServiceModal = true"
                                    class="rounded-md bg-gray-500 p-1.5 text-white shadow hover:bg-gray-600"
                                >
                                    <BxPackage />
                                </button>
                                <span class="font-bold text-gray-700"
                                    >RP 0.00</span
                                >
                            </div>
                        </div>
                        <div class="flex justify-between">
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
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sub Total:</span>
                            <span class="font-bold text-gray-700">RP 0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (11%):</span>
                            <span class="font-bold text-gray-700">RP 0.00</span>
                        </div>
                        <div
                            class="flex justify-between text-base font-bold text-gray-800"
                        >
                            <span>TOTAL:</span>
                            <span>{{ posStore.totalCost }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <PrimaryButton @click="showPaymentModal = true">
                        Payment
                    </PrimaryButton>
                    <!-- Submit Button -->
                    <PrimaryButton
                        @click="posSubmit"
                        :disabled="form.processing"
                        :class="[{ 'opacity-50': form.processing }]"
                    >
                        SUBMIT
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <CustomerModal />
    <PaymentModal />
    <NoteModal v-model="form.special_notes" />
    <AddonServicesModal :addonServices="addonServices" />
    <CouponModal :coupons="coupons" />
</template>
