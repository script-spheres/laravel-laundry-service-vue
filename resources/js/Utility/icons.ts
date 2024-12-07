import {
    AnFilledDatabase,
    BxSolidReport,
    BySettings,
    CaCloudServices,
    CaFinance,
    GlWork,
    IcBox,
    IcDashboardDots,
    IcPackages,
    McRoundLine,
    MdInventory,
    MdLoyalty,
    PhUsersFour,
} from '@kalimahapps/vue-icons';
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
