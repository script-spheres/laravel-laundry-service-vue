<script setup lang="ts">
import { useDark } from '@vueuse/core';
import { computed } from 'vue';

const isDark = useDark();

const buttonClasses = computed(() => (isDark.value ? 'bg-white' : 'bg-black'));
</script>
<template>
    <div
        class="flex h-[65px] items-center justify-between border-b border-b-gray-200 px-4"
    >
        <h2 class="text-3xl font-bold">Admin Portal</h2>
        <button
            class="h-4 w-4 rounded-full border border-gray-400 lg:hidden"
            @click="$emit('close-sidebar')"
        >
            <span :class="buttonClasses"></span>
        </button>
    </div>
</template>
