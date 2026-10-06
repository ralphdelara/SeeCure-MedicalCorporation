import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { toast, Toaster } from 'react-hot-toast';
import { getSmallInventoryList } from '@/actions/App/Http/Controllers/InventoryController';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { IconBox, IconEdit, IconPlus, IconSearch } from '@tabler/icons-react';
import TableList from '@/components/table';
import { fetchUrl, formSubmitResponse } from '@/lib/utils';
import { addOrUpdatePrescription } from '@/actions/App/Http/Controllers/ConsultationController';
import FormHeader from '@/components/ui/form-header';

interface PageProps {
    consultationDetails: {
        id: string;
    };
    inventoryCategories: Options[];
}

interface ModalProps {
    formType: string;
    formData: ModalFormProps;
    formShow: boolean;
    setFormShow: any;
}

export interface ModalFormProps {
    id: string;
    consultation_id: string;
    inventory_id: string;
    inventory_name: string;
    quantity: string;
    sig: string;
}

interface InventoryListProps {
    id: string;
    name: string;
    unit: Options;
    stock: number;
    category: Options;
}

const PrescriptionModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { consultationDetails, inventoryCategories } = usePage().props as unknown as PageProps;
    const [keyword, setKeyword] = useState('');
    const [existingOrOutside, setExistingOrOutside] = useState('existing');
    const [categoryId, setCategoryId] = useState('');
    const [inventoryList, setInventoryList] = useState<InventoryListProps[]>([]);

    const { data, setData, post, processing, errors } = useForm<ModalFormProps>(formData);

    const searchInventory = async (categoryId?: string) => {
        const response = await fetchUrl(getSmallInventoryList().url, 'GET', {
            keyword: keyword,
            category_id: categoryId ?? '',
        });

        setInventoryList(response);
    };

    const selectInventory = (id: string, name: string) => {
        setData('inventory_id', data.inventory_id === id ? '' : id);
        setData('inventory_name', data.inventory_name === name ? '' : name);
    };

    const submitPrescription = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdatePrescription().url, {
            ...formSubmitResponse('Prescription'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    const updateInventoryCategory = (categoryId: string) => {
        setCategoryId(categoryId);
        searchInventory(categoryId);
    };

    const updateForm = (formType: string) => {
        setExistingOrOutside(formType);
        setData('inventory_id', '');
        setData('inventory_name', '');
    };

    useEffect(() => {
        searchInventory();
    }, []);

    useEffect(() => {
        setData('id', formData.id);
        setData('inventory_id', formData.inventory_id);
        setData('inventory_name', formData.inventory_name);
        setData('quantity', formData.quantity);
        setData('sig', formData.sig);

        if (formData.inventory_id === null) {
            setExistingOrOutside('outside');
        } else {
            setExistingOrOutside('existing');
        }
    }, [formData]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal
                show={formShow}
                size={existingOrOutside === 'existing' ? 'xl' : 'lg'}
                onHide={() => setFormShow(false)}
            >
                <form onSubmit={submitPrescription}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Prescription</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="steps clearfix">
                                <ul role="tablist">
                                    <li
                                        role="tab"
                                        onClick={() => updateForm('existing')}
                                        className={
                                            'first w-50' +
                                            (existingOrOutside === 'existing'
                                                ? ' current'
                                                : ' done')
                                        }
                                    >
                                        <a href="#" className="fs-4 fw-bold">
                                            <IconBox className="me-2" />
                                            Existing Drug
                                        </a>
                                    </li>
                                    <li
                                        role="tab"
                                        onClick={() => updateForm('outside')}
                                        className={
                                            'w-50' +
                                            (existingOrOutside === 'outside' ? ' current' : ' done')
                                        }
                                    >
                                        <a href="#" className="fs-4 fw-bold">
                                            <IconBox className="me-2" />
                                            Outside Drug
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div className="row">
                                <div
                                    className={
                                        existingOrOutside === 'existing' ? 'col-md-8' : 'col-md-12'
                                    }
                                >
                                    {existingOrOutside === 'existing' && (
                                        <>
                                            <div className="col-md-12">
                                                <FormHeader>Select Item</FormHeader>
                                                <h5 className="fw-semibold mt-2">
                                                    Selected Item: {data.inventory_name}
                                                </h5>

                                                <div className="input-group d-flex flex-nowrap">
                                                    <Input
                                                        value={keyword}
                                                        className="form-control form-control-lg"
                                                        placeholder="Enter keyword"
                                                        maxLength={100}
                                                        onChange={(e) => setKeyword(e.target.value)}
                                                        onKeyDown={(e) => {
                                                            if (e.key === 'Enter') {
                                                                e.preventDefault(); // Prevents the PARENT form from submitting
                                                                searchInventory(); // Calls your fetch logic directly
                                                            }
                                                        }}
                                                    />
                                                    <Select
                                                        type="Category"
                                                        value={categoryId}
                                                        onChange={(e) =>
                                                            updateInventoryCategory(e.target.value)
                                                        }
                                                        options={inventoryCategories}
                                                    />
                                                    <Button
                                                        variant="default"
                                                        type="button"
                                                        onClick={() => searchInventory()}
                                                        disabled={processing}
                                                    >
                                                        <IconSearch />
                                                    </Button>
                                                </div>
                                            </div>
                                            <div className="col-md-12">
                                                <TableList
                                                    header={[
                                                        {
                                                            name: 'Stock',
                                                            align: 'left',
                                                        },
                                                        { name: 'Inventory', align: 'left' },
                                                        { name: 'Category', align: 'left' },
                                                    ]}
                                                    floatScrollbar={false}
                                                >
                                                    {inventoryList.map((item, index) => (
                                                        <tr
                                                            onClick={() =>
                                                                selectInventory(item.id, item.name)
                                                            }
                                                            className={
                                                                'cursor-pointer' +
                                                                (item.id === data.inventory_id
                                                                    ? ' border-success border-2'
                                                                    : '')
                                                            }
                                                            key={'inventoryList-' + index}
                                                        >
                                                            <td>{item.stock}</td>
                                                            <td>{item.name}</td>
                                                            <td>{item.category.name}</td>
                                                        </tr>
                                                    ))}
                                                    {inventoryList.length === 0 && (
                                                        <tr>
                                                            <td
                                                                colSpan={4}
                                                                className="fs-5 text-danger text-center"
                                                            >
                                                                No records
                                                            </td>
                                                        </tr>
                                                    )}
                                                </TableList>
                                            </div>
                                        </>
                                    )}
                                </div>
                                <div
                                    className={
                                        existingOrOutside === 'existing' ? 'col-md-4' : 'col-md-12'
                                    }
                                >
                                    <FormHeader>Prescription Details</FormHeader>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="inventory_name">
                                            Medicine *
                                        </label>

                                        <Input
                                            value={data.inventory_name}
                                            onChange={(e) =>
                                                setData('inventory_name', e.target.value)
                                            }
                                            id="inventory_name"
                                            type="text"
                                            className="form-control"
                                            placeholder={existingOrOutside === 'existing' ? 'Select Item from the List' : 'ex. Biogesic 500mg'}
                                            maxLength={100}
                                            required={true}
                                            readOnly={existingOrOutside === 'existing'}
                                        />
                                        <InputError
                                            message={errors.inventory_name}
                                            className="mt-2"
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="quantity">
                                            Quantity *
                                        </label>

                                        <Input
                                            value={data.quantity}
                                            onChange={(e) => setData('quantity', e.target.value)}
                                            id="quantity"
                                            type="number"
                                            className="form-control"
                                            placeholder="ex. 24"
                                            maxLength={100}
                                            required={true}
                                        />
                                        <InputError message={errors.quantity} className="mt-2" />
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="sig">
                                            Sig *
                                        </label>

                                        <Input
                                            value={data.sig}
                                            onChange={(e) => setData('sig', e.target.value)}
                                            id="sig"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 1 tab every 8 hours"
                                            maxLength={100}
                                            required={true}
                                        />
                                        <InputError message={errors.sig} className="mt-2" />
                                    </div>
                                    <div className="d-flex justify-content-end mt-3">
                                        <Button
                                            variant="default"
                                            size="lg"
                                            type="submit"
                                            disabled={processing}
                                        >
                                            {formType === 'Add' ? <IconPlus /> : <IconEdit />}{' '}
                                            {formType} Prescription
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default PrescriptionModal;
