<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';
import { ref, useId } from 'vue';
import vueFilePond from 'vue-filepond';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster,
);

const props = defineProps({
    files: {
        type: [Object, Array],
        default: null,
    },
    maxFileSize: {
        type: [Number, String],
        default: null,
    },
});

const filePondFiles = ref<any[]>([]);

const handleFilePondInit = () => {
    // Ensure the files are in an array format
    const normalizedFiles = Array.isArray(props.files)
        ? props.files
        : [props.files];

    // Map files to FilePond's required format
    filePondFiles.value = normalizedFiles.map((file: any) => ({
        source: file?.basename || file?.id,
        options: {
            type: 'local',
            metadata: {
                poster: file?.url,
            },
        },
    }));
};

const serverConfig = {
    process: {
        url: route('filepond-process'),
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': usePage().props.csrf_token,
        },
        withCredentials: true,
    },
    revert: {
        url: route('filepond-revert'),
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': usePage().props.csrf_token,
        },
    },
};
const id = useId();
</script>

<template>
    <label
        v-if="$attrs.label"
        :for="id"
        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
        :data-test-id="`label-${id}`"
    >
        {{ $attrs.label }} :
    </label>
    <FilePond
        v-bind="{ ...$attrs, files: props.files ? filePondFiles : [] }"
        :maxFileSize="maxFileSize"
        @init="handleFilePondInit"
        :server="serverConfig"
        credits="false"
        filePosterHeight="260"
    />
    <p v-show="$attrs.error" class="text-sm text-red-600 dark:text-red-400">
        {{ $attrs.error }}
    </p>
</template>
