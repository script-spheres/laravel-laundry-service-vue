<script lang="ts" setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import { PropType } from 'vue';
interface ServiceEntry {
    service_id: string;
    category_id: string;
    unit_id: string;
    price: string;
    quantity: string;
}

const model = defineModel<ServiceEntry[]>({
    required: true,
    default: () => [
        {
            service_id: '',
            category_id: '',
            unit_id: '',
            price: '',
            quantity: '',
        },
    ],
});

const props = defineProps({
    serviceOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    categoryOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    unitOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const addServiceEntry = () => {
    model.value.push({
        service_id: '',
        category_id: '',
        unit_id: '',
        price: '',
        quantity: '',
    });
};

const removeServiceEntry = (index: number) => {
    model.value.splice(index, 1);
};
</script>

<template>
    <div class="mb-6">
        <label class="mb-2 block text-sm font-medium text-gray-700">
            Service Prices
        </label>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Service</th>
                        <th class="px-4 py-2 text-left">Category</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Quantity</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(entry, index) in model"
                        :key="index"
                        class="border-b"
                    >
                        <td class="py-2">
                            <InputSelect
                                v-model="entry.service_id"
                                :options="props.serviceOptions"
                            />
                        </td>
                        <td class="py-2">
                            <InputSelect
                                v-model="entry.category_id"
                                :options="props.categoryOptions"
                            />
                        </td>
                        <td class="py-2">
                            <InputText
                                type="number"
                                v-model="entry.price"
                                placeholder="Enter price"
                            />
                        </td>
                        <td class="flex items-center gap-1 py-2">
                            <InputText
                                type="number"
                                v-model="entry.quantity"
                                placeholder="Enter quantity"
                            />
                            <span>/</span>
                            <InputSelect
                                class="w-20"
                                v-model="entry.unit_id"
                                :options="props.unitOptions"
                            />
                        </td>
                        <td class="px-4 py-2">
                            <PrimaryButton
                                v-if="model.length > 1"
                                @click.prevent="removeServiceEntry(index)"
                                color="danger"
                                type="button"
                            >
                                Remove
                            </PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <PrimaryButton @click.prevent="addServiceEntry" type="button">
                Add Service Price
            </PrimaryButton>
        </div>
    </div>
</template>
