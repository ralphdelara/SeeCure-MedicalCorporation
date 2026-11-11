import { usePage } from '@inertiajs/react';

const LaboratoryHeader = () => {
    const { patient, laboratory } = usePage().props as unknown as {
        laboratory: {
            date_requested: string;
            date_performed: string;
            visit: {
                consultation: {
                    doctor: {
                        physician_last_name: string;
                    }
                }
            };
        };
        patient: {
            full_name: string;
            age_year: string;
            gender: {
                name: 'string';
            };
            civil_status: {
                name: 'string';
            };
            full_address: string;
        };
    };
    return (
        <>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '170px',
                marginLeft: '145px',
                fontSize: '19px',
                width: '358px',
                textAlign: 'center'
            }}>
                <b>{patient?.full_name.toUpperCase() ?? 'WALK-IN PATIENT'}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '193px',
                marginLeft: '145px',
                fontSize: '19px',
                width: '50px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{patient?.age_year?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '193px',
                marginLeft: '239px',
                fontSize: '19px',
                width: '75px',
                textAlign: 'center'
            }}>
                <b>{patient?.gender?.name.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '193px',
                marginLeft: '379px',
                fontSize: '19px',
                width: '123px',
                textAlign: 'center',
                whiteSpace: 'nowrap'
            }}>
                <b>{patient?.civil_status?.name.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '215px',
                marginLeft: '145px',
                fontSize: '19px',
                width: '358px',
                textAlign: 'center',
                whiteSpace: 'nowrap'
            }}>
                <b>{patient?.full_address?.toUpperCase() ?? ''}</b>
            </span>

            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '170px',
                marginLeft: '718px',
                fontSize: '19px',
                width: '208px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{laboratory?.date_requested.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '193px',
                marginLeft: '718px',
                fontSize: '19px',
                width: '208px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{laboratory?.date_performed?.toUpperCase() ?? ''}</b>
            </span>
            <span style={{
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0,
                marginTop: '215px',
                marginLeft: '718px',
                fontSize: '19px',
                width: '208px',
                textAlign: 'center',
                whiteSpace: 'nowrap',
            }}>
                <b>{laboratory?.visit.consultation?.doctor?.physician_last_name.toUpperCase() ?? ''}</b>
            </span>
        </>
    );
};

export default LaboratoryHeader;
