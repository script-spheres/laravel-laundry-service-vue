import { useDark, useToggle } from '@vueuse/core';
import { computed, onMounted, watch } from 'vue';

export function useDarkMode() {
    const isDark = useDark();
    const toggleDark = useToggle(isDark);

    // Computed property for body classes
    const bodyClass = computed(() => ({
        'bg-gray-800 text-white': isDark.value,
        'bg-white text-gray-800': !isDark.value,
    }));

    // Apply computed classes to body on mount
    onMounted(() => {
        // Add initial classes
        Object.entries(bodyClass.value).forEach(([className, condition]) => {
            if (condition) document.body.classList.add(...className.split(' '));
        });

        // Watch for changes in dark mode state to update classes
        watch(isDark, (newVal) => {
            if (newVal) {
                document.body.classList.add('bg-gray-800', 'text-white');
                document.body.classList.remove('bg-white', 'text-gray-800');
            } else {
                document.body.classList.add('bg-white', 'text-gray-800');
                document.body.classList.remove('bg-gray-800', 'text-white');
            }
        });
    });

    return { isDark, toggleDark };
}
