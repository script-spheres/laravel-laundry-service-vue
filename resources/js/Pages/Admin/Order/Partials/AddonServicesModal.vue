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
import { inject, Ref } from 'vue';

// Inject the provided values
const addonServices = inject('addonServices') as AddonService[];
const showAddonServiceModal = inject('showAddonServiceModal') as Ref<boolean>;

// Access POS store
const posStore = usePosStore();

const handleClose = () => {
    showAddonServiceModal.value = false;
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
    <Modal :show="showAddonServiceModal" @close="handleClose" class="p-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Select A Service Type
        </h2>
        <!-- Addon Services Table -->
        <DataTable>
            <TableHead>
                <TableHeadCell>Addon Service</TableHeadCell>
                <TableHeadCell>Price</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow
                    v-for="addonService in addonServices"
                    :key="addonService.id"
                >
                    <TableCell>{{ addonService.name }}</TableCell>
                    <TableCell>{{ addonService.price }}</TableCell>
                    <TableCell class="flex justify-end gap-2">
                        <PrimaryButton
                            @click="addToCart(addonService, 'addon')"
                        >
                            Add
                        </PrimaryButton>
                        <DangerButton
                            @click="removeCart(addonService, 'addon')"
                        >
                            Remove
                        </DangerButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
    </Modal>
</template>
