<script lang="ts" setup>
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FieldCol from '@/Components/Form/FieldCol.vue';
import FieldRow from '@/Components/Form/FieldRow.vue';
import InputSelect from '@/Components/Form/InputSelect.vue';
import Card from '@/Components/Panel/Card.vue';
import { daysOptions } from '@/Constants/options';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { Timeslot } from '@/types';
import { useForm } from 'laravel-precognition-vue-inertia';
import { PropType } from 'vue';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    timeslot: {
        type: Object as PropType<Timeslot>,
        required: false,
    },
});

const { timeslot } = props;

const method = timeslot ? 'put' : 'post';
const url = timeslot
    ? route('timeslots.update', timeslot.id)
    : route('timeslots.store');

const form = useForm(method, url, {
    day: timeslot?.day || '',
    timeslots: timeslot?.timeslots || [{ start_time: '', end_time: '' }],
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
            {{ timeslot ? 'Edit ' : 'Create New' }} Timeslot
        </template>
        <template #subtitle>
            Fill in the details for your
            {{ timeslot ? 'existing' : 'new' }} timeslot.
        </template>
        <template #actions>
            <LinkButton :href="route('timeslots.index')">Back</LinkButton>
        </template>
    </PageHeader>

    <Card class="mx-auto mt-6 p-4">
        <form @submit.prevent="submitForm">
            <FieldRow>
                <FieldCol>
                    <InputSelect
                        label="Day"
                        v-model="form.day"
                        :error="form.errors.day"
                        :options="daysOptions"
                    />
                </FieldCol>
            </FieldRow>

            <!--            <Times v-model="form.timeslots" />-->

            <div class="flex gap-2">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ timeslot ? 'Update' : 'Submit' }}
                </PrimaryButton>
                <LinkButton :href="route('timeslots.index')" color="danger">
                    Cancel
                </LinkButton>
            </div>
        </form>
    </Card>
</template>
