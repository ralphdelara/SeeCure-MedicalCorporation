import {
    printBilling,
    printLaboratory,
    printPharmacyPickList,
    printPrescription,
    printReceipt,
} from '@/actions/App/Http/Controllers/PrintController';
import { NormalRangeProps } from '@/pages/laboratory/details/details-test-fields';
import { callOutPatient } from '@/routes/system';
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

        // this fixes the js errors if theres no content response
        if (url === callOutPatient().url && [200, 204].includes(response.status)) {
            return null;
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

export function formatReceiptDateTime(str: string, type?: string | null) {
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
    if (type === 'dateOnly') {
        return `${month}/${day}/${year}`;
    }

    return `${month}/${day}/${year} ${strHours}:${minutes}:${seconds} ${ampm}`;
}

export function isImage(ext: string) {
    return ['png', 'jpg', 'jpeg', 'gif', 'bmp'].includes(ext);
}

export function computeNettPrice(setData: any, data: any, field: string, value: string) {
    setData(field, value);

    // Safely parse all numbers from our updated item copy
    let cost_price = isNaN(parseFloat(data.cost_price as string))
        ? 0.0
        : parseFloat(data.cost_price as string);
    let quantity = isNaN(parseFloat(data.quantity as string))
        ? 0
        : parseFloat(data.quantity as string);
    let discount = isNaN(parseFloat(data.discount as string))
        ? 0.0
        : parseFloat(data.discount as string);
    let tax_percent = isNaN(parseFloat(data.tax_percent as string))
        ? 0.0
        : parseFloat(data.tax_percent as string);

    if (field === 'cost_price') {
        cost_price = parseFloat(value);
        cost_price = isNaN(cost_price) ? 0.0 : cost_price;
    }

    if (field === 'quantity') {
        quantity = parseFloat(value);
        quantity = isNaN(quantity) ? 0.0 : quantity;
    }

    if (field === 'discount') {
        discount = parseFloat(value);
        discount = isNaN(discount) ? 0.0 : discount;
    }

    if (field === 'tax_percent') {
        tax_percent = parseFloat(value);
        tax_percent = isNaN(tax_percent) ? 0.0 : tax_percent;
    }

    const total_price = (cost_price * quantity).toFixed(2);
    const basePrice = parseFloat(total_price) - discount;
    const tax_amount = (basePrice * (tax_percent / 100)).toFixed(2);
    const nett_price = (basePrice + parseFloat(tax_amount)).toFixed(2);

    setData('total_price', total_price);
    setData('tax_amount', tax_amount);
    setData('nett_price', nett_price);
}

export function computeNettPriceDetails(setData: any, id: string, field: string, value: string) {
    const parsedValue = isNaN(parseFloat(value)) ? 0.0 : value;

    setData((prevData: any) => {
        // Get the current item or fallback to empty values if it doesn't exist yet
        const currentItem = prevData[id] || {
            cost_price: '',
            quantity: '',
            total_price: '',
            discount: '',
            discount_type_id: '',
            tax_percent: '',
            nett_price: '',
        };

        // Create a fresh copy of the item and apply the new dynamic field value
        const updatedItem = {
            ...currentItem,
            [field]: parsedValue,
        };

        const allBlank =
            updatedItem.cost_price === '' &&
            updatedItem.quantity === '' &&
            updatedItem.total_price === '' &&
            updatedItem.discount === '' &&
            updatedItem.tax_percent === '' &&
            updatedItem.nett_price === '';

        // Safely parse all numbers from our updated item copy
        const cost_price = isNaN(parseFloat(updatedItem.cost_price as string))
            ? 0.0
            : parseFloat(updatedItem.cost_price as string);
        const quantity = isNaN(parseFloat(updatedItem.quantity as string))
            ? 0
            : parseFloat(updatedItem.quantity as string);
        const discount = isNaN(parseFloat(updatedItem.discount as string))
            ? 0.0
            : parseFloat(updatedItem.discount as string);
        const tax_percent = isNaN(parseFloat(updatedItem.tax_percent as string))
            ? 0.0
            : parseFloat(updatedItem.tax_percent as string);

        updatedItem.total_price = allBlank ? '' : (cost_price * quantity).toFixed(2);
        const basePrice = updatedItem.total_price - discount;
        const totalNettPrice = (basePrice * (1 + tax_percent / 100)).toFixed(2);
        updatedItem.nett_price = allBlank ? '' : totalNettPrice;

        let totals = totalValues({ ...prevData, [id]: updatedItem });

        // Return a completely fresh state object
        return {
            ...prevData,
            [id]: updatedItem,
            total_cost_price: totals.totalCostPrice,
            total_quantity: totals.totalQuantity,
            total_price: totals.totalPrice,
            total_discount: totals.totalDiscount,
            total_nett_price: totals.totalNettPrice,
        };
    });
}

const totalValues = (tmpData: any) => {
    let totalCostPrice = 0;
    let totalQuantity = 0;
    let totalPrice = 0;
    let totalDiscount = 0;
    let totalNettPrice = 0;

    Object.values(tmpData).forEach((item) => {
        if (typeof item !== 'object' || item === null) {
            return;
        }

        // Cast 'item' so TypeScript knows it has dynamic string keys
        const product = item as Record<string, any>;

        if (!isNaN(parseFloat(product.cost_price))) {
            totalCostPrice += parseFloat(product.cost_price);
        }

        if (!isNaN(parseFloat(product.cost_price))) {
            totalQuantity += parseFloat(product.quantity);
        }

        if (!isNaN(parseFloat(product.cost_price))) {
            totalPrice += parseFloat(product.cost_price) * parseFloat(product.quantity);
        }

        if (!isNaN(parseFloat(product.discount))) {
            totalDiscount += parseFloat(product.discount);
        }

        if (!isNaN(parseFloat(product.nett_price))) {
            totalNettPrice += parseFloat(product.nett_price);
        }
    });

    return {
        totalCostPrice: totalCostPrice.toFixed(2),
        totalQuantity: totalQuantity.toFixed(2),
        totalPrice: totalPrice.toFixed(2),
        totalDiscount: totalDiscount.toFixed(2),
        totalNettPrice: totalNettPrice.toFixed(2),
    };
};