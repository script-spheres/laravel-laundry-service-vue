<script setup lang="ts">
import ToggleInput from '@/Components/Form/ToggleInput.vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    action: {
        type: String,
        required: true,
    },
});

const handleStatusChange = (event: Event) => {
    const newStatus = (event.target as HTMLInputElement).checked
        ? 'active'
        : 'inactive';
    router.put(
        props.action,
        { ...props.data, active_status: newStatus },
        {
            onSuccess: (page) => toast.success(page.props?.flash?.message),
        },
    );
};
</script>

<template>
    <ToggleInput
        :modelValue="props.data.active_status === 'active'"
        @change="handleStatusChange"
    />
</template>
