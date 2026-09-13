import { Head, useForm, usePage } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';
import { toast, Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import NewInventoryForm from '@/components/inventory/new-inventory-form';
import { AddOrUpdateInventoryDetailsFormProps } from '@/components/inventory/new-inventory';
import { addOrUpdateInventory } from '@/actions/App/Http/Controllers/InventoryController';
import { InventoryDetailsTabProps } from '@/components/inventory/inventory-details';

const Details = ({ showTab }: { showTab: boolean }) => {
    const { inventoryDetails } = usePage().props as unknown as InventoryDetailsTabProps;
    const { data, setData, post, processing, errors, reset } = useForm<AddOrUpdateInventoryDetailsFormProps>({
        id: inventoryDetails?.id ?? 0,
        name: inventoryDetails.name,
        inventory_category_id: inventoryDetails.inventory_category_id ?? '',
        inventory_unit_id: inventoryDetails.inventory_unit_id ?? '',
        stock: inventoryDetails.stock ?? 0,
        cost_price: inventoryDetails.cost_price ?? 0,
        selling_price_vat_exclusive: inventoryDetails.selling_price_vat_exclusive ?? 0,
        selling_price_vat_inclusive: inventoryDetails.selling_price_vat_inclusive ?? 0,
        markup_amount: inventoryDetails.markup_amount ?? 0,
        markup_percent: inventoryDetails.markup_percent ?? 0,
        vat_percent: inventoryDetails.vat_percent ?? 0,
        vat_amount: inventoryDetails.vat_amount ?? 0,
        photo: inventoryDetails.photo ?? '',
    });

    const saveDetails = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateInventory().url, {
            onSuccess: () => {
                toast.success('Inventory has been updated.');
            },
            onError: () => {
                toast.error('Failed to update inventory.');
            },
        });
    }

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <form onSubmit={saveDetails}>
                                <div className="row w-100">
                                    <div className="mt-2 text-right">
                                        <Button size="lg">
                                            <i>
                                                <IconDeviceFloppy className="me-1" />
                                            </i>
                                            Save Details
                                        </Button>
                                    </div>
                                    <div className="col-lg-12">
                                        <h4 className="fw-bolder">Inventory Details</h4>
                                    </div>
                                </div>
                                <div className="row mt-3 w-100">
                                    <NewInventoryForm data={data} setData={setData} errors={errors} />
                                </div>
                                <div className="mt-2 text-right">
                                    <Button size="lg">
                                        <i>
                                            <IconDeviceFloppy className="me-1" />
                                        </i>
                                        Save Details
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Details;
