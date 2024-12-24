<script setup lang="ts">
import InputLabel from '@/Components/Form/InputLabel.vue';
import { icons } from '@/Components/Icons/icon';
import { computed, ref, useId } from 'vue';

const model = defineModel({ required: true });

const props = defineProps({
    label: String,
    error: String,
});

const emit = defineEmits(['update:modelValue']);
const id = useId();

const searchQuery = ref('');
const isModalOpen = ref(false);

const filteredIcons = computed(() =>
    icons.filter((icon) =>
        icon.name.toLowerCase().includes(searchQuery.value.toLowerCase()),
    ),
);

const selectIcon = (iconName: string) => {
    emit('update:modelValue', iconName);
    isModalOpen.value = false;
};
</script>

<template>
    <InputLabel v-if="label" :for="`label-${id}`">{{ label }}</InputLabel>

    <!-- Trigger Button -->
    <button
        @click="isModalOpen = true"
        class="mb-4 rounded bg-indigo-600 px-4 py-2 text-white"
    >
        Choose Icon
    </button>

    <!-- Display Selected Icon -->
    <div v-if="model" class="flex items-center gap-2">
        <div
            v-html="icons.find((icon) => icon.name === model)?.svg"
            class="h-6 w-6"
        ></div>
        <span>{{ model }}</span>
    </div>

    <!-- Modal -->
    <div
        v-if="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-11/12 max-w-md rounded bg-white p-6 shadow-lg">
            <!-- Modal Header -->
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold">Pick an Icon</h2>
                <button @click="isModalOpen = false" class="text-gray-500">
                    ✖
                </button>
            </div>

            <!-- Search Input -->
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search icons..."
                class="mb-4 w-full rounded border p-2"
            />

            <!-- Icon Grid -->
            <div class="grid grid-cols-3 gap-4">
                <div
                    v-for="icon in filteredIcons"
                    :key="icon.name"
                    @click="selectIcon(icon.name)"
                    class="cursor-pointer rounded border p-2 text-center"
                    :class="{
                        'border-indigo-500 bg-indigo-100': icon.name === model,
                        'border-gray-300': icon.name !== model,
                    }"
                >
                    <div v-html="icon.svg" class="mx-auto h-6 w-6"></div>
                    <span class="mt-1 text-xs">{{ icon.name }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
