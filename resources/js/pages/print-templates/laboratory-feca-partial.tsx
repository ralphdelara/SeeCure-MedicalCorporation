import { usePage } from '@inertiajs/react';
import '@/assets/css/print-laboratory.css';
import LaboratoryHeader from './laboratory-header';
import fecalysisPartialBg from '@/assets/images/print-templates/fecalysis_partial.png';
import { Fragment } from 'react';

const LaboratoryFecaPartial = ({ item, index }: { item: { data: any[] }, index: number }) => {
    const { leftFullName, leftLicNo, remarksTest } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksTest: string;
        };
    let incrementMarginTopFirst = 21;
    let marginTopFirst = 282;
    let marginLeftFirst = 178;
    let widthFirst = 156;
    let marginTop = marginTopFirst;
    let marginLeft = marginLeftFirst;
    let width = widthFirst;
    let incrementMarginTop = incrementMarginTopFirst;

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={fecalysisPartialBg} />
            <LaboratoryHeader />
            {item.data[0].fields.map((fecaItem, fecaIndex) => {
                marginTop += incrementMarginTop;

                return (
                    <Fragment key={'feca-' + fecaIndex}>
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
                            <b>{fecaItem.field?.name.toUpperCase()}</b>
                        </span>

                        <span style={{
                            position: 'absolute',
                            zIndex: 1,
                            top: 0,
                            left: 0,
                            marginTop: (marginTop + 5) + 'px',
                            marginLeft: '350px',
                            fontSize: '19px',
                            width: '340px',
                            textAlign: 'center',
                            whiteSpace: 'nowrap',
                            lineHeight: 0.9,
                        }}>
                            <b style={{ color: fecaItem.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>
                                {fecaItem.value?.toUpperCase() ?? <>&nbsp;</>}
                            </b>
                        </span>
                    </Fragment>
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

export default LaboratoryFecaPartial;
