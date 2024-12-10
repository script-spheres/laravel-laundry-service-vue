<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import InputTextarea from '@/Components/Form/InputTextarea.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions } from '@/Constants/options';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FinancialYear } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    financialYear: {
        type: Object as PropType<FinancialYear>,
        required: false,
    },
});

const { financialYear } = props;

const method = financialYear ? 'put' : 'post';
const url = financialYear
    ? route('admin.financial-years.update', financialYear.id)
    : route('admin.financial-years.store');

const form = useForm(method, url, {
    name: financialYear?.name || '',
    start_date: financialYear?.start_date || '',
    end_date: financialYear?.end_date || '',
    status: financialYear?.status || 'active',
    description: financialYear?.description || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props.flash?.message),
    });
};
</script>
<template>
    <PageHeader>
        <template #title>
            {{ financialYear ? 'Edit ' : 'Create New' }} Financial Year
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ financialYear ? 'existing' : 'new' }} financial year.
        </template>
        <template #actions>
            <LinkButton :href="route('admin.financial-years.index')"
                >Back</LinkButton
            >
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="Financial Year Name"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Start Date"
                        v-model="form.start_date"
                        type="date"
                        :error="form.errors.start_date"
                    />
                </FieldCol>
            </FieldRow>
            <FieldRow class="grid-cols-2">
                <FieldCol>
                    <InputText
                        label="End Date"
                        v-model="form.end_date"
                        type="date"
                        :error="form.errors.end_date"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Status"
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
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
            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ financialYear ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton
                    :href="route('admin.financial-years.index')"
                    color="danger"
                >
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
