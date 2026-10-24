import { Fragment, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-design.css';
import prescriptionBg from '@/assets/images/print-templates/prescription.png';
import prescriptionBgWithPtr from '@/assets/images/print-templates/prescription_with_ptr.png';

const Default = () => {
    const { prescription } = usePage().props as unknown as {
        prescription: {
            inventory_name: string;
            quantity: string;
            sig: string;
        }[];
    };
    const { patient, consultDate, prescriptionRemarks, rightFullName, rightPtrNo, rightLicNo } =
        usePage().props as unknown as {
            patient: {
                full_name: string;
                computed_age: string;
                gender: {
                    name: 'string';
                };
                full_address: string;
                age_computed: string;
            };
            prescriptionRemarks: string;
            leftFullName: string;
            leftPtrNo: string;
            leftLicNo: string;
            rightFullName: string;
            rightPtrNo: string;
            rightLicNo: string;
            controlNo: string;
            consultDate: string;
        };

    useEffect(() => {
        setTimeout(() => {
            //    window.print();
        }, 1000);
    }, []);

    const columns = [
        { label: 'MEDICINE', key: 'inventory_name', align: 'left', width: '1fr', isBold: true },
        { label: 'QTY', key: 'quantity', align: 'left', width: '60px', prefix: '# ' },
    ];

    const gridColsTemplate = columns.map((col) => col.width || '1fr').join(' ');

    return (
        <div className="print-design">
            {prescription.map((item, index) => (
                <div
                    style={{
                        width: '557px',
                        height: '792px',
                        position: 'relative',
                        marginTop: '1px',
                    }}
                    key={'prescription-' + index}
                >
                    <img
                        src={rightPtrNo != '' ? prescriptionBgWithPtr : prescriptionBg}
                        style={{ height: '100%', position: 'absolute', zIndex: '-1' }}
                    />
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '110px',
                            marginLeft: '105px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{patient.full_name.toUpperCase()}</b>
                    </div>
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '139px',
                            marginLeft: '105px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{patient.full_address?.toUpperCase()}</b>
                    </div>
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '168px',
                            marginLeft: '120px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{patient.gender?.name.toUpperCase() ?? ''}</b>
                    </div>
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '168px',
                            marginLeft: '255px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{patient.age_computed?.toUpperCase() ?? ''}</b>
                    </div>
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '168px',
                            marginLeft: '410px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{consultDate?.toUpperCase() ?? ''}</b>
                    </div>

                    <div
                        style={{
                            position: 'absolute',
                            fontSize: '10px',
                            marginTop: rightPtrNo != '' ? '625px' : '645px',
                            marginLeft: '335px',
                            textWrap: 'nowrap',
                            textAlign: 'center',
                            width: '200px',
                        }}
                    >
                        <b className="text-dark">{rightFullName?.toUpperCase() ?? ''}</b>
                    </div>

                    <div
                        style={{
                            position: 'absolute',
                            fontSize: '10px',
                            marginTop: rightPtrNo != '' ? '652px' : '672px',
                            marginLeft: '414px',
                            textWrap: 'nowrap',
                            textAlign: 'center',
                            width: '105px',
                        }}
                    >
                        <b className="text-dark">{rightLicNo?.toUpperCase() ?? ''}</b>
                    </div>

                    {rightPtrNo && (
                        <div
                            style={{
                                position: 'absolute',
                                fontSize: '10px',
                                marginTop: '675px',
                                marginLeft: '414px',
                                textWrap: 'nowrap',
                                textAlign: 'center',
                                width: '105px',
                            }}
                        >
                            <b className="text-dark">{rightPtrNo?.toUpperCase() ?? ''}</b>
                        </div>
                    )}

                    {prescriptionRemarks && (
                        <div
                            className="text-dark"
                            style={{
                                position: 'absolute',
                                fontSize: '11px',
                                marginTop: '615px',
                                marginLeft: '15px',
                                width: '305px',
                            }}
                        >
                            <b className="text-dark">Remarks:</b> {prescriptionRemarks}
                        </div>
                    )}
                    <div
                        className="bill-table"
                        style={{
                            position: 'absolute',
                            marginTop: '200px',
                            right: '0',
                            width: '420px', // Restrains layout explicitly to your 420px master print bounds
                            '--grid-cols': gridColsTemplate,
                        }}
                    >
                        {/* Dynamic Table Header */}
                        <div className="bill-row bill-head">
                            {columns.map((col, idx) => (
                                <span key={'th-' + idx} className={col.align || 'left'}>
                                    {col.label}
                                </span>
                            ))}
                        </div>

                        {/* Dynamic Table Body */}
                        {item.map((rowItem, rowIndex) => (
                            <Fragment key={'row-' + rowIndex + '-' + index}>
                                {/* Primary Data Row */}
                                <div
                                    className="bill-row bill-item"
                                    style={{ border: '0', paddingBottom: '0' }}
                                >
                                    {columns.map((col, colIdx) => {
                                        const value = rowItem[col.key];
                                        return (
                                            <span
                                                key={`cell-${index}-${colIdx}`}
                                                className={col.align || 'left'}
                                            >
                                                {col.isBold ? (
                                                    <b>{value}</b>
                                                ) : (
                                                    <>
                                                        {col.prefix}
                                                        {value}
                                                    </>
                                                )}
                                            </span>
                                        );
                                    })}
                                </div>

                                {/* Secondary Full-Width Instruction Row */}
                                {rowItem.sig !== null && rowItem.sig !== '' && (
                                    <div
                                        className="bill-row bill-item colspan-full"
                                        style={{ paddingTop: '0' }}
                                    >
                                        <span>
                                            <i>
                                                Sig:{' '}
                                                {rowItem.sig
                                                    .replace(/sig:/i, '') // Cleans prefixes safely using case-insensitive regex
                                                    .trim()}
                                            </i>
                                        </span>
                                    </div>
                                )}
                            </Fragment>
                        ))}
                    </div>
                </div>
            ))}
        </div>
    );
};

export default Default;
