import { IconPlus } from '@tabler/icons-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import NewOrEditModal from '../add-or-update-product-modal';

const AddProduct = () => {
    const [showModal, setShowModal] = useState(false);

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} /> Add Product
            </Button>
            <NewOrEditModal showModal={showModal} setShowModal={setShowModal}/>
        </>
    );
};

export default AddProduct;
