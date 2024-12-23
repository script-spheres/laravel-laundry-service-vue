<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';

// Define the model as a boolean
const model = defineModel<String | Boolean>({ required: true });

defineProps({
    label: { type: String, required: false },
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: { type: String, required: false },
});
</script>

<template>
    <label class="inline-flex cursor-pointer items-center">
        <input
            type="checkbox"
            v-model="model"
            class="peer sr-only h-6 w-11 appearance-none"
        />
        <div
            class="peer relative h-6 w-11 rounded-full bg-gray-200 transition-colors after:absolute after:start-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-transform after:content-[''] peer-checked:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-gray-300 dark:bg-gray-700 dark:peer-checked:bg-gray-500 dark:peer-focus:ring-gray-800"
        ></div>
    </label>
    <InputError v-if="error" :message="error" />
</template>
