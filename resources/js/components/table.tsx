import React from 'react';
import type { Pages } from '@/types/pagination';
import Pagination from './pagination';
import { FloatingScrollTable } from './floating-scroll-table';
import '@/assets/css/table.css';

interface TableHeaderProps {
    header: {
        name: string | React.ReactNode;
        width?: string;
        align: string;
        className?: string;
    }[];
}

export function TableHeader({ header }: TableHeaderProps) {
    return (
        <thead className="text-dark fs-4 table-success border-success">
            <tr>
                {header.map((item, index) => (
                    <th
                        style={item.width ? { width: item.width } : {}}
                        className={item.className}
                        key={'header-' + index}
                    >
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
            <FloatingScrollTable>
                <table className="table-hover mb-0 table align-middle text-nowrap">
                    <TableHeader header={header} />
                    <tbody>{children}</tbody>
                </table>
            </FloatingScrollTable>
            {hasPage && pageData && <Pagination pageData={pageData} bottom={true} />}
        </>
    );
};

export default TableList;
