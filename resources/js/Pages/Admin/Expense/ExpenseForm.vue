<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import PageHeader from '@/Components/PageHeader.vue';
import Card from '@/Components/Panel/Card.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Expense } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    expense: {
        type: Object as PropType<Expense>,
        required: false,
    },
    expenseTypeOptions: {
        type: Object as PropType<Object>,
        required: true,
    },
    storeOptions: {
        type: Object as PropType<Object>,
        required: true,
    },
});

const { expense } = props;

const method = expense ? 'put' : 'post';
const url = expense
    ? route('admin.expenses.update', expense.id)
    : route('admin.expenses.store');

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
            <LinkButton :href="route('admin.expenses.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow>
                <FieldCol>
                    <SelectInput
                        label="Expense Type"
                        v-model="form.expense_type_id"
                        :options="expenseTypeOptions"
                        :error="form.errors.expense_type_id"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <SelectInput
                        label="Store (Optional)"
                        v-model="form.store_id"
                        :options="storeOptions"
                        :error="form.errors.store_id"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow>
                <FieldCol>
                    <DateInput
                        label="Date"
                        v-model="form.date"
                        :error="form.errors.date"
                    />
                </FieldCol>
                <FieldCol>
                    <TextInput
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
                    <TextareaInput
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
                <LinkButton
                    :href="route('admin.expenses.index')"
                    color="danger"
                >
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
