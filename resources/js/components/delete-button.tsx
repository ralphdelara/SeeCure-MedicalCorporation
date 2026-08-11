import { router } from '@inertiajs/react';
import { IconTrash } from '@tabler/icons-react';
import Swal from 'sweetalert2';
import { Button } from './ui/button';

interface DeleteProps {
    url: string;
    msg: string;
}

export default function DeleteButton({ url, msg }: DeleteProps) {
    const handleDelete = () => {
        Swal.fire({
            position: 'top',
            title: 'Are you sure?',
            html: 'All data linked to this ' + msg + ' will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#d33',
            showLoaderOnConfirm: true,

            preConfirm: async () => {
                try {
                    // Replace this with your actual API call (e.g., axios.delete or fetch)
                    const response = await fetch(url, {
                        method: 'DELETE',
                    });

                    if (!response.ok) {
                        throw new Error('Something went wrong');
                    }

                    return;
                } catch (error: any) {
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The record has been deleted.',
                    icon: 'success',
                });

                setTimeout(() => {
                    Swal.close();
                    router.get(window.location.pathname + window.location.search);
                }, 1000);
            }
        });
    };

    return (
        <Button
            variant="danger"
            rounded={true}
            className="ms-2"
            onClick={handleDelete}
            title="Delete"
        >
            <i>
                <IconTrash size={20} />
            </i>
        </Button>
    );
}
