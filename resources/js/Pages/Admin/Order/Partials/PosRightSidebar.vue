<script setup lang="ts">
import { usePosStore } from '@/Stores/PosStore';
import { AkPlus } from '@kalimahapps/vue-icons';
import { PropType, provide, ref } from 'vue';

import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import AddonServicesModal from '@/Pages/Admin/Order/Partials/AddonServicesModal.vue';
import CartItems from '@/Pages/Admin/Order/Partials/CartItems.vue';
import CustomerModal from '@/Pages/Admin/Order/Partials/CustomerModal.vue';
import DiscountModal from '@/Pages/Admin/Order/Partials/DiscountModal.vue';
import { Order } from '@/types';
import { AkEdit, BxPackage, MdDiscount } from '@kalimahapps/vue-icons';
import { useForm } from 'laravel-precognition-vue-inertia';
import { toast } from 'vue3-toastify';

const posStore = usePosStore();

const props = defineProps({
    order: {
        type: Object as PropType<Order>,
        required: false,
    },
    customerOptions: {
        type: Object as PropType<Options>,
        required: false,
    },
});
const { order } = props;

const showAddonServiceModal = ref(false);
const showDiscountModal = ref(false);
const showCustomerModal = ref(false);
const showNoteModal = ref(false);

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

provide('showAddonServiceModal', showAddonServiceModal);
provide('showDiscountModal', showDiscountModal);
provide('showCustomerModal', showCustomerModal);
provide('showNoteModal', showNoteModal);
</script>

<template>
    <div class="flex h-screen flex-col rounded-xl shadow dark:bg-gray-800">
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
                            <span class="font-bold text-gray-700">RP 0.00</span>
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
                            <span class="font-bold text-gray-700">RP 0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Subtotal and Tax Section -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Sub Total:</span>
                        <span class="font-bold text-gray-700">RP 0.00</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Tax (11%):</span>
                        <span class="font-bold text-gray-700">RP 0.00</span>
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
    <AddonServicesModal />
    <DiscountModal />
    <CustomerModal />
</template>
