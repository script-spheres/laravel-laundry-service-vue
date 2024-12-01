<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { usePosStore } from '@/Stores/PosStore';
import { AkCart, AkTrashCan, BxPackage } from '@kalimahapps/vue-icons';

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
    <div class="flex justify-between p-4">
        <p class="text-xl font-bold">Addon Items</p>
        <div class="flex gap-4">
            <div class="relative text-left text-lg">
                <AkCart class="h-6 w-6" />
                <div
                    v-if="posStore.totalAttonItems > 0"
                    class="absolute -right-2 top-3 h-5 w-5 rounded-full bg-cyan-500 p-0 text-center text-xs leading-5 text-white"
                >
                    {{ posStore.totalAddonItems }}
                </div>
            </div>
            <div class="text-right">
                <button
                    @click="showAddonServiceModal = true"
                    class="rounded-md bg-blue-500 p-1.5 text-white shadow hover:bg-blue-600"
                >
                    <BxPackage />
                </button>
                <PrimaryButton
                    class="hover:text-pink-500 focus:outline-none"
                    @click="posStore.clearAddonCart()"
                >
                    <AkTrashCan class="inline-block h-6 w-6" />
                </PrimaryButton>
            </div>
        </div>
    </div>

    <div
        v-if="posStore.addonItems.length"
        class="w-full flex-1 overflow-auto px-4"
    >
        <div
            v-for="addon in posStore.addonItems"
            :key="addon.id"
            class="mb-1 flex w-full items-center rounded-lg bg-white p-2 shadow"
        >
            <div class="flex-grow">
                <h5 class="text-sm font-semibold">{{ addon.name }}</h5>
                <p class="text-xs text-gray-500">Price: {{ addon.price }}</p>
            </div>
            <div class="ml-2 flex items-center gap-2">
                <PrimaryButton
                    class="px-1 py-1 text-red-600"
                    @click="posStore.removeAddonItem(addon.id)"
                >
                    <AkTrashCan class="h-4 w-4" />
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
