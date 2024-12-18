<script setup lang="ts">
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import RadioInput from '@/Components/Form/InputRadio.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { usePosStore } from '@/Stores/PosStore';
import { Coupon } from '@/types';
import { inject, PropType, Ref } from 'vue';

defineProps({
    coupons: {
        type: Object as PropType<Coupon[]>,
        required: false,
    },
});

// Inject provided values
const showDiscountModal = inject('showDiscountModal') as Ref<boolean>;

// Access POS store
const posStore = usePosStore();

// Close Modal
const handleClose = () => {
    showDiscountModal.value = false;
};

// Add Coupon to Cart
const applyCoupon = (coupon: Coupon) => {
    console.log('Coupon apply:', coupon);
};
</script>

<template>
    <Modal :show="showDiscountModal" @close="handleClose">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Apply a Coupon
            </h2>
            <!-- Coupons Table -->
            <DataTable>
                <TableHead>
                    <TableHeadCell>Coupon Code</TableHeadCell>
                    <TableHeadCell>Discount</TableHeadCell>
                    <TableHeadCell class="text-right">Actions</TableHeadCell>
                </TableHead>
                <TableBody>
                    <TableRow v-for="coupon in coupons" :key="coupon.id">
                        <TableCell>{{ coupon.code }}</TableCell>
                        <TableCell>{{ coupon.discount_type }}</TableCell>
                        <TableCell>{{ coupon.discount_amount }}</TableCell>
                        <TableCell>{{ coupon.discount_percentage }}%</TableCell>
                        <TableCell class="flex justify-end gap-2">
                            <RadioInput @click="applyCoupon(coupon)">
                                Apply
                            </RadioInput>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </DataTable>
        </div>
    </Modal>
</template>
