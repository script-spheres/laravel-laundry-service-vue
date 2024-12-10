<script setup lang="ts">
import { useDarkMode } from '@/Composables/useDarkMode';
import { AkMoonFill, AkSunFill } from '@kalimahapps/vue-icons';
const { isDark, toggleDark } = useDarkMode();
</script>

<template>
    <button
        @click="toggleDark()"
        class="flex items-center justify-center rounded-full bg-gray-200 text-gray-500 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600"
    >
        <AkSunFill v-if="isDark" class="text-yellow-500" />
        <AkMoonFill v-else class="text-gray-500" />
    </button>
</template>
