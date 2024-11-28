<script setup lang="ts">
import { onMounted, ref, useId } from 'vue';

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
const id = useId();
</script>

<template>
    <label
        v-if="$attrs.label"
        :for="id"
        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
        :data-test-id="`label-${id}`"
    >
        {{ $attrs.label }} :
    </label>
    <input
        class="w-full appearance-none rounded border border-gray-200 px-3 py-2 leading-tight text-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
        v-model="model"
        ref="input"
        type="email"
        :id="id"
        :data-test-id="`input-${id}`"
        v-bind="{ ...$attrs }"
    />
    <p v-show="$attrs.error" class="text-sm text-red-600 dark:text-red-400">
        {{ $attrs.error }}
    </p>
</template>
