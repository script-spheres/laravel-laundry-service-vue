<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { usePosStore } from '@/Stores/PosStore';
import { ServiceDetail } from '@/types';

defineProps<{
    serviceDetails: ServiceDetail[];
}>();

const posStore = usePosStore();

const toggleCartItem = (item: ServiceDetail) => {
    if (isInCart(item.id)) {
        posStore.removeItem(item.id);
    } else {
        posStore.addItem({
            id: item.id,
            serviceable_type: 'service',
            serviceable_id: item.id,
            info: {
                service_name: `${item?.service_item?.name} (${item?.service_item?.name})`,
                service_image: item?.service_item?.image,
                color: '#000000',
                unit_name: item.unit.short_name,
            },
            price: item.price,
            quantity: 1,
        });
    }
};

// Check if the item is in the cart
const isInCart = (id: number) => {
    return posStore.itemIsCartByType(id, 'service');
};
</script>

<template>
    <ul class="space-y-2">
        <li
            v-for="item in serviceDetails"
            :key="item.id"
            class="flex items-center space-x-2 rounded-lg bg-white p-2 shadow transition-all duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
        >
            <img
                :alt="item?.service_item?.image?.basename"
                :src="item?.service_item?.image?.url"
                class="h-12 w-12 rounded-lg object-cover"
            />
            <div class="w-full">
                <p
                    class="text-sm font-semibold text-gray-800 dark:text-gray-200"
                >
                    {{ item?.service_item?.name }} ({{ item?.category?.name }})
                </p>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    Price: {{ item?.price }} {{ item?.quantity }} /
                    {{ item?.unit?.actual_name }}
                </p>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    {{
                        item?.service_item?.description ||
                        'No description available.'
                    }}
                </p>
            </div>
            <div>
                <PrimaryButton
                    :color="isInCart(item.id) ? 'red' : 'gray'"
                    @click="toggleCartItem(item)"
                >
                    {{ isInCart(item.id) ? 'Del' : 'Add' }}
                </PrimaryButton>
            </div>
        </li>
    </ul>
</template>
