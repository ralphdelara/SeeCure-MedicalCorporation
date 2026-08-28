import type { InertiaLinkProps } from '@inertiajs/react';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(url: NonNullable<InertiaLinkProps['href']>): string {
    return typeof url === 'string' ? url : url.url;
}

export function getExactAge(startDate: string, endDate: string) {
    const start = new Date(startDate);
    const end = new Date(endDate);

    let years = end.getFullYear() - start.getFullYear();
    let months = end.getMonth() - start.getMonth();
    let days = end.getDate() - start.getDate();

    if (days < 0) {
        months--;
        const previousMonth = new Date(end.getFullYear(), end.getMonth(), 0);
        days += previousMonth.getDate();
    }

    if (months < 0) {
        years--;
        months += 12;
    }

    return { years, months, days };
}

export function formatMoney(amount: string) {
    return parseFloat(amount).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

export async function fetchUrl(url: string, method: string, data: object) {
    const upperMethod = method.toUpperCase();

    const options: RequestInit = {
        method: upperMethod,
        headers: {
            'Content-Type': 'application/json',
        },
    };

    let finalUrl = url;

    if (upperMethod === 'GET' && data) {
        const searchParams = new URLSearchParams(data as Record<string, string>);
        finalUrl = `${url}?${searchParams.toString()}`;
    } else if (data) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(finalUrl, options);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error(`Fetch failed for ${upperMethod} request:`, error);
        throw error;
    }
}
