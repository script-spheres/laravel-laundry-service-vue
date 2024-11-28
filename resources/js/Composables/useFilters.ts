import { router } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';

export function useFilters(
    routeName: string,
    initialFilters: Record<string, string | undefined> = {},
) {
    const filter = reactive({ ...initialFilters });

    watch(filter, (newFilters) => {
        const filterParams = Object.fromEntries(
            Object.entries(newFilters).map(([key, value]) => [
                `filter[${key}]`,
                value,
            ]),
        );
        console.log(filterParams, 'filterParams');
        router.get(route(routeName), filterParams, {
            preserveScroll: true,
        });
    });

    const handleClearFilter = () => {
        Object.keys(filter).forEach(
            (key) => (filter[key as keyof Filters] = ''),
        );
    };

    return {
        filter,
        handleClearFilter,
    };
}
