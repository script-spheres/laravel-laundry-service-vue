<script setup lang="ts">
import { LinkButton, PrimaryButton } from '@/Components/Buttons';
import { InputError } from '@/Components/Form';
import FileUpload from '@/Components/Form/FileUpload.vue';

const banner = usePage().props.banner;

const form = useForm({
    _method: 'PUT',
    title: banner.title ?? '',
    description: banner.description ?? '',
    image: banner.image ?? '',
    status: banner.status ?? '',
});

const update = () => form.post(route('admin.Banner.update', banner.id));
</script>

<template>
    <Head title="Dashboard" />

    <div>
        <template>
            <div class="flex items-center justify-between py-4">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2
                            class="text-lg font-medium text-gray-800 dark:text-white"
                        >
                            Banners
                        </h2>
                        <span
                            class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-600 dark:bg-gray-800 dark:text-blue-400"
                            >240 subscriptions</span
                        >
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                        These companies have purchased in the last 12 months.
                    </p>
                </div>

                <div class="flex items-center gap-x-3">
                    <Link
                        :to="{ name: 'admin.Banner.index' }"
                        class="flex w-1/2 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-blue-500 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 sm:w-auto"
                    >
                        <span>Back</span>
                    </Link>
                </div>
            </div>
        </template>
        <div class="pb-20 pt-6">
            <div class="mx-auto px-4">
                <div
                    class="w-full overflow-hidden bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg"
                >
                    <form class="w-full" @submit.prevent="update">
                        <div class="-mx-3 mb-6 flex flex-wrap">
                            <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                                <Input v-model="form.title" :label="'Title'" />
                                <InputError :message="form.errors.title" />
                            </div>
                            <div class="w-full px-3 md:w-1/2">
                                <Input
                                    v-model="form.description"
                                    :label="'Description'"
                                />
                                <InputError
                                    :message="form.errors.description"
                                />
                            </div>
                        </div>
                        <div class="-mx-3 mb-6 flex flex-wrap">
                            <div class="mb-6 w-full px-3 md:mb-0">
                                <FileUpload
                                    :label="'Image'"
                                    @input="form.image = $event.target.files[0]"
                                />
                                <InputError
                                    :message="form.errors.description"
                                />
                            </div>
                        </div>
                        <div class="-mx-3 mb-2 flex flex-wrap">
                            <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                                <Select
                                    v-model="form.status"
                                    :label="'Status'"
                                />
                                <InputError
                                    :message="form.errors.status"
                                />
                            </div>
                        </div>
                        <div
                            class="-mx-3 mb-6 flex flex-wrap gap-3 px-3 md:mb-0"
                        >
                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                type="submit"
                            >
                                Submit
                            </PrimaryButton>
                            <LinkButton :to="{ name: 'admin.Banner.index' }"
                                >Cancel</LinkButton
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
