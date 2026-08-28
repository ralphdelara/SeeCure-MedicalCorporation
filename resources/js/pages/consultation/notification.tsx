import { useEffect, useRef } from 'react';
import { echo } from '@/components/echo';
import { usePage } from '@inertiajs/react';
import toast, { Toaster } from 'react-hot-toast';
import notificationSound from '@/assets/sounds/notification.mp3';
import { IconBellRinging, IconX } from '@tabler/icons-react';

interface User {
    id: string;
}

const Notification = () => {
    const { auth } = usePage().props as unknown as {
        auth: { user: User };
    };
    const { user } = auth;

    const dismissNotification = (id: string) => {
        toast.dismiss(id);
    };

    const playSound = async () => {
        const audio = new Audio(notificationSound);
        try {
            audio?.play();
        } catch (e) {
            if (e instanceof Error) {
                console.error(e.message);
                console.error(e.stack);
            } else {
                console.error('An unexpected error occurred:', e);
            }
        }
    };

    const showNotifications = (name: string, message: string) => {
        toast.custom((t) => (
            <div className={'d-flex align-items-center' + (!t.visible ? ' d-none' : '')}>
                <div style={{ width: '40px' }}>
                    <IconBellRinging className="text-success" />
                </div>
                <div className="ms-3">
                    <h6 className="fs-4 fw-semibold mb-0">{name}</h6>
                    <span className="fw-normal">{message}</span>
                </div>
            </div>
        ));
    };

    useEffect(() => {
        // Listening to your Laravel Echo channel
        echo.channel('consultation-' + auth.user.id).listen(
            'NotifyDoctor',
            (e: { name: string; message: string; count: number; doctorId: string }) => {
                // Fire the audio sound effect
                playSound();

                // Trigger the reactive notification toast to match the sound
                showNotifications(e.name, e.message);
            },
        );

        return () => {
            echo.leaveChannel('consultation-' + auth.user.id);
        };
    }, []);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
        </>
    );
};

export default Notification;
