<script setup lang="ts">
import { useQrCartStore } from '@/Stores/QrCartStore';

const cartStore = useQrCartStore();
</script>

<template>
    <div
        v-if="
            route.name !== 'cart' &&
            cartStore.items.length > 0 &&
            route.name !== 'welcome'
        "
        class="fixed inset-x-0 bottom-0 mx-auto flex items-center justify-between bg-orange-600 p-5 text-sm text-white"
    >
        <div>
            <h4 class="font-semibold tracking-wide">
                {{ cartStore.totalItems }} Items | Total :
                <span> {{ cartStore.totalCost }}</span>
            </h4>
            <Link :to="{ name: 'cart' }" class="mt-1 text-xs text-gray-200">
                View Cart Items
            </Link>
        </div>
        <div class="text-sm">
            <router-link
                :to="{ name: 'cart' }"
                class="rounded bg-gray-800 px-4 py-2 text-xs font-medium text-white hover:bg-gray-900"
            >
                View Cart
                <svg
                    class="ml-2 inline-flex"
                    height="1.2em"
                    viewBox="0 0 24 24"
                    width="1.2em"
                >
                    <path
                        d="M4 11v2h12l-5.5 5.5l1.42 1.42L19.84 12l-7.92-7.92L10.5 5.5L16 11H4Z"
                        fill="currentColor"
                    ></path>
                </svg>
            </router-link>
        </div>
    </div>
    <!--    <div class="fixed inset-x-0 bottom-0 mx-auto flex items-center justify-between bg-orange-600 p-5 text-sm text-white">-->
    <!--        This store is closed currently-->
    <!--    </div>-->
</template>
