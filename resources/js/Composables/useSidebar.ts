import { onClickOutside } from '@vueuse/core';
import { ref, watch } from 'vue';

export function useSidebar() {
    const sidebarVisible = ref(true);
    const isMobileDevice = ref(window.innerWidth < 1024);
    const sidebarRef = ref<HTMLElement | null>(null);

    // Handle clicks outside the Sidebar to close it on mobile
    onClickOutside(sidebarRef, () => {
        if (isMobileDevice.value) {
            sidebarVisible.value = false;
        }
    });

    // Watch for window resize events to update the mobile state dynamically
    watch(
        () => window.innerWidth,
        (newWidth) => {
            isMobileDevice.value = newWidth < 1024;
            if (newWidth < 1024) {
                sidebarVisible.value = false;
            }
        },
        { immediate: true },
    );

    // Function to toggle the Sidebar visibility
    const toggleSidebar = () => {
        sidebarVisible.value = !sidebarVisible.value;
    };

    return {
        isMobileDevice,
        sidebarVisible,
        sidebarRef,
        toggleSidebar,
    };
}
