<script lang="ts" setup>
import PageHeader from '@/Shared/PageHeader.vue';
import { Link } from '@inertiajs/vue3';

// Define props for the page title and subtitle
defineProps({
    title: { type: String, required: true },
    subtitle: { type: String, required: true },
});
</script>

<template>
    <PageHeader>
        <template #title>{{ title }}</template>
        <template #subtitle>{{ subtitle }}</template>
    </PageHeader>

    <nav class="mx-auto mb-6 mt-6 flex justify-center space-x-2 border-b pb-2">
        <Link
            :href="route('settings.index')"
            class="rounded-t-lg px-6 py-2 text-lg font-semibold text-gray-600 transition-all duration-300"
            :class="{
                '-mb-[1px] border-x border-t border-blue-600 bg-white text-blue-600':
                    $page.component.startsWith('GeneralSetting'),
                'hover:border-blue-600 hover:text-blue-600':
                    !$page.component.startsWith('GeneralSetting'),
            }"
        >
            General
        </Link>
        <Link
            :href="route('settings.finance')"
            class="rounded-t-lg px-6 py-2 text-lg font-semibold text-gray-600 transition-all duration-300"
            :class="{
                '-mb-[1px] border-x border-t border-blue-600 bg-white text-blue-600':
                    $page.component.startsWith('FinanceSetting'),
                'hover:border-blue-600 hover:text-blue-600':
                    !$page.component.startsWith('FinanceSetting'),
            }"
        >
            Finance
        </Link>
    </nav>

    <div class="mx-auto rounded-lg bg-white p-6 shadow-xl">
        <slot />
    </div>
</template>
