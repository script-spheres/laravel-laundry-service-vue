export const statusOptions: Record<string, string> = {
    active: 'Active',
    inactive: 'Inactive',
};

export const yesNoOptions: Record<string, string> = {
    yes: 'Yes',
    no: 'No',
};

export const dietaryOptions: Record<string, string> = {
    vegetarian: 'Vegetarian',
    vegan: 'Vegan',
    gluten_free: 'Gluten-Free',
    dairy_free: 'Dairy-Free',
    nut_free: 'Nut-Free',
    halal: 'Halal',
    kosher: 'Kosher',
};

export const bookingStatusOptions: Record<string, string> = {
    pending: 'Pending',
    approve: 'Approve',
    decline: 'Decline',
};

export const deliveryStatusOptions: Record<string, string> = {
    pending: 'Pending',
    in_transit: 'In Transit',
    delivered: 'Delivered',
    cancelled: 'Cancelled',
    returned: 'Returned',
};

export const deliveryTypeOptions: Record<string, string> = {
    standard: 'Standard',
    express: 'Express',
    overnight: 'Overnight',
    international: 'International',
};

export const discountTypeOptions: Record<string, string> = {
    percentage: 'Percentage',
    flat: 'Fixed Amount',
};

export const foodTypeOptions: Record<string, string> = {
    appetizer: 'Appetizer',
    main_course: 'Main Course',
    dessert: 'Dessert',
    beverage: 'Beverage',
    snack: 'Snack',
};

export const kitchenStatusOptions: Record<string, string> = {
    open: 'Open',
    closed: 'Closed',
    under_maintenance: 'Under Maintenance',
    renovation: 'Renovation',
    temporarily_closed: 'Temporarily Closed',
};

export const menuTypeOptions: Record<string, string> = {
    breakfast: 'Breakfast',
    lunch: 'Lunch',
    dinner: 'Dinner',
    snack: 'Snack',
    dessert: 'Dessert',
};

export const orderStatusOptions: Record<string, string> = {
    pending: 'Pending',
    'in-progress': 'In Progress',
    'ready-to-deliver': 'Ready To Deliver',
    delivered: 'Delivered',
};

export const orderTypeOptions: Record<string, string> = {
    dine_in: 'Dine In',
    take_away: 'Take Away',
    delivery: 'Delivery',
    catering: 'Catering',
};

export const paymentModeOptions: Record<string, string> = {
    credit_card: 'Credit Card',
    debit_card: 'Debit Card',
    paypal: 'PayPal',
    cash: 'Cash',
    bank_transfer: 'Bank Transfer',
};

export const paymentStatusOptions: Record<string, string> = {
    pending: 'Pending',
    completed: 'Completed',
    failed: 'Failed',
    refunded: 'Refunded',
    disputed: 'Disputed',
};

export const serviceTypeOptions: Record<string, string> = {
    delivery: 'Delivery',
    pickup: 'Pickup',
    dine_in: 'Dine In',
    catering: 'Catering',
    takeaway: 'Takeaway',
};

export const tableTypeOptions: Record<string, string> = {
    indoor: 'Indoor',
    outdoor: 'Outdoor',
    reserved: 'Reserved',
    available: 'Available',
    vip: 'VIP',
};

export const rolesOptions: Record<string, string> = {
    admin: 'Admin',
    restaurant_owner: 'Restaurant Owner',
    customer: 'Customer',
    staff: 'Staff',
};
