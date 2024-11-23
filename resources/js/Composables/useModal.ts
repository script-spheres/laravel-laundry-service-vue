import { ref } from 'vue';

export const useModal = () => {
    const showModal = ref(false);

    const openModal = () => {
        showModal.value = true;
    };

    const closeModal = () => {
        showModal.value = false;
    };

    return {
        showModal,
        openModal,
        closeModal,
    };
};
