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
    <PrimaryButton type="button" @click="deleteData" color="danger">
        <slot />
    </PrimaryButton>
</template>
