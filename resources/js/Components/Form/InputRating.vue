<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { useId } from 'vue';

// Define the model and its validation rules
const model = defineModel<number | null>({ required: true });

const props = defineProps({
    label: { type: String, required: false },
    error: { type: String, required: false },
});

const id = useId();

// Handle the star click to set the rating
const handleStarClick = (rating: number) => {
    model.value = rating;
};
</script>

<template>
    <div>
        <!-- Label Section -->
        <InputLabel
            v-if="props.label"
            :for="`rating-${id}`"
            :data-test-id="`label-${id}`"
        >
            {{ props.label }}:
        </InputLabel>

        <!-- Rating Stars -->
        <div
            class="flex gap-1"
            :data-test-id="`rating-${id}`"
            aria-labelledby="rating-label"
        >
            <!-- Generate 5 stars dynamically -->
            <span
                v-for="star in [1, 2, 3, 4, 5]"
                :key="star"
                :class="[
                    'cursor-pointer',
                    star <= model ? 'text-yellow-500' : 'text-gray-300',
                ]"
                @click="handleStarClick(star)"
                :aria-label="'Star ' + star"
                :data-test-id="'star-' + star"
            >
                <svg
                    class="h-6 w-6"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 22 20"
                >
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                    />
                </svg>
            </span>
        </div>

        <!-- Error message if there's an error -->
        <InputError v-if="props.error" :message="props.error" />
    </div>
</template>
