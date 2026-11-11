import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import clinicalChemistryPartialBg from '@/assets/images/print-templates/clinical_chemistry_partial.png';
import { Fragment } from 'react';
import { getNormalRange } from '@/lib/utils';

const LaboratoryChemPartial = ({ item, index }: { item: { data: any[] }, index: number }) => {
    const { patient, leftFullName, leftLicNo, remarksType } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksType: string;
        };
    let marginTopFirst = 268;
    let marginTop = marginTopFirst;
    let showOgtt = false;

    console.log(item);

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={clinicalChemistryPartialBg} />
            <LaboratoryHeader />
            {item.data.map((chemItem, chemIndex) => {
                marginTop += 22;

                if (chemIndex > 0) {
                    if (chemItem.test_data.test.id === 12) {
                        showOgtt = true;
                    }
                }
                
                if (chemItem.test_data.test.id === 12 && !showOgtt) {
                    marginTop+= 22;
                }

                return (
                    <Fragment key={'chem-' + chemIndex}>
                        {chemItem.test_data.test.id === 12 && !showOgtt && <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: (marginTop - 22) + 'px',
                            marginLeft: '100px',
                            fontSize: '19px',
                            width: '140px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                        }}>
                            <b>{chemItem.test_data.test.name}</b>
                        </span>}
                        <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: marginTop + 'px',
                            marginLeft: '100px',
                            fontSize: '19px',
                            width: '140px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                        }}>
                            <b>{chemItem.field?.name.toUpperCase()}</b>
                        </span>

                        <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: (marginTop + 5) + 'px',
                            marginLeft: '350px',
                            fontSize: '19px',
                            width: '140px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                            borderBottom: 'solid 1px #000',
                            lineHeight: 0.9,
                        }}>
                            <b style={{ color: chemItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>{chemItem.value?.toUpperCase() ?? <>&nbsp;</>}</b>
                        </span>
                        
                        <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: marginTop + 'px',
                            marginLeft: '600px',
                            fontSize: '19px',
                            width: '200px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                        }}>
                            <b>{getNormalRange(chemItem.field, patient?.gender?.id ?? null)} {chemItem.field.unit}</b>
                        </span>
                    </Fragment>
                )
            })}

            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '148px',
                marginLeft: '178px',
                fontSize: '19px',
                width: '333px',
                textAlign: 'center',
            }}>
                <b>{remarksType[1]?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '55px',
                marginLeft: '56px',
                fontSize: '18px',
                width: '433px',
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
                marginBottom: '9px',
                marginLeft: '56px',
                fontSize: '15px',
                width: '433px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                PRC LICENSE NO. {leftLicNo}
            </span>
        </div>
    );
};

export default LaboratoryChemPartial;
