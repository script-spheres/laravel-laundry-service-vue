<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useInputClasses } from '@/Composables/useInputClasses';
import { PropType, ref, useId } from 'vue';

const model = defineModel({ required: true });

const props = defineProps({
    options: Object as PropType<Record<string, string>>,
    label: String,
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: String,
});

const { inputClasses } = useInputClasses({ size: props.size });
const id = useId();
const input = ref<HTMLInputElement | null>(null);

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <InputLabel v-if="label" :for="id" :data-test-id="`label-${id}`">
        {{ label }}
    </InputLabel>
    <select
        ref="input"
        v-bind="$attrs"
        :id="id"
        v-model="model"
        :class="inputClasses"
        :data-test-id="`input-${id}`"
    >
        <option value="">Please select</option>
        <option v-for="(value, key) in options" :key="key" :value="key">
            {{ value }}
        </option>
    </select>
    <InputError v-if="error" :message="error" />
</template>
