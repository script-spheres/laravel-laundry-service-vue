<script setup lang="ts">
import { PaginationMeta } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: PaginationMeta;
}>();
</script>

<template>
    <div
        class="mt-6 flex items-center justify-between"
        v-if="links.total > links.per_page"
    >
        <p class="font-medium text-gray-700 dark:text-gray-100">
            Page <span>{{ links.from }}</span> of <span>{{ links.total }}</span>
        </p>
        <div class="inline-flex rounded-md shadow">
            <template v-for="link in links?.links" :key="link.label">
                <Link
                    preserve-scroll
                    v-if="link.url"
                    :href="link.url"
                    :class="[
                        'border px-4 py-2 text-sm font-medium transition-all duration-200',
                        link.active
                            ? 'border-gray-600 bg-gray-700 text-white dark:border-gray-500 dark:bg-gray-600 dark:text-white'
                            : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700',
                    ]"
                    v-html="link.label"
                />
                <div
                    v-else
                    :class="[
                        'border px-4 py-2 text-sm font-medium transition-all duration-200',
                        'border-gray-200 bg-white text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700',
                        link.active
                            ? 'border-gray-600 bg-gray-700 text-white dark:border-gray-500 dark:bg-gray-600 dark:text-white'
                            : '',
                    ]"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
