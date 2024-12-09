<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    label: string;
    active?: boolean;
}>();
</script>

<template>
    <li>
        <Link
            :href="props.href"
            :class="[
                'px-3 py-2',
                props.active
                    ? 'rounded bg-blue-700 text-white'
                    : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white',
                'md:p-0 md:hover:bg-transparent md:hover:text-blue-700',
            ]"
            :aria-current="props.active ? 'page' : undefined"
        >
            {{ props.label }}
        </Link>
    </li>
</template>
