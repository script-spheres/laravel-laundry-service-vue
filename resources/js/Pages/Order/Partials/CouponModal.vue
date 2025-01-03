<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { useCartCalculations } from '@/Composables/useCartCalculations';
import { Coupon } from '@/types';
import { inject, PropType, Ref } from 'vue';

// Injected ref to control modal visibility
const showDiscountModal = inject('showDiscountModal') as Ref<boolean>;

// Props declaration
defineProps({
    coupons: {
        type: Array as PropType<Coupon[]>,
        required: false,
    },
});

const { getSubTotalCost, applyCoupon } = useCartCalculations();

// Handle closing of the modal
const handleClose = () => {
    showDiscountModal.value = false;
};

// Check if a coupon is applicable based on subtotal
const isCouponApplicable = (maxDiscountAmount: number) =>
    getSubTotalCost() < maxDiscountAmount;

console.log(isCouponApplicable,'isCouponApplicable');
</script>

<template>
    <Modal :show="showDiscountModal" @close="handleClose">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Apply a Coupon
            </h2>

            <!-- List of Coupons -->
            <div class="space-y-2">
                <div
                    v-for="coupon in coupons"
                    :key="coupon.id"
                    class="flex items-center justify-between border-b p-2"
                >
                    <div>
                        <div class="flex space-x-2">
                            <span class="font-medium">{{ coupon.code }}</span>
                            <p class="rounded bg-gray-300 px-2 font-medium">
                                {{ coupon.discount_type }}
                            </p>
                            <div class="text-sm text-gray-600">
                                <!-- Show discount details based on type -->
                                <span v-if="coupon.discount_type === 'flat'">
                                    Discount: ${{ coupon.max_discount_amount }}
                                </span>
                                <span
                                    v-else-if="
                                        coupon.discount_type === 'percentage'
                                    "
                                >
                                    Discount: {{ coupon.discount_percentage }}%
                                    (up to ${{ coupon.max_discount_amount }})
                                </span>
                            </div>
                        </div>
                        <p class="text-sm font-thin">
                            {{ coupon.description }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Apply Coupon Button -->
                        <PrimaryButton
                            v-if="
                                isCouponApplicable(coupon.max_discount_amount)
                            "
                            @click="
                                applyCoupon(
                                    coupon.code,
                                    coupon.max_discount_amount,
                                )
                            "
                        >
                            Apply
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
