import { useEffect } from 'react';
import Footer from './laboratory-footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { formatMoney, getNormalRange } from '@/lib/utils';
import Header from './header';
import { Item } from '@radix-ui/react-dropdown-menu';
import { Fragment } from 'react';
import HeaderDetails from './laboratory-header';

const LaboratoryHema = ({ item, index }) => {
    const { printData, patient, remarksType } = usePage().props as unknown as {
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

                if (labelCount > 1) {
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
            <center style={{ marginBottom: '100px' }}>
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
                                width: '320px',
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
                                <tr>
                                    <td colSpan={2}>
                                        Remarks
                                        <br />
                                        {remarksType[item.type_id] ?? <>&nbsp;</>}
                                        <hr
                                            className="border-dark"
                                            style={{
                                                width: '100%',
                                                margin: '0',
                                            }}
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>&nbsp;
                    </center>
                </div>
            </center>
            <Footer />
        </>
    );
};

const TableRow = ({ fieldData, fieldIndex }) => {
    const { patient } = usePage().props as unknown as {
        patient: { gender: { id: number } };
    };
    return (
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
                    <div style={{ position: 'relative' }}>
                        {fieldData.value ?? <>&nbsp;</>}
                        <small style={{ fontSize: '10px' }}>{fieldData.field.unit ?? ''}</small>
                        {getNormalRange(fieldData.field, patient.gender.id) !== '' && (
                            <small
                                style={{
                                    fontSize: '8px',
                                    position: 'absolute',
                                    marginTop: '8px',
                                    right: '0',
                                    whiteSpace: 'pre-line',
                                    lineHeight: '0.9',
                                }}
                            >
                                (N:{' '}
                                {getNormalRange(fieldData.field, patient.gender.id).replace(
                                    ' - ',
                                    ' - \n',
                                )}
                                )
                            </small>
                        )}
                        <hr
                            className="border-dark"
                            style={{ width: '100%', margin: '0', position: 'absolute' }}
                        />
                    </div>
                )}
            </td>
        </tr>
    );
};

export default LaboratoryHema;
