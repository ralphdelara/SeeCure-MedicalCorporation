import { usePage } from '@inertiajs/react';
import '@/assets/css/print-laboratory.css';
import LaboratoryHeader from './laboratory-header';
import fecalysisBg from '@/assets/images/print-templates/fecalysis.png';

const LaboratoryFeca = ({ item, index }: {item: {data: any[]}, index: number}) => {
    const { leftFullName, leftLicNo, remarksTest } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksTest: string;
        };
    let incrementMarginTopFirst = 21;
    let marginTopFirst = 262;
    let marginLeftFirst = 178;
    let widthFirst = 156;
    let marginTop = marginTopFirst;
    let marginLeft = marginLeftFirst;
    let width = widthFirst;
    let incrementMarginTop = incrementMarginTopFirst;

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={fecalysisBg} />
            <LaboratoryHeader />
            {item.data[0].fields.map((fecaItem, fecaIndex) => {
                if (fecaItem.field.field_type === 'label') {
                    if (fecaItem.field.name === 'CHEMICAL') {
                        marginTop += 46;
                    }
                    if (fecaItem.field.name === 'MICROSCOPIC') {
                        marginTop = marginTopFirst;
                        marginLeft += 272;
                        incrementMarginTop = incrementMarginTopFirst;
                    }
                    if (fecaItem.field.name === 'CELLULAR ELEMENTS') {
                        marginTop = marginTopFirst;
                        marginLeft += 342;
                        width -= 31;
                        incrementMarginTop = incrementMarginTopFirst;
                    }
                    return;
                }

                if (fecaItem.field.id === 74) { //Entamoeba histolytica/dispar (Cyst)
                    marginTop += 45;
                } else if (fecaItem.field.id === 76) { //Entamoeba coli (Cyst)
                    marginTop += 45;
                    incrementMarginTop += 2;
                } else {
                    marginTop += incrementMarginTop;
                }


                return (
                    <span key={'feca-' + fecaIndex} style={{
                        position: 'absolute',
                        zIndex: 1,
                        top: 0,
                        left: 0,
                        marginTop: marginTop + 'px',
                        marginLeft: marginLeft + 'px',
                        fontSize: '19px',
                        width: width + 'px',
                        textAlign: 'center',
                        whiteSpace: 'nowrap',
                    }}>
                        <b style={{ color: fecaItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>{fecaItem.value?.toUpperCase()}</b>
                    </span>
                )
            })}

            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '131px',
                marginLeft: '177px',
                fontSize: '19px',
                width: '453px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{remarksTest[19]?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '50px',
                marginLeft: '57px',
                fontSize: '19px',
                width: '395px',
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
                marginBottom: '10px',
                marginLeft: '57px',
                fontSize: '14px',
                width: '395px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                License No. {leftLicNo}
            </span>
        </div>
    );
};

export default LaboratoryFeca;
