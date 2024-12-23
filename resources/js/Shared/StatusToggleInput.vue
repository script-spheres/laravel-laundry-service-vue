<script setup lang="ts">
import InputToggle from '@/Components/Form/InputToggle.vue';
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
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

// Computed property to convert status string to boolean
const isActive = computed({
    get: () => props.data.status === 'active',
    set: (newValue: boolean) => {
        const newStatus = newValue ? 'active' : 'inactive';
        router.put(
            props.action,
            { ...props.data, status: newStatus },
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => toast.success(page.props?.flash?.message),
            },
        );
    },
});
</script>

<template>
    <InputToggle v-model="isActive" />
</template>
