<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputColor from '@/Components/Form/InputColor.vue';
import { usePosStore } from '@/Stores/PosStore';
import { AkCart, AkMinus, AkPlus, AkTrashCan } from '@kalimahapps/vue-icons';
import { computed } from 'vue';

const posStore = usePosStore();
const cartItems = computed(() => posStore.getItemsByType('service'));
const totalCartItems = computed(() => posStore.totalItemsByType('service'));
</script>

<template>
    <div class="flex justify-between rounded-lg bg-gray-200 p-2">
        <div class="flex gap-4">
            <p class="text-xl font-bold">Cart Items</p>
            <div class="flex gap-4">
                <div class="relative text-left text-lg">
                    <AkCart class="h-6 w-6" />
                    <div
                        v-if="totalCartItems > 0"
                        class="absolute -right-2 top-3 h-5 w-5 rounded-full bg-cyan-500 p-0 text-center text-xs leading-5 text-white"
                    >
                        {{ totalCartItems }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <PrimaryButton
                size="sm"
                @click="posStore.clearItemCartByType('service')"
                color="red"
            >
                <AkTrashCan class="h-4 w-4" />
            </PrimaryButton>
        </div>
    </div>

    <!-- Cart Items -->
    <div class="w-full space-y-1 overflow-auto" v-if="cartItems.length > 0">
        <div
            v-for="item in cartItems"
            :key="item.id"
            class="flex items-center rounded-lg bg-white p-1 shadow"
        >
            <img
                :src="item?.service_image?.url"
                :alt="item?.service_name"
                class="mr-3 h-12 w-12 rounded-lg shadow-sm"
            />
            <div class="flex-grow">
                <h5 class="text-sm font-semibold">
                    {{ item?.service_name }}
                </h5>
                <p class="text-xs text-gray-500">Price: {{ item.price }}</p>
            </div>
            <div class="flex items-center gap-2">
                <InputColor v-model="item.color" />
                <PrimaryButton
                    class="bg-gray-600 px-2 py-1 text-white hover:bg-gray-700"
                    @click="
                        posStore.updateItemQuantity(item.id, item.quantity - 1)
                    "
                >
                    <AkMinus class="h-4 w-4" />
                </PrimaryButton>
                <input
                    v-model="item.quantity"
                    type="number"
                    min="1"
                    class="w-14 rounded-lg border p-1 text-center shadow-sm"
                />
                <PrimaryButton
                    class="bg-gray-600 px-2 py-1 text-white hover:bg-gray-700"
                    @click="
                        posStore.updateItemQuantity(item.id, item.quantity + 1)
                    "
                >
                    <AkPlus class="h-4 w-4" />
                </PrimaryButton>
                <PrimaryButton
                    color="red"
                    @click="posStore.removeItem(item.id)"
                >
                    <AkTrashCan class="h-4 w-4" />
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
