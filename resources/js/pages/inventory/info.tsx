import { IconUserEdit } from '@tabler/icons-react';
import React from 'react';
import { Link } from '@inertiajs/react';
import { getInventoryDetails } from '@/actions/App/Http/Controllers/InventoryController';
import { InventoryDetailsProps } from '@/components/inventory/inventory-details';
import inventoryDefault from '@/assets/images/inventory/inventory-default.png';

interface InertiaProps {
    inventoryDetails: InventoryDetailsProps;
    children: React.ReactNode;
}

const InventoryInfo = ({ inventoryDetails, children }: InertiaProps) => {
    return (
        <div className="card mt-2">
            <div className="card-body mb-0 p-0">
                <div className="row align-items-center g-3 w-100">
                    <div className="col-lg-3 order-lg-1 order-1">
                        <div>
                            <div className="d-flex align-items-center justify-content-center mb-2">
                                <div className="d-flex align-items-center justify-content-center round-110">
                                    <div className="d-flex align-items-center justify-content-center rounded-circle round-100 overflow-hidden border border-4 border-white">
                                        <img
                                            src={inventoryDefault}
                                            alt="modernize-img"
                                            className="h-100 w-100"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-5 order-lg-2 order-2">
                        <div className="text-dark fs-7 fw-bolder mb-0 text-center">
                            {inventoryDetails.name}
                        </div>
                        <div className="d-flex align-items-center justify-content-around">
                            <div className="p-2 text-center">
                                <i className="ti ti-file-description fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">{inventoryDetails.stock ?? '0'}</h4>
                                <p className="mb-0">Stock</p>
                            </div>
                            <div className="border-end border-success">&nbsp;</div>
                            <div className="p-2 text-center">
                                <i className="ti ti-user-circle fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">
                                    {inventoryDetails.category.name ?? 'N/A'}
                                </h4>
                                <p className="mb-0">Category</p>
                            </div>
                            <div className="border-end border-success">&nbsp;</div>
                            <div className="p-2 text-center">
                                <i className="ti ti-user-check fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">
                                    {inventoryDetails.unit.name ?? 'N/A'}
                                </h4>
                                <p className="mb-0">Unit</p>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-4 order-last">
                        <ul className="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end pe-xxl-4 mx-4 my-3 gap-3">
                            <li>
                                <Link
                                    href={getInventoryDetails(inventoryDetails.id).url}
                                    className="btn btn-success text-nowrap"
                                >
                                    <IconUserEdit className="me-1" />
                                    View Details
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
                {children}
            </div>
        </div>
    );
};

export default InventoryInfo;
