import { IcBox, IcDashboardDots, McRoundLine } from '@kalimahapps/vue-icons';
import { BySettings } from '@kalimahapps/vue-icons';
import { BxSolidReport } from '@kalimahapps/vue-icons';
import { PhUsersFour } from '@kalimahapps/vue-icons';
import { CaCloudServices } from '@kalimahapps/vue-icons';
import { IcPackages } from '@kalimahapps/vue-icons';
import { AnFilledDatabase } from '@kalimahapps/vue-icons';
import { MdInventory } from '@kalimahapps/vue-icons';
import { MdLoyalty } from '@kalimahapps/vue-icons';
import { GlWork } from '@kalimahapps/vue-icons';
import { CaFinance } from '@kalimahapps/vue-icons';
const getIcon = (icon: string) => {
    switch (icon) {
        case 'IcDashboardDots':
            return IcDashboardDots;
        case 'box':
            return IcBox;
        case 'McRoundLine':
            return McRoundLine;
        case 'BySettings':
            return BySettings;
        case 'BxSolidReport':
            return BxSolidReport;
        case 'PhUsersFour':
            return PhUsersFour;
        case 'CaCloudServices':
            return CaCloudServices;
        case 'IcPackages':
            return IcPackages;
        case 'AnFilledDatabase':
            return AnFilledDatabase;
        case 'MdInventory':
            return MdInventory;
        case 'MdLoyalty':
            return MdLoyalty;
        case 'GlWork':
            return GlWork;
        case 'CaFinance':
            return CaFinance;
        default:
            return null;
    }
};

export default getIcon;
