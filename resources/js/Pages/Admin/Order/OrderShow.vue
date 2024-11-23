<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Order } from '@/types';
import { PropType } from 'vue';

defineOptions({ layout: AdminLayout });

defineProps({
    order: {
        type: Object as PropType<Order[]>,
        required: true,
    },
});
</script>

<template>
    <div class="flex items-center justify-between py-4">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Orders Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                These companies have purchased in the last 12 months.
            </p>
        </div>

        <div class="flex items-center gap-x-3">
            <LinkButton :href="route('admin.orders.index')">Back</LinkButton>
        </div>
    </div>
    <Card class="mx-auto mt-6">
        <div class="mx-auto max-w-2xl py-0 md:py-16">
            <article
                class="overflow-hidden shadow-none md:rounded-md md:shadow-md"
            >
                <div class="bg-white md:rounded-b-md">
                    <div class="border-b border-gray-200 p-9">
                        <div class="space-y-6">
                            <div class="items-top flex justify-between">
                                <div class="space-y-4">
                                    <div>
                                        <img
                                            class="mb-4 h-6 object-cover"
                                            src="https://cdn.mjwebs.com/sites/mjwebs/mjwebs-logo.png"
                                        />
                                        <p class="text-lg font-bold">Invoice</p>
                                        <p>MJWebs</p>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-400"
                                        >
                                            Billed To
                                        </p>
                                        <p>Tony Stark</p>
                                        <p>tony@starkindustriesxyz.com</p>
                                        <p>(02) 1234 1234</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-400"
                                        >
                                            Invoice Number
                                        </p>
                                        <p>INV-MJ0001</p>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-400"
                                        >
                                            Invoice Date
                                        </p>
                                        <p>31 December 2021</p>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-400"
                                        >
                                            ABN
                                        </p>
                                        <p>57 630 182 446</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 p-9">
                        <p class="text-sm font-medium text-gray-400">Note</p>
                        <p class="text-sm">Thank you for your order.</p>
                    </div>
                    <DataTable class="w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr>
                                <th
                                    class="px-9 py-4 text-left font-semibold text-gray-400"
                                    scope="col"
                                >
                                    Item
                                </th>
                                <th
                                    class="py-3 text-left font-semibold text-gray-400"
                                    scope="col"
                                ></th>
                                <th
                                    class="py-3 text-left font-semibold text-gray-400"
                                    scope="col"
                                >
                                    Amount
                                </th>
                                <th
                                    class="py-3 text-left font-semibold text-gray-400"
                                    scope="col"
                                >
                                    Discount
                                </th>
                                <th
                                    class="py-3 text-left font-semibold text-gray-400"
                                    scope="col"
                                ></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td
                                    class="flex items-center space-x-1 whitespace-nowrap px-9 py-5"
                                >
                                    <div>
                                        <p>Jericho III (YA-4)</p>
                                        <p class="text-sm text-gray-400">
                                            Nuclear-armed ICBM
                                        </p>
                                    </div>
                                </td>
                                <td
                                    class="truncate whitespace-nowrap text-gray-600"
                                ></td>
                                <td
                                    class="truncate whitespace-nowrap text-gray-600"
                                >
                                    $380,000.00
                                </td>
                                <td
                                    class="truncate whitespace-nowrap text-gray-600"
                                >
                                    0%
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="flex items-center space-x-1 whitespace-nowrap px-9 py-5"
                                >
                                    <div>
                                        <p>Pym Particles (Pack of 10,000)</p>
                                        <p class="text-sm text-gray-400">
                                            Redacted Description
                                        </p>
                                    </div>
                                </td>
                                <td
                                    class="truncate whitespace-nowrap text-gray-600"
                                ></td>
                                <td
                                    class="truncate whitespace-nowrap text-gray-600"
                                >
                                    $280,000.00
                                </td>
                                <td
                                    class="truncate whitespace-nowrap text-gray-600"
                                >
                                    0%
                                </td>
                            </tr>
                        </tbody>
                    </DataTable>
                    <div class="border-b border-gray-200 p-9">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        Subtotal
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500">$660,000.00</p>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Tax</p>
                                </div>
                                <p class="text-sm text-gray-500">$0.00</p>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total</p>
                                </div>
                                <p class="text-sm text-gray-500">$660,000.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 p-9">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-lg font-bold text-black">
                                        Amount Due
                                    </p>
                                </div>
                                <p class="text-lg font-bold text-black">
                                    $360.00
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <div class="mt-4 flex gap-4">
                <LinkButton href="#" target="_blank"> Download PDF</LinkButton>
                <LinkButton href="#" target="_blank"> Pay Balance</LinkButton>
            </div>
        </div>
    </Card>
</template>
