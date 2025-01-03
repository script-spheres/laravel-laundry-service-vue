import { usePosStore } from '@/Stores/PosStore';
import { ref } from 'vue';

export const useCartCalculations = () => {
    const posStore = usePosStore();

    // Coupon state
    const coupon = ref<{ code: string; discount: number } | null>(null);

    // Tax rate as a reactive percentage value (e.g., 10 for 10%)
    const taxRate = ref(0);

    // Subtotal cost calculation with parseFloat and toFixed(2)
    const getSubTotalCost = () => {
        const subTotal = posStore.items.reduce(
            (acc, item) => acc + parseFloat(item.total.toString()),
            0,
        );
        return parseFloat(subTotal.toFixed(2)); // Round to two decimal places
    };

    // Tax amount calculation (taxRate in percentage converted to decimal)
    const getTaxAmount = () => {
        const taxAmount = getSubTotalCost() * (taxRate.value / 100); // Convert percentage to decimal
        return parseFloat(taxAmount.toFixed(2)); // Round to two decimal places
    };

    // Discount amount (calculated based on coupon, ensure it's a float)
    const getDiscountAmount = () => {
        if (coupon.value) {
            return parseFloat(coupon.value.discount.toString());
        }
        return 0;
    };

    // Total cost after tax and discount, parse the final value as float
    const getTotalCost = () => {
        const tax = getTaxAmount(); // Use getTaxAmount function
        const total = getSubTotalCost() + tax - getDiscountAmount();
        return parseFloat(total.toFixed(2)); // Round to two decimal places
    };

    // Total items in the cart
    const getTotalItems = () => {
        return posStore.items.reduce(
            (acc, item) => acc + parseInt(item.quantity.toString(), 10),
            0,
        );
    };

    // Apply coupon
    const applyCoupon = (code: string, discount: number) => {
        coupon.value = { code, discount: parseFloat(discount.toString()) }; // Ensure discount is a float
    };

    // Remove coupon
    const removeCoupon = () => {
        coupon.value = null;
    };

    // Update tax rate
    const setTaxRate = (rate: number) => {
        taxRate.value = parseFloat(rate.toString()); // Ensure the tax rate is a float
    };

    return {
        getTotalItems,
        getSubTotalCost,
        getTotalCost,
        getTaxAmount,
        getDiscountAmount,
        coupon,
        taxRate,
        applyCoupon,
        removeCoupon,
        setTaxRate,
    };
};
