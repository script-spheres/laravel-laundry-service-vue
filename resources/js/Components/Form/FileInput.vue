<script setup lang="ts">
import { computed } from 'vue';

interface FileInputProps {
    dropzone?: boolean;
    label?: string;
    modelValue?: File | File[] | null;
    multiple?: boolean;
    size?: string;
    accept?: string;
}

const props = withDefaults(defineProps<FileInputProps>(), {
    dropzone: false,
    label: '',
    modelValue: null,
    multiple: false,
    size: 'sm',
    accept: '',
});

const emit = defineEmits(['update:modelValue']);
const model = computed({
    get() {
        return props.modelValue;
    },
    set(val) {
        emit('update:modelValue', val);
    },
});
</script>
