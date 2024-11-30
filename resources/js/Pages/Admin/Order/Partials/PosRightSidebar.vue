<script setup lang="ts">
import { usePosStore } from '@/Stores/PosStore';
import { AkCart, AkMinus, AkPlus, AkTrashCan } from '@kalimahapps/vue-icons';
import { inject, PropType, Ref, ref } from 'vue';

import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import { serviceTypeOptions } from '@/Constants/options';
import AddonServicesModal from '@/Pages/Admin/Order/Partials/AddonServicesModal.vue';
import DiscountModal from '@/Pages/Admin/Order/Partials/DiscountModal.vue';
import { Order } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { toast } from 'vue3-toastify';
import CustomerModal from '@/Pages/Admin/Order/Partials/CustomerModal.vue';

const cartStore = usePosStore();
const moneys = ref([50, 100, 200, 5000, 10000, 20000, 50000, 100000]);
const showAddonServiceModal = inject('showAddonServiceModal') as Ref<boolean>;
const showDiscountModal = inject('showDiscountModal') as Ref<boolean>;
const showCustomerModal = inject('showCustomerModal') as Ref<boolean>;

const props = defineProps({
    order: {
        type: Object as PropType<Order>,
        required: false,
    },
});
const { order } = props;

const method = order ? 'put' : 'post';
const url = order
    ? route('admin.orders.update', order.id)
    : route('admin.orders.store');

const form = useForm(method, url, {
    customer_name: '',
    customer_mobile: '',
    customer_email: '',
    // outlet_id: outlet.id ?? '',
    table_id: cartStore.table ?? '',
    service_type_id: '',
    details: cartStore.items,
    sub_total: cartStore.subTotalCost,
    tax_percentage: 0,
    tax_amount: 0,
    payment_status: 'paid',
    order_status: 'placed',
    total_amount: cartStore.totalCost,
    payment_mode: 'offline',
    special_notes: '',
});

