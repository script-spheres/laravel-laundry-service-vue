<script setup lang="ts">
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { defineModel, inject, Ref } from 'vue';

const showNoteModal = inject('showNoteModal') as Ref<boolean>;

const closeModal = () => {
    showNoteModal.value = false;
};

const model = defineModel<string | number | null>({ required: true });
</script>

<template>
    <Modal :show="showNoteModal" @close="closeModal">
        <div class="p-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Select An Addon Service
            </h2>
            <InputTextarea v-model="model" />
        </div>
    </Modal>
</template>
