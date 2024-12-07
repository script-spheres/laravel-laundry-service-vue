<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const props = withDefaults(
    defineProps<{
        action: string;
        message?: string;
    }>(),
    {
        message: 'Are you sure you want to delete this item?',
    },
);

const deleteData = async () => {
    if (!window.confirm(props.message)) return;

    router.delete(props.action, {
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <PrimaryButton
        type="button"
        @click="deleteData"
        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700 dark:focus:ring-offset-gray-800"
    >
        <slot />
    </PrimaryButton>
</template>
