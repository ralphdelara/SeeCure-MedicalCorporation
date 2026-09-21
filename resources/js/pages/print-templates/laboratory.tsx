import { useEffect } from 'react';
import Footer from './laboratory-footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { formatMoney, getNormalRange } from '@/lib/utils';
import Header from './header';
import { Item } from '@radix-ui/react-dropdown-menu';
import { Fragment } from 'react';
import HeaderDetails from './laboratory-header';
import LaboratoryDefault from './laboratory-default';
import LaboratoryMultiple from './laboratory-multiple';
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
