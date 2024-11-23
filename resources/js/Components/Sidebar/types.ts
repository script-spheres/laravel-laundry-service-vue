export interface NavigationItem {
    label: string;
    icon: string;
    href?: string;
    component: string;
    child?: NavigationItem[];
}
