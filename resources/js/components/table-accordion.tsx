import { IconChevronDown } from '@tabler/icons-react';
import React from 'react';

interface TableAccordionProps {
    uuid: string;
    label: string;
    cols: number;
    children?: React.ReactNode;
}

const TableAccordion = ({ uuid, label, cols, children }: TableAccordionProps) => {
    const showHideDetails = (id: string) => {
        let recordDetails = document.getElementById(id + '-record');
        let iconDetails = document.getElementById(id + '-icon');

        if (recordDetails?.classList.contains('d-none')) {
            recordDetails.classList.remove('d-none');
            iconDetails?.classList.remove('rotate-180');
        } else {
            recordDetails?.classList.add('d-none');
            iconDetails?.classList.add('rotate-180');
        }
    };

    return (
        <>
            <tr
                id={label + '-details-' + uuid}
                onClick={(e) => showHideDetails(e.currentTarget.id)}
            >
                <td colSpan={cols} className="cursor-pointer text-center">
                    <h5 className="fw-bolder">
                        {label} Details{' '}
                        <IconChevronDown id={label + '-details-' + uuid + '-icon'} />
                    </h5>
                </td>
            </tr>
            <tr id={label + '-details-' + uuid + '-record'}>
                <td colSpan={cols} className="text-center">
                    {children}
                </td>
            </tr>
        </>
    );
};

export default TableAccordion;
