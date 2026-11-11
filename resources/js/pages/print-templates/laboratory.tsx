import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-laboratory.css';
import { Fragment } from 'react';
import LaboratoryUri from './laboratory-uri';
import LaboratoryFeca from './laboratory-feca';
import LaboratoryHema from './laboratory-hema';
import LaboratoryMisc from './laboratory-miscellaneous';
import LaboratoryChem from './laboratory-chemistry';
import LaboratoryChemOthers from './laboratory-chemistry-others';
import LaboratoryFecaPartial from './laboratory-feca-partial';
import LaboratoryChemPartial from './laboratory-chemistry-partial';
import LaboratoryHemaPartial from './laboratory-hema-partial';

const Default = () => {
    const { printData, patient, remarks } = usePage().props as unknown as {
        printTitle: string;
        printData: {
            name: string;
            cost_price: string;
            quantity: string;
            showPartial?: boolean;
        }[];
    };

    useEffect(() => {
        setTimeout(() => {
            //window.print();
            //window.close();
        }, 1000);
    }, []);

    return (
        <>
            {printData.map((item, index) => (
                <Fragment key={'print-' + index}>
                    {index > 0 && <div className="page-break"></div>}
                    {item.name === 'CLINICAL CHEMISTRY' && item.data.length > 6 && <LaboratoryChem item={item} index={index} />}
                    {item.name === 'CLINICAL CHEMISTRY' && item.data.length <= 6 && <LaboratoryChemPartial item={item} index={index} />}
                    {item.name === 'CLINICAL CHEMISTRY OTHERS' && <LaboratoryChemOthers item={item} index={index} />}
                    {item.name === 'HEMATOLOGY' && !item.showPartial &&  <LaboratoryHema item={item} index={index} />}
                    {item.name === 'HEMATOLOGY' && item.showPartial && <LaboratoryHemaPartial item={item} index={index} />}
                    {item.name === 'FECALYSIS' && <LaboratoryFeca item={item} index={index} />}
                    {item.name === 'FECALYSIS PARTIAL' && <LaboratoryFecaPartial item={item} index={index} />}
                    {item.name === 'URINALYSIS' && <LaboratoryUri item={item} index={index} />}
                    {!['CLINICAL CHEMISTRY', 'CLINICAL CHEMISTRY OTHERS', 'HEMATOLOGY', 'FECALYSIS', 'FECALYSIS PARTIAL',
                        'URINALYSIS'].includes(item.name) && (
                            <LaboratoryMisc item={item} index={index} />
                        )}
                </Fragment>
            ))}
        </>
    );
};

export default Default;
