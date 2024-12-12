<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    expenseType: {
        type: Object as PropType<{
            id: number;
            name: string;
            description: string;
            status: string;
        }>,
        required: false,
    },
});

const { expenseType } = props;

const method = expenseType ? 'put' : 'post';
const url = expenseType
    ? route('expense-types.update', expenseType.id)
    : route('expense-types.store');

const form = useForm(method, url, {
    name: expenseType?.name || '',
    description: expenseType?.description || '',
    status: expenseType?.status || 'active',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page?.props?.flash?.message),
    });
};
</script>

<template>
    <PageHeader>
        <template #title>
            {{ expenseType ? 'Edit ' : 'Create New' }} Expense Type
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ expenseType ? 'existing' : 'new' }} expense type.
        </template>
        <template #actions>
            <LinkButton :href="route('expense-types.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow>
                <FieldCol>
                    <InputText
                        label="Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Description"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputSelect
                        label="Status"
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ expenseType ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('expense-types.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
