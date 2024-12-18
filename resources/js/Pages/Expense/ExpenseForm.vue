<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import Card from '@/Components/Panel/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Expense } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    expense: {
        type: Object as PropType<Expense>,
        required: false,
    },
    expenseTypeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
    storeOptions: {
        type: Object as PropType<Options>,
        required: true,
    },
});

const { expense } = props;

const method = expense ? 'put' : 'post';
const url = expense
    ? route('expenses.update', expense.id)
    : route('expenses.store');

const form = useForm(method, url, {
    expense_type_id: expense?.expense_type_id || null,
    store_id: expense?.store_id || null,
    date: expense?.date || '',
    amount: expense?.amount || '',
    note: expense?.note || '',
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
            {{ expense ? 'Edit ' : 'Create New' }} Expense
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ expense ? 'existing' : 'new' }} expense.
        </template>
        <template #actions>
            <LinkButton :href="route('expenses.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow>
                <FieldCol>
                    <InputSelect
                        label="Expense Type"
                        v-model="form.expense_type_id"
                        :options="expenseTypeOptions"
                        :error="form.errors.expense_type_id"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputSelect
                        label="Store (Optional)"
                        v-model="form.store_id"
                        :options="storeOptions"
                        :error="form.errors.store_id"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputText
                        type="date"
                        label="Date"
                        v-model="form.date"
                        :error="form.errors.date"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Amount"
                        v-model="form.amount"
                        type="number"
                        step="0.01"
                        :error="form.errors.amount"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <InputTextarea
                        label="Note (Optional)"
                        v-model="form.note"
                        :error="form.errors.note"
                    />
                </FieldCol>
            </FieldRow>
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ expense ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('expenses.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
