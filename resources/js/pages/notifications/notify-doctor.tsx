import { useEffect, useRef } from 'react';
import { echo } from '@/components/echo';
import { router, usePage } from '@inertiajs/react';
import toast, { Toaster } from 'react-hot-toast';
import notificationSound from '@/assets/sounds/notification.mp3';
import { IconBellRinging } from '@tabler/icons-react';
import { consultationList } from '@/routes';

interface User {
    id: string;
}

const NotifyDoctor = () => {
    const { auth } = usePage().props as unknown as {
        auth: { user: User };
    };
    const { url } = usePage();

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
            <div
                className={`d-flex toast show align-items-center text-dark rounded-3 border-0 bg-white p-2 shadow-lg ${t.visible ? 'opacity-100' : 'opacity-0'}`}
            >
                <div style={{ width: '40px' }}>
                    <IconBellRinging />
                </div>
                <div className="ms-3">
                    <h6 className="fs-4 fw-semibold mb-0">{name}</h6>
                    <span className="fw-normal">{message}</span>
                </div>
                <button
                    type="button"
                    className="btn-close m-auto me-2"
                    aria-label="Close"
                    onClick={() => toast.dismiss(t.id)}
                />
            </div>
        ));
    };

    useEffect(() => {
        // Listening to your Laravel Echo channel
        echo.channel('consultation').listen(
            'NotifyDoctor',
            (e: { name: string; message: string; count: number;}) => {
                // Fire the audio sound effect
                playSound();

                // Trigger the reactive notification toast to match the sound
                showNotifications(e.name, e.message);

                if (url === consultationList().url) {
                    router.get(consultationList().url);
                }
            },
        );

        return () => {
            echo.leaveChannel('consultation');
        };
    }, []);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
        </>
    );
};

export default NotifyDoctor;
