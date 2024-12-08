<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputText from '@/Components/Form/InputText.vue';
import Modal from '@/Components/Modal/Modal.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { inject, Ref } from 'vue';
import { toast } from 'vue3-toastify';

const showCustomerModal = inject('showCustomerModal') as Ref<boolean>;

const handleClose = () => {
    showCustomerModal.value = false;
};

const form = useForm('post', route('admin.service-items.store'), {
    name: '',
    mobile: '',
    email: '',
    status: '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <Modal :show="showCustomerModal" @close="handleClose">
        <form class="w-full" @submit.prevent="submitForm">
            <div class="p-6">
                <div class="flex justify-between">
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Customer Details
                    </h2>
                </div>
                <div class="mt-6">
                    <InputText
                        v-model="form.name"
                        placeholder="Customer name"
                        :error="form.errors.name"
                    />
                </div>
                <div class="mt-6">
                    <InputText
                        v-model="form.mobile"
                        placeholder="Mobile Number"
                        :error="form.errors.mobile"
                    />
                </div>
                <div class="mt-6">
                    <InputText
                        v-model="form.email"
                        placeholder="Email ID (Optional)"
                        :error="form.errors.email"
                    />
                </div>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted.
                </p>
                <div class="mt-6">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="btn btn-primary w-full text-center"
                        type="submit"
                    >
                        Submit
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
