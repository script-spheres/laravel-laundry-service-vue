<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useInputClasses } from '@/Composables/useInputClasses';
import { useId } from 'vue';

const model = defineModel<string | number | null>({ required: true });

const props = defineProps({
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
    <textarea
        :class="inputClasses"
        v-model="model"
        :id="id"
        :data-test-id="`input-${id}`"
    />
    <InputError v-if="error" :message="error" />
</template>
