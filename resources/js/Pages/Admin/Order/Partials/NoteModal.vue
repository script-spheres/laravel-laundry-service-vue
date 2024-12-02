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
import { AddonService } from '@/types';
import { inject, Ref } from 'vue';

const addonServices = inject('addonServices') as AddonService[];
const showAddonServiceModal = inject('showAddonServiceModal') as Ref<boolean>;

const posStore = usePosStore();

const handleClose = () => {
    showAddonServiceModal.value = false;
};

const isInCart = (id: number) => {
    return posStore.addonItems.some((item) => item.id === id);
};

const toggleCartItem = (item: AddonService) => {
    if (isInCart(item.id)) {
        posStore.removeAddonItem(item.id);
    } else {
        posStore.addAddonItem({
            id: item.id,
            name: item.name,
            price: item.price,
        });
    }
};
</script>

<template>
    <Modal :show="showAddonServiceModal" @close="handleClose">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Select An Addon Service
            </h2>
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
                            <template v-if="isInCart(addonService.id)">
                                <DangerButton
                                    @click="toggleCartItem(addonService)"
                                >
                                    Remove
                                </DangerButton>
                            </template>
                            <template v-else>
                                <PrimaryButton
                                    @click="toggleCartItem(addonService)"
                                >
                                    Add
                                </PrimaryButton>
                            </template>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </DataTable>
        </div>
    </Modal>
</template>
