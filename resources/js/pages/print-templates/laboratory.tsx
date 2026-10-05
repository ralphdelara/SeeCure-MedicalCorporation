import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { Fragment } from 'react';
import LaboratoryDefault from './laboratory-default';
import LaboratoryUri from './laboratory-uri';
import LaboratoryFeca from './laboratory-feca';
import LaboratoryHema from './laboratory-hema';

const Default = () => {
    const { printData, patient, remarks } = usePage().props as unknown as {
        printTitle: string;
        printData: {
            name: string;
            cost_price: string;
            quantity: string;
        }[];
    };

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <>
            {printData.map((item, index) => (
                <Fragment key={'print-' + index}>
                    {index > 0 && <div className="page-break"></div>}
                    {item.name === 'URINALYSIS' && <LaboratoryUri item={item} index={index} />}
                    {item.name === 'HEMATOLOGY' && <LaboratoryHema item={item} index={index} />}
                    {item.name === 'FECALYSIS' && <LaboratoryFeca item={item} index={index} />}
                    {!['HEMATOLOGY', 'FECALYSIS', 'URINALYSIS'].includes(item.name) && (
                        <LaboratoryDefault item={item} index={index} />
                    )}
                </Fragment>
            ))}
        </>
    );
};

export default Default;
