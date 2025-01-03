<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputRadioBox from '@/Components/Form/InputRadioBox.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Modal from '@/Components/Modal/Modal.vue';
import Card from '@/Components/Panel/Card.vue';
import { orderStatusOptions, paymentModeOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { FinanceSettings, Order } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType, ref } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    order: {
        type: Object as PropType<Order>,
        required: true,
    },
    financeSettings: {
        type: Object as PropType<FinanceSettings>,
        required: true,
    },
});

const showAddPaymentModal = ref(false);

const form = useForm('post', route('payments.store'), {
    order_id: props?.order.id,
    payment_method: '',
    amount: 0,
});

const addPayment = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => {
            form.reset();
            toast.success(page?.props?.flash?.message);
            showAddPaymentModal.value = false;
        },
    });
};

const closeModal = () => {
    showAddPaymentModal.value = false;
};
const printInvoice = () => {};
</script>

<template>
    <PageHeader>
        <template #title> Order Management</template>
        <template #subtitle>
            Show the details for your order details.
        </template>
        <template #actions>
            <LinkButton :href="route('orders.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Order Details -->
        <Card class="lg:col-span-2">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-primary text-lg font-medium">
                            Invoice To
                        </h3>
                        <div class="mt-2 space-y-1 text-sm">
                            <p>+{{ order.customer?.phone_number }}</p>
                            <p>{{ order.customer?.email }}</p>
                            <p>{{ order.customer?.address }}</p>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="text-right">
                        <p class="text-sm">
                            <span class="font-medium text-gray-700"
                                >Order ID:</span
                            >
                            <span class="text-primary"
                                >#{{ order.order_display_id }}</span
                            >
                        </p>
                        <p class="text-sm">
                            <span class="font-medium text-gray-700"
                                >Order Date:</span
                            >
                            {{ order.created_at }}
                        </p>
                        <p class="text-sm">
                            <span class="font-medium text-gray-700"
                                >Delivery Date:</span
                            >
                            {{ order.delivery_date }}
                        </p>
                        <div class="mt-2">
                            <span class="font-medium text-gray-700">
                                Order Status:
                            </span>
                            <InputSelect
                                v-model="order.order_status"
                                :options="orderStatusOptions"
                            />
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
                <DataTable class="mt-6">
                    <TableHead>
                        <TableHeadCell>#</TableHeadCell>
                        <TableHeadCell>Service Name</TableHeadCell>
                        <TableHeadCell>Color</TableHeadCell>
                        <TableHeadCell>Rate</TableHeadCell>
                        <TableHeadCell>QTY</TableHeadCell>
                        <TableHeadCell>Total</TableHeadCell>
                    </TableHead>
                    <TableBody>
                        <TableRow
                            v-for="(orderDetail, index) in order.order_details"
                            :key="orderDetail.id"
                        >
                            <TableCell>{{ index + 1 }}</TableCell>
                            <TableCell>
                                <div class="flex items-center gap-4">
                                    <!-- Display serviceable image and name -->
                                    <img
                                        :src="
                                            orderDetail?.info?.service_image
                                                ?.url
                                        "
                                        alt="Service Icon"
                                        class="h-10 w-10 object-contain"
                                    />
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ orderDetail.info.service_name }}
                                        </p>
                                    </div>
                                </div>
                            </TableCell>
                            <TableCell
                                >{{ orderDetail.info.color || 'N/A' }}
                            </TableCell>
                            <TableCell
                                >{{ financeSettings.currency_symbol }}
                                {{ orderDetail.price }}
                            </TableCell>
                            <TableCell>{{ orderDetail.quantity }} </TableCell>
                            <TableCell
                                >{{ financeSettings.currency_symbol }}
                                {{ orderDetail.price * orderDetail.quantity }}
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </DataTable>

                <!-- Summary -->
                <div
                    class="mt-6 space-y-2 rounded-lg bg-gray-50 p-6 dark:bg-gray-800"
                >
                    <div
                        class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300"
                    >
                        <p class="font-medium">Sub Total</p>
                        <p
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            {{ financeSettings.currency_symbol }}
                            {{ order.sub_total }}
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300"
                    >
                        <p class="font-medium">Discount</p>
                        <p
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            {{ financeSettings.currency_symbol }}
                            {{ order.discount_amount }}
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300"
                    >
                        <p class="font-medium">
                            Tax ({{ order.tax_percentage }}%)
                        </p>
                        <p
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            {{ financeSettings.currency_symbol }}
                            {{ order.tax_amount }}
                        </p>
                    </div>
                    <div
                        class="border-t border-gray-300 pt-4 dark:border-gray-700"
                    >
                        <div
                            class="flex items-center justify-between text-lg font-semibold"
                        >
                            <p class="text-gray-800 dark:text-white">
                                Gross Total
                            </p>
                            <p class="text-primary">
                                {{ financeSettings.currency_symbol }}
                                {{ order.total_amount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </Card>

        <!-- Payments and Actions -->
        <Card class="rounded-lg bg-white shadow-lg dark:bg-gray-800">
            <div class="space-y-6 p-6">
                <h3
                    class="text-2xl font-semibold text-gray-800 dark:text-white"
                >
                    Payments
                </h3>

                <DataTable>
                    <TableHead>
                        <TableHeadCell>Date</TableHeadCell>
                        <TableHeadCell>Payment Mode</TableHeadCell>
                        <TableHeadCell>Amount</TableHeadCell>
                    </TableHead>
                    <TableBody>
                        <TableRow
                            v-for="payment in order.payments"
                            :key="payment.id"
                        >
                            <TableCell>{{ payment.payment_date }}</TableCell>
                            <TableCell>{{ payment.payment_method }}</TableCell>
                            <TableCell>{{ payment.amount }}</TableCell>
                        </TableRow>
                    </TableBody>
                </DataTable>

                <!-- Summary Section -->
                <div class="space-y-4 border-t pt-4">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium">Order Amount:</span>
                        <span class="text-primary text-lg font-semibold">
                            {{ financeSettings.currency_symbol }}
                            {{ order.total_amount }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium">Paid Amount:</span>
                        <span class="text-lg font-semibold text-green-500">
                            {{ financeSettings.currency_symbol }}
                            {{ order.paid_amount }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium">Due Balance:</span>
                        <span class="text-lg font-semibold text-red-500">
                            {{ financeSettings.currency_symbol }}
                            {{ order.due_amount }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex flex-col gap-4">
                    <PrimaryButton
                        class="w-full"
                        @click="showAddPaymentModal = true"
                    >
                        Add Payment
                    </PrimaryButton>
                    <PrimaryButton class="w-full" @click="printInvoice">
                        Print Invoice
                    </PrimaryButton>
                </div>
            </div>
        </Card>

        <!-- Add Payment Modal -->
        <Modal :show="showAddPaymentModal" @close="closeModal">
            <div class="space-y-6 p-6">
                <!-- Payment Mode Section -->
                <div>
                    <div class="mb-4 font-medium text-gray-700">
                        Payment Mode:
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <div
                            v-for="(value, key) in paymentModeOptions"
                            :key="key"
                            class="flex items-center"
                        >
                            <InputRadioBox
                                name="payment_method"
                                :label="value"
                                :value="key"
                                v-model="form.payment_method"
                                class="text-lg"
                            />
                        </div>
                    </div>
                </div>

                <!-- Amount Section -->
                <div
                    class="rounded-lg border border-gray-200 bg-gray-50 p-4 shadow-sm"
                >
                    <div class="flex items-center gap-4">
                        <span class="font-medium text-gray-600">Amount:</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-600">{{
                                financeSettings.currency_symbol
                            }}</span>
                            <InputText
                                v-model="form.amount"
                                type="number"
                                placeholder="Enter amount"
                                class="w-36"
                            />
                        </div>
                    </div>
                </div>

                <!-- Add Payment Button -->
                <PrimaryButton @click="addPayment" class="mt-4 w-full">
                    Add Payment
                </PrimaryButton>
            </div>
        </Modal>
    </div>
</template>
