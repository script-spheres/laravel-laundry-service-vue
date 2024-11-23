<script setup>
import { useId } from 'vue';

const model = defineModel({ type: [String, Number], required: true });
defineProps({ options: { type: Object, required: true } });
const id = useId();
</script>

<template>
    <label
        v-if="$attrs.value"
        :for="id"
        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
        :data-test-id="`label-${id}`"
    >
        {{ $attrs.value }} :
    </label>
    <select
        :id="id"
        :data-test-id="`input-${id}`"
        v-model="model"
        v-bind="$attrs"
        class="w-full appearance-none rounded border border-gray-200 px-3 py-2 leading-tight text-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
    >
        <option disabled value="">Please select</option>
        <option v-for="(value, key) in options" :key="key" :value="key">
            {{ value }}
        </option>
    </select>
</template>
