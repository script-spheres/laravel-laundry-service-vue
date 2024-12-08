<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputNumber from '@/Components/Form/InputNumber.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import { defineModel, PropType } from 'vue';

defineProps({
    serviceTypeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const model = defineModel<{ service_type_id: string; price: string }[]>({
    required: true,
    default: () => [{ service_type_id: '', price: '' }],
});

const addNutritionalInfo = () => {
    model.value.push({ service_type_id: '', price: '' });
};

const removeNutritionalInfo = (index: number) => {
    model.value.splice(index, 1);
};
</script>

<template>
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">
            Service Price
        </label>
        <div class="space-y-2">
            <div
                v-for="(info, index) in model"
                :key="index"
                class="flex items-center space-x-2"
            >
                <InputSelect
                    v-model="info.service_type_id"
                    type="text"
                    :options="serviceTypeOptions"
                />
                <InputNumber
                    v-model="info.price"
                    type="text"
                    :placeholder="'Enter price ' + (index + 1)"
                />
                <PrimaryButton
                    v-if="model.length > 1"
                    @click.prevent="removeNutritionalInfo(index)"
                    type="button"
                >
                    Remove
                </PrimaryButton>
            </div>
            <PrimaryButton @click.prevent="addNutritionalInfo" type="button">
                Add Nutrient
            </PrimaryButton>
        </div>
    </div>
</template>
