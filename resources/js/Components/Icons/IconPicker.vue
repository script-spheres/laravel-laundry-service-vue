<script setup lang="ts">
import InputLabel from '@/Components/Form/InputLabel.vue';
import { icons } from '@/Components/Icons/icon';
import { computed, ref, useId } from 'vue';

const model = defineModel({ required: true });

const props = defineProps({
    label: { type: String, required: false },
    error: { type: String, required: false },
});

const emit = defineEmits(['update:modelValue']);
const id = useId();

const modelValue = ref('');
const searchQuery = ref('');
const isModalOpen = ref(false);

const filteredIcons = computed(() =>
    icons.filter((icon) =>
        icon.name.toLowerCase().includes(searchQuery.value.toLowerCase()),
    ),
);

const selectIcon = (iconName: string) => {
    modelValue.value = iconName;
    emit('update:modelValue', iconName);
    closeModal();
};

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>

<template>
    <InputLabel v-if="label" :for="`label-${id}`" :data-test-id="`label-${id}`">
        {{ label }} :
    </InputLabel>
    <!-- Trigger Button -->
    <button
        @click="openModal"
        class="mb-4 rounded bg-indigo-600 px-4 py-2 text-white"
    >
        <span v-if="modelValue">Selected Icon: {{ modelValue }}</span>
        <span v-else>Choose Icon</span>
    </button>

    <!-- Modal -->
    <div
        v-if="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-11/12 max-w-md rounded bg-white p-6 shadow-lg">
            <!-- Modal Header -->
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold">Pick an Icon</h2>
                <button @click="closeModal" class="text-gray-500">✖</button>
            </div>

            <!-- Search Input -->
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search icons..."
                class="search-input mb-4 w-full rounded border p-2"
            />

            <!-- Icon Grid -->
            <div class="icon-grid grid grid-cols-3 gap-4">
                <div
                    v-for="icon in filteredIcons"
                    :key="icon.name"
                    class="icon-item cursor-pointer rounded border p-2"
                    :class="{
                        'border-indigo-500 bg-indigo-100':
                            icon.name === modelValue,
                        'border-gray-300': icon.name !== modelValue,
                    }"
                    @click="selectIcon(icon.name)"
                >
                    <!-- Render SVG -->
                    <div v-html="icon.svg" class="h-6 w-6"></div>
                </div>
            </div>
        </div>
    </div>
</template>
