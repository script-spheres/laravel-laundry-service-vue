<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useInputClasses } from '@/Composables/useInputClasses';
import { useId } from 'vue';

const id = useId();
const model = defineModel<string | number | null>({ required: true });

const props = defineProps({
    label: { type: String, required: false },
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: { type: String, required: false },
});

const { inputClasses } = useInputClasses({
    size: props.size,
});
</script>

<template>
    <InputLabel
        v-if="props.label"
        :for="`input-${id}`"
        :data-test-id="`label-${id}`"
    >
        {{ props.label }} :
    </InputLabel>

    <input
        :class="inputClasses"
        v-model="model"
        type="radio"
        :id="`input-${id}`"
        :data-test-id="`input-${id}`"
        v-bind="{ ...$attrs }"
    />

    <InputError v-if="props.error" :message="props.error" />
</template>
