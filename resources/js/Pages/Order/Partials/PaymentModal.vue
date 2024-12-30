<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputRadioBox from '@/Components/Form/InputRadioBox.vue';
import InputText from '@/Components/Form/InputText.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { inject, reactive, Ref } from 'vue';

// Define the props with types for the payments array
interface Payment {
    method: string;
    amount: number;
    date?: number;
}

// Inject the modal visibility state
const showPaymentModal = inject('showPaymentModal') as Ref<boolean>;
const model = defineModel<string | number | null | undefined>({
    required: true,
});

// Define the props for payments
const { payments } = defineProps<{
    payments: Payment[];
}>();

const closeModal = () => {
    showPaymentModal.value = false;
};

// Define available payment options
const paymentModeOptions = reactive([
    { id: 'credit_card', name: 'Credit Card' },
    { id: 'debit_card', name: 'Debit Card' },
    { id: 'paypal', name: 'PayPal' },
    { id: 'cash', name: 'Cash' },
    { id: 'bank_transfer', name: 'Bank Transfer' },
]);

// Define the form reactive state
const form = useForm({
    amount: '',
    payment_type: '',
});

// Add payment to the payments array
const addPayment = () => {
    payments.push({
        payment_type: form.payment_type,
        amount: parseFloat(form.amount),
    });

    model = payments;
    // Reset form for new input
    form.reset();
};
</script>
<template>
    <Modal :show="showPaymentModal" @close="closeModal">
        <div class="space-y-2 p-6">
            <!-- Payment Mode Section -->
            <div class="">
                <div class="mb-2 font-medium text-gray-700">Payment Mode:</div>
                <div class="flex gap-2">
                    <div
                        v-for="paymentMode in paymentModeOptions"
                        :key="paymentMode.id"
                    >
                        <InputRadioBox
                            name="inline-service-group"
                            :label="paymentMode.name"
                            :value="paymentMode.id"
                            v-model="form.payment_type"
                            class="text-lg"
                        />
                    </div>
                </div>
            </div>

            <!-- Cash Payment Section -->
            <div
                class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <span class="flex-grow text-left font-medium text-gray-600"
                        >{{  form.payment_type }}:</span
                    >
                    <div class="flex items-center">
                        <span class="mr-2 text-gray-600">Rp</span>
                        <InputText
                            v-model="form.amount"
                            type="number"
                            placeholder="Amount"
                        />
                    </div>
                </div>
            </div>

            <!-- Add Payment Button -->
            <PrimaryButton
                :class="{ 'opacity-50': form.processing }"
                :disabled="form.processing"
                class="w-full bg-blue-600 text-white transition duration-200 ease-in-out hover:bg-blue-700"
                @click="addPayment"
            >
                Add Payment
            </PrimaryButton>

            <!-- Payments List Section -->
            <div v-if="payments.length" class="mt-6">
                <h3 class="font-semibold text-gray-700">Payments List:</h3>
                <ul class="mt-2 list-disc space-y-2 pl-6">
                    <li
                        v-for="(payment, index) in payments"
                        :key="index"
                        class="text-sm"
                    >
                        <strong class="text-gray-800">{{
                            payment.method
                        }}</strong
                        >: Rp {{ payment.amount.toFixed(2) }}
                    </li>
                </ul>
            </div>

            <!-- Close Button -->
            <PrimaryButton
                @click="closeModal"
                class="w-full bg-gray-500 text-white transition duration-200 ease-in-out hover:bg-gray-600"
            >
                Close
            </PrimaryButton>
        </div>
    </Modal>
</template>
