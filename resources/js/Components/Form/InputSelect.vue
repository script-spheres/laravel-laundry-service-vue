<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useInputClasses } from '@/Composables/useInputClasses';
import { PropType, useId } from 'vue';

const model = defineModel({ required: true });

const props = defineProps({
    options: {
        type: Object as PropType<Record<string, string>>,
        required: true,
    },
    label: { type: String, required: false },
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: { type: String, required: false },
});

const { inputClasses } = useInputClasses({
    size: props.size,
});

const id = useId();
</script>

<template>
    <InputLabel v-if="label" :for="`label-${id}`" :data-test-id="`label-${id}`">
        {{ label }} :
    </InputLabel>
    <select
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
