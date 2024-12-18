<script setup lang="ts">
import Modal from '@/Components/Modal/Modal.vue';
import { usePosStore } from '@/Stores/PosStore';
import { AddonService } from '@/types';
import { inject, Ref } from 'vue';

const showAddonServiceModal = inject('showAddonServiceModal') as Ref<boolean>;

const posStore = usePosStore();

const handleClose = () => {
    showAddonServiceModal.value = false;
};

const isInCart = (id: number) => {
    return posStore.addonItems.some((item) => item.id === id);
};
</script>

<template>
    <Modal :show="showAddonServiceModal" @close="handleClose">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Select An Addon Service
            </h2>
            <form action="#">
                <div class="row">
                    <div class="col-12">
                        <div class="">
                            <ul>
                                <li
                                    class="d-flex align-items-center tw-justify-between tw-w-full mb-12 gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                        >Customer :</span
                                    >
                                    <span class="text-secondary-light fw-medium"
                                        >onkar</span
                                    >
                                </li>
                                <li
                                    class="d-flex align-items-center tw-justify-between mb-12 gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                    >
                                        Order ID :</span
                                    >
                                    <span class="text-secondary-light fw-medium"
                                        >ORD-1444</span
                                    >
                                </li>
                                <li
                                    class="d-flex align-items-center tw-justify-between mb-12 gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                    >
                                        Order Date :</span
                                    >
                                    <span class="text-secondary-light fw-medium"
                                        >02/12/2024</span
                                    >
                                </li>
                                <li
                                    class="d-flex align-items-center tw-justify-between mb-12 gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                    >
                                        Delivery Date :</span
                                    >
                                    <span class="text-secondary-light fw-medium"
                                        >02/12/2024</span
                                    >
                                </li>
                                <li
                                    class="d-flex align-items-center tw-justify-between mb-12 gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                    >
                                        Order Amount :</span
                                    >
                                    <span
                                        class="text-secondary-light fw-medium"
                                    >
                                        RP 166.50</span
                                    >
                                </li>
                                <li
                                    class="d-flex align-items-center tw-justify-between mb-12 gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                    >
                                        Paid Amount :</span
                                    >
                                    <span
                                        class="text-secondary-light fw-medium"
                                    >
                                        RP 0.00</span
                                    >
                                </li>
                                <li
                                    class="d-flex align-items-center tw-justify-between gap-1"
                                >
                                    <span
                                        class="text-md fw-semibold text-primary-light"
                                    >
                                        Balance :</span
                                    >
                                    <span
                                        class="text-secondary-light fw-medium"
                                    >
                                        RP 166.50</span
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 tw-my-6">
                        <hr />
                    </div>
                    <div class="col-12 mb-20">
                        <label
                            for="name"
                            class="form-label fw-semibold text-primary-light mb-8 text-sm"
                            >Paid Amount
                            <span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control radius-8"
                            placeholder="Enter Amount"
                            wire:model="balance"
                        />
                        <!--[if BLOCK]><!
                        [endif]--><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="col-12 mb-20">
                        <label
                            for="name"
                            class="form-label fw-semibold text-primary-light mb-8 text-sm"
                            >Payment Type
                            <span class="text-danger">*</span></label
                        >
                        <select
                            class="radius-8 form-select"
                            wire:model="payment_mode"
                        >
                            <option value="">Choose Payment Type</option>
                            <option class="select-box" value="1">Cash</option>
                            <option class="select-box" value="2">UPI</option>
                            <option class="select-box" value="3">Card</option>
                            <option class="select-box" value="4">Cheque</option>
                            <option class="select-box" value="5">
                                Bank Transfer
                            </option>
                        </select>
                        <!--[if BLOCK]><!
                        [endif]--><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="col-12 mb-20">
                        <label
                            for="name"
                            class="form-label fw-semibold text-primary-light mb-8 text-sm"
                            >Notes
                        </label>
                        <textarea
                            class="form-control radius-8"
                            placeholder="Enter Notes"
                            wire:model="note"
                        ></textarea>
                        <!--[if BLOCK]><!
                        [endif]--><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div
                        class="d-flex align-items-start justify-content-end mt-24 gap-3"
                    >
                        <button
                            data-bs-dismiss="modal"
                            type="button"
                            class="border-danger-600 bg-hover-danger-200 text-danger-600 text-md radius-8 border px-40 py-11"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            wire:click.prevent="addPayment()"
                            class="btn btn-primary border-primary-600 text-md radius-8 border px-24 py-12"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
