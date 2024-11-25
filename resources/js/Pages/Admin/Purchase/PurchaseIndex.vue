<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import DataTable from '@/Components/DataTable/DataTable.vue';
import TableBody from '@/Components/DataTable/TableBody.vue';
import TableCell from '@/Components/DataTable/TableCell.vue';
import TableHead from '@/Components/DataTable/TableHead.vue';
import TableHeadCell from '@/Components/DataTable/TableHeadCell.vue';
import TableRow from '@/Components/DataTable/TableRow.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';
import Card from '@/Components/Panel/Card.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import usePurchase from '@/services/purchase.ts';
import { onMounted, ref } from 'vue';

const { purchases, fetchPurchases, deletePurchase } = usePurchase();

const filters = ref({
    search: '',
    category: '',
});

const searchPurchases = async () => {
    await fetchPurchases(filters.value);
};

onMounted(() => {
    fetchPurchases();
});

const deleteData = async (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        await deletePurchase(id);
        await searchPurchases();
    }
};

const handleClearFilter = () => {
    Object.keys(filters.value).forEach((key) => (filters.value[key] = ''));
    searchPurchases();
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    Purchase Management
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                These companies have purchased in the last 12 months.
            </p>
        </div>

        <div class="flex items-center gap-x-3">
            <TextInput v-model="filter.search" placeholder="Search" />
            <PrimaryButton
                class="flex-none"
                color="gray"
                @click="handleClearFilter"
            >
                Clear Filter
            </PrimaryButton>
            <LinkButton :to="{ name: 'purchase.create' }"
                >Add Purchase</LinkButton
            >
        </div>
    </div>
    <div class="mx-auto mt-6">
        <Table
            class="min-w-full divide-y divide-gray-200 overflow-hidden rounded shadow dark:divide-gray-700"
        >
            <TableHead>
                <TableHeadCell>Invoice no</TableHeadCell>
                <TableHeadCell>Purchase date</TableHeadCell>
                <TableHeadCell>Total Amount</TableHeadCell>
                <TableHeadCell class="text-right">Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="purchase in purchases.data" :key="purchase.id">
                    <TableCell>{{ purchase.invoice_no }}</TableCell>
                    <TableCell>{{ purchase.purchase_date }}</TableCell>
                    <TableCell>{{ purchase.grand_total }}</TableCell>
                    <TableCell
                        class="flex items-center justify-end gap-2 px-4 py-1"
                    >
                        <LinkButton
                            :to="{
                                name: 'purchase.edit',
                                params: { id: purchase.id },
                            }"
                            color="green"
                            size="small"
                        >
                            Edit
                        </LinkButton>
                        <PrimaryButton
                            color="red"
                            size="small"
                            @click="deleteData(purchase.id)"
                        >
                            Delete
                        </PrimaryButton>
                    </TableCell>
                </TableRow>
            </TableBody>
        </DataTable>
        <Pagination :links="purchases?.meta" />
    </div>
</template>
