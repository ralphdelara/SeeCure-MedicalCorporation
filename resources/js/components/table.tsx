import { Pages } from '@/types/pagination';
import React from 'react';
import Pagination from './pagination';

interface TableHeaderProps {
    header: {
        name: string;
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
                        <h6 className={'fs-4 fw-semibold mb-0 text-' + item.align}>{item.name}</h6>
                    </th>
                ))}
            </tr>
        </thead>
    );
}

interface TableListProps extends TableHeaderProps {
    pageData: Pages;
    children: React.ReactNode;
}

const TableList = ({ header, pageData, children }: TableListProps) => {
    return (
        <>
            <Pagination pageData={pageData} />
            <div className="table-responsive rounded-4 border">
                <table className="table-hover mb-0 table align-middle">
                    <TableHeader header={header} />
                    <tbody>{children}</tbody>
                </table>
            </div>

            <Pagination pageData={pageData} />
        </>
    );
};

export default TableList;
