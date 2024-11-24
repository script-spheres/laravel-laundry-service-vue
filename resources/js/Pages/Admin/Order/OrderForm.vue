<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PosRightSidebar from '@/Pages/Admin/Pos/Partials/PosRightSidebar.vue';
import { usePosStore } from '@/Stores/PosStore';
import { Category, Product } from '@/types';
import { router } from '@inertiajs/vue3';
import { PropType, reactive, watch } from 'vue';

defineOptions({ layout: AdminLayout });

const cartStore = usePosStore();

const props = defineProps({
    categories: {
        type: Object as PropType<Category[]>,
        required: true,
    },
    products: {
        type: Object as PropType<Product[]>,
        required: true,
    },
    filters: Object as PropType<Filters>,
});

const filter = reactive<Filters>({
    search: props.filters?.name ?? '',
    category_id: props.filters?.category_id ?? '',
});

const navigateToCategory = (categoryId: number) => {
    filter.category_id = categoryId;
};

const handleClearFilter = () => {
    Object.keys(filter).forEach((key) => (filter[key as keyof Filters] = ''));
};

watch(filter, (newFilters) => {
    const { name, category_id, active_status } = newFilters;

    const filterParams: Record<string, string> = {
        ...(name && { 'filter[name]': name }),
        ...(category_id && { 'filter[category_id]': category_id }),
        ...(active_status && { 'filter[active_status]': active_status }),
    };

    router.get(route('admin.orders.create'), filterParams, {
        preserveScroll: true,
    });
});
</script>

<template>
    <div>
        <div class="grid grid-cols-3">
            <!-- Left Sidebar -->
            <div class="col-span-2 flex flex-col p-2">
                <div class="mb-2 flex gap-2">
                    <TextInput
                        v-model="filter.search"
                        class="w-full rounded-md bg-white text-lg shadow transition-shadow focus:shadow-2xl focus:outline-none"
                        placeholder="Cari menu ..."
                    />
                    <PrimaryButton @click="handleClearFilter">
                        Reset
                    </PrimaryButton>
                </div>

                <!-- Store Menu -->
                <div class="flex">
                    <div class="w-1/6 overflow-y-auto">
                        <ul>
                            <li
                                v-for="(category, index) in categories"
                                :key="index"
                                class="py-1 text-base font-medium"
                            >
                                <PrimaryButton
                                    class="w-full px-2 py-2"
                                    @click="navigateToCategory(category.id)"
                                >
                                    {{ category.name }}
                                </PrimaryButton>
                            </li>
                        </ul>
                    </div>

                    <div class="w-5/6 px-2">
                        <div
                            v-if="products?.length"
                            class="grid grid-cols-2 gap-2 pb-3 sm:grid-cols-6 md:grid-cols-6 lg:grid-cols-6"
                        >
                            <div
                                v-for="product in products"
                                :key="product.id"
                                :title="product.title"
                                class="cursor-pointer select-none overflow-hidden rounded-xl bg-white shadow hover:shadow-lg dark:bg-gray-900 dark:text-gray-200"
                                role="button"
                                @click="cartStore.addItem(product)"
                            >
                                <img
                                    :alt="product.title"
                                    :src="product?.image?.url"
                                    class="h-40 w-full"
                                />
                                <div class="px-3 pb-3 text-sm">
                                    <p class="truncate">{{ product.title }}</p>
                                    <p class="font-semibold">
                                        {{ product.market_price }}
                                    </p>
                                    <p class="font-semibold">
                                        {{ product.selling_price }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            v-else
                            class="flex h-full select-none flex-wrap content-center justify-center rounded-xl bg-gray-100 opacity-25"
                        >
                            <div class="w-full text-center text-xl">
                                YOU DON'T HAVE ANY PRODUCTS TO SHOW
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Store Menu -->
            </div>
            <!-- End of Left Sidebar -->

            <!-- Right Sidebar -->
            <div class="col-span-1 flex h-screen flex-col">
                <PosRightSidebar />
            </div>
            <!-- End of Right Sidebar -->
        </div>
    </div>
</template>
