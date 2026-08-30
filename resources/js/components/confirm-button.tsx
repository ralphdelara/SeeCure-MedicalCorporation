import { router, useForm } from '@inertiajs/react';
import Swal from 'sweetalert2';
import { Button } from './ui/button';
import React from 'react';

interface ConfirmProps {
    variant?: string;
    requestMethod: string;
    url: string;
    msg: string;
    className?: string;
    title: string;
    children: React.ReactNode;
    successTitle: string;
    successMsg: string;
    successUrl: string;
    rounded?: boolean;
}

export default function ConfirmButton({
    variant = 'default',
    requestMethod,
    url,
    msg,
    className,
    title,
    children,
    successTitle,
    successMsg,
    successUrl,
    rounded = false,
}: ConfirmProps) {
    const handleConfirm = () => {
        Swal.fire({
            position: 'top',
            title: 'Are you sure?',
            html: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            confirmButtonColor: '#d33',
            showLoaderOnConfirm: true,

            preConfirm: async () => {
                try {
                    // Replace this with your actual API call (e.g., axios.delete or fetch)
                    const response = await fetch(url, {
                        method: requestMethod,
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
                    position: 'top',
                    title: successTitle,
                    text: successMsg,
                    icon: 'success',
                });

                setTimeout(() => {
                    Swal.close();
                    router.get(successUrl);
                }, 1000);
            }
        });
    };

    return (
        <Button variant={variant} rounded={rounded} type="button" className={className} onClick={handleConfirm} title={title}>
            {children}
        </Button>
    );
}
