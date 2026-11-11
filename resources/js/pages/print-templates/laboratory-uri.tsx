import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import urinalisysBg from '@/assets/images/print-templates/urinalysis.png';

const LaboratoryUri = ({ item, index }: {item: {data: any[]}, index: number}) => {
    const { leftFullName, leftLicNo, remarksTest } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksTest: string;
        };
    let incrementMarginTopFirst = 21;
    let marginTopFirst = 262;
    let marginLeftFirst = 178;
    let widthFirst = 226;
    let marginTop = marginTopFirst;
    let marginLeft = marginLeftFirst;
    let width = widthFirst;
    let incrementMarginTop = incrementMarginTopFirst;

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={urinalisysBg} />
            <LaboratoryHeader />
            {item.data[0].fields.map((uriItem, uriIndex) => {
                if (uriItem.field.field_type === 'label') {
                    if (uriItem.field.id === 46) { // CHEMICAL PROPERTIES
                        marginTop += 66;
                        incrementMarginTop = incrementMarginTopFirst + 1;
                    }
                    if (uriItem.field.id === 50) { // MICROSCOPIC FINDINGS
                        marginTop = marginTopFirst;
                        marginLeft += 507;
                        incrementMarginTop = incrementMarginTopFirst;
                    }

                    return;
                }

                if (uriItem.field.id === 54) { //Cast
                    marginTop += 43;
                } else if (uriItem.field.id === 55) { // Amourphous Urate/Phosphate
                    marginTop += 43;
                    incrementMarginTop += 2;
                    marginLeft += 120;
                    width = 160;
                } else {
                    marginTop += incrementMarginTop;
                }


                return (
                    <span key={'uri-' + uriIndex} style={{
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
                        <b style={{ color: uriItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>{uriItem.value?.toUpperCase()}</b>
                    </span>
                )
            })}

            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '138px',
                marginLeft: '123px',
                fontSize: '19px',
                width: '280px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{remarksTest[18]?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '54px',
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
                fontSize: '16px',
                width: '430px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                PRC LICENSE NO. {leftLicNo}
            </span>
        </div>
    );
};

export default LaboratoryUri;
