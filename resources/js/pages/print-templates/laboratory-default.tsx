import { useEffect } from 'react';
import Footer from './laboratory-footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { formatMoney, getNormalRange } from '@/lib/utils';
import Header from './header';
import { Item } from '@radix-ui/react-dropdown-menu';
import { Fragment } from 'react';
import HeaderDetails from './laboratory-header';

const LaboratoryDefault = ({ item, index }) => {
    const { printData, patient, remarksType } = usePage().props as unknown as {
        printTitle: string;
        printData: {
            name: string;
            cost_price: string;
            quantity: string;
        }[];
    };

    return (
        <>
            <Header />
            <div className="text-dark mt-3 mb-13 text-center">
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
                            width: '700px',
                            fontSize: '15px',
                        }}
                        className="fw-semibold mt-4"
                    >
                        <thead>
                            <tr>
                                <th className="fw-bolder text-left">TEST</th>
                                <th className="fw-bolder text-center">RESULT</th>
                                <th>
                                    <div className="fw-bolder text-right">NORMAL VALUES</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {item.data.map((itemData, indexData) => (
                                <Fragment key={'fragment-' + indexData + '-' + index}>
                                    {itemData.fields.map((fieldData, fieldIndex) => (
                                        <tr
                                            key={
                                                'default-tr-' +
                                                fieldIndex +
                                                '-' +
                                                indexData +
                                                '-' +
                                                index
                                            }
                                        >
                                            <td>
                                                {fieldData.field.name === 'Result'
                                                    ? itemData.test.name
                                                    : fieldData.field.name}
                                            </td>
                                            <td
                                                className="text-center"
                                                style={{
                                                    width: '100px',
                                                    height: '30px',
                                                }}
                                            >
                                                {fieldData.value ?? <>&nbsp;</>}
                                                <hr
                                                    className="border-dark"
                                                    style={{
                                                        width: '200px',
                                                        margin: '0',
                                                    }}
                                                />
                                            </td>
                                            <td className="text-right">
                                                {getNormalRange(
                                                    fieldData.field,
                                                    patient?.gender_id ?? 0,
                                                )}
                                            </td>
                                        </tr>
                                    ))}
                                </Fragment>
                            ))}
                        </tbody>
                    </table>
                    <div style={{ width: '700px', textAlign: 'left' }} className="mt-2">
                        <div className="d-flex">
                            <div className="fw-bolder">Remarks</div>
                            <div className="fw-bolder ms-2 text-center">
                                {remarksType[item.type_id] ?? <>&nbsp;</>}
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
            <Footer />
        </>
    );
};

export default LaboratoryDefault;
