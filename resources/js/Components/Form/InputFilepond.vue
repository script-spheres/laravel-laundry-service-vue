<script setup lang="ts">
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import { usePage } from '@inertiajs/vue3';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';

import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';

import { ref, useId } from 'vue';
import vueFilePond from 'vue-filepond';

const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFilePoster,
    FilePondPluginFileValidateType,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageCrop,
    FilePondPluginImageResize,
    FilePondPluginImageTransform,
    FilePondPluginImageEdit,
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
    label: { type: String, required: false },
    size: { type: String as () => 'lg' | 'md' | 'sm', default: 'md' },
    error: { type: String, required: false },
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
    <InputLabel v-if="label" :for="`label-${id}`" :data-test-id="`label-${id}`">
        {{ label }} :
    </InputLabel>
    <FilePond
        v-bind="{ ...$attrs, files: props.files ? filePondFiles : [] }"
        :maxFileSize="maxFileSize"
        @init="handleFilePondInit"
        :server="serverConfig"
        credits="false"
        accepted-file-types="image/png, image/jpeg, image/gif"
        filePosterMaxHeight="268"
    />
    <InputError v-if="error" :message="error" />
</template>
