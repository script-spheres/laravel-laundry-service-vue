<script setup lang="ts">
import { useId } from 'vue';

const model = defineModel<string | number | null>({ required: true });

const props = defineProps({
    name: { type: String, required: false },
    value: { type: [String, Number], required: false },
    label: { type: String, required: true },
    disabled: { type: Boolean, default: false },
});

const id = useId();
</script>

<template>
    <div>
        <input
            type="radio"
            :id="`inline-radio-${id}`"
            class="peer hidden"
            v-model="model"
            :disabled="props.disabled"
            :name="props.name"
            :value="props.value"
        />
        <label
            :for="`inline-radio-${id}`"
            class="inline-flex w-full cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-2 text-gray-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:bg-gray-100 hover:text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-gray-300"
        >
            {{ props.label }}
        </label>
    </div>
</template>
