import {
    printBilling,
    printLaboratory,
    printPharmacyPickList,
    printPrescription,
    printReceipt,
} from '@/actions/App/Http/Controllers/PrintController';
import { NormalRangeProps } from '@/pages/laboratory/details/details-test-fields';
import type { InertiaLinkProps } from '@inertiajs/react';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { toast } from 'react-hot-toast';
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

export function formatMoney(amount: string | number) {
    return (
        '₱' +
        parseFloat(amount.toString()).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    );
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

export function getIdsFromArrayData(data: any[]) {
    const arr: any[] = [];

    data.map((item) => {
        arr.push(item.id);
    });

    return arr;
}

export function formSubmitResponse(type: string) {
    return {
        onSuccess: () => {
            toast.success(type + ' has been saved!');
        },
        onError: () => {
            toast.error('Something went wrong!, Please try again.');
        },
        preserveScroll: true,
    };
}

export function getUrlParams(param: string, defaultValue?: string) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    return urlParams.get(param) ?? defaultValue ?? '';
}

export function convertSnakeToTitleCase(word: string) {
    return word.replace(/_/g, ' ').replace(/\b\w/g, (match) => match.toUpperCase());
}

const parseNormalRange = (min: string, max: string) => {
    if (min === '') {
        return max;
    }

    if (max === '') {
        return max;
    }

    return min + ' - ' + max;
};

export function getNormalRange(field: NormalRangeProps, gender_id: number) {
    const normalRangeBothMin = field.normal_range_both_min ?? '';
    const normalRangeFemaleMin = field.normal_range_female_min ?? '';
    const normalRangeMaleMin = field.normal_range_male_min ?? '';

    const normalRangeBothMax = field.normal_range_both_max ?? '';
    const normalRangeFemaleMax = field.normal_range_female_max ?? '';
    const normalRangeMaleMax = field.normal_range_male_max ?? '';

    if (gender_id === 1) {
        // 1 - Female
        return parseNormalRange(normalRangeFemaleMin, normalRangeFemaleMax);
    } else if (gender_id === 2) {
        // 2 - Male
        return parseNormalRange(normalRangeMaleMin, normalRangeMaleMax);
    } else {
        return parseNormalRange(normalRangeBothMin, normalRangeBothMax);
    }
}

export function printDocument(type: string, id: string) {
    if (type === 'prescription') {
        window.open(printPrescription(id).url);
    }

    if (type === 'billing') {
        window.open(printBilling(id).url);
    }

    if (type === 'laboratory') {
        window.open(printLaboratory(id).url);
    }

    if (type === 'receipt') {
        window.open(printReceipt(id).url);
    }

    if (type === 'pharmacy') {
        window.open(printPharmacyPickList(id).url);
    }
}

export function addZeroes(number: string | number, maxZero: number) {
    return String(number).padStart(maxZero, '0');
}

export function formatReceiptDateTime(str: string) {
    const cleanedStr = str.replace(',', '').trim();
    const date = new Date(cleanedStr);

    // Keep month and day as numbers (or unpadded strings) for single digits
    const month = date.getMonth() + 1; // 1-12
    const day = date.getDate(); // 1-31
    const year = date.getFullYear();

    let hours = date.getHours();
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    // Convert 24-hour time to 12-hour AM/PM format
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // The hour '0' should be '12'
    const strHours = String(hours).padStart(2, '0');

    // Output format: M/d/Y h:i:s A
    return `${month}/${day}/${year} ${strHours}:${minutes}:${seconds} ${ampm}`;
}
