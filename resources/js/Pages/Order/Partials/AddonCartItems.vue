<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { usePosStore } from '@/Stores/PosStore';
import { AkCart, AkTrashCan, BxPackage } from '@kalimahapps/vue-icons';
import { computed, inject, Ref } from 'vue';

const posStore = usePosStore();
const showAddonServiceModal = inject('showAddonServiceModal') as Ref<boolean>;

// Using computed to reactively access addon items and total count
const addonItems = computed(() => posStore.getItemsByType('addon-service'));
const totalAddonItems = computed(() =>
    posStore.totalItemsByType('addon-service'),
);
</script>

<template>
    <div class="flex justify-between rounded-lg bg-gray-200 p-2">
        <div class="flex gap-4">
            <p class="text-xl font-bold">Addon Items</p>
            <div class="relative text-left text-lg">
                <AkCart class="h-6 w-6" />
                <div
                    v-if="totalAddonItems > 0"
                    class="absolute -right-2 top-3 h-5 w-5 rounded-full bg-cyan-500 p-0 text-center text-xs leading-5 text-white"
                >
                    {{ totalAddonItems }}
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <PrimaryButton @click="showAddonServiceModal = true" size="sm">
                <BxPackage class="h-4 w-4" />
            </PrimaryButton>
            <PrimaryButton
                @click="posStore.clearItemCartByType('addon-service')"
                size="sm"
                color="red"
            >
                <AkTrashCan class="h-4 w-4" />
            </PrimaryButton>
        </div>
    </div>

    <div v-if="addonItems.length" class="w-full flex-1 overflow-auto">
        <div
            v-for="addon in addonItems"
            :key="addon.id"
            class="mb-1 flex w-full items-center rounded-lg bg-white p-2 shadow"
        >
            <div class="flex-grow">
                <h5 class="text-sm font-semibold">{{ addon.service_name }}</h5>
                <p class="text-xs text-gray-500">Price: {{ addon.price }}</p>
            </div>
            <div class="ml-2 flex items-center gap-2">
                <PrimaryButton
                    color="red"
                    @click="posStore.removeItem(addon.id)"
                >
                    <AkTrashCan class="h-4 w-4" />
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
