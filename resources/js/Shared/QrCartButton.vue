<script setup lang="ts">
import { useQrCartStore } from '@/Stores/QrCartStore';

const cartStore = useQrCartStore();

defineProps({
    product: Object,
});
</script>

<template>
    <div
        v-if="cartStore.hasCart(product.id)"
        class="-mt-4 ml-0 flex justify-start gap-2 md:justify-start lg:ml-2 lg:justify-items-start"
    >
        <div
            class="ml-2 mt-[2px] flex w-24 justify-center space-x-3 rounded-lg border border-orange-500 bg-white px-1 py-0.5 text-sm font-semibold text-orange-600 md:ml-[8px] lg:ml-0 lg:mt-0"
        >
            <button type="button" @click="cartStore.removeItem(product)">
                <svg
                    aria-label="Decrease quantity to 0"
                    class="text-gray-400"
                    height="1.2em"
                    viewBox="0 0 24 24"
                    width="1.2em"
                >
                    <path d="M19 13H5v-2h14v2Z" fill="currentColor"></path>
                </svg>
            </button>
            <div>
                <span aria-hidden="true" class="font-semibold">
                    {{ cartStore.getItem(product.id).quantity }}
                </span>
            </div>
            <button type="button" @click="cartStore.addItem(product)">
                <svg
                    aria-label="Increase quantity to 2"
                    height="1.2em"
                    viewBox="0 0 24 24"
                    width="1.2em"
                >
                    <path
                        d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2Z"
                        fill="currentColor"
                    ></path>
                </svg>
            </button>
        </div>
    </div>
    <button
        v-else
        class="absolute bottom-[-10px] left-2 w-24 rounded-lg border border-orange-500 bg-white px-4 py-1 text-xs font-semibold tracking-widest text-orange-500 hover:bg-orange-500 hover:text-white"
        title="Add item"
        @click="cartStore.addItem(product)"
    >
        <svg
            class="inline-flex"
            height="1.2em"
            viewBox="0 0 24 24"
            width="1.2em"
        >
            <path
                d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2Z"
                fill="currentColor"
            ></path>
        </svg>
        ADD
    </button>
</template>
