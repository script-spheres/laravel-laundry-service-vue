<script setup>
import { computed, ref, watch } from 'vue';

const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    options: {
        type: [Array, Object],
        required: true,
    },
    modelValue: {
        type: Array,
    },
});

const checkedValues = ref(props.modelValue);

const localOptions = computed(() => props.options);

watch(checkedValues, (newCheckedValues) => {
    emit('update:modelValue', newCheckedValues);
});
</script>
<template>
    <div
        class="flex flex-wrap items-center divide-x rounded border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800"
    >
        <div
            v-for="(value, key) in localOptions"
            :key="key"
            class="my-2 flex cursor-pointer items-center space-x-3 rounded-md px-4 py-2 transition-all hover:bg-gray-50 dark:hover:bg-gray-600"
        >
            <input
                type="checkbox"
                :id="key"
                :value="key"
                v-model="checkedValues"
                class="h-5 w-5 rounded-full border-gray-300 bg-gray-100 text-blue-600 transition-all focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
            />
            <label
                :for="key"
                class="text-sm font-medium text-gray-900 dark:text-gray-300"
            >
                {{ value }}
            </label>
        </div>
    </div>
</template>
