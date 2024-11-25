import { onClickOutside } from '@vueuse/core';
import { ref, watch } from 'vue';
import { BsBagDashFill, FaBandsDashcube, IcDashboardDots, McRoundLine } from "@kalimahapps/vue-icons";

export function useSidebar() {
    const sidebarVisible = ref(true);
    const isMobileDevice = ref(window.innerWidth < 1024);
    const sidebarRef = ref<HTMLElement | null>(null);

    // Handle clicks outside the Sidebar to close it on mobile
    onClickOutside(sidebarRef, () => {
        if (isMobileDevice.value) {
            sidebarVisible.value = false; // Close sidebar on mobile if clicked outside
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

    function getIconComponent(icon: string) {
        switch (icon) {
            case 'RiDashboard3Fill':
                return IcDashboardDots;
            case 'users':
                return BsBagDashFill;
            case 'box':
                return FaBandsDashcube;
            case 'settings':
                return McRoundLine;
            default:
                return null;
        }
    }
    return {
        isMobileDevice,
        sidebarVisible,
        sidebarRef,
        toggleSidebar,
    };
}
