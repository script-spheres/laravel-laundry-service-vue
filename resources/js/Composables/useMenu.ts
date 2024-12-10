import { readonly, ref, watch } from 'vue';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

export function useMenu() {
    const isMobileDevice = ref(window.innerWidth < 1024);

    // Watch for window resize events to update the mobile state dynamically
    watch(
        () => window.innerWidth,
        (newWidth) => {
            isMobileDevice.value = newWidth < 1024;
            if (newWidth < 1024) {
                isMenuOpen.value = false;
            }
        },
        { immediate: true },
    );

    return {
        isMobileDevice,

        // Menu
        isMenuOpen: readonly(isMenuOpen),
        toggleMenu,
    };
}
