import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import hematologyBg from '@/assets/images/print-templates/hematology.png';
import { Fragment } from 'react';
import { getHighOrLowNormalRange } from '@/lib/utils';

const LaboratoryHema = ({ item, index }: { item: { data: any[] }, index: number }) => {
    const { patient, leftFullName, leftLicNo, remarksType } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksType: string;
            patient: { gender: { id: number } };
        };

    let totalDifferentCount = 0;
    let marginTopArr = {
        21: 270, 22: 292, 23: 314, 24: 336, 25: 358, 26: 380, 34: 291, 35: 313, 36: 335, 37: 357,
        38: 379, 39: 401, 40: 423, 27: 443, 28: 467, 29: 467, 30: 489, 31: 490
    };
    let marginLeftArr = {
        21: 175, 22: 175, 23: 175, 24: 175, 25: 175, 26: 175, 34: 687, 35: 687, 36: 687, 37: 687,
        38: 687, 39: 687, 40: 687, 27: 175, 28: 175, 29: 273, 30: 175, 31: 273
    };
    let widthArr = {
        21: 148, 22: 148, 23: 148, 24: 148, 25: 148, 26: 148, 34: 165, 35: 165, 36: 165, 37: 165,
        38: 165, 39: 165, 40: 165, 27: 148, 28: 64, 29: 50, 30: 64, 31: 50
    };

    let bleedingVal = '';
    let totalBleedingTime = 0;
    let clottingVal = '';
    let totalClottingTime = 0;

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={hematologyBg} />
            <LaboratoryHeader />
            {item.data.map((hemaItem, hemaIndex) => {
                if ([34, 35, 36, 37, 38, 39, 40].includes(hemaItem.field.id)) {
                    if (!isNaN(parseFloat(hemaItem.value))) {
                        totalDifferentCount += parseFloat(hemaItem.value);
                    }
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
                        <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: marginTopArr[hemaItem.field.id as keyof typeof marginTopArr] + 'px',
                            marginLeft: marginLeftArr[hemaItem.field.id as keyof typeof marginLeftArr] + 'px',
                            fontSize: '19px',
                            width: widthArr[hemaItem.field.id as keyof typeof widthArr] + 'px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                            //border: 'solid 1px #000'
                        }}>
                            <b style={{ color: hemaItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>{hemaItem.value?.toUpperCase()}</b>
                            <small style={{ fontSize: '10px', right: 0, marginTop: '5px', color: '#ff0000', position: 'absolute' }}>
                                {highOrLow}
                            </small>
                        </span>
                        {hemaItem.field.id === 40 && <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: (marginTopArr[hemaItem.field.id as keyof typeof marginTopArr] + 21) + 'px',
                            marginLeft: marginLeftArr[hemaItem.field.id as keyof typeof marginLeftArr] + 'px',
                            fontSize: '19px',
                            width: widthArr[hemaItem.field.id as keyof typeof widthArr] + 'px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                            //border: 'solid 1px #000'
                        }}>
                            <b>{totalDifferentCount > 0 ? totalDifferentCount : ''}</b>
                        </span>}
                    </Fragment>
                )
            })}

            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '143px',
                marginLeft: '110px',
                fontSize: '19px',
                width: '377px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{remarksType[4]?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '56px',
                marginLeft: '45px',
                fontSize: '19px',
                width: '356px',
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
                marginBottom: '12px',
                marginLeft: '45px',
                fontSize: '16px',
                width: '356px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                PRC LICENSE NO. {leftLicNo}
            </span>
        </div>
    );
};

export default LaboratoryHema;
