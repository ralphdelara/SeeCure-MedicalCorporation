import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { useEffect } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { Options } from '@/types/options';
import { formSubmitResponse } from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/PharmacyController';
import TableList from '@/components/table';
import { Button } from '@/components/ui/button';
import { IconPrinter } from '@tabler/icons-react';
import { printPrescription } from '@/actions/App/Http/Controllers/PrintController';

interface InertiaProps {
    pharmacyDetails: {
        id: string;
        consultation_id: string;
        details: {
            id: string;
            prescription: {
                inventory_id: null | string;
                inventory_name: string;
            };
            prescription_quantity: string;
            pharmacy_quantity: string;
            created_by: {
                full_name: string;
            };
            last_modified_by: {
                full_name: string;
            };
            created_at: string;
            updated_at: string;
        }[];
    };
    discountType: Options[];
}

const Details = ({ showTab }: { showTab: boolean }) => {
    const { pharmacyDetails } = usePage().props as unknown as InertiaProps;
    const { data, setData, patch, isDirty, setDefaults } = useForm({
        id: pharmacyDetails.id,
    });
    console.log(pharmacyDetails);

    const header = [
        { name: 'Item', className: 'sticky-left', align: 'left' },
        { name: 'Prescription Qty', align: 'center' },
        { name: 'Pharmacy Qty', align: 'center' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
    ];

    const submitDetails = async (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDetails().url, {
            ...formSubmitResponse('Details'),
        });
    };

    useEffect(() => {
        const initialFields: Record<string, any> = {};
        pharmacyDetails.details.map((item, index) => {
            initialFields[item.id] = {
                prescription_quantity: item.prescription_quantity ?? '',
                pharmacy_quantity: item.pharmacy_quantity ?? '',
            };
        });

        setData({ ...data, ...initialFields });
        setDefaults({ ...data, ...initialFields });
    }, [pharmacyDetails.details]);

    const changePharmacyQty = (detailId: string, field: string, newValue: string) => {
        const initialFields: Record<string, any> = {};
        initialFields[detailId] = {
            prescription_quantity: data[detailId as keyof typeof data].prescription_quantity,
            pharmacy_quantity: newValue,
        };
        setData({ ...data, ...initialFields });
    };

    const triggerPrintPrescription = (consultationId: string) => {
        window.open(printPrescription(consultationId).url);
    };

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form onSubmit={submitDetails}>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={isDirty} />
                        </div>
                        <div className="card border shadow-sm">
                            <div className="card-body">
                                <div className="text-right">
                                    <Button
                                        size="lg"
                                        className="mb-3"
                                        type="button"
                                        onClick={() =>
                                            triggerPrintPrescription(
                                                pharmacyDetails.consultation_id,
                                            )
                                        }
                                    >
                                        <IconPrinter />
                                        Print Prescription
                                    </Button>
                                </div>
                                <div className="row g-3 mb-5 w-100">
                                    <TableList header={header}>
                                        {pharmacyDetails.details.map((item, index) => {
                                            console.log(item);
                                            let prescriptionQtyId = 'prescription-qty-' + item.id;
                                            let pharmacyQtyId = 'pharmacy-quantity-' + item.id;
                                            let allowEdit = true;

                                            if (item.prescription.inventory_id === null) {
                                                allowEdit = false;
                                            }

                                            return (
                                                <tr key={'detail-' + index}>
                                                    <td className="sticky-left">
                                                        <h6
                                                            className="fs-5 fw-semibold text-wrap"
                                                            style={{ width: '300px' }}
                                                        >
                                                            {item.prescription.inventory_name}
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                #
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={prescriptionQtyId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.prescription_quantity ?? ''
                                                                }
                                                                readOnly={true}
                                                                className={
                                                                    'form-control' +
                                                                    (!allowEdit && ' is-invalid')
                                                                }
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                        {!allowEdit && (
                                                            <div className="d-flex invalid-feedback">
                                                                Not Available
                                                            </div>
                                                        )}
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                #
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={pharmacyQtyId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.pharmacy_quantity ?? ''
                                                                }
                                                                onChange={(e) => {
                                                                    allowEdit &&
                                                                        changePharmacyQty(
                                                                            item.id,
                                                                            'pharmacy_quantity',
                                                                            e.target.value,
                                                                        );
                                                                }}
                                                                className={
                                                                    'form-control' +
                                                                    (!allowEdit && ' is-invalid')
                                                                }
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                        {!allowEdit && (
                                                            <div className="d-flex invalid-feedback">
                                                                Not Available
                                                            </div>
                                                        )}
                                                    </td>
                                                    <td>
                                                        <div className="d-flex align-items-start">
                                                            <div>
                                                                <h6 className="fs-4 fw-semibold">
                                                                    {item.created_by.full_name}
                                                                </h6>
                                                                <h6 className="fs-4 fw-normal">
                                                                    {item.created_at}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div className="d-flex align-items-start">
                                                            <div>
                                                                <h6 className="fs-4 fw-semibold">
                                                                    {
                                                                        item.last_modified_by
                                                                            .full_name
                                                                    }
                                                                </h6>
                                                                <h6 className="fs-4 fw-normal">
                                                                    {item.updated_at}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            );
                                        })}
                                    </TableList>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
};

export default Details;
