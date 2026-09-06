import { IconPlus } from '@tabler/icons-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import AddOrUpdateModal from '../add-or-update-inventory-modal';

const AddInventory = () => {
    const [showModal, setShowModal] = useState(false);

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} /> Add Inventory
            </Button>
            <AddOrUpdateModal showModal={showModal} setShowModal={setShowModal} />
        </>
    );
};

export default AddInventory;
