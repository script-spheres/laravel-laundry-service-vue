<script setup>
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import vueFilePond from 'vue-filepond';

import { usePage } from '@inertiajs/vue3';
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';

// Register FilePond plugins
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster,
);

const serverConfig = {
    process: {
        url: route('filepond-process'),
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': usePage().props.csrf_token,
        },
        withCredentials: false,
        onerror: () => {},
    },
};
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
    <FilePond v-bind="{ ...$attrs }" :server="serverConfig" credits="false" />
</template>
