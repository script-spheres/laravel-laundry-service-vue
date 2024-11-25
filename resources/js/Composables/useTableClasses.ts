import classNames from 'classnames';
import { computed, inject } from 'vue';

export function useTableClasses() {
    const isSmall = inject('small', false);

    const baseCellClasses = 'px-4';
    const baseHeadCellClasses = 'px-6 py-4 text-xs uppercase';
    const smallHeadCellClasses = 'px-4 py-2';
    const baseRowClasses =
        'bg-white dark:bg-gray-800 [&:not(:last-child)]:border-b [&:not(:last-child)]:dark:border-gray-700';

    const tableCellClasses = computed(() => classNames(baseCellClasses));

    const tableHeadCellClasses = computed(() =>
        classNames(isSmall ? smallHeadCellClasses : baseHeadCellClasses),
    );

    const tableRowClasses = computed(() => classNames(baseRowClasses));

    return {
        tableCellClasses,
        tableHeadCellClasses,
        tableRowClasses,
    };
}
