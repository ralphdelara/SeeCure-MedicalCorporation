import React from 'react';
import type { Pages } from '@/types/pagination';
import Pagination from './pagination';
import { FloatingScrollTable } from './floating-scroll-table';
import '@/assets/css/table.css';

const TableCounter = ({ table, tableTitle }: { table: {}[]; tableTitle: string }) => {
    return (
        <>
            <div
                style={{ letterSpacing: '0.05em', position: 'relative' }}
                className="d-flex justify-content-between mt-3"
            >
                <h4 className="fw-bolder">{tableTitle}</h4>
                <h5>
                    <span className="text-danger fw-bolder">{table.length}</span> records
                </h5>
            </div>
        </>
    );
};

export default TableCounter;
