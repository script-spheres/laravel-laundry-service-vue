<script setup lang="ts">
import LinkButton from '@/Components/Buttons/LinkButton.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import TextareaInput from '@/Components/Form/TextareaInput.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Card from '@/Components/Panel/Card.vue';

const activeStatusOptions = { active: 'Active', inactive: 'Inactive' };

const {
    supplier,
    errors,
    processing,
    createSupplier,
    getSupplier,
    updateSupplier,
} = useSupplier();

const form = reactive({
    name: '',
    mobile: '',
    email: '',
    address: '',
    credit_balance: '',
    active_status: '',
});

const loadSupplier = async () => {
    if (route.params.id) {
        try {
            await getSupplier(route.params.id);
            Object.assign(form, supplier.value.data);
        } catch {
            toast.error('Error loading supplier.');
        }
    }
};

onMounted(loadSupplier);

const submitForm = async () => {
    try {
        route.params.id
            ? await updateSupplier(route.params.id, { ...form })
            : await createSupplier({ ...form });
        toast.success(
            `Supplier ${route.params.id ? 'updated' : 'created'} successfully!`,
        );
        await router.push({ name: 'supplier.index' });
    } catch {
        toast.error('There was an error saving the supplier.');
    }
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                    {{
                        route.params.id
                            ? 'Edit Supplier'
                            : 'Create New Supplier'
                    }}
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Fill in the details for your
                {{ route.params.id ? 'existing' : 'new' }} supplier.
            </p>
        </div>
        <LinkButton :to="{ name: 'supplier.index' }">Back</LinkButton>
    </div>
    <Card class="mx-auto mt-6">
        <form @submit.prevent="submitForm">
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="name" value="Supplier Name" />
                    <TextInput v-model="form.name" type="text" />
                    <InputError :message="errors.name" class="mt-2" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/2">
                    <InputLabel for="email" value="Email Address" />
                    <TextInput v-model="form.email" type="email" />
                    <InputError :message="errors.email" class="mt-2" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel for="mobile" value="Supplier Mobile" />
                    <TextInput v-model="form.mobile" type="text" />
                    <InputError :message="errors.mobile" class="mt-2" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel
                        for="credit_balance"
                        value="Previous Credit Balance"
                    />
                    <NumberInput v-model="form.credit_balance" type="number" />
                    <InputError :message="errors.credit_balance" class="mt-2" />
                </div>
                <div class="mb-6 w-full px-3 md:mb-0 md:w-1/3">
                    <InputLabel for="active_status" value="Status" />
                    <SelectInput
                        v-model="form.active_status"
                        :options="activeStatusOptions"
                    />
                    <InputError :message="errors.active_status" class="mt-2" />
                </div>
            </div>
            <div class="-mx-3 mb-6 flex flex-wrap">
                <div class="mb-6 w-full px-3 md:mb-0">
                    <InputLabel for="address" value="Address" />
                    <TextareaInput v-model="form.address" />
                    <InputError :message="errors.address" class="mt-2" />
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <PrimaryButton
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    type="submit"
                >
                    Submit
                </PrimaryButton>
                <LinkButton :to="{ name: 'supplier.index' }" color="red"
                    >Cancel</LinkButton
                >
            </div>
        </form>
    </Card>
</template>
