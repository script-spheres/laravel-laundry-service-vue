<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useInputClasses } from '@/Composables/useInputClasses';
import { ref, useId } from 'vue';

// Define props
const props = defineProps({
    label: { type: String, required: false },
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: { type: String, required: false },
    file: { type: Object as () => File | null, default: null },
});

// Initialize reactive variables
const filePreview = ref<string | null>(null);

const { inputClasses } = useInputClasses({
    size: props.size,
});

const id = useId();
</script>

<template>
    <!-- InputLabel for the file input -->
    <InputLabel v-if="label" :for="`label-${id}`" :data-test-id="`label-${id}`">
        {{ label }} :
    </InputLabel>

    <!-- File input field with change handler -->
    <input
        :class="inputClasses"
        type="file"
        :id="id"
        :data-test-id="`input-${id}`"
        v-bind="{ ...$attrs }"
    />

    <!-- Display file preview if a file is selected -->
    <div v-if="filePreview">
        <img
            v-if="filePreview"
            :src="filePreview"
            alt="File Preview"
            class="max-h-72 max-w-full object-cover"
        />
    </div>

    <!-- Display error message if exists -->
    <InputError v-if="error" :message="error" />
</template>
