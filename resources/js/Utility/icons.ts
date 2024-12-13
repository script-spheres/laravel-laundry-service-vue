import {
    AnFilledDatabase,
    BxSolidCoupon,
    BxSolidReport,
    BySettings,
    CaCloudServices,
    CaCustomerService,
    CaFinance,
    FlFilledDualScreenStatusBar,
    GlWork,
    IcBox,
    IcDashboardDots,
    IcPackages,
    McRoundLine,
    MdInventory,
    MdLoyalty,
    MdPointOfSale,
    PhUsersFour,
} from '@kalimahapps/vue-icons';

const iconMap: Record<string, any> = {
    IcDashboardDots,
    IcBox,
    McRoundLine,
    BySettings,
    BxSolidReport,
    PhUsersFour,
    CaCloudServices,
    IcPackages,
    AnFilledDatabase,
    MdInventory,
    MdLoyalty,
    GlWork,
    CaFinance,
    CaCustomerService,
    BxSolidCoupon,
    MdPointOfSale,
    FlFilledDualScreenStatusBar,
};

const getIcon = (icon: string) => iconMap[icon] || null;

export default getIcon;
