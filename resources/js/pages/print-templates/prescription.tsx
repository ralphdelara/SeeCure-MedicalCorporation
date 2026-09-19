import { useEffect } from 'react';
import Footer from './footer';
import Header from './header';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';

const Default = () => {
    const { printTitle, prescription } = usePage().props as unknown as {
        printTitle: string;
        prescription: {
            inventory_name: string;
            quantity: string;
            dosage: string;
        }[];
    };

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 500);
    }, []);
    return (
        <>
            <Header />
            <div className="text-dark mt-3 mb-12 text-center">
                <center>
                    <table
                        style={{
                            width: '600px',
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
                                        {printTitle}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table
                        style={{
                            width: '600px',
                            fontSize: '15px',
                        }}
                        className="fw-semibold mt-4"
                    >
                        <tbody>
                            {prescription.map((item, index) => (
                                <tr key={'tr-' + index}>
                                    <td width="50%" className="mt-2" valign="top">
                                        {item.inventory_name}
                                    </td>
                                    <td
                                        width="5%"
                                        className="mt-2 ps-2 text-right text-nowrap"
                                        valign="top"
                                    >
                                        x {item.quantity}
                                    </td>
                                    <td width="45%" className="mt-2 ps-2" valign="top">
                                        {item.dosage}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </center>
            </div>
            <Footer />
        </>
    );
};

export default Default;
