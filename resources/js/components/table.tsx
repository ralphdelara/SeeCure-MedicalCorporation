import React from 'react';
import type { Pages } from '@/types/pagination';
import Pagination from './pagination';

interface TableHeaderProps {
    header: {
        name: string|React.ReactNode;
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

interface TableListProps extends TableHeaderProps {
    pageData?: Pages;
    children: React.ReactNode;
    hasPage?: boolean;
}

const TableList = ({ header, pageData, children, hasPage = true }: TableListProps) => {
    return (
        <>
            {hasPage && pageData && <Pagination pageData={pageData} />}
            <div className="table-responsive rounded-4 border">
                <table className="table-hover mb-0 table align-middle">
                    <TableHeader header={header} />
                    <tbody>{children}</tbody>
                </table>
            </div>
            {hasPage && pageData && <Pagination pageData={pageData} />}
        </>
    );
};

export default TableList;
