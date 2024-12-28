<script setup lang="ts">
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FromField from '@/Components/Form/FromField.vue';
import InputText from '@/Components/Form/InputText.vue';
import { Times } from '@/types';
import { defineModel } from 'vue';

const model = defineModel<Times[]>({
    required: true,
    default: () => [{ start_time: '', end_time: '' }],
});

const addTimeslot = () => {
    model.value.push({ start_time: '', end_time: '' });
};

const removeTimeslot = (index: number) => {
    model.value.splice(index, 1);
};
</script>

<template>
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">
            Timeslots
        </label>
        <div class="space-y-2">
            <div
                v-for="(timeslot, index) in model"
                :key="index"
                class="flex w-full items-center space-x-2"
            >

                <PrimaryButton
                    v-if="model.length > 1"
                    @click.prevent="removeTimeslot(index)"
                    type="button"
                    color="danger"
                    class="flex-none items-end"
                >
                    Del
                </PrimaryButton>
            </div>
            <PrimaryButton @click.prevent="addTimeslot" type="button">
                Add Timeslot
            </PrimaryButton>
        </div>
    </div>
</template>
