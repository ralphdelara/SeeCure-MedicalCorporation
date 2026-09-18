import { useEffect } from 'react';
import Footer from './laboratory-footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { formatMoney, getNormalRange } from '@/lib/utils';
import Header from './header';
import { Item } from '@radix-ui/react-dropdown-menu';
import { Fragment } from 'react';
import HeaderDetails from './laboratory-header';

const LaboratoryUri = ({ item, index }) => {
    const { printData, patient, remarksTest } = usePage().props as unknown as {
        printTitle: string;
        printData: {
            name: string;
            cost_price: string;
            quantity: string;
        }[];
    };
    const leftTableFields = [];
    const rightTableFields = [];
    let labelCount = 0;

    item.data.forEach((itemData) => {
        if (itemData.fields && itemData.fields.length > 0) {
            itemData.fields.forEach((fieldData, fieldIndex) => {
                if (fieldData.field.field_type === 'label') {
                    labelCount += 1;
                }

                // Store the field data and its original index for conditional classes
                const fieldWithMeta = { ...fieldData, fieldIndex };

                if (labelCount > 2) {
                    rightTableFields.push(fieldWithMeta);
                } else {
                    leftTableFields.push(fieldWithMeta);
                }
            });
        }
    });
    return (
        <>
            <Header />
            <center>
                <div
                    className="text-dark position-relative mt-3 mb-12 text-center"
                    style={{ width: '700px' }}
                >
                    <center>
                        <table
                            style={{
                                width: '700px',
                            }}
                        >
                            <tbody>
                                <tr>
                                    <td
                                        className="text-center"
                                        style={{ position: 'relative' }}
                                        colSpan={3}
                                    >
                                        <span
                                            style={{
                                                fontSize: '20px',
                                                color: '#000',
                                                padding: 0,
                                                fontWeight: 'bold',
                                            }}
                                            className="fw-bolder"
                                        >
                                            {item.name}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <HeaderDetails />
                        <table
                            style={{
                                width: '350px',
                                fontSize: '15px',
                            }}
                            className="fw-semibold mt-4"
                            align="left"
                        >
                            <tbody>
                                {leftTableFields.map((fieldData, index) => (
                                    <TableRow
                                        key={`left-${index}`}
                                        fieldData={fieldData}
                                        fieldIndex={fieldData.fieldIndex}
                                    />
                                ))}
                            </tbody>
                        </table>
                        <table
                            style={{
                                width: '350px',
                                fontSize: '15px',
                            }}
                            className="fw-semibold mt-4"
                        >
                            <tbody>
                                {rightTableFields.map((fieldData, index) => (
                                    <TableRow
                                        key={`right-${index}`}
                                        fieldData={fieldData}
                                        fieldIndex={fieldData.fieldIndex}
                                    />
                                ))}
                            </tbody>
                        </table>
                        <div style={{ width: '700px', textAlign: 'left' }} className="mt-2">
                            <div className="d-flex">
                                <div className="fw-bolder">Remarks</div>
                                <div className="fw-bolder ms-2 text-center">
                                    {remarksTest[item.test_id] ?? <>&nbsp;</>}
                                    <hr
                                        className="border-dark"
                                        style={{
                                            width: '500px',
                                            margin: '0',
                                        }}
                                    />
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </center>
            <Footer />
        </>
    );
};

const TableRow = ({ fieldData, fieldIndex }) => (
    <tr>
        <td
            className={`fw-bolder ${
                fieldData.field.field_type === 'label' ? 'text-underline' : ''
            }`}
        >
            {fieldData.field.name}
        </td>
        <td className="text-center">
            {fieldData.field.field_type !== 'label' && (
                <>
                    {fieldData.value ?? <>&nbsp;</>}
                    <hr className="border-dark" style={{ width: '150px', margin: '0' }} />
                </>
            )}
        </td>
    </tr>
);

export default LaboratoryUri;
