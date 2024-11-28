<script lang="ts" setup>
import { computed } from 'vue';

const rangeDefaultClasses =
    'w-full h-2 bg-gray-200 rounded-lg cursor-pointer dark:bg-gray-700';
const rangeLabelClasses =
    'block mb-2 text-sm font-medium text-gray-900 dark:text-white';

const props = withDefaults(
    defineProps<{
        disabled?: boolean;
        max?: number;
        min?: number;
        modelValue?: number;
        steps?: number;
    }>(),
    {
        disabled: false,
        max: 100,
        min: 0,
        modelValue: 50,
        steps: 1,
    },
);

const emit = defineEmits(['update:modelValue']);

const model = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val),
});

// Default range classes
const rangeClasses = computed(() => `${rangeDefaultClasses}`);
</script>

<template>
    <label class="flex flex-col">
        <span :class="rangeLabelClasses">Range slider</span>
        <input
            v-model="model"
            :step="props.steps"
            :min="props.min"
            :max="props.max"
            :disabled="props.disabled"
            type="range"
            :class="rangeClasses"
        />
    </label>
    <p v-show="$attrs.error" class="text-sm text-red-600 dark:text-red-400">
        {{ $attrs.error }}
    </p>
</template>
