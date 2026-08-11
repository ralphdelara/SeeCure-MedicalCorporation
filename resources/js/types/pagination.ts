export interface PageLinks {
    active: boolean;
    label: string;
    page: number;
    url: string;
}

export interface Pages {
    current_page: number;
    links: PageLinks[];
    last_page_url: string;
    first_page_url: string;
    from: number;
    to: number;
    total: number;
    path: string;
}
