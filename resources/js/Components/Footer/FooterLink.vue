<script setup lang="ts">
const props = defineProps<{
    href: string;
    label: string;
}>();
</script>

<template>
    <li class="mb-4">
        <a :href="props.href" class="hover:underline">{{ props.label }}</a>
    </li>
</template>
