<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { usePosStore } from '@/Stores/PosStore';
import { useForm } from '@inertiajs/vue3';
import { inject, Ref, ref } from 'vue';

const posStore = usePosStore();

const showPaymentModal = inject('showPaymentModal') as Ref<boolean>;

const closeModal = () => {
    showPaymentModal.value = false;
};

const paymentMode = ref('Cash');

const form = useForm({
    password: '',
});

const setPaymentMode = (mode: any) => {
    paymentMode.value = mode;
};
</script>

<template>
    <Modal :show="showPaymentModal" @close="closeModal">
        <div class="p-6">
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
                        <!--                <input-->
                        <!--                    v-model="posStore.cash"-->
                        <!--                    type="text"-->
                        <!--                    class="w-24 rounded-md bg-gray-100 px-2 py-1 text-right shadow focus:ring focus:ring-blue-200"-->
                        <!--                />-->
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
                class="w-full"
            >
                SUBMIT
            </PrimaryButton>
        </div>
    </Modal>
</template>
