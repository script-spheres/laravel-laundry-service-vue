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
            Page <span>{{ links.from }}</span> of
            <span>{{ links.total }}</span>
        </p>
        <div class="inline-flex rounded-md shadow">
            <template v-for="link in links?.links" :key="link.label">
                <Link
                    preserve-scroll
                    v-if="link.url"
                    :href="link.url"
                    :class="[
                        'border px-4 py-2 text-sm font-medium',
                        link.active
                            ? 'border-blue-700 bg-gray-700 text-white'
                            : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-100',
                    ]"
                    v-html="link.label"
                />
                <div
                    v-else
                    :class="[
                        'border px-4 py-2 text-sm font-medium',
                        'border-gray-200 bg-white text-gray-900 hover:bg-gray-100',
                        link.active
                            ? 'border-blue-700 bg-gray-700 text-white'
                            : '',
                    ]"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
