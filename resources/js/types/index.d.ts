import { Config } from 'ziggy-js';

export type NavigationItem = {
    title: string;
    url: string;
    active: boolean;
    attributes: {
        icon: string;
    };
    children: NavigationItem[];
    depth: number;
};

interface PaginationLink {
    label: string;
    url?: string;
    active?: boolean;
}

export type FlashMessage = {
    type: string;
    message: string;
};

interface PaginationMeta {
    current_page: number;
    per_page: number;
    last_page_url: string;
    next_page_url?: string;
    total: number;
    from: number;
    links: PaginationLink[];
}

export type PaginatedData<T = never> = {
    data: T[];
    meta: PaginationMeta;
};

export type Image = {
    dirname: string;
    basename: string;
    extension: string;
    filename: string;
    location: string;
    url: string;
};

export type Role = {
    id: number;
    name: string;
    permissions: Permission[];
    created_at: string;
    updated_at: string;
};

export type User = {
    id: number;
    name: string;
    image: Image;
    email: string;
    email_verified_at?: string;
    roles: string[];
    password?: string;
};

export type Permission = {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
};

export type ExpenseType = {
    id: number;
    name: string;
    description: string;
    status: Status;
};

export type OrderLabel = {
    id: number;
    name: string;
    description: string;
    status: Status;
};

export type Coupon = {
    id: number;
    title: string;
    description: string;
    code: string;
    discount_type: string;
    max_discount_amount: number;
    discount_percentage: number;
    min_order_amount: number;
    status: Status;
};

export type FinancialYear = {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
    description?: string;
    status: Status;
};

export type Category = {
    id: number;
    name: string;
    description: string;
    image: Image;
    status: Status;
};

export type City = {
    id: number;
    name: string;
    description: string;
    status: Status;
};

export type Unit = {
    id: number;
    actual_name: string;
    short_name: string;
    allow_decimal: string;
    status: Status;
};

export type Banner = {
    id: number;
    title: string;
    description: string;
    image: Image;
    status: Status;
};

export type Store = {
    id: number;
    financial_year_id: number;
    name: string;
    address?: string;
    address_lat?: number;
    address_long?: number;
    email: string;
    phone_number: string;
    manager_name?: string;
    manager_email?: string;
    manager_phone_number?: string;
    additional_info?: string;
    store_code?: string;
    status: Status;
    created_at?: string;
    updated_at?: string;
};

export type Customer = {
    id: number;
    name: string;
    email: string;
    phone_number: string;
    address: string | null;
    communication_pref: string | null;
    image: Image;
};

export type Service = {
    id: number;
    name: string;
    image: Image;
    description: string;
    status: Status;
};

export type ServiceItem = {
    id: number;
    name: string;
    description: string | null;
    image: Image;
    service_details: ServiceDetail[];
    status: Status;
};

export type ServiceDetail = {
    id: number;
    service_id: number;
    category_id: number;
    unit_id: number;
    service_item_id: number;
    service: Service;
    service_item: ServiceItem;
    category: Category;
    unit: Unit;
    price: number;
    quantity: number;
};

export type AddonService = {
    id: number;
    name: string;
    image: Image;
    description: string;
    price: number;
    status: Status;
};

export type Timeslot = {
    id: number;
    day: string | null;
    start_time: string;
    end_time: string;
    status: Status;
};

export type Order = {
    id: number;
    order_uuid: string;
    order_display_id: string | null;
    customer_id: number;
    store_id: number;
    total_weight_kg: number;
    tax_percentage: number;
    sub_total: number;
    total_amount: number;
    tax_amount: number;
    discount_amount: number;
    paid_amount: number;
    due_amount: number;
    delivery_date: string;
    quick_note: string | null;
    order_label: OrderLabel;
    payments: Payment[];
    store: Store;
    customer: Customer;
    order_details: OrderDetail[];
    order_status: string;
    created_at: string;
};

export type OrderDetail = {
    id: number;
    order_id: number;
    serviceable_type: string;
    serviceable_id: number;
    price: number;
    quantity: number;
    info: {
        service_name: string;
        service_image: Image;
        unit_name: string;
        color: string;
    };
};

export type DeliveryScale = {
    id: number;
    radius: string;
    radius_unit: string;
    min_order_amount: string;
    delivery_charges: string;
    status: 'active' | 'inactive';
    created_at: string | null;
    updated_at: string | null;
    deleted_at: string | null;
};

export type Payment = {
    id: number;
    payment_date: string;
    payment_method: string;
    payment_status: string;
    amount: number;
    order: Order;
    created_at: string;
};

export type Expense = {
    id: number;
    expense_type_id: number;
    store_id: number;
    expense_type: ExpenseType;
    amount: number;
    store: Store;
    store_name: string;
    date: string;
    note: string;
};

export type CartItem = {
    id: number;
    serviceable_type: string;
    serviceable_id: string | number;
    info: {
        service_name: string;
        service_image: Image;
        unit_name: string;
        color: string;
    };
    price: number;
    quantity: number;
    total: number;
};

export type Review = {
    id: number;
    title: string;
    review: string;
    in_testimonial: boolean;
    rating: number;
    order_id: number;
    customer_id: number;
    order: Order;
    customer: Customer;
};

export type About = {
    title: string;
    description: string;
    features: string[];
};

export type HeroSection = {
    title: string;
    description: string;
};

export type Faq = {
    id: number;
    question: string;
    answer: string;
};

export type GeneralSettings = {
    site_name: string;
    slogan: string;
    logo: Image;
    favicon: Image;
};

export type FinanceSettings = {
    tax_rate: number;
    currency: string;
    currency_symbol: string;
    discount_rate: number;
    payment_terms: number;
    minimum_order_value: number;
    transaction_fee: number;
    rounding: number;
};

export type BusinessSettings = {
    name: string;
    address: string;
    city: string;
    state: string;
    country: string;
    zip_code: string;
    email: string;
    tax_number: string;
    country_code: string;
};

export type OtherSettings = {
    name: string;
    address: string;
    city: string;
    state: string;
    country: string;
    zip_code: string;
    email: string;
    tax_number: string;
    country_code: string;
};

export type Status = 'active' | 'inactive';

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth?: {
        user?: User;
        permissions: string[];
    };
    app: {
        name: string;
        image: string;
        url: string;
        version: string;
        environment: string;
    };
    ziggy: Config & { location: string };
    flash?: {
        message?: string;
    };
    navigations?: NavigationItem[];
};
