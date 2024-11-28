<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';

// Ref for Input element
const input = ref(null);
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
    <label class="inline-flex cursor-pointer items-center">
        <input
            v-bind="{ ...$props, ...$attrs }"
            ref="input"
            type="checkbox"
            :checked="props.data.active_status === 'active'"
            @change="handleStatusChange"
            class="peer sr-only h-6 w-11 appearance-none"
        />
        <div
            class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full"
        ></div>
    </label>
    <p v-show="$attrs.error" class="text-sm text-red-600 dark:text-red-400">
        {{ $attrs.error }}
    </p>
</template>
