import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import hematologyPartialBg from '@/assets/images/print-templates/hematology_partial.png';
import { Fragment } from 'react';
import { getNormalRange } from '@/lib/utils';

const LaboratoryHemaPartial = ({ item, index }: { item: { data: any[] }, index: number }) => {
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
            <img src={hematologyPartialBg} />
            <LaboratoryHeader />
            {item.data.map((hemaItem, hemaIndex) => {
                marginTop += 22;

                if (hemaIndex > 0) {
                    if (hemaItem.test_data.test.id === 12) {
                        showOgtt = true;
                    }
                }
                
                if (hemaItem.test_data.test.id === 12 && !showOgtt) {
                    marginTop+= 22;
                }

                return (
                    <Fragment key={'hema-' + hemaIndex}>
                        {hemaItem.test_data.test.id === 12 && !showOgtt && <span style={{
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
                            <b>{hemaItem.test_data.test.name}</b>
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
                            <b>{hemaItem.field?.name.toUpperCase()}</b>
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
                            <b style={{ color: hemaItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>{hemaItem.value?.toUpperCase() ?? <>&nbsp;</>}</b>
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
                            <b>{getNormalRange(hemaItem.field, patient?.gender?.id ?? null)} {hemaItem.field.unit}</b>
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

export default LaboratoryHemaPartial;
