<script setup lang="ts">
import { onMounted, reactive } from 'vue';

import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';

const itemTypeOptions = { accessory: 'accessory', ingredient: 'Ingredient' };

const supplierOptions = reactive({});
const itemOptions = reactive({});

const form = reactive({
    supplier_id: '',
    purchase_date: '',
    invoice_no: '',
    details: '',
    items: [
        {
            item_type: '',
            item_id: '',
            qty: 0,
            rate: 0,
            total: 0,
        },
    ],
    grand_total: '',
    paid_amount: '',
});

const addItemRow = () =>
    form.items.push({
        item_type: '',
        item_id: '',
        qty: 0,
        rate: 0,
        total: 0,
    });

onMounted(async () => {
    await fetchSuppliers();

    // Populate tableOptions from the fetched tables
    suppliers.value.data.forEach((unit) => {
        supplierOptions[unit.id] = unit.name;
    });

    if (route.params.id) {
        try {
            await getPurchase(route.params.id);
            Object.assign(form, purchase.value.data);
        } catch {
            toast.error('Error loading purchase.');
        }
    }
});

const submitForm = async () => {
    try {
        route.params.id
            ? await updatePurchase(route.params.id, { ...form })
            : await createPurchase({ ...form });
        toast.success(
            `Purchase ${route.params.id ? 'updated' : 'created'} successfully!`,
        );
        await router.push({ name: 'purchase.index' });
    } catch {
        toast.error('There was an error saving the purchase.');
    }
};

const removeItemRow = (index) => form.items.splice(index, 1);

const calculateTotal = (index) => {
    const item = form.items[index];
    item.total = item.qty * item.rate;
    form.grand_total = form.items.reduce(
        (sum, item) => sum + parseFloat(item.total),
        0,
    );
};

const changeItemType = async (itemType, index) => {
    itemOptions[index] = {}; // Clear previous item options

    if (itemType === 'accessory') {
        await fetchAccessories();
        accessories.value.data.forEach((accessory) => {
            itemOptions[index][accessory.id] = accessory.name;
        });
    } else if (itemType === 'ingredient') {
        await fetchIngredients();
        ingredients.value.data.forEach((ingredient) => {
            itemOptions[index][ingredient.id] = ingredient.name;
        });
    }
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{
                        route.params.id
                            ? 'Edit Purchase'
                            : 'Create New Purchase'
                    }}
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ route.params.id ? 'existing' : 'new' }}
                purchase.
            </p>
        </div>
        <LinkButton :to="{ name: 'purchase.index' }">Back</LinkButton>
    </div>
    <form @submit.prevent="submitForm">
        <Card class="mx-auto mt-6">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel
                        for="supplier_id"
                        value="Supplier Name (optional)"
                    />
                    <SelectInput
                        v-model="form.supplier_id"
                        :options="supplierOptions"
                    />
                    <InputError :message="errors.supplier_id" class="mt-2" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="purchase_date" value="Purchase Date" />
                    <TextInput v-model="form.purchase_date" type="date" />
                    <InputError :message="errors.purchase_date" class="mt-2" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="invoice_no" value="Invoice No" />
                    <TextInput v-model="form.invoice_no" />
                    <InputError :message="errors.invoice_no" class="mt-2" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="details" value="Details" />
                    <TextareaInput v-model="form.details" />
                    <InputError :message="errors.details" class="mt-2" />
                </div>
            </div>
        </Card>
        <div class="my-6 w-full">
            <InputLabel for="items" value="Item Information" />
            <DataTable class="mt-2 w-full">
                <TableHead>
                    <TableHeadCell>Item Type</TableHeadCell>
                    <TableHeadCell>Item Name</TableHeadCell>
                    <TableHeadCell>Qty</TableHeadCell>
                    <TableHeadCell>Rate</TableHeadCell>
                    <TableHeadCell>Total</TableHeadCell>
                    <TableHeadCell class="text-right">
                        <PrimaryButton
                            color="gray"
                            size="small"
                            type="button"
                            @click="addItemRow"
                        >
                            Add Item
                        </PrimaryButton>
                    </TableHeadCell>
                </TableHead>
                <TableBody>
                    <TableRow v-for="(item, index) in form.items" :key="index">
                        <TableCell class="px-1">
                            <SelectInput
                                v-model="item.item_type"
                                :options="itemTypeOptions"
                                @change="changeItemType(item.item_type, index)"
                            />
                        </TableCell>
                        <TableCell class="px-1">
                            <SelectInput
                                v-model="item.item_id"
                                :options="itemOptions[index] || {}"
                            />
                        </TableCell>
                        <TableCell class="px-1">
                            <NumberInput
                                v-model="item.qty"
                                @input="calculateTotal(index)"
                            />
                        </TableCell>
                        <TableCell class="px-1">
                            <NumberInput
                                v-model="item.rate"
                                @input="calculateTotal(index)"
                            />
                        </TableCell>
                        <TableCell class="px-1">
                            <NumberInput v-model="item.total" disabled />
                        </TableCell>
                        <TableCell
                            class="flex items-center justify-end gap-2 px-4 py-1"
                        >
                            <PrimaryButton
                                color="red"
                                size="small"
                                type="button"
                                @click="removeItemRow(index)"
                            >
                                Delete
                            </PrimaryButton>
                        </TableCell>
                    </TableRow>
                </TableBody>
                <TableFooter>
                    <TableRow>
                        <TableCell colspan="4">Grand Total</TableCell>
                        <TableCell>
                            <NumberInput v-model="form.grand_total" disabled />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell colspan="4">Paid Amount</TableCell>
                        <TableCell>
                            <NumberInput v-model="form.paid_amount" />
                        </TableCell>
                        <TableCell></TableCell>
                    </TableRow>
                </TableFooter>
            </DataTable>
            <InputError :message="errors.items" class="mt-2" />
        </div>

        <Card class="mx-auto mt-6">
            <div class="flex flex-wrap gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    type="submit"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :to="{ name: 'purchase.index' }" color="red"
                    >Cancel</LinkButton
                >
            </div>
        </Card>
    </form>
</template>
