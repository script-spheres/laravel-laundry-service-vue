<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import Card from '@/Components/Panel/Card.vue';
import { orderStatusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Order } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    order: {
        type: Object as PropType<Order>,
        required: true,
    },
});

// Payment logic placeholders
const addPayment = () => {
    console.log('Add Payment clicked');
};

const printInvoice = () => {};
</script>

<template>
    <PageHeader>
        <template #title> Order Management </template>
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
                <div class="mt-6">
                    <DataTable>
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
                                v-for="(
                                    orderDetail, index
                                ) in order.order_details"
                                :key="orderDetail.id"
                            >
                                <TableCell>{{ index + 1 }}</TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-4">
                                        <!-- Display serviceable image and name -->
                                        <img
                                            v-if="
                                                orderDetail.serviceable &&
                                                orderDetail.serviceable.icon_url
                                            "
                                            :src="
                                                orderDetail.serviceable.icon_url
                                            "
                                            alt="Service Icon"
                                            class="h-10 w-10 object-contain"
                                        />
                                        <div>
                                            <p
                                                class="font-medium text-gray-800"
                                            >
                                                {{
                                                    orderDetail.serviceable
                                                        ? orderDetail
                                                              .serviceable.name
                                                        : 'Unknown Service'
                                                }}
                                            </p>
                                            <p
                                                v-if="
                                                    orderDetail.serviceable
                                                        ?.description
                                                "
                                                class="text-sm text-gray-500"
                                            >
                                                {{
                                                    orderDetail.serviceable
                                                        .description
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>{{
                                    orderDetail.serviceable?.color || 'N/A'
                                }}</TableCell>
                                <TableCell
                                    >RP {{ orderDetail.price }}</TableCell
                                >
                                <TableCell>{{
                                    orderDetail.quantity
                                }}</TableCell>
                                <TableCell
                                    >RP
                                    {{
                                        orderDetail.price * orderDetail.quantity
                                    }}</TableCell
                                >
                            </TableRow>
                        </TableBody>
                    </DataTable>
                </div>

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
                            RP {{ order.sub_total }}
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300"
                    >
                        <p class="font-medium">Discount</p>
                        <p
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            RP {{ order.discount_amount }}
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300"
                    >
                        <p class="font-medium">Tax (11%)</p>
                        <p
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            RP {{ order.tax_amount }}
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
                                RP {{ order.total_amount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </Card>

        <!-- Payments and Actions -->
        <Card class="rounded-lg bg-white shadow-md dark:bg-gray-800">
            <div class="space-y-6 p-6">
                <h3
                    class="text-2xl font-semibold text-gray-800 dark:text-white"
                >
                    Payments
                </h3>
                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between border-b pb-2"
                    >
                        <span
                            class="text-base font-medium text-gray-600 dark:text-gray-300"
                        >
                            Order Amount:
                        </span>
                        <span class="text-primary text-lg font-semibold">
                            RP {{ order.total_amount }}
                        </span>
                    </div>
                    <div
                        class="flex items-center justify-between border-b pb-2"
                    >
                        <span
                            class="text-base font-medium text-gray-600 dark:text-gray-300"
                        >
                            Paid Amount:
                        </span>
                        <span class="text-lg font-semibold text-green-500">
                            RP {{ order.paid_amount }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span
                            class="text-base font-medium text-gray-600 dark:text-gray-300"
                        >
                            Due Balance:
                        </span>
                        <span class="text-lg font-semibold text-red-500">
                            RP
                            {{ order.total_amount - order.paid_amount }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col space-y-4">
                    <PrimaryButton class="w-full" @click="addPayment">
                        Add Payment
                    </PrimaryButton>
                    <PrimaryButton
                        theme="warning"
                        class="w-full"
                        @click="printInvoice"
                    >
                        Print Invoice
                    </PrimaryButton>
                </div>
            </div>
        </Card>
    </div>
</template>
