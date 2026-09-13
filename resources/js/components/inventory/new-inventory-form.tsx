import { Input } from '@/components/ui/input';
import { AddOrUpdateInventoryFormProps } from './new-inventory';
import InputError from '../input-error';
import { Button } from '@/components/ui/button';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { usePage } from '@inertiajs/react';

interface InertiaProps {
    inventoryUnitOptions: Options[];
    inventoryCategoryOptions: Options[];
}

const NewInventoryForm = ({ data, setData, errors = {} }: AddOrUpdateInventoryFormProps) => {
    const { inventoryCategoryOptions, inventoryUnitOptions } = usePage()
        .props as unknown as InertiaProps;

    const computeVatAmount = (vat_percent: number | string, sellingPriceValue: any) => {
        let sellingPrice = data.selling_price_vat_exclusive;

        if (sellingPriceValue) {
            sellingPrice = sellingPriceValue;
        }

        const vatAmount = (parseFloat(vat_percent.toString()) / 100) * sellingPrice;

        setData('vat_amount', isNaN(vatAmount) ? 0 : vatAmount.toFixed(2));
        setData('vat_percent', vat_percent);

        const sellingPriceVatIncl = parseFloat(sellingPrice) + vatAmount;
        setData(
            'selling_price_vat_inclusive',
            isNaN(sellingPriceVatIncl) ? 0 : sellingPriceVatIncl.toFixed(2),
        );
    };

    const computeSellingPrice = (value: string | string, fieldType: string) => {
        let sellingPrice = 0;
        const parsedValue = parseFloat(value.toString());

        if (fieldType === 'markup_percent') {
            sellingPrice = data.cost_price * (1 + (isNaN(parsedValue) ? 0 : parsedValue) / 100);
            setData(fieldType, value);
            setData(
                'markup_amount',
                (data.cost_price * ((isNaN(parsedValue) ? 0 : parsedValue) / 100)).toFixed(2),
            );
            setData('selling_price_vat_exclusive', sellingPrice.toFixed(2));
        }

        if (fieldType === 'cost_price') {
            sellingPrice = (isNaN(parsedValue) ? 0 : parsedValue) * (1 + data.markup_percent / 100);
            setData(fieldType, value);
            setData(
                'markup_amount',
                ((isNaN(parsedValue) ? 0 : parsedValue) * (data.markup_percent / 100)).toFixed(2),
            );
            setData('selling_price_vat_exclusive', sellingPrice.toFixed(2));
        }

        computeVatAmount(data.vat_percent, sellingPrice);
    };

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">(*) Mandatory</div>
            <div className="row">
                <div className="col-md-12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="name">
                            Name *
                        </label>

                        <Input
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            id="name"
                            type="text"
                            className="form-control"
                            placeholder="ex. Biogesic"
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.name} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="category">
                            Category *
                        </label>

                        <Select
                            id="category"
                            value={data.inventory_category_id}
                            onChange={(e) =>
                                setData('inventory_category_id', parseInt(e.target.value))
                            }
                            options={inventoryCategoryOptions}
                            type="Category"
                            required={true}
                        />
                        <InputError message={errors.inventory_category_id} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="cost_price">
                            Cost Price *
                        </label>

                        <Input
                            value={data.cost_price}
                            onChange={(e) => computeSellingPrice(e.target.value, 'cost_price')}
                            id="cost_price"
                            type="text"
                            className="form-control"
                            placeholder="ex. 100.00"
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.cost_price} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="vat">
                            VAT (%)*
                        </label>

                        <Input
                            value={data.vat_percent}
                            onChange={(e) => computeVatAmount(e.target.value, null)}
                            id="vat_percent"
                            type="text"
                            className="form-control"
                            placeholder="ex. 12"
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.vat_percent} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="name">
                            Selling Price (VAT Exclusive) *
                        </label>

                        <Input
                            value={data.selling_price_vat_exclusive}
                            id="name"
                            type="text"
                            className="form-control"
                            readOnly={true}
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.selling_price_vat_exclusive} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="unit">
                            Unit *
                        </label>

                        <Select
                            id="unit"
                            value={data.inventory_unit_id}
                            onChange={(e) => setData('inventory_unit_id', parseInt(e.target.value))}
                            options={inventoryUnitOptions}
                            type="Unit"
                            required={true}
                        />
                        <InputError message={errors.inventory_unit_id} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="markup_percent">
                            Mark Up (%) *
                        </label>

                        <Input
                            value={data.markup_percent}
                            onChange={(e) => computeSellingPrice(e.target.value, 'markup_percent')}
                            id="markup_percent"
                            type="text"
                            className="form-control"
                            placeholder="ex. 100.00"
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.markup_percent} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="vat_amount">
                            VAT Amount *
                        </label>

                        <Input
                            value={data.vat_amount}
                            id="vat_amount"
                            type="text"
                            className="form-control"
                            readOnly={true}
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.vat_amount} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="name">
                            Selling Price (VAT Inclusive) *
                        </label>

                        <Input
                            value={data.selling_price_vat_inclusive}
                            id="name"
                            type="text"
                            className="form-control"
                            readOnly={true}
                            maxLength={100}
                            required={true}
                        />
                        <InputError message={errors.selling_price_vat_inclusive} className="mt-2" />
                    </div>
                </div>
            </div>
        </section>
    );
};

export default NewInventoryForm;
