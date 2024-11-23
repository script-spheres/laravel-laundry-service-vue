/**
 * Format a string to Title Case.
 * @param str - The input string.
 */
export function toTitleCase(str: string): string {
    return str.replace(
        /\w\S*/g,
        (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(),
    );
}

/**
 * Debounce a function to limit execution rate.
 * @param func - Function to debounce.
 * @param delay - Delay in milliseconds.
 */
export function debounce<T extends (...args: any[]) => void>(
    func: T,
    delay: number,
): T {
    let timer: ReturnType<typeof setTimeout>;
    return ((...args: Parameters<T>) => {
        clearTimeout(timer);
        timer = setTimeout(() => func(...args), delay);
    }) as T;
}

/**
 * Convert an object to query parameters.
 * @param params - Object to convert.
 */
export function objectToQueryParams(params: Record<string, any>): string {
    return Object.keys(params)
        .map(
            (key) =>
                `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`,
        )
        .join('&');
}

/**
 * Check if an object is empty.
 * @param obj - Object to check.
 */
export function isEmptyObject(obj: Record<string, any>): boolean {
    return Object.keys(obj).length === 0;
}
