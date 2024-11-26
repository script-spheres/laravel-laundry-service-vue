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

export type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
};

export type Coupon = {
    id: number;
    title: string;
    description: string;
    code: string;
    min_amount: number;
    max_amount: number;
    valid_from: string;
    valid_to: string;
    discount_type: string;
    discount_amount: number;
    discount_percentage: number;
    usage_limit: number;
    used_count: number;
    active_status: ActiveStatus;
};

export interface FinancialYear {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
    description?: string;
    active_status: ActiveStatus;
}

export type Banner = {
    id: number;
    title: string;
    description: string;
    image: Image;
    active_status: ActiveStatus;
};

export interface Store {
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
    active_status: ActiveStatus;
    created_at?: string;
    updated_at?: string;
}

export interface Customer {
    id: number;
    name: string;
    email: string;
    phone_number: string;
    address: string | null;
    communication_pref: string | null;
}

export interface ServiceType {
    id: number;
    type_name: string;
    description: string;
    active_status: ActiveStatus;
}

export interface Service {
    id: number;
    service_name: string;
    description: string | null;
    store_id: number;
    image: string | null;
    active_status: ActiveStatus;
}
export interface Timeslot {
    id: number;
    start_time: string;
    end_time: string;
    day: string | null;
    capacity: number;
    active_status: ActiveStatus;
}

export interface Expense {
    id: number;
    category: string;
    amount: number;
    store_id: number;
    store_name: string;
    receipt: string | null;
}
export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
    flash?: {
        message?: string;
    };
    navigations?: NavigationItem[];
};
