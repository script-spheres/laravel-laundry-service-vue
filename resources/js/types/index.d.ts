import { Config } from 'ziggy-js';

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

export type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};
