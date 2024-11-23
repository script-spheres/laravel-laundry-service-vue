<script setup lang="ts">
import { useDark } from '@vueuse/core';
import { computed } from 'vue';

const isDark = useDark();

const headerClasses = computed(() => [
    'sticky top-0 flex justify-between items-center p-5',
    isDark.value ? 'bg-gray-900 text-white' : 'bg-white text-black',
]);

const buttonClasses = computed(() => (isDark.value ? 'bg-white' : 'bg-black'));
</script>
<template>
    <div :class="headerClasses">
        <h2 class="text-xl font-bold">Admin Portal</h2>
        <button
            class="h-4 w-4 rounded-full border border-gray-400 lg:hidden"
            @click="$emit('close-sidebar')"
        >
            <span :class="buttonClasses"></span>
        </button>
    </div>
</template>
