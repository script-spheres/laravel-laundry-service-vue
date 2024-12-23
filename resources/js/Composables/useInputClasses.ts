import { twMerge } from 'tailwind-merge';
import { computed } from 'vue';

type InputSize = 'lg' | 'md' | 'sm';
type InputColor = 'primary' | 'secondary' | 'error' | 'success';

// Base classes for input
const baseClasses =
    'w-full appearance-none rounded border px-3 py-2 leading-tight focus:outline-none focus:ring-2 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white';

// Size classes for different input sizes
const sizeClasses: Record<InputSize, string> = {
    lg: 'p-4 text-base',
    md: 'p-2 text-sm',
    sm: 'p-2 text-sm',
};

// Color classes for different input states
const colorClasses: Record<InputColor, string> = {
    primary:
        'border-blue-500 focus:border-blue-500 focus:ring-blue-300 dark:focus:ring-blue-500',
    secondary:
        'border-gray-500 focus:border-gray-500 focus:ring-gray-300 dark:focus:ring-gray-500',
    error: 'border-red-500 focus:border-red-500 focus:ring-red-300 dark:focus:ring-red-500',
    success:
        'border-green-500 focus:border-green-500 focus:ring-green-300 dark:focus:ring-green-500',
};

// The function now defaults size and color if not provided
export function useInputClasses({
    size = 'md',
    color = 'secondary',
}: {
    size?: InputSize;
    color?: InputColor;
} = {}) {
    const inputClasses = computed(() => {
        return twMerge(baseClasses, sizeClasses[size], colorClasses[color]);
    });

    return {
        inputClasses,
    };
}
