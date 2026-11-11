import { usePage } from '@inertiajs/react';
import LaboratoryHeader from './laboratory-header';
import miscellaneousBg from '@/assets/images/print-templates/miscellaneous.png';
import { Fragment } from 'react';

const LaboratoryMisc = ({ item, index }: { item: { data: any[] }, index: number }) => {
    const { leftFullName, leftLicNo, remarksType } =
        usePage().props as unknown as {
            leftFullName: string;
            leftLicNo: string;
            remarksType: string;
        };
    let incrementMarginTopFirst = 21;
    let marginTopFirst = 275;
    let marginTop = marginTopFirst;
    let incrementMarginTop = incrementMarginTopFirst;

    return (
        <div style={{ position: 'relative', width: '1000px' }}>
            <img src={miscellaneousBg} />
            <LaboratoryHeader />
            {item.data.map((miscItem, miscIndex) => (
                <Fragment key={'misc-' + miscIndex}>
                    {miscItem.fields.map((miscItemField, miscItemFieldIndex) => {
                        marginTop += incrementMarginTop;

                        return (
                            <Fragment key={'misc-' + miscIndex + '-' + miscItemFieldIndex}>
                                <span style={{
                                    position: 'absolute',
                                    zIndex: 1,
                                    top: 0,
                                    left: 0,
                                    marginTop: marginTop + 'px',
                                    marginLeft: '80px',
                                    fontSize: '19px',
                                    width: '200px',
                                    textAlign: 'center',
                                    whiteSpace: 'nowrap',
                                }}>
                                    <b style={{ color: miscItemField.field?.name.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>{miscItemField.field?.name.toUpperCase()}</b>
                                </span>
                                <span key={'misc-' + miscIndex + '-' + miscItemFieldIndex} style={{
                                    position: 'absolute',
                                    zIndex: 1,
                                    top: 0,
                                    left: 0,
                                    marginTop: marginTop + 'px',
                                    marginLeft: '420px',
                                    fontSize: '19px',
                                    width: '500px',
                                    textAlign: 'center',
                                    whiteSpace: 'nowrap',
                                    borderBottom: 'solid 1px #000',
                                    padding: 0,
                                    marginBottom: 0,
                                    lineHeight: 0.9,
                                }}>
                                    <b style={{ color: miscItemField.value?.toUpperCase() === 'POSITIVE' ? '#ff0000' : '' }}>
                                        {miscItemField.value?.toUpperCase() ?? <>&nbsp;</>}
                                    </b>
                                </span>
                            </Fragment>
                        )
                    })}
                </Fragment>
            ))}

            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '117px',
                marginLeft: '144px',
                fontSize: '19px',
                width: '488px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{remarksType[3]?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                bottom: 0,
                left: 0,
                marginBottom: '54px',
                marginLeft: '57px',
                fontSize: '19px',
                width: '347px',
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
                fontSize: '15px',
                width: '345px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                PRC LICENSE NO. {leftLicNo}
            </span>
        </div>
    );
};

export default LaboratoryMisc;
