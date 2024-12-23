<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputFilepond from '@/Components/Form/InputFilepond.vue';
import InputText from '@/Components/Form/InputText.vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth?.user;

const form = useForm({
    name: user?.name ?? '',
    email: user?.email ?? '',
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))">
            <div class="mt-4 grid grid-cols-6 gap-4">
                <div class="col-span-2">
                    <InputFilepond
                        stylePanelLayout="circle"
                        imagePreviewHeight="100"
                        :error="form.errors.name"
                    />
                </div>
                <div class="col-span-4 space-y-6">
                    <div>
                        <InputText
                            label="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            :error="form.errors.name"
                        />
                    </div>

                    <div>
                        <InputText
                            label="Email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            :error="form.errors.email"
                        />
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">
                            Save
                        </PrimaryButton>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-if="form.recentlySuccessful"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>
