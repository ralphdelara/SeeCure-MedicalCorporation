import { useEffect } from 'react';
import Footer from './footer';
import Header from './header';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';

const Default = () => {
    const { printTitle } = usePage().props as unknown as {
        printTitle: string;
    };

    useEffect(() => {
        document.body.style.margin = '0';
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <>
            <Header />
            <div className="mt-3 text-center">
                <center>
                    <table>
                        <tr>
                            <td className="text-center" style={{ position: 'relative' }}>
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
                    </table>
                </center>
            </div>
            <Footer />
        </>
    );
};

export default Default;
