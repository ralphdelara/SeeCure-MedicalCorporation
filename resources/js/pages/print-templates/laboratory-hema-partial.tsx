import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import hematologyPartialBg from '@/assets/images/print-templates/hematology_partial.png';
import { Fragment } from 'react';
import { getHighOrLowNormalRange, getNormalRange } from '@/lib/utils';

const LaboratoryHemaPartial = ({ item, index }: { item: { data: any[] }, index: number }) => {
    const { patient, leftFullName, leftLicNo, remarksType } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksType: string;
            patient: { gender: { id: number } };
        };
    let marginTopFirst = 268;
    let marginTop = marginTopFirst;
    let showOgtt = false;

    let bleedingVal = '';
    let totalBleedingTime = 0;
    let clottingVal = '';
    let totalClottingTime = 0;

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
                    marginTop += 22;
                }

                let highOrLow = '';

                if (!isNaN(parseFloat(hemaItem.value))) {
                    highOrLow = getHighOrLowNormalRange(hemaItem?.field, patient?.gender?.id, parseFloat(hemaItem.value?.toUpperCase()))
                }

                if ([28, 29].includes(hemaItem.field.id)) {
                    //Bleeding Time
                    bleedingVal += hemaItem.value;

                    let bleedTimeValue = !isNaN(parseFloat(hemaItem.value)) ? parseFloat(hemaItem.value) : 0;
                    if (hemaItem.field.id === 28) {
                        totalBleedingTime += bleedTimeValue;
                        highOrLow = '';
                    }
                    if (hemaItem.field.id === 29) {
                        totalBleedingTime += (bleedTimeValue / 60);
                        if (bleedingVal !== '') {
                            highOrLow = getHighOrLowNormalRange(hemaItem?.field, patient?.gender?.id, totalBleedingTime)
                        }
                    }
                }

                if ([30, 31].includes(hemaItem.field.id)) {
                    //Clotting Time
                    clottingVal += hemaItem.value;

                    let clottTimeValue = !isNaN(parseFloat(hemaItem.value)) ? parseFloat(hemaItem.value) : 0;
                    if (hemaItem.field.id === 30) {
                        totalClottingTime += clottTimeValue;
                        highOrLow = '';
                    }
                    if (hemaItem.field.id === 31) {
                        totalClottingTime += (clottTimeValue / 60);
                        if (clottingVal !== '') {
                            highOrLow = getHighOrLowNormalRange(hemaItem?.field, patient?.gender?.id, totalClottingTime)
                        }
                    }
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
                            <small style={{ fontSize: '10px', right: 0, marginTop: '5px', color: '#ff0000', position: 'absolute' }}>
                                {highOrLow}
                            </small>
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
