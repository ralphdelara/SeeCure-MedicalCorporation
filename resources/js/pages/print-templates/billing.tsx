import { Fragment, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-design.css';
import billingBg from '@/assets/images/print-templates/billing.png';
import { formatMoney } from '@/lib/utils';

const Default = () => {
    const { printTitle, billing, discountType, discountIdNo, discountPercent } = usePage()
        .props as unknown as {
        printTitle: string;
        billing: {
            details: {
                name: string;
                cost_price: string;
                quantity: string;
                total_price: string;
                discount: string;
                tax_percent: string;
                nett_price: string;
            }[];
            total_cost_price: string;
            total_quantity: string;
            total_price: string;
            total_discount: string;
            total_tax: string;
            total_nett_price: string;
            transaction_header: string;
            transaction_no: string;
            visit: {
                patient: {
                    full_name: string;
                    control_no: string;
                    computed_age: string;
                    gender: {
                        name: 'string';
                    };
                    full_address: string;
                    age_computed: string;
                };
                consultation: {
                    doctor: {
                        full_name: string;
                        physician_last_name: string;
                    };
                };
            };
            created_at: string;
        };
        printedBy: string;
        discountType: string;
        discountIdNo: string;
        discountPercent: string;
    };

    useEffect(() => {
        setTimeout(() => {
            //window.print();
        }, 1000);
    }, []);
    const columns = [
        { label: 'ITEM', key: 'name', align: 'left', width: '2fr' }, // item name gets double width
        { label: 'UNIT PRICE', key: 'cost_price', align: 'right', width: '1fr' },
        { label: 'QTY', key: 'quantity', align: 'center', width: '60px', prefix: '' },
        { label: 'TOTAL PRICE', key: 'total_price', align: 'right', width: '1fr' },
    ];

    // 2. Generate the dynamic grid template track string
    // e.g. "2fr 1fr 60px 1fr"
    const gridColsTemplate = columns.map((col) => col.width || '1fr').join(' ');
    return (
        <div className="print-design">
            {billing.details.map((item, index) => (
                <div
                    style={{
                        width: '557px',
                        height: '792px',
                        position: 'relative',
                        marginTop: '1px',
                    }}
                    key={'billing-' + index}
                >
                    <img
                        src={billingBg}
                        style={{ height: '100%', position: 'absolute', zIndex: '-1' }}
                    />
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '105px',
                            marginLeft: '105px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{billing.visit.patient?.full_name}</b>
                    </div>
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '134px',
                            marginLeft: '105px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{billing.visit.patient?.full_address}</b>
                    </div>
                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '163px',
                            marginLeft: '358px',
                            fontSize: '11px',
                            width: '70px',
                            textAlign: 'center',
                        }}
                    >
                        <b className="text-dark">{billing.visit.patient?.gender?.name ?? ''}</b>
                    </div>

                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '163px',
                            marginLeft: '470px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">{billing.visit.patient?.age_computed ?? ''}</b>
                    </div>

                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '163px',
                            marginLeft: '80px',
                            fontSize: '11px',
                            width: '70px',
                            textAlign: 'center',
                        }}
                    >
                        <b className="text-dark">{billing.transaction_no ?? ''}</b>
                    </div>

                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '163px',
                            marginLeft: '227px',
                            fontSize: '11px',
                            width: '70px',
                            textAlign: 'center',
                        }}
                    >
                        <b className="text-dark">{billing.visit.patient?.control_no ?? ''}</b>
                    </div>

                    <div
                        style={{
                            position: 'absolute',
                            marginTop: '105px',
                            marginLeft: '375px',
                            fontSize: '11px',
                        }}
                    >
                        <b className="text-dark">
                            {billing.visit.consultation?.doctor?.full_name ?? ''}
                        </b>
                    </div>

                    <div
                        className="bill-table"
                        style={{
                            position: 'absolute',
                            marginTop: '200px',
                            marginLeft: '1%',
                            width: '98%',
                            // Pass the layout configuration straight to the CSS variable
                            '--grid-cols': gridColsTemplate,
                        }}
                    >
                        {/* Table Header Row */}
                        <div className="bill-row bill-head">
                            {columns.map((col, idx) => (
                                <span key={'th-' + idx} className={col.align || 'left'}>
                                    {col.label}
                                </span>
                            ))}
                        </div>

                        {/* Table Body Rows */}
                        {item.map((rowItem, rowIndex) => (
                            <Fragment key={'row-' + rowIndex + '-' + index}>
                                {rowItem !== null && (
                                    <div className="bill-row bill-item">
                                        {columns.map((col, colIdx) => {
                                            let value;
                                            if (
                                                col.key === 'cost_price' ||
                                                col.key === 'total_price'
                                            ) {
                                                value = formatMoney(rowItem[col.key]);
                                            } else if (col.key === 'name') {
                                                value = <b>{rowItem[col.key]}</b>;
                                            } else {
                                                value = rowItem[col.key];
                                            }
                                            return (
                                                <span
                                                    key={`cell-${rowIndex}-${colIdx}`}
                                                    className={col.align || 'left'}
                                                >
                                                    {col.prefix}
                                                    {value}
                                                </span>
                                            );
                                        })}
                                    </div>
                                )}
                            </Fragment>
                        ))}
                        {billing.details.length === index + 1 && (
                            <>
                                {billing.total_discount > 0 && (
                                    <>
                                        <div className="bill-row bill-item colspan-3">
                                            <span
                                                className="right"
                                                style={{ fontSize: '14px', fontWeight: 'bold' }}
                                            >
                                                SUB TOTAL AMOUNT
                                            </span>
                                            <span
                                                className="right"
                                                style={{ fontSize: '14px', fontWeight: 'bold' }}
                                            >
                                                {formatMoney(billing.total_price)}
                                            </span>
                                        </div>
                                        <div className="bill-row bill-item colspan-3">
                                            <span
                                                className="right"
                                                style={{ fontSize: '14px', fontWeight: 'bold' }}
                                            >
                                                DISCOUNT{' '}
                                                <small>
                                                    ({discountType}:{discountIdNo})
                                                </small>
                                            </span>
                                            <span
                                                className="right"
                                                style={{ fontSize: '14px', fontWeight: 'bold' }}
                                            >
                                                {formatMoney(billing.total_discount)}
                                            </span>
                                        </div>
                                    </>
                                )}
                                <div className="bill-row bill-item colspan-3">
                                    <span
                                        className="right"
                                        style={{ fontSize: '14px', fontWeight: 'bold' }}
                                    >
                                        TOTAL AMOUNT DUE
                                    </span>
                                    <span
                                        className="right"
                                        style={{ fontSize: '14px', fontWeight: 'bold' }}
                                    >
                                        {formatMoney(billing.total_nett_price)}
                                    </span>
                                </div>
                            </>
                        )}
                    </div>
                </div>
            ))}
        </div>
    );
};

export default Default;
