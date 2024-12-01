<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { usePosStore } from '@/Stores/PosStore';
import { AkCart, AkMinus, AkPlus, AkTrashCan } from '@kalimahapps/vue-icons';

const posStore = usePosStore();

const updateItemQuantity = (id: number, currentQuantity: number) => {
    if (currentQuantity > 1) {
        posStore.updateItem(id, currentQuantity);
    } else {
        posStore.removeItem(id);
    }
};
</script>

<template>
    <div class="flex flex-1 flex-col overflow-auto">
        <div class="flex justify-between p-4">
            <div class="flex gap-4">
                <p class="text-xl font-bold">Cart Items</p>
                <div class="relative text-left text-lg">
                    <AkCart class="h-6 w-6" />
                    <div
                        v-if="posStore.totalItems > 0"
                        class="absolute -right-2 top-3 h-5 w-5 rounded-full bg-cyan-500 p-0 text-center text-xs leading-5 text-white"
                    >
                        {{ posStore.totalItems }}
                    </div>
                </div>
            </div>
            <div class="text-right">
                <PrimaryButton
                    class="hover:text-pink-500 focus:outline-none"
                    @click="posStore.clearCart()"
                >
                    <AkTrashCan class="inline-block h-6 w-6" />
                </PrimaryButton>
            </div>
        </div>

        <!-- Regular Items -->
        <div
            v-if="posStore.items.length"
            class="w-full flex-1 overflow-auto px-4"
        >
            <div
                v-for="item in posStore.items"
                :key="item.id"
                class="mb-2 flex w-full items-center rounded-lg bg-white p-2 shadow"
            >
                <img
                    :src="item?.image?.url"
                    alt=""
                    class="mr-2 h-10 w-10 rounded-lg shadow"
                />
                <div class="flex-grow">
                    <h5 class="text-sm font-semibold">{{ item.name }}</h5>
                    <p class="text-xs text-gray-500">
                        Selling Price: {{ item.price }}
                    </p>
                </div>
                <div class="ml-2 flex items-center gap-2">
                    <PrimaryButton
                        class="bg-gray-600 px-2 py-1 text-white hover:bg-gray-700"
                        @click="updateItemQuantity(item.id, item.quantity + 1)"
                    >
                        <AkMinus class="h-4 w-4" />
                    </PrimaryButton>
                    <input
                        v-model="item.quantity"
                        type="text"
                        class="w-12 rounded-lg border border-gray-300 text-center text-sm shadow focus:outline-none"
                    />
                    <PrimaryButton
                        class="bg-gray-600 px-2 py-1 text-white hover:bg-gray-700"
                        @click="updateItemQuantity(item.id, item.quantity - 1)"
                    >
                        <AkPlus class="h-4 w-4" />
                    </PrimaryButton>
                    <PrimaryButton
                        class="px-2 py-1 text-red-600"
                        @click="posStore.removeItem(item.id)"
                    >
                        <AkTrashCan class="h-4 w-4" />
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>
