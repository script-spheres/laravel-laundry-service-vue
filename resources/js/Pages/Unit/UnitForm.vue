<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import InputText from '@/Components/Form/InputText.vue';
import Card from '@/Components/Panel/Card.vue';
import { statusOptions, trueFalseOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Unit } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const { unit } = defineProps({
    unit: {
        type: Object as PropType<Unit>,
        required: false,
    },
});

const method = unit ? 'put' : 'post';
const url = unit ? route('units.update', unit.id) : route('units.store');

const form = useForm(method, url, {
    actual_name: unit?.actual_name || '',
    short_name: unit?.short_name || '',
    allow_decimal: unit?.allow_decimal ?? false,
    status: unit?.status || '',
});

const submitForm = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: (page) => toast.success(page.props?.flash?.message),
    });
};
</script>

<template>
    <PageHeader>
        <template #title> {{ unit ? 'Edit ' : 'Create New' }} Unit</template>
        <template #subtitle>
            Fill in the details for your
            {{ unit ? 'existing' : 'new' }} unit.
        </template>
        <template #actions>
            <LinkButton :href="route('units.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow :cols="3">
                <FieldCol>
                    <InputText
                        label="Actual Name"
                        v-model="form.actual_name"
                        :error="form.errors.actual_name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputText
                        label="Short Name"
                        v-model="form.short_name"
                        :error="form.errors.short_name"
                    />
                </FieldCol>
                <FieldCol>
                    <InputSelect
                        label="Allow Decimal"
                        v-model="form.allow_decimal"
                        :options="trueFalseOptions"
                        :error="form.errors.allow_decimal"
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
                    {{ unit ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('units.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
