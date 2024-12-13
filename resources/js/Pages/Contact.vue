<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import { toast } from 'vue3-toastify';

defineOptions({ layout: PublicLayout });

const form = useForm('post', route('coupons.store'), {
    name: '',
    email: '',
    message: '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <Head title="Contact Us" />

    <section class="container mx-auto py-16">
        <h1
            class="mb-8 text-center text-4xl font-extrabold text-gray-800 dark:text-white"
        >
            Contact Us
        </h1>

        <div class="flex justify-center gap-10">
            <!-- Contact Form -->
            <div
                class="w-full rounded-lg bg-white p-8 shadow-md dark:bg-gray-800 md:w-2/3"
            >
                <h2
                    class="mb-4 text-2xl font-bold text-gray-800 dark:text-white"
                >
                    Get in Touch
                </h2>
                <form @submit.prevent="submitForm">
                    <div>
                        <InputText
                            label="Name"
                            v-model="form.name"
                            placeholder="Your Name"
                            required
                        />
                    </div>

                    <div>
                        <InputText
                            label="Email"
                            v-model="form.email"
                            placeholder="Your Email"
                            required
                        />
                    </div>

                    <div>
                        <InputTextarea
                            label="Message"
                            v-model="form.message"
                            rows="5"
                            placeholder="Your Message"
                            required
                        />
                    </div>

                    <PrimaryButton type="submit"> Send Message </PrimaryButton>
                </form>
            </div>

            <!-- Contact Information -->
            <div
                class="w-full rounded-lg bg-white p-8 shadow-md dark:bg-gray-800 md:w-1/3"
            >
                <h2
                    class="mb-4 text-2xl font-bold text-gray-800 dark:text-white"
                >
                    Our Contact Information
                </h2>
                <p class="mb-4 text-gray-600 dark:text-gray-300">
                    Feel free to reach out to us for any inquiries or support.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="material-icons mr-2 text-blue-500"
                            >phone</span
                        >
                        <p class="text-gray-700 dark:text-gray-300">
                            +1 (555) 123-4567
                        </p>
                    </div>

                    <div class="flex items-center">
                        <span class="material-icons mr-2 text-blue-500"
                            >email</span
                        >
                        <p class="text-gray-700 dark:text-gray-300">
                            info@sparkleclean.com
                        </p>
                    </div>

                    <div class="flex items-center">
                        <span class="material-icons mr-2 text-blue-500"
                            >location_on</span
                        >
                        <p class="text-gray-700 dark:text-gray-300">
                            123 Sparkle Street, Clean City, Country
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
