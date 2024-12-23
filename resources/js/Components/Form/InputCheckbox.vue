<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps<{
    checked: boolean;
    value?: any;
    label?: string;
    size?: 'lg' | 'md' | 'sm';
    error?: string;
}>();

const proxyChecked = computed({
    get() {
        return props.checked;
    },
    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <label class="inline-flex items-center gap-2">
        <input
            type="checkbox"
            v-model="proxyChecked"
            class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-gray-600 dark:focus:ring-offset-gray-800"
        />
        <span v-if="label" class="text-sm text-gray-700 dark:text-gray-300">
            {{ label }}
        </span>
    </label>
    <InputError v-if="error" :message="error" />
</template>
