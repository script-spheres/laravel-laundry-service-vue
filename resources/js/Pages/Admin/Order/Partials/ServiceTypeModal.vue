<script setup lang="ts">
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { usePosStore } from '@/Stores/PosStore';
import { ServiceItem, ServicePrice } from '@/types';
import { inject, PropType, Ref } from 'vue';

// Inject values from the parent
const showServiceTypeModal = inject('showServiceTypeModal') as Ref<boolean>;

defineProps({
    selectedServiceItem: {
        type: Object as PropType<ServiceItem>,
        required: false,
    },
});

// Access the POS store
const posStore = usePosStore();

// Handle modal close
const handleClose = () => {
    showServiceTypeModal.value = false;
};

// Check if a service type is already in the cart
const isInCart = (id: number) => {
    return posStore.items.some((item) => item.id === id);
};

// Add item to cart
const addToCart = (servicePrice: ServicePrice) => {
    posStore.addItem({
        id: servicePrice.id,
        image: servicePrice.service_item?.image,
        name: servicePrice.service_type?.name,
        price: servicePrice.price,
    });
};

// Remove item from cart
const removeFromCart = (id: number) => {
    posStore.removeItem(id);
};
</script>

<template>
    <!-- Modal Wrapper -->
    <Modal :show="showServiceTypeModal" @close="handleClose">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Select a Service Type
            </h2>

            <!-- Conditional Rendering -->
            <div v-if="selectedServiceItem?.service_prices?.length > 0">
                <!-- Data Table -->
                <DataTable>
                    <TableHead>
                        <TableHeadCell>Service Type</TableHeadCell>
                        <TableHeadCell>Price</TableHeadCell>
                        <TableHeadCell class="text-right"
                            >Actions</TableHeadCell
                        >
                    </TableHead>
                    <TableBody>
                        <TableRow
                            v-for="servicePrice in selectedServiceItem.service_prices"
                            :key="servicePrice.id"
                        >
                            <TableCell>
                                {{ servicePrice.service_type?.name }}
                            </TableCell>
                            <TableCell>
                                {{ servicePrice.price }}
                            </TableCell>
                            <TableCell class="flex justify-end gap-2">
                                <!-- Conditional Add/Remove Buttons -->
                                <template v-if="isInCart(servicePrice.id)">
                                    <DangerButton
                                        @click="removeFromCart(servicePrice.id)"
                                    >
                                        Del
                                    </DangerButton>
                                </template>
                                <template v-else>
                                    <PrimaryButton
                                        @click="addToCart(servicePrice)"
                                    >
                                        Add
                                    </PrimaryButton>
                                </template>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </DataTable>
            </div>

            <!-- No Data Message -->
            <div v-else class="text-center text-gray-500 dark:text-gray-400">
                No service prices available for the selected service.
            </div>
        </div>
    </Modal>
</template>
