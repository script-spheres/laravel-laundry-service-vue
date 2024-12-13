<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useInputClasses } from '@/Composables/useInputClasses';
import { useId } from 'vue';

const model = defineModel<string | null>({ required: true });

defineProps({
    label: { type: String, required: false },
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: { type: String, required: false },
});

const { inputClasses } = useInputClasses();

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
        v-bind="{ ...$attrs }"
    />
    <InputError v-if="error" :message="error" />
</template>
