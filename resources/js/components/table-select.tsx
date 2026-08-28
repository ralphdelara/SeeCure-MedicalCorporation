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

interface TableSelectProps extends TableHeaderProps {
    children: React.ReactNode;
}

const TableSelect = ({ header, children }: TableSelectProps) => {
    return (
        <>
            <div style={{ height: '400px', overflowY: 'auto' }}>
                <div className="table-responsive rounded-4 border">
                    <table className="table-hover table-select mb-0 table align-middle">
                        <TableHeader header={header} />
                        <tbody>
                            {children}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
};

export default TableSelect;
