import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { toast, Toaster } from 'react-hot-toast';
import { getSmallProductList } from '@/actions/App/Http/Controllers/PharmacyController';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { IconPlus } from '@tabler/icons-react';
import TableList from '@/components/table';
import { fetchUrl, formSubmitResponse } from '@/lib/utils';
import { addOrUpdatePrescription } from '@/actions/App/Http/Controllers/ConsultationController';

interface PageProps {
    consultationDetails: {
        id: string;
    };
    productCategories: Options[];
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
    product_id: string;
    product_name: string;
    quantity: string;
    dosage: string;
}

interface ProductListProps {
    id: string;
    name: string;
    unit: Options;
    stock: number;
    category: Options;
}

const PrescriptionModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { consultationDetails, productCategories } = usePage().props as unknown as PageProps;
    const [keyword, setKeyword] = useState('');
    const [existingOrOutside, setExistingOrOutside] = useState('existing');
    const [categoryId, setCategoryId] = useState('');
    const [productList, setProductList] = useState<ProductListProps[]>([]);

    const { data, setData, post, processing, errors } = useForm<ModalFormProps>(formData);

    const searchProduct = async (categoryId?: string) => {
        const response = await fetchUrl(getSmallProductList().url, 'GET', {
            keyword: keyword,
            category_id: categoryId ?? '',
        });

        setProductList(response);
    };

    const selectProduct = (id: string, name: string) => {
        setData('product_id', data.product_id === id ? '' : id);
        setData('product_name', data.product_name === name ? '' : name);
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

    const updateProductCategory = (categoryId: string) => {
        setCategoryId(categoryId);
        searchProduct(categoryId);
    };

    const updateForm = (formType: string) => {
        setExistingOrOutside(formType);
        setData('product_id', '');
        setData('product_name', '');
    };

    useEffect(() => {
        searchProduct();
    }, []);

    useEffect(() => {
        setData('id', formData.id);
        setData('product_id', formData.product_id);
        setData('product_name', formData.product_name);
        setData('quantity', formData.quantity);
        setData('dosage', formData.dosage);

        if (formData.product_id === null) {
            setExistingOrOutside('outside');
        } else {
            setExistingOrOutside('existing');
        }
    }, [formData]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} size="lg" onHide={() => setFormShow(false)}>
                <form onSubmit={submitPrescription}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Prescription</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="form-group">(*) Mandatory</div>
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-check form-check-inline ms-2">
                                        <input
                                            className="form-check-input success"
                                            type="checkbox"
                                            id="existingOrOutside-0"
                                            onChange={() => updateForm('existing')}
                                            checked={existingOrOutside === 'existing'}
                                        />
                                        <label
                                            className="form-check-label fs-4"
                                            htmlFor="existingOrOutside-0"
                                        >
                                            Existing Drug
                                        </label>
                                    </div>
                                    <div className="form-check form-check-inline">
                                        <input
                                            className="form-check-input success"
                                            type="checkbox"
                                            id="existingOrOutside-1"
                                            onChange={() => updateForm('outside')}
                                            checked={existingOrOutside === 'outside'}
                                        />
                                        <label
                                            className="form-check-label fs-4"
                                            htmlFor="existingOrOutside-1"
                                        >
                                            Outside Drug
                                        </label>
                                    </div>
                                </div>
                                {existingOrOutside === 'existing' && (
                                    <>
                                        <div className="col-md-12">
                                            <label className="form-label" htmlFor="medicine">
                                                Select Medicine *
                                            </label>
                                            <h5 className='fw-semibold mt-2'>Selected Product: {data.product_name}</h5>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="form-group">
                                                <Input
                                                    value={keyword}
                                                    className="form-control"
                                                    placeholder="Keyword"
                                                    maxLength={100}
                                                    onChange={(e) => setKeyword(e.target.value)}
                                                    onKeyDown={(e) => {
                                                        if (e.key === 'Enter') {
                                                            e.preventDefault(); // Prevents the PARENT form from submitting
                                                            searchProduct(); // Calls your fetch logic directly
                                                        }
                                                    }}
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <Select
                                                className="mt-1"
                                                type="Category"
                                                value={categoryId}
                                                onChange={(e) =>
                                                    updateProductCategory(e.target.value)
                                                }
                                                options={productCategories}
                                            />
                                        </div>
                                        <div className="col-md-12">
                                            <TableList
                                                header={[
                                                    {
                                                        name: 'Stock',
                                                        align: 'left',
                                                    },
                                                    { name: 'Product', align: 'left' },
                                                    { name: 'Category', align: 'left' },
                                                ]}
                                                floatScrollbar={false}
                                            >
                                                {productList.map((item, index) => (
                                                    <tr
                                                        onClick={() =>
                                                            selectProduct(item.id, item.name)
                                                        }
                                                        className={
                                                            'cursor-pointer' +
                                                            (item.id === data.product_id
                                                                ? ' border-success border-2'
                                                                : '')
                                                        }
                                                        key={'productList-' + index}
                                                    >
                                                        <td>
                                                            {item.stock}
                                                        </td>
                                                        <td>{item.name}</td>
                                                        <td>{item.category.name}</td>
                                                    </tr>
                                                ))}
                                                {productList.length === 0 && (
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
                                {existingOrOutside === 'outside' && (
                                    <div className="col-md-12">
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="product_name">
                                                Medicine *
                                            </label>

                                            <Input
                                                value={data.product_name}
                                                onChange={(e) =>
                                                    setData('product_name', e.target.value)
                                                }
                                                id="product_name"
                                                type="text"
                                                className="form-control"
                                                placeholder="ex. Biogesic 500mg"
                                                maxLength={100}
                                                required={true}
                                            />
                                            <InputError
                                                message={errors.product_name}
                                                className="mt-2"
                                            />
                                        </div>
                                    </div>
                                )}
                                <div className="col-md-3">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="dosage">
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
                                </div>
                                <div className="col-md-9">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="dosage">
                                            Dosage *
                                        </label>

                                        <Input
                                            value={data.dosage}
                                            onChange={(e) => setData('dosage', e.target.value)}
                                            id="dosage"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 1 tab every 8 hours"
                                            maxLength={100}
                                            required={true}
                                        />
                                        <InputError message={errors.dosage} className="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Prescription
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default PrescriptionModal;
