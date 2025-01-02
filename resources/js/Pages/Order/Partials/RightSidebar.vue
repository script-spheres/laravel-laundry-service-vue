<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputRadioBox from '@/Components/Form/InputRadioBox.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import { paymentModeOptions } from '@/Constants/options';
import AddonCartItems from '@/Pages/Order/Partials/AddonCartItems.vue';
import AddonServicesModal from '@/Pages/Order/Partials/AddonServicesModal.vue';
import CartItems from '@/Pages/Order/Partials/CartItems.vue';
import CouponModal from '@/Pages/Order/Partials/CouponModal.vue';
import CustomerModal from '@/Pages/Order/Partials/CustomerModal.vue';
import NoteModal from '@/Pages/Order/Partials/NoteModal.vue';
import { usePosStore } from '@/Stores/PosStore';
import {
    AddonService,
    Coupon,
    FinanceSettings,
    Order,
    OrderDetail,
} from '@/types';
import {
    AkEdit,
    AkPlus,
    AkTrashCan,
    BxPackage,
    MdDiscount,
} from '@kalimahapps/vue-icons';
import { useForm } from 'laravel-precognition-vue-inertia';
import { computed, onMounted, PropType, provide, ref, watch } from 'vue';
import { toast } from 'vue3-toastify';

const posStore = usePosStore();

const props = defineProps({
    storeOptions: { type: Object as PropType<Options>, required: true },
    customerOptions: { type: Object as PropType<Options>, required: true },
    financeSettings: {
        type: Object as PropType<FinanceSettings>,
        required: true,
    },
    order: { type: Object as PropType<Order>, required: false },
    addonServices: { type: Array as PropType<AddonService[]>, required: true },
    coupons: { type: Array as PropType<Coupon[]>, required: true },
    orderDetails: { type: Object as PropType<OrderDetail[]>, required: false },
});

// Set up form submission URL and method
const method = props.order ? 'put' : 'post';
const url = props.order
    ? route('orders.update', props.order.id)
    : route('orders.store');

// Initialize form data
const form = useForm(method, url, {
    store_id: props.order?.store_id ?? '',
    customer_id: props.order?.customer_id ?? '',
    delivery_date: props.order?.delivery_date ?? '',
    details: posStore.items,
    sub_total: posStore.subTotalCost,
    tax_amount: posStore.taxAmount,
    total_amount: posStore.totalCost,
    quick_note: props.order?.quick_note ?? '',
    payment: { payment_method: '', amount: 0 },
});

// Watch for changes in posStore and update form
const details = computed(() => posStore.items);
const subTotal = computed(() => posStore.subTotalCost);
const taxAmount = computed(() => posStore.taxAmount);
const totalAmount = computed(() => posStore.totalCost);

const updateForm = () => {
    form.details = details.value;
    form.sub_total = subTotal.value;
    form.tax_amount = taxAmount.value;
    form.total_amount = totalAmount.value;
};

// Watch posStore for changes and update form values accordingly
watch([details, subTotal, taxAmount, totalAmount], updateForm, {
    immediate: true,
});

// Initialize order details if an order is provided
onMounted(() => {

    posStore.clear();

    if (props.order) {
        props.orderDetails?.forEach((item) => {
            posStore.addItem({
                id: item.id,
                service_name: item.service_name,
                service_image: item?.service_image,
                serviceable_type: item.serviceable_type,
                serviceable_id: item.serviceable_id,
                color: item.color,
                price: item.price,
                quantity: item.quantity,
            });
        });
    }
});

// Define modal states
const showDiscountModal = ref(false);
const showCouponModal = ref(false);
const showCustomerModal = ref(false);
const showNoteModal = ref(false);
const showPaymentModal = ref(false);
const showAddonServiceModal = ref(false);

const posSubmit = () => {
    console.log(posStore.items, 'posStore');

    form.submit({
        preserveScroll: true,
        onSuccess: (page) => {
            posStore.clear();
            form.reset();
            toast.success(page?.props?.flash?.message);
        },
        onError: (page) => {
            if (page && typeof page === 'object') {
                Object.values(page).forEach((errorMessage) =>
                    toast.error(errorMessage),
                );
            } else {
                console.error('Expected an object of errors, but got:', page);
            }
        },
    });
};

// Provide modal visibility states
provide('showAddonServiceModal', showAddonServiceModal);
provide('showDiscountModal', showDiscountModal);
provide('showCouponModal', showCouponModal);
provide('showCustomerModal', showCustomerModal);
provide('showNoteModal', showNoteModal);
provide('showPaymentModal', showPaymentModal);
</script>

<template>
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
                {{ form.quick_note }}
            </p>
            <div class="flex gap-2">
                <PrimaryButton
                    color="gray"
                    size="sm"
                    @click="showNoteModal = true"
                >
                    <AkEdit />
                </PrimaryButton>
                <PrimaryButton
                    color="red"
                    size="sm"
                    @click="form.quick_note = ''"
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
                            >{{ financeSettings.currency_symbol }}
                            {{
                                posStore.totalCostByType('addon-service')
                            }}</span
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
                            >{{ financeSettings.currency_symbol }}
                            {{ posStore.discountAmount }}</span
                        >
                    </div>
                </div>
            </div>

            <!-- Subtotal and Tax Section -->
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Sub Total:</span>
                    <span class="font-bold text-gray-700"
                        >{{ financeSettings.currency_symbol }}
                        {{ posStore.subTotalCost }}</span
                    >
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600"
                        >Tax ({{ financeSettings.tax_rate }}%):</span
                    >
                    <span class="font-bold text-gray-700"
                        >{{ financeSettings.currency_symbol }}
                        {{ posStore.taxAmount }}</span
                    >
                </div>
                <div
                    class="flex justify-between text-base font-bold text-gray-800"
                >
                    <span>TOTAL:</span>
                    <span>{{ posStore.totalCost }}</span>
                </div>
            </div>
        </div>

        <!-- Cash Payment Section -->
        <div
            class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4 shadow-sm"
        >
            <div class="mb-2 font-medium text-gray-700">Payment Mode:</div>
            <div class="flex justify-between">
                <div class="">
                    <div class="flex gap-2">
                        <div
                            v-for="(index, key) in paymentModeOptions"
                            :key="key"
                        >
                            <InputRadioBox
                                name="inline-service-group"
                                :label="index"
                                :value="key"
                                v-model="form.payment.payment_method"
                                class="text-lg"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="mr-2 text-gray-600">Amount</span>
                    <InputText
                        v-model="form.payment.amount"
                        type="number"
                        placeholder="Amount"
                    />
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between">
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
    <CustomerModal />
    <NoteModal v-model="form.quick_note" />
    <AddonServicesModal :addonServices="addonServices" />
    <CouponModal :coupons="coupons" />
</template>
