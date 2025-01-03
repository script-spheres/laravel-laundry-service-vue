<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BusinessSetting from '@/Pages/Settings/Partials/BusinessSetting.vue';
import FinanceSetting from '@/Pages/Settings/Partials/FinanceSetting.vue';
import GeneralSetting from '@/Pages/Settings/Partials/GeneralSetting.vue';
import PageHeader from '@/Shared/PageHeader.vue';
import { BusinessSettings, FinanceSettings, GeneralSettings } from '@/types';
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue';
import { markRaw, PropType, ref } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    generalSettings: {
        type: Object as PropType<GeneralSettings | null>,
        required: false,
    },
    businessSettings: {
        type: Object as PropType<BusinessSettings | null>,
        required: false,
    },
    financeSettings: {
        type: Object as PropType<FinanceSettings | null>,
        required: false,
    },
});

// Define the type for the settings component structure
interface SettingsComponent {
    component: any;
    title: string;
    subtitle: string;
    props: Record<string, any>;
}

// Define the settings object with proper typing
const settings: Record<string, SettingsComponent> = {
    'Application Settings': {
        component: markRaw(GeneralSetting),
        title: 'Application Settings',
        subtitle: 'Configure the general application settings here.',
        props: { settings: props.generalSettings },
    },
    'Business Settings': {
        component: markRaw(BusinessSetting),
        title: 'Business Settings',
        subtitle: 'Manage business-related settings here.',
        props: { settings: props.businessSettings },
    },
    'Finance Settings': {
        component: markRaw(FinanceSetting),
        title: 'Finance Settings',
        subtitle: 'Adjust financial settings like taxes and currency here.',
        props: { settings: props.financeSettings },
    },
};

// Type for the keys of the settings object
type SettingsKey = keyof typeof settings;

// Initialize the currentSetting with the default setting ('Application Settings')
let currentSetting = ref<SettingsComponent>(settings['Application Settings']);

// Method to update currentSetting based on the selected tab
function handleTabClick(setting: SettingsKey): void {
    currentSetting.value = settings[setting];
}
</script>

<template>
    <PageHeader>
        <template #title>{{ currentSetting?.title }}</template>
        <template #subtitle>{{ currentSetting?.subtitle }}</template>
    </PageHeader>

    <TabGroup>
        <TabList class="flex space-x-1 rounded-xl bg-gray-900/20 p-1">
            <Tab
                v-for="setting in Object.keys(settings)"
                :key="setting"
                as="template"
                v-slot="{ selected }"
                @click="handleTabClick(setting as SettingsKey)"
            >
                <button
                    :class="[
                        'w-full rounded-lg py-2.5 text-sm font-medium leading-5',
                        'ring-white/60 ring-offset-2 ring-offset-gray-400 focus:outline-none focus:ring-2',
                        selected
                            ? 'bg-gray-700 text-white shadow'
                            : 'hover:bg-gray-200',
                    ]"
                >
                    {{ setting }}
                </button>
            </Tab>
        </TabList>

        <TabPanels class="mt-2">
            <TabPanel
                v-for="(setting, idx) in settings"
                :key="idx"
                class="rounded-xl bg-white p-3 shadow"
            >
                <component :is="setting.component" v-bind="setting.props" />
            </TabPanel>
        </TabPanels>
    </TabGroup>
</template>
