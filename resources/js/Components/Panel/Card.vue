<script lang="ts" setup>
import { computed, useAttrs } from 'vue';

export type CardsVariant = 'default' | 'image' | 'horizontal';

const props = defineProps<{
    href?: string;
    imgAlt?: string;
    imgSrc?: string;
    variant?: CardsVariant;
}>();

// Determine wrapper type based on the presence of href
const wrapperType = computed(() => (props.href ? 'a' : 'div'));

// Base card classes
const baseClasses =
    'block bg-white rounded-md border shadow dark:bg-gray-800 dark:border-gray-700';

// Panel classes based on variant
const cardClasses = computed(() =>
    props.variant === 'horizontal'
        ? `${baseClasses} flex flex-col items-center md:flex-row md:max-w-xl`
        : baseClasses,
);

// Horizontal image classes
const horizontalImageClasses = computed(() =>
    props.variant === 'horizontal'
        ? 'object-cover w-full h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg'
        : '',
);

// Capture any additional attributes
const attrs = useAttrs();
</script>

<template>
    <component
        :is="wrapperType"
        :class="cardClasses"
        v-bind="attrs"
        :href="props.href"
    >
        <img
            v-if="props.imgSrc"
            :alt="props.imgAlt"
            :class="horizontalImageClasses"
            :src="props.imgSrc"
            class="rounded-t-lg"
        />
        <slot />
    </component>
</template>
