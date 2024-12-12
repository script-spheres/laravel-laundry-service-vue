import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { reactive, watch } from 'vue';

export function useFilters(
    routeName: string,
    initialFilters: Record<string, string> = {},
) {
    const filter = reactive({ ...initialFilters });

    // Create the debounced function only once
    const debouncedFilterUpdate = debounce(
        (newFilters: Record<string, string>) => {
            const filterParams = Object.fromEntries(
                Object.entries(newFilters).map(([key, value]) => [
                    `filter[${key}]`,
                    value,
                ]),
            );

            // Call the server request (Inertia router)
            router.get(route(routeName), filterParams, {
                preserveScroll: true,
            });
        },
        500,
    ); // 500ms debounce delay

    // Watch for changes in the filters and call the debounced function
    watch(filter, (newFilters) => {
        debouncedFilterUpdate(newFilters);
    });

    // Handle clearing the filters
    const handleClearFilter = () => {
        Object.keys(filter).forEach(
            (key) => (filter[key as keyof typeof filter] = ''),
        );
    };

    return {
        filter,
        handleClearFilter,
    };
}
