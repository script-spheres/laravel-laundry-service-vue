import { readonly, ref, watch } from 'vue';

export function useMenu(initialMenuState: boolean = false) {
    const isMobileDevice = ref(window.innerWidth < 1024);

    const menuState = ref(initialMenuState);

    const toggleMenu = () => {
        menuState.value = !menuState.value;
    };

    watch(
        () => window.innerWidth,
        (newWidth) => {
            isMobileDevice.value = newWidth < 1024;
            if (newWidth < 1024) {
                menuState.value = false;
            }
        },
        { immediate: true },
    );

    return {
        isMobileDevice,
        isMenuOpen: readonly(menuState),
        toggleMenu,
    };
}
