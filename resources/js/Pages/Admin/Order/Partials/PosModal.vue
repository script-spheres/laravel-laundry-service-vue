<script setup lang="ts">
import Modal from '@/Components/modal/Modal.vue';
import { nextTick, ref } from 'vue';
import PrimaryButton from '../@/Components/Buttons/PrimaryButton.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { usePosStore } from '@/stores/PosStore.ts';

const cartStore = usePosStore();

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
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
