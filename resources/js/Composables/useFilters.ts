import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { reactive, watch } from 'vue';

export function useFilters(
    routeName: string,
    initialFilters: Record<string, string> = {},
) {
    const filter = reactive({ ...initialFilters });

    const debouncedFilter = debounce((newFilters: Record<string, string>) => {
        const filterParams = Object.fromEntries(
            Object.entries(newFilters).map(([key, value]) => [
                `filter[${key}]`,
                value,
            ]),
        );

        router.get(route(routeName), filterParams, {
            preserveScroll: true,
        });
    }, 500);

    watch(filter, (newFilters) => {
        debouncedFilter(newFilters);
    });

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
