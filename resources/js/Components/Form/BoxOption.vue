<script setup lang="ts">
const props = defineProps({
    id: String,
    modelValue: String,
    name: String,
    type: {
        type: String,
        default: 'Radio',
    },
    value: String,
    label: String,
});

const emits = defineEmits(['update:modelValue']);

const updateValue = (value) => {
    emits('update:modelValue', value);
};
</script>
<template>
    <div>
        <input
            :id="id"
            :checked="modelValue === value"
            :name="name"
            :type="type"
            :value="value"
            class="peer hidden"
            @change="updateValue(value)"
        />
        <label
            :for="id"
            class="inline-flex w-full cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-600 peer-checked:border-blue-600 peer-checked:text-blue-600"
        >
            {{ label }}
        </label>
    </div>
</template>
