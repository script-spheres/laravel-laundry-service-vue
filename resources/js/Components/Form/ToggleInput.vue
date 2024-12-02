<script setup lang="ts">
import { ref } from 'vue';

const model = defineModel<String | Boolean>({ required: true });

// Define emits for v-model
const emit = defineEmits(['update:modelValue']);

// Ref for Input element
const input = ref(null);

// Toggle the value when checkbox changes
const handleChange = () => {
    emit('update:modelValue', input.value.checked);
};
</script>

<template>
    <label class="inline-flex cursor-pointer items-center">
        <input
            v-bind="{ ...$props, ...$attrs }"
            ref="input"
            type="checkbox"
            :checked="model"
            @change="handleChange"
            class="peer sr-only h-6 w-11 appearance-none"
        />
        <div
            class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full"
        ></div>
    </label>
    <p v-show="$attrs.error" class="text-sm text-red-600 dark:text-red-400">
        {{ $attrs.error }}
    </p>
</template>
