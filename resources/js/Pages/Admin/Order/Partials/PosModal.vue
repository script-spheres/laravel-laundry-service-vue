<script setup lang="ts">
import Modal from '@/Components/modal/Modal.vue';
import { nextTick, ref } from 'vue';
import PrimaryButton from '../@/Components/Buttons/PrimaryButton.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { usePosStore } from '@/stores/PosStore.ts';

const cartStore = usePosStore();

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const paymentMode = ref('Cash');
const moneys = ref([50, 100, 200, 5000, 10000, 20000, 50000, 100000]);

const form = useForm({
    password: '',
});

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};

const setPaymentMode = (mode) => {
    paymentMode.value = mode;
};
</script>

<template>
    <!-- Payment Section -->
    <div class="mt-4">
        <div class="mb-2 font-medium text-gray-600">Payment Mode:</div>
        <div class="grid grid-cols-2 gap-2">
            <button
                @click="setPaymentMode('Cash')"
                :class="{
                            'bg-blue-600 text-white': paymentMode === 'Cash',
                        }"
                class="rounded-md bg-gray-100 py-1 text-center text-gray-600 hover:bg-blue-500 hover:text-white"
            >
                Cash
            </button>
            <button
                @click="setPaymentMode('Card')"
                :class="{
                            'bg-blue-600 text-white': paymentMode === 'Card',
                        }"
                class="rounded-md bg-gray-100 py-1 text-center text-gray-600 hover:bg-blue-500 hover:text-white"
            >
                Card
            </button>
            <button
                @click="setPaymentMode('UPI')"
                :class="{
                            'bg-blue-600 text-white': paymentMode === 'UPI',
                        }"
                class="rounded-md bg-gray-100 py-1 text-center text-gray-600 hover:bg-blue-500 hover:text-white"
            >
                UPI
            </button>
            <button
                @click="setPaymentMode('Check')"
                :class="{
                            'bg-blue-600 text-white': paymentMode === 'Check',
                        }"
                class="rounded-md bg-gray-100 py-1 text-center text-gray-600 hover:bg-blue-500 hover:text-white"
            >
                Check
            </button>
            <button
                @click="setPaymentMode('Bank Transfer')"
                :class="{
                            'bg-blue-600 text-white':
                                paymentMode === 'Bank Transfer',
                        }"
                class="col-span-2 rounded-md bg-gray-100 py-1 text-center text-gray-600 hover:bg-blue-500 hover:text-white"
            >
                Bank Transfer
            </button>
        </div>
    </div>

    <!-- Total and Cash Section -->
    <div class="mt-4 rounded-lg bg-white p-3 text-center shadow">
        <div class="flex items-center gap-2">
            <span class="flex-grow text-left font-medium">CASH:</span>
            <div class="flex items-center">
                <span class="mr-2 text-gray-600">Rp</span>
                <input
                    v-model="posStore.cash"
                    type="text"
                    class="w-24 rounded-md bg-gray-100 px-2 py-1 text-right shadow focus:ring focus:ring-blue-200"
                />
            </div>
        </div>
        <div v-if="posStore.change !== 0" class="mt-3">
            <div
                :class="{
                            'bg-cyan-50 text-cyan-600': posStore.change > 0,
                            'bg-pink-100 text-pink-600': posStore.change < 0,
                        }"
                class="rounded-lg p-2 text-sm font-semibold"
            >
                        <span>{{
                                posStore.change > 0 ? 'CHANGE' : 'DUE'
                            }}</span>
                <span class="float-right">{{ posStore.change }}</span>
            </div>
        </div>
    </div>

    <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        class="w-full rounded-2xl py-3 text-lg text-white focus:outline-none"
        @click="confirmUserDeletion"
    >
        SUBMIT
    </PrimaryButton>
    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <div class="p-6">
            <div
                id="receipt-content"
                class="w-full overflow-auto p-6 text-left text-sm"
            >
                <div class="text-center">
                    <ApplicationLogo class="mb-3 inline-block h-8 w-8" />
                    <h2 class="text-xl font-semibold">TAILWIND POS</h2>
                    <p>CABANG KONOHA SELATAN</p>
                </div>
                <div class="mt-4 flex text-xs">
                    <div class="flex-grow">
                        No: <span>TWPOS-KS-1712065496</span>
                    </div>
                    <div>02/04/24, 19.14</div>
                </div>
                <hr class="my-2" />
                <div>
                    <DataTable class="w-full text-xs">
                        <thead>
                            <tr>
                                <th class="w-1/12 py-1 text-center">#</th>
                                <th class="py-1 text-left">Item</th>
                                <th class="w-2/12 py-1 text-center">Qty</th>
                                <th class="w-3/12 py-1 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in cartStore.items" :key="item.id">
                                <td
                                    class="py-2 text-center"
                                    x-text="index+1"
                                ></td>
                                <td class="py-2 text-left">
                                    <span>{{ item.title }}</span>
                                    <br />
                                    <small>{{ item.selling_price }}</small>
                                </td>
                                <td class="py-2 text-center">
                                    {{ item.quantity }}
                                </td>
                                <td class="py-2 text-right">
                                    {{ item.item_total }}
                                </td>
                            </tr>
                        </tbody>
                    </DataTable>
                </div>
                <hr class="my-2" />
                <div>
                    <div class="flex font-semibold">
                        <div class="flex-grow">TOTAL</div>
                        <div>Rp. {{ cartStore.totalCost }}</div>
                    </div>
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow">PAY AMOUNT</div>
                        <div>Rp. {{ cartStore.cash }}</div>
                    </div>
                    <hr class="my-2" />
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow">CHANGE</div>
                        <div>Rp. {{ cartStore.change }}</div>
                    </div>
                </div>
            </div>
            <div class="w-full p-4">
                <PrimaryButton
                    class="w-full rounded-2xl px-4 py-3 text-lg text-white focus:outline-none"
                    @click=""
                >
                    PROCEED
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
