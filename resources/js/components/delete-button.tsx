import { IconTrash } from '@tabler/icons-react';
import ConfirmButton from './confirm-button';

interface DeleteProps {
    url: string;
    msg: string;
    className?: string;
}

export default function DeleteButton({ url, msg, className = '' }: DeleteProps) {
    return (
        <ConfirmButton
            requestMethod="DELETE"
            url={url}
            msg={'All data linked to this ' + msg + ' will be deleted!'}
            className={className}
            variant="danger"
            title="Delete"
            successTitle="Deleted!"
            successMsg="The record has been deleted."
            successUrl={window.location.pathname + window.location.search}
            rounded={true}
        >
            <i>
                <IconTrash size={20} />
            </i>
        </ConfirmButton>
    );
}
