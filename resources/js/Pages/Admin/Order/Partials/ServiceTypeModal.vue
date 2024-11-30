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
import { AddonService, ServiceItem } from '@/types';
import { inject, Reactive, Ref } from 'vue';

// Inject the provided values
const showServiceTypeModal = inject('showServiceTypeModal') as Ref<boolean>;
const selectedServiceItem = inject('selectedServiceItem') as Reactive<
    ServiceItem | {}
>;

// Access POS store
const posStore = usePosStore();

const handleClose = () => {
    showServiceTypeModal.value = false;
};

const addToCart = (
    item: ServiceItem | AddonService,
    type: 'service' | 'addon',
) => {
    posStore.addItem({
        id: item.id,
        name: item.name,
        price:
            type === 'service'
                ? parseFloat(item.service_prices?.[0]?.price || '0')
                : (item as AddonService).price,
        type,
    });
    console.log('Added to cart:', item);
};

const removeCart = (
    item: ServiceItem | AddonService,
    type: 'service' | 'addon',
) => {
    posStore.removeItem(item.id, type);
    console.log('Removed from cart:', item);
};
</script>

<template>
    <Modal :show="showServiceTypeModal" @close="handleClose" class="p-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Select A Service Type
        </h2>

        <!-- Service Prices Table -->
        <DataTable>
            <TableHead>
                <TableHeadCell>Service Type</TableHeadCell>
                <TableHeadCell>Price</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="servicePrice in selectedServiceItem?.service_prices ??
                    []"
                    :key="servicePrice.id"
                >
                    <TableCell>{{ servicePrice.service_type.name }}</TableCell>
                    <TableCell>{{ servicePrice.price }}</TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <PrimaryButton
                            @click="addToCart(servicePrice, 'service')"
                        >
                            Add
                        </PrimaryButton>
                        <DangerButton
                            @click="removeCart(servicePrice, 'service')"
                        >
                            Remove
                        </DangerButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
    </Modal>
</template>
