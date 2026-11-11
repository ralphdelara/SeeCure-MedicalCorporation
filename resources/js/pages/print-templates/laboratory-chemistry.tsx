import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import bloodChemistryBg from '@/assets/images/print-templates/blood_chemistry.png';
import { Fragment } from 'react';
import { getHighOrLowNormalRange, getNormalRange } from '@/lib/utils';

const LaboratoryChem = ({ item, index }: { item: { data: any[] }, index: number }) => {
    const { patient, leftFullName, leftLicNo, remarksType } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksType: string;
            patient: {gender: {id: number}};
        };
    let marginTopArr = {
        1: 290,
        3: 312,
        4: 334,
        5: 380,
        6: 426,
        7: 470,
        9: 550,
        10: 609,
        11: 631,
        12: 674,
        13: 940,
        14: 962,
        15: 984,
        16: 1006,
        17: 1028,
    };

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={bloodChemistryBg} />
            <LaboratoryHeader />
            {item.data.map((chemItem, chemIndex) => {
                let highOrLow = '';

                if (!isNaN(parseFloat(chemItem.value))) {
                    highOrLow = getHighOrLowNormalRange(chemItem?.field, patient?.gender?.id, parseFloat(chemItem.value?.toUpperCase()))
                }

                return (
                    <Fragment key={'chem-' + chemIndex}>
                        <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: marginTopArr[chemItem.field.id as keyof typeof marginTopArr] + 'px',
                            marginLeft: '350px',
                            fontSize: '19px',
                            width: '140px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                        }}>
                            <b style={{ color: chemItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>
                                {chemItem.value?.toUpperCase()}
                            </b>
                            <small style={{ fontSize: '10px', right: 0, marginTop: '5px', color: '#ff0000', position: 'absolute' }}>
                                {highOrLow}
                            </small>
                        </span>
                    </Fragment>
                )
            })}

            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '151px',
                marginLeft: '204px',
                fontSize: '19px',
                width: '488px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{remarksType[1]?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '44px',
                marginLeft: '89px',
                fontSize: '16px',
                width: '327px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{leftFullName}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '7px',
                marginLeft: '89px',
                fontSize: '15px',
                width: '327px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                PRC LICENSE NO. {leftLicNo}
            </span>
        </div>
    );
};

export default LaboratoryChem;
