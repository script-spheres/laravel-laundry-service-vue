<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    model: {
        type: String,
        required: true,
    },
    sourceValue: {
        type: String,
        required: true,
    },
    initialSlug: {
        type: String,
        default: '',
    },
    slugField: {
        type: String,
        default: 'slug',
    },
});

const emit = defineEmits(['update:slug']);

const slug = ref(props.initialSlug);
const loading = ref(false);

const generateSlug = async (value: string) => {
    if (!value) {
        slug.value = '';
        emit('update:slug', '');
        return;
    }

    loading.value = true;

    try {
        const response = router.post(
            route('slug.generate'),
            {
                model: props.model,
                value,
            },
            {
                preserveState: true,
                only: [], // Don't replace the current page data
            },
        );
        slug.value = response.props.slug; // Assign server-generated slug
        emit('update:slug', response.props.slug); // Emit updated slug
    } catch (error) {
        console.error('Error generating slug:', error);
    } finally {
        loading.value = false;
    }
};

// Watch for changes in the source value to auto-generate the slug
watch(
    () => props.sourceValue,
    (newValue) => {
        generateSlug(newValue);
    },
);
</script>

<template>
    <div>
        <div class="mb-2">
            <label for="slug" class="block text-sm font-medium text-gray-700">
                Slug
            </label>
            <div class="relative">
                <input
                    id="slug"
                    v-model="slug"
                    type="text"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    :placeholder="`Generated from ${slugField}`"
                />
                <span
                    v-if="loading"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500"
                >
                    Generating...
                </span>
            </div>
        </div>
    </div>
</template>
