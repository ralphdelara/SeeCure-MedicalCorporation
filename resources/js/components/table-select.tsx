import React, { useEffect, useState } from 'react';
import type { Pages } from '@/types/pagination';
import Pagination from './pagination';
import { Item } from '@radix-ui/react-dropdown-menu';

interface TableHeaderProps {
    header: {
        name: string | React.ReactNode;
        width: string;
        align: string;
    }[];
}

export function TableHeader({ header }: TableHeaderProps) {
    return (
        <thead className="text-dark fs-4 table-success border-success">
            <tr>
                {header.map((item, index) => (
                    <th style={{ width: item.width }} key={'header-' + index}>
                        <h6 className={'fs-4 fw-semibold text-' + item.align + ' mb-0'}>
                            {item.name}
                        </h6>
                    </th>
                ))}
            </tr>
        </thead>
    );
}

interface TableFields {
    data: any;
    setData: (key: keyof any, value: any) => void;
    errors?: Record<string, string>;
}

interface TableSelectProps extends TableHeaderProps, TableFields {
    options: {
        id: number;
    }[];
}

const TableSelect = ({ header, options, data, setData }: TableSelectProps) => {
    const updateSelected = (id: number) => {
        const selectedIdsTemp = data.ids;
        const selectedTextTemp = data.text;
        const text = document
            .getElementById('row-' + id)
            ?.innerHTML.replace(/<\/?[^>]+(>|$)/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();
        const selectIdIndex = selectedIdsTemp.indexOf(id);
        const selectTextIndex = selectedTextTemp.indexOf(text ?? '');

        if (selectIdIndex !== -1) {
            selectedIdsTemp.splice(selectIdIndex);
        } else {
            selectedIdsTemp.push(id);
        }

        if (selectTextIndex !== -1) {
            selectedTextTemp.splice(selectTextIndex);
        } else {
            selectedTextTemp.push(text ?? '');
        }

        setData('ids', selectedIdsTemp);
        setData('text', selectedTextTemp);
    };

    return (
        <>
            <div style={{ height: '400px', overflowY: 'auto' }}>
                <div className="table-responsive rounded-4 border">
                    <table className="table-hover table-select mb-0 table align-middle">
                        <TableHeader header={header} />
                        <tbody>
                            {options.map((item, index) => (
                                <tr
                                    key={'tr-' + item.id}
                                    id={'row-' + item.id}
                                    onClick={() => updateSelected(item.id)}
                                    className={
                                        data.ids.includes(item.id)
                                            ? 'border-start border-success border-3'
                                            : ''
                                    }
                                >
                                    {Object.entries(item).map(([key, value]) => {
                                        if (key !== 'id') {
                                            return <td key={'td-' + key + '-' + index}>{value}</td>;
                                        }
                                    })}
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
};

export default TableSelect;