const posSubmit = async () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <div class="flex h-full flex-col rounded-xl shadow dark:bg-gray-800">
        <div class="p-2">
            <div class="grid gap-2 md:grid-cols-2">
                <div class="mt-0">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        v-model="form.customer_name"
                        placeholder="Customer name"
                        type="text"
                    />
                    <InputError
                        :message="form.errors.customer_name"
                        class="mt-2"
                    />
                </div>
                <div class="mt-0">
                    <InputLabel for="name" value="Mobile Number" />
                    <TextInput
                        v-model="form.customer_mobile"
                        placeholder="Mobile Number"
                        type="text"
                    />
                    <InputError
                        :message="form.errors.customer_mobile"
                        class="mt-2"
                    />
                </div>
                <div class="mt-0">
                    <InputLabel for="name" value="Email ID" />
                    <TextInput
                        v-model="form.customer_email"
                        placeholder="Email ID (Optional)"
                        type="email"
                    />
                    <InputError
                        :message="form.errors.customer_email"
                        class="mt-2"
                    />
                </div>
                <div class="mt-0">
                    <InputLabel for="service_type_id" value="Order Type" />
                    <SelectInput
                        v-model="form.service_type_id"
                        :options="serviceTypeOptions"
                        class="w-full"
                    />
                    <InputError
                        :message="form.errors.service_type_id"
                        class="mt-2"
                    />
                </div>
            </div>

            <div class="grid gap-2 md:grid-cols-2">
                <div>
                    <label
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                        >Customer name</label
                    >
                    <div class="flex gap-1">
                        <SelectInput
                            v-model="form.customer_id"
                            :options="customerOptions"
                            label="name"
                            placeholder="Select one"
                            track-by="id"
                        />
                        <PrimaryButton
                            class="px-3 py-1"
                            @click="showCustomerModal = true"
                        >
                            <AkPlus class="h-4 w-4" />
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="cartStore.items.length === 0"
            class="flex w-full flex-1 select-none flex-col flex-wrap content-center justify-center p-4 opacity-25"
        >
            <AkCart class="h-16 w-16" />
            <p>Cart Empty</p>
        </div>
        <div
            v-if="cartStore.items.length > 0"
            class="flex flex-1 flex-col overflow-auto"
        >
            <div class="flex justify-between p-4">
                <p class="text-xl font-bold">Cart Items</p>
                <div class="flex gap-4">
                    <div class="relative text-left text-lg">
                        <AkCart class="h-6 w-6" />
                        <div
                            v-if="cartStore.totalItems > 0"
                            class="absolute -right-2 top-3 h-5 w-5 rounded-full bg-cyan-500 p-0 text-center text-xs leading-5 text-white"
                        >
                            {{ cartStore.totalItems }}
                        </div>
                    </div>
                    <div class="relative flex-grow text-right text-lg">
                        <PrimaryButton
                            class="hover:text-pink-500 focus:outline-none"
                            @click="cartStore.clearCart()"
                        >
                            <AkTrashCan class="inline-block h-6 w-6" />
                        </PrimaryButton>
                    </div>
                </div>
            </div>
            <div class="w-full flex-1 overflow-auto px-4">
                <div
                    v-for="item in cartStore.items"
                    :key="item.id"
                    class="mb-1 flex w-full justify-center rounded-lg bg-white px-2 py-2 shadow"
                >
                    <img
                        :src="item?.image?.url"
                        alt=""
                        class="mr-2 h-10 w-10 rounded-lg shadow"
                    />
                    <div class="flex-grow">
                        <h5 class="text-sm">{{ item.title }}</h5>
                        <div class="flex">
                            <p class="block text-xs">
                                {{ item.selling_price }}
                            </p>
                            <p class="block text-xs">{{ item.market_price }}</p>
                        </div>
                    </div>
                    <div class="ml-2 flex gap-2">
                        <PrimaryButton
                            class="rounded-lg bg-gray-600 px-2 py-1 text-center text-white hover:bg-gray-700 focus:outline-none"
                            @click="
                                cartStore.updateItem(item.id, item.quantity - 1)
                            "
                        >
                            <AkMinus class="h-4 w-4" />
                        </PrimaryButton>
                        <input
                            v-model="item.quantity"
                            class="w-16 rounded-lg bg-white text-center text-sm shadow focus:shadow-lg focus:outline-none"
                            type="text"
                        />
                        <PrimaryButton
                            class="rounded-lg bg-gray-600 px-2 py-1 text-center text-white hover:bg-gray-700 focus:outline-none"
                            @click="
                                cartStore.updateItem(item.id, item.quantity + 1)
                            "
                        >
                            <AkPlus class="h-4 w-4" />
                        </PrimaryButton>
                        <PrimaryButton
                            class="px-2 py-1"
                            @click="cartStore.removeItem(item.id)"
                        >
                            <AkTrashCan class="h-4 w-4" />
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="mt-4 flex justify-between border-b-0 border-l-0 border-r-0 border-t border-dashed border-neutral-200 p-2 text-sm dark:border-[#1b2431]"
        >
            <div class="flex flex-col gap-2">
                <div class="flex items-end justify-end gap-2">
                    <div class="flex items-center gap-2">
                        Addon
                        <PrimaryButton
                            @click="showAddonServiceModal = true"
                            class="flex items-center gap-1.5 rounded-md border border-0 border-solid border-neutral-400 bg-transparent px-1 py-1 shadow-md"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="14"
                                height="14"
                                fill="currentColor"
                                class="bi bi-box-fill"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.004-.001.274-.11a.75.75 0 0 1 .558 0l.274.11.004.001zm-1.374.527L8 5.962 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339Z"
                                ></path>
                            </svg>
                        </PrimaryButton>
                        :
                    </div>
                    <div class="font-bold">RP 0.00</div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="">Sub Total :</div>
                    <div class="font-bold">RP 0.00</div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2">
                        Notes :
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#notesModal"
                            class="flex items-center gap-1.5 rounded-md border border-0 border-solid border-neutral-400 bg-transparent px-1 py-1 shadow-md"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="14"
                                height="14"
                                fill="currentColor"
                                class="bi bi-pencil-square"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex items-end justify-end gap-2">
                    <div class="">Tax (11%) :</div>
                    <div class="font-bold">RP 0.00</div>
                </div>
                <div class="flex items-end justify-end gap-2">
                    <div class="flex items-center gap-2">
                        Discount
                        <PrimaryButton
                            @click="showDiscountModal = true"
                            class="flex items-center gap-1.5 rounded-md border border-solid border-neutral-400 bg-transparent px-1 py-1 shadow-md"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="14"
                                height="14"
                                fill="currentColor"
                                class="bi bi-tag-fill"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"
                                ></path>
                            </svg>
                        </PrimaryButton>
                        :
                    </div>
                    <div class="font-bold">RP 0.00</div>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <div class="">Gross Total :</div>
                    <div class="font-extrabold">RP 0.00</div>
                </div>
            </div>
        </div>
        <div class="h-auto w-full select-none px-4 pb-4 pt-3 text-center">
            <div class="text-blue-gray-700 mb-3 flex text-lg font-semibold">
                <div>TOTAL</div>
                <div class="w-full text-right">
                    {{ cartStore.totalCost }}
                </div>
            </div>
            <div
                class="text-blue-gray-700 bg-blue-gray-50 mb-3 rounded-lg px-3 pb-3 pt-2"
            >
                <div class="flex text-lg font-semibold">
                    <div class="flex-grow text-left">CASH</div>
                    <div class="flex text-right">
                        <div class="mr-2">Rp</div>
                        <input
                            v-model="cartStore.cash"
                            class="w-28 rounded-lg bg-white px-2 text-right shadow focus:bg-white focus:shadow-lg focus:outline-none dark:bg-gray-900"
                            type="text"
                        />
                    </div>
                </div>
                <hr class="my-2" />
                <div class="mt-2 grid grid-cols-4 gap-2">
                    <div
                        v-for="money in moneys"
                        :key="money"
                        class="ccursor-pointer rounded-lg bg-white px-2 py-1 text-sm shadow hover:shadow-lg focus:outline-none dark:bg-gray-900"
                        @click="cartStore.addCash(money)"
                    >
                        +<span>{{ money }}</span>
                    </div>
                </div>
            </div>
            <div
                v-if="cartStore.change > 0"
                class="text-blue-gray-700 mb-3 flex rounded-lg bg-cyan-50 px-3 py-2 text-lg font-semibold"
            >
                <div class="text-cyan-800">CHANGE</div>
                <div class="flex-grow text-right text-cyan-600">
                    {{ cartStore.change }}
                </div>
            </div>
            <div
                v-if="cartStore.change < 0"
                class="text-blue-gray-700 mb-3 flex rounded-lg bg-pink-100 px-3 py-2 text-lg font-semibold"
            >
                <div class="flex-grow text-right text-pink-600">
                    {{ cartStore.change }}
                </div>
            </div>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="w-full rounded-2xl py-3 text-lg text-white focus:outline-none"
                @click="posSubmit"
            >
                SUBMIT
            </PrimaryButton>
            <AddonServicesModal />
            <DiscountModal />
            <CustomerModal />
        </div>
    </div>
</template>
